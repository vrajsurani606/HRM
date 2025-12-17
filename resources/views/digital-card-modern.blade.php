<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile['name'] }} - Digital Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --accent: #10b981;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container-fluid {
            padding: 0;
        }

        /* Header Actions */
        .header-actions {
            background: var(--card-bg);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .action-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .action-btn:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .action-btn.danger {
            background: #ef4444;
        }

        .action-btn.danger:hover {
            background: #dc2626;
        }

        /* Main Card */
        .digital-card {
            max-width: 1200px;
            margin: 2rem auto;
            background: var(--card-bg);
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .profile-content {
            position: relative;
            z-index: 1;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .profile-name {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-title {
            font-size: 1.25rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .profile-company {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 2rem;
        }

        /* Stats */
        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        /* Social Links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.2s;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        /* Content Sections */
        .content-wrapper {
            padding: 2rem;
        }

        .section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        /* Summary */
        .summary-text {
            font-size: 1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Skills */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }

        .skill-tag {
            background: var(--background);
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .skill-tag:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Timeline Items */
        .timeline-item {
            background: var(--background);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary);
            transition: all 0.2s;
        }

        .timeline-item:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow);
        }

        .timeline-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .timeline-company {
            color: var(--primary);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .timeline-duration {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .timeline-description {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Contact Info */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .contact-item {
            background: var(--background);
            border-radius: 0.75rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.2s;
        }

        .contact-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .contact-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-text {
            flex: 1;
        }

        .contact-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }

        .contact-value {
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            border-radius: 0.75rem;
            overflow: hidden;
            aspect-ratio: 1;
            transition: all 0.2s;
        }

        .gallery-item:hover {
            transform: scale(1.02);
            box-shadow: var(--shadow);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-actions {
                padding: 1rem;
                justify-content: center;
            }

            .digital-card {
                margin: 1rem;
                border-radius: 0.5rem;
            }

            .profile-header {
                padding: 2rem 1rem;
            }

            .profile-name {
                font-size: 2rem;
            }

            .profile-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .contact-grid {
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
            }
            
            .digital-card {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header Actions -->
    <div class="header-actions">
        <button onclick="window.print()" class="action-btn">
            <i class="fas fa-print"></i>
            Print Card
        </button>
        <a href="{{ route('employees.digital-card.download', $employee) }}" class="action-btn">
            <i class="fas fa-download"></i>
            Download HTML
        </a>
        <button onclick="openQuickEditModal({{ $employee->id }})" class="action-btn">
            <i class="fas fa-bolt"></i>
            Quick Edit
        </button>
        <a href="{{ route('employees.digital-card.edit', $employee) }}" class="action-btn">
            <i class="fas fa-edit"></i>
            Full Edit
        </a>
        <form method="POST" action="{{ route('employees.digital-card.destroy', $employee) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this digital card?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn danger">
                <i class="fas fa-trash"></i>
                Delete
            </button>
        </form>
    </div>

    <!-- Digital Card -->
    <div class="digital-card">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-content">
                <img src="{{ $profile_image }}" alt="Profile" class="profile-image" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9Ijc1IiBjeT0iNjAiIHI9IjIwIiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik03NSA5MEM5NSA5MCAxMTAgMTAwIDExMCAxMjBWMTUwSDQwVjEyMEM0MCAxMDAgNTUgOTAgNzUgOTBaIiBmaWxsPSIjOUNBM0FGIi8+Cjwvc3ZnPgo='">
                
                <h1 class="profile-name">{{ $profile['name'] }}</h1>
                <h2 class="profile-title">{{ $profile['position'] }}</h2>
                <p class="profile-company">{{ $profile['company'] }}</p>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $profile['experience_years'] }}+</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ count($projects) }}</span>
                        <span class="stat-label">Projects</span>
                    </div>
                    <div class="stat-item">
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
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Summary Section -->
                    @if(!empty($profile['summary']))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            About Me
                        </h3>
                        <p class="summary-text">{!! nl2br(e($profile['summary'])) !!}</p>
                    </div>
                    @endif

                    <!-- Skills Section -->
                    @if(!empty($skills))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            Skills
                        </h3>
                        <div class="skills-grid">
                            @foreach($skills as $skill)
                                <span class="skill-tag">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Experience Section -->
                    @if(!empty($previous_roles))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            Experience
                        </h3>
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
                    @endif

                    <!-- Education Section -->
                    @if(!empty($education))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            Education
                        </h3>
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
                    @endif

                    <!-- Projects Section -->
                    @if(!empty($projects))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            Projects
                        </h3>
                        @foreach($projects as $project)
                            <div class="timeline-item">
                                <h4 class="timeline-title">{{ $project['name'] ?? 'Project Name' }}</h4>
                                @if(!empty($project['technologies']))
                                    <p class="timeline-company">{{ $project['technologies'] }}</p>
                                @endif
                                @if(!empty($project['duration']))
                                    <p class="timeline-duration">{{ $project['duration'] }}</p>
                                @endif
                                @if(!empty($project['description']))
                                    <p class="timeline-description">{!! nl2br(e($project['description'])) !!}</p>
                                @endif
                                @if(!empty($project['link']))
                                    <p class="timeline-description">
                                        <strong>Link:</strong> <a href="{{ $project['link'] }}" target="_blank" style="color: var(--primary);">{{ $project['link'] }}</a>
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <!-- Contact Information -->
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-address-card"></i>
                            </div>
                            Contact
                        </h3>
                        
                        <div class="contact-grid">
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

                    <!-- Languages Section -->
                    @if(!empty($languages))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-language"></i>
                            </div>
                            Languages
                        </h3>
                        <div class="skills-grid">
                            @foreach($languages as $language)
                                <span class="skill-tag">
                                    {{ is_array($language) ? ($language['name'] ?? $language) : $language }}
                                    @if(is_array($language) && !empty($language['proficiency']))
                                        <small style="opacity: 0.7;">({{ $language['proficiency'] }})</small>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Hobbies Section -->
                    @if(!empty($hobbies))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            Hobbies
                        </h3>
                        <div class="skills-grid">
                            @foreach($hobbies as $hobby)
                                <span class="skill-tag">{{ trim($hobby) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Certifications Section -->
                    @if(!empty($certifications))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            Certifications
                        </h3>
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
                    </div>
                    @endif

                    <!-- Achievements Section -->
                    @if(!empty($achievements))
                    <div class="section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            Achievements
                        </h3>
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
                    </div>
                    @endif
                </div>
            </div>

            <!-- Gallery Section -->
            @if(!empty($gallery) && count($gallery) > 1)
            <div class="section">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    Gallery
                </h3>
                <div class="gallery-grid">
                    @foreach($gallery as $image)
                        @if(!empty($image))
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="gallery-image" onerror="this.style.display='none'">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Edit Modal -->
    @include('hr.employees.digital-card.quick-edit-modal')
    
    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        // Set current employee ID for quick edit
        window.currentEmployeeId = {{ $employee->id }};
        
        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i>
                ${message}
            `;
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'error' ? '#ef4444' : '#10b981'};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
        
        // Add CSS for notifications
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>