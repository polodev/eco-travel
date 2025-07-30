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
        return view('flight::schedules.index');
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
                if ($request->has('flight_id') && $request->get('flight_id') !== '') {
                    $query->where('flight_id', $request->get('flight_id'));
                }

                // Date range filter
                if ($request->has('start_date') && $request->get('start_date')) {
                    $query->where('departure_datetime', '>=', $request->get('start_date'));
                }
                if ($request->has('end_date') && $request->get('end_date')) {
                    $query->where('departure_datetime', '<=', $request->get('end_date'));
                }

                // Status filter
                if ($request->has('status') && $request->get('status') !== '') {
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
                $html .= Carbon::parse($schedule->departure_datetime)->format('M j, Y');
                $html .= '</div>';
                $html .= '<div class="flex items-center space-x-2 text-xs text-gray-500">';
                $html .= '<span>' . Carbon::parse($schedule->departure_datetime)->format('H:i') . '</span>';
                $html .= '<span>→</span>';
                $html .= '<span>' . Carbon::parse($schedule->arrival_datetime)->format('H:i') . '</span>';
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
                $totalSeats = $schedule->flight->economy_seats + $schedule->flight->business_seats + $schedule->flight->first_class_seats;
                $availableSeats = $schedule->available_economy + $schedule->available_business + $schedule->available_first;
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
                       '<a href="' . route('flight-schedules.show', $schedule->id) . '" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>' .
                       '<a href="' . route('flight-schedules.edit', $schedule->id) . '" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>' .
                       '<button type="button" onclick="deleteSchedule(' . $schedule->id . ')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>' .
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
            'departure_datetime' => 'required|date|after:now',
            'arrival_datetime' => 'required|date|after:departure_datetime',
            'economy_price' => 'required|numeric|min:0',
            'business_price' => 'nullable|numeric|min:0',
            'first_class_price' => 'nullable|numeric|min:0',
            'available_economy' => 'required|integer|min:0',
            'available_business' => 'nullable|integer|min:0',
            'available_first' => 'nullable|integer|min:0',
            'gate' => 'nullable|string|max:10',
            'terminal' => 'nullable|string|max:10',
            'check_in_counter' => 'nullable|string|max:20',
            'baggage_claim' => 'nullable|string|max:20',
            'status' => 'required|in:scheduled,boarding,departed,arrived,delayed,cancelled',
            'delay_minutes' => 'nullable|integer|min:0',
            'delay_reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        FlightSchedule::create($validatedData);

        return redirect()->route('flight-schedules.index')
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
            'departure_datetime' => 'required|date',
            'arrival_datetime' => 'required|date|after:departure_datetime',
            'economy_price' => 'required|numeric|min:0',
            'business_price' => 'nullable|numeric|min:0',
            'first_class_price' => 'nullable|numeric|min:0',
            'available_economy' => 'required|integer|min:0',
            'available_business' => 'nullable|integer|min:0',
            'available_first' => 'nullable|integer|min:0',
            'gate' => 'nullable|string|max:10',
            'terminal' => 'nullable|string|max:10',
            'check_in_counter' => 'nullable|string|max:20',
            'baggage_claim' => 'nullable|string|max:20',
            'status' => 'required|in:scheduled,boarding,departed,arrived,delayed,cancelled',
            'delay_minutes' => 'nullable|integer|min:0',
            'delay_reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $flightSchedule->update($validatedData);

        return redirect()->route('flight-schedules.index')
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
            'status' => 'required|in:scheduled,boarding,departed,arrived,delayed,cancelled',
            'delay_minutes' => 'nullable|integer|min:0',
            'delay_reason' => 'nullable|string',
        ]);

        $flightSchedule->update([
            'status' => $request->status,
            'delay_minutes' => $request->delay_minutes,
            'delay_reason' => $request->delay_reason,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Flight schedule status updated successfully.'
        ]);
    }
}