<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($profile['name']); ?> - Digital Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-light: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.1);
            --border-radius: 20px;
            --animation-speed: 0.6s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            color: #2d3748;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            animation: backgroundShift 20s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes backgroundShift {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(5deg); }
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
            position: relative;
        }

        /* Glass Card Effect */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-light);
            transition: all var(--animation-speed) cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.8s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .action-btn {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all var(--animation-speed) ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.3s;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Profile Header */
        .profile-header {
            text-align: center;
            padding: 4rem 2rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .profile-image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: all var(--animation-speed) ease;
            animation: profilePulse 3s ease-in-out infinite;
        }

        @keyframes profilePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .profile-image:hover {
            transform: scale(1.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .status-indicator {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            background: var(--success-gradient);
            border-radius: 50%;
            border: 3px solid white;
            animation: statusBlink 2s ease-in-out infinite;
        }

        @keyframes statusBlink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .profile-name {
            font-size: 3.5rem;
            font-weight: 900;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            animation: slideInUp 1s ease-out;
        }

        .profile-title {
            font-size: 1.8rem;
            font-weight: 600;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        .profile-company {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            animation: slideInUp 1s ease-out 0.4s both;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Profile Stats */
        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 4rem;
            margin: 3rem 0;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
            color: white;
            transition: all var(--animation-speed) ease;
            cursor: pointer;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: countUp 2s ease-out;
        }

        @keyframes countUp {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        /* Social Links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .social-link {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all var(--animation-speed) ease;
            font-size: 1.4rem;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-5px) scale(1.1);
            color: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 2rem;
            padding: 2.5rem;
            position: relative;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Skills Grid */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .skill-tag {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all var(--animation-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .skill-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.3s;
        }

        .skill-tag:hover::before {
            left: 100%;
        }

        .skill-tag:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Timeline Items */
        .timeline-item {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            transition: all var(--animation-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left 0.8s;
        }

        .timeline-item:hover::before {
            left: 100%;
        }

        .timeline-item:hover {
            transform: translateX(15px);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .timeline-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .timeline-company {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .timeline-duration {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .timeline-description {
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.7;
            font-size: 1rem;
        }

        /* Contact Information */
        .contact-info {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            color: white;
            transition: all 0.3s ease;
            padding: 0.5rem;
            border-radius: 10px;
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(10px);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            font-size: 1.2rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .contact-text {
            flex: 1;
        }

        .contact-label {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .contact-value {
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Summary Text */
        .summary-text {
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.8;
            font-size: 1.2rem;
            text-align: center;
            font-weight: 400;
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .gallery-item {
            border-radius: var(--border-radius);
            overflow: hidden;
            aspect-ratio: 1;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            transition: all var(--animation-speed) ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--animation-speed) ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .profile-name {
                font-size: 2.5rem;
            }
            
            .profile-title {
                font-size: 1.4rem;
            }
            
            .profile-stats {
                flex-direction: column;
                gap: 2rem;
            }
            
            .social-links {
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .skills-grid {
                justify-content: center;
            }
            
            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .content-section {
                padding: 1.5rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .header-actions {
                justify-content: center;
                flex-wrap: wrap;
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
            
            .glass-card {
                background: white;
                border: 1px solid #ddd;
                box-shadow: none;
            }
            
            .profile-name,
            .profile-title,
            .profile-company,
            .section-title,
            .timeline-title,
            .contact-item,
            .summary-text {
                color: black;
            }
        }

        /* Loading Animation */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* No Data State */
        .no-data {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-style: italic;
            padding: 3rem;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Actions -->
        <div class="header-actions" data-aos="fade-down">
            <button onclick="window.print()" class="action-btn">
                <i class="fas fa-print"></i>
                Print Card
            </button>
            <a href="#" onclick="downloadCard()" class="action-btn">
                <i class="fas fa-download"></i>
                Download
            </a>
            <button onclick="openQuickEditModal(<?php echo e($employee->id); ?>)" class="action-btn">
                <i class="fas fa-bolt"></i>
                Quick Edit
            </button>
            <a href="<?php echo e(route('employees.digital-card.edit', $employee)); ?>" class="action-btn">
                <i class="fas fa-edit"></i>
                Full Edit
            </a>
            <form method="POST" action="<?php echo e(route('employees.digital-card.destroy', $employee)); ?>" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this digital card?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="action-btn" style="background: rgba(239, 68, 68, 0.2);">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
            </form>
        </div>

        <!-- Profile Header -->
        <div class="glass-card profile-header fade-in" data-aos="zoom-in">
            <div class="profile-image-container">
                <img src="<?php echo e(asset($profile_image)); ?>" alt="Profile" class="profile-image">
                <div class="status-indicator"></div>
            </div>
            <h1 class="profile-name"><?php echo e($profile['name']); ?></h1>
            <h2 class="profile-title"><?php echo e($profile['position']); ?></h2>
            <p class="profile-company"><?php echo e($profile['company']); ?></p>
            
            <div class="profile-stats">
                <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                    <span class="stat-number"><?php echo e($profile['experience_years']); ?>+</span>
                    <span class="stat-label">Years Experience</span>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                    <span class="stat-number"><?php echo e(count($projects)); ?></span>
                    <span class="stat-label">Projects</span>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                    <span class="stat-number"><?php echo e(count($skills)); ?></span>
                    <span class="stat-label">Skills</span>
                </div>
            </div>

            <!-- Social Links -->
            <div class="social-links">
                <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($url)): ?>
                        <a href="<?php echo e($url); ?>" target="_blank" class="social-link" title="<?php echo e(ucfirst($platform)); ?>" data-aos="zoom-in" data-aos-delay="<?php echo e($loop->index * 100 + 400); ?>">
                            <i class="fab fa-<?php echo e($platform === 'portfolio' ? 'globe' : $platform); ?>"></i>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Summary Section -->
                <?php if(!empty($profile['summary'])): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-right">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        About Me
                    </h3>
                    <p class="summary-text"><?php echo nl2br(e($profile['summary'])); ?></p>
                </div>
                <?php endif; ?>

                <!-- Skills Section -->
                <?php if(!empty($skills)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-right" data-aos-delay="100">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        Skills
                    </h3>
                    <div class="skills-grid">
                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="skill-tag" data-aos="zoom-in" data-aos-delay="<?php echo e($loop->index * 50); ?>"><?php echo e(trim($skill)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Experience Section -->
                <?php if(!empty($previous_roles)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-right" data-aos-delay="200">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        Experience
                    </h3>
                    <?php $__currentLoopData = $previous_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                            <h4 class="timeline-title"><?php echo e($role['position'] ?? 'Position'); ?></h4>
                            <p class="timeline-company"><?php echo e($role['company'] ?? 'Company'); ?></p>
                            <p class="timeline-duration"><?php echo e($role['duration'] ?? 'Duration'); ?></p>
                            <?php if(!empty($role['description'])): ?>
                                <p class="timeline-description"><?php echo nl2br(e($role['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <!-- Education Section -->
                <?php if(!empty($education)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-right" data-aos-delay="300">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        Education
                    </h3>
                    <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                            <h4 class="timeline-title"><?php echo e($edu['degree'] ?? 'Degree'); ?></h4>
                            <p class="timeline-company"><?php echo e($edu['institution'] ?? 'Institution'); ?></p>
                            <p class="timeline-duration"><?php echo e($edu['year'] ?? 'Year'); ?></p>
                            <?php if(!empty($edu['description'])): ?>
                                <p class="timeline-description"><?php echo nl2br(e($edu['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <!-- Projects Section -->
                <?php if(!empty($projects)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-right" data-aos-delay="400">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        Projects
                    </h3>
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                            <h4 class="timeline-title"><?php echo e($project['name'] ?? 'Project Name'); ?></h4>
                            <?php if(!empty($project['technologies'])): ?>
                                <p class="timeline-company"><?php echo e($project['technologies']); ?></p>
                            <?php endif; ?>
                            <?php if(!empty($project['duration'])): ?>
                                <p class="timeline-duration"><?php echo e($project['duration']); ?></p>
                            <?php endif; ?>
                            <?php if(!empty($project['description'])): ?>
                                <p class="timeline-description"><?php echo nl2br(e($project['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <!-- Contact Information -->
                <div class="glass-card contact-info fade-in" data-aos="fade-left">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-address-card"></i>
                        </div>
                        Contact
                    </h3>
                    
                    <?php if(!empty($profile['email'])): ?>
                    <div class="contact-item" data-aos="fade-left" data-aos-delay="100">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Email</div>
                            <div class="contact-value"><?php echo e($profile['email']); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($profile['phone'])): ?>
                    <div class="contact-item" data-aos="fade-left" data-aos-delay="200">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Phone</div>
                            <div class="contact-value"><?php echo e($profile['phone']); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($profile['location'])): ?>
                    <div class="contact-item" data-aos="fade-left" data-aos-delay="300">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Location</div>
                            <div class="contact-value"><?php echo e($profile['location']); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Languages Section -->
                <?php if(!empty($languages)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-left" data-aos-delay="100">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-language"></i>
                        </div>
                        Languages
                    </h3>
                    <div class="skills-grid">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="skill-tag" data-aos="zoom-in" data-aos-delay="<?php echo e($loop->index * 50); ?>"><?php echo e(is_array($language) ? ($language['name'] ?? $language) : $language); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Hobbies Section -->
                <?php if(!empty($hobbies)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-left" data-aos-delay="200">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        Hobbies
                    </h3>
                    <div class="skills-grid">
                        <?php $__currentLoopData = $hobbies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hobby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="skill-tag" data-aos="zoom-in" data-aos-delay="<?php echo e($loop->index * 50); ?>"><?php echo e(trim($hobby)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Certifications Section -->
                <?php if(!empty($certifications)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-left" data-aos-delay="300">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        Certifications
                    </h3>
                    <?php $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                            <h4 class="timeline-title"><?php echo e($cert['name'] ?? 'Certification'); ?></h4>
                            <?php if(!empty($cert['issuer'])): ?>
                                <p class="timeline-company"><?php echo e($cert['issuer']); ?></p>
                            <?php endif; ?>
                            <?php if(!empty($cert['date'])): ?>
                                <p class="timeline-duration"><?php echo e($cert['date']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <!-- Achievements Section -->
                <?php if(!empty($achievements)): ?>
                <div class="glass-card content-section fade-in" data-aos="fade-left" data-aos-delay="400">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        Achievements
                    </h3>
                    <?php $__currentLoopData = $achievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                            <h4 class="timeline-title"><?php echo e($achievement['title'] ?? 'Achievement'); ?></h4>
                            <?php if(!empty($achievement['description'])): ?>
                                <p class="timeline-description"><?php echo nl2br(e($achievement['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Gallery Section -->
        <?php if(!empty($gallery) && count($gallery) > 1): ?>
        <div class="glass-card content-section fade-in" data-aos="fade-up">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="fas fa-images"></i>
                </div>
                Gallery
            </h3>
            <div class="gallery-grid">
                <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(file_exists(public_path('storage/' . $image))): ?>
                        <div class="gallery-item" data-aos="zoom-in" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                            <img src="<?php echo e(storage_asset('' . $image)); ?>" alt="Gallery Image" class="gallery-image">
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Quick Edit Modal -->
    <?php echo $__env->make('hr.employees.digital-card.quick-edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <script>
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Download functionality
        function downloadCard() {
            const link = document.createElement('a');
            link.href = window.location.href;
            link.download = '<?php echo e($profile['name']); ?>_Digital_Card.html';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });

        // Add interactive hover effects
        document.querySelectorAll('.glass-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add typing effect to profile name
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

        // Initialize typing effect after page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                const nameElement = document.querySelector('.profile-name');
                if (nameElement) {
                    const originalText = nameElement.textContent;
                    typeWriter(nameElement, originalText, 80);
                }
            }, 1000);
        });
        
        // Set current employee ID for quick edit
        window.currentEmployeeId = <?php echo e($employee->id); ?>;
        
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
</html><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/digital-card.blade.php ENDPATH**/ ?>