<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - ID Card (Print)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: white;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .id-card {
            width: 350px;
            height: 220px;
            background: white;
            border: 2px solid #ddd;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            color: white;
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
        }

        .card-type {
            font-size: 12px;
            opacity: 0.9;
        }

        .card-body {
            padding: 16px;
            display: flex;
            gap: 16px;
            height: calc(100% - 50px);
        }

        .photo-section {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .photo-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #2563eb;
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
            font-size: 32px;
        }

        .employee-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .employee-name {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .employee-id {
            font-size: 14px;
            color: #2563eb;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-item {
            font-size: 12px;
            color: #4b5563;
            line-height: 1.2;
        }

        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 60px;
        }

        .qr-section {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .qr-code {
            width: 60px;
            height: 60px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .qr-placeholder {
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
            line-height: 1.1;
        }

        .qr-label {
            font-size: 8px;
            color: #6b7280;
            text-align: center;
            font-weight: bold;
        }

        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2563eb, #0ea5e9, #10b981);
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }
            
            .id-card {
                box-shadow: none;
                border: 2px solid #333;
            }
        }
    </style>
</head>
<body>
    <div class="id-card">
        <!-- Card Header -->
        <div class="card-header">
            <div class="company-name">
                {{ config('app.name', 'Company Name') }}
            </div>
            <div class="card-type">
                EMPLOYEE ID
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Photo Section -->
            <div class="photo-section">
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
                        <div class="photo-placeholder">👤</div>
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
                        <span class="detail-label">Position:</span>
                        {{ $employee->position ?? 'N/A' }}
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Dept:</span>
                        {{ $employee->department ?? 'General' }}
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Phone:</span>
                        {{ $employee->mobile_no ?? 'N/A' }}
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        {{ Str::limit($employee->email, 25) }}
                    </div>
                    @if($employee->joining_date)
                    <div class="detail-item">
                        <span class="detail-label">Joined:</span>
                        {{ \Carbon\Carbon::parse($employee->joining_date)->format('M Y') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-code">
                    @php
                        $qrData = route('employees.show', $employee);
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=" . urlencode($qrData);
                    @endphp
                    <img src="{{ $qrUrl }}" alt="QR Code">
                </div>
                <div class="qr-label">SCAN TO VERIFY</div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="card-footer"></div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>
</html>