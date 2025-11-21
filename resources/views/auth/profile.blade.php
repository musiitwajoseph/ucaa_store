@extends('layouts.master')

@section('title', 'My Profile')

@section('content')

@component('components.breadcrumb')
    @slot('title') Profile @endslot
    @slot('subtitle') User Profile @endslot
    @slot('breadcrumb_items')
        <a href="{{ url('/') }}" class="breadcrumb-item">Home</a>
        <span class="breadcrumb-item active">Profile</span>
    @endslot
@endcomponent
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <!-- User card -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img class="img-fluid rounded-circle" src="{{ $user->avatar_url }}" width="170" height="170" alt="{{ $user->name }}">
                    </div>

                    <h6 class="font-weight-semibold mb-0">{{ $user->full_name }}</h6>
                    <span class="d-block text-muted">{{ $user->job_title ?? 'No title' }}</span>

                    <div class="list-icons list-icons-extended mt-3">
                        <a href="#" class="list-icons-item" data-popup="tooltip" title="Google Drive"><i class="icon-google-drive"></i></a>
                        <a href="#" class="list-icons-item" data-popup="tooltip" title="Twitter"><i class="icon-twitter"></i></a>
                        <a href="#" class="list-icons-item" data-popup="tooltip" title="Github"><i class="icon-github"></i></a>
                    </div>
                </div>

                <div class="card-footer bg-transparent text-center">
                    <div class="row">
                        <div class="col">
                            <h6 class="font-weight-semibold mb-0">{{ $user->department ?? 'N/A' }}</h6>
                            <span class="text-muted font-size-sm">Department</span>
                        </div>
                        <div class="col">
                            <h6 class="font-weight-semibold mb-0">{{ $user->office_location ?? 'N/A' }}</h6>
                            <span class="text-muted font-size-sm">Office</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user card -->

            <!-- Account info -->
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Account Information</h6>
                </div>

                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="font-weight-semibold">Email:</span>
                            <div class="text-muted">{{ $user->email }}</div>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-semibold">Username:</span>
                            <div class="text-muted">{{ $user->username ?? 'N/A' }}</div>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-semibold">Employee ID:</span>
                            <div class="text-muted">{{ $user->employee_id ?? 'N/A' }}</div>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-semibold">Authentication:</span>
                            <div>
                                @if($user->is_ldap_user)
                                    <span class="badge badge-primary">LDAP User</span>
                                @else
                                    <span class="badge badge-secondary">Local User</span>
                                @endif
                            </div>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-semibold">Status:</span>
                            <div>
                                @if($user->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </div>
                        </li>
                        @if($user->is_admin)
                        <li class="mb-2">
                            <span class="badge badge-warning">Administrator</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- /account info -->
        </div>

        <div class="col-lg-8">
            <!-- Profile information -->
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Profile Information</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                           value="{{ old('first_name', $user->first_name) }}" 
                                           {{ $user->is_ldap_user ? 'disabled' : '' }}>
                                    @if($user->is_ldap_user)
                                        <small class="form-text text-muted">LDAP field - cannot be modified</small>
                                    @endif
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                                           value="{{ old('last_name', $user->last_name) }}" 
                                           {{ $user->is_ldap_user ? 'disabled' : '' }}>
                                    @if($user->is_ldap_user)
                                        <small class="form-text text-muted">LDAP field - cannot be modified</small>
                                    @endif
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" 
                                           value="{{ old('mobile', $user->mobile) }}">
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" rows="3" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Timezone</label>
                                    <select name="timezone" class="form-control @error('timezone') is-invalid @enderror">
                                        <option value="UTC" {{ $user->timezone == 'UTC' ? 'selected' : '' }}>UTC</option>
                                        <option value="America/New_York" {{ $user->timezone == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                        <option value="America/Chicago" {{ $user->timezone == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                        <option value="America/Denver" {{ $user->timezone == 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                        <option value="America/Los_Angeles" {{ $user->timezone == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                    </select>
                                    @error('timezone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Language</label>
                                    <select name="locale" class="form-control @error('locale') is-invalid @enderror">
                                        <option value="en" {{ $user->locale == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="es" {{ $user->locale == 'es' ? 'selected' : '' }}>Spanish</option>
                                        <option value="fr" {{ $user->locale == 'fr' ? 'selected' : '' }}>French</option>
                                    </select>
                                    @error('locale')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Theme</label>
                                    <select name="theme" class="form-control @error('theme') is-invalid @enderror">
                                        <option value="light" {{ $user->theme == 'light' ? 'selected' : '' }}>Light</option>
                                        <option value="dark" {{ $user->theme == 'dark' ? 'selected' : '' }}>Dark</option>
                                        <option value="auto" {{ $user->theme == 'auto' ? 'selected' : '' }}>Auto</option>
                                    </select>
                                    @error('theme')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Profile <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /profile information -->

            @if(!$user->is_ldap_user)
            <!-- Change password -->
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Change Password</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Change Password <i class="icon-key ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-info">
                <strong>Note:</strong> As an LDAP user, you must change your password through your organization's directory service.
            </div>
            @endif
            <!-- /change password -->
        </div>
    </div>
@endsection
