<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::with(['creator', 'updater', 'module'])
                ->select('permissions.*');

            return datatables()
                ->eloquent($permissions)
                ->addColumn('status', function($permission) {
                    return $permission->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('creator_name', function($permission) {
                    return $permission->creator ? $permission->creator->name : 'N/A';
                })
                ->addColumn('module_name', function($permission) {
                    return $permission->module ? $permission->module->name : 'N/A';
                })
                ->addColumn('actions', function($permission) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-dots-three-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="'.route('permissions.show', $permission).'">
                                        <i class="ph-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="'.route('permissions.edit', $permission).'">
                                        <i class="ph-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="deletePermission('.$permission->id.'); return false;">
                                        <i class="ph-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->editColumn('created_at', function($permission) {
                    return $permission->created_at->format('M d, Y H:i');
                })
                ->editColumn('description', function($permission) {
                    return $permission->description ? \Illuminate\Support\Str::limit($permission->description, 50) : '-';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('permissions.index');
    }

    public function create()
    {
        $modules = Module::active()->orderBy('display_order')->get();
        return view('permissions.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:permissions,code',
            'name' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'description' => 'nullable|string'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');
        
        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            $lastPermission = Permission::withTrashed()->orderBy('id', 'desc')->first();
            $nextNumber = $lastPermission ? ($lastPermission->id + 1) : 1;
            $validated['code'] = 'PERM' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        Permission::create($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function show(Permission $permission)
    {
        $permission->load(['creator', 'updater', 'deleter', 'roles', 'users']);
        return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $modules = Module::active()->orderBy('display_order')->get();
        return view('permissions.edit', compact('permission', 'modules'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:permissions,code,' . $permission->id,
            'name' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'description' => 'nullable|string'
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        $permission->update($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        if ($permission->roles()->count() > 0 || $permission->users()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete permission that is assigned to roles or users.']);
        }

        $permission->update(['deleted_by' => Auth::id()]);
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
