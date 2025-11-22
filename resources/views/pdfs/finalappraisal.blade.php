<style>
    body {
        font-size: 14pt !important;
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
@php
$total_weight = $total_emp_midterm = $total_sup_midterm = 0;
@endphp

{{-- SECTION WORK PLAN STARTS--}}

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
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>{{ $final_appraisal->code ?? '' }}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">APPRAISAL TYPE:</span></strong></p>
            </td>
            <td style="width: 281.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>{{ $final_appraisal->appraisalType->name ?? '' }}</p>
            </td>
            <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;' class="text-uppercase"><strong>STATUS:</strong>
                    {!!\App\Helpers\AppraisalDocumentStatus::wordById($final_appraisal->id, '<br/>')!!}

                </p>
            </td>
        </tr>
        <tr>
            <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">APPRAISAL PERIOD:</span></strong> {{ $final_appraisal->appraisalPeriod->code ?? '' }}</p>
            </td>
            <td style="width: 281.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-success">START DATE: </strong> {{ $final_appraisal->start_date ?? '' }} </p>
            </td>
            <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;">
            <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-danger">END DATE:</strong> {{ $final_appraisal->end_date ?? '' }}</p>
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
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-primary">SUBMITTED ON: </strong> {{$final_appraisal->final_submission_date ?? ""}}</p>
            </td>
            <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;">
                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-primary">REVIEWED ON: </strong>{{$final_appraisal->final_approval_date ?? ""}} </p>
            </td>
        </tr>

    </tbody>
</table>

<div style="border:1px solid #000; box-shadow:-5px 5px #000; width: 400px; margin:15px auto; font-size:12px; background-color:#247297; color:#fff;text-align:center; ">Individual Workplan - Final Appraisal</div>


@if($appraisal)
@if ($appraisal->keyDeliverables->count() > 0)

<h3 class="text-primary">Section A : Technical Assessment</h3>
<table border="1" style="width:100%;font-size:12px;">
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
            <th style="max-width:100px;">Final Achievement</th>
            <th>Evidence</th>
            <th>Rating</th>
            <th>Weighted Score</th>
            <th>Supervisor<br/>Comment on Achievement</th>
            <th>Supervisor<br/>Rating</th>
            <th>Supervisor<br/>Weighted Score</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_weight = $total_emp_final = $total_sup_final = 0;
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

                                <td style="">{{$deliverable->final_emp_achievement ?? ""}}</td>
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
                                <td style="">{{($deliverable->final_emp_rating) ? number_format($deliverable->final_emp_rating,1) : ""}}</td>
                                <td style="">{{($deliverable->final_emp_score) ? number_format($deliverable->final_emp_score,1) : ""}}</td>

                                <td style="">{{$deliverable->final_sup_achievement ?? ""}}</td>
                                <td style="">{{($deliverable->final_sup_rating) ? number_format($deliverable->final_sup_rating,1) : ""}}</td>
                                <td style="">{{($deliverable->final_sup_score) ? number_format($deliverable->final_sup_score,1) : ""}}</td>

                                @php
                                $total_weight += $deliverable->weight;
                                $total_emp_final += $deliverable->final_emp_score;
                                $total_sup_final += $deliverable->final_sup_score;
                                @endphp


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
            <th style="text-align:center;">{{ $total_emp_final }}</th>
            <th style="text-align:center;"></th>
            <th style="text-align:center;"></th>
            <th style="text-align:center;">{{ $total_sup_final }}</th>
        </tr>
    </tbody>
</table><br/>
                    <table border="1" class="eagle-table2">
                        <tr>
                            <th></th>
                            <th><b>Employee</b></th>
                            <th><b>Supervisor</b></th>
                        </tr>
                        <tr>
                            <td>Total Weighted Score:</td>
                            <td><b>{{ number_format($total_emp_final,2) }}</b></td>
                            <td><b>{{ number_format($total_sup_final,2) }}</b></td>
                        </tr>
                        <tr>
                            <td>Converted Score Section A: Technical Assessment ({{ ($sectionA == 70) ? "Supervisor" : "Employee"}} - {{$sectionA}})</td>
                            <td><b>{{number_format($total_emp_final/$total_weight*$sectionA, 2)}}</b></td>
                            <td><b>{{number_format($total_sup_final/$total_weight*$sectionA, 2)}}</b></td>
                        </tr>
                    </table>
                    <br/>

                    <h3 class="text-primary">Section B : Personal Attributes</h3>

                    @php
                    $rating = $agreed_rating = $employee_rating = $supervisor_rating = 0;
                    @endphp
                    <table class="table eagle-table" border="1">
                        <tr>
                            <th>No.</th>
                            <th>Attribute</th>
                            <th>Score</th>
                            <th>Demonstration</th>
                            <th>Employee Rating</th>
                            <th>Supervisor Rating</th>
                            <th>Agreed Rating</th>
                            <th>Supervisor Comment</th>
                        </tr>

                        @foreach($personalAttributes as $key => $desc)
                        <tr id="personal-attributes-{{str_replace(' ', '-', $desc[0])}}">
                            <td>{{ $key+1}}.</td>
                            <td><b>{{ $desc[0] }}:</b> {{$desc[1]}}</td>
                            <td>{{$desc[2]}}</td>
                            <td style="border-left:2px solid #000;">{{$attributes[$desc[0]]['demonstration'] ?? ''}}</td>
                            <td>{{$attributes[$desc[0]]['employee_rating'] ?? ''}}</td>
                            <td style="border-left:2px solid #000;">{{$attributes[$desc[0]]['supervisor_rating'] ?? ''}}</td>
                            <td>{{$attributes[$desc[0]]['agreed_rating'] ?? ''}}</td>
                            <td>{{$attributes[$desc[0]]['supervisor_comment'] ?? ''}}</td>
                            @php
                            $rating += $desc[2] ?? 0;
                            $employee_rating += $attributes[$desc[0]]['employee_rating'] ?? 0;
                            $supervisor_rating += $attributes[$desc[0]]['supervisor_rating'] ?? 0;
                            $agreed_rating += $attributes[$desc[0]]['agreed_rating'] ?? 0;
                            @endphp

                             @if(@$final_appraisal->approval_final_status == 0 && Auth::user()->id == @$final_appraisal->user_id || @$final_appraisal->approval_final_counter == 2 && @$final_appraisal->user->line_manager_id == Auth::user()->id)

                            <td>
                                <button class="performance-btn personal-attribute-select btn btn-success-outline" data-type="select" data-attribute="{{$desc[0]}}" data-desc="{{$desc[1]}}"  data-score="{{$desc[2]}}" data-id="{{@$final_appraisal->id}}"><i class="ph-copy"></i> Select</button>
                            </td>
                            @endif
                        </tr>
                        @endforeach

                        <tr>
                            <th colspan="2"></th>
                            <th>{{$rating}}</th>
                            <th></th>
                            <th>{{$employee_rating}}</th>
                            <th>{{$supervisor_rating}}</th>
                            <th>{{$agreed_rating}}</th>
                            <th></th>
                        </tr>
                    </table>

                    <br/>
                    <table border="1" class="eagle-table2">
                        <tr>
                            <th></th>
                            <th><b>Employee</b></th>
                            <th><b>Supervisor</b></th>
                        </tr>
                        <tr>
                            <td>Section B: Personal Attributes Score</td>
                            <td><b>{{ number_format($employee_rating,2) }}</b></td>
                            <td><b>{{ number_format($agreed_rating,2) }}</b></td>
                        </tr>
                        <tr>
                            <td>Final Score Section A And Section B	</td>
                            <td><b>{{number_format($employee_rating + $total_emp_final/$total_weight*$sectionA,2)}}</b></td>
                            <td style="color:black; background-color: {{ AppraisalService::totalScore('ANALYSIS', 'SUP', $final_appraisal->id)->color ?? '' }}"><b>{{number_format($agreed_rating + $total_sup_final/$total_weight*$sectionA,2)}}</b></td>
                        </tr>
                    </table>
                    <br/>
                    <table border="1" class="eagle-table2">
                        <tr>
                            <th><b>Analysis of Results</b></th>
                        </tr>
                        <tr style="color:black; background-color: {{ AppraisalService::totalScore('ANALYSIS', 'SUP', $final_appraisal->id)->color ?? '' }}">
                            <td><b>{{ AppraisalService::totalScore('ANALYSIS', 'SUP', $final_appraisal->id)->category ?? '' }}</b></td>
                        </tr>
                    </table>

                    {!! AppraisalService::displayAnalysis() !!}

                    <h3 class="text-primary">Section C : Strengths & Development Opportunities</h3>

                    <table id="sectionc" data-id="{{$final_appraisal->id ?? ''}}"  class="eagle-table2 {{ ($final_appraisal->approval_final_counter == 1) ? "section-c-employee" : "" }}" style="width:100%;" border="1">
                        <tr><th colspan="2"><b><u>By Employee:</u></b></th></tr>
                        <tr>
                            <td style="width:200px;"><b>Employee Comment: </b></td>
                            <td>
                                @if($final_appraisal->approval_final_counter == 1 && Auth::user()->id == @$final_appraisal->user_id)
                                    @if($final_appraisal->final_emp_comment)
                                        {{$final_appraisal->final_emp_comment }}
                                        <br/><i style="color:red;font-weight:bold;"><i class="fa fa-pencil"></i>Click to Edit</i>
                                    @else
                                        <i style="color:red;font-weight:bold;"><i class="fa fa-pencil"></i>Click to Insert</i>
                                    @endif
                                @else
                                    {{$final_appraisal->final_emp_comment ?? ''}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Strengths: </b></td>
                            <td>
                                @if($final_appraisal->approval_final_counter == 1 && Auth::user()->id == @$final_appraisal->user_id)
                                    @if($final_appraisal->final_emp_strength)
                                        {{$final_appraisal->final_emp_strength }}
                                        <br/><i style="color:red;font-weight:bold;"><i class="fa fa-pencil"></i>Click to Edit</i>
                                    @else
                                        <i style="color:red;font-weight:bold;"><i class="fa fa-pencil"></i>Click to Insert</i>
                                    @endif
                                @else
                                    {{$final_appraisal->final_emp_strength ?? ''}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Opportunities/ Development Areas: </b></td>
                            <td>
                                @if($final_appraisal->approval_final_counter == 1 && Auth::user()->id == @$final_appraisal->user_id)
                                    @if($final_appraisal->final_emp_development_plan)
                                        {{$final_appraisal->final_emp_development_plan }}
                                        <br/><i style="color:red;font-weight:bold;"><i class="fa fa-pencil"></i>Click to Edit</i>
                                    @else
                                        <i style="color:red;font-weight:bold;"><i class="fa fa-pencil"></i>Click to Insert</i>
                                    @endif
                                @else
                                    {{$final_appraisal->final_emp_development_plan ?? ''}}
                                @endif
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <table  class="eagle-table2" style="width:100%;" border="1">
                        <tr><th colspan="2"><b><u>By Supervisor
:</u></b></th></tr>
                        <tr>
                            <td style="width:200px;"><b>Strengths:</b> </td>
                            <td>
                                {{$final_appraisal->final_sup_strength ?? ''}}

                            </td>
                        </tr>
                        <tr>
                            <td><b>Career Aspirations (As discussed & agreed by the employee & the Supervisor):</b> </td>
                            <td>
                                {{$final_appraisal->final_sup_career_aspiration ?? ''}}

                            </td>
                        </tr>
                        <tr>
                            <td><b>Supervisor Comment:</b> </td>
                            <td>
                                {{$final_appraisal->final_sup_comment ?? ''}}

                            </td>
                        </tr>
                    </table>

                    {{-- <h3 class="text-primary">Section D : Line Supervisor's Recommendations</h3> --}}



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
use \App\Http\Controllers\MaFinalAppraisal;
$midterm = new MaFinalAppraisal();

if($appraisal){

$midterm->display(
array(

    'table'=>'staff_appraisals',
    'status'=>'approval_final_status',
    'counter'=>$appraisal->approval_final_counter,
    'counter_field'=>'approval_final_counter',
    'id_field'=>'id',
    "where"=>'Final Appraisal',
    "id"=>$appraisal->id,
    "notify_user"=>$appraisal->user_id,
    "reference"=>$appraisal->code,
)
);

}

?>


{{-- FINAL ENDS --}}
