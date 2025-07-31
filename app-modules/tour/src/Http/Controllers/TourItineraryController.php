<?php

namespace Modules\Tour\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourItinerary;
use Yajra\DataTables\Facades\DataTables;

class TourItineraryController extends Controller
{
    /**
     * Display a listing of the tour itineraries.
     */
    public function index(Request $request)
    {
        $tours = Tour::active()->orderBy('name')->get();
        $selectedTourId = $request->get('tour_id');
        $selectedTour = null;
        
        if ($selectedTourId) {
            $selectedTour = Tour::find($selectedTourId);
        }
        
        return view('tour::itineraries.index', compact('tours', 'selectedTourId', 'selectedTour'));
    }

    /**
     * Get tour itinerary data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = TourItinerary::with(['tour']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('day_title', 'like', "%{$searchText}%")
                          ->orWhere('day_description', 'like', "%{$searchText}%")
                          ->orWhere('location', 'like', "%{$searchText}%")
                          ->orWhereHas('tour', function ($tourQuery) use ($searchText) {
                              $tourQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }

                // Tour filter
                $tourId = $request->get('tour_id');
                if ($tourId && $tourId !== '' && $tourId !== 'null') {
                    $query->where('tour_id', $tourId);
                }

                // Day type filter
                $dayType = $request->get('day_type');
                if ($dayType && $dayType !== '' && $dayType !== 'null') {
                    if ($dayType === 'rest') {
                        $query->where('is_rest_day', true);
                    } elseif ($dayType === 'activity') {
                        $query->where('is_rest_day', false);
                    }
                }

                // Accommodation type filter
                $accommodationType = $request->get('accommodation_type');
                if ($accommodationType && $accommodationType !== '' && $accommodationType !== 'null') {
                    $query->where('accommodation_type', $accommodationType);
                }
            }, true)
            ->addColumn('tour_name', function (TourItinerary $itinerary) {
                return '<div class="font-medium text-gray-900 dark:text-gray-100">' . 
                       htmlspecialchars($itinerary->tour->name) . '</div>';
            })
            ->addColumn('day_info', function (TourItinerary $itinerary) {
                $html = '<div class="flex items-center space-x-2">';
                $html .= '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">Day ' . $itinerary->day_number . '</span>';
                if ($itinerary->is_rest_day) {
                    $html .= '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Rest Day</span>';
                }
                $html .= '</div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100 mt-1">' . htmlspecialchars($itinerary->day_title) . '</div>';
                return $html;
            })
            ->addColumn('location_info', function (TourItinerary $itinerary) {
                $html = '<div class="text-gray-900 dark:text-gray-100">';
                $html .= '<div class="font-medium">' . htmlspecialchars($itinerary->location ?? 'Not specified') . '</div>';
                if ($itinerary->accommodation) {
                    $html .= '<div class="text-xs text-gray-600 dark:text-gray-400 mt-1">';
                    $html .= htmlspecialchars($itinerary->accommodation);
                    if ($itinerary->accommodation_rating) {
                        $html .= ' (' . $itinerary->accommodation_rating . '★)';
                    }
                    $html .= '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('activities_summary', function (TourItinerary $itinerary) {
                $activities = $itinerary->activities ?? [];
                if (empty($activities)) {
                    return '<span class="text-gray-500 dark:text-gray-400">No activities</span>';
                }
                
                $html = '<div class="space-y-1">';
                foreach (array_slice($activities, 0, 3) as $activity) {
                    $html .= '<div class="text-xs text-gray-700 dark:text-gray-300">• ' . htmlspecialchars($activity) . '</div>';
                }
                if (count($activities) > 3) {
                    $html .= '<div class="text-xs text-blue-600 dark:text-blue-400">+' . (count($activities) - 3) . ' more</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('meals_badge', function (TourItinerary $itinerary) {
                return $itinerary->meals_badges;
            })
            ->addColumn('duration_info', function (TourItinerary $itinerary) {
                $html = '<div class="text-sm text-gray-900 dark:text-gray-100">';
                if ($itinerary->estimated_duration) {
                    $hours = floor($itinerary->estimated_duration / 60);
                    $minutes = $itinerary->estimated_duration % 60;
                    if ($hours > 0) {
                        $html .= $hours . 'h';
                        if ($minutes > 0) $html .= ' ' . $minutes . 'm';
                    } else {
                        $html .= $minutes . 'm';
                    }
                } else {
                    $html .= 'Not specified';
                }
                $html .= '</div>';
                
                if ($itinerary->estimated_distance) {
                    $html .= '<div class="text-xs text-gray-600 dark:text-gray-400">' . $itinerary->estimated_distance . ' km</div>';
                }
                return $html;
            })
            ->addColumn('action', function (TourItinerary $itinerary) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('admin-dashboard.tour.itineraries.show', $itinerary) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('admin-dashboard.tour.itineraries.edit', $itinerary) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['tour_name', 'day_info', 'location_info', 'activities_summary', 'meals_badge', 'duration_info', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new tour itinerary.
     */
    public function create(Request $request)
    {
        $tours = Tour::active()->orderBy('name')->get();
        $accommodationTypes = TourItinerary::getAvailableAccommodationTypes();
        $selectedTourId = $request->get('tour_id');

        return view('tour::itineraries.create', compact(
            'tours',
            'accommodationTypes',
            'selectedTourId'
        ));
    }

    /**
     * Store a newly created tour itinerary in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'day_number' => 'required|integer|min:1',
            'day_title' => 'required|string|max:255',
            'day_description' => 'required|string',
            'activities' => 'required|string',
            'meals_included' => 'nullable|array',
            'accommodation' => 'nullable|string|max:255',
            'accommodation_type' => 'nullable|string',
            'accommodation_rating' => 'nullable|integer|min:1|max:5',
            'location' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'transportation' => 'nullable|string',
            'estimated_distance' => 'nullable|numeric|min:0',
            'estimated_duration' => 'nullable|integer|min:0',
            'optional_activities' => 'nullable|string',
            'meal_options' => 'nullable|string',
            'special_notes' => 'nullable|string',
            'is_rest_day' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Convert JSON strings to arrays
        if ($validatedData['activities']) {
            $validatedData['activities'] = json_decode($validatedData['activities'], true);
        }
        
        if (!empty($validatedData['transportation'])) {
            $validatedData['transportation'] = json_decode($validatedData['transportation'], true);
        }
        
        if (!empty($validatedData['optional_activities'])) {
            $validatedData['optional_activities'] = json_decode($validatedData['optional_activities'], true);
        }
        
        if (!empty($validatedData['meal_options'])) {
            $validatedData['meal_options'] = json_decode($validatedData['meal_options'], true);
        }

        // Set sort_order if not provided
        if (!isset($validatedData['sort_order'])) {
            $validatedData['sort_order'] = $validatedData['day_number'];
        }

        $itinerary = TourItinerary::create($validatedData);

        return redirect()->route('admin-dashboard.tour.itineraries.index')
                        ->with('success', 'Tour itinerary created successfully.');
    }

    /**
     * Display the specified tour itinerary.
     */
    public function show(TourItinerary $itinerary)
    {
        $itinerary->load(['tour']);

        return view('tour::itineraries.show', compact('itinerary'));
    }

    /**
     * Show the form for editing the specified tour itinerary.
     */
    public function edit(TourItinerary $itinerary)
    {
        $tours = Tour::active()->orderBy('name')->get();
        $accommodationTypes = TourItinerary::getAvailableAccommodationTypes();

        return view('tour::itineraries.edit', compact(
            'itinerary',
            'tours',
            'accommodationTypes'
        ));
    }

    /**
     * Update the specified tour itinerary in storage.
     */
    public function update(Request $request, TourItinerary $itinerary)
    {
        $validatedData = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'day_number' => 'required|integer|min:1',
            'day_title' => 'required|string|max:255',
            'day_description' => 'required|string',
            'activities' => 'required|string',
            'meals_included' => 'nullable|array',
            'accommodation' => 'nullable|string|max:255',
            'accommodation_type' => 'nullable|string',
            'accommodation_rating' => 'nullable|integer|min:1|max:5',
            'location' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'transportation' => 'nullable|string',
            'estimated_distance' => 'nullable|numeric|min:0',
            'estimated_duration' => 'nullable|integer|min:0',
            'optional_activities' => 'nullable|string',
            'meal_options' => 'nullable|string',
            'special_notes' => 'nullable|string',
            'is_rest_day' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Convert JSON strings to arrays
        if ($validatedData['activities']) {
            $validatedData['activities'] = json_decode($validatedData['activities'], true);
        }
        
        if (!empty($validatedData['transportation'])) {
            $validatedData['transportation'] = json_decode($validatedData['transportation'], true);
        }
        
        if (!empty($validatedData['optional_activities'])) {
            $validatedData['optional_activities'] = json_decode($validatedData['optional_activities'], true);
        }
        
        if (!empty($validatedData['meal_options'])) {
            $validatedData['meal_options'] = json_decode($validatedData['meal_options'], true);
        }

        // Set sort_order if not provided
        if (!isset($validatedData['sort_order'])) {
            $validatedData['sort_order'] = $validatedData['day_number'];
        }

        $itinerary->update($validatedData);

        return redirect()->route('admin-dashboard.tour.itineraries.index')
                        ->with('success', 'Tour itinerary updated successfully.');
    }

    /**
     * Remove the specified tour itinerary from storage.
     */
    public function destroy(TourItinerary $itinerary)
    {
        try {
            $itinerary->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Tour itinerary deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting tour itinerary: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Duplicate a tour itinerary.
     */
    public function duplicate(TourItinerary $itinerary)
    {
        $newItinerary = $itinerary->replicate();
        $newItinerary->day_title = $itinerary->day_title . ' (Copy)';
        $newItinerary->day_number = $itinerary->day_number + 1; // Next day
        $newItinerary->save();

        return redirect()->route('admin-dashboard.tour.itineraries.edit', $newItinerary)
                        ->with('success', 'Tour itinerary duplicated successfully. Please review and update the details.');
    }

    /**
     * Get itineraries by tour for AJAX requests.
     */
    public function getItinerariesByTour(Request $request, $tourId)
    {
        $itineraries = TourItinerary::where('tour_id', $tourId)
                                  ->orderBy('day_number')
                                  ->get(['id', 'day_number', 'day_title']);

        return response()->json($itineraries);
    }
}