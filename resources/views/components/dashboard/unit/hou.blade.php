<div class="row"> 
    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-primary text-white">
            <div class="d-flex align-items-center">
                <i class="ph-users-three ph-2x me-3"></i>

                <div class="flex-fill text-end">
                    <h1 class="mb-0">{{ EmployeeService::getStaffListByUnitForHead(Auth::user()->id)->count() }}</h1>
                    <span class="fw-semibold">TOTAL STAFF IN UNIT</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-warning text-white">
            <div class="d-flex align-items-center">
                <i class="ph-hand-pointing ph-2x me-3"></i>

                <div class="flex-fill text-end">
                    <h2 class="mb-0">{{ AppraisalService::getUnitAppraisalsListHead(Auth::user()->id,$activeAppraisalPeriod->id)->count() }}</h2>
                    <span class="fw-semibold">SUBMITTED WORKPLANS</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-indigo text-white">
            <div class="d-flex align-items-center">
                <div class="flex-fill">
                    <h2 class="mb-0">{{ AppraisalService::getUnitCompletedMidHead(Auth::user()->id,$activeAppraisalPeriod->id)->count() }}</h2>
                    <span class="fw-semibold">COMPLETED MIDYEAR</span>
                </div>

                <i class="ph-chats ph-2x ms-3"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-body bg-success text-white">
            <div class="d-flex align-items-center">
                <div class="flex-fill">
                    <h2 class="mb-0">{{ AppraisalService::getUnitCompletedFinalHead(Auth::user()->id,$activeAppraisalPeriod->id)->count() }}</h2>
                    <span class="fw-semibold">COMPLETED FINAL APPRAISAL</span>
                </div>

                <i class="ph-package ph-2x ms-3"></i>
            </div>
        </div>
    </div>
</div>
<!-- /simple statistics -->