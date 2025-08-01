<?php

namespace Modules\Booking\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Modules\Booking\Models\Booking;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use App\Models\User;

class BookingController extends Controller
{
    /**
     * Display the bookings index page.
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        
        $bookingTypes = Booking::getAvailableBookingTypes();
        $statuses = Booking::getAvailableStatuses();
        
        return view('booking::admin.bookings.index', compact(
            'countries', 
            'cities', 
            'users',
            'bookingTypes', 
            'statuses'
        ));
    }

    /**
     * Get bookings data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $bookings = Booking::with(['user', 'payments', 'flightBookings', 'hotelBookings', 'tourBookings'])
            ->select('bookings.*');

        return DataTables::eloquent($bookings)
            ->filter(function ($query) use ($request) {
                // Booking type filter
                if ($request->filled('booking_type')) {
                    $query->where('booking_type', $request->booking_type);
                }
                
                // Status filter
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }
                
                // User filter
                if ($request->filled('user_id')) {
                    $query->where('user_id', $request->user_id);
                }
                
                // Date range filter
                if ($request->filled('date_from')) {
                    $query->whereDate('booking_date', '>=', $request->date_from);
                }
                
                if ($request->filled('date_to')) {
                    $query->whereDate('booking_date', '<=', $request->date_to);
                }
                
                // Amount range filter
                if ($request->filled('amount_min')) {
                    $query->where('total_amount', '>=', $request->amount_min);
                }
                
                if ($request->filled('amount_max')) {
                    $query->where('total_amount', '<=', $request->amount_max);
                }
                
                // Payment status filter
                if ($request->filled('payment_status')) {
                    switch ($request->payment_status) {
                        case 'pending':
                            $query->whereDoesntHave('payments', function ($q) {
                                $q->where('status', 'completed');
                            });
                            break;
                        case 'partial':
                            $query->whereHas('payments', function ($q) {
                                $q->where('status', 'completed');
                            })->where(function ($q) {
                                $q->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE booking_id = bookings.id AND status = "completed") < net_receivable_amount');
                            });
                            break;
                        case 'paid':
                            $query->where(function ($q) {
                                $q->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE booking_id = bookings.id AND status = "completed") >= net_receivable_amount');
                            });
                            break;
                    }
                }
                
                // Travel date filter
                if ($request->filled('travel_date_from')) {
                    $query->whereDate('travel_date', '>=', $request->travel_date_from);
                }
                
                if ($request->filled('travel_date_to')) {
                    $query->whereDate('travel_date', '<=', $request->travel_date_to);
                }
                
                // Quick search
                if ($request->filled('quick_search')) {
                    $search = $request->quick_search;
                    $query->where(function ($q) use ($search) {
                        $q->where('booking_reference', 'like', "%{$search}%")
                          ->orWhere('confirmation_code', 'like', "%{$search}%")
                          ->orWhereHas('user', function ($userQuery) use ($search) {
                              $userQuery->where('name', 'like', "%{$search}%")
                                       ->orWhere('email', 'like', "%{$search}%");
                          })
                          ->orWhereJsonContains('customer_details->name', $search)
                          ->orWhereJsonContains('contact_details->email', $search);
                    });
                }
            }, true)
            ->addColumn('user_info', function (Booking $booking) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($booking->user->name ?? 'N/A') . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . e($booking->user->email ?? 'N/A') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('customer_info', function (Booking $booking) {
                $customerName = $booking->customer_details['name'] ?? 'N/A';
                $customerEmail = $booking->contact_details['email'] ?? 'N/A';
                
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($customerName) . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . e($customerEmail) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('booking_details', function (Booking $booking) {
                $html = '<div class="text-sm space-y-1">';
                $html .= '<div class="font-semibold text-gray-900 dark:text-gray-100">' . e($booking->booking_reference) . '</div>';
                $html .= '<div>' . $booking->booking_type_badge . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('travel_info', function (Booking $booking) {
                $html = '<div class="text-sm">';
                if ($booking->travel_date) {
                    $html .= '<div class="text-gray-900 dark:text-gray-100">' . $booking->travel_date->format('M j, Y') . '</div>';
                    if ($booking->return_date) {
                        $html .= '<div class="text-gray-500 dark:text-gray-400">to ' . $booking->return_date->format('M j, Y') . '</div>';
                    }
                } else {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">Not specified</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('passengers_info', function (Booking $booking) {
                $total = $booking->total_passengers;
                $breakdown = [];
                
                if ($booking->adults > 0) $breakdown[] = $booking->adults . ' Adult' . ($booking->adults > 1 ? 's' : '');
                if ($booking->children > 0) $breakdown[] = $booking->children . ' Child' . ($booking->children > 1 ? 'ren' : '');
                if ($booking->infants > 0) $breakdown[] = $booking->infants . ' Infant' . ($booking->infants > 1 ? 's' : '');
                
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $total . ' Total</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . implode(', ', $breakdown) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('amount_info', function (Booking $booking) {
                $html = '<div class="text-sm space-y-1 text-right">';
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">Total</div>';
                $html .= '<div class="font-semibold text-gray-900 dark:text-gray-100">৳' . number_format($booking->total_amount, 2) . '</div>';
                
                if ($booking->discount > 0) {
                    $html .= '<div class="text-xs text-green-600 dark:text-green-400">Discount: -৳' . number_format($booking->discount, 2) . '</div>';
                }
                
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-600 pt-1 mt-1">Net Receivable</div>';
                $html .= '<div class="font-medium text-blue-600 dark:text-blue-400">৳' . number_format($booking->net_receivable_amount, 2) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('payment_info', function (Booking $booking) {
                $totalPaid = $booking->total_paid_amount;
                $remaining = $booking->remaining_amount;
                
                $html = '<div class="text-sm space-y-1 text-right">';
                
                if ($totalPaid > 0) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">Paid</div>';
                    $html .= '<div class="font-medium text-green-600 dark:text-green-400">৳' . number_format($totalPaid, 2) . '</div>';
                }
                
                if ($remaining > 0) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-600 pt-1 mt-1">Due</div>';
                    $html .= '<div class="font-medium text-red-600 dark:text-red-400">৳' . number_format($remaining, 2) . '</div>';
                }
                
                $html .= '<div class="mt-2 flex justify-end">' . $booking->payment_status_badge . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('status', function (Booking $booking) {
                return $booking->status_badge;
            })
            ->addColumn('dates', function (Booking $booking) {
                $html = '<div class="text-sm text-gray-500 dark:text-gray-400">';
                $html .= '<div>Booked: ' . $booking->booking_date->format('M j, Y') . '</div>';
                if ($booking->confirmed_at) {
                    $html .= '<div>Confirmed: ' . $booking->confirmed_at->format('M j, Y') . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('actions', function (Booking $booking) {
                $html = '<div class="flex items-center justify-center space-x-2">';
                
                // View button with better contrast
                $html .= '<a href="' . route('booking::admin.bookings.show', $booking) . '" 
                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-colors duration-150" 
                            title="View Details">';
                $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
                
                // Edit button (only for pending/confirmed) with better contrast
                if (in_array($booking->status, ['pending', 'confirmed'])) {
                    $html .= '<a href="' . route('booking::admin.bookings.edit', $booking) . '" 
                                class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-amber-600 border border-transparent rounded-md hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-1 transition-colors duration-150" 
                                title="Edit Booking">';
                    $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                    $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>';
                    $html .= '</svg>';
                    $html .= '</a>';
                }
                
                // Sub-bookings buttons with better contrast
                if ($booking->booking_type === 'flight' || $booking->booking_type === 'package') {
                    $flightCount = $booking->flightBookings->count();
                    if ($flightCount > 0) {
                        $html .= '<a href="' . route('booking::admin.booking-flights.index', ['booking_id' => $booking->id]) . '" 
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-purple-600 border border-transparent rounded hover:bg-purple-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-1 transition-colors duration-150" 
                                    title="Flight Details (' . $flightCount . ')">';
                        $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                        $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>';
                        $html .= '</svg>';
                        $html .= '</a>';
                    }
                }
                
                if ($booking->booking_type === 'hotel' || $booking->booking_type === 'package') {
                    $hotelCount = $booking->hotelBookings->count();
                    if ($hotelCount > 0) {
                        $html .= '<a href="' . route('booking::admin.booking-hotels.index', ['booking_id' => $booking->id]) . '" 
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-600 border border-transparent rounded hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-colors duration-150" 
                                    title="Hotel Details (' . $hotelCount . ')">';
                        $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                        $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>';
                        $html .= '</svg>';
                        $html .= '</a>';
                    }
                }
                
                if ($booking->booking_type === 'tour' || $booking->booking_type === 'package') {
                    $tourCount = $booking->tourBookings->count();
                    if ($tourCount > 0) {
                        $html .= '<a href="' . route('booking::admin.booking-tours.index', ['booking_id' => $booking->id]) . '" 
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-indigo-600 border border-transparent rounded hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition-colors duration-150" 
                                    title="Tour Details (' . $tourCount . ')">';
                        $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                        $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>';
                        $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>';
                        $html .= '</svg>';
                        $html .= '</a>';
                    }
                }
                
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['user_info', 'customer_info', 'booking_details', 'travel_info', 'passengers_info', 'amount_info', 'payment_info', 'status', 'dates', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        
        $bookingTypes = Booking::getAvailableBookingTypes();
        $statuses = Booking::getAvailableStatuses();
        
        return view('booking::admin.bookings.create', compact(
            'users',
            'countries',
            'cities',
            'bookingTypes',
            'statuses'
        ));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'booking_type' => 'required|in:' . implode(',', array_keys(Booking::getAvailableBookingTypes())),
            'status' => 'required|in:' . implode(',', array_keys(Booking::getAvailableStatuses())),
            'total_amount' => 'required|numeric|min:0',
            'net_receivable_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'coupon_code' => 'nullable|string|max:50',
            'customer_details.name' => 'required|string|max:255',
            'customer_details.email' => 'required|email|max:255',
            'customer_details.nationality' => 'required|string|max:100',
            'contact_details.email' => 'required|email|max:255',
            'contact_details.phone' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'travel_date' => 'nullable|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:travel_date',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:20',
            'infants' => 'nullable|integer|min:0|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'booking_type' => $request->booking_type,
            'status' => $request->status,
            'total_amount' => $request->total_amount,
            'net_receivable_amount' => $request->net_receivable_amount,
            'discount' => $request->discount ?? 0,
            'coupon_code' => $request->coupon_code,
            'customer_details' => $request->customer_details,
            'contact_details' => $request->contact_details,
            'additional_requirements' => $request->additional_requirements,
            'booking_date' => $request->booking_date,
            'travel_date' => $request->travel_date,
            'return_date' => $request->return_date,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'infants' => $request->infants ?? 0,
            'cancellation_policy' => $request->cancellation_policy,
            'notes' => $request->notes,
        ]);

        return redirect()->route('booking::admin.bookings.show', $booking)
                        ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'payments', 'flightBookings', 'hotelBookings', 'tourBookings']);
        
        return view('booking::admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        $users = User::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        
        $bookingTypes = Booking::getAvailableBookingTypes();
        $statuses = Booking::getAvailableStatuses();
        
        return view('booking::admin.bookings.edit', compact(
            'booking',
            'users',
            'countries',
            'cities',
            'bookingTypes',
            'statuses'
        ));
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'booking_type' => 'required|in:' . implode(',', array_keys(Booking::getAvailableBookingTypes())),
            'status' => 'required|in:' . implode(',', array_keys(Booking::getAvailableStatuses())),
            'total_amount' => 'required|numeric|min:0',
            'net_receivable_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'coupon_code' => 'nullable|string|max:50',
            'customer_details.name' => 'required|string|max:255',
            'customer_details.email' => 'required|email|max:255',
            'customer_details.nationality' => 'required|string|max:100',
            'contact_details.email' => 'required|email|max:255',
            'contact_details.phone' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'travel_date' => 'nullable|date',
            'return_date' => 'nullable|date|after_or_equal:travel_date',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:20',
            'infants' => 'nullable|integer|min:0|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $booking->update([
            'user_id' => $request->user_id,
            'booking_type' => $request->booking_type,
            'status' => $request->status,
            'total_amount' => $request->total_amount,
            'net_receivable_amount' => $request->net_receivable_amount,
            'discount' => $request->discount ?? 0,
            'coupon_code' => $request->coupon_code,
            'customer_details' => $request->customer_details,
            'contact_details' => $request->contact_details,
            'additional_requirements' => $request->additional_requirements,
            'booking_date' => $request->booking_date,
            'travel_date' => $request->travel_date,
            'return_date' => $request->return_date,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'infants' => $request->infants ?? 0,
            'cancellation_policy' => $request->cancellation_policy,
            'notes' => $request->notes,
        ]);

        return redirect()->route('booking::admin.bookings.show', $booking)
                        ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete booking: ' . $e->getMessage()
            ], 500);
        }
    }
}