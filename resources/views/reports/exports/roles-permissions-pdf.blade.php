<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Roles & Permissions Report</title>
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
        h2 {
            color: #003DA5;
            font-size: 14px;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .header {
            margin-bottom: 15px;
        }
        .date {
            color: #666;
            font-size: 10px;
        }
        .role-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .role-header {
            background-color: #003DA5;
            color: white;
            padding: 8px;
            margin-bottom: 5px;
        }
        .role-details {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .permission-list {
            margin: 5px 0;
        }
        .permission {
            display: inline-block;
            background-color: #e9ecef;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 3px;
            font-size: 9px;
        }
        .stat {
            display: inline-block;
            margin-right: 15px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Roles & Permissions Report</h1>
        <p class="date">Generated on: {{ date('F d, Y H:i:s') }}</p>
        <p class="date">Total Roles: {{ $roles->count() }}</p>
    </div>

    @foreach($roles as $role)
        <div class="role-section">
            <div class="role-header">
                <strong>{{ $role->name }}</strong>
                ({{ $role->is_active ? 'Active' : 'Inactive' }})
            </div>
            <div class="role-details">
                <p><strong>Description:</strong> {{ $role->description }}</p>
                <p>
                    <span class="stat"><strong>Permissions:</strong> {{ $role->permissions_count }}</span>
                    <span class="stat"><strong>Users:</strong> {{ $role->users_count }}</span>
                </p>
                @if($role->permissions->count() > 0)
                    <p><strong>Assigned Permissions:</strong></p>
                    <div class="permission-list">
                        @foreach($role->permissions as $permission)
                            <span class="permission">{{ $permission->name }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</body>
</html>
