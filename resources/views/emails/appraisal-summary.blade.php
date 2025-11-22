<p style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
    Dear HR Team,
</p>

<p style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
    Please find below a summary of appraisal reminders that have been sent to supervisors. This summary highlights team members whose appraisals are still pending action in the system.
    Joseph Musiitwa and Jamil Kasirivu are copied in the emails sent to each Supervisor.
</p>

<p style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
    The table below shows the number of team members per supervisor with appraisals in the following statuses:
</p>

<ul style="font-family: Arial, sans-serif; font-size: 14px; color: #000; padding-left: 20px;">
    <li><strong>Not Submitted</strong>: Appraisals that have not been started or submitted.</li>
    <li><strong>Pending</strong>: Appraisals that are awaiting supervisor approval.</li>
    <li><strong>Pending Acceptance</strong>: Appraisals that have been approved but are awaiting the employee's acceptance.</li>
    <li><strong>Pending Second</strong>: Appraisals that require final approval by a second-level supervisor.</li>
</ul>


<h2 style="font-family: Arial, sans-serif; color: #003366;">Appraisal Reminder Summary</h2>

<table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr style="background-color: #0074a6; color: #ffffff;">
            <th style="padding: 8px; text-align: left;">#</th>
            <th style="padding: 8px; text-align: left;">Name</th>
            <th style="padding: 8px; text-align: left;">Email</th>
            <th style="padding: 8px; text-align: left;">Team Count</th>
            <th style="padding: 8px; text-align: left;">Not Submitted</th>
            <th style="padding: 8px; text-align: left;">Pending</th>
            <th style="padding: 8px; text-align: left;">Pending Acceptance</th>
            <th style="padding: 8px; text-align: left;">Pending Second supervisor</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($summary as $index => $entry)
        <tr style="background-color: {{ $index % 2 === 0 ? '#ffffff' : '#dbf1ff' }}; color:black;">
            <td style="padding: 8px;">{{ $index + 1 }}</td>
            <td style="padding: 8px;">{{ $entry['name'] }}</td>
            <td style="padding: 8px;">{{ $entry['email'] }}</td>
            <td style="padding: 8px; text-align: center;">{{ $entry['team_count'] }}</td>
            <td style="padding: 8px; text-align: center;">{{ $entry['not_submitted'] }}</td>
            <td style="padding: 8px; text-align: center;">{{ $entry['pending'] }}</td>
            <td style="padding: 8px; text-align: center;">{{ $entry['pending_acceptance'] }}</td>
            <td style="padding: 8px; text-align: center;">{{ $entry['pending_second'] }}</td>
        </tr>
    @endforeach

    {{-- Total Row --}}
    <tr style="background-color: #0074a6; color: #ffffff; font-weight: bold;">
        <td colspan="3" style="padding: 8px; text-align: right;">Total</td>
        <td style="padding: 8px; text-align: center;">{{ $total['team_count'] }}</td>
        <td style="padding: 8px; text-align: center;">{{ $total['not_submitted'] }}</td>
        <td style="padding: 8px; text-align: center;">{{ $total['pending'] }}</td>
        <td style="padding: 8px; text-align: center;">{{ $total['pending_acceptance'] }}</td>
        <td style="padding: 8px; text-align: center;">{{ $total['pending_second'] }}</td>
    </tr>
</tbody>

</table>

<p style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
    Kindly follow up with the relevant supervisors to ensure that these appraisals are completed in a timely manner.
</p>

