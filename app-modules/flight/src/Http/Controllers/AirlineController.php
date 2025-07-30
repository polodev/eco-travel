<?php

namespace Modules\Flight\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Flight\Models\Airline;
use Modules\Location\Models\Country;
use Yajra\DataTables\Facades\DataTables;

class AirlineController extends Controller
{
    /**
     * Display a listing of the airlines.
     */
    public function index()
    {
        return view('flight::airlines.index');
    }

    /**
     * Get airline data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Airline::with('country')->withCount(['flights']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('iata_code', 'like', "%{$searchText}%")
                          ->orWhere('icao_code', 'like', "%{$searchText}%")
                          ->orWhereHas('country', function ($countryQuery) use ($searchText) {
                              $countryQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }

                // Country filter
                if ($request->has('country_id') && $request->get('country_id') !== '') {
                    $query->where('country_id', $request->get('country_id'));
                }

                // Active filter
                if ($request->has('is_active') && $request->get('is_active') !== '') {
                    $query->where('is_active', $request->boolean('is_active'));
                }
            }, true)
            ->addColumn('name_formatted', function (Airline $airline) {
                $html = '<div class="flex items-center">';
                if ($airline->logo_url) {
                    $html .= '<img src="' . htmlspecialchars($airline->logo_url) . '" alt="' . htmlspecialchars($airline->name) . '" class="w-8 h-8 mr-3 rounded object-cover">';
                }
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($airline->name) . '</div>';
                $html .= '<div class="text-sm text-gray-500 dark:text-gray-400">' . htmlspecialchars($airline->iata_code . ' / ' . $airline->icao_code) . '</div>';
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('country_name', function (Airline $airline) {
                return $airline->country ? htmlspecialchars($airline->country->name) : 'N/A';
            })
            ->addColumn('status_badge', function (Airline $airline) {
                return $airline->status_badge;
            })
            ->addColumn('flights_count', function (Airline $airline) {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">' . $airline->flights_count . ' flights</span>';
            })
            ->addColumn('actions', function (Airline $airline) {
                return '<div class="flex items-center space-x-2">' .
                       '<a href="' . route('admin-dashboard.flight.airlines.show', $airline->id) . '" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>' .
                       '<a href="' . route('admin-dashboard.flight.airlines.edit', $airline->id) . '" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>' .
                       '<button type="button" onclick="deleteAirline(' . $airline->id . ')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>' .
                       '</div>';
            })
            ->rawColumns(['name_formatted', 'status_badge', 'flights_count', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new airline.
     */
    public function create()
    {
        $countries = Country::active()->orderBy('name')->get();
        
        return view('flight::airlines.create', compact('countries'));
    }

    /**
     * Store a newly created airline in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'iata_code' => 'required|string|size:2|unique:airlines',
            'icao_code' => 'required|string|size:3|unique:airlines',
            'country_id' => 'required|exists:countries,id',
            'logo_url' => 'nullable|url',
            'website_url' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'hub_airport' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'fleet_size' => 'nullable|integer|min:0',
            'destinations' => 'nullable|integer|min:0',
            'alliance' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Airline::create($validatedData);

        return redirect()->route('admin-dashboard.flight.airlines.index')
                        ->with('success', 'Airline created successfully.');
    }

    /**
     * Display the specified airline.
     */
    public function show(Airline $airline)
    {
        $airline->load(['country', 'flights' => function ($query) {
            $query->with(['departureAirport', 'arrivalAirport'])->take(10);
        }]);

        return view('flight::airlines.show', compact('airline'));
    }

    /**
     * Show the form for editing the specified airline.
     */
    public function edit(Airline $airline)
    {
        $countries = Country::active()->orderBy('name')->get();
        
        return view('flight::airlines.edit', compact('airline', 'countries'));
    }

    /**
     * Update the specified airline in storage.
     */
    public function update(Request $request, Airline $airline)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'iata_code' => 'required|string|size:2|unique:airlines,iata_code,' . $airline->id,
            'icao_code' => 'required|string|size:3|unique:airlines,icao_code,' . $airline->id,
            'country_id' => 'required|exists:countries,id',
            'logo_url' => 'nullable|url',
            'website_url' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'hub_airport' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'fleet_size' => 'nullable|integer|min:0',
            'destinations' => 'nullable|integer|min:0',
            'alliance' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $airline->update($validatedData);

        return redirect()->route('admin-dashboard.flight.airlines.index')
                        ->with('success', 'Airline updated successfully.');
    }

    /**
     * Remove the specified airline from storage.
     */
    public function destroy(Airline $airline)
    {
        try {
            $airline->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Airline deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting airline: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle airline active status.
     */
    public function toggleActive(Airline $airline)
    {
        $airline->update(['is_active' => !$airline->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $airline->is_active,
            'message' => $airline->is_active ? 'Airline activated.' : 'Airline deactivated.'
        ]);
    }
}