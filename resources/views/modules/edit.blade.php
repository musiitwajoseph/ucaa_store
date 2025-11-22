@extends('layouts.master')

@section('title', 'Edit Module')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Module</h4>
            <p class="text-muted mb-0">Update module details</p>
        </div>
        <a href="{{ route('modules.index') }}" class="btn btn-light">
            <i class="ph-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('modules.update', $module) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Module Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $module->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Module Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $module->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $module->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Icon</label>
                                <input type="text" name="icon" class="form-control" value="{{ old('icon', $module->icon) }}" placeholder="ph-house">
                                <div class="form-text">Phosphor icon class</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $module->display_order) }}" min="0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $module->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-check me-2"></i>Update Module
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
                    <h6 class="card-title">Module Information</h6>
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Created By:</dt>
                        <dd class="col-sm-7">{{ $module->creator->name ?? 'System' }}</dd>

                        <dt class="col-sm-5">Created At:</dt>
                        <dd class="col-sm-7">{{ $module->created_at->format('M d, Y H:i') }}</dd>

                        @if($module->updated_at != $module->created_at)
                        <dt class="col-sm-5">Last Updated:</dt>
                        <dd class="col-sm-7">{{ $module->updated_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-5">Updated By:</dt>
                        <dd class="col-sm-7">{{ $module->updater->name ?? '-' }}</dd>
                        @endif

                        <dt class="col-sm-5">Permissions:</dt>
                        <dd class="col-sm-7">{{ $module->permissions->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
