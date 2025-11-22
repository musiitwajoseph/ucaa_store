<!DOCTYPE html>

<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UCAA Store System - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('assets/images/ucaa-logo.png')}}">

    @include('layouts.head-css')

</head>

<body>

    <!-- Page content -->
    <div class="page-content">

        <!-- sidebar -->
        @include('layouts.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- navbar -->
            @include('layouts.navbar')

            <!-- Inner content -->
            <div class="content-inner" style="min-height: calc(100vh - 120px); display: flex; flex-direction: column;">
                
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-warning alert-icon-start alert-dismissible fade show mt-2 ml-2">
                            <span class="alert-icon bg-warning text-white">
                                <i class="ph-warning-circle"></i>
                            </span>
                            <span class="fw-semibold">{{ $error }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endforeach  
                @endif
                
                <div style="flex: 1;">
                    @yield('content')
                </div>

                @include('layouts.footer')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- notification -->
    @include('layouts.notification')

    <!-- right-sidebar content -->
    @include('layouts.right-sidebar')

    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 61, 165, 0.3); z-index: 99999; justify-content: center; align-items: center; flex-direction: column;">
        <div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem; border-width: 0.5rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="text-white mt-3 fw-bold" style="font-size: 1.2rem;">Please wait...</div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                showLoader();
                document.getElementById('logout-form').submit();
            }
        }

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
            console.log('Loader initialized');
            
            // Handle all links
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.href) {
                    // Skip if it's an anchor, toggle, external link, or download link
                    if (link.href.includes('#') || 
                        link.hasAttribute('data-bs-toggle') || 
                        link.target === '_blank' ||
                        link.hasAttribute('download') ||
                        link.href.includes('/download') ||
                        link.href.includes('download=') ||
                        link.href.includes('-template') ||
                        link.href.includes('export=')) {
                        return;
                    }
                    console.log('Link clicked, showing loader');
                    showLoader();
                }
            }, true);

            // Handle all form submissions
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form && form.checkValidity()) {
                    console.log('Form submitted, showing loader');
                    showLoader();
                    
                    // Disable submit button
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                    }
                }
            }, true);

            // Hide loader when page loads
            window.addEventListener('load', function() {
                console.log('Page loaded, hiding loader');
                hideLoader();
            });

            // Handle back/forward navigation
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    hideLoader();
                }
            });

            // Safety timeout
            setTimeout(hideLoader, 30000);
        });
    </script>

    @stack('scripts')
</body>
</html>
