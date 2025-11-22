<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Activity Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        h1 {
            color: #003DA5;
            font-size: 18px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #003DA5;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        td {
            padding: 5px 6px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .header {
            margin-bottom: 15px;
        }
        .date {
            color: #666;
            font-size: 10px;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
        }
        .badge-created {
            background-color: #28a745;
            color: white;
        }
        .badge-updated {
            background-color: #007bff;
            color: white;
        }
        .badge-deleted {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Activity Report</h1>
        <p class="date">Generated on: {{ date('F d, Y H:i:s') }}</p>
        <p class="date">Total Activities: {{ $activities->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>User</th>
                <th>Event</th>
                <th>Model</th>
                <th>IP Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $activity->user ? $activity->user->name : 'System' }}</td>
                    <td>
                        <span class="badge badge-{{ $activity->event }}">
                            {{ ucfirst($activity->event) }}
                        </span>
                    </td>
                    <td>{{ class_basename($activity->auditable_type ?? 'Unknown') }}</td>
                    <td>{{ $activity->ip_address ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
