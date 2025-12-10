<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Users Management.view user'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Get per_page from request, default to 12
        $perPage = $request->get('per_page', 12);
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Users Management.create user'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Users Management.create user'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,name',
            'mobile_no' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password, // Store plain password
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Users Management.view user'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Users Management.edit user'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $roles = Role::all();
        
        // Get all permissions grouped by module
        $allPermissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });
        
        // Get user's direct permissions (not from roles)
        $userDirectPermissions = $user->permissions->pluck('name')->toArray();
        
        // Get permissions from user's role
        $rolePermissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        
        return view('users.edit', compact('user', 'roles', 'allPermissions', 'userDirectPermissions', 'rolePermissions'));
    }

    public function update(Request $request, User $user)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Users Management.edit user'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'mobile_no' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
                'plain_password' => $request->password, // Store plain password
            ]);
        }

        // Update role
        $user->syncRoles([$request->role]);
        
        // Sync direct permissions (these are in addition to role permissions)
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')->with('success', 'User updated successfully with custom permissions');
    }

    public function destroy(User $user)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Users Management.delete user'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}