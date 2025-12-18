<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile['name'] }} - Creative Digital Portfolio</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --neon-blue: #00f5ff;
            --neon-purple: #bf00ff;
            --neon-green: #39ff14;
            --neon-pink: #ff073a;
            --dark-bg: #0a0a0a;
            --darker-bg: #050505;
            --card-bg: #111111;
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --text-muted: #666666;
            --border-color: #333333;
            --glow-shadow: 0 0 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Grid Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 245, 255, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 245, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: -2;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Floating Particles */
        .particle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: var(--neon-blue);
            border-radius: 50%;
            pointer-events: none;
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0; }
            50% { transform: translateY(-100px) rotate(180deg); opacity: 1; }
        }

        /* Header Actions */
        .header-actions {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            z-index: 1000;
        }

        .action-btn {
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--neon-blue), transparent);
            transition: left 0.5s;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            color: var(--neon-blue);
            border-color: var(--neon-blue);
            box-shadow: var(--glow-shadow) var(--neon-blue);
            transform: translateY(-2px);
        }

        .action-btn.danger:hover {
            color: var(--neon-pink);
            border-color: var(--neon-pink);
            box-shadow: var(--glow-shadow) var(--neon-pink);
        }

        /* Main Container */
        .main-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 5rem 1rem 2rem;
        }

        /* Digital Card */
        .digital-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            animation: cardGlow 4s ease-in-out infinite;
        }

        @keyframes cardGlow {
            0%, 100% { box-shadow: 0 0 30px rgba(0, 245, 255, 0.2); }
            50% { box-shadow: 0 0 50px rgba(191, 0, 255, 0.3); }
        }

        /* Split Layout */
        .split-layout {
            display: grid;
            grid-template-columns: 400px 1fr;
            min-height: 100vh;
        }

        /* Left Sidebar */
        .sidebar {
            background: linear-gradient(135deg, var(--darker-bg) 0%, var(--card-bg) 100%);
            padding: 3rem 2rem;
            border-right: 1px solid var(--border-color);
            position: relative;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(to bottom, var(--neon-blue), var(--neon-purple), var(--neon-green));
            animation: borderGlow 3s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* Profile Section */
        .profile-section {
            text-align: center;
            margin-bottom: 3rem;
        }

        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 20px;
            object-fit: cover;
            border: 2px solid var(--neon-blue);
            margin-bottom: 2rem;
            transition: all 0.5s ease;
            position: relative;
        }

        .profile-image:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: var(--glow-shadow) var(--neon-blue);
        }

        .profile-name {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textGlow 2s ease-in-out infinite;
        }

        @keyframes textGlow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); }
        }

        .profile-title {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            font-family: 'JetBrains Mono', monospace;
        }

        .profile-company {
            color: var(--neon-green);
            font-weight: 500;
            margin-bottom: 2rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--darker-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem 1rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 245, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            border-color: var(--neon-blue);
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--neon-blue);
            display: block;
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Social Links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--neon-blue);
            transform: scale(0);
            transition: transform 0.3s ease;
            border-radius: 12px;
        }

        .social-link:hover::before {
            transform: scale(1);
        }

        .social-link:hover {
            color: var(--dark-bg);
            border-color: var(--neon-blue);
            box-shadow: var(--glow-shadow) var(--neon-blue);
        }

        .social-link i {
            position: relative;
            z-index: 1;
        }

        /* Contact Info */
        .contact-info {
            background: var(--darker-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(0, 245, 255, 0.05);
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--neon-blue);
            color: var(--dark-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .contact-text {
            flex: 1;
        }

        .contact-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.25rem;
        }

        .contact-value {
            color: var(--text-primary);
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            padding: 3rem;
            overflow-y: auto;
        }

        /* Section */
        .section {
            margin-bottom: 4rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .section-number {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--neon-purple);
            color: var(--dark-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Summary */
        .summary-text {
            font-size: 1.125rem;
            line-height: 1.8;
            color: var(--text-secondary);
            background: var(--darker-bg);
            border: 1px solid var(--border-color);
            border-left: 4px solid var(--neon-green);
            border-radius: 16px;
            padding: 2rem;
            position: relative;
        }

        .summary-text::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 20px;
            font-size: 4rem;
            color: var(--neon-green);
            opacity: 0.3;
            font-family: serif;
        }

        /* Skills */
        .skills-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .skill-category {
            background: var(--darker-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .skill-category:hover {
            border-color: var(--neon-purple);
            transform: translateY(-5px);
        }

        .skill-category-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--neon-purple);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .skill-tag {
            background: var(--card-bg);
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .skill-tag:hover {
            background: var(--neon-blue);
            color: var(--dark-bg);
            border-color: var(--neon-blue);
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--neon-blue), var(--neon-purple), var(--neon-green));
        }

        .timeline-item {
            background: var(--darker-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            margin-left: 2rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -3rem;
            top: 2rem;
            width: 12px;
            height: 12px;
            background: var(--neon-blue);
            border-radius: 50%;
            border: 3px solid var(--dark-bg);
        }

        .timeline-item:hover {
            border-color: var(--neon-blue);
            transform: translateX(10px);
        }

        .timeline-title {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .timeline-company {
            color: var(--neon-green);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .timeline-duration {
            color: var(--text-muted);
            font-size: 0.875rem;
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 1rem;
        }

        .timeline-description {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Project Cards */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .project-card {
            background: var(--darker-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(191, 0, 255, 0.1), transparent);
            transition: left 0.6s;
        }

        .project-card:hover::before {
            left: 100%;
        }

        .project-card:hover {
            border-color: var(--neon-purple);
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(191, 0, 255, 0.2);
        }

        .project-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .project-tech {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .tech-tag {
            background: var(--neon-purple);
            color: var(--dark-bg);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .project-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .project-link {
            color: var(--neon-blue);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .project-link:hover {
            color: var(--neon-purple);
            transform: translateX(5px);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .split-layout {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }
        }

        @media (max-width: 768px) {
            .header-actions {
                padding: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .main-container {
                padding: 4rem 0.5rem 1rem;
            }

            .sidebar,
            .main-content {
                padding: 2rem 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .projects-grid {
                grid-template-columns: 1fr;
            }

            .skills-container {
                grid-template-columns: 1fr;
            }
        }

        /* Print Styles */
        @media print {
            .header-actions {
                display: none;
            }
            
            body {
                background: white;
                color: black;
            }
            
            body::before {
                display: none;
            }
            
            .digital-card {
                border: 1px solid #ccc;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Particles -->
    <div class="particle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
    <div class="particle" style="top: 60%; left: 80%; animation-delay: 2s;"></div>
    <div class="particle" style="top: 40%; left: 60%; animation-delay: 4s;"></div>
    <div class="particle" style="top: 80%; left: 30%; animation-delay: 1s;"></div>
    <div class="particle" style="top: 10%; left: 70%; animation-delay: 3s;"></div>

    <!-- Header Actions -->
    <div class="header-actions">
        <button onclick="window.print()" class="action-btn">
            <i class="fas fa-print"></i>
            Print
        </button>
        <a href="{{ route('employees.digital-card.download', $employee) }}" class="action-btn">
            <i class="fas fa-download"></i>
            Download
        </a>
        <button onclick="openQuickEditModal({{ $employee->id }})" class="action-btn">
            <i class="fas fa-bolt"></i>
            Quick Edit
        </button>
        <a href="{{ route('employees.digital-card.edit', $employee) }}" class="action-btn">
            <i class="fas fa-edit"></i>
            Edit
        </a>
        <form method="POST" action="{{ route('employees.digital-card.destroy', $employee) }}" style="display: inline;" onsubmit="return confirm('Delete this digital card?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn danger">
                <i class="fas fa-trash"></i>
                Delete
            </button>
        </form>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="digital-card">
            <div class="split-layout">
                <!-- Left Sidebar -->
                <div class="sidebar">
                    <!-- Profile Section -->
                    <div class="profile-section">
                        <img src="{{ $profile_image }}" alt="Profile" class="profile-image" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjMTExMTExIi8+CjxjaXJjbGUgY3g9IjEwMCIgY3k9IjgwIiByPSIzMCIgZmlsbD0iIzAwZjVmZiIvPgo8cGF0aCBkPSJNMTAwIDEyMEMxMzAgMTIwIDE1NSAxNDAgMTU1IDE2NVYyMDBINDVWMTY1QzQ1IDE0MCA3MCAxMjAgMTAwIDEyMFoiIGZpbGw9IiMwMGY1ZmYiLz4KPC9zdmc+Cg=='">
                        
                        <h1 class="profile-name">{{ $profile['name'] }}</h1>
                        <h2 class="profile-title">{{ $profile['position'] }}</h2>
                        <p class="profile-company">{{ $profile['company'] }}</p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <span class="stat-number">{{ $profile['experience_years'] }}+</span>
                            <span class="stat-label">Years</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">{{ count($projects) }}</span>
                            <span class="stat-label">Projects</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">{{ count($skills) }}</span>
                            <span class="stat-label">Skills</span>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="social-links">
                        @foreach($socials as $platform => $url)
                            @if(!empty($url))
                                <a href="{{ $url }}" target="_blank" class="social-link" title="{{ ucfirst($platform) }}">
                                    <i class="fab fa-{{ $platform === 'portfolio' ? 'globe' : $platform }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <!-- Contact Info -->
                    <div class="contact-info">
                        @if(!empty($profile['email']))
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <div class="contact-label">Email</div>
                                <div class="contact-value">{{ $profile['email'] }}</div>
                            </div>
                        </div>
                        @endif

                        @if(!empty($profile['phone']))
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-text">
                                <div class="contact-label">Phone</div>
                                <div class="contact-value">{{ $profile['phone'] }}</div>
                            </div>
                        </div>
                        @endif

                        @if(!empty($profile['location']))
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <div class="contact-label">Location</div>
                                <div class="contact-value">{{ $profile['location'] }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <!-- About Section -->
                    @if(!empty($profile['summary']))
                    <div class="section">
                        <div class="section-header">
                            <div class="section-number">01</div>
                            <h3 class="section-title">About</h3>
                        </div>
                        <p class="summary-text">{!! nl2br(e($profile['summary'])) !!}</p>
                    </div>
                    @endif

                    <!-- Skills Section -->
                    @if(!empty($skills))
                    <div class="section">
                        <div class="section-header">
                            <div class="section-number">02</div>
                            <h3 class="section-title">Skills & Technologies</h3>
                        </div>
                        <div class="skills-container">
                            <div class="skill-category">
                                <div class="skill-category-title">
                                    <i class="fas fa-code"></i>
                                    Technical Skills
                                </div>
                                <div class="skill-list">
                                    @foreach($skills as $skill)
                                        <span class="skill-tag">{{ trim($skill) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            
                            @if(!empty($languages))
                            <div class="skill-category">
                                <div class="skill-category-title">
                                    <i class="fas fa-language"></i>
                                    Languages
                                </div>
                                <div class="skill-list">
                                    @foreach($languages as $language)
                                        <span class="skill-tag">
                                            {{ is_array($language) ? ($language['name'] ?? $language) : $language }}
                                            @if(is_array($language) && !empty($language['proficiency']))
                                                ({{ $language['proficiency'] }})
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(!empty($hobbies))
                            <div class="skill-category">
                                <div class="skill-category-title">
                                    <i class="fas fa-heart"></i>
                                    Interests
                                </div>
                                <div class="skill-list">
                                    @foreach($hobbies as $hobby)
                                        <span class="skill-tag">{{ trim($hobby) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Experience Section -->
                    @if(!empty($previous_roles))
                    <div class="section">
                        <div class="section-header">
                            <div class="section-number">03</div>
                            <h3 class="section-title">Experience</h3>
                        </div>
                        <div class="timeline">
                            @foreach($previous_roles as $role)
                                <div class="timeline-item">
                                    <h4 class="timeline-title">{{ $role['position'] ?? 'Position' }}</h4>
                                    <p class="timeline-company">{{ $role['company'] ?? 'Company' }}</p>
                                    <p class="timeline-duration">{{ $role['duration'] ?? 'Duration' }}</p>
                                    @if(!empty($role['description']))
                                        <p class="timeline-description">{!! nl2br(e($role['description'])) !!}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Projects Section -->
                    @if(!empty($projects))
                    <div class="section">
                        <div class="section-header">
                            <div class="section-number">04</div>
                            <h3 class="section-title">Featured Projects</h3>
                        </div>
                        <div class="projects-grid">
                            @foreach($projects as $project)
                                <div class="project-card">
                                    <h4 class="project-title">{{ $project['name'] ?? 'Project Name' }}</h4>
                                    @if(!empty($project['technologies']))
                                        <div class="project-tech">
                                            @foreach(explode(',', $project['technologies']) as $tech)
                                                <span class="tech-tag">{{ trim($tech) }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(!empty($project['description']))
                                        <p class="project-description">{!! nl2br(e($project['description'])) !!}</p>
                                    @endif
                                    @if(!empty($project['link']))
                                        <a href="{{ $project['link'] }}" target="_blank" class="project-link">
                                            View Project <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Education Section -->
                    @if(!empty($education))
                    <div class="section">
                        <div class="section-header">
                            <div class="section-number">05</div>
                            <h3 class="section-title">Education</h3>
                        </div>
                        <div class="timeline">
                            @foreach($education as $edu)
                                <div class="timeline-item">
                                    <h4 class="timeline-title">{{ $edu['degree'] ?? 'Degree' }}</h4>
                                    <p class="timeline-company">{{ $edu['institution'] ?? 'Institution' }}</p>
                                    <p class="timeline-duration">{{ $edu['year'] ?? 'Year' }}</p>
                                    @if(!empty($edu['description']))
                                        <p class="timeline-description">{!! nl2br(e($edu['description'])) !!}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Certifications & Achievements -->
                    @if(!empty($certifications) || !empty($achievements))
                    <div class="section">
                        <div class="section-header">
                            <div class="section-number">06</div>
                            <h3 class="section-title">Certifications & Achievements</h3>
                        </div>
                        <div class="timeline">
                            @if(!empty($certifications))
                                @foreach($certifications as $cert)
                                    <div class="timeline-item">
                                        <h4 class="timeline-title">{{ $cert['name'] ?? 'Certification' }}</h4>
                                        @if(!empty($cert['issuer']))
                                            <p class="timeline-company">{{ $cert['issuer'] }}</p>
                                        @endif
                                        @if(!empty($cert['date']))
                                            <p class="timeline-duration">{{ $cert['date'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            @if(!empty($achievements))
                                @foreach($achievements as $achievement)
                                    <div class="timeline-item">
                                        <h4 class="timeline-title">{{ $achievement['title'] ?? 'Achievement' }}</h4>
                                        @if(!empty($achievement['year']))
                                            <p class="timeline-duration">{{ $achievement['year'] }}</p>
                                        @endif
                                        @if(!empty($achievement['description']))
                                            <p class="timeline-description">{!! nl2br(e($achievement['description'])) !!}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Edit Modal -->
    @include('hr.employees.digital-card.quick-edit-modal')
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        // Set current employee ID for quick edit
        window.currentEmployeeId = {{ $employee->id }};
        
        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.innerHTML = `
                <div style="
                    position: fixed;
                    top: 80px;
                    right: 20px;
                    background: ${type === 'error' ? 'var(--neon-pink)' : 'var(--neon-green)'};
                    color: var(--dark-bg);
                    padding: 1rem 1.5rem;
                    border-radius: 12px;
                    z-index: 10000;
                    animation: slideIn 0.3s ease-out;
                    box-shadow: var(--glow-shadow) ${type === 'error' ? 'var(--neon-pink)' : 'var(--neon-green)'};
                    font-weight: 500;
                    max-width: 400px;
                ">
                    <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}" style="margin-right: 0.5rem;"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }
        
        // Add CSS for notifications
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Typing effect for name
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Initialize effects
        window.addEventListener('load', function() {
            setTimeout(() => {
                const nameElement = document.querySelector('.profile-name');
                if (nameElement) {
                    const originalText = nameElement.textContent;
                    typeWriter(nameElement, originalText, 100);
                }
            }, 1000);
        });
    </script>
</body>
</html>