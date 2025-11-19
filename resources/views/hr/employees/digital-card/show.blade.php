@extends('layouts.macos')
@section('page_title', 'Digital Card - ' . $employee->name)

@section('content')
<div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success" style="background:#d4edda;color:#155724;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #c3e6cb;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger" style="background:#f8d7da;color:#721c24;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #f5c6cb;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info" style="background:#d1ecf1;color:#0c5460;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #bee5eb;">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
            </div>
        @endif
        
        <div class="text-center">
            <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0;font-size:24px;">
                Digital Card - {{ $employee->name }}
            </h3>
            
            <div style="margin: 30px 0;">
                <a href="{{ url('view_digital_card_modern.php?um_id=' . $employee->id) }}" 
                   class="hrp-btn hrp-btn-primary" 
                   target="_blank"
                   style="margin-right: 15px;">
                    <i class="fas fa-eye"></i> View Digital Card
                </a>
                
                <a href="{{ route('employees.digital-card.edit', $employee) }}" 
                   class="hrp-btn hrp-btn-secondary">
                    <i class="fas fa-edit"></i> Edit Card
                </a>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <p style="color: #6c757d; margin: 0;">
                    <i class="fas fa-info-circle"></i> 
                    Your digital card is ready! Click "View Digital Card" to see the modern view.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-redirect to the modern view after 2 seconds
setTimeout(function() {
    window.open('{{ url('view_digital_card_modern.php?um_id=' . $employee->id) }}', '_blank');
}, 2000);
</script>
@endsection

@section('breadcrumb')
<a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
<span class="hrp-bc-sep">›</span>
<a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employees</a>
<span class="hrp-bc-sep">›</span>
<span class="hrp-bc-current">Digital Card</span>
@endsection