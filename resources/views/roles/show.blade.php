@extends('layouts.master')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Role Details
                <span>{{ $role->name }}</span>
            </h4>
        </div>
        <div class="d-flex justify-content-lg-end my-2 my-lg-0 ms-lg-auto">
            <a href="{{ route('roles.index') }}" class="btn btn-light btn-sm me-2">
                <i class="ph-list me-1"></i>Back to List
            </a>
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm me-2">
                <i class="ph-pencil me-1"></i>Edit
            </a>
            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="ph-trash me-1"></i>Delete
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
            <!-- Role Information -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Role Information</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Code</label>
                            <div class="fw-semibold">{{ $role->code }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small mb-1">Status</label>
                            <div>
                                @if($role->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small mb-1">Name</label>
                            <div class="fw-semibold">{{ $role->name }}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small mb-1">Description</label>
                            <div class="fw-semibold">{{ $role->description ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            @if($role->permissions->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Permissions ({{ $role->permissions->count() }})</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        @foreach($role->permissions->groupBy('module.name') as $moduleName => $permissions)
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-semibold text-primary">
                                <i class="ph-shield-check me-1"></i>{{ $moduleName }}
                            </h6>
                            <ul class="list-unstyled ms-3">
                                @foreach($permissions->sortBy('code') as $permission)
                                <li class="mb-2">
                                    <i class="ph-check-circle text-success me-1"></i>
                                    <span>{{ $permission->name }}</span>
                                    <br>
                                    <small class="text-muted ms-3"><code>{{ $permission->code }}</code></small>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="card mt-3">
                <div class="card-body text-center py-4">
                    <i class="ph-shield-slash icon-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No permissions assigned</p>
                </div>
            </div>
            @endif

            <!-- Users with this Role -->
            @if($role->users->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Users with this Role ({{ $role->users->count() }})</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover eagle-table2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->department->name ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="card mt-3">
                <div class="card-body text-center py-4">
                    <i class="ph-users-three icon-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No users assigned to this role</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Statistics</h6>
                </div>

                <div class="card-body">
                    <div class="mb-3 p-3 bg-light rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="ph-users-three text-primary me-2"></i>
                                <span class="text-muted">Total Users</span>
                            </div>
                            <span class="badge bg-primary fs-6">{{ $role->users->count() }}</span>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="ph-shield-check text-info me-2"></i>
                                <span class="text-muted">Total Permissions</span>
                            </div>
                            <span class="badge bg-info fs-6">{{ $role->permissions->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audit Information -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">Audit Information</h6>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Created By</label>
                        <div class="fw-semibold">{{ $role->creator->name ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small mb-1">Created At</label>
                        <div class="fw-semibold">{{ $role->created_at->format('M d, Y H:i') }}</div>
                    </div>

                    @if($role->updated_at != $role->created_at)
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Last Updated By</label>
                        <div class="fw-semibold">{{ $role->updater->name ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <label class="text-muted small mb-1">Last Updated At</label>
                        <div class="fw-semibold">{{ $role->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
