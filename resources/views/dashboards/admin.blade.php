@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')

@component('components.breadcrumb')
    @slot('title') Admin Dashboard @endslot
    @slot('subtitle') Home @endslot
    @slot('breadcrumb_items')
        <span class="breadcrumb-item active">Dashboard</span>
    @endslot
@endcomponent

<div class="container-fluid mt-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #003DA5 0%, #0052d9 100%);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-white">
                            <h3 class="mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                            <p class="mb-0 opacity-75">{{ now()->format('l, F j, Y') }}</p>
                            <span class="badge bg-white text-primary mt-2">
                                <i class="ph-shield-check me-1"></i> Administrator
                            </span>
                        </div>
                        <div class="text-white d-none d-md-block">
                            <i class="ph-shield-star" style="font-size: 64px; opacity: 0.3;"></i>
                        </div>
                    </div>

                    @php
                        $dashboardHolidays = \App\Models\PublicHoliday::forDashboard()->limit(3)->get();
                    @endphp

                    @if($dashboardHolidays->isNotEmpty())
                    <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                        <h6 class="text-white mb-3">
                            <i class="ph-calendar-check me-2"></i>Upcoming Holidays
                        </h6>
                        <div class="row g-3">
                            @foreach($dashboardHolidays as $holiday)
                            @php
                                // Set beautiful gradient colors based on holiday type
                                $cardStyles = [
                                    'public' => 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);',
                                    'religious' => 'background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);',
                                    'internal' => 'background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);'
                                ];
                                $cardStyle = $cardStyles[$holiday->type] ?? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);';
                                
                                $typeIcons = [
                                    'public' => 'ph-flag',
                                    'religious' => 'ph-star',
                                    'internal' => 'ph-buildings'
                                ];
                                $icon = $typeIcons[$holiday->type] ?? 'ph-calendar';
                            @endphp
                            <div class="col-md-4">
                                <div class="rounded-3 p-3 position-relative overflow-hidden" style="{{ $cardStyle }} transition: all 0.3s ease;">
                                    <!-- Decorative pattern -->
                                    <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 100px; margin-top: -20px; margin-right: -20px;">
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                    
                                    <div class="d-flex align-items-start position-relative">
                                        <div class="flex-shrink-0">
                                            @php
                                                $daysUntil = $holiday->daysUntil();
                                            @endphp
                                            @if($daysUntil == 0)
                                                <div class="bg-white rounded-3 px-3 py-2 text-center shadow-sm" style="min-width: 70px;">
                                                    <div class="text-danger fw-bold" style="font-size: 11px; letter-spacing: 1px;">TODAY</div>
                                                    <div class="text-dark fw-bold" style="font-size: 24px; line-height: 1;">{{ $holiday->getDisplayDate()->format('d') }}</div>
                                                    <div class="text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">{{ $holiday->getDisplayDate()->format('M') }}</div>
                                                </div>
                                            @else
                                                <div class="bg-white rounded-3 px-3 py-2 text-center shadow-sm" style="min-width: 70px;">
                                                    <div class="text-dark fw-bold" style="font-size: 28px; line-height: 1; margin-bottom: 2px;">{{ $holiday->getDisplayDate()->format('d') }}</div>
                                                    <div class="text-muted fw-semibold" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">{{ $holiday->getDisplayDate()->format('M') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <h6 class="text-white mb-0 fw-bold" style="font-size: 15px;">{{ $holiday->name }}</h6>
                                                <span class="badge bg-white bg-opacity-25 ms-2" style="font-size: 10px; padding: 3px 8px;">
                                                    <i class="{{ $icon }} me-1" style="font-size: 10px;"></i>{{ ucfirst($holiday->type) }}
                                                </span>
                                            </div>
                                            <p class="text-white mb-2" style="font-size: 13px; line-height: 1.5; opacity: 0.95;">
                                                {{ Str::limit(strip_tags($holiday->getDashboardMessage()), 80) }}
                                            </p>
                                            <div class="d-flex align-items-center">
                                                @if($daysUntil == 0)
                                                    <span class="badge bg-white text-danger fw-semibold" style="font-size: 11px; padding: 4px 10px;">
                                                        <i class="ph-check-circle me-1"></i>Today
                                                    </span>
                                                @elseif($daysUntil == 1)
                                                    <span class="badge bg-white text-warning fw-semibold" style="font-size: 11px; padding: 4px 10px;">
                                                        <i class="ph-clock me-1"></i>Tomorrow
                                                    </span>
                                                @else
                                                    <span class="badge bg-white bg-opacity-25 text-white fw-normal" style="font-size: 11px; padding: 4px 10px;">
                                                        <i class="ph-calendar-blank me-1"></i>{{ $daysUntil }} days away
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        @php
            $totalUsers = \App\Models\User::count();
            $activeUsers = \App\Models\User::where('is_active', true)->count();
            $totalDepartments = \App\Models\Department::count();
            $totalRoles = \App\Models\Role::count();
        @endphp

        <!-- Total Users -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="ph-users text-primary" style="font-size: 32px;"></i>
                        </div>
                        <span class="badge bg-success">+12%</span>
                    </div>
                    <h3 class="mb-1">{{ $totalUsers }}</h3>
                    <p class="text-muted mb-0">Total Users</p>
                    <small class="text-success">
                        <i class="ph-trend-up"></i> {{ $activeUsers }} Active
                    </small>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="ph-buildings text-success" style="font-size: 32px;"></i>
                        </div>
                        <span class="badge bg-info">{{ \App\Models\Department::where('is_active', true)->count() }} Active</span>
                    </div>
                    <h3 class="mb-1">{{ $totalDepartments }}</h3>
                    <p class="text-muted mb-0">Departments</p>
                    <small class="text-muted">
                        <i class="ph-buildings"></i> Organization Units
                    </small>
                </div>
            </div>
        </div>

        <!-- Roles -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="ph-shield-check text-warning" style="font-size: 32px;"></i>
                        </div>
                        <span class="badge bg-primary">{{ \App\Models\Role::where('is_active', true)->count() }} Active</span>
                    </div>
                    <h3 class="mb-1">{{ $totalRoles }}</h3>
                    <p class="text-muted mb-0">Roles</p>
                    <small class="text-muted">
                        <i class="ph-lock-key"></i> Access Control
                    </small>
                </div>
            </div>
        </div>

        <!-- Job Titles -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="ph-briefcase text-info" style="font-size: 32px;"></i>
                        </div>
                        <span class="badge bg-secondary">{{ \App\Models\JobTitle::where('is_active', true)->count() }} Active</span>
                    </div>
                    <h3 class="mb-1">{{ \App\Models\JobTitle::count() }}</h3>
                    <p class="text-muted mb-0">Job Titles</p>
                    <small class="text-muted">
                        <i class="ph-suitcase"></i> Position Types
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row g-4 mb-4">
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-lightning text-warning me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @can('users-create')
                        <a href="{{ route('users.create') }}" class="btn btn-outline-primary text-start">
                            <i class="ph-user-plus me-2"></i> Add New User
                        </a>
                        @endcan
                        
                        @can('departments-create')
                        <a href="{{ route('departments.create') }}" class="btn btn-outline-success text-start">
                            <i class="ph-buildings me-2"></i> Create Department
                        </a>
                        @endcan
                        
                        @can('roles-create')
                        <a href="{{ route('roles.create') }}" class="btn btn-outline-warning text-start">
                            <i class="ph-shield-plus me-2"></i> Create Role
                        </a>
                        @endcan
                        
                        @can('reports-view')
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-info text-start">
                            <i class="ph-chart-bar me-2"></i> View Reports
                        </a>
                        @endcan

                        @can('audit-logs-view')
                        <a href="{{ route('audit-logs.index') }}" class="btn btn-outline-secondary text-start">
                            <i class="ph-clock-counter-clockwise me-2"></i> Audit Trail
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-activity text-success me-2"></i> System Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Active Users</span>
                            <span class="fw-semibold">{{ number_format(($activeUsers / max($totalUsers, 1)) * 100, 1) }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ ($activeUsers / max($totalUsers, 1)) * 100 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Active Departments</span>
                            <span class="fw-semibold">{{ number_format((\App\Models\Department::where('is_active', true)->count() / max($totalDepartments, 1)) * 100, 1) }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" 
                                 style="width: {{ (\App\Models\Department::where('is_active', true)->count() / max($totalDepartments, 1)) * 100 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">LDAP Users</span>
                            <span class="fw-semibold">{{ \App\Models\User::where('is_ldap_user', true)->count() }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                 style="width: {{ (\App\Models\User::where('is_ldap_user', true)->count() / max($totalUsers, 1)) * 100 }}%"></div>
                        </div>
                    </div>

                    <div class="alert alert-success mb-0 py-2">
                        <i class="ph-check-circle me-1"></i> All systems operational
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-clock-clockwise text-primary me-2"></i> Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    <div class="list-group list-group-flush">
                        @forelse($recentUsers as $user)
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->avatar_url }}" class="rounded-circle me-3" width="32" height="32" alt="{{ $user->full_name }}" style="object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <small class="text-muted">Joined {{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3">
                            <i class="ph-info mb-2" style="font-size: 32px;"></i>
                            <p class="mb-0">No recent activity</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4">
        <!-- User Distribution -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-chart-bar text-primary me-2"></i> User Distribution by Department
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $usersByDept = \App\Models\User::select('department_id', \DB::raw('count(*) as count'))
                            ->with('department')
                            ->groupBy('department_id')
                            ->orderBy('count', 'desc')
                            ->take(8)
                            ->get();
                        $maxCount = $usersByDept->max('count') ?: 1;
                    @endphp

                    @forelse($usersByDept as $dept)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold">{{ $dept->department ? $dept->department->name : 'Unassigned' }}</span>
                            <span class="text-muted">{{ $dept->count }} users</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                 style="width: {{ ($dept->count / $maxCount) * 100 }}%">
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="ph-chart-bar mb-2" style="font-size: 48px;"></i>
                        <p class="mb-0">No data available</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-info text-info me-2"></i> Quick Stats
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center g-3">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="mb-0 text-primary">{{ \App\Models\OfficeLocation::count() }}</h4>
                                <small class="text-muted">Offices</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="mb-0 text-success">{{ \App\Models\Permission::count() }}</h4>
                                <small class="text-muted">Permissions</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="mb-0 text-warning">{{ \App\Models\Module::count() }}</h4>
                                <small class="text-muted">Modules</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="mb-0 text-info">{{ \App\Models\User::where('is_admin', true)->count() }}</h4>
                                <small class="text-muted">Admins</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-grid">
                        @can('reports-view')
                        <a href="{{ route('reports.summary') }}" class="btn btn-primary">
                            <i class="ph-chart-line me-2"></i> View Full Report
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
