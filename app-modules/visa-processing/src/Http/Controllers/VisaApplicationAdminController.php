<?php

namespace Modules\VisaProcessing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\VisaProcessing\Models\VisaApplication;
use Modules\VisaProcessing\Models\VisaProcessing;
use Yajra\DataTables\Facades\DataTables;

class VisaApplicationAdminController extends Controller
{
    /**
     * Display a listing of visa applications.
     */
    public function index()
    {
        return view('visa-processing::admin.visa-applications.index');
    }

    /**
     * Return JSON data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $query = VisaApplication::with(['visaProcessing', 'payment', 'reviewer'])
            ->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('application_status', $request->status);
        }

        // Filter by date range if provided
        if ($request->filled('date_from')) {
            $query->whereDate('submission_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('submission_date', '<=', $request->date_to);
        }

        // Filter by country if provided
        if ($request->filled('country')) {
            $query->whereHas('visaProcessing', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        return DataTables::of($query)
            ->addColumn('action', function ($visaApplication) {
                $actions = '<div class="flex space-x-2">';
                $actions .= '<a href="' . route('visa-processing::admin.visa-applications.show', $visaApplication->id) . '" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View Details">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>';
                $actions .= '<a href="' . route('visa-processing::admin.visa-applications.edit', $visaApplication->id) . '" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit Status">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>';
                $actions .= '</div>';
                return $actions;
            })
            ->editColumn('application_number', function ($visaApplication) {
                return '<span class="font-mono text-sm font-medium">' . $visaApplication->application_number . '</span>';
            })
            ->editColumn('applicant_name', function ($visaApplication) {
                return '<div class="flex flex-col">
                    <span class="font-medium">' . $visaApplication->applicant_name . '</span>
                    <span class="text-sm text-gray-500">' . $visaApplication->email . '</span>
                </div>';
            })
            ->editColumn('visa_processing.country_name', function ($visaApplication) {
                return '<div class="flex items-center space-x-2">
                    <span class="text-lg">' . $visaApplication->visaProcessing->country_flag . '</span>
                    <div class="flex flex-col">
                        <span class="font-medium">' . $visaApplication->visaProcessing->country_name . '</span>
                        <span class="text-sm text-gray-500">' . ucfirst($visaApplication->visaProcessing->visa_type) . ' Visa</span>
                    </div>
                </div>';
            })
            ->editColumn('application_status', function ($visaApplication) {
                return $visaApplication->status_badge;
            })
            ->editColumn('submission_date', function ($visaApplication) {
                return $visaApplication->submission_date ? $visaApplication->submission_date->format('M d, Y H:i') : 'N/A';
            })
            ->editColumn('payment.status', function ($visaApplication) {
                return $visaApplication->payment ? $visaApplication->payment->status_badge : '<span class="text-gray-500">No Payment</span>';
            })
            ->editColumn('documents_count', function ($visaApplication) {
                $uploaded = $visaApplication->uploaded_documents_count;
                $total = $visaApplication->total_documents_count;
                $percentage = $total > 0 ? round(($uploaded / $total) * 100) : 0;
                
                $color = $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600');
                
                return "<span class=\"{$color} font-medium\">{$uploaded}/{$total} ({$percentage}%)</span>";
            })
            ->rawColumns(['action', 'application_number', 'applicant_name', 'visa_processing.country_name', 'application_status', 'payment.status', 'documents_count'])
            ->make(true);
    }

    /**
     * Display the specified visa application.
     */
    public function show(VisaApplication $visaApplication)
    {
        $visaApplication->load(['visaProcessing', 'payment', 'reviewer']);
        
        // Get all document types and check if they're uploaded
        $documentTypes = VisaApplication::getDocumentCollections();
        $documents = [];
        
        foreach ($documentTypes as $type => $label) {
            $media = $visaApplication->getFirstMedia($type);
            $documents[$type] = [
                'label' => $label,
                'uploaded' => !is_null($media),
                'media' => $media,
                'url' => $media ? $media->getUrl() : null,
                'download_url' => $media ? route('visa-processing::admin.visa-applications.download-document', ['visaApplication' => $visaApplication->id, 'type' => $type]) : null,
            ];
        }
        
        return view('visa-processing::admin.visa-applications.show', compact('visaApplication', 'documents'));
    }

    /**
     * Show the form for editing the specified visa application.
     */
    public function edit(VisaApplication $visaApplication)
    {
        $visaApplication->load(['visaProcessing', 'payment']);
        $availableStatuses = VisaApplication::getAvailableStatuses();
        
        return view('visa-processing::admin.visa-applications.edit', compact('visaApplication', 'availableStatuses'));
    }

    /**
     * Update the specified visa application.
     */
    public function update(Request $request, VisaApplication $visaApplication)
    {
        $validator = Validator::make($request->all(), [
            'application_status' => 'required|in:' . implode(',', array_keys(VisaApplication::getAvailableStatuses())),
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $visaApplication->update([
            'application_status' => $request->application_status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Set completion date if status is completed
        if ($request->application_status === 'completed') {
            $visaApplication->update(['completion_date' => now()]);
        }

        return redirect()
            ->route('visa-processing::admin.visa-applications.show', $visaApplication)
            ->with('success', 'Visa application status updated successfully.');
    }

    /**
     * Download document file.
     */
    public function downloadDocument(VisaApplication $visaApplication, $type)
    {
        $documentTypes = array_keys(VisaApplication::getDocumentCollections());
        
        if (!in_array($type, $documentTypes)) {
            abort(404);
        }

        $media = $visaApplication->getFirstMedia($type);
        
        if (!$media) {
            abort(404, 'Document not found');
        }

        return response()->download($media->getPath(), $media->file_name);
    }

    /**
     * Get filter options for DataTables.
     */
    public function getFilterOptions()
    {
        $statuses = VisaApplication::getAvailableStatuses();
        
        $countries = VisaProcessing::published()
            ->select('country')
            ->distinct()
            ->get();

        return response()->json([
            'statuses' => $statuses,
            'countries' => $countries,
        ]);
    }

    /**
     * Bulk update application statuses.
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:visa_applications,id',
            'status' => 'required|in:' . implode(',', array_keys(VisaApplication::getAvailableStatuses())),
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid data provided.'], 422);
        }

        $updated = VisaApplication::whereIn('id', $request->application_ids)
            ->update([
                'application_status' => $request->status,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully updated {$updated} application(s).",
        ]);
    }
}