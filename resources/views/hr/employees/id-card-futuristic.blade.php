<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - Futuristic ID Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --neon-blue: #00f5ff;
            --neon-purple: #bf00ff;
            --neon-green: #39ff14;
            --neon-pink: #ff073a;
            --neon-orange: #ff9500;
            
            --dark-bg: #0a0a0f;
            --card-bg: #1a1a2e;
            --glass-bg: rgba(26, 26, 46, 0.8);
            --text-primary: #ffffff;
            --text-secondary: #b8bcc8;
            --text-accent: var(--neon-blue);
            
            --glow-intensity: 0 0 20px;
            --glow-strong: 0 0 40px;
            --glow-extreme: 0 0 60px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: var(--dark-bg);
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(0, 245, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(191, 0, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(57, 255, 20, 0.05) 0%, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow-x: auto;
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
                linear-gradient(90deg, transparent 0%, rgba(0, 245, 255, 0.03) 50%, transparent 100%),
                linear-gradient(0deg, transparent 0%, rgba(191, 0, 255, 0.03) 50%, transparent 100%);
            animation: backgroundPulse 4s ease-in-out infinite alternate;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes backgroundPulse {
            0% { opacity: 0.3; }
            100% { opacity: 0.7; }
        }

        /* Floating Particles */
        .particle {
            position: fixed;
            width: 2px;
            height: 2px;
            background: var(--neon-blue);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            animation: float 6s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        .container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
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
            backdrop-filter: blur(20px);
            border: 1px solid var(--neon-blue);
            color: var(--text-primary);
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            font-family: 'Orbitron', monospace;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            box-shadow: var(--glow-intensity) var(--neon-blue);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--glow-strong) var(--neon-blue);
            background: rgba(0, 245, 255, 0.1);
            color: var(--text-primary);
            border-color: var(--neon-green);
        }

        /* Futuristic ID Card */
        .id-card-futuristic {
            width: 420px;
            height: 280px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 2px solid var(--neon-blue);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 
                var(--glow-intensity) var(--neon-blue),
                inset 0 0 20px rgba(0, 245, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: cardPulse 3s ease-in-out infinite alternate;
        }

        @keyframes cardPulse {
            0% {
                box-shadow: 
                    var(--glow-intensity) var(--neon-blue),
                    inset 0 0 20px rgba(0, 245, 255, 0.1);
            }
            100% {
                box-shadow: 
                    var(--glow-strong) var(--neon-blue),
                    inset 0 0 30px rgba(0, 245, 255, 0.2);
            }
        }

        .id-card-futuristic:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 
                var(--glow-extreme) var(--neon-blue),
                inset 0 0 40px rgba(0, 245, 255, 0.2);
            border-color: var(--neon-green);
        }

        /* Animated Border */
        .id-card-futuristic::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple), var(--neon-green), var(--neon-pink));
            border-radius: 20px;
            z-index: -1;
            animation: borderRotate 4s linear infinite;
            opacity: 0.7;
        }

        @keyframes borderRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Holographic Effect */
        .id-card-futuristic::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: holographicSweep 3s ease-in-out infinite;
        }

        @keyframes holographicSweep {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: -100%; }
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
            font-family: 'Orbitron', monospace;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--neon-blue);
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: var(--glow-intensity) var(--neon-blue);
            animation: textGlow 2s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            0% { text-shadow: var(--glow-intensity) var(--neon-blue); }
            100% { text-shadow: var(--glow-strong) var(--neon-blue); }
        }

        .card-type {
            font-family: 'Orbitron', monospace;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--neon-green);
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: var(--glow-intensity) var(--neon-green);
        }

        /* Card Body */
        .card-body {
            display: flex;
            gap: 1.5rem;
            position: relative;
            z-index: 2;
            height: calc(100% - 60px);
        }

        /* Employee Photo */
        .employee-photo {
            flex-shrink: 0;
        }

        .photo-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            border: 3px solid var(--neon-blue);
            box-shadow: 
                var(--glow-intensity) var(--neon-blue),
                inset 0 0 20px rgba(0, 245, 255, 0.2);
            animation: photoGlow 2.5s ease-in-out infinite alternate;
        }

        @keyframes photoGlow {
            0% {
                border-color: var(--neon-blue);
                box-shadow: 
                    var(--glow-intensity) var(--neon-blue),
                    inset 0 0 20px rgba(0, 245, 255, 0.2);
            }
            100% {
                border-color: var(--neon-purple);
                box-shadow: 
                    var(--glow-strong) var(--neon-purple),
                    inset 0 0 30px rgba(191, 0, 255, 0.3);
            }
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 245, 255, 0.2) 0%, rgba(26, 26, 46, 0.8) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--neon-blue);
            font-size: 2.5rem;
            text-shadow: var(--glow-intensity) var(--neon-blue);
        }

        /* Employee Info */
        .employee-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .employee-name {
            font-family: 'Orbitron', monospace;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            line-height: 1.2;
            text-shadow: var(--glow-intensity) var(--neon-blue);
            animation: nameGlow 3s ease-in-out infinite alternate;
        }

        @keyframes nameGlow {
            0% { 
                color: var(--text-primary);
                text-shadow: var(--glow-intensity) var(--neon-blue);
            }
            100% { 
                color: var(--neon-blue);
                text-shadow: var(--glow-strong) var(--neon-blue);
            }
        }

        .employee-id {
            font-family: 'Orbitron', monospace;
            font-size: 0.9rem;
            color: var(--neon-green);
            font-weight: 600;
            margin-bottom: 1rem;
            text-shadow: var(--glow-intensity) var(--neon-green);
            letter-spacing: 1px;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            color: var(--neon-blue);
            text-shadow: var(--glow-intensity) var(--neon-blue);
        }

        .detail-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle, var(--neon-blue) 0%, transparent 70%);
            border: 1px solid var(--neon-blue);
            border-radius: 50%;
            flex-shrink: 0;
            color: var(--neon-blue);
            font-size: 0.7rem;
            box-shadow: var(--glow-intensity) var(--neon-blue);
            animation: iconPulse 2s ease-in-out infinite alternate;
        }

        @keyframes iconPulse {
            0% {
                box-shadow: var(--glow-intensity) var(--neon-blue);
                border-color: var(--neon-blue);
            }
            100% {
                box-shadow: var(--glow-strong) var(--neon-green);
                border-color: var(--neon-green);
            }
        }

        .detail-text {
            font-weight: 500;
            flex: 1;
            font-family: 'Rajdhani', sans-serif;
        }

        /* QR Code */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .qr-code {
            width: 75px;
            height: 75px;
            background: var(--text-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border: 2px solid var(--neon-purple);
            box-shadow: var(--glow-intensity) var(--neon-purple);
            animation: qrGlow 2.8s ease-in-out infinite alternate;
            padding: 3px;
        }

        @keyframes qrGlow {
            0% {
                border-color: var(--neon-purple);
                box-shadow: var(--glow-intensity) var(--neon-purple);
            }
            100% {
                border-color: var(--neon-orange);
                box-shadow: var(--glow-strong) var(--neon-orange);
            }
        }

        .qr-code img,
        .qr-code canvas {
            width: 69px;
            height: 69px;
            border-radius: 8px;
            display: block;
        }

        .qr-placeholder {
            font-family: 'Orbitron', monospace;
            font-size: 0.7rem;
            color: var(--card-bg);
            text-align: center;
            line-height: 1.2;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .qr-label {
            font-family: 'Orbitron', monospace;
            font-size: 0.65rem;
            color: var(--neon-purple);
            text-align: center;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: var(--glow-intensity) var(--neon-purple);
        }

        /* Scan Line Animation */
        .scan-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-green), transparent);
            animation: scanLine 2s linear infinite;
        }

        @keyframes scanLine {
            0% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(280px); opacity: 0; }
        }

        /* Data Stream Effect */
        .data-stream {
            position: absolute;
            top: 0;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(0deg, transparent, var(--neon-blue), transparent);
            animation: dataStream 1.5s linear infinite;
        }

        @keyframes dataStream {
            0% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(-420px); opacity: 0; }
        }

        /* Status Indicators */
        .status-indicators {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            gap: 0.5rem;
            z-index: 3;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--neon-green);
            box-shadow: var(--glow-intensity) var(--neon-green);
            animation: statusBlink 1s ease-in-out infinite alternate;
        }

        .status-dot:nth-child(2) {
            background: var(--neon-blue);
            box-shadow: var(--glow-intensity) var(--neon-blue);
            animation-delay: 0.3s;
        }

        .status-dot:nth-child(3) {
            background: var(--neon-purple);
            box-shadow: var(--glow-intensity) var(--neon-purple);
            animation-delay: 0.6s;
        }

        @keyframes statusBlink {
            0% { opacity: 0.3; }
            100% { opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .id-card-futuristic {
                width: 100%;
                max-width: 420px;
                height: auto;
                min-height: 280px;
            }
            
            .card-body {
                flex-direction: column;
                gap: 1rem;
                height: auto;
            }
            
            .employee-photo {
                align-self: center;
            }
            
            .header-actions {
                flex-direction: column;
                align-items: center;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: #000;
                padding: 0;
            }
            
            .header-actions {
                display: none;
            }
            
            .id-card-futuristic {
                box-shadow: none;
                border: 2px solid #333;
                animation: none;
            }
            
            .id-card-futuristic::before,
            .id-card-futuristic::after,
            .scan-line,
            .data-stream {
                display: none;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            animation: materializeIn 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes materializeIn {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.8);
            }
            50% {
                opacity: 0.5;
                transform: translateY(25px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>
<body>
    <!-- Floating Particles -->
    <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
    <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
    <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
    <div class="particle" style="left: 40%; animation-delay: 3s;"></div>
    <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
    <div class="particle" style="left: 60%; animation-delay: 5s;"></div>
    <div class="particle" style="left: 70%; animation-delay: 0.5s;"></div>
    <div class="particle" style="left: 80%; animation-delay: 1.5s;"></div>
    <div class="particle" style="left: 90%; animation-delay: 2.5s;"></div>

    <div class="container">
        <!-- Header Actions -->
        <div class="header-actions loading" style="animation-delay: 0.2s;">
            <button onclick="printCard()" class="action-btn">
                <i class="fas fa-print"></i>
                Print
            </button>
            <button onclick="downloadPDF()" class="action-btn">
                <i class="fas fa-download"></i>
                Export
            </button>
            <button onclick="shareCard()" class="action-btn">
                <i class="fas fa-share-alt"></i>
                Share
            </button>
            <a href="{{ route('employees.show', $employee) }}" class="action-btn">
                <i class="fas fa-arrow-left"></i>
                Return
            </a>
        </div>

        <!-- Futuristic ID Card -->
        <div class="loading" style="animation-delay: 0.5s;">
            <div class="id-card-futuristic" id="futuristicCard">
                <!-- Status Indicators -->
                <div class="status-indicators">
                    <div class="status-dot"></div>
                    <div class="status-dot"></div>
                    <div class="status-dot"></div>
                </div>

                <!-- Scan Line -->
                <div class="scan-line"></div>
                
                <!-- Data Stream -->
                <div class="data-stream"></div>

                <div class="card-header">
                    <div class="company-logo">{{ config('app.name', 'NEXUS CORP') }}</div>
                    <div class="card-type">SECURITY CLEARANCE</div>
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
                            <div class="employee-name">{{ strtoupper($employee->name) }}</div>
                            <div class="employee-id">ID: {{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>

                        <div class="employee-details">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <span class="detail-text">{{ strtoupper($employee->position ?? 'OPERATIVE') }}</span>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <span class="detail-text">{{ strtoupper($employee->department ?? 'DIVISION-7') }}</span>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span class="detail-text">{{ strtoupper($employee->email) }}</span>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span class="detail-text">{{ $employee->mobile_no ?? 'CLASSIFIED' }}</span>
                            </div>
                            @if($employee->joining_date)
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <span class="detail-text">ACTIVE: {{ \Carbon\Carbon::parse($employee->joining_date)->format('Y.m.d') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="qr-section">
                        <div class="qr-code" id="qrCodeFuturistic">
                            <div class="qr-placeholder">SCAN</div>
                        </div>
                        <div class="qr-label">VERIFY</div>
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

        // Generate QR Code
        function generateQRCode() {
            const qrContainer = document.getElementById('qrCodeFuturistic');
            const qrData = employeeData.verification_url;

            qrContainer.innerHTML = '';

            try {
                QRCode.toCanvas(qrData, {
                    width: 69,
                    height: 69,
                    margin: 0,
                    color: {
                        dark: '#0a0a0f',
                        light: '#ffffff'
                    },
                    errorCorrectionLevel: 'M'
                }, function (error, canvas) {
                    if (error) {
                        generateFallbackQR();
                    } else {
                        canvas.style.width = '69px';
                        canvas.style.height = '69px';
                        canvas.style.borderRadius = '8px';
                        canvas.style.display = 'block';
                        qrContainer.appendChild(canvas);
                    }
                });
            } catch (error) {
                generateFallbackQR();
            }
        }

        function generateFallbackQR() {
            const qrContainer = document.getElementById('qrCodeFuturistic');
            const qrData = employeeData.verification_url;
            
            const qrImg = document.createElement('img');
            qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=69x69&data=${encodeURIComponent(qrData)}`;
            qrImg.style.width = '69px';
            qrImg.style.height = '69px';
            qrImg.style.borderRadius = '8px';
            qrImg.style.display = 'block';
            qrImg.onerror = function() {
                qrContainer.innerHTML = `<div class="qr-placeholder">SCAN</div>`;
            };
            
            qrContainer.appendChild(qrImg);
        }

        // Print Card
        function printCard() {
            window.print();
        }

        // Download as PDF
        function downloadPDF() {
            showNotification('GENERATING EXPORT...', 'info');
            
            const { jsPDF } = window.jspdf;
            const card = document.getElementById('futuristicCard');
            
            html2canvas(card, {
                scale: 3,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#0a0a0f'
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png', 1.0);
                
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [105, 70] // Credit card size
                });
                
                pdf.addImage(imgData, 'PNG', 0, 0, 105, 70, '', 'FAST');
                
                const fileName = `${employeeData.name.replace(/\s+/g, '_')}_SECURITY_CLEARANCE.pdf`;
                pdf.save(fileName);
                
                showNotification('EXPORT COMPLETE', 'success');
            }).catch(error => {
                console.error('Export failed:', error);
                showNotification('EXPORT FAILED', 'error');
            });
        }

        // Share card
        function shareCard() {
            if (navigator.share) {
                navigator.share({
                    title: `${employeeData.name} - Security Clearance`,
                    text: `Futuristic ID Card for ${employeeData.name}`,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showNotification('LINK COPIED TO MEMORY BANK', 'success');
                });
            }
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                ${message}
            `;
            
            const colors = {
                info: '#00f5ff',
                success: '#39ff14',
                error: '#ff073a'
            };
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: rgba(26, 26, 46, 0.9);
                backdrop-filter: blur(20px);
                border: 1px solid ${colors[type]};
                color: ${colors[type]};
                padding: 1rem 1.5rem;
                border-radius: 15px;
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
                box-shadow: 0 0 20px ${colors[type]};
                font-weight: 500;
                font-family: 'Orbitron', monospace;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                max-width: 400px;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.8rem;
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
            // Generate QR code
            generateQRCode();
            
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