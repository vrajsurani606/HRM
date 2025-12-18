@props([
    'employee',
    'size' => 'standard', // standard, compact, mini
    'showActions' => true,
    'showQr' => true,
    'showDetails' => true
])

@php
    $cardClasses = [
        'standard' => 'w-[350px] h-[220px]',
        'compact' => 'w-[300px] h-[180px]',
        'mini' => 'w-[250px] h-[150px]'
    ];
    
    $photoSizes = [
        'standard' => 'w-20 h-20',
        'compact' => 'w-16 h-16',
        'mini' => 'w-12 h-12'
    ];
    
    $fontSizes = [
        'standard' => ['name' => 'text-lg', 'id' => 'text-sm', 'detail' => 'text-xs'],
        'compact' => ['name' => 'text-base', 'id' => 'text-sm', 'detail' => 'text-xs'],
        'mini' => ['name' => 'text-sm', 'id' => 'text-xs', 'detail' => 'text-xs']
    ];
@endphp

<div class="employee-id-card {{ $cardClasses[$size] }} bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden relative transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
    <!-- Card Header -->
    <div class="card-header bg-gradient-to-r from-blue-600 to-sky-500 text-white px-4 py-2 flex justify-between items-center relative">
        <div class="absolute inset-0 bg-white/10 bg-[url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"dots\" width=\"10\" height=\"10\" patternUnits=\"userSpaceOnUse\"><circle cx=\"5\" cy=\"5\" r=\"1\" fill=\"white\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23dots)\"/></svg>')]"></div>
        
        <div class="company-logo font-bold {{ $size === 'mini' ? 'text-sm' : 'text-base' }} relative z-10">
            {{ config('app.name', 'Company Name') }}
        </div>
        <div class="card-type text-xs font-medium opacity-90 relative z-10">
            EMPLOYEE ID
        </div>
    </div>

    <!-- Card Body -->
    <div class="card-body p-4 flex gap-4 h-full">
        <!-- Employee Photo -->
        <div class="employee-photo flex-shrink-0 flex flex-col items-center gap-2">
            <div class="photo-container {{ $photoSizes[$size] }} rounded-full overflow-hidden border-3 border-blue-600 shadow-md">
                @php
                    $photoUrl = null;
                    if ($employee->photo_path) {
                        $photoUrl = asset('storage/' . $employee->photo_path);
                    } elseif ($employee->user && $employee->user->profile_photo_path) {
                        $photoUrl = asset('storage/' . $employee->user->profile_photo_path);
                    }
                @endphp
                
                @if($photoUrl)
                    <img src="{{ $photoUrl }}" alt="{{ $employee->name }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-2xl\'><i class=\'fas fa-user\'></i></div>'">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 {{ $size === 'mini' ? 'text-lg' : 'text-2xl' }}">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Employee Info -->
        <div class="employee-info flex-1 flex flex-col justify-between">
            <div>
                <div class="employee-name {{ $fontSizes[$size]['name'] }} font-bold text-gray-800 mb-1 leading-tight">
                    {{ $employee->name }}
                </div>
                <div class="employee-id {{ $fontSizes[$size]['id'] }} text-blue-600 font-semibold mb-2">
                    ID: {{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            @if($showDetails)
            <div class="employee-details flex flex-col gap-1">
                <div class="detail-item flex items-center gap-2 {{ $fontSizes[$size]['detail'] }} text-gray-600">
                    <i class="fas fa-briefcase w-3 h-3 text-gray-400 flex-shrink-0"></i>
                    <span class="font-medium truncate">{{ $employee->position ?? 'N/A' }}</span>
                </div>
                <div class="detail-item flex items-center gap-2 {{ $fontSizes[$size]['detail'] }} text-gray-600">
                    <i class="fas fa-building w-3 h-3 text-gray-400 flex-shrink-0"></i>
                    <span class="font-medium truncate">{{ $employee->department ?? 'General' }}</span>
                </div>
                @if($size !== 'mini')
                <div class="detail-item flex items-center gap-2 {{ $fontSizes[$size]['detail'] }} text-gray-600">
                    <i class="fas fa-phone w-3 h-3 text-gray-400 flex-shrink-0"></i>
                    <span class="font-medium truncate">{{ $employee->mobile_no ?? 'N/A' }}</span>
                </div>
                <div class="detail-item flex items-center gap-2 {{ $fontSizes[$size]['detail'] }} text-gray-600">
                    <i class="fas fa-envelope w-3 h-3 text-gray-400 flex-shrink-0"></i>
                    <span class="font-medium truncate">{{ $employee->email }}</span>
                </div>
                @endif
                @if($employee->joining_date && $size === 'standard')
                <div class="detail-item flex items-center gap-2 {{ $fontSizes[$size]['detail'] }} text-gray-600">
                    <i class="fas fa-calendar w-3 h-3 text-gray-400 flex-shrink-0"></i>
                    <span class="font-medium">Joined: {{ \Carbon\Carbon::parse($employee->joining_date)->format('M Y') }}</span>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- QR Code -->
        @if($showQr)
        <div class="qr-section flex flex-col items-center gap-1">
            @php
                $qrSize = $size === 'mini' ? 40 : ($size === 'compact' ? 50 : 60);
            @endphp
            <div class="qr-code w-{{ $qrSize/4 }} h-{{ $qrSize/4 }} border border-gray-200 rounded flex items-center justify-center bg-white" style="width: {{ $qrSize }}px; height: {{ $qrSize }}px;">
                @php
                    $qrData = route('employees.show', $employee);
                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize}x{$qrSize}&data=" . urlencode($qrData);
                @endphp
                <img src="{{ $qrUrl }}" alt="QR Code" class="w-full h-full rounded" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-50 flex items-center justify-center text-gray-400 text-xs text-center leading-tight\'>{{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>'">
            </div>
            <div class="qr-label text-xs text-gray-500 text-center font-medium">
                Scan to Verify
            </div>
        </div>
        @endif
    </div>

    <!-- Card Footer -->
    <div class="card-footer absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 via-sky-500 to-emerald-500"></div>

    <!-- Actions Overlay (appears on hover) -->
    @if($showActions)
    <div class="actions-overlay absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
        <a href="{{ route('employees.id-card.show', $employee) }}" class="action-btn bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center gap-2">
            <i class="fas fa-eye"></i>
            View
        </a>
        <button onclick="printIdCard('{{ $employee->id }}')" class="action-btn bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center gap-2">
            <i class="fas fa-print"></i>
            Print
        </button>
        <a href="{{ route('employees.id-card.pdf', $employee) }}" class="action-btn bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center gap-2">
            <i class="fas fa-download"></i>
            PDF
        </a>
    </div>
    @endif
</div>

@if($showActions)
<script>
function printIdCard(employeeId) {
    const printWindow = window.open(`/employees/${employeeId}/id-card`, '_blank');
    printWindow.onload = function() {
        printWindow.print();
    };
}
</script>
@endif