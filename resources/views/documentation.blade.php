@extends('layouts.master-login')

@section('content')

<!-- Page header -->
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Documentation - <span class="fw-normal">User Guide</span>
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
                <span class="breadcrumb-item active">Documentation</span>
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
            <div class="card" style="background-color: #003DA5;">
                <div class="card-body text-center py-4 text-white">
                    <img src="{{URL::asset('assets/images/ucaa-logo.png')}}" alt="UCAA Logo" style="height: 80px;" class="mb-3">
                    <h3 class="mb-2 fw-bold">UCAA Store System</h3>
                    <h5 class="mb-0 opacity-75">Complete User Documentation</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Start Guide -->
    <div class="row">
        <div class="col-lg-3">
            <!-- Sidebar Navigation -->
            <div class="card sticky-top" style="top: 80px;">
                <div class="card-header" style="background-color: #003DA5; color: white;">
                    <h6 class="mb-0">
                        <i class="ph-list me-2"></i>
                        Table of Contents
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#getting-started" class="list-group-item list-group-item-action">
                        <i class="ph-rocket-launch me-2"></i>Getting Started
                    </a>
                    <a href="#user-management" class="list-group-item list-group-item-action">
                        <i class="ph-users me-2"></i>User Management
                    </a>
                    <a href="#master-data" class="list-group-item list-group-item-action">
                        <i class="ph-database me-2"></i>Master Data
                    </a>
                    <a href="#roles-permissions" class="list-group-item list-group-item-action">
                        <i class="ph-shield-check me-2"></i>Roles & Permissions
                    </a>
                    <a href="#inventory" class="list-group-item list-group-item-action">
                        <i class="ph-package me-2"></i>Inventory Management
                    </a>
                    <a href="#reports" class="list-group-item list-group-item-action">
                        <i class="ph-chart-bar me-2"></i>Reports
                    </a>
                    <a href="#troubleshooting" class="list-group-item list-group-item-action">
                        <i class="ph-wrench me-2"></i>Troubleshooting
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <!-- Getting Started -->
            <div class="card mb-4" id="getting-started">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-rocket-launch me-2"></i>
                        Getting Started
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">System Overview</h6>
                    <p>The UCAA Store System is a comprehensive inventory management solution designed to streamline store operations, track inventory, manage users, and generate detailed reports.</p>
                    
                    <h6 class="fw-bold mt-4">Logging In</h6>
                    <ol>
                        <li>Navigate to the login page</li>
                        <li>Enter your email address</li>
                        <li>Enter your password</li>
                        <li>Click the "Login" button</li>
                    </ol>

                    <div class="alert alert-info">
                        <i class="ph-info me-2"></i>
                        <strong>Note:</strong> If you don't have login credentials, contact the IT support team at support@ucaa.go.ug
                    </div>

                    <h6 class="fw-bold mt-4">Dashboard Overview</h6>
                    <p>After logging in, you'll see the dashboard which displays:</p>
                    <ul>
                        <li>System statistics and key metrics</li>
                        <li>Recent notifications</li>
                        <li>Quick access to frequently used features</li>
                        <li>Navigation menu on the left sidebar</li>
                    </ul>
                </div>
            </div>

            <!-- User Management -->
            <div class="card mb-4" id="user-management">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-users me-2"></i>
                        User Management
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Creating a New User</h6>
                    <ol>
                        <li>Navigate to <strong>User Management → Users</strong></li>
                        <li>Click the "Create User" button</li>
                        <li>Fill in the required information:
                            <ul>
                                <li>First Name and Last Name</li>
                                <li>Email Address</li>
                                <li>Department, Job Title, and Office Location</li>
                                <li>Assign appropriate roles</li>
                            </ul>
                        </li>
                        <li>Set user status (Active/Inactive)</li>
                        <li>Click "Save" to create the user</li>
                    </ol>

                    <h6 class="fw-bold mt-4">Editing User Information</h6>
                    <ol>
                        <li>Go to the Users list</li>
                        <li>Click the edit icon next to the user</li>
                        <li>Update the necessary information</li>
                        <li>Click "Update" to save changes</li>
                    </ol>

                    <h6 class="fw-bold mt-4">Deactivating a User</h6>
                    <p>To temporarily disable a user account without deleting it:</p>
                    <ol>
                        <li>Edit the user profile</li>
                        <li>Uncheck the "Is Active" checkbox</li>
                        <li>Save the changes</li>
                    </ol>
                </div>
            </div>

            <!-- Master Data -->
            <div class="card mb-4" id="master-data">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-database me-2"></i>
                        Master Data Management
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Departments</h6>
                    <p>Manage organizational departments:</p>
                    <ul>
                        <li><strong>Code:</strong> Auto-generated (e.g., DEPT0001)</li>
                        <li><strong>Name:</strong> Department name</li>
                        <li><strong>Description:</strong> Optional department description</li>
                        <li><strong>Status:</strong> Active/Inactive</li>
                    </ul>

                    <h6 class="fw-bold mt-4">Job Titles</h6>
                    <p>Define job positions within the organization:</p>
                    <ul>
                        <li>Navigate to <strong>Master Data → Job Titles</strong></li>
                        <li>Click "Create Job Title"</li>
                        <li>Enter job title name and description</li>
                        <li>System automatically generates a unique code</li>
                    </ul>

                    <h6 class="fw-bold mt-4">Office Locations</h6>
                    <p>Manage physical office locations:</p>
                    <ul>
                        <li>Add location name and address</li>
                        <li>Specify region or area</li>
                        <li>Set location status</li>
                    </ul>

                    <div class="alert alert-warning">
                        <i class="ph-warning me-2"></i>
                        <strong>Important:</strong> Master data is referenced by other modules. Ensure accuracy when creating or editing records.
                    </div>
                </div>
            </div>

            <!-- Roles & Permissions -->
            <div class="card mb-4" id="roles-permissions">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-shield-check me-2"></i>
                        Roles & Permissions
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Understanding Roles</h6>
                    <p>Roles define what users can do in the system. Common roles include:</p>
                    <ul>
                        <li><strong>Administrator:</strong> Full system access</li>
                        <li><strong>Manager:</strong> Department-level access</li>
                        <li><strong>User:</strong> Basic operational access</li>
                    </ul>

                    <h6 class="fw-bold mt-4">Creating a Role</h6>
                    <ol>
                        <li>Go to <strong>User Management → Roles</strong></li>
                        <li>Click "Create Role"</li>
                        <li>Enter role name and description</li>
                        <li>Select permissions for this role</li>
                        <li>Save the role</li>
                    </ol>

                    <h6 class="fw-bold mt-4">Managing Permissions</h6>
                    <p>Permissions are organized by modules:</p>
                    <ul>
                        <li><strong>View:</strong> Read-only access</li>
                        <li><strong>Create:</strong> Add new records</li>
                        <li><strong>Edit:</strong> Modify existing records</li>
                        <li><strong>Delete:</strong> Remove records</li>
                    </ul>

                    <h6 class="fw-bold mt-4">Assigning Roles to Users</h6>
                    <ol>
                        <li>Edit the user profile</li>
                        <li>Select one or more roles from the available list</li>
                        <li>Save changes</li>
                        <li>User will immediately have the new permissions</li>
                    </ol>
                </div>
            </div>

            <!-- Inventory Management -->
            <div class="card mb-4" id="inventory">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-package me-2"></i>
                        Inventory Management
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Coming Soon</h6>
                    <p>The inventory management module is currently under development. It will include:</p>
                    <ul>
                        <li>Item catalog and categorization</li>
                        <li>Stock level tracking</li>
                        <li>Purchase orders and requisitions</li>
                        <li>Stock movement and transfers</li>
                        <li>Supplier management</li>
                        <li>Barcode/QR code scanning</li>
                    </ul>
                </div>
            </div>

            <!-- Reports -->
            <div class="card mb-4" id="reports">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-chart-bar me-2"></i>
                        Reports & Analytics
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Generating Reports</h6>
                    <p>The system provides various reporting capabilities:</p>
                    <ul>
                        <li><strong>User Reports:</strong> Active users, role assignments</li>
                        <li><strong>Inventory Reports:</strong> Stock levels, movements (Coming Soon)</li>
                        <li><strong>Activity Logs:</strong> System usage and audit trails</li>
                    </ul>

                    <h6 class="fw-bold mt-4">Exporting Data</h6>
                    <ol>
                        <li>Navigate to any data table</li>
                        <li>Use the export buttons (Excel, PDF, CSV)</li>
                        <li>Select your preferred format</li>
                        <li>File will be downloaded automatically</li>
                    </ol>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="card mb-4" id="troubleshooting">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ph-wrench me-2"></i>
                        Troubleshooting
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Common Issues</h6>
                    
                    <div class="mb-4">
                        <strong>Cannot Login</strong>
                        <ul>
                            <li>Verify your email address is correct</li>
                            <li>Check if Caps Lock is on</li>
                            <li>Contact IT support to reset your password</li>
                            <li>Ensure your account is active</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <strong>Missing Menu Items</strong>
                        <ul>
                            <li>Check your assigned roles and permissions</li>
                            <li>Contact your administrator to request access</li>
                            <li>Try logging out and back in</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <strong>Data Not Saving</strong>
                        <ul>
                            <li>Ensure all required fields are filled</li>
                            <li>Check for validation error messages</li>
                            <li>Verify you have permission to perform the action</li>
                            <li>Try refreshing the page</li>
                        </ul>
                    </div>

                    <div class="alert alert-success">
                        <i class="ph-question me-2"></i>
                        <strong>Need More Help?</strong> Contact the IT support team at <a href="mailto:support@ucaa.go.ug" class="alert-link">support@ucaa.go.ug</a> or call +256 414 353 000
                    </div>
                </div>
            </div>

            <!-- Download Resources -->
            <div class="card" style="border-left: 4px solid #003DA5;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="ph-download-simple me-2"></i>
                        Download Resources
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="ph-file-pdf me-2"></i>
                                Download PDF Guide
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="ph-video me-2"></i>
                                Video Tutorials
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->

<style>
    .sticky-top {
        position: sticky;
        z-index: 1020;
    }
    
    .list-group-item-action:hover {
        background-color: #f8f9fa;
    }
    
    html {
        scroll-behavior: smooth;
    }
</style>

@endsection
