<?php

namespace App\Http\Controllers;

use App\Models\MasterData;
use App\Models\MasterDataCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MasterDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:master-data-view')->only(['index', 'show']);
        $this->middleware('permission:master-data-create')->only(['create', 'store']);
        $this->middleware('permission:master-data-edit')->only(['edit', 'update']);
        $this->middleware('permission:master-data-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MasterData::with('category');

            return datatables()->eloquent($query)
                ->addColumn('category', function($data) {
                    if ($data->category) {
                        $icon = $data->category->icon ? '<i class="' . $data->category->icon . ' me-1"></i>' : '';
                        return '<span class="badge" style="background-color: ' . ($data->category->color ?? '#6c757d') . '">' . 
                               $icon . e($data->category->name) . '</span>';
                    }
                    return '<span class="text-muted">Uncategorized</span>';
                })
                ->editColumn('code', function($data) {
                    return '<code>' . e($data->code) . '</code>';
                })
                ->editColumn('type', function($data) {
                    return $data->type ?: '-';
                })
                ->editColumn('unit', function($data) {
                    return $data->unit ?: '-';
                })
                ->editColumn('value', function($data) {
                    return $data->value ?: '-';
                })
                ->addColumn('status', function($data) {
                    return $data->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('actions', function($data) {
                    $actions = '<div class="dropdown">
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph-dots-three-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">';
                    
                    if (Auth::user()->can('master-data-view')) {
                        $actions .= '<li>
                            <a class="dropdown-item" href="'.route('master-data.show', $data).'">
                                <i class="ph-eye me-2"></i> View
                            </a>
                        </li>';
                    }
                    
                    if (Auth::user()->can('master-data-edit')) {
                        $actions .= '<li>
                            <a class="dropdown-item" href="'.route('master-data.edit', $data).'">
                                <i class="ph-pencil me-2"></i> Edit
                            </a>
                        </li>';
                    }
                    
                    if (Auth::user()->can('master-data-delete')) {
                        $actions .= '<li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); deleteMasterData('.$data->id.');">
                                <i class="ph-trash me-2"></i> Delete
                            </a>
                        </li>';
                    }
                    
                    $actions .= '</ul></div>';
                    return $actions;
                })
                ->rawColumns(['code', 'category', 'status', 'actions'])
                ->make(true);
        }

        return view('master-data.index');
    }

    public function create()
    {
        $categories = MasterDataCategory::active()->ordered()->get();
        return view('master-data.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:100|unique:master_data,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:master_data_categories,id',
            'type' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'value' => 'nullable|numeric',
            'metadata' => 'nullable|json',
            'display_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        MasterData::create($validated);

        return redirect()->route('master-data.index')
            ->with('success', 'Master data created successfully.');
    }

    public function show(MasterData $masterData)
    {
        $masterData->load('category');
        return view('master-data.show', compact('masterData'));
    }

    public function edit(MasterData $masterData)
    {
        $categories = MasterDataCategory::active()->ordered()->get();
        return view('master-data.edit', compact('masterData', 'categories'));
    }

    public function update(Request $request, MasterData $masterData)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:100|unique:master_data,code,' . $masterData->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:master_data_categories,id',
            'type' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'value' => 'nullable|numeric',
            'metadata' => 'nullable|json',
            'display_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $masterData->update($validated);

        return redirect()->route('master-data.index')
            ->with('success', 'Master data updated successfully.');
    }

    public function destroy(MasterData $masterData)
    {
        $masterData->delete();

        return redirect()->route('master-data.index')
            ->with('success', 'Master data deleted successfully.');
    }

    public function showImport()
    {
        $categories = MasterDataCategory::active()->ordered()->get();
        return view('master-data.import', compact('categories'));
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
                'code' => 'required|string|max:100|unique:master_data,code',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'nullable|exists:master_data_categories,id',
                'type' => 'nullable|string|max:50',
                'unit' => 'nullable|string|max:50',
                'value' => 'nullable|numeric',
                'display_order' => 'nullable|integer',
                'is_active' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                $errors[] = "Row " . ($index + 2) . ": " . implode(', ', $validator->errors()->all());
                continue;
            }

            MasterData::create([
                'code' => $rowData['code'],
                'name' => $rowData['name'],
                'description' => $rowData['description'] ?? null,
                'category_id' => $rowData['category_id'] ?? null,
                'type' => $rowData['type'] ?? null,
                'unit' => $rowData['unit'] ?? null,
                'value' => $rowData['value'] ?? null,
                'metadata' => isset($rowData['metadata']) ? $rowData['metadata'] : null,
                'display_order' => $rowData['display_order'] ?? 0,
                'is_active' => isset($rowData['is_active']) ? (bool)$rowData['is_active'] : true,
            ]);

            $imported++;
        }

        if (count($errors) > 0) {
            return redirect()->route('master-data.import')
                ->with('warning', "Imported {$imported} items. Errors: " . implode('; ', $errors));
        }

        return redirect()->route('master-data.index')
            ->with('success', "Successfully imported {$imported} master data items.");
    }

    public function downloadTemplate()
    {
        $filename = 'master_data_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $columns = ['code', 'name', 'description', 'category_id', 'type', 'unit', 'value', 'metadata', 'display_order', 'is_active'];
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['LAPTOP_HP', 'HP Laptop', 'HP EliteBook 840', '1', 'asset', 'pcs', '1500.00', '{"brand":"HP"}', '0', '1']);
            fputcsv($file, ['DESKTOP_DELL', 'Dell Desktop', 'Dell OptiPlex 7090', '1', 'asset', 'pcs', '1200.00', '{"brand":"Dell"}', '1', '1']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
