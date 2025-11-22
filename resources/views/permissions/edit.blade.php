@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Permission</h4>
            <p class="text-muted mb-0">Update permission information</p>
        </div>
        <a href="{{ route('permissions.index') }}" class="btn btn-light">
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

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Permission Information</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Permission Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $permission->code) }}" required>
                    <div class="form-text">Unique identifier</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
                    <div class="form-text">Display name</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Module <span class="text-danger">*</span></label>
                    <select name="module_id" class="form-select" required>
                        <option value="">Select Module</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id', $permission->module_id) == $module->id ? 'selected' : '' }}>
                                {{ $module->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Select the module this permission belongs to</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $permission->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $permission->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('permissions.index') }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="ph-check me-1"></i> Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
