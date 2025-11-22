@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Import Departments</h4>
            <p class="text-muted mb-0">Upload Excel or CSV file to import multiple departments</p>
        </div>
        <a href="{{ route('departments.index') }}" class="btn btn-light">
            <i class="ph-arrow-left me-2"></i>Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <span class="fw-semibold">Success!</span> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <span class="fw-semibold">Error!</span> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upload File</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('departments.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="file" class="form-label">Select File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                id="file" name="file" accept=".xlsx,.xls,.csv" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Accepted formats: Excel (.xlsx, .xls) or CSV (.csv). Maximum size: 2MB</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('departments.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ph-upload me-2"></i>Import Departments
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Download Template -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Download Template</h5>
                </div>
                <div class="card-body">
                    <p>Download the template file to see the required format for importing departments.</p>
                    <a href="{{ route('departments.template') }}" class="btn btn-success w-100">
                        <i class="ph-download me-2"></i>Download Template
                    </a>
                </div>
            </div>

            <!-- Instructions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Import Instructions</h5>
                </div>
                <div class="card-body">
                    <h6>Required Columns:</h6>
                    <ul class="mb-3">
                        <li><strong>name</strong> - Department name (required)</li>
                    </ul>
                    
                    <h6>Optional Columns:</h6>
                    <ul class="mb-3">
                        <li><strong>code</strong> - Unique department code</li>
                        <li><strong>description</strong> - Department description</li>
                        <li><strong>is_active</strong> - Status (true/false)</li>
                    </ul>

                    <h6>Tips:</h6>
                    <ul class="mb-0">
                        <li>Use the template for correct format</li>
                        <li>Codes must be unique</li>
                        <li>If code is not provided, it will be auto-generated</li>
                        <li>Leave is_active blank or set to 'true' for active departments</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
