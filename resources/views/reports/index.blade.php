@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Reports & Analytics</h4>
            <p class="text-muted mb-0">View and export system reports</p>
        </div>
    </div>

    <!-- Reports Grid -->
    <div class="row g-4">
        <!-- System Summary Card -->
        @can('reports-view')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-chart-pie ph-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">System Summary</h5>
                            <p class="text-muted small mb-0">Overview of system statistics</p>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        View comprehensive system statistics including user counts, active departments, roles distribution, and recent activity.
                    </p>
                    <a href="{{ route('reports.summary') }}" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="ph-chart-bar me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        @endcan

        <!-- Users Report Card -->
        @can('reports-view')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-users ph-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">Users Report</h5>
                            <p class="text-muted small mb-0">Detailed user information</p>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        View and filter user data by department, job title, office location, status, and date range. Export to Excel or PDF.
                    </p>
                    <a href="{{ route('reports.users') }}" class="btn btn-outline-success btn-sm mt-2">
                        <i class="ph-file-text me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        @endcan

        <!-- Roles & Permissions Report Card -->
        @can('reports-view')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-shield-check ph-2x text-info"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">Roles & Permissions</h5>
                            <p class="text-muted small mb-0">Access control overview</p>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        View all roles with their assigned permissions and user counts. Understand your system's access control structure.
                    </p>
                    <a href="{{ route('reports.roles-permissions') }}" class="btn btn-outline-info btn-sm mt-2">
                        <i class="ph-key me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        @endcan

        <!-- Departments Report Card -->
        @can('reports-view')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-buildings ph-2x text-warning"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">Departments Report</h5>
                            <p class="text-muted small mb-0">Department statistics</p>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        View department information with user counts, active status, and creation details. Export for analysis.
                    </p>
                    <a href="{{ route('reports.departments') }}" class="btn btn-outline-warning btn-sm mt-2">
                        <i class="ph-tree-structure me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        @endcan

        <!-- User Activity Report Card -->
        @can('reports-view')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-danger bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-clock-counter-clockwise ph-2x text-danger"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">User Activity</h5>
                            <p class="text-muted small mb-0">Audit log viewer</p>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        Track user actions with detailed audit logs. Filter by user, event type, date range, and export activity data.
                    </p>
                    <a href="{{ route('reports.user-activity') }}" class="btn btn-outline-danger btn-sm mt-2">
                        <i class="ph-clock me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        @endcan

        <!-- Coming Soon Placeholder -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-secondary bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-dots-three ph-2x text-secondary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">More Reports</h5>
                            <p class="text-muted small mb-0">Additional reports coming soon</p>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        Additional report types will be added based on your needs. Contact support for custom report requests.
                    </p>
                    <button class="btn btn-outline-secondary btn-sm mt-2" disabled>
                        <i class="ph-hourglass-medium me-1"></i> Coming Soon
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="mb-3"><i class="ph-info text-primary me-2"></i> Report Features</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-start mb-3">
                                <i class="ph-funnel text-primary me-2 mt-1"></i>
                                <div>
                                    <strong>Advanced Filtering</strong>
                                    <p class="text-muted small mb-0">Filter data by multiple criteria</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-start mb-3">
                                <i class="ph-file-xls text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Excel Export</strong>
                                    <p class="text-muted small mb-0">Download reports as Excel files</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-start mb-3">
                                <i class="ph-file-pdf text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>PDF Export</strong>
                                    <p class="text-muted small mb-0">Generate printable PDF reports</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-start mb-3">
                                <i class="ph-calendar text-info me-2 mt-1"></i>
                                <div>
                                    <strong>Date Ranges</strong>
                                    <p class="text-muted small mb-0">Filter by custom date ranges</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-body {
    display: flex;
    flex-direction: column;
}

.card-body .btn {
    margin-top: auto;
}
</style>
@endsection
