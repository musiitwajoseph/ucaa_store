@extends('layouts.master')

@section('content')
<!-- Content area -->
<div class="content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Account Settings</h4>
            <p class="text-muted mb-0">Manage your account preferences</p>
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

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <form action="{{ route('profile.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Appearance Settings -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Appearance</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="theme" class="form-label">Theme</label>
                            <select class="form-select @error('theme') is-invalid @enderror" id="theme" name="theme">
                                <option value="light" {{ old('theme', $user->theme) === 'light' ? 'selected' : '' }}>Light</option>
                                <option value="dark" {{ old('theme', $user->theme) === 'dark' ? 'selected' : '' }}>Dark</option>
                                <option value="auto" {{ old('theme', $user->theme) === 'auto' ? 'selected' : '' }}>Auto (System)</option>
                            </select>
                            @error('theme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Choose your preferred theme for the application</div>
                        </div>
                    </div>
                </div>

                <!-- Regional Settings -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Regional Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="locale" class="form-label">Language</label>
                                <select class="form-select @error('locale') is-invalid @enderror" id="locale" name="locale">
                                    <option value="en" {{ old('locale', $user->locale ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="fr" {{ old('locale', $user->locale) === 'fr' ? 'selected' : '' }}>French</option>
                                    <option value="es" {{ old('locale', $user->locale) === 'es' ? 'selected' : '' }}>Spanish</option>
                                </select>
                                @error('locale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Select your preferred language</div>
                            </div>
                            <div class="col-md-6">
                                <label for="timezone" class="form-label">Timezone</label>
                                <input type="text" class="form-control @error('timezone') is-invalid @enderror" 
                                    id="timezone" name="timezone" value="{{ old('timezone', $user->timezone ?? 'UTC') }}" 
                                    placeholder="e.g., UTC, Africa/Kampala, America/New_York">
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Set your local timezone</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mb-3">
                    <a href="{{ route('profile.show') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-floppy-disk me-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Current Settings Summary -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Current Settings</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted">Theme:</td>
                                <td class="fw-semibold text-end">{{ $user->theme ? ucfirst($user->theme) : 'Light' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Language:</td>
                                <td class="fw-semibold text-end">
                                    @switch($user->locale ?? 'en')
                                        @case('en') English @break
                                        @case('fr') French @break
                                        @case('es') Spanish @break
                                        @default English
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Timezone:</td>
                                <td class="fw-semibold text-end">{{ $user->timezone ?? 'UTC' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Help -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Settings Help</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Theme:</strong> Choose between light, dark, or automatic theme based on your system preferences.</p>
                    <p class="mb-2"><strong>Language:</strong> Select your preferred language for the interface.</p>
                    <p class="mb-0"><strong>Timezone:</strong> Set your local timezone for accurate time displays. Use standard timezone names (e.g., UTC, Africa/Kampala).</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
