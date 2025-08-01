<?php

namespace Modules\Hotel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Hotel\Models\Hotel;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Yajra\DataTables\Facades\DataTables;

class HotelController extends Controller
{
    public function index()
    {
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::active()->orderBy('name')->get();
        return view('hotel::hotels.index', compact('countries', 'cities'));
    }

    public function indexJson(Request $request)
    {
        $model = Hotel::with(['country', 'city'])->withCount(['rooms']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->filled('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('description', 'like', "%{$searchText}%")
                          ->orWhere('address', 'like', "%{$searchText}%")
                          ->orWhereHas('city', function ($cityQuery) use ($searchText) {
                              $cityQuery->where('name', 'like', "%{$searchText}%");
                          })
                          ->orWhereHas('country', function ($countryQuery) use ($searchText) {
                              $countryQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }
                if ($request->filled('country_id')) {
                    $query->where('country_id', $request->get('country_id'));
                }
                if ($request->filled('city_id')) {
                    $query->where('city_id', $request->get('city_id'));
                }
                if ($request->filled('star_rating')) {
                    $query->where('star_rating', $request->get('star_rating'));
                }
                if ($request->filled('is_active')) {
                    $query->where('is_active', $request->boolean('is_active'));
                }
                if ($request->filled('is_featured')) {
                    $query->where('is_featured', $request->boolean('is_featured'));
                }
            }, true)
            ->addColumn('name_formatted', function (Hotel $hotel) {
                $html = '<div class="flex items-center">';
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($hotel->name) . '</div>';
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($hotel->address) . '</div>';
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('location_info', function (Hotel $hotel) {
                return '<div class="text-sm">' . 
                       '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($hotel->city->name) . '</div>' .
                       '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($hotel->country->name) . '</div>' .
                       '</div>';
            })
            ->addColumn('star_rating_display', function (Hotel $hotel) {
                return '<div class="text-center text-yellow-400">' . $hotel->star_rating_display . '</div>';
            })
            ->addColumn('amenities_display', function (Hotel $hotel) {
                return $hotel->amenities_display;
            })
            ->addColumn('status_badges', function (Hotel $hotel) {
                $badges = '<div class="flex flex-col items-center space-y-1">';
                $badges .= $hotel->status_badge;
                if ($hotel->is_featured) {
                    $badges .= '<div>' . $hotel->featured_badge . '</div>';
                }
                $badges .= '</div>';
                return $badges;
            })
            ->addColumn('created_at_formatted', function (Hotel $hotel) {
                return $hotel->created_at->format('M d, Y');
            })
            ->addColumn('action', function (Hotel $hotel) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('hotel::admin.hotels.show', $hotel) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('hotel::admin.hotels.edit', $hotel) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['name_formatted', 'location_info', 'star_rating_display', 'amenities_display', 'status_badges', 'action'])
            ->make(true);
    }

    public function create()
    {
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::active()->orderBy('name')->get();
        return view('hotel::hotels.create', compact('countries', 'cities'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'star_rating' => 'required|integer|min:1|max:5',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'checkin_time' => 'nullable|date_format:H:i',
            'checkout_time' => 'nullable|date_format:H:i',
            'distance_from_airport' => 'nullable|numeric|min:0',
            'distance_from_city_center' => 'nullable|numeric|min:0',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Convert time strings to datetime for storage
        if ($validatedData['checkin_time'] ?? null) {
            $validatedData['checkin_time'] = now()->setTimeFromTimeString($validatedData['checkin_time'])->format('H:i:s');
        }
        if ($validatedData['checkout_time'] ?? null) {
            $validatedData['checkout_time'] = now()->setTimeFromTimeString($validatedData['checkout_time'])->format('H:i:s');
        }

        Hotel::create($validatedData);
        return redirect()->route('hotel::admin.hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show(Hotel $hotel)
    {
        $hotel->load(['country', 'city', 'rooms']);
        return view('hotel::hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::active()->orderBy('name')->get();
        return view('hotel::hotels.edit', compact('hotel', 'countries', 'cities'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'star_rating' => 'required|integer|min:1|max:5',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'checkin_time' => 'nullable|date_format:H:i',
            'checkout_time' => 'nullable|date_format:H:i',
            'distance_from_airport' => 'nullable|numeric|min:0',
            'distance_from_city_center' => 'nullable|numeric|min:0',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Convert time strings to datetime for storage
        if ($validatedData['checkin_time'] ?? null) {
            $validatedData['checkin_time'] = now()->setTimeFromTimeString($validatedData['checkin_time'])->format('H:i:s');
        }
        if ($validatedData['checkout_time'] ?? null) {
            $validatedData['checkout_time'] = now()->setTimeFromTimeString($validatedData['checkout_time'])->format('H:i:s');
        }

        $hotel->update($validatedData);
        return redirect()->route('hotel::admin.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel)
    {
        try {
            $hotel->delete();
            return response()->json(['success' => true, 'message' => 'Hotel deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting hotel: ' . $e->getMessage()], 500);
        }
    }
}