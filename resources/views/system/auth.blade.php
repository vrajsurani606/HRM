<!DOCTYPE html>
<html>
<head>
    <title>System Health Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial; background: #0a0a0a; color: #e0e0e0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .auth-box { background: #1a1a1a; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5); width: 90%; max-width: 350px; border: 1px solid #2a2a2a; }
        h2 { font-size: 16px; color: #666; margin-bottom: 25px; font-weight: normal; letter-spacing: 0.5px; }
        form { display: flex; flex-direction: column; }
        input { padding: 12px; margin-bottom: 15px; border: 1px solid #333; background: #0a0a0a; color: #e0e0e0; border-radius: 4px; font-size: 14px; }
        input:focus { outline: none; border-color: #0066cc; }
        button { padding: 12px; background: #0066cc; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px; }
        button:hover { background: #0052a3; }
        .footer { margin-top: 20px; text-align: center; font-size: 11px; color: #444; }
    </style>
</head>
<body>
    <div class="auth-box">
        <h2>SYSTEM HEALTH MONITOR</h2>
        <form method="GET">
            <input type="password" name="key" placeholder="Access Key" required autofocus>
            <button type="submit">AUTHENTICATE</button>
            @if(isset($error))
                <div style="color: #ff4444; font-size: 12px; margin-top: 10px; text-align: center;">Invalid access key</div>
            @endif
        </form>
        <div class="footer">Diagnostics Panel v2.1</div>
    </div>
</body>
</html>
