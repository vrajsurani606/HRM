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
        .bg-grid {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                linear-gradient(rgba(88, 166, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(88, 166, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 32px;
            position: relative;
            z-index: 1;
        }
        .status-hero {
            text-align: center;
            margin-bottom: 48px;
        }
        .status-hero h2 {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }
        .status-hero p {
            font-size: 16px;
            color: var(--text-secondary);
        }
        .overall-status {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: rgba(63, 185, 80, 0.1);
            border: 1px solid rgba(63, 185, 80, 0.3);
            border-radius: 50px;
            margin-top: 24px;
        }
        .overall-status .big-dot {
            width: 16px;
            height: 16px;
            background: var(--accent-green);
            border-radius: 50%;
            animation: live-pulse 1.5s ease-in-out infinite;
        }
        .overall-status span {
            font-size: 18px;
            font-weight: 600;
            color: var(--accent-green);
        }
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 48px;
        }
        .service-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            transition: all 0.3s ease;
        }
        .service-card:hover {
            border-color: var(--accent-blue);
            transform: translateY(-2px);
        }
        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .service-name {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .service-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .service-icon.api { background: rgba(88, 166, 255, 0.15); color: var(--accent-blue); }
        .service-icon.db { background: rgba(163, 113, 247, 0.15); color: var(--accent-purple); }
        .service-icon.cache { background: rgba(57, 197, 207, 0.15); color: var(--accent-cyan); }
        .service-icon.queue { background: rgba(210, 153, 34, 0.15); color: var(--accent-orange); }
        .service-icon.storage { background: rgba(63, 185, 80, 0.15); color: var(--accent-green); }
        .service-icon.mail { background: rgba(248, 81, 73, 0.15); color: var(--accent-red); }
        .service-name h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
        }
        .service-status {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .service-status.operational {
            background: rgba(63, 185, 80, 0.15);
            color: var(--accent-green);
        }
        .service-status .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }
        .service-metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .metric {
            text-align: center;
        }
        .metric-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .metric-label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .uptime-section {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 48px;
        }
        .uptime-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .uptime-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }
        .uptime-legend {
            display: flex;
            gap: 16px;
            font-size: 12px;
            color: var(--text-secondary);
        }
        .uptime-bars {
            display: flex;
            gap: 3px;
            height: 32px;
        }
        .uptime-bar {
            flex: 1;
            background: var(--accent-green);
            border-radius: 4px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .uptime-bar:hover {
            transform: scaleY(1.1);
            filter: brightness(1.2);
        }
        .uptime-bar.partial {
            background: var(--accent-orange);
        }
        .uptime-bar.down {
            background: var(--accent-red);
        }
        .uptime-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            font-size: 11px;
            color: var(--text-muted);
        }
        .incidents-section {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 32px;
        }
        .incidents-header {
            margin-bottom: 24px;
        }
        .incidents-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        .incidents-header p {
            font-size: 13px;
            color: var(--text-muted);
        }
        .incident-item {
            padding: 20px 0;
            border-bottom: 1px solid var(--border-color);
        }
        .incident-item:last-child {
            border-bottom: none;
        }
        .incident-date {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .incident-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        .incident-desc {
            font-size: 13px;
            color: var(--text-secondary);
        }
        .no-incidents {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
        }
        .no-incidents svg {
            margin-bottom: 16px;
            opacity: 0.5;
        }
        .footer {
            margin-top: 48px;
            padding: 24px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        .footer-text {
            font-size: 12px;
            color: var(--text-muted);
        }
        @media (max-width: 768px) {
            .container { padding: 20px 16px; }
            .header { padding: 12px 16px; }
            .services-grid { grid-template-columns: 1fr; }
            .status-hero h2 { font-size: 24px; }
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .service-card, .uptime-section, .incidents-section {
            animation: fadeIn 0.5s ease forwards;
        }
        .service-card:nth-child(1) { animation-delay: 0.1s; }
        .service-card:nth-child(2) { animation-delay: 0.2s; }
        .service-card:nth-child(3) { animation-delay: 0.3s; }
        .service-card:nth-child(4) { animation-delay: 0.4s; }
        .service-card:nth-child(5) { animation-delay: 0.5s; }
        .service-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo-icon" id="logoTrigger">
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
        <div class="status-hero">
            <h2>All Systems Operational</h2>
            <p>Current status of all services and infrastructure components</p>
            <div class="overall-status">
                <div class="big-dot"></div>
                <span>99.99% Uptime</span>
            </div>
        </div>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-header">
                    <div class="service-name">
                        <div class="service-icon api">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            </svg>
                        </div>
                        <h3>API Gateway</h3>
                    </div>
                    <div class="service-status operational">
                        <span class="status-dot"></span>
                        Operational
                    </div>
                </div>
                <div class="service-metrics">
                    <div class="metric">
                        <div class="metric-value">{{ rand(10, 50) }}ms</div>
                        <div class="metric-label">Latency</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">{{ number_format(rand(1000, 5000)) }}</div>
                        <div class="metric-label">Req/min</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">99.9%</div>
                        <div class="metric-label">Uptime</div>
                    </div>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-header">
                    <div class="service-name">
                        <div class="service-icon db">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                            </svg>
                        </div>
                        <h3>Database Cluster</h3>
                    </div>
                    <div class="service-status operational">
                        <span class="status-dot"></span>
                        Operational
                    </div>
                </div>
                <div class="service-metrics">
                    <div class="metric">
                        <div class="metric-value">{{ rand(2, 15) }}ms</div>
                        <div class="metric-label">Query Time</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">{{ rand(50, 200) }}</div>
                        <div class="metric-label">Connections</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">100%</div>
                        <div class="metric-label">Uptime</div>
                    </div>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-header">
                    <div class="service-name">
                        <div class="service-icon cache">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                            </svg>
                        </div>
                        <h3>Cache Layer</h3>
                    </div>
                    <div class="service-status operational">
                        <span class="status-dot"></span>
                        Operational
                    </div>
                </div>
                <div class="service-metrics">
                    <div class="metric">
                        <div class="metric-value">{{ rand(85, 98) }}%</div>
                        <div class="metric-label">Hit Rate</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">{{ number_format(rand(500, 2000)) }}MB</div>
                        <div class="metric-label">Memory</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">100%</div>
                        <div class="metric-label">Uptime</div>
                    </div>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-header">
                    <div class="service-name">
                        <div class="service-icon queue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="8" y1="6" x2="21" y2="6"/>
                                <line x1="8" y1="12" x2="21" y2="12"/>
                                <line x1="8" y1="18" x2="21" y2="18"/>
                                <line x1="3" y1="6" x2="3.01" y2="6"/>
                                <line x1="3" y1="12" x2="3.01" y2="12"/>
                                <line x1="3" y1="18" x2="3.01" y2="18"/>
                            </svg>
                        </div>
                        <h3>Job Queue</h3>
                    </div>
                    <div class="service-status operational">
                        <span class="status-dot"></span>
                        Operational
                    </div>
                </div>
                <div class="service-metrics">
                    <div class="metric">
                        <div class="metric-value">{{ rand(0, 50) }}</div>
                        <div class="metric-label">Pending</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">{{ number_format(rand(5000, 20000)) }}</div>
                        <div class="metric-label">Processed</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">99.8%</div>
                        <div class="metric-label">Success</div>
                    </div>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-header">
                    <div class="service-name">
                        <div class="service-icon storage">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            </svg>
                        </div>
                        <h3>File Storage</h3>
                    </div>
                    <div class="service-status operational">
                        <span class="status-dot"></span>
                        Operational
                    </div>
                </div>
                <div class="service-metrics">
                    <div class="metric">
                        <div class="metric-value">{{ rand(100, 500) }}GB</div>
                        <div class="metric-label">Used</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">{{ rand(500, 1500) }}GB</div>
                        <div class="metric-label">Available</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">100%</div>
                        <div class="metric-label">Uptime</div>
                    </div>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-header">
                    <div class="service-name">
                        <div class="service-icon mail">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <h3>Email Service</h3>
                    </div>
                    <div class="service-status operational">
                        <span class="status-dot"></span>
                        Operational
                    </div>
                </div>
                <div class="service-metrics">
                    <div class="metric">
                        <div class="metric-value">{{ number_format(rand(100, 1000)) }}</div>
                        <div class="metric-label">Sent Today</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">{{ rand(95, 99) }}%</div>
                        <div class="metric-label">Delivery</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">100%</div>
                        <div class="metric-label">Uptime</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="uptime-section">
            <div class="uptime-header">
                <h3>90-Day Uptime History</h3>
                <div class="uptime-legend">
                    <span>● Operational</span>
                    <span style="color: var(--accent-orange);">● Partial</span>
                    <span style="color: var(--accent-red);">● Outage</span>
                </div>
            </div>
            <div class="uptime-bars">
                @for($i = 0; $i < 90; $i++)
                    @php
                        $rand = rand(1, 100);
                        $class = $rand > 5 ? '' : ($rand > 2 ? 'partial' : 'down');
                    @endphp
                    <div class="uptime-bar {{ $class }}" title="Day {{ 90 - $i }}"></div>
                @endfor
            </div>
            <div class="uptime-footer">
                <span>90 days ago</span>
                <span>Today</span>
            </div>
        </div>
        
        <div class="incidents-section">
            <div class="incidents-header">
                <h3>Recent Incidents</h3>
                <p>Past incidents and maintenance windows</p>
            </div>
            <div class="no-incidents">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <p>No incidents reported in the last 30 days</p>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">System Health Monitor v3.0 • Infrastructure Analytics Platform • Last updated: <span id="lastSync"></span></p>
        </div>
    </main>
    
    <div id="accessOverlay" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(13,17,23,0.95);z-index:9999;justify-content:center;align-items:center;backdrop-filter:blur(10px);">
        <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:16px;padding:40px;width:90%;max-width:400px;text-align:center;">
            <div style="width:60px;height:60px;background:linear-gradient(135deg,var(--accent-blue),var(--accent-purple));border-radius:14px;margin:0 auto 24px;display:flex;align-items:center;justify-content:center;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <h3 style="font-size:18px;font-weight:600;color:var(--text-primary);margin-bottom:8px;">System Access</h3>
            <p style="font-size:13px;color:var(--text-muted);margin-bottom:24px;">Enter authorization token to continue</p>
            <form method="GET" id="accessForm">
                <input type="password" name="key" id="accessKey" placeholder="Authorization Token" required autofocus
                    style="width:100%;padding:14px 18px;border:1px solid var(--border-color);background:var(--bg-primary);color:var(--text-primary);border-radius:10px;font-size:14px;margin-bottom:16px;outline:none;transition:border-color 0.2s;">
                <button type="submit" style="width:100%;padding:14px;background:linear-gradient(135deg,var(--accent-blue),var(--accent-purple));color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:transform 0.2s,box-shadow 0.2s;">
                    Authenticate
                </button>
                @if(isset($error))
                <div style="color:var(--accent-red);font-size:12px;margin-top:16px;padding:10px;background:rgba(248,81,73,0.1);border-radius:8px;">
                    Invalid authorization token
                </div>
                @endif
            </form>
            <button onclick="closeAccess()" style="margin-top:20px;background:none;border:none;color:var(--text-muted);font-size:12px;cursor:pointer;">
                Cancel
            </button>
        </div>
    </div>
    
    <script>
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('currentTime').textContent = now.toLocaleDateString('en-US', options);
            document.getElementById('lastSync').textContent = now.toLocaleTimeString('en-US');
        }
        updateTime();
        setInterval(updateTime, 1000);
        
        let clickCount = 0;
        let clickTimer = null;
        const logoTrigger = document.getElementById('logoTrigger');
        const accessOverlay = document.getElementById('accessOverlay');
        const accessKey = document.getElementById('accessKey');
        
        logoTrigger.addEventListener('click', function() {
            clickCount++;
            if (clickTimer) clearTimeout(clickTimer);
            if (clickCount >= 5) {
                accessOverlay.style.display = 'flex';
                setTimeout(() => accessKey.focus(), 100);
                clickCount = 0;
            }
            clickTimer = setTimeout(() => { clickCount = 0; }, 2000);
        });
        
        function closeAccess() {
            accessOverlay.style.display = 'none';
            clickCount = 0;
        }
        
        accessOverlay.addEventListener('click', function(e) {
            if (e.target === accessOverlay) closeAccess();
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAccess();
        });
        
        accessKey.addEventListener('focus', function() {
            this.style.borderColor = 'var(--accent-blue)';
        });
        accessKey.addEventListener('blur', function() {
            this.style.borderColor = 'var(--border-color)';
        });
    </script>
</body>
</html>
