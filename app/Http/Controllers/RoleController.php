<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles-view')->only(['index', 'show']);
        $this->middleware('permission:roles-create')->only(['create', 'store']);
        $this->middleware('permission:roles-edit')->only(['edit', 'update']);
        $this->middleware('permission:roles-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with(['creator', 'updater'])
                ->withCount(['users', 'permissions'])
                ->select('roles.*');

            return datatables()
                ->eloquent($roles)
                ->addColumn('status', function($role) {
                    return $role->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('creator_name', function($role) {
                    return $role->creator ? $role->creator->name : 'N/A';
                })
                ->addColumn('users_count_display', function($role) {
                    return '<span class="badge bg-primary">' . $role->users_count . '</span>';
                })
                ->addColumn('permissions_count_display', function($role) {
                    return '<span class="badge bg-info">' . $role->permissions_count . '</span>';
                })
                ->addColumn('actions', function($role) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-dots-three-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="'.route('roles.show', $role).'">
                                        <i class="ph-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="'.route('roles.edit', $role).'">
                                        <i class="ph-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="deleteRole('.$role->id.'); return false;">
                                        <i class="ph-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->editColumn('created_at', function($role) {
                    return $role->created_at->format('M d, Y H:i');
                })
                ->editColumn('description', function($role) {
                    return $role->description ? \Illuminate\Support\Str::limit($role->description, 50) : '-';
                })
                ->rawColumns(['status', 'users_count_display', 'permissions_count_display', 'actions'])
                ->make(true);
        }

        return view('roles.index');
    }

    public function create()
    {
        $permissions = Permission::with('module')->active()->orderBy('code')->get()
            ->groupBy('module.name');
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:roles,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');
        
        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            $lastRole = Role::withTrashed()->orderBy('id', 'desc')->first();
            $nextNumber = $lastRole ? ($lastRole->id + 1) : 1;
            $validated['code'] = 'ROLE' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        DB::beginTransaction();
        try {
            $role = Role::create($validated);
            
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permissionId) {
                    $role->permissions()->attach($permissionId, [
                        'assigned_by' => Auth::id(),
                        'assigned_at' => now()
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('roles.index')
                ->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create role.']);
        }
    }

    public function show(Role $role)
    {
        $role->load(['creator', 'updater', 'deleter', 'users', 'permissions']);
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::with('module')->active()->get()
            ->sortBy(function($permission) {
                return $permission->module->name ?? '';
            })
            ->groupBy('module.name');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:roles,code,' . $role->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        DB::beginTransaction();
        try {
            $role->update($validated);
            
            // Sync permissions with audit tracking
            $permissions = [];
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permissionId) {
                    $permissions[$permissionId] = [
                        'assigned_by' => Auth::id(),
                        'assigned_at' => now()
                    ];
                }
            }
            $role->permissions()->sync($permissions);
            
            DB::commit();
            return redirect()->route('roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update role.']);
        }
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete role with assigned users.']);
        }

        $role->update(['deleted_by' => Auth::id()]);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
