<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-static shadow py-1" style="background-color: #003DA5 !important;">
    <div class="container-fluid py-0">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>
        
        <div class="navbar-brand d-flex align-items-center mb-0 py-1">
            <img src="{{URL::asset('assets/images/ucaa-logo.png')}}" alt="UCAA Logo" style="height: 40px;" class="me-2">
            <div class="text-white">
                <h6 class="mb-0 fw-bold">UCAA STORE SYSTEM</h6>
                <!-- <small class="opacity-75">Uganda Civil Aviation Authority</small> -->
            </div>
        </div>

        <div class="navbar-collapse flex-lg-1 order-2 order-lg-1 collapse">
        </div>

        {{-- <div class="navbar-collapse flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
            <div class="navbar-search flex-fill dropdown mt-2 mt-lg-0">
                <div class="form-control-feedback form-control-feedback-start flex-grow-1">
                    <input type="text" class="form-control" placeholder="Search" data-bs-toggle="dropdown">
                    <div class="form-control-feedback-icon">
                        <i class="ph-magnifying-glass"></i>
                    </div>
                    <div class="dropdown-menu w-100">
                        <button type="button" class="dropdown-item">
                            <div class="text-center w-32px me-3">
                                <i class="ph-magnifying-glass"></i>
                            </div>
                            <span>Search <span class="fw-bold">"in"</span> everywhere</span>
                        </button>

                        <div class="dropdown-divider"></div>

                        <div class="dropdown-menu-scrollable-lg">
                            <div class="dropdown-header">
                                Contacts
                                <a href="#" class="float-end">
                                    See all
                                    <i class="ph-arrow-circle-right ms-1"></i>
                                </a>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{URL::asset('assets/images/demo/users/face3.jpg')}}" class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Christ<mark>in</mark>e Johnson</div>
                                    <span class="fs-sm text-muted">c.johnson@awesomecorp.com</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-user-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{URL::asset('assets/images/demo/users/face24.jpg')}}" class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Cl<mark>in</mark>ton Sparks</div>
                                    <span class="fs-sm text-muted">c.sparks@awesomecorp.com</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-user-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="dropdown-header">
                                Clients
                                <a href="#" class="float-end">
                                    See all
                                    <i class="ph-arrow-circle-right ms-1"></i>
                                </a>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{URL::asset('assets/images/brands/adobe.svg')}}" class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Adobe <mark>In</mark>c.</div>
                                    <span class="fs-sm text-muted">Enterprise license</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-briefcase"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{URL::asset('assets/images/brands/holiday-inn.svg')}}" class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold">Holiday-<mark>In</mark>n</div>
                                    <span class="fs-sm text-muted">On-premise license</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-briefcase"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown-item cursor-pointer">
                                <div class="me-3">
                                    <img src="{{URL::asset('assets/images/brands/ing.svg')}}" class="w-32px h-32px rounded-pill" alt="">
                                </div>

                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="fw-semibold"><mark>IN</mark>G Group</div>
                                    <span class="fs-sm text-muted">Perpetual license</span>
                                </div>

                                <div class="d-inline-flex">
                                    <a href="#" class="text-body ms-2">
                                        <i class="ph-briefcase"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="position-static">
                    <a href="#" class="navbar-nav-link align-items-center justify-content-center w-40px h-32px position-absolute end-0 top-50 translate-middle-y p-0 me-1" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="ph-faders-horizontal"></i>
                    </a>

                    <div class="dropdown-menu w-100 p-3">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">Search options</h6>
                            <a href="#" class="text-body rounded-pill ms-auto">
                                <i class="ph-clock-counter-clockwise"></i>
                            </a>
                        </div>

                        <div class="mb-3">
                            <label class="d-block form-label">Category</label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" checked>
                                <span class="form-check-label">Invoices</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input">
                                <span class="form-check-label">Files</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input">
                                <span class="form-check-label">Users</span>
                            </label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Addition</label>
                            <div class="input-group">
                                <select class="form-select w-auto flex-grow-0">
                                    <option value="1" selected>has</option>
                                    <option value="2">has not</option>
                                </select>
                                <input type="text" class="form-control" placeholder="Enter the word(s)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="input-group">
                                <select class="form-select w-auto flex-grow-0">
                                    <option value="1" selected>is</option>
                                    <option value="2">is not</option>
                                </select>
                                <select class="form-select">
                                    <option value="1" selected>Active</option>
                                    <option value="2">Inactive</option>
                                    <option value="3">New</option>
                                    <option value="4">Expired</option>
                                    <option value="5">Pending</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="button" class="btn btn-light">Reset</button>

                            <div class="ms-auto">
                                <button type="button" class="btn btn-light">Cancel</button>
                                <button type="button" class="btn btn-primary ms-2">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <ul class="nav hstack gap-sm-1 flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item d-lg-none">
                <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="collapse">
                    <i class="ph-magnifying-glass"></i>
                </a>
            </li>

            @auth
                @if(auth()->user()->unreadNotifications->count() > 0)
                <li class="nav-item dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill bg-white" data-bs-toggle="dropdown">
                        <i class="ph-bell"></i>
                        <span class="badge bg-danger badge-pill position-absolute top-0 end-0">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end wmin-300 p-0">
                        <div class="dropdown-header">
                            <span class="fw-bold">Notifications</span>
                            <a href="{{ route('notifications.mark-all-read') }}" class="float-end text-body">
                                <small>Mark all as read</small>
                            </a>
                        </div>

                        <div class="dropdown-content" style="max-height: 400px; overflow-y: auto;">
                            @forelse(auth()->user()->unreadNotifications->take(10) as $notification)
                            <a href="{{ route('notifications.mark-read', $notification->id) }}" class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}">
                                <div class="d-flex align-items-start">
                                    <div class="flex-fill">
                                        @if(isset($notification->data['urgency']))
                                            @if($notification->data['urgency'] == 'critical')
                                                <span class="badge bg-danger mb-1">Critical</span>
                                            @elseif($notification->data['urgency'] == 'high')
                                                <span class="badge bg-warning mb-1">High</span>
                                            @else
                                                <span class="badge bg-info mb-1">Medium</span>
                                            @endif
                                        @endif
                                        <div class="fw-semibold">{{ $notification->data['message'] ?? 'Contract Notification' }}</div>
                                        <div class="text-muted fs-sm">
                                            <i class="ph-clock me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="dropdown-item text-center text-muted">
                                No new notifications
                            </div>
                            @endforelse
                        </div>

                        <div class="dropdown-divider"></div>
                        <a href="{{ route('notifications.index') }}" class="dropdown-item text-center">
                            View all notifications
                        </a>
                    </div>
                </li>
                @endif
            @endauth
            
            <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1 bg-white" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        @auth
                            <img src="{{ Auth::user()->avatar_url }}" class="w-32px h-32px rounded-pill" alt="{{ Auth::user()->full_name }}" style="object-fit: cover;">
                        @else
                            <img src="{{URL::asset('images/avatar.png')}}" class="w-32px h-32px rounded-pill" alt="Guest">
                        @endauth
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ Auth::check() ? Auth::user()->full_name : 'Guest' }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('profile.show') }}" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My Profile
                    </a>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ph-pencil me-2"></i>
                        Edit Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.settings') }}" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        Account Settings
                    </a>
                    <a href="{{ route('profile.security') }}" class="dropdown-item">
                        <i class="ph-lock-key me-2"></i>
                        Security
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); confirmLogout();">
                        <i class="ph-sign-out me-2"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>

            <li class="nav-item ms-lg-2">
                <a href="#" onclick="event.preventDefault(); confirmLogout();" class="btn btn-light btn-sm rounded-pill" title="Logout">
                    <i class="ph-sign-out me-1"></i>
                    <span class="d-none d-lg-inline">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
        
<!-- /main navbar -->
