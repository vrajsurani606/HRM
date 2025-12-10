<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Roles Management.view role'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $perPage = (int) $request->input('per_page', 10);
        $q = trim((string) $request->input('q', ''));

        $query = Role::with(['permissions', 'users']);
        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%");
            });
        }

        $roles = $query->paginate(max($perPage, 1))->appends($request->query());
        return view('roles.index', compact('roles', 'q', 'perPage'));
    }

    public function create()
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Roles Management.create role'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Roles Management.create role'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'restrict_to_own_data' => 'nullable|boolean',
            'dashboard_type' => 'required|string|in:admin,employee,customer,hr,receptionist',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'restrict_to_own_data' => $request->boolean('restrict_to_own_data'),
            'dashboard_type' => $request->dashboard_type,
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function show(Role $role)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Roles Management.view role'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Roles Management.edit role'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Roles Management.edit role'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'restrict_to_own_data' => 'nullable|boolean',
            'dashboard_type' => 'required|string|in:admin,employee,customer,hr,receptionist',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'restrict_to_own_data' => $request->boolean('restrict_to_own_data'),
            'dashboard_type' => $request->dashboard_type,
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Roles Management.delete role'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role that is assigned to users');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
