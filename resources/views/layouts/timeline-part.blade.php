@php
    use Carbon\Carbon;

    $now = Carbon::now();
    $currentPeriod = null;
    $timeline = null;
@endphp


@if ($timeline)
    @php $countdownEnd = $timeline->end_date->copy()->endOfDay(); @endphp

    <div class="timeline-card mb-3">
        <div class="timeline-phase">
            <i class="ph ph-flag" style="color:#007bff;"></i>
            {{ ucwords($timeline->phase) }} Timeline
            <span class="info-icon" title="Current phase info">
                <i class="ph ph-info"></i>
            </span>
        </div>

        <div style="margin-bottom:6px;">
            @if ($timeline->is_extension)
                <span class="extended-badge" title="This timeline has been extended">
                    <i class="ph ph-arrow-clockwise"></i> (Extended)
                </span>
            @endif
        </div>

        <div class="timeline-dates small" style="margin-top:4px;">
            <div>
                <i class="ph ph-calendar" style="margin-right:4px;"></i>
                <strong>Start:</strong> {{ $timeline->start_date->format('d M, Y') }}
            </div>
            <div>
                <i class="ph ph-calendar" style="margin-right:4px;"></i>
                <strong>End:</strong> {{ $timeline->end_date->format('d M, Y') }}
            </div>
        </div>

        <div class="timeline-countdown text-danger fw-bold" style="margin-top:8px;">
            <i class="ph ph-clock" style="margin-right:4px;"></i>
            @if(0)
            Proceed
            @elseif ($timeline->end_date->copy()->endOfDay() >= $now)
                Ends in:
                <span id="countdown-{{ $timeline->id }}" data-end="{{ $countdownEnd->format('Y-m-d H:i:s') }}"></span>
            @else
                <span class="text-muted">Expired on {{ $timeline->end_date->format('d M, Y') }}</span>
                <br/><span class="text-danger">Final Submission and Approvals are disabled. Please contact the HR if further action is required.</span>
            @endif
        </div>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const countdownElements = document.querySelectorAll('[id^="countdown-"]');

        countdownElements.forEach(el => {
            const endTime = new Date(el.dataset.end).getTime();

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    el.innerHTML = "Timeline Ended";
                    clearInterval(interval);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                el.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
        });
    });
</script>
