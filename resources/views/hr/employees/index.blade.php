@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="flex items-center justify-between mb-3">
        <h2 class="hrp-page-title">Employee List</h2>
        @can('employees.create')
          <a href="{{ route('employees.create') }}" class="hrp-btn hrp-btn-primary" style="border-radius:9999px;padding:10px 20px;font-weight:800">+ Add</a>
        @endcan
      </div>

      <div class="grid" style="display:grid;grid-template-columns:repeat(3, minmax(0,1fr));gap:20px">
        @php
          $staticImages = [
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face'
          ];
        @endphp
        
        @forelse($employees as $emp)
          <div class="emp-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:20px;box-shadow:0 2px 8px rgba(0,0,0,.08);padding:20px;display:flex;flex-direction:column;gap:16px;position:relative">
            <!-- Top Row: Badge and 3 Dots -->
            <div style="display:flex;align-items:flex-start;justify-content:space-between">
              @php($isModel = $emp instanceof \App\Models\Employee)
              @if($emp->experience_type ?? false)
                <span style="background:#f8d7da;color:#721c24;font-weight:600;font-size:12px;padding:6px 12px;border-radius:12px;">{{ $emp->experience_type }}</span>
              @else
                <span style="background:#f8d7da;color:#721c24;font-weight:600;font-size:12px;padding:6px 12px;border-radius:12px;">Full - Time</span>
              @endif
              
              <div class="dropdown" style="position:relative">
                <button class="dropdown-toggle" onclick="toggleDropdown({{ $loop->index }})" style="width:32px;height:32px;border-radius:50%;background:#f1f3f4;border:0;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;font-size:16px" title="More options">⋮</button>
                <div id="dropdown-{{ $loop->index }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;background:white;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:1000;min-width:120px;padding:4px 0;margin-top:4px">
                  @if($isModel)
                    <a href="{{ route('employees.edit', $emp) }}" style="display:flex;align-items:center;gap:8px;padding:8px 12px;color:#374151;text-decoration:none;font-size:14px;font-weight:500" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                      <span style="font-size:16px">✏️</span> Edit
                    </a>
                    <form method="POST" action="{{ route('employees.destroy', $emp) }}" onsubmit="return confirm('Delete employee?')" style="margin:0">
                      @csrf @method('DELETE')
                      <button type="submit" style="width:100%;display:flex;align-items:center;gap:8px;padding:8px 12px;color:#ef4444;background:transparent;border:0;text-align:left;font-size:14px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                        <span style="font-size:16px">🗑️</span> Delete
                      </button>
                    </form>
                  @else
                    <span style="display:flex;align-items:center;gap:8px;padding:8px 12px;color:#9ca3af;font-size:14px;font-weight:500">
                      <span style="font-size:16px">✏️</span> Edit (Demo)
                    </span>
                    <span style="display:flex;align-items:center;gap:8px;padding:8px 12px;color:#9ca3af;font-size:14px;font-weight:500">
                      <span style="font-size:16px">🗑️</span> Delete (Demo)
                    </span>
                  @endif
                </div>
              </div>
            </div>

            <!-- Profile Section -->
            <div style="display:flex;align-items:center;gap:16px">
              <div style="width:60px;height:60px;border-radius:50%;overflow:hidden;background:#f3f4f6;flex:0 0 60px">
                @php($imageIndex = $loop->index % count($staticImages))
                @if(isset($emp->photo_path) && $emp->photo_path)
                  <img src="{{ asset('storage/'.$emp->photo_path) }}" alt="{{ $emp->name }}" style="width:60px;height:60px;object-fit:cover;display:block">
                @else
                  <img src="{{ $staticImages[$imageIndex] }}" alt="{{ $emp->name }}" style="width:60px;height:60px;object-fit:cover;display:block">
                @endif
              </div>
              <div style="min-width:0;flex:1">
                <h3 style="font-weight:700;color:#2d3748;font-size:18px;line-height:1.3;margin:0 0 4px 0">{{ $emp->name }}</h3>
                <p style="color:#718096;font-weight:400;font-size:14px;line-height:1.3;margin:0;word-break:break-all">{{ $emp->email }}</p>
              </div>
            </div>

            <!-- Tags Section -->
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
              <div style="display:flex;align-items:center;gap:6px;background:#f7fafc;padding:6px 12px;border-radius:12px">
                <div style="width:8px;height:8px;background:#e53e3e;border-radius:50%"></div>
                <span style="color:#2d3748;font-weight:500;font-size:13px">Designer</span>
              </div>
              <span style="color:#718096;font-weight:500;font-size:13px">{{ $emp->position ?? 'Sr. UI/UX Designer' }}</span>
            </div>

            <!-- Bottom Info -->
            <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-top:8px">
              <div>
                <div style="color:#718096;font-size:13px;font-weight:500;margin-bottom:2px">Payroll</div>
                <div style="color:#718096;font-size:13px;font-weight:500">Join Date</div>
              </div>
              <div style="text-align:right">
                <div style="color:#2d3748;font-size:13px;font-weight:600;margin-bottom:2px">{{ $emp->code ?? 'ABDPF1835R' }} | {{ isset($emp->current_offer_amount) ? number_format($emp->current_offer_amount,0) : '27,000' }}</div>
                <div style="color:#2d3748;font-size:13px;font-weight:600">{{ isset($emp->joining_date) ? $emp->joining_date->format('d M,Y') : '23 Feb,2025' }}</div>
              </div>
            </div>
          </div>
        @empty
          <div class="text-center" style="color:#6b7280;font-weight:700">No employees found</div>
        @endforelse
      </div>

    </div>
  </div>
@endsection

@push('styles')
<style>
  @media (max-width: 1200px){ .grid{ grid-template-columns: repeat(2, minmax(0,1fr)) !important; } }
  @media (max-width: 768px){ .grid{ grid-template-columns: repeat(1, minmax(0,1fr)) !important; } }
  .dropdown-menu { transition: all 0.2s ease; }
  .dropdown-menu.show { display: block !important; }
</style>
@endpush

@push('scripts')
<script>
function toggleDropdown(index) {
  // Close all other dropdowns
  document.querySelectorAll('.dropdown-menu').forEach(menu => {
    if (menu.id !== `dropdown-${index}`) {
      menu.style.display = 'none';
    }
  });
  
  // Toggle current dropdown
  const dropdown = document.getElementById(`dropdown-${index}`);
  dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  if (!event.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      menu.style.display = 'none';
    });
  }
});
</script>
@endpush