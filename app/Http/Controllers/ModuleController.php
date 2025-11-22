<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $modules = Module::with(['creator', 'updater'])
                ->select('modules.*');

            return datatables()
                ->eloquent($modules)
                ->addColumn('status', function($module) {
                    return $module->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('creator_name', function($module) {
                    return $module->creator ? $module->creator->name : 'N/A';
                })
                ->addColumn('icon_display', function($module) {
                    return $module->icon ? '<i class="'.$module->icon.'"></i>' : '-';
                })
                ->addColumn('actions', function($module) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-dots-three-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="'.route('modules.show', $module).'">
                                        <i class="ph-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="'.route('modules.edit', $module).'">
                                        <i class="ph-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="deleteModule('.$module->id.'); return false;">
                                        <i class="ph-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->editColumn('created_at', function($module) {
                    return $module->created_at->format('M d, Y H:i');
                })
                ->editColumn('description', function($module) {
                    return $module->description ? \Illuminate\Support\Str::limit($module->description, 50) : '-';
                })
                ->rawColumns(['status', 'icon_display', 'actions'])
                ->make(true);
        }

        return view('modules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:modules,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer|min:0'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');
        
        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            // Try to generate from name first (e.g., "User Management" -> "users")
            $nameSlug = strtolower(str_replace([' ', '-'], '_', $validated['name']));
            
            // Remove common words and take first word or abbreviation
            $commonWords = ['management', 'module', 'system', 'the', 'a', 'an'];
            $words = explode('_', $nameSlug);
            $words = array_diff($words, $commonWords);
            $baseCode = !empty($words) ? reset($words) : 'module';
            
            // Check if code exists, if so add number
            $code = $baseCode;
            $counter = 1;
            while (Module::withTrashed()->where('code', $code)->exists()) {
                $counter++;
                $code = $baseCode . $counter;
            }
            
            $validated['code'] = $code;
        }

        // Auto-set display_order if not provided
        if (!isset($validated['display_order'])) {
            $maxOrder = Module::max('display_order') ?? 0;
            $validated['display_order'] = $maxOrder + 1;
        }

        Module::create($validated);

        return redirect()->route('modules.index')
            ->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        $module->load(['creator', 'updater', 'deleter', 'permissions']);
        return view('modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        return view('modules.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:modules,code,' . $module->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'display_order' => 'required|integer|min:0'
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        $module->update($validated);

        return redirect()->route('modules.index')
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        if ($module->permissions()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete module that has permissions.']);
        }

        $module->update(['deleted_by' => Auth::id()]);
        $module->delete();

        return redirect()->route('modules.index')
            ->with('success', 'Module deleted successfully.');
    }
}
