<?php

namespace Modules\Hotel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelRoom;
use Yajra\DataTables\Facades\DataTables;

class HotelRoomController extends Controller
{
    public function index()
    {
        $hotels = Hotel::active()->orderBy('name')->get();
        return view('hotel::rooms.index', compact('hotels'));
    }

    public function indexJson(Request $request)
    {
        $model = HotelRoom::with(['hotel.country', 'hotel.city']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->filled('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('description', 'like', "%{$searchText}%")
                          ->orWhere('room_type', 'like', "%{$searchText}%")
                          ->orWhereHas('hotel', function ($hotelQuery) use ($searchText) {
                              $hotelQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }
                if ($request->filled('hotel_id')) {
                    $query->where('hotel_id', $request->get('hotel_id'));
                }
                if ($request->filled('room_type')) {
                    $query->where('room_type', $request->get('room_type'));
                }
                if ($request->filled('bed_type')) {
                    $query->where('bed_type', $request->get('bed_type'));
                }
                if ($request->filled('is_active')) {
                    $query->where('is_active', $request->boolean('is_active'));
                }
                if ($request->filled('is_refundable')) {
                    $query->where('is_refundable', $request->boolean('is_refundable'));
                }
            }, true)
            ->addColumn('room_info', function (HotelRoom $room) {
                $html = '<div class="flex items-center">';
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($room->name) . '</div>';
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($room->hotel->name) . '</div>';
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('room_type_badge', function (HotelRoom $room) {
                return $room->room_type_badge;
            })
            ->addColumn('occupancy_info', function (HotelRoom $room) {
                return '<div class="text-sm">' . 
                       '<div class="font-medium text-gray-900 dark:text-gray-100">' . $room->occupancy_display . '</div>' .
                       '<div class="text-xs text-gray-500 dark:text-gray-400">' . $room->bed_display . '</div>' .
                       '</div>';
            })
            ->addColumn('price_display', function (HotelRoom $room) {
                return '<div class="text-center">' .
                       '<div class="font-semibold text-lg text-green-600 dark:text-green-400">৳' . number_format($room->base_price, 0) . '</div>' .
                       '<div class="text-xs text-gray-500 dark:text-gray-400">per night</div>' .
                       '</div>';
            })
            ->addColumn('room_details', function (HotelRoom $room) {
                $details = '<div class="text-sm">';
                $details .= '<div class="text-gray-900 dark:text-gray-100">' . $room->room_size_display . '</div>';
                $details .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . $room->total_rooms . ' ' . ($room->total_rooms > 1 ? 'rooms' : 'room') . ' available</div>';
                $details .= '</div>';
                return $details;
            })
            ->addColumn('amenities_display', function (HotelRoom $room) {
                return $room->amenities_display;
            })
            ->addColumn('status_badges', function (HotelRoom $room) {
                $badges = '<div class="flex flex-col items-center space-y-1">';
                $badges .= $room->status_badge;
                $badges .= '<div>' . $room->refundable_badge . '</div>';
                $badges .= '</div>';
                return $badges;
            })
            ->addColumn('created_at_formatted', function (HotelRoom $room) {
                return $room->created_at->format('M d, Y');
            })
            ->addColumn('action', function (HotelRoom $room) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('admin-dashboard.hotel.rooms.show', $room) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('admin-dashboard.hotel.rooms.edit', $room) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['room_info', 'room_type_badge', 'occupancy_info', 'price_display', 'room_details', 'amenities_display', 'status_badges', 'action'])
            ->make(true);
    }

    public function create()
    {
        $hotels = Hotel::active()->orderBy('name')->get();
        return view('hotel::rooms.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'max_adults' => 'required|integer|min:1|max:15',
            'max_children' => 'required|integer|min:0|max:10',
            'room_size' => 'nullable|numeric|min:0|max:500',
            'bed_type' => 'required|string',
            'bed_count' => 'required|integer|min:1|max:5',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'base_price' => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1|max:100',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_refundable' => 'boolean',
        ]);

        HotelRoom::create($validatedData);
        return redirect()->route('admin-dashboard.hotel.rooms.index')->with('success', 'Hotel room created successfully.');
    }

    public function show(HotelRoom $room)
    {
        $room->load(['hotel.country', 'hotel.city']);
        return view('hotel::rooms.show', compact('room'));
    }

    public function edit(HotelRoom $room)
    {
        $hotels = Hotel::active()->orderBy('name')->get();
        return view('hotel::rooms.edit', compact('room', 'hotels'));
    }

    public function update(Request $request, HotelRoom $room)
    {
        $validatedData = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'max_adults' => 'required|integer|min:1|max:15',
            'max_children' => 'required|integer|min:0|max:10',
            'room_size' => 'nullable|numeric|min:0|max:500',
            'bed_type' => 'required|string',
            'bed_count' => 'required|integer|min:1|max:5',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'base_price' => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1|max:100',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_refundable' => 'boolean',
        ]);

        $room->update($validatedData);
        return redirect()->route('admin-dashboard.hotel.rooms.index')->with('success', 'Hotel room updated successfully.');
    }

    public function destroy(HotelRoom $room)
    {
        try {
            $room->delete();
            return response()->json(['success' => true, 'message' => 'Hotel room deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting hotel room: ' . $e->getMessage()], 500);
        }
    }
}