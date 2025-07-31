<?php

namespace Modules\Booking\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingHotel;

class BookingHotelController extends Controller
{
    /**
     * Display the hotel bookings index page.
     */
    public function index(Request $request)
    {
        $booking = null;
        if ($request->has('booking_id')) {
            $booking = Booking::findOrFail($request->booking_id);
        }
        
        return view('booking::admin.booking-hotels.index', compact('booking'));
    }

    /**
     * Get hotel bookings data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $query = BookingHotel::with(['booking.user', 'hotel', 'hotelRoom']);
        
        // Filter by specific booking if provided
        if ($request->filled('booking_id')) {
            $query->where('booking_id', $request->booking_id);
        }

        return DataTables::eloquent($query)
            ->filter(function ($query) use ($request) {
                // Booking status filter
                if ($request->filled('booking_status')) {
                    $query->where('booking_status', $request->booking_status);
                }
                
                // Rate plan filter
                if ($request->filled('rate_plan')) {
                    $query->where('rate_plan', $request->rate_plan);
                }
                
                // Hotel filter
                if ($request->filled('hotel_id')) {
                    $query->where('hotel_id', $request->hotel_id);
                }
                
                // Check-in date filter
                if ($request->filled('checkin_date_from')) {
                    $query->whereDate('checkin_date', '>=', $request->checkin_date_from);
                }
                
                if ($request->filled('checkin_date_to')) {
                    $query->whereDate('checkin_date', '<=', $request->checkin_date_to);
                }
                
                // Check-out date filter
                if ($request->filled('checkout_date_from')) {
                    $query->whereDate('checkout_date', '>=', $request->checkout_date_from);
                }
                
                if ($request->filled('checkout_date_to')) {
                    $query->whereDate('checkout_date', '<=', $request->checkout_date_to);
                }
                
                // Nights filter
                if ($request->filled('nights_min')) {
                    $query->where('nights', '>=', $request->nights_min);
                }
                
                if ($request->filled('nights_max')) {
                    $query->where('nights', '<=', $request->nights_max);
                }
                
                // Amount range filter
                if ($request->filled('amount_min')) {
                    $query->where('total_amount', '>=', $request->amount_min);
                }
                
                if ($request->filled('amount_max')) {
                    $query->where('total_amount', '<=', $request->amount_max);
                }
                
                // Quick search
                if ($request->filled('quick_search')) {
                    $search = $request->quick_search;
                    $query->where(function ($q) use ($search) {
                        $q->where('confirmation_number', 'like', "%{$search}%")
                          ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                              $bookingQuery->where('booking_reference', 'like', "%{$search}%");
                          })
                          ->orWhereHas('hotel', function ($hotelQuery) use ($search) {
                              $hotelQuery->where('name', 'like', "%{$search}%");
                          });
                    });
                }
            }, true)
            ->addColumn('booking_info', function (BookingHotel $hotel) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($hotel->booking->booking_reference) . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . e($hotel->booking->user->name ?? 'N/A') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('hotel_info', function (BookingHotel $hotel) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($hotel->hotel->name ?? 'N/A') . '</div>';
                if ($hotel->hotelRoom) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">' . e($hotel->hotelRoom->name) . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('stay_details', function (BookingHotel $hotel) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $hotel->nights . ' Night' . ($hotel->nights > 1 ? 's' : '') . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . $hotel->rooms . ' Room' . ($hotel->rooms > 1 ? 's' : '') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('checkin_info', function (BookingHotel $hotel) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $hotel->checkin_date->format('M j, Y') . '</div>';
                if ($hotel->checkin_time) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">' . $hotel->checkin_time->format('H:i') . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('checkout_info', function (BookingHotel $hotel) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $hotel->checkout_date->format('M j, Y') . '</div>';
                if ($hotel->checkout_time) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">' . $hotel->checkout_time->format('H:i') . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('guests_info', function (BookingHotel $hotel) {
                $total = $hotel->total_guests;
                $breakdown = [];
                
                if ($hotel->adults > 0) $breakdown[] = $hotel->adults . ' Adult' . ($hotel->adults > 1 ? 's' : '');
                if ($hotel->children > 0) $breakdown[] = $hotel->children . ' Child' . ($hotel->children > 1 ? 'ren' : '');
                
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $total . ' Total</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . implode(', ', $breakdown) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('amount_info', function (BookingHotel $hotel) {
                $html = '<div class="text-sm text-right">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">৳' . number_format($hotel->total_amount, 2) . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">৳' . number_format($hotel->room_rate, 2) . '/night</div>';
                
                if ($hotel->taxes_fees > 0) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">+৳' . number_format($hotel->taxes_fees, 2) . ' tax</div>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->addColumn('booking_info_status', function (BookingHotel $hotel) {
                $html = '<div class="text-sm">';
                $html .= '<div>' . $hotel->booking_status_badge . '</div>';
                
                if ($hotel->rate_plan) {
                    $html .= '<div class="mt-1">' . $hotel->rate_plan_badge . '</div>';
                }
                
                if ($hotel->confirmation_number) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400 font-mono mt-1 text-xs">Conf: ' . e($hotel->confirmation_number) . '</div>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->addColumn('actions', function (BookingHotel $hotel) {
                $html = '<div class="flex items-center space-x-1">';
                
                // View button
                $html .= '<a href="' . route('admin-dashboard.booking.booking-hotels.show', $hotel) . '" 
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200 dark:bg-blue-800 dark:text-blue-200 dark:hover:bg-blue-700" 
                            title="View Details">';
                $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
                
                // Edit button (only for pending/confirmed bookings)
                if (in_array($hotel->booking_status, ['pending', 'confirmed'])) {
                    $html .= '<a href="' . route('admin-dashboard.booking.booking-hotels.edit', $hotel) . '" 
                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200 dark:bg-yellow-800 dark:text-yellow-200 dark:hover:bg-yellow-700" 
                                title="Edit Hotel Booking">';
                    $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                    $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>';
                    $html .= '</svg>';
                    $html .= '</a>';
                }
                
                // Main booking link
                $html .= '<a href="' . route('admin-dashboard.booking.bookings.show', $hotel->booking) . '" 
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500" 
                            title="View Main Booking">';
                $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
                
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['booking_info', 'hotel_info', 'stay_details', 'checkin_info', 'checkout_info', 'guests_info', 'amount_info', 'booking_info_status', 'actions'])
            ->make(true);
    }

    /**
     * Display the specified hotel booking.
     */
    public function show(BookingHotel $bookingHotel)
    {
        $bookingHotel->load(['booking.user', 'hotel', 'hotelRoom']);
        
        return view('booking::admin.booking-hotels.show', compact('bookingHotel'));
    }

    /**
     * Show the form for editing the specified hotel booking.
     */
    public function edit(BookingHotel $bookingHotel)
    {
        $bookingHotel->load(['booking', 'hotel', 'hotelRoom']);
        
        return view('booking::admin.booking-hotels.edit', compact('bookingHotel'));
    }

    /**
     * Update the specified hotel booking.
     */
    public function update(Request $request, BookingHotel $bookingHotel)
    {
        $request->validate([
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'nights' => 'required|integer|min:1|max:365',
            'rooms' => 'required|integer|min:1|max:20',
            'adults' => 'required|integer|min:1|max:50',
            'children' => 'nullable|integer|min:0|max:50',
            'room_rate' => 'required|numeric|min:0',
            'total_room_cost' => 'required|numeric|min:0',
            'taxes_fees' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'rate_plan' => 'required|in:room_only,breakfast_included,half_board,full_board,all_inclusive',
            'booking_status' => 'required|in:pending,confirmed,checked_in,checked_out,no_show,cancelled',
            'confirmation_number' => 'nullable|string|max:50',
            'checkin_time' => 'nullable|date_format:H:i',
            'checkout_time' => 'nullable|date_format:H:i',
        ]);

        $bookingHotel->update([
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'nights' => $request->nights,
            'rooms' => $request->rooms,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'room_rate' => $request->room_rate,
            'total_room_cost' => $request->total_room_cost,
            'taxes_fees' => $request->taxes_fees ?? 0,
            'total_amount' => $request->total_amount,
            'rate_plan' => $request->rate_plan,
            'booking_status' => $request->booking_status,
            'confirmation_number' => $request->confirmation_number,
            'checkin_time' => $request->checkin_time,
            'checkout_time' => $request->checkout_time,
        ]);

        return redirect()->route('admin-dashboard.booking.booking-hotels.show', $bookingHotel)
                        ->with('success', 'Hotel booking updated successfully.');
    }

    /**
     * Remove the specified hotel booking.
     */
    public function destroy(BookingHotel $bookingHotel)
    {
        try {
            $bookingId = $bookingHotel->booking_id;
            $bookingHotel->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Hotel booking deleted successfully.',
                'redirect' => route('admin-dashboard.booking.bookings.show', $bookingId)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete hotel booking: ' . $e->getMessage()
            ], 500);
        }
    }
}