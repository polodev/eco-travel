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
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        
        return view('flight::airlines.index', compact('countries'));
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
                          ->orWhere('code', 'like', "%{$searchText}%")
                          ->orWhere('icao_code', 'like', "%{$searchText}%")
                          ->orWhereHas('country', function ($countryQuery) use ($searchText) {
                              $countryQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }

                // Country filter
                if ($request->has('country_id') && $request->get('country_id') !== '' && $request->get('country_id') !== null && $request->get('country_id') !== 'null') {
                    $query->where('country_id', $request->get('country_id'));
                }

                // Active filter
                if ($request->has('is_active') && $request->get('is_active') !== '' && $request->get('is_active') !== null && $request->get('is_active') !== 'null') {
                    $query->where('is_active', $request->get('is_active') === '1' || $request->get('is_active') === 'true');
                }
            }, true)
            ->addColumn('name_formatted', function (Airline $airline) {
                $html = '<div class="flex items-center">';
                if ($airline->hasLogo()) {
                    $html .= '<img src="' . htmlspecialchars($airline->logo_thumb_url) . '" alt="' . htmlspecialchars($airline->name) . '" class="w-8 h-8 mr-3 rounded object-cover">';
                }
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($airline->name) . '</div>';
                $html .= '<div class="text-sm text-gray-500 dark:text-gray-400">' . htmlspecialchars($airline->code . ' / ' . $airline->icao_code) . '</div>';
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
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('flight::admin.airlines.show', $airline->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('flight::admin.airlines.edit', $airline->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                return $actions;
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
            'code' => 'required|string|max:3|unique:airlines',
            'icao_code' => 'required|string|size:4|unique:airlines',
            'country_id' => 'required|exists:countries,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'headquarters' => 'nullable|string|max:255',
            'founded' => 'nullable|integer|min:1900|max:' . date('Y'),
            'alliance' => 'nullable|in:star_alliance,oneworld,skyteam,none',
            'is_active' => 'boolean',
            'is_low_cost' => 'boolean',
            'operating_countries' => 'nullable|array',
            'position' => 'nullable|integer|min:0',
        ]);

        $airline = Airline::create($validatedData);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $airline->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('flight::admin.airlines.index')
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
            'code' => 'required|string|max:3|unique:airlines,code,' . $airline->id,
            'icao_code' => 'required|string|size:4|unique:airlines,icao_code,' . $airline->id,
            'country_id' => 'required|exists:countries,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'headquarters' => 'nullable|string|max:255',
            'founded' => 'nullable|integer|min:1900|max:' . date('Y'),
            'alliance' => 'nullable|in:star_alliance,oneworld,skyteam,none',
            'is_active' => 'boolean',
            'is_low_cost' => 'boolean',
            'operating_countries' => 'nullable|array',
            'position' => 'nullable|integer|min:0',
        ]);

        $airline->update($validatedData);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $airline->clearMediaCollection('logo');
            $airline->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('flight::admin.airlines.index')
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