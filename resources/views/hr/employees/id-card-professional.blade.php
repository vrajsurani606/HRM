<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="print-color-adjust" content="exact">
    <title>{{ $employee->name }} - Professional ID Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #64748b;
            --accent-color: #3b82f6;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
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
        }

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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--white);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.4);
            color: var(--white);
        }

        .action-btn.secondary {
            background: linear-gradient(135deg, var(--gray-600) 0%, var(--gray-700) 100%);
            box-shadow: 0 4px 15px rgba(75, 85, 99, 0.3);
        }

        .action-btn.success {
            background: linear-gradient(135deg, var(--success-color) 0%, #10b981 100%);
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        /* Professional ID Card */
        .professional-id-card {
            width: 420px;
            height: 260px;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 3px solid var(--primary-color);
            position: relative;
            margin: 0 auto;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--white);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            height: 60px;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="12" height="12" patternUnits="userSpaceOnUse"><circle cx="6" cy="6" r="1.5" fill="white" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        }

        .company-logo {
            font-size: 1.25rem;
            font-weight: 800;
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .logo-img {
            max-height: 32px;
            max-width: 100px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            drop-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .card-type {
            font-size: 0.875rem;
            font-weight: 700;
            opacity: 0.95;
            position: relative;
            z-index: 2;
            letter-spacing: 1px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .card-body {
            padding: 1.25rem;
            display: flex;
            gap: 1rem;
            height: calc(260px - 60px - 6px);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            align-items: stretch;
        }

        .employee-section {
            display: flex;
            gap: 1rem;
            flex: 1;
            align-items: flex-start;
            overflow: hidden;
        }

        .photo-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--primary-color);
            box-shadow: 0 6px 12px rgba(30, 64, 175, 0.3);
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            color: var(--gray-400);
            font-size: 2.5rem;
        }

        .employee-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            overflow: hidden;
        }

        .employee-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .employee-id {
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.8rem;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            border: 2px solid var(--primary-color);
            display: inline-block;
            box-shadow: 0 2px 6px rgba(30, 64, 175, 0.2);
            white-space: nowrap;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--gray-700);
            font-weight: 500;
            margin-bottom: 0.3rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .detail-icon {
            width: 16px;
            height: 16px;
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .qr-code {
            width: 70px;
            height: 70px;
            border: 2px solid var(--primary-color);
            border-radius: 10px;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 12px rgba(30, 64, 175, 0.2);
            position: relative;
        }

        .qr-code::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
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
            font-size: 0.7rem;
            color: var(--gray-400);
            text-align: center;
            line-height: 1.2;
            font-weight: 600;
        }

        .qr-label {
            font-size: 0.7rem;
            color: var(--gray-600);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--accent-color) 50%, var(--success-color) 100%);
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
                margin: 15mm;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                print-color-adjust: exact;
            }

            body {
                background: white !important;
                padding: 0 !important;
                display: block !important;
                min-height: auto !important;
            }

            .container {
                background: white !important;
                backdrop-filter: none !important;
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }

            .header-actions {
                display: none !important;
            }

            .professional-id-card {
                margin: 0 auto !important;
                page-break-inside: avoid !important;
                border: 3px solid var(--primary-color) !important;
            }

            .card-header {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .card-footer {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .employee-id {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .photo-container {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .qr-code {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .container {
                padding: 1rem;
            }

            .professional-id-card {
                width: 100%;
                max-width: 420px;
                height: auto;
                min-height: 260px;
            }

            .card-body {
                flex-direction: column;
                gap: 1rem;
                height: auto;
                padding: 1rem;
            }

            .employee-section {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .header-actions {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .action-buttons {
                justify-content: center;
            }
        }
    </style>
</head><body>

    <div class="container">
        <!-- Header Actions -->
        <div class="header-actions">
            <div class="header-title">
                <i class="fas fa-id-card-clip"></i>
                Professional ID Card - {{ $employee->name }}
            </div>
            <div class="action-buttons">
                <button onclick="printCard()" class="action-btn">
                    <i class="fas fa-print"></i>
                    Print Card
                </button>
                <button onclick="downloadPDF()" class="action-btn success">
                    <i class="fas fa-download"></i>
                    Download PDF
                </button>
                <button onclick="downloadImage()" class="action-btn secondary">
                    <i class="fas fa-image"></i>
                    Download Image
                </button>
                <a href="{{ route('employees.show', $employee) }}" class="action-btn secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Profile
                </a>
            </div>
        </div>

        <!-- Professional ID Card -->
        <div class="professional-id-card" id="professionalCard">
            <!-- Card Header -->
            <div class="card-header">
                <div class="company-logo">
                    @if(file_exists(public_path('full_logo.jpeg')))
                        <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo" class="logo-img">
                    @else
                        <i class="fas fa-building"></i>
                        <span>{{ config('app.name', 'Company Name') }}</span>
                    @endif
                </div>
                <div class="card-type">EMPLOYEE ID</div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="employee-section">
                    <!-- Employee Photo -->
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
                            <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" onerror="this.parentElement.innerHTML='<div class=\'photo-placeholder\'><i class=\'fas fa-user\'></i></div>'">
                        @else
                            <div class="photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Employee Info -->
                    <div class="employee-info">
                        <div>
                            <div class="employee-name">{{ $employee->name }}</div>
                            <div class="employee-id">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>

                        <div class="employee-details">
                            <div class="detail-item">
                                <i class="fas fa-briefcase detail-icon"></i>
                                {{ $employee->position ?? 'N/A' }}
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-building detail-icon"></i>
                                {{ $employee->department ?? 'General' }}
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-envelope detail-icon"></i>
                                {{ Str::limit($employee->email, 20) }}
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-phone detail-icon"></i>
                                {{ $employee->mobile_no ?? 'N/A' }}
                            </div>
                            @if($employee->joining_date)
                            <div class="detail-item">
                                <i class="fas fa-calendar detail-icon"></i>
                                {{ \Carbon\Carbon::parse($employee->joining_date)->format('M Y') }}
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
                    <div class="qr-label">SCAN TO VERIFY</div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer"></div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Employee data
        const employeeData = {
            id: {{ $employee->id }},
            code: '{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}',
            name: '{{ $employee->name }}',
            email: '{{ $employee->email }}',
            position: '{{ $employee->position ?? 'N/A' }}',
            verification_url: '{{ route('employees.show', $employee) }}'
        };

        // Print Card
        function printCard() {
            Swal.fire({
                title: 'Color Printing Instructions',
                html: `
                    <div style="text-align: left; font-size: 14px; line-height: 1.6;">
                        <p><strong>To print in full color:</strong></p>
                        <ol style="margin: 10px 0; padding-left: 20px;">
                            <li>In the print dialog, click <strong>"More settings"</strong></li>
                            <li>Under <strong>"Options"</strong>, check <strong>"Background graphics"</strong></li>
                            <li>Set <strong>"Color"</strong> to <strong>"Color"</strong> (not Black & White)</li>
                            <li>Click <strong>"Print"</strong></li>
                        </ol>
                        <p style="color: #1e40af; font-weight: 500;">This ensures all gradients and colors print correctly!</p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Continue to Print',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#1e40af',
                width: '500px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.print();
                }
            });
        }

        // Download as PDF
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const card = document.getElementById('professionalCard');
            
            showNotification('Generating PDF...', 'info');
            
            html2canvas(card, {
                scale: 3,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                width: 420,
                height: 260
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png', 1.0);
                
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [100, 63] // Professional card size
                });
                
                pdf.addImage(imgData, 'PNG', 0, 0, 100, 63, '', 'FAST');
                
                const fileName = `${employeeData.name.replace(/\s+/g, '_')}_Professional_ID_Card.pdf`;
                pdf.save(fileName);
                
                showNotification('PDF downloaded successfully!', 'success');
            }).catch(error => {
                console.error('PDF generation failed:', error);
                showNotification('Failed to generate PDF. Please try again.', 'error');
            });
        }

        // Download as Image
        function downloadImage() {
            const card = document.getElementById('professionalCard');
            
            showNotification('Generating image...', 'info');
            
            html2canvas(card, {
                scale: 4,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `${employeeData.name.replace(/\s+/g, '_')}_Professional_ID_Card.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
                
                showNotification('Image downloaded successfully!', 'success');
            }).catch(error => {
                console.error('Image generation failed:', error);
                showNotification('Failed to generate image', 'error');
            });
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
                background: ${type === 'error' ? '#dc2626' : type === 'success' ? '#059669' : '#1e40af'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                max-width: 400px;
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

        // Handle image loading errors
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG' && e.target.closest('.photo-container')) {
                e.target.parentElement.innerHTML = '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
            }
        }, true);
    </script>
</body>
</html>