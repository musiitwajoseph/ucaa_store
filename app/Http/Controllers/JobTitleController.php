<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use App\Imports\JobTitlesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class JobTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:job-titles-view')->only(['index', 'show']);
        $this->middleware('permission:job-titles-create')->only(['create', 'store']);
        $this->middleware('permission:job-titles-edit')->only(['edit', 'update']);
        $this->middleware('permission:job-titles-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobTitles = JobTitle::with(['creator', 'updater'])
                ->select('job_titles.*');

            return datatables()
                ->eloquent($jobTitles)
                ->addColumn('status', function($jobTitle) {
                    return $jobTitle->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('creator_name', function($jobTitle) {
                    return $jobTitle->creator ? $jobTitle->creator->name : 'N/A';
                })
                ->addColumn('actions', function($jobTitle) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-dots-three-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="'.route('job-titles.show', $jobTitle).'">
                                        <i class="ph-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="'.route('job-titles.edit', $jobTitle).'">
                                        <i class="ph-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="deleteJobTitle('.$jobTitle->id.'); return false;">
                                        <i class="ph-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->editColumn('created_at', function($jobTitle) {
                    return $jobTitle->created_at->format('M d, Y H:i');
                })
                ->editColumn('description', function($jobTitle) {
                    return $jobTitle->description ? \Illuminate\Support\Str::limit($jobTitle->description, 50) : '-';
                })
                ->editColumn('level', function($jobTitle) {
                    return $jobTitle->level ?? '-';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('job_titles.index');
    }

    public function create()
    {
        return view('job_titles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:job_titles,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|string|max:50'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');
        
        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            $lastJobTitle = JobTitle::withTrashed()->orderBy('id', 'desc')->first();
            $nextNumber = $lastJobTitle ? ($lastJobTitle->id + 1) : 1;
            $validated['code'] = 'JOB' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        JobTitle::create($validated);

        return redirect()->route('job-titles.index')
            ->with('success', 'Job title created successfully.');
    }

    public function show(JobTitle $jobTitle)
    {
        $jobTitle->load(['creator', 'updater', 'deleter', 'users']);
        return view('job_titles.show', compact('jobTitle'));
    }

    public function edit(JobTitle $jobTitle)
    {
        return view('job_titles.edit', compact('jobTitle'));
    }

    public function update(Request $request, JobTitle $jobTitle)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:job_titles,code,' . $jobTitle->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|string|max:50'
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        $jobTitle->update($validated);

        return redirect()->route('job-titles.index')
            ->with('success', 'Job title updated successfully.');
    }

    public function destroy(JobTitle $jobTitle)
    {
        $jobTitle->update(['deleted_by' => Auth::id()]);
        $jobTitle->delete();

        return redirect()->route('job-titles.index')
            ->with('success', 'Job Title deleted successfully.');
    }

    public function showImport()
    {
        return view('job_titles.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new JobTitlesImport();
            Excel::import($import, $request->file('file'));

            $failures = $import->failures();
            
            if ($failures->count() > 0) {
                $errorMessages = [];
                foreach ($failures as $failure) {
                    $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
                
                return redirect()->route('job-titles.import')
                    ->with('error', 'Some rows failed to import: ' . implode(' | ', $errorMessages));
            }

            return redirect()->route('job-titles.index')
                ->with('success', 'Job Titles imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('job-titles.import')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="job_titles_template.csv"',
        ];

        $columns = ['code', 'title', 'description', 'level', 'is_active'];
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['JOB-001', 'Manager', 'Department Manager', 'Senior', 'true']);
            fputcsv($file, ['JOB-002', 'Developer', 'Software Developer', 'Mid', 'true']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
