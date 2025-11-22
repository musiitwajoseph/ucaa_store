<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['subject'] ?? 'Workplan' }}</title>
</head>
<body>
    <p>Dear {{ $data['staff']->full_name }},</p>

    <p>{{ $data['supervisor'] }} has accepted your workplan.</p>

    @if ($data['staff']->team->count())
         
            @if($data['staff']->team->count() > 1)
               <p>The workplan has now been cascaded down to your subordinates. They can now start goal setting:<p>
            @else                
               <p>The workplan has now been cascaded down to your subordinate to start the goal setting:<p>
            @endif
            
        <ul>
            @foreach ($data['staff']->team as $subordinate)
                <li>{{ $subordinate->full_name }}</li>
            @endforeach
        </ul>
    @endif

    <p>Regards,<br/>HR Team</p>
</body>
</html>
