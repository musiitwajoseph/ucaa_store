<!-- Main navbar -->
<div class="navbar navbar-static py-2" style="background-color: #003DA5;">
    <div class="container-fluid">
        <div class="navbar-brand d-flex align-items-center">
            <img src="{{URL::asset('assets/images/ucaa-logo.png')}}" alt="UCAA Logo" style="height: 50px;" class="me-3">
            <div class="text-white">
                <h5 class="mb-0 fw-bold">UCAA STORE SYSTEM</h5>
                <small class="opacity-75">Uganda Civil Aviation Authority</small>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center ms-auto">
            <ul class="navbar-nav flex-row">
                <li class="nav-item">
                    <a href="{{ route('support.public') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1 text-white">
                        <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-lifebuoy"></i>
                            <span class="d-none d-md-inline-block ms-2">Support</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('documentation.public') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1 text-white">
                        <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-book-open"></i>
                            <span class="d-none d-md-inline-block ms-2">Documentation</span>
                        </div>
                    </a>
                </li>
                @if (Route::has('login'))
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1 bg-white" style="color: #003DA5;">
                        <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-user-circle"></i>
                            <span class="d-none d-md-inline-block ms-2">{{ __('Login') }}</span>
                        </div>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->
