


        <style>


.eagle-table2 tbody, .eagle-table2 td, .eagle-table2 tfoot, .eagle-table2 th, .eagle-table2 thead, .eagle-table2 tr, .eagle-table2{
    border: 1px solid #000;
    border-spacing: 0;
    border-color: inherit;
    font-size:11px;
    line-height: 14px;
    padding:5px;
    color:#000;
}
.eagle-table2 p{
    font-size:11px;
    line-height: 14px;
    padding: 0;
    margin: 0;
}

.eagle-table2 button{
    margin:0.3em;
    padding:0 5px;
    color:blue;
    min-width:20px;
    text-align:center;
}

.eagle-table2 button:hover{
    color:red;
    border: 1px solid red;
    background-color: #ffdcdc;
}

.eagle-table2 tr:nth-child(odd){
    background-color: #dbf1ff;
}
.eagle-table2 tr th{
    background-color: #377297;
    color:#fff;
}
.eagle-table2 tr:hover{
    color:black;
    background-color: #f7f58d;
}

.badge {
    display: inline-block;
    padding: 2px 6px;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 4px;
}

/* Custom backgrounds for status badges */
.bg-danger {
    background-color: #dc3545; /* Red */
}

.bg-warning {
    background-color: #ffc107; /* Yellow */
    color: #212529; /* Dark text on yellow */
}

.bg-info {
    background-color: #17a2b8; /* Teal */
}

/* Optional hover effect for badges */
.badge:hover {
    opacity: 0.9;
}
</style>


        @if(@$user)


                    @php
                        $notSubmittedList = [];
                        $pendingList = [];
                        $pendingAcceptanceList = [];
                        $pendingSecondList = [];

                        foreach($user->team as $employee) {
                            $appraisal = $employee->staffAppraisal->where('status', 1)->first();

                            // if ($appraisal && $appraisal->status == 1 && ($appraisal->approval_final_counter < 2 && $appraisal->approval_final_status == 1 || empty($appraisal->approval_final_status)  )) {
                            //     $notSubmittedList[] = array(
                            //         'name' => $employee->full_name ?? '',
                            //         'status' => \App\Helpers\AppraisalDocumentStatus::finalStatusInLineCss(@$appraisal->id),
                            //         'date_submitted' => $appraisal->final_submission_date ? \Carbon\Carbon::parse($appraisal->final_submission_date)->format('d M Y, h:i:s A') : '',
                            //         'code' => $appraisal->code ?? '',
                            //         'link' => url('workplan/view/' . $appraisal->id),
                            //     );
                            // }
                            // else
                            // if ($appraisal && $appraisal->status == 1 && $appraisal->approval_final_counter == 2 && $appraisal->approval_final_status == 1) {
                            //     $pendingList[] = array(
                            //         'name' => $employee->full_name ?? '',
                            //         'status' => \App\Helpers\AppraisalDocumentStatus::finalStatusInLineCss(@$appraisal->id),
                            //         'date_submitted' => $appraisal->final_submission_date ? \Carbon\Carbon::parse($appraisal->final_submission_date)->format('d M Y, h:i:s A') : '',
                            //         'code' => $appraisal->code ?? '',
                            //         'link' => url('workplan/view/' . $appraisal->id),
                            //     );
                            // }
                            // elseif ($appraisal && $appraisal->status == 1 && $appraisal->approval_final_counter == 3 && $appraisal->approval_final_status == 1) {
                            //     $pendingAcceptanceList[] = array(
                            //         'name' => $employee->full_name ?? '',
                            //         'status' => \App\Helpers\AppraisalDocumentStatus::finalStatusInLineCss(@$appraisal->id),
                            //         'date_submitted' => $appraisal->final_submission_date ? \Carbon\Carbon::parse($appraisal->final_submission_date)->format('d M Y, h:i:s A') : '',
                            //         'code' => $appraisal->code ?? '',
                            //         'link' => url('workplan/view/' . $appraisal->id),
                            //     );
                            // }
                            // else
                            if ($appraisal->approval_final_counter == 4 && $appraisal->approval_final_status == 1) {
                                $pendingSecondList[] = array(
                                    'name' => $employee->full_name ?? '',
                                    'status' => \App\Helpers\AppraisalDocumentStatus::finalStatusInLineCss(@$appraisal->id),
                                    'date_submitted' => $appraisal->final_submission_date ? \Carbon\Carbon::parse($appraisal->final_submission_date)->format('d M Y, h:i:s A') : '',
                                    'code' => $appraisal->code ?? '',
                                    'second_supervisor' => $employee->line_manager->line_manager->full_name ?? '',
                                    'link' => url('workplan/view/' . $appraisal->id),
                                );
                            }
                        }

                    @endphp


                    @if(count($notSubmittedList) || count($pendingList) || count($pendingAcceptanceList) || count($pendingSecondList))

<div style="margin-bottom: 50px; font-family: Arial, sans-serif; line-height: 1.5;">
    <p>Dear <strong>{{ $user->full_name }}</strong>,</p>

    <p>
        The following appraisals are still pending at your terminal.
    </p>

    @if(count($pendingList))
    <h4 style="font-family: Arial, sans-serif; font-size: 16px; margin-top: 20px; color: #333;">
        Pending Supervisor Approvals ({{ count($pendingList) }})
    </h4>
    <table style="border-collapse: collapse; width: 100%; margin-bottom: 20px; font-size: 11px; line-height: 14px; color: #000; border: 1px solid #000;">
        <thead>
            <tr style="background-color: #377297; color: #fff;">
                <th style="border: 1px solid #000; padding: 5px;">#</th>
                <th style="border: 1px solid #000; padding: 5px;">Appraisal Code</th>
                <th style="border: 1px solid #000; padding: 5px;">Employee Name</th>
                <th style="border: 1px solid #000; padding: 5px;">Status</th>
                <th style="border: 1px solid #000; padding: 5px;">Date Submitted</th>
                <th style="border: 1px solid #000; padding: 5px;">Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingList as $index => $employee)
                <tr style="{{ $index % 2 === 0 ? 'background-color: #dbf1ff;' : '' }}">
                    <td style="border: 1px solid #000; padding: 5px;">{{ $index + 1 }}</td>
                    <td style="border: 1px solid #000; padding: 5px;">{{ $employee['code'] }}</td>
                    <td style="border: 1px solid #000; padding: 5px;">{{ $employee['name'] }}</td>
                    <td style="border: 1px solid #000; padding: 5px;">{!! $employee['status'] !!}</td>
                    <td style="border: 1px solid #000; padding: 5px;">{{ $employee['date_submitted'] }}</td>
                    <td style="border: 1px solid #000; padding: 5px;">
                        <a href="{{ $employee['link'] }}" target="_blank" style="color: blue; text-decoration: underline;">
                            Click to View Appraisal
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

    @if(count($notSubmittedList))
    <h4 style="font-size:16px; font-weight:bold; margin: 20px 0 10px 0;">
        Appraisals Not Yet Submitted ({{ count($notSubmittedList) }})
    </h4>

    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-bottom: 20px; border:1px solid #000; font-size:11px; line-height:14px; color:#000;">
        <thead>
            <tr style="background-color: #377297; color: #ffffff;">
                <th style="border:1px solid #000; padding:5px;">#</th>
                <th style="border:1px solid #000; padding:5px;">Appraisal Code</th>
                <th style="border:1px solid #000; padding:5px;">Employee Name</th>
                <th style="border:1px solid #000; padding:5px;">Status</th>
                <th style="border:1px solid #000; padding:5px;">Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notSubmittedList as $index => $employee)
                <tr style="{{ $index % 2 == 0 ? 'background-color: #dbf1ff;' : '' }}">
                    <td style="border:1px solid #000; padding:5px;">{{ $index + 1 }}</td>
                    <td style="border:1px solid #000; padding:5px;">{{ $employee['code'] }}</td>
                    <td style="border:1px solid #000; padding:5px;">{{ $employee['name'] }}</td>
                    <td style="border:1px solid #000; padding:5px;">{!! $employee['status'] !!}</td>
                    <td style="border:1px solid #000; padding:5px;">
                        <a href="{{ $employee['link'] }}" target="_blank" style="color: blue; text-decoration: underline;">
                            Click to View Appraisal
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@if(count($pendingSecondList))
    <h4 style="font-size:16px; font-weight:bold; margin: 20px 0 10px 0;">
        Pending Second Supervisor Approvals ({{ count($pendingSecondList) }})
    </h4>

    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-bottom: 20px; border:1px solid #000; font-size:11px; line-height:14px; color:#000;">
        <thead>
            <tr style="background-color: #377297; color: #ffffff;">
                <th style="border:1px solid #000; padding:5px;">#</th>
                <th style="border:1px solid #000; padding:5px;">Appraisal Code</th>
                <th style="border:1px solid #000; padding:5px;">Employee Name</th>
                <th style="border:1px solid #000; padding:5px;">Status</th>
                <th style="border:1px solid #000; padding:5px;">Second Supervisor</th>
                <th style="border:1px solid #000; padding:5px;">Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingSecondList as $index => $employee)
                <tr style="{{ $index % 2 == 0 ? 'background-color: #dbf1ff;' : '' }}">
                    <td style="border:1px solid #000; padding:5px;">{{ $index + 1 }}</td>
                    <td style="border:1px solid #000; padding:5px;">{{ $employee['code'] }}</td>
                    <td style="border:1px solid #000; padding:5px;">{{ $employee['name'] }}</td>
                    <td style="border:1px solid #000; padding:5px;">{!! $employee['status'] !!}</td>
                    <td style="border:1px solid #000; padding:5px;">{{ $employee['second_supervisor'] }}</td>
                    <td style="border:1px solid #000; padding:5px;">
                        <a href="{{ $employee['link'] }}" target="_blank" style="color: blue; text-decoration: underline;">
                            Click to View Appraisal
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

    @if(count($pendingAcceptanceList))
    <h4 style="font-size:16px; font-weight:bold; margin: 20px 0 10px 0;">
        Pending Employee Acceptances ({{ count($pendingAcceptanceList) }})
    </h4>

    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-bottom: 20px; border:1px solid #000; font-size:11px; line-height:14px; color:#000;">
        <thead>
            <tr style="background-color: #377297; color: #ffffff;">
                <th style="border:1px solid #000; padding:5px;">#</th>
                <th style="border:1px solid #000; padding:5px;">Appraisal Code</th>
                <th style="border:1px solid #000; padding:5px;">Employee Name</th>
                <th style="border:1px solid #000; padding:5px;">Status</th>
                <th style="border:1px solid #000; padding:5px;">Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingAcceptanceList as $index => $employee)
                <tr style="{{ $index % 2 == 0 ? 'background-color: #dbf1ff;' : '' }}">
                    <td style="border:1px solid #000; padding:5px;">{{ $index + 1 }}</td>
                    <td style="border:1px solid #000; padding:5px;">{{ $employee['code'] }}</td>
                    <td style="border:1px solid #000; padding:5px;">{{ $employee['name'] }}</td>
                    <td style="border:1px solid #000; padding:5px;">{!! $employee['status'] !!}</td>
                    <td style="border:1px solid #000; padding:5px;">
                        <a href="{{ $employee['link'] }}" target="_blank" style="color: blue; text-decoration: underline;">
                            Click to View Appraisal
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

    <p>
        Please take the necessary action at your earliest convenience.<br>
    </p>

    <p>Thank you for your cooperation.</p>

    <p>
        Best regards,<br>
        <strong>HRA Department</strong>
    </p>
</div>

@endif

@endif
