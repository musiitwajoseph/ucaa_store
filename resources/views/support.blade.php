@extends('layouts.master-login')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Support - <span class="fw-normal">Get Help</span>
            </h4>
        </div>
    </div>

    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                @else
                    <a href="{{ route('login') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                @endauth
                <span class="breadcrumb-item active">Support</span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- UCAA Branding Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-4">
                    <img src="{{URL::asset('assets/images/ucaa-logo.png')}}" alt="UCAA Logo" style="height: 80px;" class="mb-3">
                    <h3 class="mb-2 fw-bold">Uganda Civil Aviation Authority</h3>
                    <h5 class="mb-0 opacity-75">Store System Support</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information and Quick Links -->
    <div class="row">
        <!-- Contact Information -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: #003DA5; color: white;">
                    <h5 class="mb-0">
                        <i class="ph-phone me-2"></i>
                        Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">IT Support Department</h6>
                        <p class="text-muted mb-3">For technical support and system-related queries, please contact our IT support team.</p>
                        
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-envelope me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Email</div>
                                    <a href="mailto:support@ucaa.go.ug">support@ucaa.go.ug</a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-phone me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Phone</div>
                                    <a href="tel:+256414353000">+256 414 353 000</a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-globe me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Website</div>
                                    <a href="https://www.caa.go.ug" target="_blank">www.caa.go.ug</a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-map-pin me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Location</div>
                                    <span>Plot 24, Nakasero Road, Kampala, Uganda</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <div class="d-flex align-items-center">
                            <i class="ph-info me-2"></i>
                            <div>
                                <strong>Business Hours:</strong> Monday - Friday, 8:00 AM - 5:00 PM (EAT)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="ph-book-open mb-3" style="font-size: 3rem; color: #003DA5;"></i>
                            <h6 class="fw-bold">User Manual</h6>
                            <p class="text-muted small">Download comprehensive user documentation</p>
                            <a href="{{ route('documentation.public') }}" class="btn btn-sm" style="background-color: #003DA5; color: white; border-color: #003DA5;">View Documentation</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="ph-video mb-3" style="font-size: 3rem; color: #003DA5;"></i>
                            <h6 class="fw-bold">Video Tutorials</h6>
                            <p class="text-muted small">Watch step-by-step video guides</p>
                            <a href="#" class="btn btn-sm" style="background-color: #003DA5; color: white; border-color: #003DA5;">View Tutorials</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="ph-headset me-2"></i>
                                IT Support Department
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Our IT support team is available to assist you with:</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="ph-check-circle text-success me-2"></i> System access and login issues</li>
                                <li class="mb-2"><i class="ph-check-circle text-success me-2"></i> Password resets and account management</li>
                                <li class="mb-2"><i class="ph-check-circle text-success me-2"></i> Technical troubleshooting</li>
                                <li class="mb-2"><i class="ph-check-circle text-success me-2"></i> Feature requests and system improvements</li>
                                <li class="mb-2"><i class="ph-check-circle text-success me-2"></i> Training and onboarding</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-question me-2"></i>
                        Frequently Asked Questions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How do I reset my password?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Contact the IT support team at support@ucaa.go.ug or call +256 414 353 000 to request a password reset. You will need to verify your identity for security purposes.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Who do I contact for system training?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Contact the IT support department to schedule training sessions. Training can be arranged for individual users or groups depending on your needs.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    How do I report a bug or issue?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Send an email to support@ucaa.go.ug with a detailed description of the issue. Include screenshots if possible, and describe the steps that led to the problem.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    What are the system requirements?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    The UCAA Store System works on any modern web browser (Chrome, Firefox, Safari, Edge). We recommend using the latest version of your preferred browser for the best experience. A stable internet connection is required.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    How do I request new features?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Feature requests can be submitted to the IT department via email. Describe the feature you need and explain how it would benefit your workflow. All requests are reviewed and prioritized based on organizational needs.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    What should I do if I can't login?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    First, verify you are using the correct email and password. If you've forgotten your password, contact IT support for a reset. If the issue persists, there may be a problem with your account permissions - contact support immediately.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->

@endsection
