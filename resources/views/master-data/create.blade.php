@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-0">Create Master Data</h1>
        <p class="text-muted">Add a new master data item</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('master-data.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code') }}" required>
                                <small class="text-muted">Unique identifier</small>
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
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror" 
                                       id="type" name="type" value="{{ old('type') }}" 
                                       placeholder="e.g., dropdown, reference">
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" 
                                       id="unit" name="unit" value="{{ old('unit') }}" 
                                       placeholder="e.g., pcs, kg, m">
                                @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="value" class="form-label">Value</label>
                                <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror" 
                                       id="value" name="value" value="{{ old('value') }}">
                                @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="metadata" class="form-label">Metadata (JSON)</label>
                            <textarea class="form-control @error('metadata') is-invalid @enderror" 
                                      id="metadata" name="metadata" rows="4" 
                                      placeholder='{"key": "value"}'>{{ old('metadata') }}</textarea>
                            <small class="text-muted">Optional JSON data for flexible attributes</small>
                            @error('metadata')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <a href="{{ route('master-data.index') }}" class="btn btn-secondary">
                                <i class="ph ph-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-check me-2"></i>Create Master Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ph ph-info me-2"></i>Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Use clear, descriptive codes (e.g., LAPTOP_HP_15)</li>
                        <li>Assign categories to group related items</li>
                        <li>Use types for filtering (e.g., asset, status)</li>
                        <li>Metadata allows flexible custom fields</li>
                        <li>Display order controls sorting in dropdowns</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Metadata Example</h5>
                </div>
                <div class="card-body">
                    <pre class="small mb-0"><code>{
  "brand": "HP",
  "model": "EliteBook 840",
  "warranty": "3 years",
  "specs": {
    "ram": "16GB",
    "storage": "512GB SSD"
  }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('metadata').addEventListener('blur', function() {
        try {
            if (this.value.trim()) {
                const parsed = JSON.parse(this.value);
                this.value = JSON.stringify(parsed, null, 2);
                this.classList.remove('is-invalid');
            }
        } catch (e) {
            this.classList.add('is-invalid');
        }
    });
</script>
@endpush
@endsection
