<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - ID Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
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
            background: var(--background);
            color: var(--text-primary);
            line-height: 1.5;
            padding: 1rem;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
        }

        .id-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            padding: 1rem;
            text-align: center;
            position: relative;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            opacity: 0.3;
        }

        .company-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 1;
        }

        .card-type {
            font-size: 0.875rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 1.5rem;
        }

        .employee-photo {
            text-align: center;
            margin-bottom: 1rem;
        }

        .photo-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--primary);
            margin: 0 auto;
            box-shadow: var(--shadow);
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 2.5rem;
        }

        .employee-name {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .employee-id {
            font-size: 1rem;
            color: var(--primary);
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--background);
            border-radius: 8px;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 0.875rem;
            color: var(--text-primary);
            font-weight: 600;
            margin-top: 0.125rem;
        }

        .qr-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .qr-code {
            width: 80px;
            height: 80px;
            margin: 0 auto 0.5rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }

        .qr-code img,
        .qr-code canvas {
            width: 100%;
            height: 100%;
            border-radius: 8px;
        }

        .qr-placeholder {
            width: 100%;
            height: 100%;
            background: var(--background);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 0.75rem;
            border-radius: 8px;
        }

        .qr-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .action-btn {
            flex: 1;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--primary-dark);
            color: white;
        }

        .action-btn.secondary {
            background: var(--secondary);
        }

        .footer {
            text-align: center;
            padding: 1rem;
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .actions,
            .footer {
                display: none;
            }
            
            .id-card {
                box-shadow: none;
                border: 1px solid #ccc;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="id-card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="company-name">{{ config('app.name', 'Company Name') }}</div>
                <div class="card-type">Employee ID Card</div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Employee Photo -->
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
                            <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" onerror="showPhotoPlaceholder(this)">
                        @else
                            <div class="photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Employee Info -->
                <div class="employee-name">{{ $employee->name }}</div>
                <div class="employee-id">ID: {{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>

                <!-- Employee Details -->
                <div class="employee-details">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Position</div>
                            <div class="detail-value">{{ $employee->position ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Department</div>
                            <div class="detail-value">{{ $employee->department ?? 'General' }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $employee->email }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value">{{ $employee->mobile_no ?? 'N/A' }}</div>
                        </div>
                    </div>

                    @if($employee->joining_date)
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Joined</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($employee->joining_date)->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- QR Code Section -->
                <div class="qr-section">
                    <div class="qr-code" id="qrCode">
                        <div class="qr-placeholder">QR Code</div>
                    </div>
                    <div class="qr-label">Scan to Verify</div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="actions">
            <button onclick="window.print()" class="action-btn">
                <i class="fas fa-print"></i>
                Print
            </button>
            <button onclick="downloadImage()" class="action-btn secondary">
                <i class="fas fa-download"></i>
                Download
            </button>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a digital employee ID card</p>
            <p>Generated on {{ now()->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <script>
        // Employee data for QR code
        const employeeData = {
            id: {{ $employee->id }},
            code: '{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}',
            name: '{{ $employee->name }}',
            email: '{{ $employee->email }}',
            position: '{{ $employee->position ?? 'N/A' }}',
            verification_url: '{{ route('employees.show', $employee) }}'
        };

        // Generate QR Code
        function generateQRCode() {
            const qrContainer = document.getElementById('qrCode');
            const qrData = employeeData.verification_url;

            qrContainer.innerHTML = '';

            try {
                QRCode.toCanvas(qrData, {
                    width: 80,
                    height: 80,
                    margin: 1,
                    color: {
                        dark: '#1e293b',
                        light: '#ffffff'
                    },
                    errorCorrectionLevel: 'M'
                }, function (error, canvas) {
                    if (error) {
                        generateFallbackQR();
                    } else {
                        canvas.style.width = '80px';
                        canvas.style.height = '80px';
                        qrContainer.appendChild(canvas);
                    }
                });
            } catch (error) {
                generateFallbackQR();
            }
        }

        // Fallback QR code generation
        function generateFallbackQR() {
            const qrContainer = document.getElementById('qrCode');
            const qrData = employeeData.verification_url;
            
            const qrImg = document.createElement('img');
            qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=${encodeURIComponent(qrData)}`;
            qrImg.style.width = '80px';
            qrImg.style.height = '80px';
            qrImg.onerror = function() {
                qrContainer.innerHTML = `<div class="qr-placeholder">${employeeData.code}</div>`;
            };
            
            qrContainer.appendChild(qrImg);
        }

        // Download as Image
        function downloadImage() {
            const card = document.querySelector('.id-card');
            
            html2canvas(card, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `${employeeData.name.replace(/\s+/g, '_')}_ID_Card_Mobile.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            }).catch(error => {
                console.error('Image generation failed:', error);
                alert('Failed to generate image');
            });
        }

        // Photo placeholder function
        function showPhotoPlaceholder(img) {
            img.parentElement.innerHTML = '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            generateQRCode();
        });

        // Handle image loading errors
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG' && e.target.closest('.photo-container')) {
                showPhotoPlaceholder(e.target);
            }
        }, true);
    </script>
</body>
</html>