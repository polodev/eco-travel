<?php

namespace Modules\Hotel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Hotel\Models\RoomInventory;
use Modules\Hotel\Models\HotelRoom;
use Modules\Hotel\Models\Hotel;
use Yajra\DataTables\Facades\DataTables;

class RoomInventoryController extends Controller
{
    public function index()
    {
        $hotels = Hotel::active()->orderBy('name')->get();
        $hotelRooms = HotelRoom::active()->with('hotel')->orderBy('name')->get();
        return view('hotel::room_inventories.index', compact('hotels', 'hotelRooms'));
    }

    public function indexJson(Request $request)
    {
        $model = RoomInventory::with(['hotelRoom.hotel']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->filled('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('date', 'like', "%{$searchText}%")
                          ->orWhere('rate_plan', 'like', "%{$searchText}%")
                          ->orWhere('notes', 'like', "%{$searchText}%")
                          ->orWhereHas('hotelRoom', function ($roomQuery) use ($searchText) {
                              $roomQuery->where('name', 'like', "%{$searchText}%");
                          })
                          ->orWhereHas('hotelRoom.hotel', function ($hotelQuery) use ($searchText) {
                              $hotelQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }
                if ($request->filled('hotel_id')) {
                    $query->whereHas('hotelRoom', function ($roomQuery) use ($request) {
                        $roomQuery->where('hotel_id', $request->get('hotel_id'));
                    });
                }
                if ($request->filled('hotel_room_id')) {
                    $query->where('hotel_room_id', $request->get('hotel_room_id'));
                }
                if ($request->filled('date_from')) {
                    $query->where('date', '>=', $request->get('date_from'));
                }
                if ($request->filled('date_to')) {
                    $query->where('date', '<=', $request->get('date_to'));
                }
                if ($request->filled('is_available')) {
                    $query->where('is_available', $request->boolean('is_available'));
                }
                if ($request->filled('stop_sell')) {
                    $query->where('stop_sell', $request->boolean('stop_sell'));
                }
                if ($request->filled('rate_plan')) {
                    $query->where('rate_plan', $request->get('rate_plan'));
                }
            }, true)
            ->addColumn('room_info', function (RoomInventory $inventory) {
                $hotel = $inventory->hotelRoom->hotel->name;
                $room = $inventory->hotelRoom->name;
                return '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($room) . '</div>' .
                       '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($hotel) . '</div>';
            })
            ->addColumn('date_formatted', function (RoomInventory $inventory) {
                return '<div class="text-center">' . $inventory->date_formatted . '</div>';
            })
            ->addColumn('availability_info', function (RoomInventory $inventory) {
                $html = '<div class="text-center text-sm">';
                $html .= '<div class="font-medium">' . $inventory->available_rooms . '/' . $inventory->total_rooms . '</div>';
                $html .= '<div class="text-xs text-gray-500">' . $inventory->occupancy_percentage . '% booked</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('price_info', function (RoomInventory $inventory) {
                return '<div class="text-center">' . $inventory->price_display . '</div>';
            })
            ->addColumn('rate_plan_badge', function (RoomInventory $inventory) {
                return '<div class="text-center">' . $inventory->rate_plan_badge . '</div>';
            })
            ->addColumn('status_badges', function (RoomInventory $inventory) {
                $badges = '<div class="flex flex-col items-center space-y-1">';
                $badges .= $inventory->availability_badge;
                if ($inventory->discount_percentage > 0) {
                    $badges .= '<div>' . $inventory->discount_badge . '</div>';
                }
                $badges .= '</div>';
                return $badges;
            })
            ->addColumn('inclusions_display', function (RoomInventory $inventory) {
                return $inventory->inclusions_display;
            })
            ->addColumn('stay_requirements', function (RoomInventory $inventory) {
                return '<div class="text-xs text-gray-600 dark:text-gray-400">' . $inventory->stay_requirements . '</div>';
            })
            ->addColumn('created_at_formatted', function (RoomInventory $inventory) {
                return $inventory->created_at->format('M d, Y');
            })
            ->addColumn('action', function (RoomInventory $inventory) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('hotel::admin.room-inventories.show', $inventory) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('hotel::admin.room-inventories.edit', $inventory) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['room_info', 'date_formatted', 'availability_info', 'price_info', 'rate_plan_badge', 'status_badges', 'inclusions_display', 'stay_requirements', 'action'])
            ->make(true);
    }

    public function create()
    {
        $hotels = Hotel::active()->orderBy('name')->get();
        $hotelRooms = HotelRoom::active()->with('hotel')->orderBy('name')->get();
        return view('hotel::room_inventories.create', compact('hotels', 'hotelRooms'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hotel_room_id' => 'required|exists:hotel_rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'booked_rooms' => 'nullable|integer|min:0',
            'blocked_rooms' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'final_price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'rate_plan' => 'required|string',
            'inclusions' => 'nullable|array',
            'inclusions.*' => 'string',
            'minimum_stay' => 'nullable|integer|min:1',
            'maximum_stay' => 'nullable|integer|min:1',
            'stop_sell' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        // Ensure room counts add up correctly
        $bookedRooms = $validatedData['booked_rooms'] ?? 0;
        $blockedRooms = $validatedData['blocked_rooms'] ?? 0;
        $totalRooms = $validatedData['total_rooms'];
        $availableRooms = $totalRooms - $bookedRooms - $blockedRooms;
        
        $validatedData['available_rooms'] = max(0, $availableRooms);
        $validatedData['booked_rooms'] = $bookedRooms;
        $validatedData['blocked_rooms'] = $blockedRooms;

        RoomInventory::create($validatedData);
        return redirect()->route('hotel::admin.room-inventories.index')->with('success', 'Room inventory created successfully.');
    }

    public function show(RoomInventory $roomInventory)
    {
        $roomInventory->load(['hotelRoom.hotel']);
        return view('hotel::room_inventories.show', compact('roomInventory'));
    }

    public function edit(RoomInventory $roomInventory)
    {
        $hotels = Hotel::active()->orderBy('name')->get();
        $hotelRooms = HotelRoom::active()->with('hotel')->orderBy('name')->get();
        return view('hotel::room_inventories.edit', compact('roomInventory', 'hotels', 'hotelRooms'));
    }

    public function update(Request $request, RoomInventory $roomInventory)
    {
        $validatedData = $request->validate([
            'hotel_room_id' => 'required|exists:hotel_rooms,id',
            'date' => 'required|date',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'booked_rooms' => 'nullable|integer|min:0',
            'blocked_rooms' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'final_price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'rate_plan' => 'required|string',
            'inclusions' => 'nullable|array',
            'inclusions.*' => 'string',
            'minimum_stay' => 'nullable|integer|min:1',
            'maximum_stay' => 'nullable|integer|min:1',
            'stop_sell' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        // Ensure room counts add up correctly
        $bookedRooms = $validatedData['booked_rooms'] ?? 0;
        $blockedRooms = $validatedData['blocked_rooms'] ?? 0;
        $totalRooms = $validatedData['total_rooms'];
        $availableRooms = $totalRooms - $bookedRooms - $blockedRooms;
        
        $validatedData['available_rooms'] = max(0, $availableRooms);
        $validatedData['booked_rooms'] = $bookedRooms;
        $validatedData['blocked_rooms'] = $blockedRooms;

        $roomInventory->update($validatedData);
        return redirect()->route('hotel::admin.room-inventories.index')->with('success', 'Room inventory updated successfully.');
    }

    public function destroy(RoomInventory $roomInventory)
    {
        try {
            $roomInventory->delete();
            return response()->json(['success' => true, 'message' => 'Room inventory deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting room inventory: ' . $e->getMessage()], 500);
        }
    }
}