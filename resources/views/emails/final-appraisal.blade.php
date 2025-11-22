<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['subject'] ?? 'Final Appraisal '}}</title>
</head>
<body>
    <p>Dear {{ $data['staff'] }},</p>
    <p>{{ $data['supervisor']}} has accepted and submitted your final appraisal to HR</p>
    <p>Regards,<br/>HR Team</p>
</body>
</html>
