@extends('layouts.master')

@section('title', 'Departments Report')

@section('content')
<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Departments Report</h2>
            <p class="text-muted mb-0">Department statistics and information</p>
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

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-buildings ph-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $departments->count() }}</h3>
                            <p class="text-muted mb-0 small">Total Departments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-users ph-2x text-success"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $departments->sum('users_count') }}</h3>
                            <p class="text-muted mb-0 small">Total Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                            <i class="ph-chart-line ph-2x text-info"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $departments->where('is_active', true)->count() }}</h3>
                            <p class="text-muted mb-0 small">Active Departments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Departments Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Department Details</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover eagle-table2 mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Department Name</th>
                            <th>Code</th>
                            <th>User Count</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $dept)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $dept->name }}</div>
                                    @if($dept->description)
                                        <small class="text-muted">{{ Str::limit($dept->description, 50) }}</small>
                                    @endif
                                </td>
                                <td><code>{{ $dept->code }}</code></td>
                                <td>
                                    @if($dept->users_count > 0)
                                        <span class="badge bg-primary rounded-pill">{{ $dept->users_count }}</span>
                                    @else
                                        <span class="text-muted">0</span>
                                    @endif
                                </td>
                                <td>
                                    @if($dept->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $dept->creator ? $dept->creator->name : '-' }}</td>
                                <td>{{ $dept->created_at->format('M d, Y') }}</td>
                                <td>{{ $dept->updated_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No departments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Distribution Chart -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ph-chart-bar text-primary me-2"></i> Users per Department</h5>
                </div>
                <div class="card-body">
                    @php
                        $sortedDepts = $departments->sortByDesc('users_count')->take(10);
                        $maxCount = $sortedDepts->max('users_count') ?: 1;
                    @endphp
                    @foreach($sortedDepts as $dept)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">{{ $dept->name }}</span>
                                <span class="text-muted">{{ $dept->users_count }} users</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: {{ ($dept->users_count / $maxCount) * 100 }}%"
                                     aria-valuenow="{{ $dept->users_count }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $maxCount }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ph-info text-info me-2"></i> Department Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-4">
                            <h4 class="mb-0 text-primary">{{ number_format($departments->avg('users_count'), 1) }}</h4>
                            <p class="text-muted mb-0">Average Users/Dept</p>
                        </div>
                        <div class="col-6 mb-4">
                            <h4 class="mb-0 text-success">{{ $departments->max('users_count') }}</h4>
                            <p class="text-muted mb-0">Largest Department</p>
                        </div>
                        <div class="col-6 mb-4">
                            <h4 class="mb-0 text-info">{{ $departments->where('users_count', 0)->count() }}</h4>
                            <p class="text-muted mb-0">Empty Departments</p>
                        </div>
                        <div class="col-6 mb-4">
                            <h4 class="mb-0 text-warning">{{ number_format(($departments->where('is_active', true)->count() / max($departments->count(), 1)) * 100, 1) }}%</h4>
                            <p class="text-muted mb-0">Active Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportData(format) {
    const url = '{{ route("reports.departments") }}';
    window.location.href = url + '?export=' + format;
}
</script>
@endsection
