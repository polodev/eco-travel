<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Payment\Models\CustomPayment;
use Modules\Payment\Models\Payment;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class CustomPaymentController extends Controller
{
    public function index()
    {
        return view('payment::custom-payments.index');
    }

    public function indexJson(Request $request)
    {
        $model = CustomPayment::with(['payments', 'processedBy']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->has('search_text') && !empty($request->get('search_text'))) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('email', 'like', "%{$searchText}%")
                          ->orWhere('mobile', 'like', "%{$searchText}%")
                          ->orWhere('purpose', 'like', "%{$searchText}%")
                          ->orWhere('reference_number', 'like', "%{$searchText}%");
                    });
                }
                if ($request->has('status') && !empty($request->get('status'))) {
                    $query->where('status', $request->get('status'));
                }
                if ($request->has('payment_status') && !empty($request->get('payment_status'))) {
                    if ($request->get('payment_status') === 'fully_paid') {
                        $query->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE custom_payment_id = custom_payments.id AND status = "completed") >= amount');
                    } elseif ($request->get('payment_status') === 'partially_paid') {
                        $query->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE custom_payment_id = custom_payments.id AND status = "completed") > 0')
                              ->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE custom_payment_id = custom_payments.id AND status = "completed") < amount');
                    } elseif ($request->get('payment_status') === 'unpaid') {
                        $query->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE custom_payment_id = custom_payments.id AND status = "completed") = 0');
                    }
                }
            }, true)
            ->addColumn('customer_info', function (CustomPayment $customPayment) {
                $html = '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($customPayment->name) . '</div>';
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($customPayment->email ?? $customPayment->mobile) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('purpose_info', function (CustomPayment $customPayment) {
                $html = '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($customPayment->purpose ?? 'General Payment') . '</div>';
                if ($customPayment->reference_number) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">Ref: ' . htmlspecialchars($customPayment->reference_number) . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('amount_info', function (CustomPayment $customPayment) {
                return '<div class="text-sm">' .
                       '<div class="font-medium text-gray-900 dark:text-gray-100">' . $customPayment->formatted_amount . '</div>' .
                       '<div class="text-xs text-gray-500 dark:text-gray-400">Paid: ' . $customPayment->formatted_total_paid . '</div>' .
                       '</div>';
            })
            ->addColumn('payment_status', function (CustomPayment $customPayment) {
                if ($customPayment->isFullyPaid()) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-900 dark:bg-green-900 dark:text-green-100">Fully Paid</span>';
                } elseif ($customPayment->isPartiallyPaid()) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-900 dark:bg-orange-900 dark:text-orange-100">Partially Paid</span>';
                } else {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-900 dark:bg-red-900 dark:text-red-100">Unpaid</span>';
                }
            })
            ->addColumn('status_badge', function (CustomPayment $customPayment) {
                return $customPayment->status_badge;
            })
            ->addColumn('created_at_formatted', function (CustomPayment $customPayment) {
                return $customPayment->created_at->format('M j, Y H:i');
            })
            ->addColumn('actions', function (CustomPayment $customPayment) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('payment::admin.custom-payments.show', $customPayment->id) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('payment::admin.custom-payments.edit', $customPayment->id) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['customer_info', 'purpose_info', 'amount_info', 'payment_status', 'status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('payment::custom-payments.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'amount' => 'required|numeric|min:100',
            'purpose' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'reference_number' => 'nullable|string|max:255',
            'status' => 'required|in:submitted,processing,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ], [
            'amount.min' => __('messages.amount_minimum_required'),
        ]);

        // Set user who processed this payment
        $validatedData['processed_by'] = auth()->id();

        // Get IP and user agent from request
        $validatedData['ip_address'] = $request->ip();
        $validatedData['user_agent'] = $request->userAgent();

        $customPayment = CustomPayment::create($validatedData);

        // Auto-create payment record if feature is enabled
        if (config('payment.auto_create_payment', true)) {
            $this->createAutoPayment($customPayment);
        }

        return redirect()->route('payment::admin.custom-payments.show', $customPayment->id)->with('success', 'Custom payment created successfully.');
    }

    public function show(CustomPayment $customPayment)
    {
        $customPayment->load(['payments', 'processedBy']);
        return view('payment::custom-payments.show', compact('customPayment'));
    }

    public function edit(CustomPayment $customPayment)
    {
        return view('payment::custom-payments.edit', compact('customPayment'));
    }

    public function update(Request $request, CustomPayment $customPayment)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'amount' => 'required|numeric|min:100',
            'purpose' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'reference_number' => 'nullable|string|max:255',
            'status' => 'required|in:submitted,processing,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ], [
            'amount.min' => __('messages.amount_minimum_required'),
        ]);

        // Set processed_by to current admin user
        $validatedData['processed_by'] = auth()->id();

        // No additional timestamp updates needed - using created_at and updated_at

        $customPayment->update($validatedData);
        return redirect()->route('payment::admin.custom-payments.show', $customPayment->id)->with('success', 'Custom payment updated successfully.');
    }

    public function destroy(CustomPayment $customPayment)
    {
        try {
            // Check if there are associated payments
            if ($customPayment->payments()->count() > 0) {
                return response()->json(['success' => false, 'message' => 'Cannot delete custom payment with associated payment records.'], 400);
            }

            $customPayment->delete();
            return response()->json(['success' => true, 'message' => 'Custom payment deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting custom payment: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Automatically create a payment record for the custom payment.
     * This helps operators by creating an initial payment record that can be modified later.
     */
    private function createAutoPayment(CustomPayment $customPayment)
    {
        try {
            $defaults = config('payment.auto_payment_defaults');
            
            Payment::create([
                'custom_payment_id' => $customPayment->id,
                'amount' => $customPayment->amount,
                'payment_method' => $defaults['payment_method'] ?? 'sslcommerz',
                'status' => $defaults['status'] ?? 'pending',
                'payment_date' => now(),
                'notes' => $defaults['notes'] ?? 'Auto-created payment record for custom payment processing'
            ]);

            // Log this auto-creation for transparency
            \Log::info('Auto-payment created for CustomPayment', [
                'custom_payment_id' => $customPayment->id,
                'amount' => $customPayment->amount,
                'created_by' => auth()->user()->name ?? 'System'
            ]);

        } catch (\Exception $e) {
            // Log error but don't fail the custom payment creation
            \Log::error('Failed to auto-create payment for CustomPayment', [
                'custom_payment_id' => $customPayment->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}