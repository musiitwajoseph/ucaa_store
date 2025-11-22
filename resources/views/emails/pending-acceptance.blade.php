<p style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
    Dear <b>{{$user->full_name}}</b>,
</p>

<p style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
    This is a reminder that your staff appraisal was approved by <b>{{$user->line_manager->full_name}}</b> and is currently pending your acceptance in the system. Kindly log in to your terminal and review the appraisal details, then proceed to accept it.
</p>

<div style="text-align: center;"> <a href="{{url('workplan/view/'.$appraisal->id)}}" style=" display: inline-block; padding: 12px 24px; background-color: #007BFF; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; font-family: Arial, sans-serif; "> Accept Appraisal </a> </div>
<p>
Your timely response is important to finalize the appraisal process for this period.
</p>

<p>
    Best regards,<br>
    <strong>HRA Department</strong>
</p>           
