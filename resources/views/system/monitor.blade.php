<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Health Monitor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0d1117;
            --bg-secondary: #161b22;
            --bg-tertiary: #21262d;
            --border-color: #30363d;
            --text-primary: #f0f6fc;
            --text-secondary: #8b949e;
            --text-muted: #6e7681;
            --accent-green: #3fb950;
            --accent-green-glow: rgba(63, 185, 80, 0.4);
            --accent-blue: #58a6ff;
            --accent-blue-glow: rgba(88, 166, 255, 0.3);
            --accent-yellow: #d29922;
            --accent-red: #f85149;
            --accent-purple: #a371f7;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .bg-grid {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(88, 166, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(88, 166, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }
        
        .container {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px var(--accent-blue-glow);
        }
        
        .logo-icon svg {
            width: 28px;
            height: 28px;
            fill: white;
        }
        
        .logo-text h1 {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 400;
        }
        
        .header-status {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .live-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(63, 185, 80, 0.1);
            border: 1px solid rgba(63, 185, 80, 0.3);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: var(--accent-green);
        }
        
        .live-dot {
            width: 8px;
            height: 8px;
            background: var(--accent-green);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 var(--accent-green-glow); }
            50% { opacity: 0.8; box-shadow: 0 0 0 8px transparent; }
        }
        
        .timestamp {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            border-color: var(--accent-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-3);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .stat-icon.green { background: rgba(63, 185, 80, 0.15); }
        .stat-icon.blue { background: rgba(88, 166, 255, 0.15); }
        .stat-icon.purple { background: rgba(163, 113, 247, 0.15); }
        .stat-icon.yellow { background: rgba(210, 153, 34, 0.15); }
        
        .stat-icon svg {
            width: 22px;
            height: 22px;
        }
        
        .stat-icon.green svg { fill: var(--accent-green); }
        .stat-icon.blue svg { fill: var(--accent-blue); }
        .stat-icon.purple svg { fill: var(--accent-purple); }
        .stat-icon.yellow svg { fill: var(--accent-yellow); }
        
        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -1px;
        }
        
        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            margin-top: 8px;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .stat-change.up {
            background: rgba(63, 185, 80, 0.15);
            color: var(--accent-green);
        }
        
        .stat-change.down {
            background: rgba(248, 81, 73, 0.15);
            color: var(--accent-red);
        }
        
        .panels-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .panel {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .panel-title {
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .panel-title svg {
            width: 18px;
            height: 18px;
            fill: var(--accent-blue);
        }
        
        .panel-badge {
            font-size: 10px;
            padding: 4px 10px;
            border-radius: 10px;
            font-weight: 500;
        }
        
        .panel-badge.healthy {
            background: rgba(63, 185, 80, 0.15);
            color: var(--accent-green);
        }
        
        .panel-badge.warning {
            background: rgba(210, 153, 34, 0.15);
            color: var(--accent-yellow);
        }
        
        .panel-content {
            padding: 24px;
        }
        
        .metric-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .metric-row:last-child {
            border-bottom: none;
        }
        
        .metric-label {
            font-size: 13px;
            color: var(--text-secondary);
        }
        
        .metric-value {
            font-size: 13px;
            font-weight: 500;
            font-family: 'SF Mono', 'Consolas', monospace;
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .status-dot.healthy {
            background: var(--accent-green);
            box-shadow: 0 0 8px var(--accent-green-glow);
        }
        
        .status-dot.warning {
            background: var(--accent-yellow);
        }
        
        .status-dot.error {
            background: var(--accent-red);
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: var(--bg-tertiary);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 8px;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.5s ease;
        }
        
        .progress-fill.green { background: var(--accent-green); }
        .progress-fill.blue { background: var(--accent-blue); }
        .progress-fill.yellow { background: var(--accent-yellow); }
        .progress-fill.red { background: var(--accent-red); }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        
        .service-card {
            background: var(--bg-tertiary);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            background: var(--border-color);
        }
        
        .service-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .service-icon svg {
            width: 20px;
            height: 20px;
        }
        
        .service-name {
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 4px;
        }
        
        .service-status {
            font-size: 11px;
            color: var(--text-muted);
        }
        
        .storage-item {
            margin-bottom: 20px;
        }
        
        .storage-item:last-child {
            margin-bottom: 0;
        }
        
        .storage-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .storage-name {
            font-size: 13px;
            font-weight: 500;
        }
        
        .storage-usage {
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .footer {
            text-align: center;
            padding: 30px;
            color: var(--text-muted);
            font-size: 12px;
        }
        
        .footer a {
            color: var(--accent-blue);
            text-decoration: none;
        }
        
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .panels-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 768px) {
            .container { padding: 20px; }
            .stats-grid { grid-template-columns: 1fr; }
            .services-grid { grid-template-columns: repeat(2, 1fr); }
            .header { flex-direction: column; gap: 20px; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    
    <div class="container">
        <header class="header">
            <div class="logo">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                <div class="logo-text">
                    <h1>System Health Monitor</h1>
                    <span>Infrastructure Diagnostics Dashboard</span>
                </div>
            </div>
            <div class="header-status">
                <div class="live-indicator">
                    <span class="live-dot"></span>
                    All Systems Operational
                </div>
                <div class="timestamp">{{ $metrics['server']['server_time'] }}</div>
            </div>
        </header>
