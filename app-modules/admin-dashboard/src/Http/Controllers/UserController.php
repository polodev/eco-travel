<?php

namespace Modules\AdminDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $roles = User::whereNotNull('role')
            ->distinct()
            ->pluck('role')
            ->filter()
            ->values()
            ->toArray();

        return view('admin-dashboard::users.index', compact('roles'));
    }

    public function indexJson()
    {
        $model = User::query();
        
        return DataTables::eloquent($model)
            ->filter(function ($query) {
                if (request()->has('role') && request('role')) {
                    $query->whereIn('role', request('role'));
                }
                if (request()->has('starting_date_of_user_create_at') && request('starting_date_of_user_create_at')) {
                    $query->whereDate('created_at', '>=', request('starting_date_of_user_create_at'));
                }
                if (request()->has('ending_date_of_user_created_at') && request('ending_date_of_user_created_at')) {
                    $query->whereDate('created_at', '<=', request('ending_date_of_user_created_at'));
                }
            }, true)
            ->addColumn('role', function (User $user) {
                return $user->role ? Str::headline($user->role) : 'No Role';
            })
            ->addColumn('action', function (User $user) {
                $editBtn = '<a class="btn btn-sm btn-info me-1" href="' . route('admin-dashboard.users.edit', $user->id) . '">Edit</a>';
                $viewBtn = '<a class="btn btn-sm btn-success" href="' . route('admin-dashboard.users.show', $user->id) . '">View</a>';
                return $editBtn . $viewBtn;
            })
            ->addColumn('created_at_formatted', function (User $user) {
                return $user->created_at->format('Y-m-d H:i:s') . '<br><small class="text-muted">' . $user->created_at->diffForHumans() . '</small>';
            })
            ->rawColumns(['action', 'created_at_formatted'])
            ->toJson();
    }

    public function show(User $user)
    {
        return view('admin-dashboard::users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $availableRoles = ['developer', 'admin', 'employee', 'accounts', 'customer'];
        return view('admin-dashboard::users.edit', compact('user', 'availableRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'nullable|string|in:developer,admin,employee,accounts,customer'
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin-dashboard.users.index')
            ->with('success', 'User updated successfully.');
    }
}