<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Contract Monitoring System</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('assets/images/uetcl_logo.png')}}">
     <!-- Global stylesheets -->
    <link href="{{URL::asset('assets/css/custom.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/css/login.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/css/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{URL::asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <!-- /core JS files -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="background-image: url('{{URL::asset('assets/images/contracts.png')}}'), url('{{URL::asset('assets/images/contractsmall.png')}}'); background-position: bottom, center; background-repeat: no-repeat, repeat; background-size: contain, auto;">

    <div id="pms-layout"></div>
    <div class="page-container">
        

        <div class="col-lg-5 right-container layout-column layout-align-center-center" id="login-form">
            <div class="content-container form-container new">
                <!-- Login form -->
                <form class="" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-0">
                        <div class="card-body" style="border:2px solid #2F3192; padding:20px;  padding-top:40px;border-radius:20px;background-color:#fff">
                            <div class="text-center mb-2" style="padding-left:50px;">
                                
                            </div>
                            
                            <div style="padding-left:10px;position:relative;">
                                <div class="mb-3 text-center" style="padding-left:50px;">
                                    <h1 style=":blue; line-height:25px;font-size:35px;margin-bottom:10px;color:#2F3192;">UETCL</h1>
                                    <span style="line-height:10px;font-size:20px;">CONTRACT MANAGEMENT SYSTEM</span>
                                </div>
                            @if ($errors->any())
                                <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
                                    <span class="alert-icon bg-danger text-white">
                                        <i class="ph-x-circle"></i>
                                    </span>
                                    <span class="fw-semibold">{{__('Login Failed, Please try again!!')}}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                                <img src="{{URL::asset('assets/images/UETCLSTAFFCONTRACTMONITORING.png')}}" alt="UETCL Logo" style="width:150px; height:150px; position:absolute; top:50%; left:-100px; transform:translateY(-50%);padding:5px;">
                            <div class="mb-3" style="padding-left:50px;">
                                <label for="username" class="col-form-label text-md-right">{{ __('Username') }}</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input id="text" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Enter your Username">
                                    <div class="form-control-feedback-icon">
                                        <i class="ph-user-circle text-muted"></i>
                                    </div>
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3" style="padding-left:50px;>
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input id="password" type="password" value="" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="">
                                    <div class="form-control-feedback-icon">
                                        <i class="ph-lock text-muted"></i>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="p-2 form-control btn btn-primary w-100"> {{ __('Login') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /login form -->
            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const countdownElements = document.querySelectorAll('[id^="countdown-"]');

        countdownElements.forEach(el => {
            const endTime = new Date(el.dataset.end).getTime();

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    el.innerHTML = "Timeline Ended";
                    clearInterval(interval);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                el.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
        });
    });
</script>

</body>
</html>
