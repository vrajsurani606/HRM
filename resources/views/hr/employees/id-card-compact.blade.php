<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - ID Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --accent: #0ea5e9;
            --success: #10b981;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: var(--text-primary);
            line-height: 1.5;
            padding: 1rem;
            min-height: 100vh;
        }

        .container {
            max-width: 450px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            color: white;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .header p {
            opacity: 0.9;
        }

        .cards-container {
            display: grid;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .id-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 2px solid var(--primary);
            position: relative;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            padding: 1rem;
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

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .company-logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--primary);
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 5px;
        }

        .company-logo img,
        .company-logo .logo-img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .company-info h2 {
            font-size: 1rem;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .company-info p {
            font-size: 0.75rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .employee-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .employee-photo {
            flex-shrink: 0;
        }

        .photo-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid var(--primary);
            overflow: hidden;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow);
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            font-size: 2rem;
            color: #9ca3af;
        }

        .employee-info {
            flex: 1;
        }

        .employee-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .employee-id {
            display: inline-block;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--primary);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 2px solid var(--primary);
            margin-bottom: 0.75rem;
        }

        .employee-details {
            display: grid;
            gap: 0.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .detail-icon {
            width: 16px;
            height: 16px;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-text {
            font-weight: 500;
            color: var(--text-primary);
        }

        .qr-section {
            text-align: center;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .qr-code {
            width: 120px;
            height: 120px;
            margin: 0 auto 0.5rem;
            border: 2px solid var(--primary);
            border-radius: 8px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow);
        }

        .qr-code img {
            width: 90%;
            height: 90%;
            object-fit: contain;
        }

        .qr-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .back-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .info-value {
            font-size: 0.875rem;
            color: var(--text-primary);
            font-weight: 600;
        }

        .card-footer {
            height: 6px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 50%, var(--success) 100%);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .action-btn {
            flex: 1;
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .action-btn.secondary {
            background: var(--secondary);
            border-color: var(--secondary);
            color: white;
        }

        .action-btn.secondary:hover {
            background: var(--text-primary);
            border-color: var(--text-primary);
        }

        /* Print Styles */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: A4;
                margin: 10mm;
            }

            body {
                background: white !important;
                padding: 0 !important;
                font-size: 10pt !important;
            }

            .header,
            .action-buttons {
                display: none !important;
            }

            .container {
                max-width: none !important;
                margin: 0 !important;
            }

            .cards-container {
                display: block !important;
                gap: 0 !important;
            }

            .id-card {
                width: 85.6mm !important;
                height: 54mm !important;
                margin: 0 auto 10mm !important;
                page-break-inside: avoid !important;
                border: 2pt solid var(--primary) !important;
                border-radius: 8pt !important;
                box-shadow: none !important;
                overflow: hidden !important;
                display: block !important;
            }

            .card-header {
                padding: 2mm !important;
                height: 12mm !important;
                background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%) !important;
            }

            .header-content {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                height: 100% !important;
            }

            .company-logo {
                width: 8mm !important;
                height: 8mm !important;
                font-size: 6pt !important;
                border-radius: 2mm !important;
                padding: 0.5mm !important;
            }

            .company-logo img,
            .company-logo .logo-img {
                max-width: 100% !important;
                max-height: 100% !important;
                width: auto !important;
                height: auto !important;
                object-fit: contain !important;
            }

            .company-info h2 {
                font-size: 6pt !important;
                font-weight: bold !important;
            }

            .company-info p {
                font-size: 4pt !important;
            }

            .card-body {
                padding: 2mm !important;
                height: calc(54mm - 16mm) !important;
            }

            .employee-section {
                display: flex !important;
                gap: 2mm !important;
                margin-bottom: 2mm !important;
                height: 20mm !important;
            }

            .photo-container {
                width: 16mm !important;
                height: 16mm !important;
                border: 1pt solid var(--primary) !important;
                flex-shrink: 0 !important;
            }

            .employee-name {
                font-size: 7pt !important;
                font-weight: bold !important;
                margin-bottom: 0.5mm !important;
                line-height: 1.1 !important;
            }

            .employee-id {
                font-size: 5pt !important;
                padding: 0.5mm 1mm !important;
                margin-bottom: 1mm !important;
                border: 0.5pt solid var(--primary) !important;
            }

            .employee-details {
                gap: 0.3mm !important;
            }

            .detail-item {
                font-size: 4pt !important;
                gap: 1mm !important;
            }

            .detail-icon {
                width: 2mm !important;
                height: 2mm !important;
                font-size: 4pt !important;
            }

            .qr-section {
                display: none !important;
            }

            .back-info {
                display: none !important;
            }

            .card-footer {
                height: 2mm !important;
                background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 50%, var(--success) 100%) !important;
            }

            /* Back card for second page */
            .id-card:nth-child(2) {
                page-break-before: always !important;
            }

            .id-card.back-card .employee-section {
                display: none !important;
            }

            .id-card.back-card .qr-section {
                display: block !important;
                text-align: center !important;
                padding: 2mm !important;
                background: transparent !important;
                margin: 0 !important;
            }

            .id-card.back-card .qr-code {
                width: 20mm !important;
                height: 20mm !important;
                margin: 0 auto 1mm !important;
                border: 1pt solid var(--primary) !important;
            }

            .id-card.back-card .qr-label {
                font-size: 4pt !important;
            }

            .id-card.back-card .back-info {
                display: block !important;
                background: transparent !important;
                padding: 1mm !important;
                border-radius: 0 !important;
            }

            .id-card.back-card .info-row {
                padding: 0.5mm 0 !important;
                font-size: 4pt !important;
                border-bottom: 0.5pt solid var(--border) !important;
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .container {
                padding: 0.5rem;
            }

            .employee-section {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-id-card"></i> Employee ID Card</h1>
            <p>Professional Identification</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button onclick="printCards()" class="action-btn">
                <i class="fas fa-print"></i>
                Print Cards
            </button>
            <a href="{{ route('employees.id-card.show', $employee) }}" class="action-btn secondary">
                <i class="fas fa-expand"></i>
                Full View
            </a>
        </div>

        <!-- Cards Container -->
        <div class="cards-container">
            <!-- Front Card -->
            <div class="id-card">
                <div class="card-header">
                    <div class="header-content">
                        <div class="company-logo">
                            @if(file_exists(public_path('full_logo.jpeg')))
                                <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo" class="logo-img">
                            @elseif(config('app.logo'))
                                <img src="{{ asset(config('app.logo')) }}" alt="Company Logo" class="logo-img">
                            @else
                                <i class="fas fa-building"></i>
                            @endif
                        </div>
                        <div class="company-info">
                            <h2>{{ config('app.name', 'Company Name') }}</h2>
                            <p>EMPLOYEE ID CARD</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="employee-section">
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
                            <div class="employee-id">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>

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
                                    <div class="detail-text">{{ Str::limit($employee->email, 25) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer"></div>
            </div>

            <!-- Back Card -->
            <div class="id-card back-card">
                <div class="card-header">
                    <div class="header-content">
                        <div class="company-logo">
                            @if(file_exists(public_path('full_logo.jpeg')))
                                <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo" class="logo-img">
                            @elseif(config('app.logo'))
                                <img src="{{ asset(config('app.logo')) }}" alt="Company Logo" class="logo-img">
                            @else
                                <i class="fas fa-building"></i>
                            @endif
                        </div>
                        <div class="company-info">
                            <h2>{{ config('app.name', 'Company Name') }}</h2>
                            <p>EMPLOYEE INFORMATION</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="qr-section">
                        <div class="qr-code">
                            @php
                                $qrData = route('employees.id-card.show', $employee);
                                $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" . urlencode($qrData);
                            @endphp
                            <img src="{{ $qrUrl }}" alt="QR Code" loading="lazy">
                        </div>
                        <div class="qr-label">Scan to Verify Employee</div>
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
                            <span class="info-value" style="color: {{ ($employee->status ?? 'active') === 'active' ? 'var(--success)' : '#ef4444' }}">
                                {{ ucfirst($employee->status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-footer"></div>
            </div>
        </div>
    </div>

    <script>
        function printCards() {
            window.print();
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