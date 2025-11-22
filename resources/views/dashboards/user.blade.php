@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@component('components.breadcrumb')
    @slot('title') Dashboard @endslot
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
                        </div>
                        <div class="text-white d-none d-md-block">
                            <i class="ph-user-circle" style="font-size: 64px; opacity: 0.3;"></i>
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

    <!-- User Profile Overview -->
    <div class="row g-4 mb-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-user-circle text-primary me-2"></i> My Profile
                    </h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle mb-3" width="100" height="100" alt="{{ auth()->user()->full_name }}" style="object-fit: cover;">
                    <h5 class="mb-1">{{ auth()->user()->full_name }}</h5>
                    <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                    @if(auth()->user()->department)
                        <span class="badge bg-primary mb-2">{{ auth()->user()->department->name }}</span>
                    @endif
                    @if(auth()->user()->jobTitle)
                        <p class="text-muted small mb-3">{{ auth()->user()->jobTitle->name }}</p>
                    @endif
                    
                    <hr class="my-3">
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.show') }}" class="btn btn-outline-primary btn-sm">
                            <i class="ph-user-circle me-1"></i> View Profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ph-pencil me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Cards -->
        <div class="col-lg-8">
            <div class="row g-4">
                <!-- Account Status -->
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-success bg-opacity-10 rounded p-3">
                                    <i class="ph-check-circle text-success" style="font-size: 32px;"></i>
                                </div>
                                <span class="badge bg-success">Active</span>
                            </div>
                            <h5 class="mb-1">Account Status</h5>
                            <p class="text-muted mb-0">Your account is active and verified</p>
                        </div>
                    </div>
                </div>

                <!-- Member Since -->
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-info bg-opacity-10 rounded p-3">
                                    <i class="ph-calendar-check text-info" style="font-size: 32px;"></i>
                                </div>
                                <span class="badge bg-info">{{ auth()->user()->created_at->diffForHumans() }}</span>
                            </div>
                            <h5 class="mb-1">Member Since</h5>
                            <p class="text-muted mb-0">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- My Roles -->
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-warning bg-opacity-10 rounded p-3">
                                    <i class="ph-shield-check text-warning" style="font-size: 32px;"></i>
                                </div>
                                <span class="badge bg-warning">{{ auth()->user()->roles->count() }}</span>
                            </div>
                            <h5 class="mb-1">My Roles</h5>
                            <p class="text-muted mb-0">
                                @forelse(auth()->user()->roles->take(2) as $role)
                                    {{ $role->name }}@if(!$loop->last), @endif
                                @empty
                                    No roles assigned
                                @endforelse
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Last Login -->
                <div class="col-sm-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-primary bg-opacity-10 rounded p-3">
                                    <i class="ph-clock text-primary" style="font-size: 32px;"></i>
                                </div>
                                <span class="badge bg-primary">Recent</span>
                            </div>
                            <h5 class="mb-1">Last Login</h5>
                            <p class="text-muted mb-0">
                                @if(auth()->user()->last_login_at)
                                    {{ auth()->user()->last_login_at->format('M j, Y g:i A') }}
                                @else
                                    First login
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Information -->
    <div class="row g-4 mb-4">
        <!-- Quick Actions -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-lightning text-warning me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary text-start">
                            <i class="ph-pencil me-2"></i> Update My Profile
                        </a>
                        
                        <a href="{{ route('profile.security') }}" class="btn btn-outline-warning text-start">
                            <i class="ph-lock-key me-2"></i> Change Password
                        </a>
                        
                        <a href="{{ route('profile.settings') }}" class="btn btn-outline-info text-start">
                            <i class="ph-gear me-2"></i> Account Settings
                        </a>

                        @can('reports-view')
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-success text-start">
                            <i class="ph-chart-bar me-2"></i> View Reports
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- My Department Info -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-buildings text-success me-2"></i> Department Information
                    </h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->department)
                        <div class="mb-3">
                            <label class="text-muted small">Department</label>
                            <h6 class="mb-0">{{ auth()->user()->department->name }}</h6>
                        </div>

                        @if(auth()->user()->department->description)
                        <div class="mb-3">
                            <label class="text-muted small">Description</label>
                            <p class="mb-0">{{ Str::limit(auth()->user()->department->description, 100) }}</p>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="text-muted small">Department Members</label>
                            <h6 class="mb-0">{{ auth()->user()->department->users->count() }} users</h6>
                        </div>

                        @if(auth()->user()->officeLocation)
                        <div class="mb-3">
                            <label class="text-muted small">Office Location</label>
                            <h6 class="mb-0">{{ auth()->user()->officeLocation->name }}</h6>
                        </div>
                        @endif
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="ph-buildings mb-2" style="font-size: 48px;"></i>
                            <p class="mb-0">No department assigned</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Notifications & Activity -->
    <div class="row g-4">
        <!-- Notifications -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ph-bell text-primary me-2"></i> Recent Notifications
                    </h5>
                    <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="card-body">
                    @php
                        $notifications = auth()->user()->notifications->take(5);
                    @endphp
                    <div class="list-group list-group-flush">
                        @forelse($notifications as $notification)
                        <div class="list-group-item border-0 px-0 py-2 {{ $notification->read_at ? '' : 'bg-light' }}">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="ph-bell text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $notification->data['message'] ?? 'Notification' }}</div>
                                    <small class="text-muted">
                                        <i class="ph-clock me-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-4">
                            <i class="ph-bell-slash mb-2" style="font-size: 48px;"></i>
                            <p class="mb-0">No notifications yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="ph-info text-info me-2"></i> System Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">System Version</span>
                            <span class="fw-semibold">{{ \App\Helpers\VersionHelper::formatted('full') }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Release Date</span>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse(\App\Helpers\VersionHelper::releaseDate())->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Departments</span>
                            <span class="fw-semibold">{{ \App\Models\Department::where('is_active', true)->count() }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Active Users</span>
                            <span class="fw-semibold">{{ \App\Models\User::where('is_active', true)->count() }}</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="alert alert-info mb-0 py-2">
                        <i class="ph-info me-1"></i> Need help? Contact your administrator
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
