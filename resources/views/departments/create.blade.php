@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Create Department</h4>
            <p class="text-muted mb-0">Add a new department</p>
        </div>
        <a href="{{ route('departments.index') }}" class="btn btn-light">
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
            <h5 class="mb-0">Department Information</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Department Code</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="Auto-generated if left blank">
                    <div class="form-text">Leave blank for auto-generation (e.g., DEPT0001)</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Department Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('departments.index') }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="ph-check me-1"></i> Create Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
