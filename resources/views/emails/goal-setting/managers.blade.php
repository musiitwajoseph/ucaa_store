<p style="color:#333333;">Dear <b>{{$user->fullname}}</b></p>

<p style="color:#333333; line-height:1.5;">
    Following the completion of workplan entry for your Head of Department, <b>{{$user->line_manager->fullname}}</b>, the next step in the Performance Management process is now open for you.
</p>

@if($user->team->count())
<p style="color:#333333; line-height:1.5;">
    As per the cascading principle (<strong>Heads &rarr; <span style="color:blue">Managers</span> &rarr; Seniors &rarr; Individuals</strong>), you are required to log in to the Performance Management System and enter your respective workplans. This ensures alignment of objectives across all levels of the organization.
</p>
@endif

<p style="color:#333333; margin-bottom:6px;"><strong>Action required:</strong></p>
<ul style="color:#333333; line-height:1.5;">
    <li>Access the Performance Management System using your credentials. <a href="https://pms.uetcl.com" target="_blank">https://pms.uetcl.com</a>, the system is currently only accessible through UETCL’s internal network. </li>
    <li>Review the workplans submitted by your Head of Department</li>
    <li>Enter and confirm your own workplans in line with the departmental objectives.</li>
</ul>

@if($user->team->count())
<p style="color:#333333; line-height:1.5;">
    <b>Kindly complete this step asap before 23<sup>rd</sup>-Sept-2025 to allow Seniors and Officers adequate time to align their workplans accordingly.</b>
</p>
@endif

<p style="color:#333333; line-height:1.5;">If you encounter any challenges accessing the workplans or need support with the goal-setting process, please contact the HR Performance Management Unit.</p>

<p>For any technical-related issues, kindly reach out to the IT Team.</p>

<p style="color:#333333; margin-bottom:0;">Best regards,</p>
<p style="color:#333333; margin-top:4px;">
    <strong>HRA Department</strong><br />
</p>