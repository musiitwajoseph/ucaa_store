@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-0">Create Master Data Category</h1>
        <p class="text-muted">Add a new category for organizing master data</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('master-data-categories.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code') }}" required>
                                <small class="text-muted">Unique identifier (e.g., ASSET_TYPE)</small>
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="icon" class="form-label">Icon Class</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" name="icon" value="{{ old('icon', 'ph ph-folder') }}" 
                                       placeholder="ph ph-folder">
                                <small class="text-muted">Phosphor icon class</small>
                                @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                       id="color" name="color" value="{{ old('color', '#6366f1') }}">
                                @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                       id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                                @error('display_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                           name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('master-data-categories.index') }}" class="btn btn-secondary">
                                <i class="ph ph-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-check me-2"></i>Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Preview</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <i id="iconPreview" class="ph ph-folder fs-1 mb-3"></i>
                        <h5 id="namePreview">Category Name</h5>
                        <span id="colorPreview" class="badge" style="background-color: #6366f1">Badge Preview</span>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Icon Reference</h5>
                </div>
                <div class="card-body">
                    <p class="small">Common icons:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <code>ph ph-folder</code>
                        <code>ph ph-database</code>
                        <code>ph ph-list</code>
                        <code>ph ph-tag</code>
                    </div>
                    <a href="https://phosphoricons.com" target="_blank" class="btn btn-sm btn-link p-0 mt-2">
                        View all icons →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('namePreview').textContent = this.value || 'Category Name';
        document.getElementById('colorPreview').textContent = this.value || 'Badge Preview';
    });

    document.getElementById('icon').addEventListener('input', function() {
        document.getElementById('iconPreview').className = this.value || 'ph ph-folder fs-1 mb-3';
    });

    document.getElementById('color').addEventListener('input', function() {
        document.getElementById('colorPreview').style.backgroundColor = this.value;
    });
</script>
@endpush
@endsection
