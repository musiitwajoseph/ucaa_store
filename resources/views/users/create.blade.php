@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Create User</h4>
            <p class="text-muted mb-0">Add a new user</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-light">
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

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <!-- User Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Information</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">User Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                        <div class="form-text">Optional unique identifier (e.g., USR001)</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                        <div class="form-text">Minimum 8 characters</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Organization Details -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Organization Details</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Job Title</label>
                        <select name="job_title_id" class="form-select">
                            <option value="">Select Job Title</option>
                            @foreach($jobTitles as $jobTitle)
                                <option value="{{ $jobTitle->id }}" {{ old('job_title_id') == $jobTitle->id ? 'selected' : '' }}>
                                    {{ $jobTitle->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Office Location</label>
                        <select name="office_location_id" class="form-select">
                            <option value="">Select Office Location</option>
                            @foreach($officeLocations as $location)
                                <option value="{{ $location->id }}" {{ old('office_location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Assign Roles</h5>
            </div>

            <div class="card-body">
                @if($roles->count() > 0)
                    <div class="row">
                        @foreach($roles as $role)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                           class="form-check-input" id="role_{{ $role->id }}"
                                           {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                        @if($role->description)
                                            <br><small class="text-muted">{{ $role->description }}</small>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No roles available. Create roles first.</p>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary ms-2">
                <i class="ph-check me-1"></i> Create User
            </button>
        </div>
    </form>
</div>
<!-- /content area -->
@endsection
