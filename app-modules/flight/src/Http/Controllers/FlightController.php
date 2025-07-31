<?php

namespace Modules\Flight\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Airline;
use Modules\Location\Models\Airport;
use Yajra\DataTables\Facades\DataTables;

class FlightController extends Controller
{
    /**
     * Display a listing of the flights.
     */
    public function index()
    {
        $airlines = Airline::where('is_active', true)->orderBy('name')->get();
        $airports = Airport::with('city')->orderBy('name')->get();
        
        return view('flight::flights.index', compact('airlines', 'airports'));
    }

    /**
     * Get flight data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
                      ->withCount(['schedules']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('flight_number', 'like', "%{$searchText}%")
                          ->orWhere('aircraft_type', 'like', "%{$searchText}%")
                          ->orWhereHas('airline', function ($airlineQuery) use ($searchText) {
                              $airlineQuery->where('name', 'like', "%{$searchText}%");
                          })
                          ->orWhereHas('departureAirport', function ($airportQuery) use ($searchText) {
                              $airportQuery->where('name', 'like', "%{$searchText}%")
                                          ->orWhere('iata_code', 'like', "%{$searchText}%");
                          })
                          ->orWhereHas('arrivalAirport', function ($airportQuery) use ($searchText) {
                              $airportQuery->where('name', 'like', "%{$searchText}%")
                                          ->orWhere('iata_code', 'like', "%{$searchText}%");
                          });
                    });
                }

                // Airline filter
                if ($request->has('airline_id') && $request->get('airline_id') !== '' && $request->get('airline_id') !== null) {
                    $query->where('airline_id', $request->get('airline_id'));
                }

                // Route filter
                if ($request->has('departure_airport_id') && $request->get('departure_airport_id') !== '' && $request->get('departure_airport_id') !== null) {
                    $query->where('departure_airport_id', $request->get('departure_airport_id'));
                }
                if ($request->has('arrival_airport_id') && $request->get('arrival_airport_id') !== '' && $request->get('arrival_airport_id') !== null) {
                    $query->where('arrival_airport_id', $request->get('arrival_airport_id'));
                }

                // Active filter
                if ($request->has('is_active') && $request->get('is_active') !== '' && $request->get('is_active') !== null) {
                    $query->where('is_active', $request->boolean('is_active'));
                }
            }, true)
            ->addColumn('flight_info', function (Flight $flight) {
                $html = '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($flight->airline->name . ' ' . $flight->flight_number) . '</div>';
                $html .= '<div class="text-sm text-gray-500 dark:text-gray-400">' . htmlspecialchars($flight->aircraft_type) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('route', function (Flight $flight) {
                $html = '<div class="text-sm">';
                $html .= '<div class="flex items-center">';
                $html .= '<span class="font-medium">' . htmlspecialchars($flight->departureAirport->iata_code) . '</span>';
                $html .= '<svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>';
                $html .= '</svg>';
                $html .= '<span class="font-medium">' . htmlspecialchars($flight->arrivalAirport->iata_code) . '</span>';
                $html .= '</div>';
                $html .= '<div class="text-xs text-gray-500 mt-1">';
                $html .= htmlspecialchars($flight->departureAirport->city->name . ' → ' . $flight->arrivalAirport->city->name);
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('duration_formatted', function (Flight $flight) {
                $hours = floor($flight->duration_minutes / 60);
                $minutes = $flight->duration_minutes % 60;
                return $hours . 'h ' . $minutes . 'm';
            })
            ->addColumn('capacity_info', function (Flight $flight) {
                $total = $flight->economy_seats + $flight->business_seats + $flight->first_seats;
                return '<div class="text-sm">' .
                       '<div>Total: ' . $total . ' seats</div>' .
                       '<div class="text-xs text-gray-500">E:' . $flight->economy_seats . ' | B:' . $flight->business_seats . ' | F:' . $flight->first_seats . '</div>' .
                       '</div>';
            })
            ->addColumn('status_badge', function (Flight $flight) {
                return $flight->status_badge;
            })
            ->addColumn('schedules_count', function (Flight $flight) {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">' . $flight->schedules_count . ' schedules</span>';
            })
            ->addColumn('actions', function (Flight $flight) {
                return '<div class="flex items-center space-x-2">' .
                       '<a href="' . route('admin-dashboard.flight.flights.show', $flight->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">' .
                           '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">' .
                               '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>' .
                               '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>' .
                           '</svg>' .
                       '</a>' .
                       '<a href="' . route('admin-dashboard.flight.flights.edit', $flight->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">' .
                           '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">' .
                               '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>' .
                           '</svg>' .
                       '</a>' .
                       '</div>';
            })
            ->rawColumns(['flight_info', 'route', 'capacity_info', 'status_badge', 'schedules_count', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new flight.
     */
    public function create()
    {
        $airlines = Airline::active()->orderBy('name')->get();
        $airports = Airport::with('city')->orderBy('name')->get();
        
        return view('flight::flights.create', compact('airlines', 'airports'));
    }

    /**
     * Store a newly created flight in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'flight_number' => 'required|string|max:10',
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
            'departure_time' => 'nullable|date_format:H:i',
            'arrival_time' => 'nullable|date_format:H:i',
            'duration_minutes' => 'required|integer|min:1',
            'aircraft_type' => 'required|in:boeing_737,boeing_777,airbus_a320,airbus_a330,dash_8,atr_72,other',
            'operating_days' => 'nullable|array',
            'flight_type' => 'required|in:domestic,international,regional',
            'economy_seats' => 'nullable|integer|min:0',
            'business_seats' => 'nullable|integer|min:0',
            'first_seats' => 'nullable|integer|min:0',
            'total_seats' => 'nullable|integer|min:0',
            'base_price' => 'nullable|numeric|min:0',
            'baggage_allowance' => 'nullable|array',
            'has_meal' => 'boolean',
            'has_wifi' => 'boolean',
            'has_entertainment' => 'boolean',
            'is_active' => 'boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        Flight::create($validatedData);

        return redirect()->route('admin-dashboard.flight.flights.index')
                        ->with('success', 'Flight created successfully.');
    }

    /**
     * Display the specified flight.
     */
    public function show(Flight $flight)
    {
        $flight->load([
            'airline',
            'departureAirport.city.country',
            'arrivalAirport.city.country',
            'schedules' => function ($query) {
                $query->upcoming()->with(['flight'])->take(10);
            }
        ]);

        return view('flight::flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified flight.
     */
    public function edit(Flight $flight)
    {
        $airlines = Airline::active()->orderBy('name')->get();
        $airports = Airport::with('city')->orderBy('name')->get();
        
        return view('flight::flights.edit', compact('flight', 'airlines', 'airports'));
    }

    /**
     * Update the specified flight in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        $validatedData = $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'flight_number' => 'required|string|max:10|unique:flights,flight_number,' . $flight->id . ',id,airline_id,' . $request->airline_id,
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
            'departure_time' => 'nullable|date_format:H:i',
            'arrival_time' => 'nullable|date_format:H:i',
            'duration_minutes' => 'required|integer|min:1',
            'aircraft_type' => 'required|in:boeing_737,boeing_777,airbus_a320,airbus_a330,dash_8,atr_72,other',
            'operating_days' => 'nullable|array',
            'flight_type' => 'required|in:domestic,international,regional',
            'economy_seats' => 'nullable|integer|min:0',
            'business_seats' => 'nullable|integer|min:0',
            'first_seats' => 'nullable|integer|min:0',
            'total_seats' => 'nullable|integer|min:0',
            'base_price' => 'nullable|numeric|min:0',
            'baggage_allowance' => 'nullable|array',
            'has_meal' => 'boolean',
            'has_wifi' => 'boolean',
            'has_entertainment' => 'boolean',
            'is_active' => 'boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        $flight->update($validatedData);

        return redirect()->route('admin-dashboard.flight.flights.index')
                        ->with('success', 'Flight updated successfully.');
    }

    /**
     * Remove the specified flight from storage.
     */
    public function destroy(Flight $flight)
    {
        try {
            $flight->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Flight deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting flight: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle flight active status.
     */
    public function toggleActive(Flight $flight)
    {
        $flight->update(['is_active' => !$flight->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $flight->is_active,
            'message' => $flight->is_active ? 'Flight activated.' : 'Flight deactivated.'
        ]);
    }
}