<?php

namespace App\Http\Controllers;

use App\Models\MasterDataCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MasterDataCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:master-data-categories-view')->only(['index', 'show']);
        $this->middleware('permission:master-data-categories-create')->only(['create', 'store']);
        $this->middleware('permission:master-data-categories-edit')->only(['edit', 'update']);
        $this->middleware('permission:master-data-categories-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = MasterDataCategory::withCount('masterData');

            return datatables()->eloquent($categories)
                ->addColumn('code', function($category) {
                    return '<code class="d-inline-block">' . e($category->code) . '</code>';
                })
                ->editColumn('name', function($category) {
                    $color = $category->color ?? '#6366f1';
                    $icon = $category->icon ?? 'ph-folder';
                    return '<span class="badge" style="background-color: ' . $color . '20; color: ' . $color . '; border: 1px solid ' . $color . '40;"><i class="' . $icon . ' me-1"></i>' . e($category->name) . '</span>';
                })
                ->editColumn('description', function($category) {
                    return $category->description ? '<span class="text-muted">' . e($category->description) . '</span>' : '<span class="text-muted">-</span>';
                })
                ->editColumn('icon', function($category) {
                    $icon = $category->icon ?? 'ph-folder';
                    return '<i class="' . $icon . '" style="font-size: 1.5rem;"></i>';
                })
                ->addColumn('items_count', function($category) {
                    return '<span class="badge bg-secondary">' . $category->master_data_count . '</span>';
                })
                ->editColumn('status', function($category) {
                    return $category->is_active
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('actions', function($category) {
                    $actions = '<div class="dropdown">
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph-dots-three-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">';
                    
                    if (Auth::user()->can('master-data-categories-view')) {
                        $actions .= '<li>
                            <a class="dropdown-item" href="'.route('master-data-categories.show', $category).'">
                                <i class="ph-eye me-2"></i> View
                            </a>
                        </li>';
                    }
                    
                    if (Auth::user()->can('master-data-categories-edit')) {
                        $actions .= '<li>
                            <a class="dropdown-item" href="'.route('master-data-categories.edit', $category).'">
                                <i class="ph-pencil me-2"></i> Edit
                            </a>
                        </li>';
                    }
                    
                    if (Auth::user()->can('master-data-categories-delete')) {
                        $actions .= '<li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); deleteCategory('.$category->id.');">
                                <i class="ph-trash me-2"></i> Delete
                            </a>
                        </li>';
                    }
                    
                    $actions .= '</ul></div>';
                    return $actions;
                })
                ->rawColumns(['code', 'name', 'description', 'icon', 'items_count', 'status', 'actions'])
                ->make(true);
        }

        return view('master-data-categories.index');
    }

    public function create()
    {
        return view('master-data-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:master_data_categories,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'display_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        MasterDataCategory::create($validated);

        return redirect()->route('master-data-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(MasterDataCategory $masterDataCategory)
    {
        $masterDataCategory->load('masterData');
        return view('master-data-categories.show', compact('masterDataCategory'));
    }

    public function edit(MasterDataCategory $masterDataCategory)
    {
        return view('master-data-categories.edit', compact('masterDataCategory'));
    }

    public function update(Request $request, MasterDataCategory $masterDataCategory)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:master_data_categories,code,' . $masterDataCategory->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'display_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $masterDataCategory->update($validated);

        return redirect()->route('master-data-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(MasterDataCategory $masterDataCategory)
    {
        $masterDataCategory->delete();

        return redirect()->route('master-data-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function showImport()
    {
        return view('master-data-categories.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        $imported = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            if (count($row) != count($header)) {
                continue;
            }

            $rowData = array_combine($header, $row);

            $validator = Validator::make($rowData, [
                'code' => 'required|string|max:50|unique:master_data_categories,code',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'icon' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:20',
                'display_order' => 'nullable|integer',
                'is_active' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                $errors[] = "Row " . ($index + 2) . ": " . implode(', ', $validator->errors()->all());
                continue;
            }

            MasterDataCategory::create([
                'code' => $rowData['code'],
                'name' => $rowData['name'],
                'description' => $rowData['description'] ?? null,
                'icon' => $rowData['icon'] ?? null,
                'color' => $rowData['color'] ?? null,
                'display_order' => $rowData['display_order'] ?? 0,
                'is_active' => isset($rowData['is_active']) ? (bool)$rowData['is_active'] : true,
            ]);

            $imported++;
        }

        if (count($errors) > 0) {
            return redirect()->route('master-data-categories.import')
                ->with('warning', "Imported {$imported} categories. Errors: " . implode('; ', $errors));
        }

        return redirect()->route('master-data-categories.index')
            ->with('success', "Successfully imported {$imported} categories.");
    }

    public function downloadTemplate()
    {
        $filename = 'master_data_categories_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $columns = ['code', 'name', 'description', 'icon', 'color', 'display_order', 'is_active'];
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['ASSET_TYPE', 'Asset Types', 'Classification of assets', 'ph ph-package', '#6366f1', '0', '1']);
            fputcsv($file, ['STATUS_TYPE', 'Status Types', 'Various status options', 'ph ph-tag', '#10b981', '1', '1']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
