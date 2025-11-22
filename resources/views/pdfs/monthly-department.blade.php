
 <style>
    body {
        font-size: 14pt;
    }
    table {
        width: 100%;
        /*table-layout: fixed; /* Ensure proper layout for columns */
        border-collapse: collapse;
        font-family: arial;
        font-size:12px !important;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 1px;
        text-align: left;
        word-wrap: break-word;
        display: table-cell;
        font-size:12px !important;
    }

    th {
        background-color: #f4f4f4;
    }

    .narrow-column {
        width: 20%;
    }

    .medium-column {
        width: 30%;
    }

    .wide-column {
        width: 40%;
    }

</style>
<hr style="opacity:100; background-color: #000;height:4px; margin-top:50px;">
<div style="border:1px solid #000; box-shadow:-5px 5px #000; width: 200px; margin:15px auto; font-size:16px; background-color:#247297; color:#fff;text-align:center; position: relative; top:-30px;font-weight:bold;margin-bottom:-20px; ">Section I: Scorecard</div>

@php
    // Grouping logic
    $objectiveCounts = [];
    $goalCounts = [];

    foreach ($scorecard as $item) {
        $objectiveName = $item->goal->objective->name;
        $goalName = $item->goal->name;

        $objectiveCounts[$objectiveName] = ($objectiveCounts[$objectiveName] ?? 0) + 1;
        $goalCounts[$goalName] = ($goalCounts[$goalName] ?? 0) + 1;
    }

    // Tracking printed objectives/goals
    $printedObjectives = [];
    $printedGoals = [];
@endphp

<table style="border-collapse:collapse;border:none;font-size:12px !important;" width="100%">

    <thead>
        <tr style="text-align: center; font-weight: bold; color:#fff; background-color:#316789;">
            <th>#</th>
            <th>Strategic Objective<br/>(Tier 1 & Tier 2)</th>
            <th>Strategic Goal/ Performance Result</th>
            <th>Key Performance Indicator</th>
            <th>Baseline</th>
            <th>Target</th>
            <th>Department Status {{$months[$active_month]['month_name']}} {{$months[$active_month]['year']}}</th>
            <th>Strategy Management Office Status {{$months[$active_month]['month_name']}} {{$months[$active_month]['year']}}</th>
            @if(@$monthly_appraisal->appraisal_status == 0 || @$monthly_appraisal->appraisal_counter == 2 && 3440 == Auth::user()->id)
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>

    @foreach($scorecard as $key => $item)
            <tr>
                <td>{{ $key + 1 }}.</td>

                {{-- Strategic Objective with rowspan --}}
                @php $objectiveName = $item->goal->objective->name; @endphp
                @if(!in_array($objectiveName, $printedObjectives))
                    <td rowspan="{{ $objectiveCounts[$objectiveName] }}">
                        {{ $objectiveName }}
                    </td>
                    @php $printedObjectives[] = $objectiveName; @endphp
                @endif

                {{-- Strategic Goal with rowspan --}}
                @php $goalName = $item->goal->name; @endphp
                @if(!in_array($goalName, $printedGoals))
                    <td rowspan="{{ $goalCounts[$goalName] }}">
                        {{ $goalName }}
                    </td>
                    @php $printedGoals[] = $goalName; @endphp
                @endif

                <td>{{ $item->name }}</td>
                <td>{{ $item->baseline }}</td>
                <td>{{ $item->target }}</td>
                        <td>{{$item->monthlyStatus($active_month)->remarks ?? '' }}</td>
                        <td>{{$item->monthlyStatus($active_month)->sup_remarks ?? '' }}</td>

                         @if(@$monthly_appraisal->appraisal_status == 0 ||  @$monthly_appraisal->appraisal_counter == 2 && 3440 == Auth::user()->id)
                            <td id="{{ $item->id }}">
                                <button class="scorecard-btn scorecard-select btn btn-success-outline" data-type="copy" data-id="{{ $item->id }}" data-department="{{$department_id}}" data-month="{{$active_month}}"><i class="ph-copy"></i> Select</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
    </tbody>
</table>


<hr style="opacity:100; background-color: #000;height:4px; margin-top:50px;">
<div style="border:1px solid #000; box-shadow:-5px 5px #000; width: 200px; margin:15px auto; font-size:16px; background-color:#247297; color:#fff;text-align:center; position: relative; top:-30px;font-weight:bold;margin-bottom:-20px; ">Section II: Workplan</div>

@if($appraisal)
    @if ($appraisal->keyDeliverables->count() > 0)
        <div class="table-responsive">

            <table style="font-size:16px !important;">
                <thead>
                    <tr>
                        <th>Line</th>
                        <th>#</th>
                        <th>Strategic Objective</th>
                        <th>#</th>
                        <th>Strategic Initiative</th>
                        <th>Key<Br/>Undertaking</th>
                        <th>Key Deliverable/ Output</th>
                        <th>Timelines/ By When</th>
                        {{-- <th>By Who</th> --}}
                        <th>Weight</th>
                        <th>Achievement</th>
                        <th>Evidence</th>
                        <th>Rating</th>
                        <th>Weighted Score</th>
                        <th>Strategy Mgt Office<br/>Comment on Achievement</th>
                        <th>Strategy Mgt Office<br/>Rating</th>
                        <th>Strategy Mgt Office<br/>Weighted Score</th>
                        @if(@$monthly_appraisal->appraisal_status == 0 ||  @$monthly_appraisal->appraisal_counter == 2 && 3440 == Auth::user()->id)
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_weight = $total_emp_midterm = $total_sup_midterm = 0;
                        $counter = 1;
                        $counter2 = 1;
                        $pillars = $appraisal->keyDeliverables->groupBy(fn($deliverable) =>
                            $deliverable->keyUndertaking->strategicInitiative->strategicObjective->StrategicPillar->name ?? ''
                        );
                    @endphp

                    @foreach ($pillars as $pillarName => $deliverablesByPillar)
                        @php
                            $rowspanPillar = $deliverablesByPillar->count();
                            $counter3 = 1;
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: bold; color:#fff; background-color:#316789;">{{ $pillarName }}</td>
                            @for($i=0; $i < 16; $i++)
                            <td></td>
                            @endfor
                        </tr>
                        @foreach ($deliverablesByPillar->groupBy(fn($deliverable) =>
                            $deliverable->keyUndertaking->strategicInitiative->strategicObjective->name ?? ''
                        ) as $objectiveName => $deliverablesByObjective)
                            @php
                                $rowspanObjective = $deliverablesByObjective->count();
                                $counter4 = 1;
                            @endphp
                            @foreach ($deliverablesByObjective->groupBy(fn($deliverable) =>
                                $deliverable->keyUndertaking->strategicInitiative->name ?? ''
                            ) as $initiativeName => $deliverablesByInitiative)
                                @php
                                    $rowspanInitiative = $deliverablesByInitiative->count();
                                @endphp
                                @foreach ($deliverablesByInitiative->groupBy(fn($deliverable) =>
                                    $deliverable->keyUndertaking->name ?? ''
                                ) as $undertakingName => $deliverablesByUndertaking)
                                    @php
                                        $rowspanUndertaking = $deliverablesByUndertaking->count();
                                    @endphp
                                    @foreach ($deliverablesByUndertaking as $key => $deliverable)
                                        <tr id="deliverable-{{$deliverable->id}}" class="{{ ($appraisal->active_line == $deliverable->id) ? 'active-line' : '' }} {{ ($deliverable->weight == 0) ? 'weaved-line' : '' }}">
                                            <td>{{ $counter++ }}.</td>

                                            {{-- Strategic Objective --}}
                                            @if ($key === 0 && $loop->parent->parent->first && $loop->parent->first)
                                                <td rowspan="{{ $rowspanObjective }}">{{ $counter2++ }}.</td>
                                                <td rowspan="{{ $rowspanObjective }}">{{ $objectiveName }}</td>
                                            @endif

                                            {{-- Strategic Initiative --}}
                                            @if ($key === 0 && $loop->parent->first)
                                                <td rowspan="{{ $rowspanInitiative }}">{{ ($counter2 - 1) ?? 1 }}.{{ $counter3++ }}.</td>
                                                <td rowspan="{{ $rowspanInitiative }}">{{ $initiativeName }}</td>
                                            @endif

                                            {{-- Key Undertaking --}}
                                            @if ($key === 0)
                                                <td rowspan="{{ $rowspanUndertaking }}" style="font-size:14px !important;">{!! nl2br($undertakingName) ?? '' !!}</td>
                                            @endif

                                            {{-- Key Deliverable/ Output --}}
                                            <td class="workplan-deliverable-{{ $deliverable->id }}">{{ $deliverable->name ?? '' }}</td>

                                            {{-- Timelines --}}
                                            <td>
                                                <p>{{ ($deliverable->timeline && $deliverable->review_type_id == 6) ? date('Y-m-d',strtotime($deliverable->timeline)) :  '' }}</p>
                                                @if ($deliverable->review_type_id && $deliverable->review_type_id != 6)
                                                    <p>{{ $deliverable->reviewType->review_name ?? '' }}</p>
<p>{{ $deliverable->timeline_comment ?? ''}}</p>
                                                @endif
                                            </td>

                                            {{-- By Who --}}
                                            {{-- <td>
                                                @php $weight = 0; @endphp
                                                @foreach ($deliverable->byWhos as $key => $byWho)
                                                    <p>
                                                        @if($appraisal->user->headOfDepartment->count())
                                                            {{ $byWho->section->name ?? '' }}
                                                        @elseif($appraisal->user->headOfSection->count())
                                                            {{ $byWho->unit->name ?? '' }}
                                                        @elseif($appraisal->user->headOfUnit->count())
                                                            N/A
                                                        @endif

                                                        @if ($key + 1 != $deliverable->byWhos->count())
                                                        ,
                                                        @endif
                                                    </p>
                                                @endforeach

                                                @if((float)$deliverable->weight > 0)
                                                    @php
                                                    $weight = $deliverable->weight;
                                                    $total_weight += $deliverable->weight;
                                                    @endphp
                                                @else
                                                    @foreach ($deliverable->byWhos as $key => $byWho)
                                                        @php
                                                            $weight += $byWho->weight;
                                                            $total_weight += $byWho->weight;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </td>
            --}}
                                            {{-- Weight --}}
                                            <td style="text-align:center;">{{ number_format($deliverable->weight,2) ?? "" }}</td>

                                            <td style="">{{$deliverable->monthlyDeliverable($active_month)->emp_achievement ?? ""}}</td>
                                            <td style="">
                                                @if($deliverable->attachments()->count()
 + $deliverable->links->count() > 1)
                                                <span class="text-primary performance-btn evidence-list btn btn-success-outline" data-type="copy" data-id="{{$deliverable->id}}" title="Click to View Evidence">Yes ({{ $deliverable->attachments()->count() + ($deliverable->links ? $deliverable->links->count() : 0) }})</span>
                                                @elseif($deliverable->attachments()->count() || $deliverable->links->count())
                                                <span class="text-primary performance-btn evidence-list btn btn-success-outline" data-type="copy" data-id="{{$deliverable->id}}" title="Click to View Evidence">Yes</span>
                                                @else
                                                No
                                                @endif
                                            </td>

                                            <td style="">
                                                @if(@$deliverable->monthlyDeliverable($active_month)->emp_rating)
                                                {{ number_format($deliverable->monthlyDeliverable($active_month)->emp_rating,1)}}%
                                                @endif
                                            </td>
                                            <td style="">{{(@$deliverable->monthlyDeliverable($active_month)->emp_score) ? number_format(@$deliverable->monthlyDeliverable($active_month)->emp_score ?? 0,2) : ""}}</td>

                                            @php
                                            $total_weight += $deliverable->weight;
                                            $total_emp_midterm += $deliverable->monthlyDeliverable($active_month)->emp_score ?? 0;
                                            $total_sup_midterm += $deliverable->monthlyDeliverable($active_month)->sup_score ?? 0;
                                            @endphp

                                            <td style="">{{$deliverable->monthlyDeliverable($active_month)->sup_achievement ?? ""}}</td>
                                            <td style="">{{$deliverable->monthlyDeliverable($active_month)->sup_rating ?? ""}}</td>
                                            <td style="">{{(@$deliverable->monthlyDeliverable($active_month)->sup_score) ? number_format(@$deliverable->monthlyDeliverable($active_month)->sup_score ?? 0,1) : ""}}</td>


                                            @if(@$monthly_appraisal->appraisal_status == 0 ||  @$monthly_appraisal->appraisal_counter == 2 && 3440 == Auth::user()->id)
                                                <td id="{{ $deliverable->id }}">
                                                    <button class="performance-btn midterm-select btn btn-success-outline" data-type="copy" data-id="{{$deliverable->id}}" data-department="{{$department_id}}" data-month="{{$active_month}}"><i class="ph-copy"></i> Select</button>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach

                    {{-- Total Weight Row --}}
                    <tr>
                        <th></th>
                        <th colspan="7" style="text-align: right;">Total</th>
                        <th style="text-align:center;">{{ $total_weight }}</th>
                        <th style="text-align:center;"></th>
                        <th style="text-align:center;"></th>
                        <th style="text-align:center;"></th>
                        <th style="text-align:center;">{{ $total_emp_midterm }}</th>
                        <th style="text-align:center;"></th>
                        <th style="text-align:center;"></th>
                        <th style="text-align:center;">{{ $total_sup_midterm }}</th>
                    </tr>
                </tbody>
            </table>



        </div>
    @else
        <div class="card-body">
            <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                <span class="alert-icon bg-warning text-white">
                    <i class="ph-warning-circle"></i>
                </span>
                <span class="fw-semibold">Workplan has no Key Undertakings</span>
            </div>
        </div>
    @endif
@endif

<?php
    use \App\Http\Controllers\MaDepartmentAppraisal;
    $midterm = new MaDepartmentAppraisal();

    if($monthly_appraisal){

        $midterm->display(
            array(
                'table'=>'staff_monthly_appraisals',
                'status'=>'appraisal_status',
                'counter'=>$monthly_appraisal->appraisal_counter ?? 0,
                'counter_field'=>'appraisal_counter',
                'id_field'=>'id',
                "where"=>'Department Appraisal',
                "id"=>$monthly_appraisal->id ?? 0,
                "notify_user"=>$appraisal->user_id ?? 0,
                "reference"=>$monthly_appraisal->code ?? 0,
            )
        );

    }

?>

