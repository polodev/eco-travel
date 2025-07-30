<?php

namespace Modules\Tour\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourItinerary;
use Modules\Tour\Models\TourDate;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Yajra\DataTables\Facades\DataTables;

class TourController extends Controller
{
    /**
     * Display a listing of the tours.
     */
    public function index()
    {
        return view('tour::index');
    }

    /**
     * Get tour data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Tour::with(['country', 'city'])
                    ->withCount(['itineraries', 'tourDates']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('description', 'like', "%{$searchText}%")
                          ->orWhereHas('country', function ($countryQuery) use ($searchText) {
                              $countryQuery->where('name', 'like', "%{$searchText}%");
                          })
                          ->orWhereHas('city', function ($cityQuery) use ($searchText) {
                              $cityQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }

                // Tour type filter
                if ($request->has('tour_type') && $request->get('tour_type') !== '') {
                    $query->where('tour_type', $request->get('tour_type'));
                }

                // Difficulty level filter
                if ($request->has('difficulty_level') && $request->get('difficulty_level') !== '') {
                    $query->where('difficulty_level', $request->get('difficulty_level'));
                }

                // Active filter
                if ($request->has('is_active') && $request->get('is_active') !== '') {
                    $query->where('is_active', $request->boolean('is_active'));
                }

                // Featured filter
                if ($request->has('is_featured') && $request->get('is_featured') !== '') {
                    $query->where('is_featured', $request->boolean('is_featured'));
                }

                // Price range filter
                if ($request->has('min_price') && $request->get('min_price')) {
                    $query->where('base_price', '>=', $request->get('min_price'));
                }
                if ($request->has('max_price') && $request->get('max_price')) {
                    $query->where('base_price', '<=', $request->get('max_price'));
                }

                // Duration filter
                if ($request->has('min_duration') && $request->get('min_duration')) {
                    $query->where('duration_days', '>=', $request->get('min_duration'));
                }
                if ($request->has('max_duration') && $request->get('max_duration')) {
                    $query->where('duration_days', '<=', $request->get('max_duration'));
                }
            }, true)
            ->addColumn('name_formatted', function (Tour $tour) {
                $html = '<div class="flex items-center">';
                if ($tour->featured_image) {
                    $html .= '<img src="' . htmlspecialchars($tour->featured_image) . '" alt="' . htmlspecialchars($tour->name) . '" class="w-12 h-8 mr-3 rounded object-cover">';
                }
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($tour->name) . '</div>';
                if ($tour->is_featured) {
                    $html .= '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 mt-1">Featured</span>';
                }
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('destination', function (Tour $tour) {
                return htmlspecialchars($tour->city->name . ', ' . $tour->country->name);
            })
            ->addColumn('duration_formatted', function (Tour $tour) {
                return $tour->formatted_duration;
            })
            ->addColumn('price_formatted', function (Tour $tour) {
                return '৳' . number_format($tour->base_price, 2);
            })
            ->addColumn('tour_type_badge', function (Tour $tour) {
                return $tour->tour_type_badge;
            })
            ->addColumn('difficulty_badge', function (Tour $tour) {
                return $tour->difficulty_badge;
            })
            ->addColumn('availability_badge', function (Tour $tour) {
                return $tour->availability_badge;
            })
            ->addColumn('rating_formatted', function (Tour $tour) {
                $stars = str_repeat('★', floor($tour->rating));
                $halfStar = ($tour->rating - floor($tour->rating)) >= 0.5 ? '☆' : '';
                $emptyStars = str_repeat('☆', 5 - floor($tour->rating) - ($halfStar ? 1 : 0));
                
                return '<div class="flex items-center">' .
                       '<span class="text-yellow-400">' . $stars . $halfStar . '</span>' .
                       '<span class="text-gray-300">' . $emptyStars . '</span>' .
                       '<span class="ml-2 text-sm text-gray-600 dark:text-gray-400">(' . $tour->total_reviews . ')</span>' .
                       '</div>';
            })
            ->addColumn('status_badges', function (Tour $tour) {
                $html = '';
                if ($tour->is_active) {
                    $html .= '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 mr-1">Active</span>';
                } else {
                    $html .= '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 mr-1">Inactive</span>';
                }
                return $html;
            })
            ->addColumn('actions', function (Tour $tour) {
                return '<div class="flex items-center space-x-2">' .
                       '<a href="' . route('tours.show', $tour->id) . '" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>' .
                       '<a href="' . route('tours.edit', $tour->id) . '" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>' .
                       '<button type="button" onclick="deleteTour(' . $tour->id . ')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>' .
                       '</div>';
            })
            ->rawColumns(['name_formatted', 'tour_type_badge', 'difficulty_badge', 'availability_badge', 'rating_formatted', 'status_badges', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new tour.
     */
    public function create()
    {
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $tourTypes = Tour::getAvailableTourTypes();
        $difficultyLevels = Tour::getAvailableDifficultyLevels();
        $availabilityStatuses = Tour::getAvailableStatuses();

        return view('tour::create', compact(
            'countries',
            'cities',
            'tourTypes',
            'difficultyLevels',
            'availabilityStatuses'
        ));
    }

    /**
     * Store a newly created tour in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'difficulty_level' => 'required|in:easy,moderate,challenging,expert',
            'tour_type' => 'required|in:cultural,adventure,wildlife,historical,religious,beach,city,nature',
            'min_group_size' => 'required|integer|min:1',
            'max_group_size' => 'required|integer|min:1|gte:min_group_size',
            'base_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'single_supplement' => 'nullable|numeric|min:0',
            'included_services' => 'required|array',
            'excluded_services' => 'nullable|array',
            'amenities' => 'nullable|array',
            'age_restrictions' => 'nullable|array',
            'physical_requirements' => 'nullable|array',
            'what_to_bring' => 'nullable|array',
            'meeting_point' => 'nullable|string|max:255',
            'meeting_time' => 'nullable|date_format:H:i',
            'cancellation_policy' => 'required|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'availability_status' => 'required|in:available,limited,sold_out,suspended',
            'tour_operator' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'pickup_locations' => 'nullable|array',
            'languages' => 'nullable|array',
            'special_notes' => 'nullable|string',
        ]);

        $tour = Tour::create($validatedData);

        return redirect()->route('tours.index')
                        ->with('success', 'Tour created successfully.');
    }

    /**
     * Display the specified tour.
     */
    public function show(Tour $tour)
    {
        $tour->load([
            'country',
            'city',
            'itineraries' => function ($query) {
                $query->orderBy('day_number');
            },
            'tourDates' => function ($query) {
                $query->upcoming()->orderBy('start_date');
            }
        ]);

        return view('tour::show', compact('tour'));
    }

    /**
     * Show the form for editing the specified tour.
     */
    public function edit(Tour $tour)
    {
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $tourTypes = Tour::getAvailableTourTypes();
        $difficultyLevels = Tour::getAvailableDifficultyLevels();
        $availabilityStatuses = Tour::getAvailableStatuses();

        return view('tour::edit', compact(
            'tour',
            'countries',
            'cities',
            'tourTypes',
            'difficultyLevels',
            'availabilityStatuses'
        ));
    }

    /**
     * Update the specified tour in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'difficulty_level' => 'required|in:easy,moderate,challenging,expert',
            'tour_type' => 'required|in:cultural,adventure,wildlife,historical,religious,beach,city,nature',
            'min_group_size' => 'required|integer|min:1',
            'max_group_size' => 'required|integer|min:1|gte:min_group_size',
            'base_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'single_supplement' => 'nullable|numeric|min:0',
            'included_services' => 'required|array',
            'excluded_services' => 'nullable|array',
            'amenities' => 'nullable|array',
            'age_restrictions' => 'nullable|array',
            'physical_requirements' => 'nullable|array',
            'what_to_bring' => 'nullable|array',
            'meeting_point' => 'nullable|string|max:255',
            'meeting_time' => 'nullable|date_format:H:i',
            'cancellation_policy' => 'required|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'availability_status' => 'required|in:available,limited,sold_out,suspended',
            'tour_operator' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'pickup_locations' => 'nullable|array',
            'languages' => 'nullable|array',
            'special_notes' => 'nullable|string',
        ]);

        $tour->update($validatedData);

        return redirect()->route('tours.index')
                        ->with('success', 'Tour updated successfully.');
    }

    /**
     * Remove the specified tour from storage.
     */
    public function destroy(Tour $tour)
    {
        try {
            $tour->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Tour deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting tour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cities by country for AJAX requests.
     */
    public function getCitiesByCountry(Request $request, $countryId)
    {
        $cities = City::where('country_id', $countryId)
                     ->orderBy('name')
                     ->get(['id', 'name']);

        return response()->json($cities);
    }

    /**
     * Toggle tour featured status.
     */
    public function toggleFeatured(Tour $tour)
    {
        $tour->update(['is_featured' => !$tour->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $tour->is_featured,
            'message' => $tour->is_featured ? 'Tour marked as featured.' : 'Tour removed from featured.'
        ]);
    }

    /**
     * Toggle tour active status.
     */
    public function toggleActive(Tour $tour)
    {
        $tour->update(['is_active' => !$tour->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $tour->is_active,
            'message' => $tour->is_active ? 'Tour activated.' : 'Tour deactivated.'
        ]);
    }

    /**
     * Duplicate a tour.
     */
    public function duplicate(Tour $tour)
    {
        $newTour = $tour->replicate();
        $newTour->name = $tour->name . ' (Copy)';
        $newTour->slug = null; // Will be regenerated
        $newTour->is_featured = false;
        $newTour->save();

        // Duplicate itineraries
        foreach ($tour->itineraries as $itinerary) {
            $newItinerary = $itinerary->replicate();
            $newItinerary->tour_id = $newTour->id;
            $newItinerary->save();
        }

        return redirect()->route('tours.edit', $newTour)
                        ->with('success', 'Tour duplicated successfully. Please review and update the details.');
    }
}