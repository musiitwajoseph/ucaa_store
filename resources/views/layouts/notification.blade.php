<!-- Notifications -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
		<div class="offcanvas-header py-0">
			<h5 class="offcanvas-title py-3">Notifications</h5>
			<button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill" data-bs-dismiss="offcanvas">
				<i class="ph-x"></i>
			</button>
		</div>

		<div class="offcanvas-body p-0">
			<div class="bg-light fw-medium py-2 px-3">New notifications</div>
			<div class="p-3">
				@auth
					@forelse (Auth::user()->unreadNotifications as $notification)
						<div class="d-flex align-items-start mb-3">
							<a href="{{$notification->data['url'] ?? '#'}}" class="status-indicator-container me-3">
								<img src="{{URL::asset('assets/images/demo/users/face1.jpg')}}" class="w-40px h-40px rounded-pill" alt="">
								<span class="status-indicator bg-success"></span>
							</a>
							<div class="flex-fill">
								<a href="#" class="fw-semibold">{{ $notification->data['subject'] ?? '' }}</a> - {{ $notification->data['message'] ?? '' }}

								<div class="fs-sm text-muted mt-1">{{ $notification->created_at->diffForHumans() ?? '' }}</div>
							</div>
						</div>
					@empty
						<div class="text-center text-muted py-3">
							No new notifications
						</div>
					@endforelse
				@else
					<div class="text-center text-muted py-3">
						Please login to view notifications
					</div>
				@endauth
			</div>
		</div>
	</div>
	<!-- /notifications -->