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
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <!-- Add your menu items here -->
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-stack"></i> <span>Example Menu</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Example">
                        <li class="nav-item"><a href="#" class="nav-link">Submenu Item 1</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Submenu Item 2</a></li>
                    </ul>
                </li>
                <!-- /main -->
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
