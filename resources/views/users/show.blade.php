@extends('layouts.master')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                User Details
            </h4>
        </div>
        <div class="d-flex justify-content-lg-end my-2 my-lg-0 ms-lg-auto">
            <a href="{{ route('users.index') }}" class="btn btn-light me-2">
                <i class="ph-list me-2"></i>Back to List
            </a>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary me-2">
                <i class="ph-pencil me-2"></i>Edit
            </a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="ph-trash me-2"></i>Delete
                </button>
            </form>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <div class="row">
        <div class="col-lg-8">
            <!-- User Information -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Personal Information</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">User Code</label>
                            <div class="fw-semibold">{{ $user->code ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Username</label>
                            <div class="fw-semibold">{{ $user->username ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">First Name</label>
                            <div class="fw-semibold">{{ $user->first_name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Last Name</label>
                            <div class="fw-semibold">{{ $user->last_name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Email Address</label>
                            <div class="fw-semibold">
                                <i class="ph-envelope me-1"></i>{{ $user->email }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Phone Number</label>
                            <div class="fw-semibold">
                                <i class="ph-phone me-1"></i>{{ $user->phone ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Mobile Number</label>
                            <div class="fw-semibold">
                                <i class="ph-device-mobile me-1"></i>{{ $user->mobile ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Employee ID</label>
                            <div class="fw-semibold">{{ $user->employee_id ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small mb-1">Status</label>
                            <div>
                                @if($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                                @if($user->is_admin)
                                    <span class="badge bg-primary ms-2">Administrator</span>
                                @endif
                                @if($user->is_ldap_user)
                                    <span class="badge bg-info ms-2">LDAP User</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Organization Details -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Organization Details</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Department</label>
                            <div class="fw-semibold">
                                <i class="ph-buildings me-1"></i>{{ $user->department->name ?? 'Not assigned' }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Job Title</label>
                            <div class="fw-semibold">
                                <i class="ph-briefcase me-1"></i>{{ $user->jobTitle->title ?? 'Not assigned' }}
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small mb-1">Office Location</label>
                            <div class="fw-semibold">
                                @if($user->officeLocation)
                                    <i class="ph-map-pin me-1"></i>{{ $user->officeLocation->name }}
                                    @if($user->officeLocation->building)
                                        <div class="text-muted small mt-1 ms-4">
                                            {{ $user->officeLocation->building }}
                                            @if($user->officeLocation->floor), Floor {{ $user->officeLocation->floor }}@endif
                                            @if($user->officeLocation->room_number), Room {{ $user->officeLocation->room_number }}@endif
                                        </div>
                                    @endif
                                @else
                                    Not assigned
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Account Information</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Created At</label>
                            <div class="fw-semibold">{{ $user->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Updated At</label>
                            <div class="fw-semibold">{{ $user->updated_at->format('M d, Y H:i') }}</div>
                        </div>
                        @if($user->last_login_at)
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Last Login</label>
                            <div class="fw-semibold">{{ $user->last_login_at->format('M d, Y H:i') }}</div>
                        </div>
                        @endif
                        @if($user->last_login_ip)
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Last Login IP</label>
                            <div class="fw-semibold">{{ $user->last_login_ip }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Roles -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Assigned Roles</h6>
                </div>

                <div class="card-body">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <div class="mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $role->name }}</h6>
                                        @if($role->description)
                                            <p class="text-muted small mb-0">{{ $role->description }}</p>
                                        @endif
                                    </div>
                                    <span class="badge bg-info">{{ $role->permissions->count() }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="ph-user-circle-minus icon-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No roles assigned</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Permissions -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Permissions</h6>
                </div>

                <div class="card-body">
                    @php
                        $allPermissions = $user->getAllPermissions();
                        $groupedPermissions = $allPermissions->groupBy('module');
                    @endphp

                    @if($groupedPermissions->count() > 0)
                        @foreach($groupedPermissions as $module => $permissions)
                            <div class="mb-3">
                                <h6 class="text-primary mb-2">
                                    <i class="ph-shield-check me-1"></i>{{ ucfirst($module) }}
                                </h6>
                                <ul class="list-unstyled ms-3 mb-0">
                                    @foreach($permissions as $permission)
                                        <li class="mb-1">
                                            <i class="ph-check-circle text-success me-1"></i>
                                            <span class="small">{{ $permission->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="ph-shield-slash icon-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No permissions</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
