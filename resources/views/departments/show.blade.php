@extends('layouts.master')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Department <span class="fw-normal">Details</span>
            </h4>
        </div>
        <div class="d-flex justify-content-lg-end my-2 my-lg-0 ms-lg-auto">
            <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary me-2">
                <i class="ph-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('departments.index') }}" class="btn btn-light">
                <i class="ph-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <div class="row">
        <div class="col-lg-8">
            <!-- Department Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Department Information</h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="width: 200px;">Code:</td>
                                <td>{{ $department->code }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Name:</td>
                                <td>{{ $department->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Description:</td>
                                <td>{{ $department->description ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Status:</td>
                                <td>
                                    @if($department->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Users in Department -->
            @if($department->users->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Users ({{ $department->users->count() }})</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Job Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($department->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->jobTitle->title ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Audit Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Audit Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted mb-1">Created By:</div>
                        <div>{{ $department->creator->name ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted mb-1">Created At:</div>
                        <div>{{ $department->created_at->format('M d, Y H:i') }}</div>
                    </div>

                    @if($department->updated_at != $department->created_at)
                    <div class="mb-3">
                        <div class="text-muted mb-1">Last Updated By:</div>
                        <div>{{ $department->updater->name ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted mb-1">Last Updated At:</div>
                        <div>{{ $department->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                    @endif

                    @if($department->deleted_at)
                    <div class="mb-3">
                        <div class="text-muted mb-1">Deleted By:</div>
                        <div>{{ $department->deleter->name ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted mb-1">Deleted At:</div>
                        <div>{{ $department->deleted_at->format('M d, Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>

                <div class="card-body">
                    <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary w-100 mb-2">
                        <i class="ph-pencil me-1"></i> Edit Department
                    </a>

                    <form action="{{ route('departments.destroy', $department) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="ph-trash me-1"></i> Delete Department
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
