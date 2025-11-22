@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">My Profile</h4>
            <p class="text-muted mb-0">View your profile information</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="ph-pencil me-2"></i>Edit Profile
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Profile Header -->
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ $user->avatar_url }}" class="rounded-circle" width="120" height="120" alt="{{ $user->full_name }}">
                    </div>
                    <h5 class="mb-0">{{ $user->full_name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                    @if($user->jobTitle)
                        <span class="badge bg-primary">{{ $user->jobTitle->title }}</span>
                    @endif
                    @if($user->department)
                        <span class="badge bg-info">{{ $user->department->name }}</span>
                    @endif
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 30%;">Full Name</td>
                                <td class="fw-semibold">{{ $user->full_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td class="fw-semibold">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Username</td>
                                <td class="fw-semibold">{{ $user->username ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Employee ID</td>
                                <td class="fw-semibold">{{ $user->employee_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Phone</td>
                                <td class="fw-semibold">{{ $user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Mobile</td>
                                <td class="fw-semibold">{{ $user->mobile ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Date of Birth</td>
                                <td class="fw-semibold">{{ $user->date_of_birth ? $user->date_of_birth->format('F d, Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Gender</td>
                                <td class="fw-semibold">{{ $user->gender ? ucfirst($user->gender) : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contact Information -->
            @if($user->address || $user->city || $user->state || $user->country)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            @if($user->address)
                            <tr>
                                <td class="text-muted" style="width: 30%;">Address</td>
                                <td class="fw-semibold">{{ $user->address }}</td>
                            </tr>
                            @endif
                            @if($user->city)
                            <tr>
                                <td class="text-muted">City</td>
                                <td class="fw-semibold">{{ $user->city }}</td>
                            </tr>
                            @endif
                            @if($user->state)
                            <tr>
                                <td class="text-muted">State/Province</td>
                                <td class="fw-semibold">{{ $user->state }}</td>
                            </tr>
                            @endif
                            @if($user->country)
                            <tr>
                                <td class="text-muted">Country</td>
                                <td class="fw-semibold">{{ $user->country }}</td>
                            </tr>
                            @endif
                            @if($user->postal_code)
                            <tr>
                                <td class="text-muted">Postal Code</td>
                                <td class="fw-semibold">{{ $user->postal_code }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Organization Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Organization Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 30%;">Department</td>
                                <td class="fw-semibold">{{ $user->department->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Job Title</td>
                                <td class="fw-semibold">{{ $user->jobTitle->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Office Location</td>
                                <td class="fw-semibold">{{ $user->officeLocation->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Manager</td>
                                <td class="fw-semibold">{{ $user->manager->full_name ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bio -->
            @if($user->bio)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">About Me</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $user->bio }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                        <i class="ph-pencil me-2"></i>Edit Profile
                    </a>
                    <a href="{{ route('profile.security') }}" class="list-group-item list-group-item-action">
                        <i class="ph-lock-key me-2"></i>Change Password
                    </a>
                    <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                        <i class="ph-gear me-2"></i>Account Settings
                    </a>
                </div>
            </div>

            <!-- Account Status -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Account Status</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status:</span>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Account Type:</span>
                        <span class="badge bg-info">
                            {{ $user->is_ldap_user ? 'LDAP' : 'Local' }}
                        </span>
                    </div>
                    @if($user->is_admin)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Administrator:</span>
                        <span class="badge bg-warning">Yes</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Last Login:</span>
                        <span class="fw-semibold">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Roles & Permissions -->
            @if($user->roles->count() > 0)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Roles & Permissions</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-2">Assigned Roles</h6>
                    <div class="mb-3">
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary me-1 mb-1">{{ $role->name }}</span>
                        @endforeach
                    </div>
                    
                    <h6 class="mb-2">Total Permissions</h6>
                    <p class="mb-0">
                        <span class="badge bg-info">{{ $user->getAllPermissions()->count() }} permissions</span>
                    </p>
                </div>
            </div>
            @endif

            <!-- Account Preferences -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Preferences</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted">Timezone:</td>
                                <td class="fw-semibold text-end">{{ $user->timezone ?? 'UTC' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Language:</td>
                                <td class="fw-semibold text-end">{{ $user->locale ?? 'English' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Theme:</td>
                                <td class="fw-semibold text-end">{{ $user->theme ? ucfirst($user->theme) : 'Light' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
