<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UCAA Store System - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('assets/images/ucaa-logo.png')}}">

    @include('layouts.head-css')

    <style>
        .content-inner {
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(0, 61, 165, 0.03) 35px, rgba(0, 61, 165, 0.03) 70px),
                repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(0, 61, 165, 0.03) 35px, rgba(0, 61, 165, 0.03) 70px);
            position: relative;
        }
        
        .content-inner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(0, 61, 165, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(0, 61, 165, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(0, 61, 165, 0.03) 0%, transparent 40%);
            pointer-events: none;
        }
        
        .content-inner::after {
            content: '○';
            position: absolute;
            font-size: 100px;
            color: rgba(0, 61, 165, 0.04);
            top: 10%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        
        .login-form {
            position: relative;
            z-index: 1;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }
        
        /* Decorative shapes */
        .content-inner .doodle-circle {
            position: absolute;
            border: 2px solid rgba(0, 61, 165, 0.1);
            border-radius: 50%;
            animation: rotate 20s linear infinite;
        }
        
        .content-inner .doodle-square {
            position: absolute;
            border: 2px solid rgba(0, 61, 165, 0.08);
            animation: pulse 8s ease-in-out infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.1; }
            50% { transform: scale(1.05); opacity: 0.15; }
        }
    </style>

</head>

<body>

    @include('layouts.auth-navbar')

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Decorative doodle elements -->
                <div class="doodle-circle" style="width: 150px; height: 150px; top: 15%; right: 15%;"></div>
                <div class="doodle-circle" style="width: 80px; height: 80px; bottom: 20%; left: 20%;"></div>
                <div class="doodle-square" style="width: 60px; height: 60px; top: 60%; right: 25%;"></div>
                <div class="doodle-square" style="width: 100px; height: 100px; bottom: 15%; right: 15%;"></div>

                @yield('content')

                @include('layouts.footer')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    @include('layouts.right-sidebar')

    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 61, 165, 0.3); z-index: 99999; justify-content: center; align-items: center; flex-direction: column;">
        <div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem; border-width: 0.5rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="text-white mt-3 fw-bold" style="font-size: 1.2rem;">Logging in...</div>
    </div>

    <script>
        function showLoader() {
            const overlay = document.getElementById('loading-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
            }
        }

        function hideLoader() {
            const overlay = document.getElementById('loading-overlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Handle login form submission
            const loginForm = document.querySelector('form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    if (this.checkValidity()) {
                        showLoader();
                        
                        // Disable submit button
                        const submitBtn = this.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Logging in...';
                        }
                    }
                });
            }

            // Hide loader if page loads (in case of validation error)
            window.addEventListener('load', function() {
                hideLoader();
            });

            // Handle back button
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    hideLoader();
                }
            });
        });
    </script>
</body>
</html>
