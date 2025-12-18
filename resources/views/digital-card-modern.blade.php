<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $profile['name'] }} - Digital Card</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body {
            height: 100%;
            overflow: hidden;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-wrapper {
            width: 100%;
            max-width: 900px;
            height: calc(100vh - 40px);
            max-height: 600px;
            display: flex;
            flex-direction: column;
        }

        /* Action Buttons */
        .action-bar {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
            flex-shrink: 0;
        }
        .action-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }
        .action-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
            color: white;
        }
</style>
</head>
<body>
    <div class="card-wrapper">
        <!-- Action Bar -->
        <div class="action-bar">
            <a href="{{ route('employees.index') }}" class="action-btn"><i class="fas fa-arrow-left"></i> Back</a>
            <button onclick="window.print()" class="action-btn"><i class="fas fa-print"></i> Print</button>
            <a href="{{ route('employees.digital-card.download', $employee) }}" class="action-btn"><i class="fas fa-download"></i> Download</a>
            <button onclick="openQuickEditModal({{ $employee->id }})" class="action-btn"><i class="fas fa-edit"></i> Edit</button>
        </div>

        <!-- Main Card -->
        <div class="digital-card">
            <!-- Left Panel - Profile -->
            <div class="card-left">
                <div class="profile-section">
                    <div class="avatar-container">
                        <img src="{{ $profile_image }}" alt="{{ $profile['name'] }}" class="avatar" 
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjNjM2NmYxIi8+CjxjaXJjbGUgY3g9Ijc1IiBjeT0iNTUiIHI9IjI1IiBmaWxsPSJ3aGl0ZSIgb3BhY2l0eT0iMC44Ii8+CjxwYXRoIGQ9Ik03NSA5MEMxMDAgOTAgMTE1IDEwNSAxMTUgMTMwVjE1MEgzNVYxMzBDMzUgMTA1IDUwIDkwIDc1IDkwWiIgZmlsbD0id2hpdGUiIG9wYWNpdHk9IjAuOCIvPgo8L3N2Zz4='">
                        <div class="status-dot"></div>
                    </div>
                    <h1 class="name">{{ $profile['name'] }}</h1>
                    <p class="title">{{ $profile['position'] }}</p>
                    <p class="company"><i class="fas fa-building"></i> {{ $profile['company'] }}</p>
                </div>

                <!-- Stats -->
                <div class="stats-row">
                    <div class="stat">
                        <span class="stat-num">{{ $profile['experience_years'] ?? '0' }}+</span>
                        <span class="stat-label">Years</span>
                    </div>
                    <div class="stat">
                        <span class="stat-num">{{ count($projects ?? []) }}</span>
                        <span class="stat-label">Projects</span>
                    </div>
                    <div class="stat">
                        <span class="stat-num">{{ count($skills ?? []) }}</span>
                        <span class="stat-label">Skills</span>
                    </div>
                </div>

                <!-- Social Links -->
                @if(!empty($socials) && collect($socials)->filter()->count() > 0)
                <div class="social-row">
                    @foreach($socials as $platform => $url)
                        @if(!empty($url))
                        <a href="{{ $url }}" target="_blank" class="social-icon" title="{{ ucfirst($platform) }}">
                            <i class="fab fa-{{ $platform === 'portfolio' || $platform === 'website' ? 'globe' : $platform }}"></i>
                        </a>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Right Panel - Details -->
            <div class="card-right">
                <!-- Contact Info -->
                <div class="info-section">
                    <h3 class="section-title"><i class="fas fa-address-card"></i> Contact</h3>
                    <div class="contact-grid">
                        @if(!empty($profile['email']))
                        <a href="mailto:{{ $profile['email'] }}" class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $profile['email'] }}</span>
                        </a>
                        @endif
                        @if(!empty($profile['phone']))
                        <a href="tel:{{ $profile['phone'] }}" class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $profile['phone'] }}</span>
                        </a>
                        @endif
                        @if(!empty($profile['location']))
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $profile['location'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Skills -->
                @if(!empty($skills))
                <div class="info-section">
                    <h3 class="section-title"><i class="fas fa-code"></i> Skills</h3>
                    <div class="skills-wrap">
                        @foreach(array_slice($skills, 0, 8) as $skill)
                        <span class="skill-tag">{{ trim($skill) }}</span>
                        @endforeach
                        @if(count($skills) > 8)
                        <span class="skill-tag more">+{{ count($skills) - 8 }}</span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- About -->
                @if(!empty($profile['summary']))
                <div class="info-section">
                    <h3 class="section-title"><i class="fas fa-user"></i> About</h3>
                    <p class="about-text">{{ Str::limit($profile['summary'], 200) }}</p>
                </div>
                @endif

                <!-- Experience Preview -->
                @if(!empty($previous_roles) && count($previous_roles) > 0)
                <div class="info-section">
                    <h3 class="section-title"><i class="fas fa-briefcase"></i> Experience</h3>
                    @foreach(array_slice($previous_roles, 0, 2) as $role)
                    <div class="exp-item">
                        <strong>{{ $role['position'] ?? 'Position' }}</strong>
                        <span>{{ $role['company'] ?? '' }} {{ !empty($role['duration']) ? '• ' . $role['duration'] : '' }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Edit Modal -->
    @include('hr.employees.digital-card.quick-edit-modal')

    <style>
        /* Main Card */
        .digital-card {
            flex: 1;
            display: flex;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.1);
        }

        /* Left Panel */
        .card-left {
            width: 320px;
            flex-shrink: 0;
            background: linear-gradient(180deg, #6366f1 0%, #4f46e5 100%);
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .card-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.3; }
        }

        .profile-section {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .avatar-container {
            position: relative;
            width: 130px;
            height: 130px;
            margin: 0 auto 20px;
        }
        .avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.3);
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .status-dot {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            background: #22c55e;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(34,197,94,0.5);
        }
        .name {
            font-size: 26px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .title {
            font-size: 15px;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
            margin-bottom: 8px;
        }
        .company {
            font-size: 13px;
            color: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Stats */
        .stats-row {
            display: flex;
            gap: 20px;
            margin-top: 25px;
            position: relative;
            z-index: 1;
        }
        .stat {
            text-align: center;
            background: rgba(255,255,255,0.15);
            padding: 12px 18px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        .stat-num {
            display: block;
            font-size: 22px;
            font-weight: 700;
            color: white;
        }
        .stat-label {
            font-size: 11px;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Social */
        .social-row {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }
        .social-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        .social-icon:hover {
            background: white;
            color: #6366f1;
            transform: translateY(-3px);
        }

        /* Right Panel */
        .card-right {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background: #fafafa;
        }
        .card-right::-webkit-scrollbar { width: 4px; }
        .card-right::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

        .info-section {
            margin-bottom: 22px;
        }
        .info-section:last-child { margin-bottom: 0; }
        
        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title i {
            font-size: 14px;
        }

        /* Contact */
        .contact-grid {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: white;
            border-radius: 10px;
            text-decoration: none;
            color: #374151;
            font-size: 13px;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
        }
        .contact-item:hover {
            border-color: #6366f1;
            box-shadow: 0 4px 12px rgba(99,102,241,0.15);
        }
        .contact-item i {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .contact-item span {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Skills */
        .skills-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .skill-tag {
            background: white;
            color: #4b5563;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }
        .skill-tag:hover {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
        }
        .skill-tag.more {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
        }

        /* About */
        .about-text {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.7;
            background: white;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        /* Experience */
        .exp-item {
            background: white;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            border: 1px solid #e5e7eb;
        }
        .exp-item:last-child { margin-bottom: 0; }
        .exp-item strong {
            display: block;
            font-size: 13px;
            color: #1f2937;
            margin-bottom: 2px;
        }
        .exp-item span {
            font-size: 12px;
            color: #6b7280;
        }

        /* Responsive */
        @media (max-width: 900px) {
            body { padding: 15px; }
            .card-wrapper { max-height: none; height: auto; }
            .digital-card { flex-direction: column; height: auto; }
            .card-left { width: 100%; padding: 25px 20px; }
            .card-right { padding: 25px 20px; }
            .avatar-container { width: 100px; height: 100px; }
            .name { font-size: 22px; }
            .stats-row { gap: 12px; }
            .stat { padding: 10px 14px; }
            .stat-num { font-size: 18px; }
        }

        @media (max-width: 480px) {
            body { padding: 10px; }
            .action-bar { flex-wrap: wrap; gap: 8px; }
            .action-btn { padding: 6px 12px; font-size: 12px; }
            .card-left { padding: 20px 15px; }
            .card-right { padding: 20px 15px; }
            .avatar-container { width: 80px; height: 80px; }
            .name { font-size: 20px; }
            .title { font-size: 13px; }
            .stats-row { gap: 8px; }
            .stat { padding: 8px 12px; }
            .stat-num { font-size: 16px; }
            .stat-label { font-size: 10px; }
        }

        /* Print */
        @media print {
            body { 
                background: white; 
                padding: 0;
                height: auto;
                overflow: visible;
            }
            .action-bar { display: none; }
            .card-wrapper { 
                max-width: none; 
                max-height: none;
                height: auto;
            }
            .digital-card { 
                box-shadow: none; 
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
            .card-left::before { display: none; }
        }
    </style>

    <script>
        window.currentEmployeeId = {{ $employee->id }};
    </script>
</body>
</html>
