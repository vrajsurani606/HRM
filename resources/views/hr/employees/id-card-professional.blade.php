<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - Employee ID Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --accent-color: #0ea5e9;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1e293b;
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
            
            --card-width: 350px;
            --card-height: 220px;
            --border-radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.5;
        }

        /* Header Actions */
        .header-actions {
            background: var(--white);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .header-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .action-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .action-btn:hover {
            background: var(--primary-color);
            filter: brightness(1.1);
            transform: translateY(-1px);
            color: var(--white);
        }

        .action-btn.secondary {
            background: var(--gray-600);
        }

        .action-btn.success {
            background: var(--success-color);
        }

        .action-btn.danger {
            background: var(--danger-color);
        }

        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Card Container */
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 60vh;
            padding: 2rem 0;
        }

        /* Employee ID Card */
        .employee-id-card {
            width: var(--card-width);
            height: var(--card-height);
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .employee-id-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Card Header */
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--white);
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .company-logo {
            font-size: 1.125rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .card-type {
            font-size: 0.75rem;
            font-weight: 500;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Card Body */
        .card-body {
            padding: 1rem;
            display: flex;
            gap: 1rem;
            height: calc(100% - 60px);
        }

        /* Employee Photo */
        .employee-photo {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .photo-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--primary-color);
            box-shadow: var(--shadow);
            position: relative;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 2rem;
        }

        /* Employee Info */
        .employee-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .employee-name {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .employee-id {
            font-size: 0.875rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .detail-icon {
            width: 12px;
            height: 12px;
            color: var(--gray-400);
            flex-shrink: 0;
        }

        .detail-text {
            font-weight: 500;
        }

        /* QR Code Section */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .qr-code {
            width: 60px;
            height: 60px;
            border: 1px solid var(--gray-200);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
        }

        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .qr-placeholder {
            width: 100%;
            height: 100%;
            background: var(--gray-50);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 0.75rem;
            text-align: center;
            line-height: 1.2;
            border-radius: 4px;
        }

        .qr-code canvas,
        .qr-code img {
            border-radius: 4px;
        }

        .qr-label {
            font-size: 0.625rem;
            color: var(--gray-500);
            text-align: center;
            font-weight: 500;
        }

        /* Card Footer */
        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--success-color));
        }

        /* Card Preview Section */
        .card-preview-section {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .preview-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* Employee Details Table */
        .employee-details-table {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-top: 2rem;
        }

        .details-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .detail-card {
            background: var(--gray-50);
            border-radius: 8px;
            padding: 1rem;
            border-left: 4px solid var(--primary-color);
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 0.875rem;
            color: var(--gray-800);
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-actions {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .action-buttons {
                justify-content: center;
            }

            .main-container {
                padding: 1rem 0.5rem;
            }

            .employee-id-card {
                width: 100%;
                max-width: 350px;
                height: auto;
                min-height: var(--card-height);
            }

            .card-body {
                flex-direction: column;
                gap: 1rem;
                height: auto;
                padding: 1rem;
            }

            .employee-photo {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .header-actions,
            .employee-details-table {
                display: none;
            }

            .main-container {
                padding: 0;
            }

            .card-container {
                min-height: auto;
                padding: 0;
            }

            .employee-id-card {
                box-shadow: none;
                border: 2px solid var(--gray-300);
                page-break-inside: avoid;
            }

            .employee-id-card:hover {
                transform: none;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Header Actions -->
    <div class="header-actions">
        <div class="header-title">
            <i class="fas fa-id-card"></i>
            Employee ID Card - {{ $employee->name }}
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
            <a href="{{ route('employees.id-card.compact', $employee) }}" class="action-btn secondary" target="_blank">
                <i class="fas fa-mobile-alt"></i>
                Compact View
            </a>
            <a href="{{ route('employees.show', $employee) }}" class="action-btn secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Profile
            </a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Card Preview Section -->
        <div class="card-preview-section loading">
            <h2 class="preview-title">Employee ID Card Preview</h2>
            
            <!-- Card Container -->
            <div class="card-container">
                <div class="employee-id-card" id="employeeCard">
                    <!-- Card Header -->
                    <div class="card-header">
                        <div class="company-logo">
                            {{ config('app.name', 'Company Name') }}
                        </div>
                        <div class="card-type">
                            EMPLOYEE ID
                        </div>
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
                        <div class="employee-info">
                            <div>
                                <div class="employee-name">{{ $employee->name }}</div>
                                <div class="employee-id">ID: {{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <div class="employee-details">
                                <div class="detail-item">
                                    <i class="fas fa-briefcase detail-icon"></i>
                                    <span class="detail-text">{{ $employee->position ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-building detail-icon"></i>
                                    <span class="detail-text">{{ $employee->department ?? ($employee->position ? 'Department' : 'General') }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-phone detail-icon"></i>
                                    <span class="detail-text">{{ $employee->mobile_no ?? 'N/A' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-envelope detail-icon"></i>
                                    <span class="detail-text">{{ $employee->email }}</span>
                                </div>
                                @if($employee->joining_date)
                                <div class="detail-item">
                                    <i class="fas fa-calendar detail-icon"></i>
                                    <span class="detail-text">Joined: {{ \Carbon\Carbon::parse($employee->joining_date)->format('M Y') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- QR Code -->
                        <div class="qr-section">
                            <div class="qr-code" id="qrCode">
                                <div class="qr-placeholder">
                                    QR Code
                                </div>
                            </div>
                            <div class="qr-label">Scan to Verify</div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <!-- Employee Details Table -->
        <div class="employee-details-table loading">
            <h3 class="details-title">Employee Information</h3>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">{{ $employee->name }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Employee ID</div>
                    <div class="detail-value">{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Designation</div>
                    <div class="detail-value">{{ $employee->position ?? 'N/A' }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Department</div>
                    <div class="detail-value">{{ $employee->department ?? 'Administration' }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $employee->email }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value">{{ $employee->mobile_no ?? 'N/A' }}</div>
                </div>
                @if($employee->joining_date)
                <div class="detail-card">
                    <div class="detail-label">Joining Date</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($employee->joining_date)->format('d M, Y') }}</div>
                </div>
                @endif
                @if($employee->date_of_birth)
                <div class="detail-card">
                    <div class="detail-label">Date of Birth</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d M, Y') }}</div>
                </div>
                @endif
                <div class="detail-card">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">{{ ucfirst($employee->status ?? 'active') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
            verification_url: '{{ route('employees.show', $employee) }}'
        };

        // Generate QR Code
        function generateQRCode() {
            const qrContainer = document.getElementById('qrCode');
            
            // Simple QR data - just the employee verification URL
            const qrData = employeeData.verification_url;

            // Clear existing content
            qrContainer.innerHTML = '';

            try {
                // Generate QR code using QRCode.js
                QRCode.toCanvas(qrData, {
                    width: 60,
                    height: 60,
                    margin: 1,
                    color: {
                        dark: '#1e293b',
                        light: '#ffffff'
                    },
                    errorCorrectionLevel: 'M'
                }, function (error, canvas) {
                    if (error) {
                        console.error('QR Code generation failed:', error);
                        // Fallback to text-based QR
                        generateFallbackQR();
                    } else {
                        canvas.style.width = '60px';
                        canvas.style.height = '60px';
                        qrContainer.appendChild(canvas);
                    }
                });
            } catch (error) {
                console.error('QR Code library error:', error);
                generateFallbackQR();
            }
        }

        // Fallback QR code generation
        function generateFallbackQR() {
            const qrContainer = document.getElementById('qrCode');
            const qrData = employeeData.verification_url;
            
            // Use Google Charts API as fallback
            const qrImg = document.createElement('img');
            qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=${encodeURIComponent(qrData)}`;
            qrImg.style.width = '60px';
            qrImg.style.height = '60px';
            qrImg.onerror = function() {
                // Final fallback - show employee code as text
                qrContainer.innerHTML = `<div class="qr-placeholder" style="font-size: 8px; line-height: 1.1;">${employeeData.code}</div>`;
            };
            
            qrContainer.appendChild(qrImg);
        }

        // Print Card
        function printCard() {
            window.print();
        }

        // Download as PDF
        function downloadPDF() {
            // Use the backend route for PDF generation
            showNotification('Generating PDF...', 'info');
            
            // Create a temporary link to trigger download
            const link = document.createElement('a');
            link.href = '{{ route('employees.id-card.pdf', $employee) }}';
            link.target = '_blank';
            link.click();
            
            showNotification('PDF download started!', 'success');
        }

        // Alternative client-side PDF generation
        function downloadPDFClientSide() {
            const { jsPDF } = window.jspdf;
            const card = document.getElementById('employeeCard');
            
            // Show loading
            showNotification('Generating PDF...', 'info');
            
            html2canvas(card, {
                scale: 3,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                logging: false,
                width: 350,
                height: 220
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png', 1.0);
                
                // Create PDF in ID card dimensions (85.6mm x 54mm)
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [85.6, 54]
                });
                
                // Add the image to fit the entire page
                pdf.addImage(imgData, 'PNG', 0, 0, 85.6, 54, '', 'FAST');
                
                // Save the PDF
                const fileName = `${employeeData.name.replace(/\s+/g, '_')}_ID_Card.pdf`;
                pdf.save(fileName);
                
                showNotification('PDF downloaded successfully!', 'success');
            }).catch(error => {
                console.error('PDF generation failed:', error);
                showNotification('Failed to generate PDF. Please try again.', 'error');
            });
        }

        // Download as Image
        function downloadImage() {
            const card = document.getElementById('employeeCard');
            
            // Show loading
            showNotification('Generating image...', 'info');
            
            html2canvas(card, {
                scale: 3,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `${employeeData.name.replace(/\s+/g, '_')}_ID_Card.png`;
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
                background: ${type === 'error' ? 'var(--danger-color)' : type === 'success' ? 'var(--success-color)' : 'var(--primary-color)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
                box-shadow: var(--shadow-lg);
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

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Generate QR code
            generateQRCode();
            
            // Add loading animation delay
            setTimeout(() => {
                document.querySelectorAll('.loading').forEach(element => {
                    element.style.opacity = '1';
                });
            }, 100);
        });

        // Photo placeholder function
        function showPhotoPlaceholder(img) {
            img.parentElement.innerHTML = '<div class="photo-placeholder"><i class="fas fa-user"></i></div>';
        }

        // Handle image loading errors
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG' && e.target.closest('.photo-container')) {
                showPhotoPlaceholder(e.target);
            }
        }, true);
    </script>
</body>
</html>