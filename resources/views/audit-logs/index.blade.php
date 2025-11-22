@extends('layouts.master')

@section('content')
<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Audit Trail</h2>
            <p class="text-muted mb-0">System activity and change logs</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('audit-logs.statistics') }}" class="btn btn-primary">
                <i class="ph-chart-line me-1"></i> Statistics
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <h6 class="mb-0 text-muted">Total Logs</h6>
                            <h2 class="mb-0">{{ number_format($stats['total_logs']) }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="ph-database icon-3x text-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <h6 class="mb-0 text-muted">Today's Activity</h6>
                            <h2 class="mb-0">{{ number_format($stats['today_logs']) }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="ph-calendar icon-3x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <h6 class="mb-0 text-muted">Active Users</h6>
                            <h2 class="mb-0">{{ number_format($stats['unique_users']) }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="ph-users icon-3x text-info opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <h6 class="mb-0 text-muted">Event Types</h6>
                            <h2 class="mb-0">{{ number_format($stats['events_count']) }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="ph-list-checks icon-3x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">User</label>
                        <select name="user_id" class="form-select">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Event Type</label>
                        <select name="event" class="form-select">
                            <option value="">All Events</option>
                            @foreach($events as $event)
                                <option value="{{ $event }}">{{ ucfirst(str_replace('_', ' ', $event)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ph-funnel me-1"></i> Apply
                        </button>
                        <a href="#" class="btn btn-outline-secondary" id="clearFilters">
                            <i class="ph-x me-1"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Audit Logs</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="auditLogsTable" class="table table-hover eagle-table2 mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Event</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#auditLogsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('audit-logs.index') }}",
            data: function(d) {
                d.user_id = $('select[name="user_id"]').val();
                d.event = $('select[name="event"]').val();
                d.date_from = $('input[name="date_from"]').val();
                d.date_to = $('input[name="date_to"]').val();
            }
        },
        columns: [
            { data: 'timestamp', name: 'created_at', orderable: true },
            { data: 'user', name: 'user.name', orderable: true },
            { data: 'event', name: 'event', orderable: true },
            { data: 'description', name: 'description', orderable: false },
            { data: 'ip_address', name: 'ip_address', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"B>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="ph-file-xls me-2"></i>Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="ph-file-pdf me-2"></i>PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                customize: function(doc) {
                    doc.styles.tableHeader.fillColor = '#003DA5';
                }
            },
            {
                extend: 'print',
                text: '<i class="ph-printer me-2"></i>Print',
                className: 'btn btn-info',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            emptyTable: '<div class="text-center py-4"><i class="ph-database icon-3x text-muted mb-3 d-block"></i><p class="text-muted">No audit logs found</p></div>'
        }
    });

    // Filter button click
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });

    // Clear filters
    $('#clearFilters').on('click', function(e) {
        e.preventDefault();
        $('#filterForm')[0].reset();
        table.draw();
    });
});
</script>
@endpush
@endsection
