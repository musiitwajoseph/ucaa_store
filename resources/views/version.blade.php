@extends('layouts.master')

@section('title', 'Version Information')

@section('content')

@component('components.breadcrumb')
    @slot('title') Version Information @endslot
    @slot('subtitle') System @endslot
    @slot('breadcrumb_items')
        <span class="breadcrumb-item active">Version Information</span>
    @endslot
@endcomponent

<div class="container-fluid mt-4">
    <!-- Current Version Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="ph-info me-2"></i> Current Version
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                    <i class="ph-package text-primary" style="font-size: 48px;"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1">{{ \App\Helpers\VersionHelper::formatted('detailed') }}</h2>
                                    <p class="text-muted mb-0">Released on {{ \Carbon\Carbon::parse(\App\Helpers\VersionHelper::releaseDate())->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="ph-code text-primary mb-2" style="font-size: 24px;"></i>
                                        <h6 class="mb-0">{{ PHP_VERSION }}</h6>
                                        <small class="text-muted">PHP Version</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="ph-app-window text-success mb-2" style="font-size: 24px;"></i>
                                        <h6 class="mb-0">{{ app()->version() }}</h6>
                                        <small class="text-muted">Laravel</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="ph-gear text-warning mb-2" style="font-size: 24px;"></i>
                                        <h6 class="mb-0">{{ ucfirst(app()->environment()) }}</h6>
                                        <small class="text-muted">Environment</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="ph-clock text-info mb-2" style="font-size: 24px;"></i>
                                        <h6 class="mb-0">{{ config('app.timezone') }}</h6>
                                        <small class="text-muted">Timezone</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Version Changes -->
    @php
        $currentChangelog = \App\Helpers\VersionHelper::changelog();
    @endphp
    @if($currentChangelog)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="ph-list-bullets me-2"></i> What's New in {{ \App\Helpers\VersionHelper::formatted('full') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <i class="ph-info me-2"></i>
                        <strong>{{ ucfirst($currentChangelog['type']) }} Release</strong> - 
                        Released on {{ \Carbon\Carbon::parse($currentChangelog['date'])->format('F j, Y') }}
                    </div>
                    <ul class="list-unstyled mb-0">
                        @foreach($currentChangelog['changes'] as $change)
                        <li class="mb-2">
                            <i class="ph-check-circle text-success me-2"></i>
                            {{ $change }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Version History -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="ph-clock-counter-clockwise me-2"></i> Version History
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $history = \App\Helpers\VersionHelper::history();
                        $sortedHistory = collect($history)->sortByDesc(function ($item, $key) {
                            return $key;
                        });
                    @endphp

                    @forelse($sortedHistory as $version => $details)
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="mb-1">
                                    <span class="badge bg-primary me-2">v{{ $version }}</span>
                                    @if($version === \App\Helpers\VersionHelper::current())
                                        <span class="badge bg-success">Current</span>
                                    @endif
                                </h5>
                                <p class="text-muted mb-0">
                                    <i class="ph-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($details['date'])->format('F j, Y') }}
                                    <span class="badge bg-{{ $details['type'] === 'major' ? 'danger' : ($details['type'] === 'minor' ? 'warning' : 'info') }} ms-2">
                                        {{ ucfirst($details['type']) }} Release
                                    </span>
                                </p>
                            </div>
                        </div>
                        <ul class="mb-0">
                            @foreach($details['changes'] as $change)
                            <li class="mb-1">{{ $change }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="ph-clock-counter-clockwise mb-2" style="font-size: 48px;"></i>
                        <p class="mb-0">No version history available</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Build Information -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="ph-wrench me-2"></i> Build Information
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $buildInfo = \App\Helpers\VersionHelper::buildInfo();
                    @endphp
                    <table class="table table-borderless mb-0">
                        <tbody>
                            @foreach($buildInfo as $key => $value)
                            <tr>
                                <td class="text-muted" style="width: 40%;">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                <td class="fw-semibold">{{ $value }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-muted">Database</td>
                                <td class="fw-semibold">{{ ucfirst(config('database.default')) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Session Driver</td>
                                <td class="fw-semibold">{{ ucfirst(config('session.driver')) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Cache Driver</td>
                                <td class="fw-semibold">{{ ucfirst(config('cache.default')) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="ph-link me-2"></i> Resources
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ asset('CHANGELOG.md') }}" class="list-group-item list-group-item-action border-0" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="ph-file-text text-primary me-3" style="font-size: 24px;"></i>
                                <div>
                                    <h6 class="mb-0">Changelog</h6>
                                    <small class="text-muted">View detailed change history</small>
                                </div>
                            </div>
                        </a>
                        <a href="{{ asset('VERSION.md') }}" class="list-group-item list-group-item-action border-0" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="ph-book-open text-success me-3" style="font-size: 24px;"></i>
                                <div>
                                    <h6 class="mb-0">Version Guide</h6>
                                    <small class="text-muted">How to manage versions</small>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('documentation.public') }}" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex align-items-center">
                                <i class="ph-book text-info me-3" style="font-size: 24px;"></i>
                                <div>
                                    <h6 class="mb-0">Documentation</h6>
                                    <small class="text-muted">System documentation</small>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('support.public') }}" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex align-items-center">
                                <i class="ph-lifebuoy text-warning me-3" style="font-size: 24px;"></i>
                                <div>
                                    <h6 class="mb-0">Support</h6>
                                    <small class="text-muted">Get help and support</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
