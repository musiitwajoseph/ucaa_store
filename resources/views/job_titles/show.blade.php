@extends('layouts.master')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Job Title <span class="fw-normal">Details</span>
            </h4>
        </div>
        <div class="d-flex justify-content-lg-end my-2 my-lg-0 ms-lg-auto">
            <a href="{{ route('job-titles.edit', $jobTitle) }}" class="btn btn-primary me-2">
                <i class="ph-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('job-titles.index') }}" class="btn btn-light">
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
            <!-- Job Title Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Job Title Information</h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="width: 200px;">Code:</td>
                                <td>{{ $jobTitle->code }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Title:</td>
                                <td>{{ $jobTitle->title }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Level:</td>
                                <td>{{ $jobTitle->level ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Description:</td>
                                <td>{{ $jobTitle->description ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Status:</td>
                                <td>
                                    @if($jobTitle->is_active)
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

            <!-- Users with this Job Title -->
            @if($jobTitle->users->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Users ({{ $jobTitle->users->count() }})</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobTitle->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->department->name ?? 'N/A' }}</td>
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
                        <div>{{ $jobTitle->creator->name ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted mb-1">Created At:</div>
                        <div>{{ $jobTitle->created_at->format('M d, Y H:i') }}</div>
                    </div>

                    @if($jobTitle->updated_at != $jobTitle->created_at)
                    <div class="mb-3">
                        <div class="text-muted mb-1">Last Updated By:</div>
                        <div>{{ $jobTitle->updater->name ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <div class="text-muted mb-1">Last Updated At:</div>
                        <div>{{ $jobTitle->updated_at->format('M d, Y H:i') }}</div>
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
                    <a href="{{ route('job-titles.edit', $jobTitle) }}" class="btn btn-primary w-100 mb-2">
                        <i class="ph-pencil me-1"></i> Edit Job Title
                    </a>

                    <form action="{{ route('job-titles.destroy', $jobTitle) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job title?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="ph-trash me-1"></i> Delete Job Title
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
