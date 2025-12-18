<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile['name'] }} - Digital Profile</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4F46E5;
            --primary-light: #818CF8;
            --primary-dark: #3730A3;
            --secondary: #10B981;
            --accent: #F59E0B;
            --dark: #111827;
            --gray-900: #1F2937;
            --gray-800: #374151;
            --gray-700: #4B5563;
            --gray-600: #6B7280;
            --gray-500: #9CA3AF;
            --gray-400: #D1D5DB;
            --gray-300: #E5E7EB;
            --gray-200: #F3F4F6;
            --gray-100: #F9FAFB;
            --white: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-hero: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 25px -5px rgba(0,0,0,0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.25);
            --radius: 16px;
            --radius-lg: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(180deg, #F8FAFC 0%, #EEF2FF 100%);
            min-height: 100vh;
            color: var(--gray-800);
            line-height: 1.6;
        }

        /* Header Actions Bar */
        .action-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gray-200);
            padding: 12px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            z-index: 1000;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            background: var(--white);
            color: var(--gray-700);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .action-btn.danger:hover {
            background: #EF4444;
            border-color: #EF4444;
        }

        /* Main Container */
        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 80px 20px 40px;
        }

        /* Profile Card */
        .profile-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hero Section */
        .hero-section {
            background: var(--gradient-hero);
            padding: 60px 40px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            object-fit: cover;
            margin-bottom: 24px;
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .profile-name {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .profile-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: rgba(255,255,255,0.9);
            margin-bottom: 4px;
        }

        .profile-company {
            font-size: 1rem;
            color: rgba(255,255,255,0.75);
            margin-bottom: 24px;
        }

        /* Stats Row */
        .stats-row {
            display: flex;
            justify-content: center;
            gap: 48px;
            margin-top: 24px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        /* Contact Strip */
        .contact-strip {
            background: var(--white);
            margin: -40px 24px 0;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 24px;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .contact-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-label {
            font-size: 0.7rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-800);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Content Area */
        .content-area {
            padding: 40px;
        }

        /* Section */
        .section {
            margin-bottom: 40px;
        }

        .section:last-child {
            margin-bottom: 0;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--gray-100);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        /* About Text */
        .about-text {
            font-size: 1rem;
            color: var(--gray-600);
            line-height: 1.8;
            padding: 20px;
            background: var(--gray-50);
            border-radius: var(--radius);
            border-left: 4px solid var(--primary);
        }

        /* Skills */
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .skill-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: var(--gray-100);
            color: var(--gray-700);
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .skill-badge:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* Experience Card */
        .experience-card {
            background: var(--gray-50);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 16px;
            border-left: 3px solid var(--primary);
            transition: all 0.2s ease;
        }

        .experience-card:hover {
            background: var(--white);
            box-shadow: var(--shadow);
            transform: translateX(4px);
        }

        .experience-card:last-child {
            margin-bottom: 0;
        }

        .exp-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .exp-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .exp-duration {
            font-size: 0.8rem;
            color: var(--gray-500);
            background: var(--gray-200);
            padding: 4px 10px;
            border-radius: 12px;
        }

        .exp-company {
            font-size: 0.95rem;
            color: var(--primary);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .exp-description {
            font-size: 0.9rem;
            color: var(--gray-600);
            line-height: 1.6;
        }

        /* Social Links */
        .social-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .social-link {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--gray-100);
            color: var(--gray-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .social-link:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        /* Languages & Certifications Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .info-card {
            background: var(--gray-50);
            border-radius: var(--radius);
            padding: 16px;
            transition: all 0.2s ease;
        }

        .info-card:hover {
            background: var(--white);
            box-shadow: var(--shadow);
        }

        .info-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 4px;
        }

        .info-card-subtitle {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        /* Footer */
        .card-footer {
            background: var(--gray-50);
            padding: 20px 40px;
            text-align: center;
            border-top: 1px solid var(--gray-200);
        }

        .footer-text {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 70px 12px 24px;
            }

            .hero-section {
                padding: 40px 20px 60px;
            }

            .profile-name {
                font-size: 1.75rem;
            }

            .stats-row {
                gap: 24px;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .contact-strip {
                margin: -30px 12px 0;
                padding: 16px;
                grid-template-columns: 1fr;
            }

            .content-area {
                padding: 24px 20px;
            }

            .action-bar {
                padding: 8px 12px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .action-btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }

        /* Print Styles */
        @media print {
            .action-bar { display: none !important; }
            
            body { 
                background: white !important; 
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .main-container { 
                padding: 0 !important; 
                max-width: 100% !important;
            }
            
            .profile-card { 
                box-shadow: none !important; 
                border: none !important;
                border-radius: 0 !important;
            }
            
            .hero-section {
                background: #4F46E5 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                padding: 30px 20px 50px !important;
            }
            
            .hero-section::before {
                display: none !important;
            }
            
            .profile-avatar {
                width: 100px !important;
                height: 100px !important;
                border: 3px solid rgba(255,255,255,0.5) !important;
            }
            
            .profile-name {
                font-size: 1.75rem !important;
                color: white !important;
            }
            
            .profile-title, .profile-company {
                color: rgba(255,255,255,0.9) !important;
            }
            
            .stats-row {
                gap: 30px !important;
            }
            
            .stat-value {
                font-size: 1.5rem !important;
                color: white !important;
            }
            
            .stat-label {
                color: rgba(255,255,255,0.8) !important;
            }
            
            .contact-strip {
                margin: -25px 15px 0 !important;
                padding: 15px !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
                border: 1px solid #e5e7eb !important;
            }
            
            .contact-icon {
                background: #4F46E5 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                width: 36px !important;
                height: 36px !important;
            }
            
            .content-area {
                padding: 25px 20px !important;
            }
            
            .section {
                margin-bottom: 25px !important;
                page-break-inside: avoid;
            }
            
            .section-icon {
                background: #EEF2FF !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .section-title {
                font-size: 1.1rem !important;
            }
            
            .about-text {
                padding: 15px !important;
                background: #f9fafb !important;
                border-left: 3px solid #4F46E5 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .skill-badge {
                background: #f3f4f6 !important;
                padding: 6px 12px !important;
                font-size: 0.8rem !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .experience-card {
                padding: 15px !important;
                margin-bottom: 12px !important;
                background: #f9fafb !important;
                border-left: 3px solid #4F46E5 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                page-break-inside: avoid;
            }
            
            .info-card {
                background: #f9fafb !important;
                padding: 12px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .social-link {
                background: #f3f4f6 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .card-footer {
                background: #f9fafb !important;
                padding: 15px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* Hide quick edit modal on print */
            #quickEditModal {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Action Bar -->
    <div class="action-bar">
        <button onclick="window.print()" class="action-btn">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{ route('employees.digital-card.download', $employee) }}" class="action-btn">
            <i class="fas fa-download"></i> Download
        </a>
        <a href="{{ route('employees.digital-card.edit', $employee) }}" class="action-btn">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form method="POST" action="{{ route('employees.digital-card.destroy', $employee) }}" style="display:inline" onsubmit="return confirm('Delete this digital card?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn danger">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="profile-card">
            <!-- Hero Section -->
            <div class="hero-section">
                <div class="hero-content">
                    <img src="{{ $profile_image }}" alt="{{ $profile['name'] }}" class="profile-avatar" 
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjE0MCIgaGVpZ2h0PSIxNDAiIGZpbGw9IiNFNUU3RUIiLz48Y2lyY2xlIGN4PSI3MCIgY3k9IjUwIiByPSIyNSIgZmlsbD0iIzlDQTNBRiIvPjxwYXRoIGQ9Ik03MCA4NUMxMDAgODUgMTIwIDEwNSAxMjAgMTMwVjE0MEgyMFYxMzBDMjAgMTA1IDQwIDg1IDcwIDg1WiIgZmlsbD0iIzlDQTNBRiIvPjwvc3ZnPg=='">
                    
                    <h1 class="profile-name">{{ $profile['name'] }}</h1>
                    <p class="profile-title">{{ $profile['position'] }}</p>
                    <p class="profile-company">{{ $profile['company'] }}</p>

                    <div class="stats-row">
                        <div class="stat-item">
                            <div class="stat-value">{{ $profile['experience_years'] }}+</div>
                            <div class="stat-label">Years Exp</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ count($projects) }}</div>
                            <div class="stat-label">Projects</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ count($skills) }}</div>
                            <div class="stat-label">Skills</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Strip -->
            <div class="contact-strip">
                @if(!empty($profile['email']))
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div class="contact-info">
                        <div class="contact-label">Email</div>
                        <div class="contact-value">{{ $profile['email'] }}</div>
                    </div>
                </div>
                @endif

                @if(!empty($profile['phone']))
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <div class="contact-info">
                        <div class="contact-label">Phone</div>
                        <div class="contact-value">{{ $profile['phone'] }}</div>
                    </div>
                </div>
                @endif

                @if(!empty($profile['location']))
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-info">
                        <div class="contact-label">Location</div>
                        <div class="contact-value">{{ $profile['location'] }}</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content Area -->
            <div class="content-area">

                <!-- About Section -->
                @if(!empty($profile['summary']))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-user"></i></div>
                        <h2 class="section-title">About Me</h2>
                    </div>
                    <p class="about-text">{!! nl2br(e($profile['summary'])) !!}</p>
                </div>
                @endif

                <!-- Skills Section -->
                @if(!empty($skills))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-code"></i></div>
                        <h2 class="section-title">Skills & Expertise</h2>
                    </div>
                    <div class="skills-container">
                        @foreach($skills as $skill)
                            <span class="skill-badge">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Experience Section -->
                @if(!empty($previous_roles))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-briefcase"></i></div>
                        <h2 class="section-title">Professional Experience</h2>
                    </div>
                    @foreach($previous_roles as $role)
                    <div class="experience-card">
                        <div class="exp-header">
                            <span class="exp-title">{{ $role['position'] ?? 'Position' }}</span>
                            @if(!empty($role['duration']))
                            <span class="exp-duration">{{ $role['duration'] }}</span>
                            @endif
                        </div>
                        <div class="exp-company">{{ $role['company'] ?? 'Company' }}</div>
                        @if(!empty($role['description']))
                        <p class="exp-description">{!! nl2br(e($role['description'])) !!}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Education Section -->
                @if(!empty($education))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-graduation-cap"></i></div>
                        <h2 class="section-title">Education</h2>
                    </div>
                    @foreach($education as $edu)
                    <div class="experience-card">
                        <div class="exp-header">
                            <span class="exp-title">{{ $edu['degree'] ?? 'Degree' }}</span>
                            @if(!empty($edu['year']))
                            <span class="exp-duration">{{ $edu['year'] }}</span>
                            @endif
                        </div>
                        <div class="exp-company">{{ $edu['institution'] ?? 'Institution' }}</div>
                        @if(!empty($edu['description']))
                        <p class="exp-description">{!! nl2br(e($edu['description'])) !!}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Projects Section -->
                @if(!empty($projects))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-project-diagram"></i></div>
                        <h2 class="section-title">Featured Projects</h2>
                    </div>
                    @foreach($projects as $project)
                    <div class="experience-card">
                        <div class="exp-header">
                            <span class="exp-title">{{ $project['name'] ?? 'Project' }}</span>
                            @if(!empty($project['duration']))
                            <span class="exp-duration">{{ $project['duration'] }}</span>
                            @endif
                        </div>
                        @if(!empty($project['technologies']))
                        <div class="exp-company">{{ $project['technologies'] }}</div>
                        @endif
                        @if(!empty($project['description']))
                        <p class="exp-description">{!! nl2br(e($project['description'])) !!}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Certifications Section -->
                @if(!empty($certifications))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-certificate"></i></div>
                        <h2 class="section-title">Certifications</h2>
                    </div>
                    <div class="info-grid">
                        @foreach($certifications as $cert)
                        <div class="info-card">
                            <div class="info-card-title">{{ $cert['name'] ?? 'Certification' }}</div>
                            <div class="info-card-subtitle">{{ $cert['issuer'] ?? '' }} @if(!empty($cert['date'])) • {{ $cert['date'] }} @endif</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Languages Section -->
                @if(!empty($languages))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-language"></i></div>
                        <h2 class="section-title">Languages</h2>
                    </div>
                    <div class="skills-container">
                        @foreach($languages as $language)
                            <span class="skill-badge">
                                @if(is_array($language))
                                    {{ $language['name'] ?? $language }}
                                    @if(!empty($language['proficiency']))
                                        <small style="opacity:0.7;margin-left:4px">({{ $language['proficiency'] }})</small>
                                    @endif
                                @else
                                    {{ $language }}
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Achievements Section -->
                @if(!empty($achievements))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-trophy"></i></div>
                        <h2 class="section-title">Achievements & Awards</h2>
                    </div>
                    <div class="info-grid">
                        @foreach($achievements as $achievement)
                        <div class="info-card">
                            <div class="info-card-title">{{ $achievement['title'] ?? 'Achievement' }}</div>
                            @if(!empty($achievement['description']))
                            <div class="info-card-subtitle">{{ $achievement['description'] }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Hobbies Section -->
                @if(!empty($hobbies))
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-heart"></i></div>
                        <h2 class="section-title">Interests & Hobbies</h2>
                    </div>
                    <div class="skills-container">
                        @foreach($hobbies as $hobby)
                            <span class="skill-badge">{{ trim($hobby) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Social Links Section -->
                @php
                    $hasSocials = !empty($socials['linkedin']) || !empty($socials['github']) || !empty($socials['twitter']) || !empty($socials['instagram']) || !empty($socials['facebook']) || !empty($socials['portfolio']);
                @endphp
                @if($hasSocials)
                <div class="section">
                    <div class="section-header">
                        <div class="section-icon"><i class="fas fa-share-alt"></i></div>
                        <h2 class="section-title">Connect With Me</h2>
                    </div>
                    <div class="social-links">
                        @if(!empty($socials['linkedin']))
                        <a href="{{ $socials['linkedin'] }}" target="_blank" class="social-link" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                        @if(!empty($socials['github']))
                        <a href="{{ $socials['github'] }}" target="_blank" class="social-link" title="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        @endif
                        @if(!empty($socials['twitter']))
                        <a href="{{ $socials['twitter'] }}" target="_blank" class="social-link" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        @if(!empty($socials['instagram']))
                        <a href="{{ $socials['instagram'] }}" target="_blank" class="social-link" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if(!empty($socials['facebook']))
                        <a href="{{ $socials['facebook'] }}" target="_blank" class="social-link" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if(!empty($socials['portfolio']))
                        <a href="{{ $socials['portfolio'] }}" target="_blank" class="social-link" title="Portfolio">
                            <i class="fas fa-globe"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="card-footer">
                <p class="footer-text">Digital Profile Card • Generated on {{ date('F d, Y') }}</p>
            </div>
        </div>
    </div>

</body>
</html>
