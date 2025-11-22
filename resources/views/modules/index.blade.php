@extends('layouts.master')

@section('title', 'Modules')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Modules</h4>
            <p class="text-muted mb-0">Manage system modules</p>
        </div>
        <a href="{{ route('modules.create') }}" class="btn btn-primary">
            <i class="ph ph-plus me-2"></i>Add Module
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Modules Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table eagle-table2 table-hover" id="modules-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Form (hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
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
        $('#modules-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('modules.index') }}',
            columns: [
                { data: 'display_order', name: 'display_order' },
                { data: 'code', name: 'code' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description', orderable: false },
                { data: 'icon_display', name: 'icon', orderable: false, searchable: false },
                { data: 'status', name: 'is_active' },
                { data: 'creator_name', name: 'creator.name', orderable: false },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: '<"datatable-header"<"d-flex align-items-center"<"me-auto"f><"ms-auto ms-3"B>>>t<"datatable-footer"ip>',
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-light',
                    text: '<i class="ph-copy me-2"></i>Copy',
                    exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7] }
                },
                {
                    extend: 'csv',
                    className: 'btn btn-light',
                    text: '<i class="ph-file-csv me-2"></i>CSV',
                    exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7] }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-light',
                    text: '<i class="ph-file-xls me-2"></i>Excel',
                    exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7] }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-light',
                    text: '<i class="ph-file-pdf me-2"></i>PDF',
                    orientation: 'landscape',
                    exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7] }
                },
                {
                    extend: 'print',
                    className: 'btn btn-light',
                    text: '<i class="ph-printer me-2"></i>Print',
                    exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7] }
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

    function deleteModule(id) {
        if (confirm('Are you sure you want to delete this module?')) {
            const form = document.getElementById('delete-form');
            form.action = '{{ url('modules') }}/' + id;
            form.submit();
        }
    }
</script>
@endsection
