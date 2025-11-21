@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')

@component('components.breadcrumb')
    @slot('title') Dashboard @endslot
    @slot('subtitle') Home @endslot
    @slot('breadcrumb_items')
        <span class="breadcrumb-item active">Dashboard</span>
    @endslot
@endcomponent
    <!-- Dashboard content -->
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-blue-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">3,450</h3>
                        <span class="text-uppercase font-size-xs">Total Orders</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-bag icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-danger-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">$18,390</h3>
                        <span class="text-uppercase font-size-xs">Total Revenue</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-cash3 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-success-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">652</h3>
                        <span class="text-uppercase font-size-xs">New Customers</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-users4 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-indigo-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">2,378</h3>
                        <span class="text-uppercase font-size-xs">Active Sessions</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-enter6 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Basic Card</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p>Welcome to the Limitless Laravel Template!</p>
                    <p>This is an example dashboard page showing how to use the template components.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Add your custom scripts here
    console.log('Dashboard loaded');
</script>
@endpush
