<?php

namespace Modules\Flight\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Flight\Models\FlightSchedule;
use Modules\Flight\Models\Flight;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class FlightScheduleController extends Controller
{
    /**
     * Display a listing of the flight schedules.
     */
    public function index()
    {
        $flights = Flight::with(['airline', 'departureAirport.city', 'arrivalAirport.city'])
                        ->where('is_active', true)
                        ->orderBy('flight_number')
                        ->get();
        
        return view('flight::schedules.index', compact('flights'));
    }

    /**
     * Get flight schedule data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = FlightSchedule::with([
            'flight.airline',
            'flight.departureAirport.city',
            'flight.arrivalAirport.city'
        ]);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->whereHas('flight', function ($flightQuery) use ($searchText) {
                        $flightQuery->where('flight_number', 'like', "%{$searchText}%")
                                   ->orWhereHas('airline', function ($airlineQuery) use ($searchText) {
                                       $airlineQuery->where('name', 'like', "%{$searchText}%");
                                   });
                    });
                }

                // Flight filter
                if ($request->has('flight_id') && $request->get('flight_id') !== '' && $request->get('flight_id') !== null) {
                    $query->where('flight_id', $request->get('flight_id'));
                }

                // Date range filter
                if ($request->has('start_date') && $request->get('start_date') !== '' && $request->get('start_date') !== null) {
                    $query->where('scheduled_departure', '>=', $request->get('start_date'));
                }
                if ($request->has('end_date') && $request->get('end_date') !== '' && $request->get('end_date') !== null) {
                    $query->where('scheduled_departure', '<=', $request->get('end_date'));
                }

                // Status filter
                if ($request->has('status') && $request->get('status') !== '' && $request->get('status') !== null) {
                    $query->where('status', $request->get('status'));
                }
            }, true)
            ->addColumn('flight_info', function (FlightSchedule $schedule) {
                $html = '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">';
                $html .= htmlspecialchars($schedule->flight->airline->name . ' ' . $schedule->flight->flight_number);
                $html .= '</div>';
                $html .= '<div class="text-sm text-gray-500 dark:text-gray-400">';
                $html .= htmlspecialchars($schedule->flight->departureAirport->city->name . ' → ' . $schedule->flight->arrivalAirport->city->name);
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('schedule_info', function (FlightSchedule $schedule) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium">';
                $html .= Carbon::parse($schedule->scheduled_departure)->format('M j, Y');
                $html .= '</div>';
                $html .= '<div class="flex items-center space-x-2 text-xs text-gray-500">';
                $html .= '<span>' . Carbon::parse($schedule->scheduled_departure)->format('H:i') . '</span>';
                $html .= '<span>→</span>';
                $html .= '<span>' . Carbon::parse($schedule->scheduled_arrival)->format('H:i') . '</span>';
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('pricing', function (FlightSchedule $schedule) {
                $html = '<div class="text-sm">';
                $html .= '<div class="font-medium">৳' . number_format($schedule->economy_price, 0) . '</div>';
                if ($schedule->business_price) {
                    $html .= '<div class="text-xs text-gray-500">Bus: ৳' . number_format($schedule->business_price, 0) . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('availability', function (FlightSchedule $schedule) {
                $totalSeats = $schedule->flight->economy_seats + $schedule->flight->business_seats + $schedule->flight->first_seats;
                $availableSeats = $schedule->available_economy_seats + $schedule->available_business_seats + $schedule->available_first_seats;
                $percentage = $totalSeats > 0 ? round(($availableSeats / $totalSeats) * 100) : 0;
                
                $colorClass = $percentage > 70 ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                             ($percentage > 30 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' :
                              'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100');
                
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $colorClass . '">' .
                       $availableSeats . '/' . $totalSeats . ' (' . $percentage . '%)</span>';
            })
            ->addColumn('status_badge', function (FlightSchedule $schedule) {
                return $schedule->status_badge;
            })
            ->addColumn('actions', function (FlightSchedule $schedule) {
                return '<div class="flex items-center space-x-2">' .
                       '<a href="' . route('admin-dashboard.flight.flight-schedules.show', $schedule->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">' .
                           '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">' .
                               '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>' .
                               '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>' .
                           '</svg>' .
                       '</a>' .
                       '<a href="' . route('admin-dashboard.flight.flight-schedules.edit', $schedule->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">' .
                           '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">' .
                               '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>' .
                           '</svg>' .
                       '</a>' .
                       '</div>';
            })
            ->rawColumns(['flight_info', 'schedule_info', 'pricing', 'availability', 'status_badge', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new flight schedule.
     */
    public function create()
    {
        $flights = Flight::with(['airline', 'departureAirport.city', 'arrivalAirport.city'])
                        ->active()
                        ->orderBy('flight_number')
                        ->get();
        
        return view('flight::schedules.create', compact('flights'));
    }

    /**
     * Store a newly created flight schedule in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'flight_date' => 'required|date|after_or_equal:today',
            'scheduled_departure' => 'required|date|after:now',
            'scheduled_arrival' => 'required|date|after:scheduled_departure',
            'economy_price' => 'required|numeric|min:0',
            'business_price' => 'nullable|numeric|min:0',
            'first_price' => 'nullable|numeric|min:0',
            'available_economy_seats' => 'required|integer|min:0',
            'available_business_seats' => 'required|integer|min:0',
            'available_first_seats' => 'required|integer|min:0',
            'gate' => 'nullable|string|max:10',
            'terminal' => 'nullable|string|max:10',
            'status' => 'required|in:scheduled,delayed,cancelled,departed,arrived,diverted',
            'delay_minutes' => 'nullable|integer|min:0',
            'meal_options' => 'nullable|array',
            'notes' => 'nullable|string',
            'is_available_for_booking' => 'boolean',
        ]);

        FlightSchedule::create($validatedData);

        return redirect()->route('admin-dashboard.flight.flight-schedules.index')
                        ->with('success', 'Flight schedule created successfully.');
    }

    /**
     * Display the specified flight schedule.
     */
    public function show(FlightSchedule $flightSchedule)
    {
        $flightSchedule->load([
            'flight.airline',
            'flight.departureAirport.city.country',
            'flight.arrivalAirport.city.country'
        ]);

        return view('flight::schedules.show', compact('flightSchedule'));
    }

    /**
     * Show the form for editing the specified flight schedule.
     */
    public function edit(FlightSchedule $flightSchedule)
    {
        $flights = Flight::with(['airline', 'departureAirport.city', 'arrivalAirport.city'])
                        ->active()
                        ->orderBy('flight_number')
                        ->get();
        
        return view('flight::schedules.edit', compact('flightSchedule', 'flights'));
    }

    /**
     * Update the specified flight schedule in storage.
     */
    public function update(Request $request, FlightSchedule $flightSchedule)
    {
        $validatedData = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'flight_date' => 'required|date',
            'scheduled_departure' => 'required|date',
            'scheduled_arrival' => 'required|date|after:scheduled_departure',
            'economy_price' => 'required|numeric|min:0',
            'business_price' => 'nullable|numeric|min:0',
            'first_price' => 'nullable|numeric|min:0',
            'available_economy_seats' => 'required|integer|min:0',
            'available_business_seats' => 'required|integer|min:0',
            'available_first_seats' => 'required|integer|min:0',
            'gate' => 'nullable|string|max:10',
            'terminal' => 'nullable|string|max:10',
            'status' => 'required|in:scheduled,delayed,cancelled,departed,arrived,diverted',
            'delay_minutes' => 'nullable|integer|min:0',
            'meal_options' => 'nullable|array',
            'notes' => 'nullable|string',
            'is_available_for_booking' => 'boolean',
        ]);

        $flightSchedule->update($validatedData);

        return redirect()->route('admin-dashboard.flight.flight-schedules.index')
                        ->with('success', 'Flight schedule updated successfully.');
    }

    /**
     * Remove the specified flight schedule from storage.
     */
    public function destroy(FlightSchedule $flightSchedule)
    {
        try {
            $flightSchedule->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Flight schedule deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting flight schedule: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update flight schedule status.
     */
    public function updateStatus(Request $request, FlightSchedule $flightSchedule)
    {
        $request->validate([
            'status' => 'required|in:scheduled,delayed,cancelled,departed,arrived,diverted',
            'delay_minutes' => 'nullable|integer|min:0',
        ]);

        $flightSchedule->update([
            'status' => $request->status,
            'delay_minutes' => $request->delay_minutes ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Flight schedule status updated successfully.'
        ]);
    }
}