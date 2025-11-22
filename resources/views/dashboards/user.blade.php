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
                            <span class="fw-semibold">1.0.0</span>
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
