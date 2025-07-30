<?php

namespace Modules\Booking\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking::bookings.index');
    }

    public function indexJson(Request $request)
    {
        $model = Booking::with(['user']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('booking_reference', 'like', "%{$searchText}%")
                          ->orWhereHas('user', function ($userQuery) use ($searchText) {
                              $userQuery->where('name', 'like', "%{$searchText}%")
                                       ->orWhere('email', 'like', "%{$searchText}%");
                          });
                    });
                }
                if ($request->has('booking_type') && $request->get('booking_type') !== '') {
                    $query->where('booking_type', $request->get('booking_type'));
                }
                if ($request->has('status') && $request->get('status') !== '') {
                    $query->where('status', $request->get('status'));
                }
            }, true)
            ->addColumn('booking_info', function (Booking $booking) {
                $html = '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($booking->booking_reference) . '</div>';
                $html .= '<div class="text-sm text-gray-500 dark:text-gray-400">' . htmlspecialchars($booking->user->name) . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('booking_type_badge', function (Booking $booking) {
                return $booking->booking_type_badge;
            })
            ->addColumn('amount_info', function (Booking $booking) {
                return '<div class="text-sm">' .
                       '<div class="font-medium">৳' . number_format($booking->total_amount, 2) . '</div>' .
                       '<div class="text-xs text-gray-500">Paid: ৳' . number_format($booking->paid_amount, 2) . '</div>' .
                       '</div>';
            })
            ->addColumn('status_badge', function (Booking $booking) {
                return $booking->status_badge;
            })
            ->addColumn('payment_status_badge', function (Booking $booking) {
                return $booking->payment_status_badge;
            })
            ->addColumn('actions', function (Booking $booking) {
                return '<div class="flex items-center space-x-2">' .
                       '<a href="' . route('bookings.show', $booking->id) . '" class="text-blue-600 hover:text-blue-900">View</a>' .
                       '<a href="' . route('bookings.edit', $booking->id) . '" class="text-indigo-600 hover:text-indigo-900">Edit</a>' .
                       '</div>';
            })
            ->rawColumns(['booking_info', 'booking_type_badge', 'amount_info', 'status_badge', 'payment_status_badge', 'actions'])
            ->make(true);
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'flightBookings', 'hotelBookings', 'tourBookings']);
        return view('booking::bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $users = User::orderBy('name')->get();
        return view('booking::bookings.edit', compact('booking', 'users'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed,refunded',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'notes' => 'nullable|string',
        ]);

        $booking->update($validatedData);
        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }
}