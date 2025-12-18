<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - Employee Verification</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .card-container {
            perspective: 1500px;
            margin-bottom: 30px;
        }

        .card-flip {
            position: relative;
            width: 100%;
            max-width: 500px;
            height: 315px;
            margin: 0 auto;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.4, 0.2, 0.2, 1);
        }

        .card-flip.flipped {
            transform: rotateY(180deg);
        }

        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .card-front {
            background: white;
        }

        .card-back {
            background: white;
            transform: rotateY(180deg);
        }

        /* Front Card Design */
        .card-header {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            padding: 20px;
            border-radius: 20px 20px 0 0;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        }

        .company-info {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .company-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }

        .company-name {
            flex: 1;
            margin-left: 15px;
        }

        .company-name h2 {
            font-size: 1.25rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .company-name p {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        .card-body {
            padding: 30px;
        }

        .employee-section {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .employee-photo {
            flex-shrink: 0;
        }

        .photo-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #2563eb;
            overflow: hidden;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            font-size: 40px;
            color: #9ca3af;
        }

        .employee-info {
            flex: 1;
        }

        .employee-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .employee-id {
            display: inline-block;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #2563eb;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 2px solid #2563eb;
            margin-bottom: 15px;
        }

        .employee-details {
            display: grid;
            gap: 10px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            color: #4b5563;
        }

        .detail-icon {
            width: 20px;
            height: 20px;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-text {
            font-weight: 500;
        }

        .verification-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }

        .verification-badge i {
            font-size: 1.25rem;
        }

        /* Back Card Design */
        .card-back .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: calc(100% - 100px);
        }

        .qr-section {
            text-align: center;
            padding: 20px;
        }

        .qr-code {
            width: 150px;
            height: 150px;
            margin: 0 auto 15px;
            border: 3px solid #2563eb;
            border-radius: 12px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .qr-code img {
            width: 90%;
            height: 90%;
            object-fit: contain;
        }

        .qr-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .back-info {
            padding: 0 30px 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-weight: 500;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
        }

        .card-footer {
            background: linear-gradient(90deg, #2563eb 0%, #0ea5e9 50%, #10b981 100%);
            height: 8px;
            border-radius: 0 0 20px 20px;
        }

        /* Flip Button */
        .flip-button {
            background: white;
            color: #2563eb;
            border: 2px solid #2563eb;
            padding: 12px 30px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .flip-button:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.3);
        }

        .flip-button i {
            transition: transform 0.3s ease;
        }

        .flip-button:hover i {
            transform: rotateY(180deg);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.5rem;
            }

            .card-flip {
                height: 280px;
            }

            .employee-section {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .employee-name {
                font-size: 1.25rem;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .header,
            .flip-button {
                display: none;
            }

            .card-flip {
                transform: none !important;
            }

            .card-face {
                position: relative;
                page-break-after: always;
            }

            .card-back {
                transform: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-shield-check"></i> Employee Verification</h1>
            <p>Verified Employee Information</p>
        </div>

        <!-- ID Card -->
        <div class="card-container">
            <div class="card-flip" id="idCard">
                <!-- Front Side -->
                <div class="card-face card-front">
                    <div class="card-header">
                        <div class="company-info">
                            <div class="company-logo">
                                @if(config('app.logo'))
                                    <img src="{{ asset(config('app.logo')) }}" alt="Logo">
                                @else
                                    <i class="fas fa-building"></i>
                                @endif
                            </div>
                            <div class="company-name">
                                <h2>{{ config('app.name', 'Company Name') }}</h2>
                                <p>EMPLOYEE IDENTIFICATION CARD</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="employee-section">
                            <div class="employee-photo">
                                <div class="photo-container">
                                    @php
                                        $photoUrl = null;
                                        if ($employee->photo_path) {
                                            $photoUrl = asset('storage/' . $employee->photo_path);
                                        } elseif ($employee->user && $employee->user->profile_photo_path) {
                                            $photoUrl = asset('storage/' . $employee->user->profile_photo_path);
                                        }
                                    @endphp
                                    
                                    @if($photoUrl)
                                        <img src="{{ $photoUrl }}" alt="{{ $employee->name }}">
                                    @else
                                        <div class="photo-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="employee-info">
                                <div class="employee-name">{{ $employee->name }}</div>
                                <div class="employee-id">ID: {{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>

                                <div class="employee-details">
                                    <div class="detail-item">
                                        <div class="detail-icon"><i class="fas fa-briefcase"></i></div>
                                        <div class="detail-text">{{ $employee->position ?? 'N/A' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-icon"><i class="fas fa-building"></i></div>
                                        <div class="detail-text">{{ $employee->department ?? 'General' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-icon"><i class="fas fa-envelope"></i></div>
                                        <div class="detail-text">{{ $employee->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="verification-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>VERIFIED EMPLOYEE</span>
                        </div>
                    </div>

                    <div class="card-footer"></div>
                </div>

                <!-- Back Side -->
                <div class="card-face card-back">
                    <div class="card-header">
                        <div class="company-info">
                            <div class="company-logo">
                                @if(config('app.logo'))
                                    <img src="{{ asset(config('app.logo')) }}" alt="Logo">
                                @else
                                    <i class="fas fa-building"></i>
                                @endif
                            </div>
                            <div class="company-name">
                                <h2>{{ config('app.name', 'Company Name') }}</h2>
                                <p>EMPLOYEE INFORMATION</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="qr-section">
                            <div class="qr-code">
                                @php
                                    $qrData = route('employees.public.verify', $employee);
                                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);
                                @endphp
                                <img src="{{ $qrUrl }}" alt="QR Code">
                            </div>
                            <div class="qr-label">Scan to Verify</div>
                        </div>

                        <div class="back-info">
                            <div class="info-row">
                                <span class="info-label">Employee Code:</span>
                                <span class="info-value">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone:</span>
                                <span class="info-value">{{ $employee->mobile_no ?? 'N/A' }}</span>
                            </div>
                            @if($employee->joining_date)
                            <div class="info-row">
                                <span class="info-label">Joined:</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($employee->joining_date)->format('M d, Y') }}</span>
                            </div>
                            @endif
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="info-value" style="color: {{ ($employee->status ?? 'active') === 'active' ? '#10b981' : '#ef4444' }}">
                                    {{ ucfirst($employee->status ?? 'active') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <!-- Flip Button -->
        <button class="flip-button" onclick="flipCard()">
            <i class="fas fa-sync-alt"></i>
            <span id="flipText">View Back</span>
        </button>
    </div>

    <script>
        let isFlipped = false;

        function flipCard() {
            const card = document.getElementById('idCard');
            const flipText = document.getElementById('flipText');
            
            isFlipped = !isFlipped;
            
            if (isFlipped) {
                card.classList.add('flipped');
                flipText.textContent = 'View Front';
            } else {
                card.classList.remove('flipped');
                flipText.textContent = 'View Back';
            }
        }

        // Handle image loading errors
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG' && e.target.closest('.photo-container')) {
                e.target.parentElement.innerHTML = '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
            }
        }, true);
    </script>
</body>
</html>
