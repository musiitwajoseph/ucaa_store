@extends('layouts.master')

@section('title', 'System Summary Report')

@section('content')
<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">System Summary Report</h2>
            <p class="text-muted mb-0">Overview of system statistics and activity</p>
        </div>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
            <i class="ph-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Users Statistics -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-users ph-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $total_users }}</h3>
                            <p class="text-muted mb-0 small">Total Users</p>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-success me-2">
                            <i class="ph-check-circle"></i> {{ $active_users }} Active
                        </span>
                        <span class="text-danger">
                            <i class="ph-x-circle"></i> {{ $inactive_users }} Inactive
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- LDAP Users -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-git-branch ph-2x text-info"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $ldap_users }}</h3>
                            <p class="text-muted mb-0 small">LDAP Users</p>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-warning">
                            <i class="ph-shield-check"></i> {{ $admin_users }} Admins
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-buildings ph-2x text-success"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $total_departments }}</h3>
                            <p class="text-muted mb-0 small">Departments</p>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-success">
                            <i class="ph-check-circle"></i> {{ $active_departments }} Active
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-shield-check ph-2x text-warning"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $total_roles }}</h3>
                            <p class="text-muted mb-0 small">Roles</p>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-success">
                            <i class="fas fa-check-circle"></i> {{ $active_roles }} Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution Charts -->
    <div class="row g-4 mb-4">
        <!-- Users by Department -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ph-buildings text-primary me-2"></i> Users by Department</h5>
                </div>
                <div class="card-body">
                    @if($users_by_department->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($users_by_department as $dept)
                                <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                                    <span>{{ $dept->department ? $dept->department->name : 'Unassigned' }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $dept->count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">No department data available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Users by Job Title -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ph-briefcase text-success me-2"></i> Users by Job Title</h5>
                </div>
                <div class="card-body">
                    @if($users_by_job_title->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($users_by_job_title as $job)
                                <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                                    <span>{{ $job->jobTitle ? $job->jobTitle->title : 'Unassigned' }}</span>
                                    <span class="badge bg-success rounded-pill">{{ $job->count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">No job title data available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Users by Office -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ph-map-pin text-info me-2"></i> Users by Office Location</h5>
                </div>
                <div class="card-body">
                    @if($users_by_office->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($users_by_office as $office)
                                <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                                    <span>{{ $office->officeLocation ? $office->officeLocation->name : 'Unassigned' }}</span>
                                    <span class="badge bg-info rounded-pill">{{ $office->count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">No office location data available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4">
        <!-- Recently Created Users -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ph-user-plus text-primary me-2"></i> Recently Created Users</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm eagle-table2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No recent users</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Logins -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ph-sign-in text-success me-2"></i> Recent Logins</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm eagle-table2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Last Login</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_logins as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</td>
                                        <td>
                                            @if($user->is_ldap_user)
                                                <span class="badge bg-info">LDAP</span>
                                            @else
                                                <span class="badge bg-secondary">Local</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No login data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4 class="mb-0">{{ $total_job_titles }}</h4>
                            <p class="text-muted mb-0">Job Titles</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="mb-0">{{ $total_office_locations }}</h4>
                            <p class="text-muted mb-0">Office Locations</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="mb-0">{{ number_format(($active_users / max($total_users, 1)) * 100, 1) }}%</h4>
                            <p class="text-muted mb-0">Active User Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
