@extends('layouts.master')

@section('title', 'Roles & Permissions Report')

@section('content')
<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Roles & Permissions Report</h2>
            <p class="text-muted mb-0">Access control overview</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" onclick="exportData('excel')">
                <i class="ph-file-xls me-1"></i> Export Excel
            </button>
            <button type="button" class="btn btn-danger" onclick="exportData('pdf')">
                <i class="ph-file-pdf me-1"></i> Export PDF
            </button>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                <i class="ph-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-shield-check ph-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $roles->count() }}</h3>
                            <p class="text-muted mb-0 small">Total Roles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-key ph-2x text-success"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $roles->sum('permissions_count') }}</h3>
                            <p class="text-muted mb-0 small">Total Permissions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-users ph-2x text-info"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $roles->sum('users_count') }}</h3>
                            <p class="text-muted mb-0 small">Total Assignments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles List -->
    @foreach($roles as $role)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">
                        {{ $role->name }}
                        @if($role->is_active)
                            <span class="badge bg-success ms-2">Active</span>
                        @else
                            <span class="badge bg-danger ms-2">Inactive</span>
                        @endif
                    </h5>
                    <p class="text-muted mb-0 small">{{ $role->description }}</p>
                </div>
                <div class="text-end">
                    <div class="mb-1">
                        <span class="badge bg-primary">{{ $role->permissions_count }} Permissions</span>
                        <span class="badge bg-info">{{ $role->users_count }} Users</span>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#role-{{ $role->id }}" aria-expanded="false">
                        <i class="ph-caret-down me-1"></i> View Details
                    </button>
                </div>
            </div>
        </div>
        
        <div class="collapse" id="role-{{ $role->id }}">
            <div class="card-body">
                <div class="row">
                    <!-- Permissions Section -->
                    <div class="col-md-8">
                        <h6 class="mb-3"><i class="ph-key text-primary me-2"></i> Permissions</h6>
                        @php
                            $groupedPermissions = $role->permissions->groupBy(function($permission) {
                                return $permission->module ? $permission->module->name : 'Other';
                            });
                        @endphp
                        
                        @if($groupedPermissions->count() > 0)
                            <div class="row">
                                @foreach($groupedPermissions as $moduleName => $permissions)
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body p-3">
                                                <h6 class="mb-2 text-primary">{{ $moduleName }}</h6>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($permissions as $permission)
                                                        <span class="badge bg-secondary" title="{{ $permission->description }}">
                                                            {{ $permission->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No permissions assigned</p>
                        @endif
                    </div>

                    <!-- Users Section -->
                    <div class="col-md-4">
                        <h6 class="mb-3"><i class="ph-users text-info me-2"></i> Assigned Users ({{ $role->users_count }})</h6>
                        @if($role->users->count() > 0)
                            <div class="list-group">
                                @foreach($role->users->take(10) as $user)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                @if($role->users_count > 10)
                                    <div class="list-group-item text-center text-muted small">
                                        And {{ $role->users_count - 10 }} more users...
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-muted">No users assigned</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
function exportData(format) {
    const url = '{{ route("reports.roles-permissions") }}';
    window.location.href = url + '?export=' + format;
}
</script>
@endsection
