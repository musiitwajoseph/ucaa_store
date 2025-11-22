@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Security Settings</h4>
            <p class="text-muted mb-0">Manage your password and security settings</p>
        </div>
        <a href="{{ route('profile.show') }}" class="btn btn-light">
            <i class="ph-arrow-left me-2"></i>Back to Profile
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <span class="fw-semibold">Success!</span> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <span class="fw-semibold">Error!</span> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            @if($user->isLdapUser())
            <!-- LDAP User Notice -->
            <div class="alert alert-info">
                <div class="d-flex">
                    <i class="ph-info fs-3 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-2">LDAP Account</h5>
                        <p class="mb-0">Your account is managed through LDAP/Active Directory. To change your password, please contact your system administrator or use your organization's password reset portal.</p>
                    </div>
                </div>
            </div>
            @else
            <!-- Change Password Form -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Password must be at least 8 characters long</div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ph-lock-key me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Security Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Security Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 30%;">Last Login</td>
                                <td class="fw-semibold">
                                    {{ $user->last_login_at ? $user->last_login_at->format('F d, Y \a\t h:i A') : 'Never' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Last Login IP</td>
                                <td class="fw-semibold">{{ $user->last_login_ip ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Account Type</td>
                                <td>
                                    <span class="badge {{ $user->is_ldap_user ? 'bg-info' : 'bg-primary' }}">
                                        {{ $user->is_ldap_user ? 'LDAP' : 'Local' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Account Status</td>
                                <td>
                                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            @if($user->email_verified_at)
                            <tr>
                                <td class="text-muted">Email Verified</td>
                                <td class="fw-semibold">
                                    <i class="ph-check-circle text-success me-1"></i>
                                    {{ $user->email_verified_at->format('F d, Y') }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Password Requirements -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Password Requirements</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">At least 8 characters long</li>
                        <li class="mb-2">Mix of uppercase and lowercase letters</li>
                        <li class="mb-2">Include at least one number</li>
                        <li class="mb-2">Include special characters (@, #, $, etc.)</li>
                        <li>Avoid common words and patterns</li>
                    </ul>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Security Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">Never share your password with anyone</li>
                        <li class="mb-2">Use a unique password for this account</li>
                        <li class="mb-2">Change your password regularly</li>
                        <li class="mb-2">Log out when using shared devices</li>
                        <li>Report suspicious activity immediately</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
