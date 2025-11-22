@extends('layouts.master')

@section('title', 'Create Module')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Create Module</h4>
            <p class="text-muted mb-0">Add a new module to the system</p>
        </div>
        <a href="{{ route('modules.index') }}" class="btn btn-light">
            <i class="ph-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('modules.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Module Code</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="Auto-generated from name">
                            <div class="form-text">Leave blank to auto-generate from module name</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Module Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Display name for the module</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            <div class="form-text">Brief description of what this module manages</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Icon</label>
                                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="ph-house">
                                <div class="form-text">Phosphor icon class (e.g., ph-house, ph-users)</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" name="display_order" class="form-control" value="{{ old('display_order') }}" min="0" placeholder="Auto-assigned">
                                <div class="form-text">Order in navigation menu</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <div class="form-text">Inactive modules will not be shown in navigation</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-check me-2"></i>Create Module
                            </button>
                            <a href="{{ route('modules.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Common Phosphor Icons</h6>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-house fs-3"></i>
                            <div class="small text-muted">ph-house</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-users fs-3"></i>
                            <div class="small text-muted">ph-users</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-buildings fs-3"></i>
                            <div class="small text-muted">ph-buildings</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-briefcase fs-3"></i>
                            <div class="small text-muted">ph-briefcase</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-map-pin fs-3"></i>
                            <div class="small text-muted">ph-map-pin</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-shield-check fs-3"></i>
                            <div class="small text-muted">ph-shield-check</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-lock-key fs-3"></i>
                            <div class="small text-muted">ph-lock-key</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-package fs-3"></i>
                            <div class="small text-muted">ph-package</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-chart-bar fs-3"></i>
                            <div class="small text-muted">ph-chart-bar</div>
                        </div>
                        <div class="text-center" style="width: 60px;">
                            <i class="ph ph-gear fs-3"></i>
                            <div class="small text-muted">ph-gear</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
