@extends('layouts.master-login')

@section('content')

<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">

    <!-- Login form -->
    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="card mb-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="{{URL::asset('assets/images/ucaa-logo.png')}}" class="ucaa-logo me-3" alt="Uganda Civil Aviation Authority" onerror="this.src='{{URL::asset('assets/images/logo_icon.svg')}}'" style="height: 80px;">
                    <div class="text-start">
                        <h3 class="mb-0 fw-bold">UCAA</h3>
                        <h6 class="text-muted mb-0">Stores System</h6>
                    </div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show py-2 mb-2" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="mb-2">
                    <label for="email" class="form-label small mb-1">{{ __('Email or Username') }}</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input id="email" type="text" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email or username">
                        <div class="form-control-feedback-icon">
                            <i class="ph-user-circle text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label small mb-1">{{ __('Password') }}</label>
                    <div class="form-control-feedback form-control-feedback-start">
                        <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter password">
                        <div class="form-control-feedback-icon">
                            <i class="ph-lock text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small">
                        {{ __('Forgot Password?') }}
                    </a>
                    @endif
                </div>

                <div>
                    <button type="submit" class="btn btn-primary btn-sm w-100"> 
                        <i class="ph-sign-in me-1"></i>
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
    <!-- /login form -->

</div>
<!-- /content area -->

@endsection
