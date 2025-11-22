<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">
        @auth
        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img src="{{ auth()->user()->avatar_url }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ auth()->user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-pin font-size-sm"></i> &nbsp;{{ auth()->user()->office_location ?? 'No location' }}
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <a href="{{ route('profile') }}" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->
        @endauth

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <!-- Master Data -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Master Data</div> <i class="icon-menu" title="Master Data"></i></li>
                
                <li class="nav-item">
                    <a href="{{ route('departments.index') }}" class="nav-link {{ request()->is('departments*') ? 'active' : '' }}">
                        <i class="ph-buildings"></i>
                        <span>Departments</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('job-titles.index') }}" class="nav-link {{ request()->is('job-titles*') ? 'active' : '' }}">
                        <i class="ph-briefcase"></i>
                        <span>Job Titles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('office-locations.index') }}" class="nav-link {{ request()->is('office-locations*') ? 'active' : '' }}">
                        <i class="ph-map-pin"></i>
                        <span>Office Locations</span>
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">User Management</div> <i class="icon-menu" title="User Management"></i></li>
                
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="ph-users"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                        <i class="ph-shield-check"></i>
                        <span>Roles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('permissions.index') }}" class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}">
                        <i class="ph-lock-key"></i>
                        <span>Permissions</span>
                    </a>
                </li>
                <!-- /main -->
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
