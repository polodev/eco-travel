<?php

namespace Modules\Hotel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ApiService\Services\HotelApiService;

class DynamicHotelController extends Controller
{
    protected HotelApiService $hotelApiService;

    public function __construct()
    {
        $this->hotelApiService = \Modules\ApiService\ApiServiceManager::hotel();
    }

    /**
     * Display the dynamic hotel search page with Volt component
     */
    public function index()
    {
        return view('hotel::dynamic.index');
    }

    /**
     * Handle hotel search requests
     */
    public function search(Request $request)
    {
        $request->validate([
            'destination' => 'required|string|max:100',
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'guests' => 'required|integer|min:1|max:8',
            'rooms' => 'required|integer|min:1|max:4',
            'star_rating' => 'nullable|integer|min:1|max:5'
        ]);

        $searchParams = [
            'destination' => $request->destination,
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'guests' => $request->guests,
            'rooms' => $request->rooms,
            'star_rating' => $request->star_rating,
            'price_range' => $request->price_range
        ];

        $results = $this->hotelApiService->searchHotels($searchParams);

        if (isset($results['error'])) {
            return back()->withErrors(['search' => $results['error']])->withInput();
        }

        return view('hotel::dynamic.results', [
            'results' => $results,
            'searchParams' => $searchParams
        ]);
    }

    /**
     * Show hotel details
     */
    public function show(string $id)
    {
        $hotel = $this->hotelApiService->getHotelDetails($id);

        if (isset($hotel['error'])) {
            abort(404, $hotel['error']);
        }

        return view('hotel::dynamic.show', [
            'hotel' => $hotel
        ]);
    }
}