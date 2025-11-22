@extends('layouts.master')

@section('title', 'Users Report')

@section('content')
<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Users Report</h2>
            <p class="text-muted mb-0">View and filter user data</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" onclick="exportData('excel')">
                <i class="ph-file-xls me-1"></i> Export Excel
            </button>
            <button type="button" class="btn btn-danger" onclick="exportData('pdf')">
                <i class="ph-file-pdf me-1"></i> Export PDF
            </button>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                <i class="ph-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.users') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Job Title</label>
                        <select name="job_title_id" class="form-select">
                            <option value="">All Job Titles</option>
                            @foreach($jobTitles as $job)
                                <option value="{{ $job->id }}" {{ request('job_title_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Office Location</label>
                        <select name="office_location_id" class="form-select">
                            <option value="">All Locations</option>
                            @foreach($officeLocations as $office)
                                <option value="{{ $office->id }}" {{ request('office_location_id') == $office->id ? 'selected' : '' }}>
                                    {{ $office->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="">All Status</option>
                            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">User Type</label>
                        <select name="is_ldap_user" class="form-select">
                            <option value="">All Types</option>
                            <option value="1" {{ request('is_ldap_user') === '1' ? 'selected' : '' }}>LDAP</option>
                            <option value="0" {{ request('is_ldap_user') === '0' ? 'selected' : '' }}>Local</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ph-funnel me-1"></i> Apply Filters
                        </button>
                        <a href="{{ route('reports.users') }}" class="btn btn-outline-secondary">
                            <i class="ph-x me-1"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Results: {{ $users->count() }} users found</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover eagle-table2 mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Job Title</th>
                            <th>Office Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Roles</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->department ? $user->department->name : '-' }}</td>
                                <td>{{ $user->jobTitle ? $user->jobTitle->title : '-' }}</td>
                                <td>{{ $user->officeLocation ? $user->officeLocation->name : '-' }}</td>
                                <td>
                                    @if($user->is_ldap_user)
                                        <span class="badge bg-info">LDAP</span>
                                    @else
                                        <span class="badge bg-secondary">Local</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No users found matching the criteria</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function exportData(format) {
    const form = document.getElementById('filterForm');
    const url = new URL(form.action);
    const formData = new FormData(form);
    
    // Add export parameter
    formData.append('export', format);
    
    // Build query string
    const params = new URLSearchParams(formData);
    window.location.href = url.pathname + '?' + params.toString();
}
</script>
@endsection
