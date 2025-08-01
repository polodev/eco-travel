<?php

namespace Modules\Tour\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourItinerary;
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
        $countries = Country::active()->orderBy('name')->get();
        $cities = City::active()->orderBy('name')->get();
        return view('tour::tours.index', compact('countries', 'cities'));
    }

    /**
     * Get tour data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Tour::with(['country', 'city'])
                    ->withCount(['itineraries']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->get('search_text')) {
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
                $tourType = $request->get('tour_type');
                if ($tourType && $tourType !== '' && $tourType !== 'null') {
                    $query->where('tour_type', $tourType);
                }

                // Difficulty level filter
                $difficultyLevel = $request->get('difficulty_level');
                if ($difficultyLevel && $difficultyLevel !== '' && $difficultyLevel !== 'null') {
                    $query->where('difficulty_level', $difficultyLevel);
                }

                // Active filter
                if ($request->filled('is_active')) {
                    $query->where('is_active', $request->boolean('is_active'));
                }

                // Featured filter
                if ($request->filled('is_featured')) {
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
            ->addColumn('action', function (Tour $tour) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('tour::admin.tours.show', $tour) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('tour::admin.tours.edit', $tour) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['name_formatted', 'tour_type_badge', 'difficulty_badge', 'availability_badge', 'rating_formatted', 'status_badges', 'action'])
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

        return view('tour::tours.create', compact(
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
            'included_services' => 'required|string',
            'excluded_services' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'availability_status' => 'required|in:available,limited,sold_out,suspended',
        ]);

        // Convert JSON strings to arrays
        if ($validatedData['included_services']) {
            $validatedData['included_services'] = json_decode($validatedData['included_services'], true);
        }
        if ($validatedData['excluded_services'] ?? null) {
            $validatedData['excluded_services'] = json_decode($validatedData['excluded_services'], true);
        }

        $tour = Tour::create($validatedData);

        return redirect()->route('tour::admin.tours.index')
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
            }
        ]);

        return view('tour::tours.show', compact('tour'));
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

        return view('tour::tours.edit', compact(
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
            'included_services' => 'required|string',
            'excluded_services' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'availability_status' => 'required|in:available,limited,sold_out,suspended',
        ]);

        // Convert JSON strings to arrays
        if ($validatedData['included_services']) {
            $validatedData['included_services'] = json_decode($validatedData['included_services'], true);
        }
        if ($validatedData['excluded_services'] ?? null) {
            $validatedData['excluded_services'] = json_decode($validatedData['excluded_services'], true);
        }

        $tour->update($validatedData);

        return redirect()->route('tour::admin.tours.index')
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

        return redirect()->route('tour::admin.tours.edit', $newTour)
                        ->with('success', 'Tour duplicated successfully. Please review and update the details.');
    }
}