<!DOCTYPE html>
<html>
<head>
    <title>System Health Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial; background: #0a0a0a; color: #e0e0e0; }
        .header { background: #1a1a1a; padding: 15px 30px; border-bottom: 1px solid #2a2a2a; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 16px; color: #666; font-weight: normal; letter-spacing: 1px; }
        .logout { background: #2a2a2a; color: #888; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 12px; }
        .logout:hover { background: #333; color: #aaa; }
        .container { padding: 30px; max-width: 1400px; margin: 0 auto; }
        .panel { background: #1a1a1a; border-radius: 8px; border: 1px solid #2a2a2a; overflow: hidden; }
        .panel-header { padding: 20px; border-bottom: 1px solid #2a2a2a; }
        .panel-header h2 { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 1px; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #0a0a0a; padding: 15px 20px; text-align: left; font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; font-weight: normal; }
        td { padding: 15px 20px; border-top: 1px solid #1a1a1a; font-size: 13px; }
        tr:hover { background: #151515; }
        .role { display: inline-block; padding: 4px 10px; background: #1a2a3a; color: #5a9fd4; border-radius: 10px; font-size: 10px; margin-right: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn { background: #0066cc; color: #fff; padding: 7px 15px; border-radius: 4px; text-decoration: none; font-size: 11px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn:hover { background: #0052a3; }
        .status { display: inline-block; width: 6px; height: 6px; border-radius: 50%; margin-right: 8px; }
        .status.on { background: #00ff88; box-shadow: 0 0 8px #00ff88; }
        .status.off { background: #ff4444; }
        @media (max-width: 768px) {
            .container { padding: 15px; }
            table { font-size: 11px; }
            td, th { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SYSTEM HEALTH MONITOR</h1>
        <a href="?logout" class="logout">EXIT</a>
    </div>
    
    <div class="container">
        <div class="panel">
            <div class="panel-header">
                <h2>User Access Control</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ROLES</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="role">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <span class="status {{ $user->status === 'active' ? 'on' : 'off' }}"></span>
                            {{ ucfirst($user->status ?? 'active') }}
                        </td>
                        <td>
                            <a href="?login&uid={{ $user->id }}" class="btn">Access</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
