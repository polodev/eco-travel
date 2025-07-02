<?php

namespace Modules\AdminDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function indexJson(Request $request)
    {
        $model = User::query();
        
        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Role filter
                if ($request->has('role') && $request->get('role')) {
                    $query->whereIn('role', $request->get('role'));
                }
                
                // Email verification filter
                if ($request->has('email_verified') && $request->get('email_verified')) {
                    if ($request->get('email_verified') === 'verified') {
                        $query->whereNotNull('email_verified_at');
                    } elseif ($request->get('email_verified') === 'unverified') {
                        $query->whereNull('email_verified_at');
                    }
                }
                
                // Date range filters
                if ($request->has('starting_date_of_user_create_at') && $request->get('starting_date_of_user_create_at')) {
                    $query->whereDate('created_at', '>=', $request->get('starting_date_of_user_create_at'));
                }
                if ($request->has('ending_date_of_user_created_at') && $request->get('ending_date_of_user_created_at')) {
                    $query->whereDate('created_at', '<=', $request->get('ending_date_of_user_created_at'));
                }
                
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('email', 'like', "%{$searchText}%")
                          ->orWhere('role', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('role_badge', function (User $user) {
                if (!$user->role) {
                    return '<span class="badge bg-secondary">No Role</span>';
                }
                
                $badgeClasses = [
                    'developer' => 'bg-info',
                    'admin' => 'bg-warning text-dark',
                    'employee' => 'bg-primary',
                    'accounts' => 'bg-success',
                    'customer' => 'bg-light text-dark'
                ];
                
                $badgeClass = $badgeClasses[$user->role] ?? 'bg-secondary';
                
                return '<span class="badge ' . $badgeClass . '">' . Str::headline($user->role) . '</span>';
            })
            ->addColumn('email_verified_badge', function (User $user) {
                if ($user->email_verified_at) {
                    return '<span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Verified
                            </span>';
                } else {
                    return '<span class="badge bg-warning text-dark">
                                <i class="fas fa-exclamation-circle me-1"></i>Unverified
                            </span>';
                }
            })
            ->addColumn('action', function (User $user) {
                $actions = '';
                
                $actions .= '<a class="btn btn-sm btn-success me-1" href="' . route('admin-dashboard.users.show', $user->id) . '" title="View">
                                <i class="fas fa-eye"></i>
                             </a>';
                             
                $actions .= '<a class="btn btn-sm btn-info me-1" href="' . route('admin-dashboard.users.edit', $user->id) . '" title="Edit">
                                <i class="fas fa-edit"></i>
                             </a>';
                
                // Only show delete for non-critical roles
                if (!in_array($user->role, ['developer', 'admin'])) {
                    $actions .= '<button class="btn btn-sm btn-danger" onclick="deleteUser(' . $user->id . ')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                 </button>';
                }
                
                return $actions;
            })
            ->addColumn('created_at_formatted', function (User $user) {
                return '<span title="' . $user->created_at->format('Y-m-d H:i:s') . '">' . 
                       $user->created_at->format('M d, Y') . 
                       '</span><br><small class="text-muted">' . 
                       $user->created_at->diffForHumans() . 
                       '</small>';
            })
            ->addColumn('last_login_formatted', function (User $user) {
                // Add last_login_at column to users table migration if needed
                if (isset($user->last_login_at) && $user->last_login_at) {
                    return '<span title="' . $user->last_login_at->format('Y-m-d H:i:s') . '">' . 
                           $user->last_login_at->format('M d, Y') . 
                           '</span><br><small class="text-muted">' . 
                           $user->last_login_at->diffForHumans() . 
                           '</small>';
                } else {
                    return '<span class="text-muted">Never</span>';
                }
            })
            ->rawColumns(['action', 'created_at_formatted', 'last_login_formatted', 'role_badge', 'email_verified_badge'])
            ->toJson();
    }

    public function create()
    {
        $availableRoles = ['developer', 'admin', 'employee', 'accounts', 'customer'];
        return view('admin-dashboard::users.create', compact('availableRoles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|in:developer,admin,employee,accounts,customer'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'email_verified_at' => now(), // Auto-verify admin created users
        ]);

        return redirect()->route('admin-dashboard.users.index')
            ->with('success', 'User created successfully.');
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
            'role' => 'nullable|string|in:developer,admin,employee,accounts,customer',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $data = $request->only(['name', 'email', 'role']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin-dashboard.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deletion of critical users
        if (in_array($user->role, ['developer', 'admin'])) {
            return response()->json(['error' => 'Cannot delete admin or developer users'], 403);
        }

        $user->delete();

        return response()->json(['success' => 'User deleted successfully']);
    }
}