@extends('layouts.master')

@section('content')
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Public Holiday</h4>
            <p class="text-muted mb-0">Create a new holiday entry</p>
        </div>
        <a href="{{ route('public-holidays.index') }}" class="btn btn-light">
            <i class="ph-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('public-holidays.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Holiday Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                               value="{{ old('date') }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="public" {{ old('type') == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="religious" {{ old('type') == 'religious' ? 'selected' : '' }}>Religious</option>
                            <option value="internal" {{ old('type') == 'internal' ? 'selected' : '' }}>Internal</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Reminder Days Before <span class="text-danger">*</span></label>
                        <input type="number" name="reminder_days" class="form-control @error('reminder_days') is-invalid @enderror" 
                               value="{{ old('reminder_days', 1) }}" min="0" max="30" required>
                        <small class="form-text text-muted">Days before to send notification</small>
                        @error('reminder_days')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="2">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Display Message</label>
                    <textarea name="display_message" class="form-control @error('display_message') is-invalid @enderror" 
                              rows="2" placeholder="Custom message to display in notifications and dashboard (leave empty for auto-generated message)">{{ old('display_message') }}</textarea>
                    <small class="form-text text-muted">If provided, this message will be used instead of the auto-generated one</small>
                    @error('display_message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Notification Start Date</label>
                        <input type="date" name="notification_start_date" class="form-control @error('notification_start_date') is-invalid @enderror" 
                               value="{{ old('notification_start_date') }}">
                        <small class="form-text text-muted">Start showing notifications from this date</small>
                        @error('notification_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Notification End Date</label>
                        <input type="date" name="notification_end_date" class="form-control @error('notification_end_date') is-invalid @enderror" 
                               value="{{ old('notification_end_date') }}">
                        <small class="form-text text-muted">Stop showing notifications after this date</small>
                        @error('notification_end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_recurring" class="form-check-input" id="is_recurring" 
                                   {{ old('is_recurring', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_recurring">
                                Recurring Holiday
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="show_on_dashboard" class="form-check-input" id="show_on_dashboard" 
                                   {{ old('show_on_dashboard', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_on_dashboard">
                                Show on Dashboard
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('public-holidays.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-floppy-disk me-2"></i>Save Holiday
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
