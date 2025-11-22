<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Imports\DepartmentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:departments-view')->only(['index', 'show']);
        $this->middleware('permission:departments-create')->only(['create', 'store']);
        $this->middleware('permission:departments-edit')->only(['edit', 'update']);
        $this->middleware('permission:departments-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $departments = Department::with(['creator', 'updater'])
                ->select('departments.*');

            return datatables()
                ->eloquent($departments)
                ->addColumn('status', function($department) {
                    return $department->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('creator_name', function($department) {
                    return $department->creator ? $department->creator->name : 'N/A';
                })
                ->addColumn('actions', function($department) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-dots-three-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="'.route('departments.show', $department).'">
                                        <i class="ph-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="'.route('departments.edit', $department).'">
                                        <i class="ph-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="deleteDepartment('.$department->id.'); return false;">
                                        <i class="ph-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->editColumn('created_at', function($department) {
                    return $department->created_at->format('M d, Y H:i');
                })
                ->editColumn('description', function($department) {
                    return $department->description ? \Illuminate\Support\Str::limit($department->description, 50) : '-';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('departments.index');
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:departments,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');
        
        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            $lastDepartment = Department::withTrashed()->orderBy('id', 'desc')->first();
            $nextNumber = $lastDepartment ? ($lastDepartment->id + 1) : 1;
            $validated['code'] = 'DEPT' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load(['creator', 'updater', 'deleter', 'users']);
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->update(['deleted_by' => Auth::id()]);
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function showImport()
    {
        return view('departments.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new DepartmentsImport();
            Excel::import($import, $request->file('file'));

            $failures = $import->failures();
            
            if ($failures->count() > 0) {
                $errorMessages = [];
                foreach ($failures as $failure) {
                    $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
                
                return redirect()->route('departments.import')
                    ->with('error', 'Some rows failed to import: ' . implode(' | ', $errorMessages));
            }

            return redirect()->route('departments.index')
                ->with('success', 'Departments imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('departments.import')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="departments_template.csv"',
        ];

        $columns = ['code', 'name', 'description', 'is_active'];
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['DEPT-001', 'Human Resources', 'HR Department', 'true']);
            fputcsv($file, ['DEPT-002', 'IT Department', 'Information Technology', 'true']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
