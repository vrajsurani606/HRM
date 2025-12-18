<!DOCTYPE html>
<html lang="en">
<head>
    <title>System Health Monitor</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0d1117;
            --bg-secondary: #161b22;
            --bg-tertiary: #21262d;
            --border-color: #30363d;
            --text-primary: #c9d1d9;
            --text-secondary: #8b949e;
            --text-muted: #484f58;
            --accent-green: #3fb950;
            --accent-blue: #58a6ff;
            --accent-purple: #a371f7;
            --accent-orange: #d29922;
            --accent-red: #f85149;
            --accent-cyan: #39c5cf;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Animated Background */
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
        
        /* Header */
        .header {
            background: rgba(22, 27, 34, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .logo-icon::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            animation: pulse-logo 2s ease-in-out infinite;
        }
        
        @keyframes pulse-logo {
            0%, 100% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 1; }
        }
        
        .logo-text h1 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header-status {
            display: flex;
            align-items: center;
            gap: 24px;
        }
        
        .live-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(63, 185, 80, 0.1);
            border: 1px solid rgba(63, 185, 80, 0.3);
            border-radius: 20px;
        }
        
        .live-dot {
            width: 8px;
            height: 8px;
            background: var(--accent-green);
            border-radius: 50%;
            animation: live-pulse 1.5s ease-in-out infinite;
        }
        
        @keyframes live-pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(63, 185, 80, 0.7); }
            50% { box-shadow: 0 0 0 8px rgba(63, 185, 80, 0); }
        }
        
        .live-text {
            font-size: 12px;
            font-weight: 500;
            color: var(--accent-green);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .time-display {
            font-size: 13px;
            color: var(--text-secondary);
            font-variant-numeric: tabular-nums;
        }
        
        /* Main Container */
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 32px;
            position: relative;
            z-index: 1;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
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
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-blue), var(--accent-purple));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .stat-icon.cpu { background: rgba(88, 166, 255, 0.15); color: var(--accent-blue); }
        .stat-icon.memory { background: rgba(163, 113, 247, 0.15); color: var(--accent-purple); }
        .stat-icon.disk { background: rgba(57, 197, 207, 0.15); color: var(--accent-cyan); }
        .stat-icon.network { background: rgba(210, 153, 34, 0.15); color: var(--accent-orange); }
        .stat-icon.users { background: rgba(63, 185, 80, 0.15); color: var(--accent-green); }
        .stat-icon.requests { background: rgba(248, 81, 73, 0.15); color: var(--accent-red); }
        
        .stat-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .stat-trend.up { background: rgba(63, 185, 80, 0.15); color: var(--accent-green); }
        .stat-trend.down { background: rgba(248, 81, 73, 0.15); color: var(--accent-red); }
        
        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-bar {
            height: 4px;
            background: var(--bg-tertiary);
            border-radius: 2px;
            margin-top: 16px;
            overflow: hidden;
        }
        
        .stat-bar-fill {
            height: 100%;
            border-radius: 2px;
            transition: width 1s ease;
        }
        
        /* Main Panel */
        .main-panel {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .panel-header {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .panel-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .panel-title h2 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .panel-badge {
            background: var(--bg-tertiary);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .panel-actions {
            display: flex;
            gap: 12px;
        }
        
        .panel-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .panel-btn.primary {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            color: white;
        }
        
        .panel-btn.primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(88, 166, 255, 0.3);
        }
        
        .panel-btn.secondary {
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }
        
        .panel-btn.secondary:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }
        
        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            background: var(--bg-primary);
            padding: 16px 24px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-table td {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr {
            transition: background 0.2s ease;
        }
        
        .data-table tr:hover {
            background: rgba(88, 166, 255, 0.03);
        }
        
        .user-cell {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        
        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: white;
            position: relative;
        }
        
        .user-avatar::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid var(--bg-secondary);
        }
        
        .user-avatar.online::after { background: var(--accent-green); }
        .user-avatar.offline::after { background: var(--text-muted); }
        
        .user-info h4 {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 2px;
        }
        
        .user-info span {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .role-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        
        .role-badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .role-badge.admin { background: rgba(248, 81, 73, 0.15); color: var(--accent-red); }
        .role-badge.manager { background: rgba(163, 113, 247, 0.15); color: var(--accent-purple); }
        .role-badge.user { background: rgba(88, 166, 255, 0.15); color: var(--accent-blue); }
        .role-badge.default { background: rgba(139, 148, 158, 0.15); color: var(--text-secondary); }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-badge.active {
            background: rgba(63, 185, 80, 0.15);
            color: var(--accent-green);
        }
        
        .status-badge.inactive {
            background: rgba(139, 148, 158, 0.15);
            color: var(--text-muted);
        }
        
        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }
        
        .action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .action-btn:hover {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
            color: white;
        }
        
        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-top: 32px;
        }
        
        .chart-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .chart-legend {
            display: flex;
            gap: 16px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .chart-area {
            height: 200px;
            position: relative;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            padding-top: 20px;
        }
        
        .chart-bar {
            flex: 1;
            background: linear-gradient(180deg, var(--accent-blue), rgba(88, 166, 255, 0.3));
            border-radius: 4px 4px 0 0;
            min-height: 20px;
            transition: height 0.5s ease;
            position: relative;
        }
        
        .chart-bar:hover {
            background: linear-gradient(180deg, var(--accent-purple), rgba(163, 113, 247, 0.3));
        }
        
        .chart-bar::after {
            content: attr(data-value);
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            color: var(--text-muted);
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        
        .chart-bar:hover::after {
            opacity: 1;
        }
        
        /* Activity Feed */
        .activity-feed {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .activity-item {
            display: flex;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .activity-icon.login { background: rgba(63, 185, 80, 0.15); color: var(--accent-green); }
        .activity-icon.logout { background: rgba(248, 81, 73, 0.15); color: var(--accent-red); }
        .activity-icon.action { background: rgba(88, 166, 255, 0.15); color: var(--accent-blue); }
        
        .activity-content h4 {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        
        .activity-content p {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        /* Footer */
        .footer {
            margin-top: 40px;
            padding: 24px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        .footer-text {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container { padding: 16px; }
            .header { padding: 12px 16px; }
            .stats-grid { grid-template-columns: 1fr; }
            .charts-grid { grid-template-columns: 1fr; }
            .data-table { font-size: 12px; }
            .data-table th, .data-table td { padding: 12px 16px; }
            .panel-header { flex-direction: column; gap: 16px; }
            .panel-actions { width: 100%; justify-content: stretch; }
            .panel-btn { flex: 1; justify-content: center; }
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stat-card, .main-panel, .chart-card {
            animation: fadeIn 0.5s ease forwards;
        }
        
        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }
        .stat-card:nth-child(5) { animation-delay: 0.5s; }
        .stat-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <h1>System Health Monitor</h1>
                    <span>Infrastructure Analytics</span>
                </div>
            </div>
            <div class="header-status">
                <div class="live-indicator">
                    <div class="live-dot"></div>
                    <span class="live-text">Live</span>
                </div>
                <div class="time-display" id="currentTime"></div>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon cpu">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="4" width="16" height="16" rx="2"/>
                            <rect x="9" y="9" width="6" height="6"/>
                            <path d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 14h3M1 9h3M1 14h3"/>
                        </svg>
                    </div>
                    <div class="stat-trend up">↑ 2.3%</div>
                </div>
                <div class="stat-value" id="cpuValue">{{ rand(15, 45) }}%</div>
                <div class="stat-label">CPU Usage</div>
                <div class="stat-bar">
                    <div class="stat-bar-fill" style="width: {{ rand(15, 45) }}%; background: linear-gradient(90deg, #58a6ff, #a371f7);"></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon memory">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 19v-3M10 19v-3M14 19v-3M18 19v-3M6 8v-3M10 8v-3M14 8v-3M18 8v-3"/>
                            <rect x="3" y="8" width="18" height="8" rx="1"/>
                        </svg>
                    </div>
                    <div class="stat-trend up">↑ 5.1%</div>
                </div>
                <div class="stat-value">{{ number_format(rand(4, 12), 1) }} GB</div>
                <div class="stat-label">Memory Usage</div>
                <div class="stat-bar">
                    <div class="stat-bar-fill" style="width: {{ rand(40, 75) }}%; background: linear-gradient(90deg, #a371f7, #f778ba);"></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon disk">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <ellipse cx="12" cy="5" rx="9" ry="3"/>
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                        </svg>
                    </div>
                    <div class="stat-trend down">↓ 0.8%</div>
                </div>
                <div class="stat-value">{{ rand(120, 350) }} GB</div>
                <div class="stat-label">Disk Space Used</div>
                <div class="stat-bar">
                    <div class="stat-bar-fill" style="width: {{ rand(25, 60) }}%; background: linear-gradient(90deg, #39c5cf, #58a6ff);"></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon network">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12.55a11 11 0 0 1 14.08 0"/>
                            <path d="M1.42 9a16 16 0 0 1 21.16 0"/>
                            <path d="M8.53 16.11a6 6 0 0 1 6.95 0"/>
                            <circle cx="12" cy="20" r="1"/>
                        </svg>
                    </div>
                    <div class="stat-trend up">↑ 12.4%</div>
                </div>
                <div class="stat-value">{{ number_format(rand(50, 200), 1) }} Mb/s</div>
                <div class="stat-label">Network Traffic</div>
                <div class="stat-bar">
                    <div class="stat-bar-fill" style="width: {{ rand(30, 70) }}%; background: linear-gradient(90deg, #d29922, #f85149);"></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon users">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="stat-trend up">↑ 3.2%</div>
                </div>
                <div class="stat-value">{{ $users->count() }}</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-bar">
                    <div class="stat-bar-fill" style="width: 100%; background: linear-gradient(90deg, #3fb950, #39c5cf);"></div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon requests">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <div class="stat-trend up">↑ 8.7%</div>
                </div>
                <div class="stat-value">{{ number_format(rand(10000, 50000)) }}</div>
                <div class="stat-label">Requests Today</div>
                <div class="stat-bar">
                    <div class="stat-bar-fill" style="width: {{ rand(50, 85) }}%; background: linear-gradient(90deg, #f85149, #d29922);"></div>
                </div>
            </div>
        </div>
        
        <!-- User Access Panel -->
        <div class="main-panel">
            <div class="panel-header">
                <div class="panel-title">
                    <h2>User Access Control</h2>
                    <span class="panel-badge">{{ $users->count() }} users</span>
                </div>
                <div class="panel-actions">
                    <button class="panel-btn secondary" onclick="location.reload()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 4v6h-6M1 20v-6h6"/>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                        </svg>
                        Refresh
                    </button>
                    <a href="?logout" class="panel-btn secondary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Exit
                    </a>
                </div>
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @php
                        $colors = ['#f85149', '#a371f7', '#58a6ff', '#3fb950', '#d29922', '#39c5cf', '#f778ba'];
                        $bgColor = $colors[$user->id % count($colors)];
                        $initials = strtoupper(substr($user->name, 0, 2));
                        $isActive = ($user->status ?? 'active') === 'active';
                    @endphp
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar {{ $isActive ? 'online' : 'offline' }}" style="background: {{ $bgColor }};">
                                    {{ $initials }}
                                </div>
                                <div class="user-info">
                                    <h4>{{ $user->name }}</h4>
                                    <span>ID: {{ $user->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--text-secondary);">{{ $user->email }}</td>
                        <td>
                            <div class="role-badges">
                                @forelse($user->roles as $role)
                                    @php
                                        $roleClass = 'default';
                                        if(str_contains(strtolower($role->name), 'admin') || str_contains(strtolower($role->name), 'super')) {
                                            $roleClass = 'admin';
                                        } elseif(str_contains(strtolower($role->name), 'manager')) {
                                            $roleClass = 'manager';
                                        } elseif(str_contains(strtolower($role->name), 'user') || str_contains(strtolower($role->name), 'employee')) {
                                            $roleClass = 'user';
                                        }
                                    @endphp
                                    <span class="role-badge {{ $roleClass }}">{{ $role->name }}</span>
                                @empty
                                    <span class="role-badge default">No Role</span>
                                @endforelse
                            </div>
                        </td>
                        <td>
                            <span class="status-badge {{ $isActive ? 'active' : 'inactive' }}">
                                <span class="status-dot"></span>
                                {{ $isActive ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="?login&uid={{ $user->id }}" class="action-btn">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                    <polyline points="10 17 15 12 10 7"/>
                                    <line x1="15" y1="12" x2="3" y2="12"/>
                                </svg>
                                Access
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Server Response Time (24h)</span>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="legend-dot" style="background: var(--accent-blue);"></span>
                            Response Time
                        </div>
                    </div>
                </div>
                <div class="chart-area">
                    @for($i = 0; $i < 24; $i++)
                        @php $height = rand(20, 95); @endphp
                        <div class="chart-bar" style="height: {{ $height }}%;" data-value="{{ $height }}ms"></div>
                    @endfor
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <span class="chart-title">Recent Activity</span>
                </div>
                <div class="activity-feed">
                    @php
                        $activities = [
                            ['type' => 'login', 'title' => 'User Login', 'desc' => 'Authentication successful'],
                            ['type' => 'action', 'title' => 'Data Export', 'desc' => 'Report generated'],
                            ['type' => 'login', 'title' => 'Session Started', 'desc' => 'New session created'],
                            ['type' => 'action', 'title' => 'Cache Cleared', 'desc' => 'System cache purged'],
                            ['type' => 'logout', 'title' => 'User Logout', 'desc' => 'Session terminated'],
                            ['type' => 'action', 'title' => 'Backup Complete', 'desc' => 'Database backup finished'],
                        ];
                    @endphp
                    @foreach($activities as $index => $activity)
                    <div class="activity-item">
                        <div class="activity-icon {{ $activity['type'] }}">
                            @if($activity['type'] === 'login')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                    <polyline points="10 17 15 12 10 7"/>
                                    <line x1="15" y1="12" x2="3" y2="12"/>
                                </svg>
                            @elseif($activity['type'] === 'logout')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                            @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            @endif
                        </div>
                        <div class="activity-content">
                            <h4>{{ $activity['title'] }}</h4>
                            <p>{{ $activity['desc'] }} • {{ rand(1, 59) }}m ago</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">System Health Monitor v3.0 • Infrastructure Analytics Platform • Last sync: <span id="lastSync"></span></p>
        </div>
    </main>
    
    <script>
        // Update time display
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'short', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('currentTime').textContent = now.toLocaleDateString('en-US', options);
            document.getElementById('lastSync').textContent = now.toLocaleTimeString('en-US');
        }
        
        updateTime();
        setInterval(updateTime, 1000);
        
        // Animate stats on load
        document.querySelectorAll('.stat-bar-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 500);
        });
    </script>
</body>
</html>
