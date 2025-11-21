<!-- Main navbar -->
<div class="navbar navbar-dark navbar-static py-2" style="background-color: #003DA5;">
    <div class="container-fluid">
        <div class="navbar-brand">
            <a href="/" class="d-inline-flex align-items-center">
                <img src="{{URL::asset('assets/images/ucaa-logo.png')}}" alt="UCAA" style="height: 40px;" onerror="this.src='{{URL::asset('assets/images/logo_icon.svg')}}'">
                <span class="d-none d-sm-inline-block ms-3 text-white fw-semibold">Uganda Civil Aviation Authority</span>
            </a>
        </div>

        <div class="d-flex justify-content-end align-items-center ms-auto">
            <ul class="navbar-nav flex-row">
                <li class="nav-item">
                    <a href="{{ route('support.public') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
                        <div class="d-flex align-items-center mx-md-1">
                            <i class="ph-lifebuoy"></i>
                            <span class="d-none d-md-inline-block ms-2">Support</span>
                        </div>
                    </a>
                </li>
                @if (Route::has('login'))
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="navbar-nav-link navbar-nav-link-icon rounded ms-1">
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
