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

<table style="border-collapse:collapse;border:none;font-size:12px !important;" class="mb-4" width="100%">
    <tbody>
        <tr>
            <td style="width: 250.45pt;border: 1pt solid windowtext;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">EMPLOYEE&rsquo;S NAME &amp; TITLE:</span></strong></p>
            </td>
            <td style="width: 281.5pt;border: 1pt solid windowtext;padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>{{ $user->full_name ?? '' }}, {{$user->position->name ?? '' }}</p>
            </td>
            <td style="width: 224.35pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="">CHECK NUMBER:</strong> {{$user->check_number ?? '' }}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">DOCUMENT CODE: </span></strong> </p>
            </td>
            <td colspan="2" style="width: 505.85pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>{{ $appraisal->code ?? '' }}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">APPRAISAL TYPE:</span></strong></p>
            </td>
            <td style="width: 281.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>{{ $appraisal->appraisalType->name ?? '' }}</p>
            </td>
            <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;' class="text-uppercase"><strong>STATUS:</strong>
                    {!!\App\Helpers\AppraisalDocumentStatus::wordById($appraisal->id, '<br/>')!!}

                </p>
            </td>
        </tr>
        <tr>
            <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">APPRAISAL PERIOD:</span></strong> {{ $appraisal->appraisalPeriod->code ?? '' }}</p>
            </td>
            <td style="width: 281.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-success">START DATE: </strong> {{ $appraisal->appraisalPeriod->start_date ?? '' }} </p>
            </td>
            <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;">
            <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-danger">END DATE:</strong> {{ $appraisal->appraisalPeriod->end_date ?? '' }}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">SUPERVISOR&rsquo;S NAME &amp; TITLE:</span></strong></p>
            </td>
            <td colspan="2" style="width: 505.85pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>

                        {{$user->line_manager->full_name ?? '' }}, {{$user->line_manager->position->name ?? '' }}

                </p>
            </td>
        </tr>

        <tr>
            <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">SUBMISSION AND REVIEW:</span></strong></p>
            </td>
            <td style="width: 281.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-primary">SUBMITTED ON: </strong> {{$appraisal->workplan_submission_date ?? ""}}</p>
            </td>
            <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-primary">REVIEWED ON: </strong>{{$appraisal->workplan_approval_date ?? ""}} </p>
            </td>
        </tr>

    </tbody>
</table>



{{-- SECTION WORK PLAN STARTS--}}

<div style="border:1px solid #000; box-shadow:-5px 5px #000; width: 200px; margin:15px auto; font-size:16px; background-color:#247297; color:#fff;text-align:center; ">Individual Workplan</div>


@if($appraisal)
@if ($appraisal->keyDeliverables->count() > 0)
<div class="table-responsive">

    <table boder="1" cellspacing="0" cellpadding="0" class="table table-xs table-condensed eagle-table" style="width:100%;font-size:10px; font-family:arial;">
        <thead>
            <tr>
                <td>Line</td>
                <td>#</td>
                <td>Strategic Objective</td>
                <td>#</td>
                <td>Strategic Initiative</td>
                <td>Key Undertaking</td>
                <td>Key Deliverable/ Output</td>
                <td>Timelines/ By When</td>
                <td>By Who</td>
                <td>Weight</td>
                @if(@$appraisal->approval_work_plan_status == 0)
                <td>Actions</td>
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
                    <th colspan="11" style="text-align: center; font-weight: bold; color:#fff; background-color:#316789;">{{ $pillarName }}</th>
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
                                    <td class="workplan-deliverable-{{ $deliverable->id }}">{!! nl2br($deliverable->name) ?? '' !!}</td>

                                    {{-- Timelines --}}
                                    <td>
                                        <p>{{ ($deliverable->timeline && $deliverable->review_type_id == 6) ? date('Y-m-d',strtotime($deliverable->timeline)) :  '' }}</p>
                                        @if ($deliverable->review_type_id && $deliverable->review_type_id != 6)
                                            <p>{{ $deliverable->reviewType->review_name ?? '' }}</p>
<p>{{ $deliverable->timeline_comment ?? ''}}</p>
                                        @endif
                                    </td>

                                    {{-- By Who --}}
                                    <td>
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

                                    {{-- Weight --}}
                                    <td style="text-align:center;">{{ isset($weight) ? rtrim(rtrim(number_format($weight, 2, '.', ''), '0'), '.') : '' }}</td>

                                    @if(@$appraisal->approval_work_plan_status == 0)
                                        <td id="{{ $deliverable->id }}">
                                            <button class="performance-btn workplan-copy btn btn-success-outline" data-type="copy" data-id="{{$deliverable->id}}"><i class="ph-copy"></i> Copy</button>
                                            <button class="performance-btn workplan-edit btn btn-success-outline" data-type="edit" data-id="{{$deliverable->id}}"><i class="ph-pencil"></i> Edit</button>
                                            <button class="performance-btn workplan-delete btn btn-success-outline" data-type="delete" data-id="{{$deliverable->id}}"><i class="ph-trash"></i> Delete</button>
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
                <th colspan="8" style="text-align: right;">Total</th>
                <th style="text-align:center;">{{ $total_weight }}</th>
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
use \App\Http\Controllers\MaGoalSetting;
$workflow = new MaGoalSetting();

if($appraisal){

$workflow->display(
    array(

        'table'=>'staff_appraisals',
        'status'=>'approval_work_plan_status    ',
        'counter'=>$appraisal->approval_work_plan_counter,
        'counter_field'=>'approval_work_plan_counter',
        'id_field'=>'id',
        "where"=>'Goal Setting',
        "id"=>$appraisal->id,
        "notify_user"=>$appraisal->user_id,
        "reference"=>$appraisal->code,
    )
);

}



?>
