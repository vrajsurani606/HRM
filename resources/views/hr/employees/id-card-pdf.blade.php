<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - ID Card</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #ffffff;
            color: #1e293b;
            line-height: 1.4;
        }

        .id-card {
            width: 350px;
            height: 220px;
            background: #ffffff;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            overflow: hidden;
            position: relative;
            margin: 0 auto;
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            color: #ffffff;
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 40px;
        }

        .company-logo {
            font-size: 14px;
            font-weight: bold;
        }

        .card-type {
            font-size: 10px;
            font-weight: 500;
        }

        .card-body {
            padding: 12px;
            display: flex;
            gap: 12px;
            height: calc(100% - 40px - 4px);
        }

        .employee-photo {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .photo-container {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #2563eb;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            color: #9ca3af;
            font-size: 24px;
        }

        .employee-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .employee-name {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 2px;
            line-height: 1.2;
        }

        .employee-id {
            font-size: 11px;
            color: #2563eb;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 9px;
            color: #4b5563;
        }

        .detail-icon {
            width: 10px;
            height: 10px;
            color: #9ca3af;
            flex-shrink: 0;
        }

        .detail-text {
            font-weight: 500;
        }

        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .qr-code {
            width: 50px;
            height: 50px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .qr-placeholder {
            font-size: 8px;
            color: #9ca3af;
            text-align: center;
            line-height: 1.1;
        }

        .qr-label {
            font-size: 7px;
            color: #6b7280;
            text-align: center;
            font-weight: 500;
        }

        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2563eb, #0ea5e9, #10b981);
        }

        /* Font Awesome Icons (simplified for PDF) */
        .fa-briefcase::before { content: "💼"; }
        .fa-building::before { content: "🏢"; }
        .fa-phone::before { content: "📞"; }
        .fa-envelope::before { content: "✉️"; }
        .fa-calendar::before { content: "📅"; }
        .fa-user::before { content: "👤"; }
    </style>
</head>
<body>
    <div class="id-card">
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
                            $photoUrl = public_path('storage/' . $employee->photo_path);
                        } elseif ($employee->user && $employee->user->profile_photo_path) {
                            $photoUrl = public_path('storage/' . $employee->user->profile_photo_path);
                        }
                    @endphp
                    
                    @if($photoUrl && file_exists($photoUrl))
                        <img src="{{ $photoUrl }}" alt="{{ $employee->name }}">
                    @else
                        <div class="photo-placeholder">
                            <span class="fa-user"></span>
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
                        <span class="detail-icon fa-briefcase"></span>
                        <span class="detail-text">{{ $employee->position ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon fa-building"></span>
                        <span class="detail-text">{{ $employee->department ?? 'General' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon fa-phone"></span>
                        <span class="detail-text">{{ $employee->mobile_no ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon fa-envelope"></span>
                        <span class="detail-text">{{ $employee->email }}</span>
                    </div>
                    @if($employee->joining_date)
                    <div class="detail-item">
                        <span class="detail-icon fa-calendar"></span>
                        <span class="detail-text">Joined: {{ \Carbon\Carbon::parse($employee->joining_date)->format('M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- QR Code -->
            <div class="qr-section">
                <div class="qr-code">
                    @php
                        $qrData = route('employees.show', $employee);
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=" . urlencode($qrData);
                    @endphp
                    <img src="{{ $qrUrl }}" alt="QR Code" style="width: 50px; height: 50px; border-radius: 4px;" onerror="this.parentElement.innerHTML='<div class=\'qr-placeholder\'>{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>'">
                </div>
                <div class="qr-label">Scan to Verify</div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="card-footer"></div>
    </div>
</body>
</html>