@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Office Location</h4>
            <p class="text-muted mb-0">Update office location information</p>
        </div>
        <a href="{{ route('office-locations.index') }}" class="btn btn-light">
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
            <h5 class="mb-0">Office Location Information</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('office-locations.update', $officeLocation) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $officeLocation->code) }}" required>
                        <div class="form-text">Unique identifier</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $officeLocation->name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Building</label>
                        <input type="text" name="building" class="form-control" value="{{ old('building', $officeLocation->building) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Floor</label>
                        <input type="text" name="floor" class="form-control" value="{{ old('floor', $officeLocation->floor) }}" placeholder="e.g., 1st, 2nd">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Room Number</label>
                        <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $officeLocation->room_number) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $officeLocation->address) }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $officeLocation->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('office-locations.index') }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="ph-check me-1"></i> Update Location
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
