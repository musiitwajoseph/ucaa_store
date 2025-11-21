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
    <!-- Contact Information and Quick Links -->
    <div class="row">
        <!-- Contact Information -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="ph-phone me-2"></i>
                        Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">System Support by Flaxem</h6>
                        <p class="text-muted mb-3">For technical support and system-related queries, please contact our development team.</p>
                        
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-envelope me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Email</div>
                                    <a href="mailto:support@flaxem.com">support@flaxem.com</a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-phone me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Phone</div>
                                    <a href="tel:+256">+256 XXX XXX XXX</a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-globe me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Website</div>
                                    <a href="https://flaxem.com" target="_blank">www.flaxem.com</a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <i class="ph-map-pin me-3 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-semibold">Location</div>
                                    <span>Kampala, Uganda</span>
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
                            <i class="ph-book-open text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="fw-bold">User Manual</h6>
                            <p class="text-muted small">Download comprehensive user documentation</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Download PDF</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="ph-video text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="fw-bold">Video Tutorials</h6>
                            <p class="text-muted small">Watch step-by-step video guides</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">View Tutorials</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="ph-chats-circle text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="fw-bold">Live Chat</h6>
                            <p class="text-muted small">Chat with our support team</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Start Chat</a>
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
                                    Click on "Forgot Password?" on the login page and follow the instructions sent to your registered email address.
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
                                    Contact Flaxem support team at support@flaxem.com to schedule training sessions for your team.
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
                                    Use the support request form above and select "Bug Report" as the category. Provide as much detail as possible including screenshots.
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
                                    The system works on any modern web browser (Chrome, Firefox, Safari, Edge). We recommend using the latest version of your preferred browser for the best experience.
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
