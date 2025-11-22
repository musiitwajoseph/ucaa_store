<style>

    table {
        width: 100%;
        table-layout: fixed; /* Ensure proper layout for columns */
        border-collapse: collapse;
        font-family: arial;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 1px;
        text-align: left;
        word-wrap: break-word;
        display: table-cell;
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
@php
$total_weight = $total_emp_midterm = $total_sup_midterm = 0;
@endphp

{{-- SECTION WORK PLAN STARTS--}}

<div style="border:1px solid #000; box-shadow:-5px 5px #000; width: 200px; margin:15px auto; font-size:16px; background-color:#247297; color:#fff;text-align:center; ">Individual Workplan - Midterm Appraisal</div>


@if($appraisal)
@if ($appraisal->keyDeliverables->count() > 0)

<table class="table table-xs table-condensed eagle-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Line</th>
                                <th>#</th>
                                <th>Strategic Objective</th>
                                <th>#</th>
                                <th>Strategic Initiative</th>
                                <th>Key Undertaking</th>
                                <th>Key Deliverable/ Output</th>
                                <th>Timelines/ By When</th>
                                {{-- <th>By Who</th> --}}
                                <th>Weight</th>
                                <th>Achievement</th>
                                <th>Evidence</th>
                                <th>Rating</th>
                                <th>Weighted Score</th>
                                <th>Supervisor<br/>Comment on Achievement</th>
                                <th>Supervisor<br/>Rating</th>
                                <th>Supervisor<br/>Weighted Score</th>
                                @if(@$appraisal->approval_mid_term_status == 0)
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_weight = 0;
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
                                    <td colspan="17" style="text-align: center; font-weight: bold; color:#fff; background-color:#316789;">{{ $pillarName }}</td>
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
                                                <tr>
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
                                                        <td rowspan="{{ $rowspanUndertaking }}">{!! nl2br($undertakingName) !!}</td>
                                                    @endif

                                                    {{-- Key Deliverable/ Output --}}
                                                    <td class="workplan-deliverable-{{ $deliverable->id }}">{!! n2br($deliverable->name) ?? '' !!}</td>

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
                                                    <td style="text-align:center;">{{ isset($deliverable->weight) ? number_format($deliverable->weight, 2) : '' }}</td>

                                                    <td style="">{{$deliverable->mid_term_emp_achievement ?? ""}}</td>
                                                    <td style="">
                                                        @if($deliverable->attachments()->count()
 + $deliverable->links->count() > 1)
                                                        Yes ({{ $deliverable->attachments()->count() + ($deliverable->links ? $deliverable->links->count() : 0) }})
                                                        @elseif($deliverable->attachments()->count() || $deliverable->links->count())
                                                        Yes
                                                        @else
                                                        No
                                                        @endif
                                                    </td>
                                                    <td style="">{{$deliverable->mid_term_emp_rating ?? ""}}</td>
                                                    <td style="">{{($deliverable->mid_term_emp_score) ? number_format($deliverable->mid_term_emp_score,1) : ""}}</td>

                                                    @php
                                                    $total_weight += $deliverable->weight;
                                                    $total_emp_midterm += $deliverable->mid_term_emp_score;
                                                    $total_sup_midterm += $deliverable->mid_term_sup_score;
                                                    @endphp

                                                    <td style="">{{$deliverable->mid_term_sup_achievement ?? ""}}</td>
                                                    <td style="">{{$deliverable->mid_term_sup_rating ?? ""}}</td>
                                                    <td style="">{{($deliverable->mid_term_sup_score) ? number_format($deliverable->mid_term_sup_score,1) : ""}}</td>


                                                    @if(@$appraisal->approval_mid_term_status == 0)
                                                        <td id="{{ $deliverable->id }}">
                                                            <button class="performance-btn midterm-select btn btn-success-outline" data-type="copy" data-id="{{$deliverable->id}}"><i class="ph-copy"></i> Select</button>
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
            use \App\Http\Controllers\MaMidterm;
            $midterm = new MaMidterm();

            if($appraisal){

                $midterm->display(
                    array(
                        'table'=>'staff_appraisals',
                        'status'=>'approval_mid_term_status',
                        'counter'=>$appraisal->approval_mid_term_counter,
                        'counter_field'=>'approval_mid_term_counter',
                        'id_field'=>'id',
                        "where"=>'Mid Term',
                        "id"=>$appraisal->id,
                        "notify_user"=>$appraisal->user_id,
                        "reference"=>$appraisal->code,
                    )
                );

            }

        ?>


        {{-- MID TERM ENDS --}}
