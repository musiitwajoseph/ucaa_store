<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\OfficeLocation;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reports-view');
    }

    /**
     * Display reports dashboard
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Users Report
     */
    public function users(Request $request)
    {
        $query = User::with(['department', 'jobTitle', 'officeLocation', 'roles']);

        // Apply filters
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('job_title_id')) {
            $query->where('job_title_id', $request->job_title_id);
        }

        if ($request->filled('office_location_id')) {
            $query->where('office_location_id', $request->office_location_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('is_ldap_user')) {
            $query->where('is_ldap_user', $request->is_ldap_user);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        // Get filter options
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $jobTitles = JobTitle::where('is_active', true)->orderBy('title')->get();
        $officeLocations = OfficeLocation::where('is_active', true)->orderBy('name')->get();

        // Handle export
        if ($request->has('export')) {
            return $this->exportUsers($users, $request->export);
        }

        return view('reports.users', compact('users', 'departments', 'jobTitles', 'officeLocations'));
    }

    /**
     * Roles & Permissions Report
     */
    public function rolesPermissions(Request $request)
    {
        $roles = Role::with(['permissions.module', 'users'])
            ->withCount(['permissions', 'users'])
            ->orderBy('name')
            ->get();

        // Handle export
        if ($request->has('export')) {
            return $this->exportRolesPermissions($roles, $request->export);
        }

        return view('reports.roles-permissions', compact('roles'));
    }

    /**
     * Departments Report
     */
    public function departments(Request $request)
    {
        $departments = Department::withCount('users')
            ->with(['creator', 'updater'])
            ->orderBy('name')
            ->get();

        // Handle export
        if ($request->has('export')) {
            return $this->exportDepartments($departments, $request->export);
        }

        return view('reports.departments', compact('departments'));
    }

    /**
     * User Activity Report (Audit Logs)
     */
    public function userActivity(Request $request)
    {
        $query = AuditLog::with(['user']);

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('auditable_type')) {
            $query->where('auditable_type', $request->auditable_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(50);
        $users = User::where('is_active', true)->orderBy('name')->get();

        // Handle export
        if ($request->has('export')) {
            return $this->exportUserActivity($query->get(), $request->export);
        }

        return view('reports.user-activity', compact('activities', 'users'));
    }

    /**
     * System Summary Report
     */
    public function summary()
    {
        $data = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'ldap_users' => User::where('is_ldap_user', true)->count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'total_departments' => Department::count(),
            'active_departments' => Department::where('is_active', true)->count(),
            'total_job_titles' => JobTitle::count(),
            'total_office_locations' => OfficeLocation::count(),
            'total_roles' => Role::count(),
            'active_roles' => Role::where('is_active', true)->count(),
            'users_by_department' => User::select('department_id', DB::raw('count(*) as count'))
                ->with('department')
                ->groupBy('department_id')
                ->orderBy('count', 'desc')
                ->get(),
            'users_by_job_title' => User::select('job_title_id', DB::raw('count(*) as count'))
                ->with('jobTitle')
                ->groupBy('job_title_id')
                ->orderBy('count', 'desc')
                ->get(),
            'users_by_office' => User::select('office_location_id', DB::raw('count(*) as count'))
                ->with('officeLocation')
                ->groupBy('office_location_id')
                ->orderBy('count', 'desc')
                ->get(),
            'recent_users' => User::orderBy('created_at', 'desc')->take(10)->get(),
            'recent_logins' => User::whereNotNull('last_login_at')
                ->orderBy('last_login_at', 'desc')
                ->take(10)
                ->get(),
        ];

        return view('reports.summary', $data);
    }

    /**
     * Export Users to Excel/PDF
     */
    private function exportUsers($users, $format)
    {
        if ($format === 'excel') {
            return Excel::download(new \App\Exports\UsersReportExport($users), 'users_report_' . date('Y-m-d') . '.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = PDF::loadView('reports.exports.users-pdf', compact('users'));
            return $pdf->download('users_report_' . date('Y-m-d') . '.pdf');
        }
    }

    /**
     * Export Roles & Permissions to Excel/PDF
     */
    private function exportRolesPermissions($roles, $format)
    {
        if ($format === 'excel') {
            return Excel::download(new \App\Exports\RolesPermissionsExport($roles), 'roles_permissions_report_' . date('Y-m-d') . '.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = PDF::loadView('reports.exports.roles-permissions-pdf', compact('roles'));
            return $pdf->download('roles_permissions_report_' . date('Y-m-d') . '.pdf');
        }
    }

    /**
     * Export Departments to Excel/PDF
     */
    private function exportDepartments($departments, $format)
    {
        if ($format === 'excel') {
            return Excel::download(new \App\Exports\DepartmentsReportExport($departments), 'departments_report_' . date('Y-m-d') . '.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = PDF::loadView('reports.exports.departments-pdf', compact('departments'));
            return $pdf->download('departments_report_' . date('Y-m-d') . '.pdf');
        }
    }

    /**
     * Export User Activity to Excel/PDF
     */
    private function exportUserActivity($activities, $format)
    {
        if ($format === 'excel') {
            return Excel::download(new \App\Exports\UserActivityExport($activities), 'user_activity_report_' . date('Y-m-d') . '.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = PDF::loadView('reports.exports.user-activity-pdf', compact('activities'));
            return $pdf->download('user_activity_report_' . date('Y-m-d') . '.pdf');
        }
    }
}
