@extends('layouts.master')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Permission <span class="fw-normal">Details</span>
            </h4>
        </div>
        <div class="d-flex justify-content-lg-end my-2 my-lg-0 ms-lg-auto">
            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary me-2">
                <i class="ph-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('permissions.index') }}" class="btn btn-light">
                <i class="ph-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <div class="row">
        <div class="col-lg-8">
            <!-- Permission Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Permission Information</h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="width: 200px;">Code:</td>
                                <td>{{ $permission->code }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Name:</td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Module:</td>
                                <td>
                                    @if($permission->module)
                                        <span class="badge bg-primary">{{ $permission->module->name }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Description:</td>
                                <td>{{ $permission->description ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Status:</td>
                                <td>
                                    @if($permission->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Roles with this Permission -->
            @if($permission->roles->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Assigned to Roles ({{ $permission->roles->count() }})</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Status</th>
                                    <th>Users</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permission->roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @if($role->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-primary">{{ $role->users->count() }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Users with Direct Permission -->
            @if($permission->users->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Users with Direct Access ({{ $permission->users->count() }})</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permission->users as $user)
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
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistics</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Assigned to Roles:</span>
                            <span class="badge bg-primary">{{ $permission->roles->count() }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Direct User Access:</span>
                            <span class="badge bg-info">{{ $permission->users->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audit Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Audit Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted mb-1">Created By:</div>
                        <div>{{ $permission->creator->name ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted mb-1">Created At:</div>
                        <div>{{ $permission->created_at->format('M d, Y H:i') }}</div>
                    </div>

                    @if($permission->updated_at != $permission->created_at)
                    <div class="mb-3">
                        <div class="text-muted mb-1">Last Updated By:</div>
                        <div>{{ $permission->updater->name ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <div class="text-muted mb-1">Last Updated At:</div>
                        <div>{{ $permission->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>

                <div class="card-body">
                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary w-100 mb-2">
                        <i class="ph-pencil me-1"></i> Edit Permission
                    </a>

                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="ph-trash me-1"></i> Delete Permission
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
