<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-expand-lg" style="background-color: #003DA5;">

    <!-- Sidebar header -->
    <div class="sidebar-section border-bottom border-bottom-white border-opacity-10" style="background-color: #002a7a;">
        <div class="sidebar-logo d-flex justify-content-center align-items-center flex-column py-3">
            <span class="text-white fw-bold text-center" style="font-size: 0.8rem;">MENU</span>

            <div class="sidebar-resize-hide ms-auto position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%);">
                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="ph-arrows-left-right"></i>
                </button>

                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                    <i class="ph-x"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- /sidebar header -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" id="navbar-nav" data-nav-type="accordion">
                
                <!-- Main -->
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-75 sidebar-resize-hide text-white">Main</div>
                    <i class="ph-dots-three sidebar-resize-show text-white"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Master Data -->
                @if(auth()->user()->hasPermission('departments-view') || auth()->user()->hasPermission('job-titles-view') || auth()->user()->hasPermission('office-locations-view'))
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-75 sidebar-resize-hide text-white">Master Data</div>
                    <i class="ph-dots-three sidebar-resize-show text-white"></i>
                </li>
                @endif
                
                @can('departments-view')
                <li class="nav-item">
                    <a href="{{ route('departments.index') }}" class="nav-link text-white {{ request()->is('departments*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-buildings"></i>
                        <span>Departments</span>
                    </a>
                </li>
                @endcan
                
                @can('job-titles-view')
                <li class="nav-item">
                    <a href="{{ route('job-titles.index') }}" class="nav-link text-white {{ request()->is('job-titles*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-briefcase"></i>
                        <span>Job Titles</span>
                    </a>
                </li>
                @endcan
                
                @can('office-locations-view')
                <li class="nav-item">
                    <a href="{{ route('office-locations.index') }}" class="nav-link text-white {{ request()->is('office-locations*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-map-pin"></i>
                        <span>Office Locations</span>
                    </a>
                </li>
                @endcan

                <!-- User Management -->
                @if(auth()->user()->hasPermission('users-view') || auth()->user()->hasPermission('roles-view') || auth()->user()->hasPermission('permissions-view') || auth()->user()->hasPermission('modules-view'))
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-75 sidebar-resize-hide text-white">User Management</div>
                    <i class="ph-dots-three sidebar-resize-show text-white"></i>
                </li>
                @endif
                
                @can('users-view')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link text-white {{ request()->is('users*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                @endcan
                
                @can('roles-view')
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link text-white {{ request()->is('roles*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-shield-check"></i>
                        <span>Roles</span>
                    </a>
                </li>
                @endcan
                
                @can('permissions-view')
                <li class="nav-item">
                    <a href="{{ route('permissions.index') }}" class="nav-link text-white {{ request()->is('permissions*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-lock-key"></i>
                        <span>Permissions</span>
                    </a>
                </li>
                @endcan
                
                @can('modules-view')
                <li class="nav-item">
                    <a href="{{ route('modules.index') }}" class="nav-link text-white {{ request()->is('modules*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-package"></i>
                        <span>Modules</span>
                    </a>
                </li>
                @endcan

                <!-- My Account -->
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-75 sidebar-resize-hide text-white">My Account</div>
                    <i class="ph-dots-three sidebar-resize-show text-white"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link text-white {{ request()->is('profile') && !request()->is('profile/*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-user-circle"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.settings') }}" class="nav-link text-white {{ request()->is('profile/settings') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-gear"></i>
                        <span>Account Settings</span>
                    </a>
                </li>

                <!-- Reports -->
                @if(auth()->user()->hasPermission('reports-view') || auth()->user()->hasPermission('audit-logs-view'))
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-75 sidebar-resize-hide text-white">Reports</div>
                    <i class="ph-dots-three sidebar-resize-show text-white"></i>
                </li>
                @endif
                
                @can('reports-view')
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}" class="nav-link text-white {{ request()->is('reports*') && !request()->is('audit-logs*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-chart-line"></i>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
                @endcan
                
                @can('audit-logs-view')
                <li class="nav-item">
                    <a href="{{ route('audit-logs.index') }}" class="nav-link text-white {{ request()->is('audit-logs*') ? 'active' : '' }}" style="--nav-link-hover-bg: rgba(255,255,255,0.1);">
                        <i class="ph-clock-counter-clockwise"></i>
                        <span>Audit Trail</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
