@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Public Holidays</h4>
            <p class="text-muted mb-0">Manage public holidays and system notifications</p>
        </div>
        <div>
            @can('public-holidays-create')
            <a href="{{ route('public-holidays.create') }}" class="btn btn-primary">
                <i class="ph-plus me-2"></i>Add Holiday
            </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <h6 class="mb-0 text-muted">Total Holidays</h6>
                            <h2 class="mb-0">{{ $stats['total'] }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="ph-calendar icon-3x text-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <h6 class="mb-0 text-muted">Upcoming (90 days)</h6>
                            <h2 class="mb-0">{{ $stats['upcoming'] }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="ph-clock icon-3x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <h6 class="mb-0 text-muted">Today</h6>
                            <h2 class="mb-0">{{ $stats['today'] }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="ph-confetti icon-3x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Holidays table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Holidays</h5>
        </div>

        <div class="card-body">
            <table class="table eagle-table2 table-hover" id="holidays-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Days Until</th>
                        <th>Recurring</th>
                        <th>Reminder Days</th>
                        <th>Notification Period</th>
                        <th>Dashboard</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /holidays table -->

    <!-- Delete Form (hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
<!-- /content area -->
@endsection

@section('center-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="{{URL::asset('assets/js/vendor/tables/datatables/extensions/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/tables/datatables/extensions/pdfmake/vfs_fonts.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#holidays-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('public-holidays.index') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'date_formatted', name: 'date' },
                { data: 'type_badge', name: 'type' },
                { data: 'days_until', name: 'days_until', orderable: false, searchable: false },
                { data: 'recurring', name: 'is_recurring', orderable: false },
                { data: 'reminder_days', name: 'reminder_days' },
                { data: 'notification_period', name: 'notification_period', orderable: false, searchable: false },
                { data: 'dashboard', name: 'show_on_dashboard', orderable: false },
                { data: 'status', name: 'is_active' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' }
            ],
            order: [[1, 'asc']],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: '<"datatable-header"<"d-flex align-items-center"<"me-auto"f><"ms-auto ms-3"B>>>t<"datatable-footer"ip>',
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-light',
                    text: '<i class="ph-copy me-2"></i>Copy',
                    exportOptions: { columns: [0, 1, 2, 5, 6, 7, 8] }
                },
                {
                    extend: 'csv',
                    className: 'btn btn-light',
                    text: '<i class="ph-file-csv me-2"></i>CSV',
                    exportOptions: { columns: [0, 1, 2, 5, 6, 7, 8] }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-light',
                    text: '<i class="ph-file-xls me-2"></i>Excel',
                    exportOptions: { columns: [0, 1, 2, 5, 6, 7, 8] }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-light',
                    text: '<i class="ph-file-pdf me-2"></i>PDF',
                    orientation: 'landscape',
                    exportOptions: { columns: [0, 1, 2, 5, 6, 7, 8] }
                },
                {
                    extend: 'print',
                    className: 'btn btn-light',
                    text: '<i class="ph-printer me-2"></i>Print',
                    exportOptions: { columns: [0, 1, 2, 5, 6, 7, 8] }
                }
            ],
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });
    });

    function deleteHoliday(id) {
        if (confirm('Are you sure you want to delete this holiday?')) {
            const form = document.getElementById('delete-form');
            form.action = '{{ url('public-holidays') }}/' + id;
            form.submit();
        }
    }
</script>
@endsection
