@extends('layouts.master')
@section('content')

@component('components.breadcrumb')
    @slot('title') Notifications @endslot
    @slot('subtitle') All Notifications @endslot
@endcomponent

<div class="content">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">All Notifications</h5>
            <div class="ms-auto">
                <a href="{{ route('notifications.mark-all-read') }}" class="btn btn-sm btn-primary">
                    <i class="ph-checks me-2"></i>Mark All as Read
                </a>
            </div>
        </div>

        <div class="list-group list-group-flush">
            @forelse($notifications as $notification)
                <a href="{{ route('notifications.mark-read', $notification->id) }}" 
                   class="list-group-item list-group-item-action {{ $notification->read_at ? '' : 'bg-light' }}">
                    <div class="d-flex w-100 justify-content-between">
                        <div>
                            @if(isset($notification->data['urgency']))
                                @if($notification->data['urgency'] == 'critical')
                                    <span class="badge bg-danger me-2">Critical</span>
                                @elseif($notification->data['urgency'] == 'high')
                                    <span class="badge bg-warning me-2">High</span>
                                @else
                                    <span class="badge bg-info me-2">Medium</span>
                                @endif
                            @endif
                            <strong>{{ $notification->data['message'] ?? 'Contract Notification' }}</strong>
                        </div>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    @if(isset($notification->data['staff_name']))
                        <p class="mb-1 mt-2">
                            <i class="ph-user me-1"></i>{{ $notification->data['staff_name'] }}<br>
                            <i class="ph-briefcase me-1"></i>{{ $notification->data['position'] }}<br>
                            <i class="ph-buildings me-1"></i>{{ $notification->data['department'] }}<br>
                            <i class="ph-calendar me-1"></i>Expires: {{ \Carbon\Carbon::parse($notification->data['end_date'])->format('d M Y') }}<br>
                            <i class="ph-clock me-1"></i>Days Remaining: {{ $notification->data['days_remaining'] }}
                        </p>
                    @endif
                </a>
            @empty
                <div class="list-group-item text-center text-muted">
                    No notifications found
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="card-footer">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>

@endsection