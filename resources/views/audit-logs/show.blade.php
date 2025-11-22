@extends('layouts.master')

@section('content')
<div class="content">
    <!-- Page Header -->
    <div class="page-header page-header-light shadow">
        <div class="page-header-content d-flex align-items-center">
            <div class="page-title">
                <h5 class="mb-0">
                    <i class="ph-clock-counter-clockwise me-2"></i>
                    Audit Log Details
                </h5>
                <p class="text-muted mb-0">Log ID: #{{ $log->id }}</p>
            </div>

            <div class="ms-auto">
                <a href="{{ route('audit-logs.index') }}" class="btn btn-light">
                    <i class="ph-arrow-left me-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <div class="row mt-3">
        <!-- Log Information -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Log Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Event:</th>
                            <td>
                                @php
                                    $badgeClass = match($log->event) {
                                        'created' => 'bg-success',
                                        'updated' => 'bg-info',
                                        'deleted' => 'bg-danger',
                                        'logged_in' => 'bg-primary',
                                        'logged_out' => 'bg-secondary',
                                        'exported' => 'bg-warning',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $log->event)) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>User:</th>
                            <td>
                                @if($log->user)
                                    <strong>{{ $log->user->name }}</strong>
                                    <br><small class="text-muted">{{ $log->user->email }}</small>
                                @else
                                    <span class="text-muted">System / Unknown</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Timestamp:</th>
                            <td>
                                {{ $log->created_at->format('F d, Y h:i:s A') }}
                                <br><small class="text-muted">({{ $log->created_at->diffForHumans() }})</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $log->description ?? 'N/A' }}</td>
                        </tr>
                        @if($log->auditable_type)
                            <tr>
                                <th>Model Type:</th>
                                <td>{{ class_basename($log->auditable_type) }}</td>
                            </tr>
                            <tr>
                                <th>Model ID:</th>
                                <td>{{ $log->auditable_id }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Request Information -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Request Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">IP Address:</th>
                            <td>{{ $log->ip_address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>User Agent:</th>
                            <td>
                                @if($log->user_agent)
                                    <small class="text-muted">{{ Str::limit($log->user_agent, 100) }}</small>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>URL:</th>
                            <td>
                                @if($log->url)
                                    <a href="{{ $log->url }}" target="_blank" class="text-break small">
                                        {{ Str::limit($log->url, 100) }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Changes (Old vs New Values) -->
    @if($log->old_values || $log->new_values)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Changed Values</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($log->old_values && is_array($log->old_values))
                        <div class="col-md-6">
                            <h6 class="text-muted">Old Values</h6>
                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>
                    @endif

                    @if($log->new_values && is_array($log->new_values))
                        <div class="col-md-6">
                            <h6 class="text-muted">New Values</h6>
                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>
                    @endif
                </div>

                @if($log->event === 'updated' && $log->old_values && $log->new_values)
                    <hr>
                    <h6 class="mt-3 mb-3">Changes Summary</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($log->new_values as $key => $newValue)
                                @php
                                    $oldValue = $log->old_values[$key] ?? null;
                                @endphp
                                @if($oldValue != $newValue)
                                    <tr>
                                        <td><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                                        <td>
                                            <span class="badge bg-danger">
                                                {{ is_array($oldValue) ? json_encode($oldValue) : ($oldValue ?? 'NULL') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ is_array($newValue) ? json_encode($newValue) : ($newValue ?? 'NULL') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endif

    <!-- Related Auditable Model -->
    @if($log->auditable)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Related {{ class_basename($log->auditable_type) }}</h6>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->auditable->toArray(), JSON_PRETTY_PRINT) }}</code></pre>
            </div>
        </div>
    @endif
</div>
@endsection
