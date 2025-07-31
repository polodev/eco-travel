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
        return view('booking::admin.bookings.index');
    }

    public function indexJson(Request $request)
    {
        $model = Booking::with(['user']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->has('search_text') && !empty($request->get('search_text'))) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('booking_reference', 'like', "%{$searchText}%")
                          ->orWhereHas('user', function ($userQuery) use ($searchText) {
                              $userQuery->where('name', 'like', "%{$searchText}%")
                                       ->orWhere('email', 'like', "%{$searchText}%");
                          });
                    });
                }
                if ($request->has('booking_type') && !empty($request->get('booking_type'))) {
                    $query->where('booking_type', $request->get('booking_type'));
                }
                if ($request->has('status') && !empty($request->get('status'))) {
                    $query->where('status', $request->get('status'));
                }
            }, true)
            ->addColumn('booking_info', function (Booking $booking) {
                $html = '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($booking->booking_reference) . '</div>';
                $html .= '<div class="text-sm text-gray-500 dark:text-gray-400">' . htmlspecialchars($booking->user->name ?? 'Guest User') . '</div>';
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
            ->addColumn('travel_date_formatted', function (Booking $booking) {
                return $booking->travel_date_formatted;
            })
            ->addColumn('created_at_formatted', function (Booking $booking) {
                return $booking->created_at_formatted;
            })
            ->addColumn('actions', function (Booking $booking) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('admin-dashboard.booking.bookings.show', $booking->id) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('admin-dashboard.booking.bookings.edit', $booking->id) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['booking_info', 'booking_type_badge', 'amount_info', 'status_badge', 'payment_status_badge', 'actions'])
            ->make(true);
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'flightBookings', 'hotelBookings', 'tourBookings']);
        return view('booking::admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $users = User::orderBy('name')->get();
        return view('booking::admin.bookings.edit', compact('booking', 'users'));
    }

    public function create()
    {
        return view('booking::admin.bookings.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_type' => 'required|in:flight,hotel,tour,package',
            'booking_reference' => 'required|string|unique:bookings',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
        ]);

        $booking = Booking::create($validatedData);
        return redirect()->route('admin-dashboard.booking.bookings.show', $booking)->with('success', 'Booking created successfully.');
    }

    public function update(Request $request, Booking $booking)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed,refunded',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'notes' => 'nullable|string',
        ]);

        $booking->update($validatedData);
        return redirect()->route('admin-dashboard.booking.bookings.index')->with('success', 'Booking updated successfully.');
    }
}
