<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile['name'] }} - Professional Digital Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-dark: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            --border-radius: 1rem;
            --border-radius-lg: 1.5rem;
            --border-radius-xl: 2rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-primary);
            min-height: 100vh;
            color: var(--gray-800);
            overflow-x: hidden;
            position: relative;
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
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.4) 0%, transparent 50%);
            animation: backgroundFloat 20s ease-in-out infinite;
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="0.5" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="0.5" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.3" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.3" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.3" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            z-index: -1;
        }

        @keyframes backgroundFloat {
            0%, 100% { 
                transform: scale(1) rotate(0deg);
                opacity: 0.4;
            }
            33% { 
                transform: scale(1.1) rotate(2deg);
                opacity: 0.6;
            }
            66% { 
                transform: scale(0.9) rotate(-1deg);
                opacity: 0.5;
            }
        }

        /* Header Actions */
        .header-actions {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }

        .action-btn {
            background: var(--white);
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-sm);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            color: var(--white);
            border-color: var(--primary);
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .action-btn.danger:hover {
            background: var(--danger);
            border-color: var(--danger);
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 6rem 1rem 2rem;
            position: relative;
        }

        /* Digital Card */
        .digital-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-2xl);
            overflow: hidden;
            position: relative;
            animation: cardEntrance 1s ease-out;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Profile Header */
        .profile-header {
            background: var(--gradient-primary);
            color: var(--white);
            padding: 4rem 2rem 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 30% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: headerFloat 15s ease-in-out infinite;
        }

        @keyframes headerFloat {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
        }

        .profile-content {
            position: relative;
            z-index: 2;
        }

        .profile-image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            animation: profilePulse 4s ease-in-out infinite;
        }

        @keyframes profilePulse {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            }
            50% { 
                transform: scale(1.05);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            }
        }

        .profile-image:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        }

        .status-indicator {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 24px;
            height: 24px;
            background: var(--gradient-success);
            border-radius: 50%;
            border: 3px solid var(--white);
            animation: statusPulse 2s ease-in-out infinite;
        }

        @keyframes statusPulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.2);
                opacity: 0.8;
            }
        }

        .profile-name {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: linear-gradient(45deg, var(--white), rgba(255, 255, 255, 0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: nameGlow 3s ease-in-out infinite;
        }

        @keyframes nameGlow {
            0%, 100% { text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
            50% { text-shadow: 0 4px 20px rgba(255, 255, 255, 0.3); }
        }

        .profile-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            opacity: 0.95;
            animation: slideInUp 1s ease-out 0.3s both;
        }

        .profile-company {
            font-size: 1.125rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 2.5rem;
            animation: slideInUp 1s ease-out 0.6s both;
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
            animation: slideInUp 1s ease-out 0.9s both;
        }

        .stat-item {
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 1rem;
            border-radius: var(--border-radius);
            backdrop-filter: blur(10px);
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px) scale(1.05);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
            background: linear-gradient(45deg, var(--white), rgba(255, 255, 255, 0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: countUp 2s ease-out 1.2s both;
        }

        @keyframes countUp {
            from { 
                opacity: 0; 
                transform: scale(0.5) rotateY(180deg); 
            }
            to { 
                opacity: 1; 
                transform: scale(1) rotateY(0deg); 
            }
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        /* Social Links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 3rem;
            animation: slideInUp 1s ease-out 1.5s both;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.25rem;
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
            background: var(--gradient-accent);
            transform: scale(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
        }

        .social-link:hover::before {
            transform: scale(1);
        }

        .social-link:hover {
            color: var(--white);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .social-link i {
            position: relative;
            z-index: 1;
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 3rem 2rem;
        }

        /* Section Styling */
        .section {
            margin-bottom: 3rem;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), transparent);
            margin-left: 1rem;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: var(--border-radius);
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .section-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: rotate(45deg);
            animation: iconShine 3s ease-in-out infinite;
        }

        @keyframes iconShine {
            0%, 100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        /* Summary */
        .summary-text {
            font-size: 1.125rem;
            color: var(--gray-600);
            line-height: 1.8;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            background: var(--gray-50);
            border-radius: var(--border-radius-lg);
            border-left: 4px solid var(--primary);
            box-shadow: var(--shadow-sm);
            position: relative;
        }

        .summary-text::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 20px;
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.3;
            font-family: serif;
        }

        /* Skills Grid */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .skill-tag {
            background: var(--white);
            color: var(--gray-700);
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            border: 2px solid var(--gray-200);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .skill-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .skill-tag:hover::before {
            left: 0;
        }

        .skill-tag:hover {
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-3px) scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        .skill-tag span {
            position: relative;
            z-index: 1;
        }

        /* Timeline Items */
        .timeline-container {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--gradient-primary);
            border-radius: 1px;
        }

        .timeline-item {
            background: var(--white);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin-left: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -3rem;
            top: 2rem;
            width: 12px;
            height: 12px;
            background: var(--primary);
            border-radius: 50%;
            border: 3px solid var(--white);
            box-shadow: var(--shadow-md);
        }

        .timeline-item:hover {
            transform: translateX(10px) translateY(-5px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .timeline-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .timeline-company {
            color: var(--primary);
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }

        .timeline-duration {
            color: var(--gray-500);
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timeline-duration::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
        }

        .timeline-description {
            color: var(--gray-600);
            line-height: 1.7;
            font-size: 1rem;
        }

        /* Contact Grid */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .contact-item {
            background: var(--white);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .contact-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.05), transparent);
            transition: left 0.6s;
        }

        .contact-item:hover::before {
            left: 100%;
        }

        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius);
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.5rem;
            box-shadow: var(--shadow-md);
            position: relative;
        }

        .contact-text {
            flex: 1;
        }

        .contact-label {
            font-size: 0.875rem;
            color: var(--gray-500);
            font-weight: 500;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-value {
            font-weight: 600;
            color: var(--gray-800);
            font-size: 1.125rem;
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .gallery-item {
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            aspect-ratio: 1;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-md);
            position: relative;
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(99, 102, 241, 0.8), rgba(139, 92, 246, 0.8));
            opacity: 0;
            transition: opacity 0.4s;
            z-index: 1;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-item:hover {
            transform: scale(1.05) rotate(2deg);
            box-shadow: var(--shadow-xl);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-actions {
                padding: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .main-container {
                padding: 5rem 0.5rem 1rem;
            }

            .profile-header {
                padding: 3rem 1rem 2rem;
            }

            .profile-name {
                font-size: 2.5rem;
            }

            .profile-stats {
                flex-direction: column;
                gap: 2rem;
            }

            .content-wrapper {
                padding: 2rem 1rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .timeline-container {
                padding-left: 1rem;
            }

            .timeline-item {
                margin-left: 1rem;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        /* Print Styles */
        @media print {
            .header-actions {
                display: none;
            }
            
            body {
                background: var(--white);
            }
            
            body::before,
            body::after {
                display: none;
            }
            
            .digital-card {
                box-shadow: none;
                border: 1px solid var(--gray-300);
            }
            
            .profile-header {
                background: var(--gray-800);
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }

        /* Loading Animation */
        .loading-animation {
            opacity: 0;
            animation: fadeInScale 0.8s ease-out forwards;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Scroll Animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scroll-animate.animate {
            opacity: 1;
            transform: translateY(0);
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

    <!-- Main Container -->
    <div class="main-container">
        <!-- Digital Card -->
        <div class="digital-card loading-animation">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-content">
                    <div class="profile-image-container">
                        <img src="{{ $profile_image }}" alt="Profile" class="profile-image" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgwIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE4MCAxODAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxODAiIGhlaWdodD0iMTgwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjkwIiBjeT0iNzAiIHI9IjI1IiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik05MCA5MEM5MCA5MCA5MCA5MCA5MCA5MEM5MCA5MCA5MCA5MCA5MCA5MEM5MCA5MCA5MCA5MCA5MCA5MEM5MCA5MCA5MCA5MCA5MCA5MFoiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+Cg=='">
                        <div class="status-indicator"></div>
                    </div>
                    
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
                        <div class="section scroll-animate">
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
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-code"></i>
                                </div>
                                Skills & Expertise
                            </h3>
                            <div class="skills-grid">
                                @foreach($skills as $skill)
                                    <div class="skill-tag">
                                        <span>{{ trim($skill) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Experience Section -->
                        @if(!empty($previous_roles))
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                Professional Experience
                            </h3>
                            <div class="timeline-container">
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

                        <!-- Education Section -->
                        @if(!empty($education))
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                Education
                            </h3>
                            <div class="timeline-container">
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

                        <!-- Projects Section -->
                        @if(!empty($projects))
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                                Featured Projects
                            </h3>
                            <div class="timeline-container">
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
                                                <strong>Project Link:</strong> 
                                                <a href="{{ $project['link'] }}" target="_blank" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                                    {{ $project['link'] }} <i class="fas fa-external-link-alt" style="font-size: 0.8rem; margin-left: 0.25rem;"></i>
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <!-- Contact Information -->
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-address-card"></i>
                                </div>
                                Contact Info
                            </h3>
                            
                            <div class="contact-grid">
                                @if(!empty($profile['email']))
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-text">
                                        <div class="contact-label">Email Address</div>
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
                                        <div class="contact-label">Phone Number</div>
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
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-language"></i>
                                </div>
                                Languages
                            </h3>
                            <div class="skills-grid">
                                @foreach($languages as $language)
                                    <div class="skill-tag">
                                        <span>
                                            {{ is_array($language) ? ($language['name'] ?? $language) : $language }}
                                            @if(is_array($language) && !empty($language['proficiency']))
                                                <small style="opacity: 0.7; font-size: 0.75rem;">({{ $language['proficiency'] }})</small>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Hobbies Section -->
                        @if(!empty($hobbies))
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                Interests & Hobbies
                            </h3>
                            <div class="skills-grid">
                                @foreach($hobbies as $hobby)
                                    <div class="skill-tag">
                                        <span>{{ trim($hobby) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Certifications Section -->
                        @if(!empty($certifications))
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                Certifications
                            </h3>
                            <div class="timeline-container">
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
                        </div>
                        @endif

                        <!-- Achievements Section -->
                        @if(!empty($achievements))
                        <div class="section scroll-animate">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                Achievements & Awards
                            </h3>
                            <div class="timeline-container">
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
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Gallery Section -->
                @if(!empty($gallery) && count($gallery) > 1)
                <div class="section scroll-animate">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        Portfolio Gallery
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
    </div>

    <!-- Quick Edit Modal -->
    @include('hr.employees.digital-card.quick-edit-modal')
    
    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out-cubic',
            once: true,
            mirror: false,
            offset: 100
        });

        // Set current employee ID for quick edit
        window.currentEmployeeId = {{ $employee->id }};
        
        // Scroll animations
        function initScrollAnimations() {
            const elements = document.querySelectorAll('.scroll-animate');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            elements.forEach(element => {
                observer.observe(element);
            });
        }

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
                top: 80px;
                right: 20px;
                background: ${type === 'error' ? 'var(--danger)' : 'var(--success)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: var(--border-radius);
                z-index: 10000;
                animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: var(--shadow-xl);
                font-weight: 500;
                max-width: 400px;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 400);
            }, 4000);
        }
        
        // Add CSS for notifications and other animations
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

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initScrollAnimations();
            
            // Add smooth scrolling for anchor links
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

            // Add parallax effect to header
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const header = document.querySelector('.profile-header');
                if (header) {
                    header.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });
        });

        // Enhanced typing effect for profile name
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
            }, 1500);
        });
    </script>
</body>
</html>