@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-0">Import Master Data Categories</h1>
        <p class="text-muted">Upload a CSV file to import multiple categories at once</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ph ph-upload me-2"></i>Upload CSV File</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('master-data-categories.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="file" class="form-label">Select CSV File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" accept=".csv,.txt" required>
                            <small class="text-muted">Maximum file size: 2MB. Accepted formats: CSV, TXT</small>
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="ph ph-info fs-3 me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">CSV Format Requirements</h6>
                                    <ul class="mb-0">
                                        <li>First row must contain column headers</li>
                                        <li>Required columns: <code>code</code>, <code>name</code></li>
                                        <li>Optional columns: <code>description</code>, <code>icon</code>, <code>color</code>, <code>display_order</code>, <code>is_active</code></li>
                                        <li>Use <code>1</code> for active, <code>0</code> for inactive</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('master-data-categories.index') }}" class="btn btn-secondary">
                                <i class="ph ph-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-upload me-2"></i>Import Categories
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ph ph-download me-2"></i>Download Template</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Download a sample CSV template to get started quickly.</p>
                    <a href="{{ route('master-data-categories.template') }}" class="btn btn-success w-100">
                        <i class="ph ph-file-csv me-2"></i>Download CSV Template
                    </a>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">CSV Example</h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-2 rounded small mb-0"><code>code,name,description,icon,color,display_order,is_active
ASSET_TYPE,Asset Types,Classification of assets,ph ph-package,#6366f1,0,1
STATUS_TYPE,Status Types,Various status options,ph ph-tag,#10b981,1,1</code></pre>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ph ph-lightbulb me-2"></i>Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Ensure all codes are unique</li>
                        <li>Use valid Phosphor icon classes</li>
                        <li>Color should be in hex format (#RRGGBB)</li>
                        <li>Test with a small file first</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
