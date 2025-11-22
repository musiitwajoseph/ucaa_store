<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Departments Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
            font-size: 11px;
        }
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
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
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .badge-active {
            background-color: #28a745;
            color: white;
        }
        .badge-inactive {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Departments Report</h1>
        <p class="date">Generated on: {{ date('F d, Y H:i:s') }}</p>
        <p class="date">Total Departments: {{ $departments->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Department</th>
                <th>Code</th>
                <th>Users</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $dept)
                <tr>
                    <td>{{ $dept->name }}</td>
                    <td>{{ $dept->code }}</td>
                    <td>{{ $dept->users_count }}</td>
                    <td>
                        <span class="badge badge-{{ $dept->is_active ? 'active' : 'inactive' }}">
                            {{ $dept->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $dept->creator ? $dept->creator->name : '-' }}</td>
                    <td>{{ $dept->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
