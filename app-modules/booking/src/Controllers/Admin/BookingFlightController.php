<?php

namespace Modules\Booking\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingFlight;

class BookingFlightController extends Controller
{
    /**
     * Display the flight bookings index page.
     */
    public function index(Request $request)
    {
        $booking = null;
        if ($request->has('booking_id')) {
            $booking = Booking::findOrFail($request->booking_id);
        }
        
        return view('booking::admin.booking-flights.index', compact('booking'));
    }

    /**
     * Get flight bookings data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $query = BookingFlight::with(['booking.user']);
        
        // Filter by specific booking if provided
        if ($request->filled('booking_id')) {
            $query->where('booking_id', $request->booking_id);
        }

        return DataTables::eloquent($query)
            ->filter(function ($query) use ($request) {
                // Trip type filter
                if ($request->filled('trip_type')) {
                    $query->where('trip_type', $request->trip_type);
                }
                
                // Cabin class filter
                if ($request->filled('cabin_class')) {
                    $query->where('cabin_class', $request->cabin_class);
                }
                
                // Ticket status filter
                if ($request->filled('ticket_status')) {
                    $query->where('ticket_status', $request->ticket_status);
                }
                
                // Airline filter
                if ($request->filled('airline_code')) {
                    $query->where('airline_code', $request->airline_code);
                }
                
                // Route filter
                if ($request->filled('route')) {
                    $parts = explode('-', $request->route);
                    if (count($parts) === 2) {
                        $query->where('departure_airport', trim($parts[0]))
                              ->where('arrival_airport', trim($parts[1]));
                    }
                }
                
                // Departure date filter
                if ($request->filled('departure_date_from')) {
                    $query->whereDate('departure_datetime', '>=', $request->departure_date_from);
                }
                
                if ($request->filled('departure_date_to')) {
                    $query->whereDate('departure_datetime', '<=', $request->departure_date_to);
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
                        $q->where('pnr_code', 'like', "%{$search}%")
                          ->orWhere('ticket_numbers', 'like', "%{$search}%")
                          ->orWhere('flight_number', 'like', "%{$search}%")
                          ->orWhere('airline_code', 'like', "%{$search}%")
                          ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                              $bookingQuery->where('booking_reference', 'like', "%{$search}%");
                          });
                    });
                }
            }, true)
            ->addColumn('booking_info', function (BookingFlight $flight) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($flight->booking->booking_reference) . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . e($flight->booking->user->name ?? 'N/A') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('flight_info', function (BookingFlight $flight) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . e($flight->airline_code . ' ' . $flight->flight_number) . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . e($flight->departure_airport . ' → ' . $flight->arrival_airport) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('trip_details', function (BookingFlight $flight) {
                $html = '<div class="text-sm">';
                $html .= '<div>' . $flight->cabin_class_badge . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400 mt-1">' . ucfirst($flight->trip_type) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('departure_info', function (BookingFlight $flight) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $flight->departure_datetime->format('M j, Y') . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . $flight->departure_datetime->format('H:i') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('arrival_info', function (BookingFlight $flight) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $flight->arrival_datetime->format('M j, Y') . '</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . $flight->arrival_datetime->format('H:i') . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('passengers_info', function (BookingFlight $flight) {
                $total = $flight->total_passengers;
                $breakdown = [];
                
                if ($flight->adults > 0) $breakdown[] = $flight->adults . ' Adult' . ($flight->adults > 1 ? 's' : '');
                if ($flight->children > 0) $breakdown[] = $flight->children . ' Child' . ($flight->children > 1 ? 'ren' : '');
                if ($flight->infants > 0) $breakdown[] = $flight->infants . ' Infant' . ($flight->infants > 1 ? 's' : '');
                
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $total . ' Total</div>';
                $html .= '<div class="text-gray-500 dark:text-gray-400">' . implode(', ', $breakdown) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('amount_info', function (BookingFlight $flight) {
                $html = '<div class="text-sm text-right">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">৳' . number_format($flight->total_amount, 2) . '</div>';
                
                if ($flight->taxes_fees > 0) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400">+৳' . number_format($flight->taxes_fees, 2) . ' tax</div>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->addColumn('ticket_info', function (BookingFlight $flight) {
                $html = '<div class="text-sm">';
                $html .= '<div>' . $flight->ticket_status_badge . '</div>';
                
                if ($flight->pnr_code) {
                    $html .= '<div class="text-gray-500 dark:text-gray-400 font-mono mt-1">PNR: ' . e($flight->pnr_code) . '</div>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->addColumn('actions', function (BookingFlight $flight) {
                $html = '<div class="flex items-center space-x-1">';
                
                // View button
                $html .= '<a href="' . route('booking::admin.booking-flights.show', $flight) . '" 
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200 dark:bg-blue-800 dark:text-blue-200 dark:hover:bg-blue-700" 
                            title="View Details">';
                $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
                
                // Edit button (only for pending/issued tickets)
                if (in_array($flight->ticket_status, ['pending', 'issued'])) {
                    $html .= '<a href="' . route('booking::admin.booking-flights.edit', $flight) . '" 
                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200 dark:bg-yellow-800 dark:text-yellow-200 dark:hover:bg-yellow-700" 
                                title="Edit Flight">';
                    $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                    $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>';
                    $html .= '</svg>';
                    $html .= '</a>';
                }
                
                // Main booking link
                $html .= '<a href="' . route('booking::admin.bookings.show', $flight->booking) . '" 
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500" 
                            title="View Main Booking">';
                $html .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>';
                $html .= '</svg>';
                $html .= '</a>';
                
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['booking_info', 'flight_info', 'trip_details', 'departure_info', 'arrival_info', 'passengers_info', 'amount_info', 'ticket_info', 'actions'])
            ->make(true);
    }

    /**
     * Display the specified flight booking.
     */
    public function show(BookingFlight $bookingFlight)
    {
        $bookingFlight->load(['booking.user']);
        
        return view('booking::admin.booking-flights.show', compact('bookingFlight'));
    }

    /**
     * Show the form for editing the specified flight booking.
     */
    public function edit(BookingFlight $bookingFlight)
    {
        $bookingFlight->load(['booking']);
        
        return view('booking::admin.booking-flights.edit', compact('bookingFlight'));
    }

    /**
     * Update the specified flight booking.
     */
    public function update(Request $request, BookingFlight $bookingFlight)
    {
        $request->validate([
            'trip_type' => 'required|in:oneway,roundtrip',
            'cabin_class' => 'required|in:economy,business,first',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:20',
            'infants' => 'nullable|integer|min:0|max:20',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'taxes_fees' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'pnr_code' => 'nullable|string|max:20',
            'ticket_numbers' => 'nullable|string|max:500',
            'ticket_status' => 'required|in:pending,issued,cancelled,refunded',
            'departure_datetime' => 'required|date',
            'arrival_datetime' => 'required|date|after:departure_datetime',
            'departure_airport' => 'required|string|max:10',
            'arrival_airport' => 'required|string|max:10',
            'airline_code' => 'required|string|max:10',
            'flight_number' => 'required|string|max:20',
        ]);

        $bookingFlight->update([
            'trip_type' => $request->trip_type,
            'cabin_class' => $request->cabin_class,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'infants' => $request->infants ?? 0,
            'adult_price' => $request->adult_price,
            'child_price' => $request->child_price,
            'infant_price' => $request->infant_price,
            'taxes_fees' => $request->taxes_fees ?? 0,
            'total_amount' => $request->total_amount,
            'pnr_code' => $request->pnr_code,
            'ticket_numbers' => $request->ticket_numbers,
            'ticket_status' => $request->ticket_status,
            'departure_datetime' => $request->departure_datetime,
            'arrival_datetime' => $request->arrival_datetime,
            'departure_airport' => $request->departure_airport,
            'arrival_airport' => $request->arrival_airport,
            'airline_code' => $request->airline_code,
            'flight_number' => $request->flight_number,
        ]);

        return redirect()->route('booking::admin.booking-flights.show', $bookingFlight)
                        ->with('success', 'Flight booking updated successfully.');
    }

    /**
     * Remove the specified flight booking.
     */
    public function destroy(BookingFlight $bookingFlight)
    {
        try {
            $bookingId = $bookingFlight->booking_id;
            $bookingFlight->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Flight booking deleted successfully.',
                'redirect' => route('booking::admin.bookings.show', $bookingId)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete flight booking: ' . $e->getMessage()
            ], 500);
        }
    }
}