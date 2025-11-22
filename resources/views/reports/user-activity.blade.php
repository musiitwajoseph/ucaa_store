@extends('layouts.master')

@section('title', 'User Activity Report')

@section('content')
<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">User Activity Report</h2>
            <p class="text-muted mb-0">Audit log and activity tracking</p>
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
            <form method="GET" action="{{ route('reports.user-activity') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">User</label>
                        <select name="user_id" class="form-select">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Event Type</label>
                        <select name="event" class="form-select">
                            <option value="">All Events</option>
                            <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                            <option value="restored" {{ request('event') == 'restored' ? 'selected' : '' }}>Restored</option>
                            <option value="login" {{ request('event') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ request('event') == 'logout' ? 'selected' : '' }}>Logout</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Model Type</label>
                        <select name="auditable_type" class="form-select">
                            <option value="">All Models</option>
                            <option value="App\Models\User" {{ request('auditable_type') == 'App\Models\User' ? 'selected' : '' }}>User</option>
                            <option value="App\Models\Department" {{ request('auditable_type') == 'App\Models\Department' ? 'selected' : '' }}>Department</option>
                            <option value="App\Models\JobTitle" {{ request('auditable_type') == 'App\Models\JobTitle' ? 'selected' : '' }}>Job Title</option>
                            <option value="App\Models\OfficeLocation" {{ request('auditable_type') == 'App\Models\OfficeLocation' ? 'selected' : '' }}>Office Location</option>
                            <option value="App\Models\Role" {{ request('auditable_type') == 'App\Models\Role' ? 'selected' : '' }}>Role</option>
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
                        <a href="{{ route('reports.user-activity') }}" class="btn btn-outline-secondary">
                            <i class="ph-x me-1"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Activity Log</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover eagle-table2 mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Event</th>
                            <th>Model</th>
                            <th>Details</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $activity->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $activity->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    @if($activity->user)
                                        <div class="fw-semibold">{{ $activity->user->name }}</div>
                                        <small class="text-muted">{{ $activity->user->email }}</small>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $eventColors = [
                                            'created' => 'success',
                                            'updated' => 'primary',
                                            'deleted' => 'danger',
                                            'restored' => 'info',
                                            'login' => 'success',
                                            'logout' => 'secondary'
                                        ];
                                        $color = $eventColors[$activity->event] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ ucfirst($activity->event) }}</span>
                                </td>
                                <td>
                                    @php
                                        $modelName = class_basename($activity->auditable_type ?? 'Unknown');
                                    @endphp
                                    <code>{{ $modelName }}</code>
                                </td>
                                <td>
                                    @if($activity->old_values || $activity->new_values)
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#activityModal{{ $activity->id }}">
                                            <i class="ph-eye me-1"></i> View Changes
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="activityModal{{ $activity->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Activity Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if($activity->old_values)
                                                            <h6 class="text-danger">Old Values:</h6>
                                                            <pre class="bg-light p-3 rounded">{{ json_encode($activity->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                        @endif
                                                        @if($activity->new_values)
                                                            <h6 class="text-success">New Values:</h6>
                                                            <pre class="bg-light p-3 rounded">{{ json_encode($activity->new_values, JSON_PRETTY_PRINT) }}</pre>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">No details</span>
                                    @endif
                                </td>
                                <td>
                                    @if($activity->ip_address)
                                        <code>{{ $activity->ip_address }}</code>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No activity logs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($activities->hasPages())
            <div class="card-footer bg-white">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function exportData(format) {
    const form = document.getElementById('filterForm');
    const url = new URL('{{ route("reports.user-activity") }}', window.location.origin);
    const formData = new FormData(form);
    
    // Add export parameter
    formData.append('export', format);
    
    // Build query string
    const params = new URLSearchParams(formData);
    window.location.href = url.pathname + '?' + params.toString();
}
</script>
@endsection
