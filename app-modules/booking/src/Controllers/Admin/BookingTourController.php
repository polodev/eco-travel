<?php

namespace Modules\Booking\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingTour;

class BookingTourController extends Controller
{
    /**
     * Display the tour bookings index page.
     */
    public function index(Request $request)
    {
        $booking = null;
        if ($request->has('booking_id')) {
            $booking = Booking::findOrFail($request->booking_id);
        }
        
        return view('booking::admin.booking-tours.index', compact('booking'));
    }

    /**
     * Get tour bookings data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $query = BookingTour::with(['booking.user', 'tour']);
        
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
                
                // Accommodation type filter
                if ($request->filled('accommodation_type')) {
                    $query->where('accommodation_type', $request->accommodation_type);
                }
                
                // Tour filter
                if ($request->filled('tour_id')) {
                    $query->where('tour_id', $request->tour_id);
                }
                
                // Tour start date filter
                if ($request->filled('tour_start_date_from')) {
                    $query->whereDate('tour_start_date', '>=', $request->tour_start_date_from);
                }
                
                if ($request->filled('tour_start_date_to')) {
                    $query->whereDate('tour_start_date', '<=', $request->tour_start_date_to);
                }
                
                // Tour end date filter
                if ($request->filled('tour_end_date_from')) {
                    $query->whereDate('tour_end_date', '>=', $request->tour_end_date_from);
                }
                
                if ($request->filled('tour_end_date_to')) {
                    $query->whereDate('tour_end_date', '<=', $request->tour_end_date_to);
                }
                
                // Duration filter
                if ($request->filled('duration_min')) {
                    $query->whereRaw('DATEDIFF(tour_end_date, tour_start_date) + 1 >= ?', [$request->duration_min]);
                }
                
                if ($request->filled('duration_max')) {
                    $query->whereRaw('DATEDIFF(tour_end_date, tour_start_date) + 1 <= ?', [$request->duration_max]);
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
                        $q->where('tour_voucher', 'like', "%{$search}%")
                          ->orWhere('tour_guide', 'like', "%{$search}%")
                          ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                              $bookingQuery->where('booking_reference', 'like', "%{$search}%");
                          })
                          ->orWhereHas('tour', function ($tourQuery) use ($search) {
                              $tourQuery->where('name', 'like', "%{$search}%");
                          });
                    });
                }
            }, true)
            ->addColumn('booking_info', function (BookingTour $tour) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($tour->booking->booking_reference) . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . e($tour->booking->user->name ?? 'N/A') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('tour_info', function (BookingTour $tour) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($tour->tour->name ?? 'N/A') . '</div>';
                if ($tour->tour_guide) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">Guide: ' . e($tour->tour_guide) . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('tour_details', function (BookingTour $tour) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $tour->tour_duration . ' Day' . ($tour->tour_duration > 1 ? 's' : '') . '</div>';
                if ($tour->accommodation_type) {
                    $html .= '<div class="mt-1">' . $tour->accommodation_type_badge . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('tour_start_info', function (BookingTour $tour) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $tour->tour_start_date->format('M j, Y') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('tour_end_info', function (BookingTour $tour) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $tour->tour_end_date->format('M j, Y') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('participants_info', function (BookingTour $tour) {
                $total = $tour->total_participants;
                $breakdown = [];
                
                if ($tour->adults > 0) $breakdown[] = $tour->adults . ' Adult' . ($tour->adults > 1 ? 's' : '');
                if ($tour->children > 0) $breakdown[] = $tour->children . ' Child' . ($tour->children > 1 ? 'ren' : '');
                
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $total . ' Total</div>';
                if (!empty($breakdown)) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">' . implode(', ', $breakdown) . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('amount_info', function (BookingTour $tour) {
                $html = '<div class="text-sm text-right">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">৳' . number_format($tour->total_amount, 2) . '</div>';
                
                if ($tour->adult_price > 0) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">৳' . number_format($tour->adult_price, 2) . '/adult</div>';
                }
                
                if ($tour->single_supplement > 0) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">+৳' . number_format($tour->single_supplement, 2) . ' single</div>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->addColumn('booking_info_status', function (BookingTour $tour) {
                $html = '<div class="text-sm">';
                $html .= '<div>' . $tour->booking_status_badge . '</div>';
                
                if ($tour->tour_voucher) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400 font-mono mt-1 text-xs">Voucher: ' . e($tour->tour_voucher) . '</div>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->addColumn('actions', function (BookingTour $tour) {
                $html = '<div class="flex items-center space-x-1">';
                
                // View button
                $html .= '<a href="' . route('booking::admin.booking-tours.show', $tour) . '" 
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200 dark:bg-blue-800 dark:text-blue-200 dark:hover:bg-blue-700" 
                            title="View Details">';
                $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
                
                // Edit button (only for pending/confirmed bookings)
                if (in_array($tour->booking_status, ['pending', 'confirmed'])) {
                    $html .= '<a href="' . route('booking::admin.booking-tours.edit', $tour) . '" 
                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200 dark:bg-yellow-800 dark:text-yellow-200 dark:hover:bg-yellow-700" 
                                title="Edit Tour Booking">';
                    $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                    $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>';
                    $html .= '</svg>';
                    $html .= '</a>';
                }
                
                // Main booking link
                $html .= '<a href="' . route('booking::admin.bookings.show', $tour->booking) . '" 
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500" 
                            title="View Main Booking">';
                $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
                
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['booking_info', 'tour_info', 'tour_details', 'tour_start_info', 'tour_end_info', 'participants_info', 'amount_info', 'booking_info_status', 'actions'])
            ->make(true);
    }

    /**
     * Display the specified tour booking.
     */
    public function show(BookingTour $bookingTour)
    {
        $bookingTour->load(['booking.user', 'tour']);
        
        return view('booking::admin.booking-tours.show', compact('bookingTour'));
    }

    /**
     * Show the form for editing the specified tour booking.
     */
    public function edit(BookingTour $bookingTour)
    {
        $bookingTour->load(['booking', 'tour']);
        
        return view('booking::admin.booking-tours.edit', compact('bookingTour'));
    }

    /**
     * Update the specified tour booking.
     */
    public function update(Request $request, BookingTour $bookingTour)
    {
        $request->validate([
            'tour_start_date' => 'required|date',
            'tour_end_date' => 'required|date|after:tour_start_date',
            'adults' => 'required|integer|min:1|max:50',
            'children' => 'nullable|integer|min:0|max:50',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'single_supplement' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'accommodation_type' => 'required|in:shared,single,twin,double',
            'booking_status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'tour_voucher' => 'nullable|string|max:50',
            'tour_guide' => 'nullable|string|max:100',
        ]);

        $bookingTour->update([
            'tour_start_date' => $request->tour_start_date,
            'tour_end_date' => $request->tour_end_date,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'adult_price' => $request->adult_price,
            'child_price' => $request->child_price,
            'single_supplement' => $request->single_supplement ?? 0,
            'total_amount' => $request->total_amount,
            'accommodation_type' => $request->accommodation_type,
            'booking_status' => $request->booking_status,
            'tour_voucher' => $request->tour_voucher,
            'tour_guide' => $request->tour_guide,
        ]);

        return redirect()->route('booking::admin.booking-tours.show', $bookingTour)
                        ->with('success', 'Tour booking updated successfully.');
    }

    /**
     * Remove the specified tour booking.
     */
    public function destroy(BookingTour $bookingTour)
    {
        try {
            $bookingId = $bookingTour->booking_id;
            $bookingTour->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Tour booking deleted successfully.',
                'redirect' => route('booking::admin.bookings.show', $bookingId)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tour booking: ' . $e->getMessage()
            ], 500);
        }
    }
}