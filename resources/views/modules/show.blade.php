@extends('layouts.master')

@section('title', 'Module Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Module Details</h4>
            <p class="text-muted mb-0">View module information and permissions</p>
        </div>
        <div>
            <a href="{{ route('modules.edit', $module) }}" class="btn btn-primary me-2">
                <i class="ph ph-pencil me-2"></i>Edit Module
            </a>
            <a href="{{ route('modules.index') }}" class="btn btn-outline-secondary">
                <i class="ph ph-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Module Information -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($module->icon)
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="{{ $module->icon }} fs-1 text-primary"></i>
                            </div>
                        @endif
                        <h5 class="mt-3 mb-1">{{ $module->name }}</h5>
                        <code class="text-muted">{{ $module->code }}</code>
                    </div>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
                            @if($module->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Display Order:</dt>
                        <dd class="col-sm-7">{{ $module->display_order }}</dd>

                        <dt class="col-sm-5">Permissions:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-info">{{ $module->permissions->count() }}</span>
                        </dd>

                        @if($module->description)
                        <dt class="col-sm-12 mt-3">Description:</dt>
                        <dd class="col-sm-12">{{ $module->description }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Audit Information -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Audit Information</h6>
                    <dl class="row mb-0 small">
                        <dt class="col-sm-5">Created By:</dt>
                        <dd class="col-sm-7">{{ $module->creator->name ?? 'System' }}</dd>

                        <dt class="col-sm-5">Created At:</dt>
                        <dd class="col-sm-7">{{ $module->created_at->format('M d, Y H:i') }}</dd>

                        @if($module->updated_at != $module->created_at)
                        <dt class="col-sm-5">Updated By:</dt>
                        <dd class="col-sm-7">{{ $module->updater->name ?? '-' }}</dd>

                        <dt class="col-sm-5">Updated At:</dt>
                        <dd class="col-sm-7">{{ $module->updated_at->format('M d, Y H:i') }}</dd>
                        @endif

                        @if($module->deleted_at)
                        <dt class="col-sm-5">Deleted By:</dt>
                        <dd class="col-sm-7">{{ $module->deleter->name ?? '-' }}</dd>

                        <dt class="col-sm-5">Deleted At:</dt>
                        <dd class="col-sm-7">{{ $module->deleted_at->format('M d, Y H:i') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Permissions ({{ $module->permissions->count() }})</h5>
                    <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary">
                        <i class="ph ph-plus me-1"></i>Add Permission
                    </a>
                </div>
                <div class="card-body">
                    @if($module->permissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($module->permissions as $permission)
                                    <tr>
                                        <td><code>{{ $permission->code }}</code></td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ Str::limit($permission->description, 50) }}</td>
                                        <td>
                                            @if($permission->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('permissions.show', $permission) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="ph ph-eye"></i>
                                                </a>
                                                <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="ph ph-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="ph ph-lock-key fs-1 mb-3 d-block"></i>
                            <p>No permissions assigned to this module yet.</p>
                            <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary">
                                <i class="ph ph-plus me-2"></i>Create First Permission
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
