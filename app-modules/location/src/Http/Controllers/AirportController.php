<?php

namespace Modules\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Location\Models\Airport;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Yajra\DataTables\Facades\DataTables;

class AirportController extends Controller
{
    /**
     * Display a listing of the airports.
     */
    public function index()
    {
        $countries = Country::active()->ordered()->get();
        $cities = City::active()->ordered()->get();
        $types = Airport::getAvailableTypes();
        return view('location::airports.index', compact('countries', 'cities', 'types'));
    }

    /**
     * Get airport data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Airport::with(['country', 'city']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('iata_code', 'like', "%{$searchText}%")
                          ->orWhere('icao_code', 'like', "%{$searchText}%")
                          ->orWhereHas('city', function ($cityQuery) use ($searchText) {
                              $cityQuery->where('name', 'like', "%{$searchText}%");
                          })
                          ->orWhereHas('country', function ($countryQuery) use ($searchText) {
                              $countryQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }

                // Country filter
                if ($request->has('country_id') && $request->get('country_id')) {
                    $query->where('country_id', $request->get('country_id'));
                }

                // City filter
                if ($request->has('city_id') && $request->get('city_id')) {
                    $query->where('city_id', $request->get('city_id'));
                }

                // Type filter
                if ($request->has('type') && $request->get('type')) {
                    $query->where('type', $request->get('type'));
                }

                // Active filter
                if ($request->filled('is_active')) {
                    $query->where('is_active', $request->boolean('is_active'));
                }

                // Hub filter
                if ($request->has('is_hub') && $request->get('is_hub') !== '') {
                    $query->where('is_hub', $request->boolean('is_hub'));
                }
            }, true)
            ->addColumn('name_formatted', function (Airport $airport) {
                return '<div class="font-medium">' . htmlspecialchars($airport->name) . '</div>';
            })
            ->addColumn('code_formatted', function (Airport $airport) {
                return '<div class="space-y-1">
                    <code class="px-2 py-1 bg-blue-100 dark:bg-blue-800 rounded text-sm font-bold">' . htmlspecialchars($airport->iata_code) . '</code>
                    <code class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-sm">' . htmlspecialchars($airport->icao_code) . '</code>
                </div>';
            })
            ->addColumn('city_name', function (Airport $airport) {
                return htmlspecialchars($airport->city->name);
            })
            ->addColumn('country_name', function (Airport $airport) {
                return htmlspecialchars($airport->country->name);
            })
            ->addColumn('created_at_formatted', function (Airport $airport) {
                return $airport->created_at->format('M d, Y');
            })
            ->addColumn('status_badge', function (Airport $airport) {
                return $airport->status_badge;
            })
            ->addColumn('type_badge', function (Airport $airport) {
                return $airport->type_badge;
            })
            ->addColumn('hub_badge', function (Airport $airport) {
                return $airport->hub_badge ?: '<span class="text-gray-400 text-sm">-</span>';
            })
            ->addColumn('action', function (Airport $airport) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('location::admin.airports.show', $airport->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('location::admin.airports.edit', $airport->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['name_formatted', 'code_formatted', 'status_badge', 'type_badge', 'hub_badge', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating new airport.
     */
    public function create()
    {
        $countries = Country::active()->ordered()->get();
        $types = Airport::getAvailableTypes();
        return view('location::airports.create', compact('countries', 'types'));
    }

    /**
     * Store a newly created airport.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'iata_code' => 'required|string|size:3|unique:airports,iata_code',
            'icao_code' => 'required|string|size:4|unique:airports,icao_code',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'nullable|string|max:255',
            'type' => 'required|in:international,domestic,regional',
            'is_active' => 'nullable|boolean',
            'is_hub' => 'nullable|boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        Airport::create($request->all());

        return redirect()->route('location::admin.airports.index')
                       ->with('success', 'Airport created successfully!');
    }

    /**
     * Display the specified airport.
     */
    public function show(Airport $airport)
    {
        $airport->load(['country', 'city']);
        return view('location::airports.show', compact('airport'));
    }

    /**
     * Show the form for editing the specified airport.
     */
    public function edit(Airport $airport)
    {
        $countries = Country::active()->ordered()->get();
        $cities = City::where('country_id', $airport->country_id)->active()->ordered()->get();
        $types = Airport::getAvailableTypes();
        return view('location::airports.edit', compact('airport', 'countries', 'cities', 'types'));
    }

    /**
     * Update the specified airport.
     */
    public function update(Request $request, Airport $airport)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'iata_code' => 'required|string|size:3|unique:airports,iata_code,' . $airport->id,
            'icao_code' => 'required|string|size:4|unique:airports,icao_code,' . $airport->id,
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'nullable|string|max:255',
            'type' => 'required|in:international,domestic,regional',
            'is_active' => 'nullable|boolean',
            'is_hub' => 'nullable|boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        $airport->update($request->all());

        return redirect()->route('location::admin.airports.show', $airport->id)
                       ->with('success', 'Airport updated successfully!');
    }

    /**
     * Remove the specified airport.
     */
    public function destroy(Airport $airport)
    {
        try {
            $airport->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Airport deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cities by country (AJAX).
     */
    public function getCitiesByCountry(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)
                     ->active()
                     ->ordered()
                     ->get(['id', 'name']);

        return response()->json($cities);
    }
}