<?php

namespace Modules\VisaProcessing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\VisaProcessing\Models\VisaProcessing;
use Yajra\DataTables\Facades\DataTables;

class VisaProcessingAdminController extends Controller
{
    /**
     * Display a listing of visa processings.
     */
    public function index()
    {
        return view('visa-processing::admin.index');
    }

    /**
     * Get visa processings data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $query = VisaProcessing::with('user')
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addColumn('id_formatted', function ($visaProcessing) {
                return '<a href="' . route('visa-processing::admin.visa-processings.show', $visaProcessing) . '" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">#' . $visaProcessing->id . '</a>';
            })
            ->addColumn('action', function ($visaProcessing) {
                $actions = '<div class="flex space-x-2">';
                $actions .= '<a href="' . route('visa-processing::admin.visa-processings.show', $visaProcessing) . '" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>';
                $actions .= '<a href="' . route('visa-processing::visa-processings.show', $visaProcessing) . '" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300" title="View in Frontend" target="_blank"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg></a>';
                $actions .= '<a href="' . route('visa-processing::admin.visa-processings.edit', $visaProcessing) . '" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>';
                $actions .= '<button onclick="deleteRecord(' . $visaProcessing->id . ')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>';
                $actions .= '</div>';
                return $actions;
            })
            ->addColumn('country_info', function ($visaProcessing) {
                return '<div class="flex items-center space-x-2">'
                    . '<span class="text-lg">' . $visaProcessing->country_flag . '</span>'
                    . '<span class="font-medium">' . $visaProcessing->country_name . '</span>'
                    . '</div>';
            })
            ->addColumn('visa_type_badge', function ($visaProcessing) {
                $colors = [
                    'tourist' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
                    'business' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                    'student' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
                    'work' => 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100',
                    'medical' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
                ];
                $color = $colors[$visaProcessing->visa_type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' . ucfirst($visaProcessing->visa_type) . '</span>';
            })
            ->addColumn('price_display', function ($visaProcessing) {
                return '<span class="font-semibold text-green-600 dark:text-green-400">' . $visaProcessing->formatted_price . '</span>';
            })
            ->addColumn('status_badge', function ($visaProcessing) {
                return $visaProcessing->status_badge;
            })
            ->addColumn('featured_badge', function ($visaProcessing) {
                if ($visaProcessing->is_featured) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Featured</span>';
                }
                return '';
            })
            ->addColumn('author', function ($visaProcessing) {
                return $visaProcessing->user ? $visaProcessing->user->name : 'N/A';
            })
            ->editColumn('created_at', function ($visaProcessing) {
                return $visaProcessing->created_at->format('M d, Y');
            })
            ->editColumn('published_at', function ($visaProcessing) {
                return $visaProcessing->published_at ? $visaProcessing->published_at->format('M d, Y') : 'Not Published';
            })
            ->rawColumns(['id_formatted', 'action', 'country_info', 'visa_type_badge', 'price_display', 'status_badge', 'featured_badge'])
            ->make(true);
    }

    /**
     * Show the form for creating a new visa processing.
     */
    public function create()
    {
        return view('visa-processing::admin.create');
    }

    /**
     * Store a newly created visa processing in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'english_title' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'title.bn' => 'nullable|string|max:255',
            'content.en' => 'required|string',
            'content.bn' => 'nullable|string',
            'country' => 'required|string|max:100',
            'visa_type' => 'required|string|in:tourist,business,student,work,medical,transit,family,other',
            'visa_fees' => 'required|numeric|min:0',
            'processing_fee' => 'nullable|numeric|min:0',
            'processing_days' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'position' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'estimated_processing_time' => 'nullable|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_title.bn' => 'nullable|string|max:255',
            'meta_description.en' => 'nullable|string|max:500',
            'meta_description.bn' => 'nullable|string|max:500',
            'keywords.en' => 'nullable|string|max:500',
            'keywords.bn' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();
            $data['user_id'] = auth()->id();
            $data['processing_fee'] = $data['processing_fee'] ?? 0;
            $data['position'] = $data['position'] ?? 0;
            $data['is_featured'] = $request->boolean('is_featured');
            
            // Handle published_at field
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            } elseif ($data['status'] === 'draft') {
                $data['published_at'] = null;
            }

            VisaProcessing::create($data);

            return redirect()->route('visa-processing::admin.visa-processings.index')
                ->with('success', 'Visa processing created successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while creating the visa processing.'])->withInput();
        }
    }

    /**
     * Display the specified visa processing.
     */
    public function show(VisaProcessing $visaProcessing)
    {
        $visaProcessing->load('user');
        return view('visa-processing::admin.show', compact('visaProcessing'));
    }

    /**
     * Show the form for editing the specified visa processing.
     */
    public function edit(VisaProcessing $visaProcessing)
    {
        return view('visa-processing::admin.edit', compact('visaProcessing'));
    }

    /**
     * Update the specified visa processing in storage.
     */
    public function update(Request $request, VisaProcessing $visaProcessing)
    {
        $validator = Validator::make($request->all(), [
            'english_title' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'title.bn' => 'nullable|string|max:255',
            'content.en' => 'required|string',
            'content.bn' => 'nullable|string',
            'country' => 'required|string|max:100',
            'visa_type' => 'required|string|in:tourist,business,student,work,medical,transit,family,other',
            'visa_fees' => 'required|numeric|min:0',
            'processing_fee' => 'nullable|numeric|min:0',
            'processing_days' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'position' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'estimated_processing_time' => 'nullable|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_title.bn' => 'nullable|string|max:255',
            'meta_description.en' => 'nullable|string|max:500',
            'meta_description.bn' => 'nullable|string|max:500',
            'keywords.en' => 'nullable|string|max:500',
            'keywords.bn' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();
            $data['processing_fee'] = $data['processing_fee'] ?? 0;
            $data['position'] = $data['position'] ?? 0;
            $data['is_featured'] = $request->boolean('is_featured');
            
            // Handle published_at field
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            } elseif ($data['status'] === 'draft') {
                $data['published_at'] = null;
            }

            $visaProcessing->update($data);

            return redirect()->route('visa-processing::admin.visa-processings.index')
                ->with('success', 'Visa processing updated successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the visa processing.'])->withInput();
        }
    }

    /**
     * Remove the specified visa processing from storage.
     */
    public function destroy(VisaProcessing $visaProcessing)
    {
        try {
            // Check if there are any payments associated with this visa processing
            $paymentsCount = $visaProcessing->payments()->count();
            
            if ($paymentsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete visa processing. There are {$paymentsCount} payment(s) associated with it."
                ], 422);
            }

            $visaProcessing->delete();

            return response()->json([
                'success' => true,
                'message' => 'Visa processing deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the visa processing.'
            ], 500);
        }
    }

}