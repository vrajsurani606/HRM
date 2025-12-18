<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="print-color-adjust" content="exact">
    <title>{{ $employee->name }} - Creative ID Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            --gold-gradient: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            --emerald-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --text-light: #718096;
            --white: #ffffff;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            
            --shadow-soft: 0 8px 32px rgba(31, 38, 135, 0.37);
            --shadow-hard: 0 20px 40px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 40px rgba(79, 172, 254, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
            overflow-x: auto;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            pointer-events: none;
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            align-items: center;
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .action-btn {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            box-shadow: var(--shadow-soft);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
            background: rgba(255, 255, 255, 0.35);
            color: var(--white);
        }

        /* Card Styles Container */
        .cards-showcase {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 3rem;
            max-width: 1400px;
            width: 100%;
        }

        /* Glassmorphism Card */
        .id-card-glass {
            width: 380px;
            height: 240px;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .id-card-glass:hover {
            transform: translateY(-8px) rotateX(5deg);
            box-shadow: var(--shadow-glow);
        }

        .id-card-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }

        /* Neon Card */
        .id-card-neon {
            width: 380px;
            height: 240px;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 0 20px rgba(79, 172, 254, 0.3),
                0 0 40px rgba(79, 172, 254, 0.2),
                0 0 80px rgba(79, 172, 254, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .id-card-neon:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 0 30px rgba(79, 172, 254, 0.5),
                0 0 60px rgba(79, 172, 254, 0.3),
                0 0 120px rgba(79, 172, 254, 0.2);
        }

        .id-card-neon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--accent-gradient);
            animation: neonPulse 2s ease-in-out infinite alternate;
        }

        @keyframes neonPulse {
            0% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Gradient Card */
        .id-card-gradient {
            width: 380px;
            height: 240px;
            background: var(--primary-gradient);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-hard);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .id-card-gradient:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .id-card-gradient::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        /* Minimalist Card */
        .id-card-minimal {
            width: 380px;
            height: 240px;
            background: var(--white);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f0f0f0;
        }

        .id-card-minimal:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .id-card-minimal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-gradient);
        }

        /* Card Header */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .company-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .id-card-minimal .company-logo {
            color: var(--text-primary);
        }

        .card-type {
            font-size: 0.75rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .id-card-minimal .card-type {
            color: var(--text-light);
        }

        /* Card Body */
        .card-body {
            display: flex;
            gap: 1.2rem;
            position: relative;
            z-index: 2;
            height: calc(100% - 60px);
            align-items: flex-start;
        }

        /* Employee Photo */
        .employee-photo {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }

        .id-card-minimal .photo-container {
            border: 3px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background: #f7fafc;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.8rem;
        }

        .id-card-minimal .photo-placeholder {
            background: #f7fafc;
            color: var(--text-light);
        }

        /* Employee Info */
        .employee-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0; /* Allow text to wrap */
        }

        .employee-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 0.25rem;
            line-height: 1.2;
            word-wrap: break-word;
        }

        .id-card-minimal .employee-name {
            color: var(--text-primary);
        }

        .employee-id {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .id-card-minimal .employee-id {
            color: var(--text-secondary);
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .id-card-minimal .detail-item {
            color: var(--text-secondary);
        }

        .detail-icon {
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .id-card-minimal .detail-icon {
            background: #e2e8f0;
            color: var(--text-secondary);
        }

        .detail-text {
            font-weight: 500;
            flex: 1;
        }

        /* QR Code */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            flex-shrink: 0;
        }

        .qr-code {
            width: 65px;
            height: 65px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            padding: 3px;
        }

        .qr-code img,
        .qr-code canvas {
            width: 59px;
            height: 59px;
            border-radius: 6px;
            display: block;
        }

        .qr-placeholder {
            font-size: 0.7rem;
            color: var(--text-secondary);
            text-align: center;
            line-height: 1.2;
            font-weight: 600;
        }

        .qr-label {
            font-size: 0.6rem;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .id-card-minimal .qr-label {
            color: var(--text-light);
        }

        /* Card Decorations */
        .card-decoration {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            top: -50px;
            right: -50px;
            pointer-events: none;
        }

        .card-decoration-2 {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            bottom: -30px;
            left: -30px;
            pointer-events: none;
        }

        /* Card Titles */
        .card-title {
            text-align: center;
            margin-bottom: 1rem;
            color: var(--white);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cards-showcase {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .id-card-glass,
            .id-card-neon,
            .id-card-gradient,
            .id-card-minimal {
                width: 100%;
                max-width: 380px;
                margin: 0 auto;
            }
            
            .header-actions {
                flex-direction: column;
                align-items: center;
            }
        }

        /* Print Styles */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
                -webkit-filter: none !important;
                filter: none !important;
            }

            @page {
                size: A4;
                margin: 10mm;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                print-color-adjust: exact;
            }

            html {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                background: white !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .header-actions {
                display: none !important;
            }
            
            .cards-showcase {
                display: block !important;
            }
            
            .id-card-glass,
            .id-card-neon,
            .id-card-gradient,
            .id-card-minimal {
                page-break-inside: avoid !important;
                margin-bottom: 2rem !important;
                box-shadow: 0 0 10px rgba(0,0,0,0.1) !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Force gradient backgrounds to print */
            .card-header,
            .card-footer,
            .gradient-bg,
            .glass-bg,
            .neon-bg {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Actions -->
        <div class="header-actions">
            <button onclick="printCards()" class="action-btn">
                <i class="fas fa-print"></i>
                Print All Cards
            </button>
            <button onclick="downloadPDF()" class="action-btn">
                <i class="fas fa-download"></i>
                Download PDF
            </button>
            <button onclick="shareCard()" class="action-btn">
                <i class="fas fa-share-alt"></i>
                Share Card
            </button>
            <a href="{{ route('employees.show', $employee) }}" class="action-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Profile
            </a>
        </div>

        <!-- Cards Showcase -->
        <div class="cards-showcase">
            <!-- Glassmorphism Card -->
            <div class="loading" style="animation-delay: 0.1s;">
                <div class="card-title">Glassmorphism Style</div>
                <div class="id-card-glass" id="glassCard">
                    <div class="card-decoration"></div>
                    <div class="card-decoration-2"></div>
                    
                    <div class="card-header">
                        <div class="company-logo">{{ config('app.name', 'Company') }}</div>
                        <div class="card-type">Employee ID</div>
                    </div>

                    <div class="card-body">
                        <div class="employee-photo">
                            <div class="photo-container">
                                @php
                                    $photoUrl = null;
                                    // Try multiple photo sources
                                    if (!empty($employee->photo_path)) {
                                        $photoUrl = asset('storage/' . $employee->photo_path);
                                    } elseif (!empty($employee->user->profile_photo_path ?? null)) {
                                        $photoUrl = asset('storage/' . $employee->user->profile_photo_path);
                                    } elseif (!empty($employee->user->avatar ?? null)) {
                                        $photoUrl = $employee->user->avatar;
                                    }
                                    
                                    // Check if file exists
                                    if ($photoUrl && !empty($employee->photo_path) && !file_exists(public_path('storage/' . $employee->photo_path))) {
                                        $photoUrl = null;
                                    }
                                @endphp
                                
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" onerror="showPhotoPlaceholder(this)" loading="lazy">
                                @else
                                    <div class="photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="employee-info">
                            <div>
                                <div class="employee-name">{{ $employee->name }}</div>
                                <div class="employee-id">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <div class="employee-details">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-briefcase" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->position ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-envelope" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->email }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-phone" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->mobile_no ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="qr-section">
                            <div class="qr-code" id="qrCodeGlass">
                                <div class="qr-placeholder">QR</div>
                            </div>
                            <div class="qr-label">Verify</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Neon Card -->
            <div class="loading" style="animation-delay: 0.2s;">
                <div class="card-title">Neon Cyberpunk Style</div>
                <div class="id-card-neon" id="neonCard">
                    <div class="card-header">
                        <div class="company-logo">{{ config('app.name', 'Company') }}</div>
                        <div class="card-type">Employee ID</div>
                    </div>

                    <div class="card-body">
                        <div class="employee-photo">
                            <div class="photo-container">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" onerror="showPhotoPlaceholder(this)">
                                @else
                                    <div class="photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="employee-info">
                            <div>
                                <div class="employee-name">{{ $employee->name }}</div>
                                <div class="employee-id">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <div class="employee-details">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-briefcase" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->position ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-envelope" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->email }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-phone" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->mobile_no ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="qr-section">
                            <div class="qr-code" id="qrCodeNeon">
                                <div class="qr-placeholder">QR</div>
                            </div>
                            <div class="qr-label">Verify</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gradient Card -->
            <div class="loading" style="animation-delay: 0.3s;">
                <div class="card-title">Premium Gradient Style</div>
                <div class="id-card-gradient" id="gradientCard">
                    <div class="card-header">
                        <div class="company-logo">{{ config('app.name', 'Company') }}</div>
                        <div class="card-type">Employee ID</div>
                    </div>

                    <div class="card-body">
                        <div class="employee-photo">
                            <div class="photo-container">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" onerror="showPhotoPlaceholder(this)">
                                @else
                                    <div class="photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="employee-info">
                            <div>
                                <div class="employee-name">{{ $employee->name }}</div>
                                <div class="employee-id">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <div class="employee-details">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-briefcase" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->position ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-envelope" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->email }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-phone" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->mobile_no ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="qr-section">
                            <div class="qr-code" id="qrCodeGradient">
                                <div class="qr-placeholder">QR</div>
                            </div>
                            <div class="qr-label">Verify</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Minimalist Card -->
            <div class="loading" style="animation-delay: 0.4s;">
                <div class="card-title">Clean Minimalist Style</div>
                <div class="id-card-minimal" id="minimalCard">
                    <div class="card-header">
                        <div class="company-logo">{{ config('app.name', 'Company') }}</div>
                        <div class="card-type">Employee ID</div>
                    </div>

                    <div class="card-body">
                        <div class="employee-photo">
                            <div class="photo-container">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" onerror="showPhotoPlaceholder(this)">
                                @else
                                    <div class="photo-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="employee-info">
                            <div>
                                <div class="employee-name">{{ $employee->name }}</div>
                                <div class="employee-id">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <div class="employee-details">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-briefcase" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->position ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-envelope" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->email }}</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-phone" style="font-size: 0.625rem;"></i>
                                    </div>
                                    <span class="detail-text">{{ $employee->mobile_no ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="qr-section">
                            <div class="qr-code" id="qrCodeMinimal">
                                <div class="qr-placeholder">QR</div>
                            </div>
                            <div class="qr-label">Verify</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <script>
        // Employee data for QR code
        const employeeData = {
            id: {{ $employee->id }},
            code: '{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}',
            name: '{{ $employee->name }}',
            email: '{{ $employee->email }}',
            position: '{{ $employee->position ?? 'N/A' }}',
            verification_url: '{{ route('employees.id-card.show', $employee) }}'
        };

        // Generate QR Codes for all cards
        function generateQRCodes() {
            const qrContainers = ['qrCodeGlass', 'qrCodeNeon', 'qrCodeGradient', 'qrCodeMinimal'];
            const qrData = employeeData.verification_url;

            qrContainers.forEach(containerId => {
                const container = document.getElementById(containerId);
                if (container) {
                    generateQRForContainer(container, qrData);
                }
            });
        }

        function generateQRForContainer(container, qrData) {
            container.innerHTML = '';

            try {
                QRCode.toCanvas(qrData, {
                    width: 59,
                    height: 59,
                    margin: 0,
                    color: {
                        dark: '#2d3748',
                        light: '#ffffff'
                    },
                    errorCorrectionLevel: 'M'
                }, function (error, canvas) {
                    if (error) {
                        generateFallbackQR(container);
                    } else {
                        canvas.style.width = '59px';
                        canvas.style.height = '59px';
                        canvas.style.borderRadius = '6px';
                        canvas.style.display = 'block';
                        container.appendChild(canvas);
                    }
                });
            } catch (error) {
                generateFallbackQR(container);
            }
        }

        function generateFallbackQR(container) {
            const qrData = employeeData.verification_url;
            const qrImg = document.createElement('img');
            qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=59x59&data=${encodeURIComponent(qrData)}`;
            qrImg.style.width = '59px';
            qrImg.style.height = '59px';
            qrImg.style.borderRadius = '6px';
            qrImg.style.display = 'block';
            qrImg.onerror = function() {
                container.innerHTML = `<div class="qr-placeholder">${employeeData.code}</div>`;
            };
            container.appendChild(qrImg);
        }

        // Print all cards
        function printCards() {
            // Show color printing instruction
            alert('For best color printing:\n\n1. Click "More settings" in print dialog\n2. Enable "Background graphics"\n3. Set "Color" to "Color" (not Black & White)\n4. Click "Print"\n\nThis ensures all gradients and colors print correctly!');
            
            setTimeout(() => {
                window.print();
            }, 500);
        }

        // Download as PDF
        function downloadPDF() {
            showNotification('Generating PDF...', 'info');
            
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('landscape', 'mm', 'a4');
            
            const cards = document.querySelectorAll('.id-card-glass, .id-card-neon, .id-card-gradient, .id-card-minimal');
            let cardIndex = 0;
            
            function processNextCard() {
                if (cardIndex >= cards.length) {
                    const fileName = `${employeeData.name.replace(/\s+/g, '_')}_Creative_ID_Cards.pdf`;
                    pdf.save(fileName);
                    showNotification('PDF downloaded successfully!', 'success');
                    return;
                }
                
                const card = cards[cardIndex];
                html2canvas(card, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff'
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    
                    if (cardIndex > 0) {
                        pdf.addPage();
                    }
                    
                    // Add card to PDF (centered)
                    const imgWidth = 100;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;
                    const x = (297 - imgWidth) / 2; // A4 landscape width is 297mm
                    const y = (210 - imgHeight) / 2; // A4 landscape height is 210mm
                    
                    pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
                    
                    cardIndex++;
                    processNextCard();
                }).catch(error => {
                    console.error('Card processing failed:', error);
                    cardIndex++;
                    processNextCard();
                });
            }
            
            processNextCard();
        }

        // Share card
        function shareCard() {
            if (navigator.share) {
                navigator.share({
                    title: `${employeeData.name} - Employee ID Card`,
                    text: `Employee ID Card for ${employeeData.name}`,
                    url: window.location.href
                });
            } else {
                // Fallback: copy URL to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showNotification('Link copied to clipboard!', 'success');
                });
            }
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                ${message}
            `;
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'error' ? '#ef4444' : type === 'success' ? '#10b981' : '#3b82f6'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                max-width: 400px;
                backdrop-filter: blur(16px);
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        // Photo placeholder function
        function showPhotoPlaceholder(img) {
            img.parentElement.innerHTML = '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
        }

        // Add notification animations
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
            // Generate QR codes
            generateQRCodes();
            
            // Handle image loading errors
            document.addEventListener('error', function(e) {
                if (e.target.tagName === 'IMG' && e.target.closest('.photo-container')) {
                    showPhotoPlaceholder(e.target);
                }
            }, true);
        });
    </script>
</body>
</html>