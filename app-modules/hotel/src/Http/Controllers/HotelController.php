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
        return view('hotel::hotels.index');
    }

    public function indexJson(Request $request)
    {
        $model = Hotel::with(['country', 'city'])->withCount(['rooms']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('description', 'like', "%{$searchText}%")
                          ->orWhereHas('city', function ($cityQuery) use ($searchText) {
                              $cityQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }
                if ($request->has('star_rating') && $request->get('star_rating') !== '') {
                    $query->where('star_rating', $request->get('star_rating'));
                }
                if ($request->has('is_active') && $request->get('is_active') !== '') {
                    $query->where('is_active', $request->boolean('is_active'));
                }
            }, true)
            ->addColumn('hotel_info', function (Hotel $hotel) {
                $html = '<div class="flex items-center">';
                if ($hotel->featured_image) {
                    $html .= '<img src="' . htmlspecialchars($hotel->featured_image) . '" alt="' . htmlspecialchars($hotel->name) . '" class="w-12 h-8 mr-3 rounded object-cover">';
                }
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($hotel->name) . '</div>';
                $html .= '<div class="text-sm text-gray-500 dark:text-gray-400">' . str_repeat('★', $hotel->star_rating) . '</div>';
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('location', function (Hotel $hotel) {
                return htmlspecialchars($hotel->city->name . ', ' . $hotel->country->name);
            })
            ->addColumn('status_badge', function (Hotel $hotel) {
                return $hotel->status_badge;
            })
            ->addColumn('actions', function (Hotel $hotel) {
                return '<div class="flex items-center space-x-2">' .
                       '<a href="' . route('hotels.show', $hotel->id) . '" class="text-blue-600 hover:text-blue-900">View</a>' .
                       '<a href="' . route('hotels.edit', $hotel->id) . '" class="text-indigo-600 hover:text-indigo-900">Edit</a>' .
                       '<button type="button" onclick="deleteHotel(' . $hotel->id . ')" class="text-red-600 hover:text-red-900">Delete</button>' .
                       '</div>';
            })
            ->rawColumns(['hotel_info', 'status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        return view('hotel::hotels.create', compact('countries', 'cities'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'star_rating' => 'required|integer|min:1|max:5',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
        ]);

        Hotel::create($validatedData);
        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show(Hotel $hotel)
    {
        $hotel->load(['country', 'city', 'rooms']);
        return view('hotel::hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        return view('hotel::hotels.edit', compact('hotel', 'countries', 'cities'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'star_rating' => 'required|integer|min:1|max:5',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'is_active' => 'boolean',
        ]);

        $hotel->update($validatedData);
        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
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