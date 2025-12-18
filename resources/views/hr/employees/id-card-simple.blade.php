<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - ID Card</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .id-card { 
            width: 350px; 
            height: 220px; 
            border: 2px solid #333; 
            border-radius: 10px; 
            padding: 20px; 
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header { background: #2563eb; color: white; padding: 10px; margin: -20px -20px 20px -20px; border-radius: 8px 8px 0 0; }
        .employee-info { display: flex; gap: 20px; }
        .photo { width: 80px; height: 80px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; }
        .details { flex: 1; }
        .name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .id { color: #2563eb; font-weight: bold; margin-bottom: 10px; }
        .detail { margin-bottom: 5px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">
            <strong>{{ config('app.name', 'Company Name') }}</strong> - Employee ID Card
        </div>
        
        <div class="employee-info">
            <div class="photo">
                @if($employee->photo_path)
                    <img src="{{ asset('storage/' . $employee->photo_path) }}" alt="{{ $employee->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    👤
                @endif
            </div>
            
            <div class="details">
                <div class="name">{{ $employee->name }}</div>
                <div class="id">ID: {{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="detail"><strong>Position:</strong> {{ $employee->position ?? 'N/A' }}</div>
                <div class="detail"><strong>Email:</strong> {{ $employee->email }}</div>
                <div class="detail"><strong>Phone:</strong> {{ $employee->mobile_no ?? 'N/A' }}</div>
                @if($employee->joining_date)
                <div class="detail"><strong>Joined:</strong> {{ \Carbon\Carbon::parse($employee->joining_date)->format('M Y') }}</div>
                @endif
            </div>
        </div>
        
        <div style="margin-top: 20px; text-align: center;">
            <div style="width: 60px; height: 60px; border: 1px solid #ccc; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                QR Code
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button onclick="window.print()">Print Card</button>
        <a href="{{ route('employees.show', $employee) }}" style="margin-left: 10px;">Back to Profile</a>
    </div>
</body>
</html>