<?php

namespace Modules\Flight\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ApiService\Services\FlightApiService;

class DynamicFlightController extends Controller
{
    protected FlightApiService $flightApiService;

    public function __construct()
    {
        $this->flightApiService = \Modules\ApiService\ApiServiceManager::flight();
    }

    /**
     * Display the dynamic flight search page with Volt component
     */
    public function index()
    {
        return view('flight::dynamic.index');
    }

    /**
     * Handle flight search requests
     */
    public function search(Request $request)
    {
        $request->validate([
            'departure_city' => 'required|string|max:100',
            'arrival_city' => 'required|string|max:100',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after:departure_date',
            'passengers' => 'required|integer|min:1|max:9',
            'class' => 'required|in:economy,business,first'
        ]);

        $searchParams = [
            'departure_city' => $request->departure_city,
            'arrival_city' => $request->arrival_city,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'passengers' => $request->passengers,
            'class' => $request->class,
            'trip_type' => $request->return_date ? 'roundtrip' : 'oneway'
        ];

        $results = $this->flightApiService->searchFlights($searchParams);

        if (isset($results['error'])) {
            return back()->withErrors(['search' => $results['error']])->withInput();
        }

        return view('flight::dynamic.results', [
            'results' => $results,
            'searchParams' => $searchParams
        ]);
    }

    /**
     * Show flight details
     */
    public function show(string $id)
    {
        $flight = $this->flightApiService->getFlightDetails($id);

        if (isset($flight['error'])) {
            abort(404, $flight['error']);
        }

        return view('flight::dynamic.show', [
            'flight' => $flight
        ]);
    }
}