<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="print-color-adjust" content="exact">
    <title>{{ $employee->name }} - Modern ID Card</title>
    
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .id-card { 
            width: 380px; 
            height: 240px; 
            border-radius: 20px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            overflow: hidden;
            position: relative;
            transform: perspective(1000px) rotateY(-5deg);
            transition: all 0.3s ease;
        }

        .id-card:hover {
            transform: perspective(1000px) rotateY(0deg) translateY(-5px);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.6);
        }

        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }

        .header { 
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white; 
            padding: 15px 20px; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .company-logo {
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .logo-img {
            max-height: 28px;
            max-width: 100px;
            object-fit: contain;
            filter: brightness(0) invert(1) drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .card-type {
            font-size: 11px;
            opacity: 0.9;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .card-body {
            padding: 20px;
            height: calc(240px - 60px);
            display: flex;
            gap: 20px;
            position: relative;
            z-index: 2;
        }

        .employee-info { 
            display: flex; 
            gap: 18px; 
            flex: 1;
        }

        .photo { 
            width: 80px; 
            height: 80px; 
            border-radius: 50%; 
            background: rgba(255, 255, 255, 0.2);
            display: flex; 
            align-items: center; 
            justify-content: center;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .photo::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #fff, transparent, #fff);
            border-radius: 50%;
            z-index: -1;
        }

        .photo img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .photo-placeholder {
            font-size: 28px;
            color: rgba(255, 255, 255, 0.8);
        }

        .details { 
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        .name { 
            font-size: 18px; 
            font-weight: 700; 
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            line-height: 1.2;
        }

        .employee-id { 
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600; 
            margin-bottom: 10px;
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: inline-block;
            font-size: 12px;
            backdrop-filter: blur(5px);
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .detail { 
            margin-bottom: 4px; 
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .detail-icon {
            width: 14px;
            color: rgba(255, 255, 255, 0.8);
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .qr-code {
            width: 70px;
            height: 70px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            position: relative;
            backdrop-filter: blur(10px);
        }

        .qr-code::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, rgba(255,255,255,0.5), transparent, rgba(255,255,255,0.5));
            border-radius: 12px;
            z-index: -1;
        }

        .qr-code img {
            width: 90%;
            height: 90%;
            object-fit: contain;
            border-radius: 8px;
        }

        .qr-placeholder {
            font-size: 9px;
            color: #666;
            text-align: center;
            line-height: 1.2;
            font-weight: 600;
        }

        .qr-label {
            font-size: 9px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #ff6b6b, #feca57, #48dbfb, #ff9ff3);
            opacity: 0.8;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.6);
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
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                print-color-adjust: exact;
            }

            body {
                background: white !important;
                padding: 0 !important;
                display: block !important;
            }

            .container {
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
            }

            .actions {
                display: none !important;
            }

            .id-card {
                margin: 0 auto !important;
                page-break-inside: avoid !important;
                transform: none !important;
            }

            .header, .card-footer, .employee-id, .photo, .qr-code {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="id-card">
            <div class="card-overlay"></div>
            
            <!-- Card Header -->
            <div class="header">
                <div class="company-logo">
                    @if(file_exists(public_path('full_logo.jpeg')))
                        <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo" class="logo-img">
                    @else
                        <i class="fas fa-building"></i>
                        <span>{{ config('app.name', 'Company Name') }}</span>
                    @endif
                </div>
                <div class="card-type">Employee ID</div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="employee-info">
                    <!-- Employee Photo -->
                    <div class="photo">
                        @php
                            $photoUrl = null;
                            if ($employee->photo_path) {
                                $photoUrl = asset('storage/' . $employee->photo_path);
                            } elseif ($employee->user && $employee->user->profile_photo_path) {
                                $photoUrl = asset('storage/' . $employee->user->profile_photo_path);
                            }
                        @endphp
                        
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" onerror="this.parentElement.innerHTML='<div class=\'photo-placeholder\'><i class=\'fas fa-user\'></i></div>'">
                        @else
                            <div class="photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Employee Details -->
                    <div class="details">
                        <div>
                            <div class="name">{{ $employee->name }}</div>
                            <div class="employee-id">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>

                        <div>
                            <div class="detail">
                                <i class="fas fa-briefcase detail-icon"></i>
                                {{ $employee->position ?? 'N/A' }}
                            </div>
                            <div class="detail">
                                <i class="fas fa-building detail-icon"></i>
                                {{ $employee->department ?? 'General' }}
                            </div>
                            <div class="detail">
                                <i class="fas fa-envelope detail-icon"></i>
                                {{ Str::limit($employee->email, 22) }}
                            </div>
                            <div class="detail">
                                <i class="fas fa-phone detail-icon"></i>
                                {{ $employee->mobile_no ?? 'N/A' }}
                            </div>
                            @if($employee->joining_date)
                            <div class="detail">
                                <i class="fas fa-calendar detail-icon"></i>
                                Joined {{ \Carbon\Carbon::parse($employee->joining_date)->format('M Y') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="qr-section">
                    <div class="qr-code">
                        @php
                            $qrData = route('employees.show', $employee);
                            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=70x70&data=" . urlencode($qrData);
                        @endphp
                        <img src="{{ $qrUrl }}" alt="QR Code" onerror="this.parentElement.innerHTML='<div class=\'qr-placeholder\'>{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>'">
                    </div>
                    <div class="qr-label">Scan to Verify</div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer"></div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    @if(!isset($printMode))
    <div class="actions">
        <button onclick="printCard()" class="btn btn-primary">
            <i class="fas fa-print"></i>
            Print Card
        </button>
        <a href="{{ route('employees.show', $employee) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Profile
        </a>
    </div>
    @endif

    <script>
        function printCard() {
            if (confirm('For best color printing:\n\n1. Enable "Background graphics" in print settings\n2. Set "Color" to "Color" (not Black & White)\n3. Click "Print"\n\nContinue to print?')) {
                window.print();
            }
        }

        // Handle image loading errors
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG' && e.target.closest('.photo')) {
                e.target.parentElement.innerHTML = '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
            }
        }, true);
    </script>
</body>
</html>