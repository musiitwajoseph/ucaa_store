<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\OfficeLocation;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users-view')->only(['index', 'show']);
        $this->middleware('permission:users-create')->only(['create', 'store']);
        $this->middleware('permission:users-edit')->only(['edit', 'update']);
        $this->middleware('permission:users-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with(['department', 'jobTitle', 'officeLocation', 'roles'])
                ->select('users.*');

            return datatables()
                ->eloquent($users)
                ->addColumn('department_name', function($user) {
                    return $user->department ? $user->department->name : 'N/A';
                })
                ->addColumn('job_title', function($user) {
                    return $user->jobTitle ? $user->jobTitle->title : 'N/A';
                })
                ->addColumn('office_location', function($user) {
                    return $user->officeLocation ? $user->officeLocation->name : 'N/A';
                })
                ->addColumn('roles_display', function($user) {
                    return $user->roles->pluck('name')->implode(', ') ?: 'No roles';
                })
                ->addColumn('actions', function($user) {
                    $disabled = $user->id === Auth::id() ? 'disabled' : '';
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-dots-three-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="'.route('users.show', $user).'">
                                        <i class="ph-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="'.route('users.edit', $user).'">
                                        <i class="ph-pencil me-2"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger '.($user->id === Auth::id() ? 'disabled' : '').'" href="#" onclick="'.($user->id === Auth::id() ? 'return false;' : 'deleteUser('.$user->id.'); return false;').'">
                                        <i class="ph-trash me-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->editColumn('created_at', function($user) {
                    return $user->created_at->format('M d, Y H:i');
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('users.index');
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        $jobTitles = JobTitle::active()->orderBy('title')->get();
        $officeLocations = OfficeLocation::active()->orderBy('name')->get();
        $roles = Role::active()->orderBy('name')->get();
        
        return view('users.create', compact('departments', 'jobTitles', 'officeLocations', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:users,code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'job_title_id' => 'nullable|exists:job_titles,id',
            'office_location_id' => 'nullable|exists:office_locations,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        DB::beginTransaction();
        try {
            $validated['password'] = Hash::make($validated['password']);
            
            $user = User::create($validated);
            
            // Assign roles
            if ($request->has('roles')) {
                foreach ($request->roles as $roleId) {
                    $user->roles()->attach($roleId, [
                        'assigned_by' => Auth::id(),
                        'assigned_at' => now()
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create user.']);
        }
    }

    public function show(User $user)
    {
        $user->load(['department', 'jobTitle', 'officeLocation', 'roles.permissions', 'permissions']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $departments = Department::active()->orderBy('name')->get();
        $jobTitles = JobTitle::active()->orderBy('title')->get();
        $officeLocations = OfficeLocation::active()->orderBy('name')->get();
        $roles = Role::active()->orderBy('name')->get();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('users.edit', compact('user', 'departments', 'jobTitles', 'officeLocations', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:users,code,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'job_title_id' => 'nullable|exists:job_titles,id',
            'office_location_id' => 'nullable|exists:office_locations,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        DB::beginTransaction();
        try {
            // Only update password if provided
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }
            
            $user->update($validated);
            
            // Sync roles with audit tracking
            $roles = [];
            if ($request->has('roles')) {
                foreach ($request->roles as $roleId) {
                    $roles[$roleId] = [
                        'assigned_by' => Auth::id(),
                        'assigned_at' => now()
                    ];
                }
            }
            $user->roles()->sync($roles);
            
            DB::commit();
            return redirect()->route('users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update user.']);
        }
    }

    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function showImport()
    {
        return view('users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new UsersImport();
            Excel::import($import, $request->file('file'));

            $failures = $import->failures();
            
            if ($failures->count() > 0) {
                $errorMessages = [];
                foreach ($failures as $failure) {
                    $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
                
                return redirect()->route('users.import')
                    ->with('error', 'Some rows failed to import: ' . implode(' | ', $errorMessages));
            }

            return redirect()->route('users.index')
                ->with('success', 'Users imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.import')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_template.csv"',
        ];

        $columns = ['code', 'first_name', 'last_name', 'email', 'username', 'password', 'phone', 'mobile', 'employee_id', 'department_code', 'job_title_code', 'office_location_code', 'is_active', 'is_admin'];
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['USR-001', 'John', 'Doe', 'john.doe@ucaa.go.ug', 'jdoe', 'password123', '+256-111-1111', '+256-777-1111', 'EMP001', 'DEPT-001', 'JOB-001', 'LOC-001', 'true', 'false']);
            fputcsv($file, ['USR-002', 'Jane', 'Smith', 'jane.smith@ucaa.go.ug', 'jsmith', 'password123', '+256-222-2222', '+256-777-2222', 'EMP002', 'DEPT-002', 'JOB-002', 'LOC-001', 'true', 'false']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
