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
                    <table style="border-collapse:collapse;border:none;" class="mb-4" width="100%">
                        <tbody>
                            <tr>
                                <td style="width: 250.45pt;border: 1pt solid windowtext;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">EMPLOYEE&rsquo;S NAME &amp; TITLE:</span></strong></p>
                                </td>
                                <td style="width: 281.5pt;border: 1pt solid windowtext;padding: 2pt 5.4pt;vertical-align: top;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>{{ $appraisal->user->full_name ?? '' }}, {{$appraisal->user->position->name ?? '' }}</p>
                                </td>
                                <td style="width: 224.35pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="">CHECK NUMBER:</strong> {{$appraisal->user->check_number ?? '' }}</p>
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


                                        {!!\App\Helpers\AppraisalDocumentStatus::wordById(@$appraisal->id, ',')!!}

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">APPRAISAL PERIOD:</span></strong> {{ $appraisal->appraisalPeriod->code ?? '' }}</p>
                                </td>
                                <td style="width: 281.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-success">START DATE: </strong> {{ $appraisal->probation_review_submission_date ?? '' }} </p>
                                </td>
                                <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;">
                                <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-danger">END DATE:</strong> {{ $appraisal->probation_review_approved_date ?? '' }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">SUPERVISOR&rsquo;S NAME &amp; TITLE:</span></strong></p>
                                </td>
                                <td colspan="2" style="width: 505.85pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;vertical-align: top;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'>

                                            {{$appraisal->user->line_manager->full_name ?? '' }}, {{$appraisal->user->line_manager->position->name ?? '' }}

                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 250.45pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;background: rgb(191, 191, 191);padding: 2pt 5.4pt;vertical-align: top;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong><span style="color:black;">SUBMISSION AND REVIEW:</span></strong> {{$appraisal->probation_review_submission_date ?? ''}}</p>
                                </td>
                                <td style="width: 281.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 2pt 5.4pt;vertical-align: top;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-primary">SUBMITTED ON: </strong> {{$appraisal->probation_review_submission_date ?? ""}}</p>
                                </td>
                                <td style="width: 224.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;">
                                    <p style='margin:0cm;font-size:13px;font-family:"Arial",sans-serif;'><strong class="text-primary">REVIEWED ON: </strong>{{$appraisal->probation_review_approved_date ?? ""}} </p>
                                </td>
                            </tr>

                        </tbody>
                    </table>

            <hr style="opacity:100; background-color: #000;height:4px; margin-top:20px;">
            <div style="border:1px solid #000; box-shadow:-5px 5px #000; width: 350px; margin:15px auto; font-size:16px; background-color:#247297; color:#fff;text-align:center; position: relative; top:-30px;font-weight:bold;margin-bottom:-20px; ">Probation Performance Review</div>


        <h3 class="mt-4 pb-0 text-secondary">Part 1:  Performance Expectations - the ‘what’</h3>
        <p>Objectives are the things that you need to achieve and will link to the aims of your department. Key Performance Indicators (KPIs) are the success criteria by which you measure your performance towards achieving those goals; the activities you need to focus on to achieve your overall objectives.</p>
        @if($appraisal)
            @if ($appraisal->keyDeliverables->count() > 0)
                <div class="table-responsive">

                    <table class="table table-xs table-condensed eagle-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th rowspan="2">Line</th>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Strategic Objective</th>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Strategic Initiative</th>
                                <th rowspan="2">Key Undertaking</th>
                                <th rowspan="2">Key Deliverable/ Output</th>
                                <th rowspan="2">Timelines/ By When</th>
                                <th colspan="3" style="border-left:2px solid #000">Employee</th>
                                <th colspan="2" style="border-left:2px solid #000">Supervisor</th>

                                @if(($appraisal->approval_probation_review_status == 0 && @$appraisal->user_id == Auth::user()->id) ||
                ($appraisal->approval_probation_review_counter == 2 && @$appraisal->user->line_manager->id == Auth::user()->id)
                )
                                <th rowspan="2" class="text-center">Actions</th>
                                @endif
                            </tr>
                            <tr>
                                <th style="border-left:2px solid #000">Status</th>
                                <th>Achievement</th>
                                <th>Evidence</th>
                                <th style="border-left:2px solid #000">Status</th>
                                <th>Achievement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $probation = [1 => 'Not Done', 2 => 'Partially Done', 3 => 'Fully Done'];
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
                                                <tr id="deliverable-{{$deliverable->id}}" class="{{ ($appraisal->active_line == $deliverable->id) ? 'active-line' : '' }}">
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
                                                        <td rowspan="{{ $rowspanUndertaking }}">{!! nl2br($undertakingName) ?? '' !!}</td>
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
                                                    <td  style="border-left:2px solid #000">{{ @$probation[(int)$deliverable->mid_term_emp_rating ?? ""]}}</td>
                                                    <td style="">{{$deliverable->mid_term_emp_achievement ?? ""}}</td>
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

                                                    <td  style="border-left:2px solid #000">{{ @$probation[(int)$deliverable->mid_term_sup_rating ?? ""]}}</td>
                                                    <td style="">{{$deliverable->mid_term_sup_achievement ?? ""}}</td>

                                                    @php
                                                    $total_weight += $deliverable->weight;
                                                    $total_emp_midterm += $deliverable->mid_term_emp_score;
                                                    $total_sup_midterm += $deliverable->mid_term_sup_score;
                                                    @endphp

                                                    @if((@$appraisal->approval_probation_review_status == 0 && @$appraisal->user_id == Auth::user()->id) ||
                ($appraisal->approval_probation_review_counter == 2 && @$appraisal->user->line_manager->id == Auth::user()->id)
                )
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




        <h3 class="mt-4 pb-0 text-secondary" id="part-2">Part 2: Behaviours – the ‘how’</h3>
        <table class="eagle-table2">
            <tr>
                <th rowspan="2">Behaviours</th>
                <th rowspan="2">Definition/ Description.</th>
                <th colspan="2" style="border-left:2px solid #000">Employee</th>
                <th colspan="2" style="border-left:2px solid #000">Supervisor</th>
                @if(@
                ($appraisal->approval_probation_review_status == 0 && @$appraisal->user_id == Auth::user()->id) ||
                ($appraisal->approval_probation_review_counter == 2 && @$appraisal->user->line_manager->id == Auth::user()->id)
                )
                <th rowspan="2" class="text-center">Actions</th>
                @endif
            </tr>

            @if(@$appraisal->approval_probation_preview_status == 0)
            <tr>
                <th style="border-left:2px solid #000">Status</th>
                <th>Employee&nbsp;Comment</th>
                <th style="border-left:2px solid #000">Status</th>
                <th>Employee&nbsp;Comment</th>
            </tr>
            @endif

            {{-- <tr>
                <th>Consistently Demonstrated (Behaviour demonstrated most of the time)</th>
                <th>Occasionally Demonstrated (Behaviour demonstrated sometimes)</th>
                <th>Not Demonstrated</th>
                <th>General Comments/Agreed Actions</th>
            </tr> --}}
            @if($behavior_list->count())
                @php
                    $probation = [1 => 'Not Done', 2 => 'Partially Done', 3 => 'Fully Done'];
                @endphp
                @foreach ($behavior_list as $item)
                    @php $behaviour = $behaviours[$item->id] ?? ''; @endphp
                    <tr>
                        <td class="fw-bold">{{$item->title}}</td>
                        <td style="max-width:20%;">{{$item->description}}</td>
                        <td style="border-left:2px solid #000">{{@$probation[$behaviour->emp_status ?? 0]}}</td>
                        <td>{{$behaviour->emp_comment ?? ''}}</td>
                        <td style="border-left:2px solid #000">{{@$probation[$behaviour->sup_status ?? 0]}}</td>
                        <td>{{$behaviour->sup_comment ?? ''}}</td>

                        @if(@
                        ($appraisal->approval_probation_review_status == 0 && @$appraisal->user_id == Auth::user()->id) ||
                        ($appraisal->approval_probation_review_counter == 2 && @$appraisal->user->line_manager->id == Auth::user()->id)
                        )
                            <td id="{{ $item->id }}">
                                <button class="performance-btn behaviour-select btn btn-success-outline" data-type="copy" data-id="{{$item->id}}"><i class="ph-copy"></i> Select</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </table>

        @if((@$appraisal->approval_probation_review_status == 1 && @$appraisal->user->line_manager->id == Auth::user()->id ) || (@$appraisal->approval_probation_review_status >= 2))

        <h3 class="mt-4 pb-0 text-secondary">Part 3: Overall Rating</h3>
        <table class="eagle-table2" style="width:100%;">
            <tr>
                <th>Performance Level</th>
                <th>Description.</th>
                <th>Definition</th>
            </tr>

            @if($overall_rating->count())
                @foreach ($overall_rating as $item)
                    <tr>
                        <td class="text-center fw-bold overall-rating" style="text-align: center;">
                            @if(@$appraisal->probation_overall_rating_id == @$item->id)
                                <div class="" style="width:30px;height:30px;border-radius:20px;border:2px solid #000;background-color:#000;color:#fff;text-align:center;line-height:26px;margin:auto;">{{$item->code}}</div>
                            @else
                                <div>{{$item->code}}</div>
                            @endif
                        </td>
                        <td class="text-center fw-bold">{{$item->title}}</td>
                        <td>{{$item->definition}}</td>
                    </tr>
                @endforeach
            @endif
        </table>

        @if((@$appraisal->approval_probation_review_counter == 2 && @$appraisal->user->line_manager->id == Auth::user()->id ))

        <div class="row">
            <div class="col-md-4">
                <label class="fw-bold mt-3">Select Overall Rating:</label>
                <select class="form-control select" id="overall_rating">
                    <option value="">Select</option>
                    @foreach ($overall_rating as $item)
                        <option value="{{$item->id}}">{{$item->code}}, {{$item->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <h3 class="mt-4 pb-0 text-secondary" id="part-4">Part 4: Personal Development Plan</h3>
        <p>Having discussed performance, considering behavior, ability, skills and knowledge, record agreed areas of development in terms of current role and possible career development for the future. E.g. job enlargement, job enrichment, coaching, mentoring, training, job shadowing, job rotation, etc.</p>
        <table class="eagle-table2">
            <tr>
                <th>Development Need / Requirement</th>
                <th>Planned Action</th>
                <th>By when</th>
                <th>Support required and by who</th>
            </tr>

            @if(count($development_plans))
                @foreach($development_plans as $plan)
                    @php
                        if((@$appraisal->approval_probation_review_counter == 2 && @$appraisal->user->line_manager->id == Auth::user()->id )){
                            $edit = '<br/><b class="text-danger"><i>[Click to Edit]</i></b>';
                            $develop_plan = "development-plan";
                        }else {
                            $edit = '';
                            $develop_plan = "";
                        }
                    @endphp
                    <tr class="{{ $develop_plan }}" data-id="{{$plan->id}}">
                        <td>{!! $plan->development_need.$edit !!}</td>
                        <td>{!! $plan->planned_action.$edit !!}</td>
                        <td>{!! ($plan->by_when ? \Carbon\Carbon::parse($plan->by_when)->format('Y-m-d') : '').$edit !!}</td>
                        <td>{!! $plan->support_required.$edit !!}</td>
                    </tr>
                @endforeach
            @else
                <tr class="development-plan" data-id="">
                    <td><b class="text-danger"><i>[Click to Add Line]</i></b></td>
                    <td><b class="text-danger"><i>[Click to Add Line]</i></b></td>
                    <td><b class="text-danger"><i>[Click to Add Line]</i></b></td>
                    <td><b class="text-danger"><i>[Click to Add Line]</i></b>&nbsp;</td>
                </tr>
            @endif
        </table>

        @if((@$appraisal->approval_probation_review_counter == 2 && @$appraisal->user->line_manager->id == Auth::user()->id ))
        <button class="btn btn-dark xs p-1 mt-3 development-plan" data-id=""><i class="ph-plus"></i> Add Line</button>
        @endif


        @endif

        <h3 class="mt-4 pb-0 text-secondary">Part 5: Comments & Sign-Off</h3>
        <p>Use the space below to summarise your conclusion on the performance which has been reviewed.</p>



        <?php

            use \App\Http\Controllers\MaProbationReview;
            $goal_setting = new MaProbationReview();
            if($goal_setting){
                $goal_setting->display(
                    array(
                        'table'=>'staff_appraisals',
                        'status'=>'approval_probation_review_status',
                        'counter'=>$appraisal->approval_final_counter,
                        'counter_field'=>'approval_probation_review_counter',
                        'id_field'=>'id',
                        "where"=>'Probation Review',
                        "id"=>$appraisal->id,
                        "notify_user"=>$appraisal->user_id,
                        "reference"=>$appraisal->code,
                    )
                );
            }

        ?>




    </div>
</div>

