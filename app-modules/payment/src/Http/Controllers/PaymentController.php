<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Payment\Models\Payment;
use Modules\Booking\Models\Booking;
use Modules\Payment\Models\CustomPayment;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment::payments.index');
    }

    public function indexJson(Request $request)
    {
        $model = Payment::with(['booking.user', 'customPayment']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->has('search_text') && !empty($request->get('search_text'))) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('transaction_id', 'like', "%{$searchText}%")
                          ->orWhere('gateway_payment_id', 'like', "%{$searchText}%")
                          ->orWhere('receipt_number', 'like', "%{$searchText}%")
                          ->orWhereHas('booking', function ($bookingQuery) use ($searchText) {
                              $bookingQuery->where('booking_reference', 'like', "%{$searchText}%")
                                          ->orWhereHas('user', function ($userQuery) use ($searchText) {
                                              $userQuery->where('name', 'like', "%{$searchText}%")
                                                       ->orWhere('email', 'like', "%{$searchText}%");
                                          });
                          })
                          ->orWhereHas('customPayment', function ($customQuery) use ($searchText) {
                              $customQuery->where('name', 'like', "%{$searchText}%")
                                         ->orWhere('email', 'like', "%{$searchText}%")
                                         ->orWhere('mobile', 'like', "%{$searchText}%");
                          });
                    });
                }
                if ($request->has('status') && !empty($request->get('status'))) {
                    $query->where('status', $request->get('status'));
                }
                if ($request->has('payment_method') && !empty($request->get('payment_method'))) {
                    $query->where('payment_method', $request->get('payment_method'));
                }
                if ($request->has('payment_type') && !empty($request->get('payment_type'))) {
                    if ($request->get('payment_type') === 'booking') {
                        $query->whereNotNull('booking_id');
                    } elseif ($request->get('payment_type') === 'custom') {
                        $query->whereNotNull('custom_payment_id');
                    }
                }
            }, true)
            ->addColumn('payment_info', function (Payment $payment) {
                $html = '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($payment->formatted_amount) . '</div>';
                if ($payment->transaction_id) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">ID: ' . htmlspecialchars($payment->transaction_id) . '</div>';
                }
                if ($payment->receipt_number) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">Receipt: ' . htmlspecialchars($payment->receipt_number) . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('customer_info', function (Payment $payment) {
                if ($payment->booking) {
                    $html = '<div>';
                    $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($payment->booking->user->name ?? 'Guest User') . '</div>';
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">Booking: ' . htmlspecialchars($payment->booking->booking_reference) . '</div>';
                    $html .= '</div>';
                    return $html;
                } elseif ($payment->customPayment) {
                    $html = '<div>';
                    $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($payment->customPayment->name) . '</div>';
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($payment->customPayment->email ?? $payment->customPayment->mobile) . '</div>';
                    $html .= '</div>';
                    return $html;
                }
                return '<span class="text-gray-400">No customer info</span>';
            })
            ->addColumn('payment_type', function (Payment $payment) {
                if ($payment->booking_id) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-900 dark:bg-blue-900 dark:text-blue-100">Booking</span>';
                } elseif ($payment->custom_payment_id) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-900 dark:bg-green-900 dark:text-green-100">Custom</span>';
                }
                return '<span class="text-gray-400">Unknown</span>';
            })
            ->addColumn('payment_method_badge', function (Payment $payment) {
                return $payment->payment_method_badge;
            })
            ->addColumn('status_badge', function (Payment $payment) {
                return $payment->status_badge;
            })
            ->addColumn('payment_date_formatted', function (Payment $payment) {
                return $payment->payment_date ? $payment->payment_date->format('M j, Y H:i') : 'N/A';
            })
            ->addColumn('created_at_formatted', function (Payment $payment) {
                return $payment->created_at->format('M j, Y H:i');
            })
            ->addColumn('actions', function (Payment $payment) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('admin-dashboard.payment.payments.show', $payment->id) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('admin-dashboard.payment.payments.edit', $payment->id) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['payment_info', 'customer_info', 'payment_type', 'payment_method_badge', 'status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $bookings = Booking::with('user')->orderBy('created_at', 'desc')->limit(100)->get();
        $customPayments = CustomPayment::orderBy('created_at', 'desc')->limit(100)->get();
        return view('payment::payments.create', compact('bookings', 'customPayments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'custom_payment_id' => 'nullable|exists:custom_payments,id',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,processing,completed,failed,cancelled,refunded',
            'payment_method' => 'nullable|in:sslcommerz,bkash,nagad,city_bank,brac_bank,bank_transfer,cash,other',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id',
            'gateway_payment_id' => 'nullable|string|max:255',
            'gateway_reference' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
            'receipt_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Ensure only one reference type is set
        if ($validatedData['booking_id'] && $validatedData['custom_payment_id']) {
            return back()->withErrors(['general' => 'Payment can only be associated with either booking or custom payment, not both.']);
        }

        if (!$validatedData['booking_id'] && !$validatedData['custom_payment_id']) {
            return back()->withErrors(['general' => 'Payment must be associated with either a booking or custom payment.']);
        }

        // Set created_by to current admin user
        $validatedData['created_by'] = auth()->id();

        // Set processed_at if status is completed
        if ($validatedData['status'] === 'completed') {
            $validatedData['processed_at'] = now();
        }

        Payment::create($validatedData);
        return redirect()->route('admin-dashboard.payment.payments.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.user', 'customPayment']);
        return view('payment::payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $bookings = Booking::with('user')->orderBy('created_at', 'desc')->limit(100)->get();
        $customPayments = CustomPayment::orderBy('created_at', 'desc')->limit(100)->get();
        return view('payment::payments.edit', compact('payment', 'bookings', 'customPayments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,processing,completed,failed,cancelled,refunded',
            'payment_method' => 'nullable|in:sslcommerz,bkash,nagad,city_bank,brac_bank,bank_transfer,cash,other',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id,' . $payment->id,
            'gateway_payment_id' => 'nullable|string|max:255',
            'gateway_reference' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
            'receipt_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Set processed_at if status changed to completed
        if ($validatedData['status'] === 'completed' && $payment->status !== 'completed') {
            $validatedData['processed_at'] = now();
        }

        // Set failed_at if status changed to failed
        if ($validatedData['status'] === 'failed' && $payment->status !== 'failed') {
            $validatedData['failed_at'] = now();
        }

        // Set refunded_at if status changed to refunded
        if ($validatedData['status'] === 'refunded' && $payment->status !== 'refunded') {
            $validatedData['refunded_at'] = now();
        }

        $payment->update($validatedData);
        return redirect()->route('admin-dashboard.payment.payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return response()->json(['success' => true, 'message' => 'Payment deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting payment: ' . $e->getMessage()], 500);
        }
    }
}