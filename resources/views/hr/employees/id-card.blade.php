<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="print-color-adjust" content="exact">
    <title>{{ $employee->name }} - Employee ID Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @php
            $isPrintView = request()->get('print') === '1';
        @endphp
        
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
            background: {{ $isPrintView ? 'white' : 'var(--gray-50)' }};
            color: var(--gray-800);
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        @if($isPrintView)
        .header-actions,
        .employee-details-table,
        .preview-title {
            display: none !important;
        }

        body {
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .main-container {
            padding: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            min-height: 100vh !important;
            background: white !important;
        }

        .card-preview-section {
            background: white !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
        }

        .employee-id-card {
            border: 2px solid #2563eb !important;
            width: 350px !important;
            height: 220px !important;
        }
        @endif

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
            border: 2px solid var(--primary-color);
            transition: all 0.3s ease;
            margin: 0 auto;
        }

        .employee-id-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="cardPattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="%23f3f4f6" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23cardPattern)"/></svg>');
            pointer-events: none;
            z-index: 0;
        }

        .employee-id-card > * {
            position: relative;
            z-index: 1;
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
            min-height: 50px;
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
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-img {
            max-height: 32px;
            max-width: 120px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            drop-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .logo-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-text i {
            font-size: 1rem;
        }

        .card-type {
            font-size: 0.75rem;
            font-weight: 600;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.5px;
        }

        /* Card Body */
        .card-body {
            padding: 1rem;
            display: flex;
            gap: 1rem;
            height: calc(100% - 60px);
            position: relative;
        }

        .card-body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 1rem;
            right: 1rem;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, var(--gray-200) 20%, var(--gray-200) 80%, transparent 100%);
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
            background: var(--gray-100);
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.2s ease;
        }

        .photo-container:hover img {
            transform: scale(1.05);
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
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
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .employee-id {
            font-size: 0.875rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            border: 1px solid var(--primary-color);
            display: inline-block;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.1);
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
            margin-bottom: 0.25rem;
            padding: 0.125rem 0;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-icon {
            width: 12px;
            height: 12px;
            color: var(--primary-color);
            flex-shrink: 0;
            opacity: 0.7;
        }

        .detail-text {
            font-weight: 500;
            line-height: 1.3;
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
            border: 2px solid var(--gray-200);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .qr-code::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 6px;
            z-index: -1;
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
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
                -webkit-filter: none !important;
                filter: none !important;
            }

            @page {
                size: 85.6mm 54mm;
                margin: 0;
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
                margin: 0 !important;
                padding: 0 !important;
                font-family: 'Arial', 'Helvetica', sans-serif !important;
                font-size: 8pt !important;
                width: 85.6mm !important;
                height: 54mm !important;
            }

            .header-actions,
            .employee-details-table,
            .card-preview-section h2,
            .preview-title,
            .action-buttons {
                display: none !important;
            }

            .main-container {
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
                width: 85.6mm !important;
                height: 54mm !important;
            }

            .card-preview-section {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                width: 85.6mm !important;
                height: 54mm !important;
            }

            .card-container {
                min-height: auto !important;
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
                width: 85.6mm !important;
                height: 54mm !important;
            }

            .employee-id-card {
                width: 85.6mm !important;
                height: 54mm !important;
                box-shadow: none !important;
                border: 1pt solid #2563eb !important;
                border-radius: 3mm !important;
                page-break-inside: avoid !important;
                background: white !important;
                position: relative !important;
                overflow: hidden !important;
                margin: 0 !important;
                display: block !important;
            }

            .employee-id-card:hover {
                transform: none !important;
            }

            .card-header {
                background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%) !important;
                background-color: #2563eb !important;
                color: white !important;
                padding: 2mm 3mm !important;
                font-size: 7pt !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                height: 8mm !important;
                position: relative !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .card-header::before {
                content: '' !important;
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="8" height="8" patternUnits="userSpaceOnUse"><circle cx="4" cy="4" r="0.8" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>') !important;
            }

            .company-logo {
                font-size: 8pt !important;
                font-weight: bold !important;
                position: relative !important;
                z-index: 2 !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
                display: flex !important;
                align-items: center !important;
                gap: 1mm !important;
            }

            .logo-img {
                max-height: 6mm !important;
                max-width: 20mm !important;
                object-fit: contain !important;
                filter: brightness(0) invert(1) !important;
                drop-shadow: 0 0.5mm 1mm rgba(0,0,0,0.3) !important;
            }

            .logo-text {
                display: flex !important;
                align-items: center !important;
                gap: 1mm !important;
            }

            .logo-text i {
                font-size: 6pt !important;
            }

            .card-type {
                font-size: 5pt !important;
                opacity: 0.95 !important;
                position: relative !important;
                z-index: 2 !important;
                font-weight: bold !important;
                letter-spacing: 0.5pt !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
            }

            .card-body {
                padding: 3mm !important;
                display: flex !important;
                gap: 3mm !important;
                height: calc(54mm - 12mm) !important;
                align-items: stretch !important;
            }

            .employee-photo {
                flex-shrink: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: flex-start !important;
            }

            .photo-container {
                width: 18mm !important;
                height: 18mm !important;
                border-radius: 50% !important;
                border: 2pt solid #2563eb !important;
                overflow: hidden !important;
                background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%) !important;
                background-color: #f3f4f6 !important;
                box-shadow: 0 1mm 2mm rgba(0,0,0,0.1) !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .photo-container img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }

            .photo-placeholder {
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                color: #6b7280 !important;
                font-size: 8pt !important;
            }

            .employee-info {
                flex: 1 !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                padding-right: 2mm !important;
            }

            .employee-name {
                font-size: 8pt !important;
                font-weight: bold !important;
                color: #1f2937 !important;
                margin-bottom: 1mm !important;
                line-height: 1.1 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.3pt !important;
            }

            .employee-id {
                font-size: 6pt !important;
                color: #2563eb !important;
                font-weight: bold !important;
                margin-bottom: 2mm !important;
                background: #f0f9ff !important;
                background-color: #f0f9ff !important;
                padding: 0.5mm 1mm !important;
                border-radius: 1mm !important;
                border: 0.5pt solid #2563eb !important;
                display: inline-block !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .employee-details {
                display: flex !important;
                flex-direction: column !important;
                gap: 0.8mm !important;
            }

            .detail-item {
                font-size: 5pt !important;
                color: #374151 !important;
                line-height: 1.2 !important;
                display: flex !important;
                align-items: center !important;
                gap: 1mm !important;
            }

            .detail-icon {
                width: 2.5mm !important;
                height: 2.5mm !important;
                color: #2563eb !important;
                flex-shrink: 0 !important;
                font-size: 5pt !important;
            }

            .detail-text {
                font-weight: 500 !important;
                flex: 1 !important;
            }

            .qr-section {
                flex-shrink: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                gap: 1mm !important;
                justify-content: flex-start !important;
            }

            .qr-code {
                width: 16mm !important;
                height: 16mm !important;
                border: 1pt solid #e5e7eb !important;
                border-radius: 2mm !important;
                background: white !important;
                background-color: white !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                box-shadow: 0 0.5mm 1mm rgba(0,0,0,0.1) !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .qr-code img {
                width: 95% !important;
                height: 95% !important;
                object-fit: contain !important;
                border-radius: 1mm !important;
            }

            .qr-placeholder {
                font-size: 4pt !important;
                color: #9ca3af !important;
                text-align: center !important;
                line-height: 1.1 !important;
                font-weight: bold !important;
            }

            .qr-label {
                font-size: 3pt !important;
                color: #6b7280 !important;
                text-align: center !important;
                font-weight: bold !important;
                text-transform: uppercase !important;
                letter-spacing: 0.2pt !important;
            }

            .card-footer {
                position: absolute !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                height: 2mm !important;
                background: linear-gradient(90deg, #2563eb 0%, #0ea5e9 50%, #10b981 100%) !important;
                background-color: #2563eb !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Add professional styling elements */
            .card-body::before {
                content: '' !important;
                position: absolute !important;
                top: 8mm !important;
                left: 0 !important;
                right: 0 !important;
                height: 0.5pt !important;
                background: linear-gradient(90deg, transparent 0%, #e5e7eb 20%, #e5e7eb 80%, transparent 100%) !important;
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
            <a href="{{ route('employees.id-card.show', $employee) }}?print=1" target="_blank" class="action-btn secondary">
                <i class="fas fa-external-link-alt"></i>
                Print View
            </a>
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
                            @if(file_exists(public_path('full_logo.jpeg')))
                                <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo" class="logo-img">
                            @elseif(config('app.logo'))
                                <img src="{{ asset(config('app.logo')) }}" alt="Company Logo" class="logo-img">
                            @else
                                <div class="logo-text">
                                    <i class="fas fa-building"></i>
                                    <span>{{ config('app.name', 'Company Name') }}</span>
                                </div>
                            @endif
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
                                    <span class="detail-text">{{ $employee->department ?? 'General' }}</span>
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
                                @php
                                    $qrData = route('employees.public.verify', $employee);
                                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=" . urlencode($qrData);
                                @endphp
                                <img src="{{ $qrUrl }}" alt="QR Code" style="width: 60px; height: 60px; border-radius: 4px;" onerror="this.parentElement.innerHTML='<div class=\'qr-placeholder\'>{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>'">
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
                    <div class="detail-value">{{ $employee->department ?? 'General' }}</div>
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
            // Show color printing instruction with detailed steps
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
                        <p style="color: #2563eb; font-weight: 500;">This ensures all gradients and colors print correctly!</p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Continue to Print',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2563eb',
                width: '500px'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a new window for printing
                    const printWindow = window.open('{{ route('employees.id-card.show', $employee) }}?print=1', '_blank');
                    
                    // Wait for the new window to load, then print
                    printWindow.onload = function() {
                        setTimeout(() => {
                            printWindow.print();
                        }, 1000);
                    };
                }
            });
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

            @if($isPrintView)
            // Auto-print for print view
            setTimeout(() => {
                window.print();
            }, 1500);
            @endif
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