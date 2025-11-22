@extends('layouts.master')

@section('content')
<div class="content">
    <!-- Page Header -->
    <div class="page-header page-header-light shadow">
        <div class="page-header-content d-flex align-items-center">
            <div class="page-title">
                <h5 class="mb-0">
                    <i class="ph-chart-line me-2"></i>
                    Audit Trail Statistics
                </h5>
                <p class="text-muted mb-0">Activity insights and analytics</p>
            </div>

            <div class="ms-auto">
                <a href="{{ route('audit-logs.index') }}" class="btn btn-light">
                    <i class="ph-arrow-left me-2"></i>
                    Back to Logs
                </a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <div class="row mt-3">
        <!-- Activity by Event Type -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="ph-tag me-2"></i>
                        Activity by Event Type
                    </h6>
                </div>
                <div class="card-body">
                    @if($eventStats->count() > 0)
                        @foreach($eventStats as $stat)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $stat->event)) }}</span>
                                    <span class="badge bg-primary">{{ number_format($stat->count) }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    @php
                                        $percentage = ($stat->count / $eventStats->sum('count')) * 100;
                                    @endphp
                                    <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-3">No event data available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Active Users -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="ph-users me-2"></i>
                        Top Active Users
                    </h6>
                </div>
                <div class="card-body">
                    @if($userStats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th class="text-end">Activities</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userStats as $stat)
                                        <tr>
                                            <td>
                                                @if($stat->user)
                                                    <span class="fw-semibold">{{ $stat->user->name }}</span>
                                                @else
                                                    <span class="text-muted">Unknown User</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-success">{{ number_format($stat->count) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No user data available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Activity Chart -->
    <div class="card mt-3">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="ph-calendar me-2"></i>
                Daily Activity (Last 30 Days)
            </h6>
        </div>
        <div class="card-body">
            @if($dailyStats->count() > 0)
                <canvas id="dailyActivityChart" height="80"></canvas>
            @else
                <p class="text-muted text-center py-3">No daily activity data available</p>
            @endif
        </div>
    </div>

    <!-- Activity by Model Type -->
    <div class="card mt-3">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="ph-database me-2"></i>
                Activity by Model Type
            </h6>
        </div>
        <div class="card-body">
            @if($modelStats->count() > 0)
                <div class="row">
                    @foreach($modelStats as $stat)
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-primary">{{ number_format($stat->count) }}</h3>
                                    <p class="text-muted mb-0">{{ $stat->model_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center py-3">No model activity data available</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($dailyStats->count() > 0)
    const ctx = document.getElementById('dailyActivityChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dailyStats->pluck('date')->map(fn($d) => date('M d', strtotime($d)))),
                datasets: [{
                    label: 'Activities',
                    data: @json($dailyStats->pluck('count')),
                    borderColor: '#003DA5',
                    backgroundColor: 'rgba(0, 61, 165, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
    @endif
});
</script>
@endpush
@endsection
