<?php

namespace App\Http\Controllers;

use App\Models\OfficeLocation;
use App\Imports\OfficeLocationsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OfficeLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:office-locations-view')->only(['index', 'show']);
        $this->middleware('permission:office-locations-create')->only(['create', 'store']);
        $this->middleware('permission:office-locations-edit')->only(['edit', 'update']);
        $this->middleware('permission:office-locations-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $officeLocations = OfficeLocation::with(['creator', 'updater'])
                ->select('office_locations.*');

            return datatables()
                ->eloquent($officeLocations)
                ->addColumn('status', function($location) {
                    return $location->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('creator_name', function($location) {
                    return $location->creator ? $location->creator->name : 'N/A';
                })
                ->addColumn('location_info', function($location) {
                    $info = [];
                    if ($location->building) $info[] = 'Building: ' . $location->building;
                    if ($location->floor) $info[] = 'Floor: ' . $location->floor;
                    if ($location->room_number) $info[] = 'Room: ' . $location->room_number;
                    return !empty($info) ? implode(' | ', $info) : '-';
                })
                ->addColumn('actions', function($location) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-dots-three-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="'.route('office-locations.show', $location).'">
                                        <i class="ph-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="'.route('office-locations.edit', $location).'">
                                        <i class="ph-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="deleteLocation('.$location->id.'); return false;">
                                        <i class="ph-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->editColumn('created_at', function($location) {
                    return $location->created_at->format('M d, Y H:i');
                })
                ->editColumn('address', function($location) {
                    return $location->address ? \Illuminate\Support\Str::limit($location->address, 50) : '-';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('office_locations.index');
    }

    public function create()
    {
        return view('office_locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:office_locations,code',
            'name' => 'required|string|max:255',
            'building' => 'nullable|string|max:100',
            'floor' => 'nullable|string|max:50',
            'room_number' => 'nullable|string|max:50',
            'address' => 'nullable|string'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');
        
        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            $lastLocation = OfficeLocation::withTrashed()->orderBy('id', 'desc')->first();
            $nextNumber = $lastLocation ? ($lastLocation->id + 1) : 1;
            $validated['code'] = 'LOC' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        OfficeLocation::create($validated);

        return redirect()->route('office-locations.index')
            ->with('success', 'Office location created successfully.');
    }

    public function show(OfficeLocation $officeLocation)
    {
        $officeLocation->load(['creator', 'updater', 'deleter', 'users']);
        return view('office_locations.show', compact('officeLocation'));
    }

    public function edit(OfficeLocation $officeLocation)
    {
        return view('office_locations.edit', compact('officeLocation'));
    }

    public function update(Request $request, OfficeLocation $officeLocation)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:office_locations,code,' . $officeLocation->id,
            'name' => 'required|string|max:255',
            'building' => 'nullable|string|max:100',
            'floor' => 'nullable|string|max:50',
            'room_number' => 'nullable|string|max:50',
            'address' => 'nullable|string'
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        $officeLocation->update($validated);

        return redirect()->route('office-locations.index')
            ->with('success', 'Office location updated successfully.');
    }

    public function destroy(OfficeLocation $officeLocation)
    {
        $officeLocation->update(['deleted_by' => Auth::id()]);
        $officeLocation->delete();

        return redirect()->route('office-locations.index')
            ->with('success', 'Office Location deleted successfully.');
    }

    public function showImport()
    {
        return view('office_locations.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new OfficeLocationsImport();
            Excel::import($import, $request->file('file'));

            $failures = $import->failures();
            
            if ($failures->count() > 0) {
                $errorMessages = [];
                foreach ($failures as $failure) {
                    $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
                
                return redirect()->route('office-locations.import')
                    ->with('error', 'Some rows failed to import: ' . implode(' | ', $errorMessages));
            }

            return redirect()->route('office-locations.index')
                ->with('success', 'Office Locations imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('office-locations.import')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="office_locations_template.csv"',
        ];

        $columns = ['code', 'name', 'address', 'city', 'state', 'country', 'postal_code', 'phone', 'email', 'is_active'];
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['LOC-001', 'Head Office', '123 Main St', 'Kampala', 'Central', 'Uganda', '00256', '+256-123-4567', 'office@ucaa.go.ug', 'true']);
            fputcsv($file, ['LOC-002', 'Branch Office', '456 Park Ave', 'Entebbe', 'Central', 'Uganda', '00257', '+256-987-6543', 'branch@ucaa.go.ug', 'true']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
