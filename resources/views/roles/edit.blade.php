@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Role</h4>
            <p class="text-muted mb-0">Update role information</p>
        </div>
        <a href="{{ route('roles.index') }}" class="btn btn-light">
            <i class="ph-arrow-left me-2"></i>Back to List
        </a>
    </div>
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Role Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Role Information</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Role Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $role->code) }}" required>
                    <div class="form-text">Unique identifier for the role</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $role->description) }}</textarea>
                </div>

                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Assign Permissions</h5>
            </div>

            <div class="card-body">
                @if($permissions->count() > 0)
                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" id="checkAll">
                            <i class="ph-check-square me-1"></i>Check All
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="uncheckAll">
                            <i class="ph-square me-1"></i>Uncheck All
                        </button>
                    </div>
                    @foreach($permissions as $module => $modulePermissions)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-primary">{{ ucfirst($module) }} Module</h6>
                                <div>
                                    <button type="button" class="btn btn-xs btn-link check-module" data-module="{{ $module }}">
                                        <i class="ph-check-square me-1"></i>Check All
                                    </button>
                                    <button type="button" class="btn btn-xs btn-link uncheck-module" data-module="{{ $module }}">
                                        <i class="ph-square me-1"></i>Uncheck All
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($modulePermissions->sortBy('code') as $permission)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                   class="form-check-input permission-checkbox" id="permission_{{ $permission->id }}"
                                                   data-module="{{ $module }}"
                                                   {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                                <br><small class="text-muted"><code>{{ $permission->code }}</code></small>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @else
                    <p class="text-muted">No permissions available. Please create permissions first.</p>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('roles.index') }}" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary ms-2">
                <i class="ph-check me-1"></i> Update Role
            </button>
        </div>
    </form>
</div>
<!-- /content area -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check all permissions
        document.getElementById('checkAll').addEventListener('click', function() {
            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
        });

        // Uncheck all permissions
        document.getElementById('uncheckAll').addEventListener('click', function() {
            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        });

        // Check all in module
        document.querySelectorAll('.check-module').forEach(button => {
            button.addEventListener('click', function() {
                const module = this.dataset.module;
                document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).forEach(checkbox => {
                    checkbox.checked = true;
                });
            });
        });

        // Uncheck all in module
        document.querySelectorAll('.uncheck-module').forEach(button => {
            button.addEventListener('click', function() {
                const module = this.dataset.module;
                document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
        });
    });
</script>
@endsection
