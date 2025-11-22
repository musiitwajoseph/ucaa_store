<div class="row"> 
    
    <div class="col-sm-6 col-xl-3">
        <a href="#departmentalStaff" data-bs-toggle="modal">
            <div class="card card-body bg-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="ph-users-three ph-2x me-3"></i>

                    <div class="flex-fill text-end">
                        <h1 class="mb-0">{{ $lists->count() }}</h1>
                        <span class="fw-semibold">TOTAL STAFF IN {{ $header }}</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="#submittedWorkplans" data-bs-toggle="modal">
            <div class="card card-body bg-warning text-white">
                <div class="d-flex align-items-center">
                    <i class="ph-hand-pointing ph-2x me-3"></i>

                    <div class="flex-fill text-end">
                        <h2 class="mb-0">{{ $workplans->count() }}</h2>
                        <span class="fw-semibold">SUBMITTED WORKPLANS</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="#submittedMidTerms" data-bs-toggle="modal">
            <div class="card card-body bg-indigo text-white">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h2 class="mb-0">{{ $midterms->count() }}</h2>
                        <span class="fw-semibold">COMPLETED MIDYEAR</span>
                    </div>

                    <i class="ph-chats ph-2x ms-3"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="#completedAppraisals" data-bs-toggle="modal">
            <div class="card card-body bg-success text-white">
                <div class="d-flex align-items-center">
                    <div class="flex-fill">
                        <h2 class="mb-0">{{ $finals->count() }}</h2>
                        <span class="fw-semibold">COMPLETED FINAL APPRAISAL</span>
                    </div>

                    <i class="ph-package ph-2x ms-3"></i>
                </div>
            </div>
        </a>
    </div>
</div>
<!-- /simple statistics -->

<!-- StaffList in department area -->
<div class="modal fade" id="departmentalStaff" tabindex="-1" aria-labelledby="createAppraisalInstance" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAppraisalInstanceLabel">LIST OF STAFF IN THE {{ $header }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($lists->count() > 0)
                    <table class="table datatable-button-html5-columns eagle-table2">
                        <thead>
                            <tr>
                                <th style="width:30px;">No.</th>
                                <th>Check Number</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Section</th>
                                <th>Unit</th>
                            </tr>
                        </thead>                        
                        <tbody>
                            @foreach($lists as $key => $list)
                                <tr>
                                    <td>{{$key + 1}}.</td>
                                    <td>{{$list->check_number}}</td>
                                    <td>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</td>
                                    <td>{{$list->position ?? ''}}</td>                        
                                    <td>{{$list->section ?? ''}}</td>                        
                                    <td>{{$list->unit ?? ''}}</td>                        
                                </tr>       
                            @endforeach
                        </tbody>
                    </table>  
                @else
                    
                <div class="card-body">
                    <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                        <span class="alert-icon bg-warning text-white">
                            <i class="ph-warning-circle"></i>
                        </span>
                        <span class="fw-semibold">No Staff in your {{ $header }} yet!</span>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
<!-- /StaffList in department area -->

<!-- Submitted Workplans in department area -->
<div class="modal fade" id="submittedWorkplans" tabindex="-1" aria-labelledby="submittedWorkplans" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submittedWorkplansLabel">LIST OF SUBMITTED WORPLANS IN THE {{ $header }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($workplans->count() > 0)
                    <table class="table datatable-button-html5-columns eagle-table2">
                        <thead>
                            <tr>
                                <th style="width:30px;">No.</th>
                                <th>Check Number</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Section</th>
                                <th>Unit</th>
                                <th>Appraisal Code</th>
                                <th>Status</th>
                                <th>View Document</th>
                            </tr>
                        </thead>                        
                        <tbody>
                            @foreach($workplans as $key => $workplan)
                                <tr>
                                    <td>{{$key + 1}}.</td>
                                    <td>{{$workplan->check_number}}</td>
                                    <td>{{$workplan->first_name}} {{$workplan->middle_name}} {{$workplan->last_name}}</td>
                                    <td>{{$workplan->position ?? ''}}</td>                        
                                    <td>{{$workplan->section ?? ''}}</td>                        
                                    <td>{{$workplan->unit ?? ''}}</td>                        
                                    <td>{{$workplan->code ?? ''}}</td>                        
                                    <td>{!!\App\Helpers\AppraisalDocumentStatus::currentStatusWord($workplan->userid, $workplan->appraisal_period_id ?? '')!!}</td>                        
                                    <td><a href="{{ route('view-workplan', ['id' => $workplan->id]) }}"><i class="fa fa-fw fa-list"></i> View Document</td>                        
                                </tr>       
                            @endforeach
                        </tbody>
                    </table>  
                @else
                    
                <div class="card-body">
                    <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                        <span class="alert-icon bg-warning text-white">
                            <i class="ph-warning-circle"></i>
                        </span>
                        <span class="fw-semibold">No Submissions yet!</span>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
<!-- /Submitted Workplans in department area -->

<!-- Completed MidTerm in department area -->
<div class="modal fade" id="submittedMidTerms" tabindex="-1" aria-labelledby="submittedMidTerms" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submittedMidTermsLabel">LIST OF COMPLETED MIDTERM APPRAISALS IN THE {{ $header }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($midterms->count() > 0)
                    <table class="table datatable-button-html5-columns eagle-table2">
                        <thead>
                            <tr>
                                <th style="width:30px;">No.</th>
                                <th>Check Number</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Section</th>
                                <th>Unit</th>
                                <th>Appraisal Code</th>
                                <th>Status</th>
                                <th>View Document</th>
                            </tr>
                        </thead>                        
                        <tbody>
                            @foreach($midterms as $key => $midterm)
                                <tr>
                                    <td>{{$key + 1}}.</td>
                                    <td>{{$midterm->check_number}}</td>
                                    <td>{{$midterm->first_name}} {{$midterm->middle_name}} {{$midterm->last_name}}</td>
                                    <td>{{$midterm->position ?? ''}}</td>                        
                                    <td>{{$midterm->section ?? ''}}</td>                        
                                    <td>{{$midterm->unit ?? ''}}</td>                        
                                    <td>{{$midterm->code ?? ''}}</td>                        
                                    <td>{!!\App\Helpers\AppraisalDocumentStatus::currentStatusWord($midterm->userid, $midterm->appraisal_period_id ?? '')!!}</td>                        
                                    <td><a href="{{ route('view-workplan', ['id' => $midterm->id]) }}"><i class="fa fa-fw fa-list"></i> View Document</td>                        
                                </tr>       
                            @endforeach
                        </tbody>
                    </table>  
                @else
                    <div class="card-body">
                        <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                            <span class="alert-icon bg-warning text-white">
                                <i class="ph-warning-circle"></i>
                            </span>
                            <span class="fw-semibold">No Completed MidTerm Appraisals yet!</span>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
<!-- /Completed MidTerm in department area -->

<!-- Completed Appraisals in department area -->
<div class="modal fade" id="completedAppraisals" tabindex="-1" aria-labelledby="completedAppraisals" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completedAppraisalsLabel">LIST OF COMPLETED FINAL APPRAISALS IN THE {{ $header }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($finals->count() > 0)
                    <table class="table datatable-button-html5-columns eagle-table2">
                        <thead>
                            <tr>
                                <th style="width:30px;">No.</th>
                                <th>Check Number</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Section</th>
                                <th>Unit</th>
                                <th>Appraisal Code</th>
                                <th>Final Score</th>
                                <th>Status</th>
                                <th>View Document</th>
                            </tr>
                        </thead>                        
                        <tbody>
                            @foreach($finals as $key => $final)
                                <tr>
                                    <td>{{$key + 1}}.</td>
                                    <td>{{$final->check_number}}</td>
                                    <td>{{$final->first_name}} {{$final->middle_name}} {{$final->last_name}}</td>
                                    <td>{{$final->position ?? ''}}</td>                        
                                    <td>{{$final->section ?? ''}}</td>                        
                                    <td>{{$final->unit ?? ''}}</td>                        
                                    <td>{{$final->code ?? ''}}</td>                        
                                    <td>{{number_format(AppraisalService::totalScore('FINAL', 'SUP', $final->id ?? '' ),1)}}</td>                        
                                    <td>{!!\App\Helpers\AppraisalDocumentStatus::currentStatusWord($final->userid, $midterm->appraisal_period_id ?? '')!!}</td>                        
                                    <td><a href="{{ route('view-workplan', ['id' => $final->id]) }}"><i class="fa fa-fw fa-list"></i> View Document</td>                        
                                </tr>       
                            @endforeach
                        </tbody>
                    </table>  
                @else
                    <div class="card-body">
                        <div class="alert alert-warning alert-icon-start alert-dismissible fade show">
                            <span class="alert-icon bg-warning text-white">
                                <i class="ph-warning-circle"></i>
                            </span>
                            <span class="fw-semibold">No Completed Final Appraisals yet!</span>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
<!-- /Completed Appraisals in department area -->