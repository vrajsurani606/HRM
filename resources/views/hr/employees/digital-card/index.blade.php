@extends('layouts.macos')
@section('page_title', 'Digital Cards - ' . $employee->name)

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Digital Cards for {{ $employee->name }}</h3>
            <div class="header-actions">
                <a href="{{ route('employees.digital-card.create', $employee) }}" class="btn btn-primary">Add New Card</a>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to Employees</a>
            </div>
        </div>
        
        <div class="card-body">
            @if($digitalCards->count() > 0)
                <div class="cards-grid">
                    @foreach($digitalCards as $card)
                        <div class="digital-card-item">
                            <div class="card-type-badge {{ strtolower($card->card_type) }}">
                                {{ ucwords(str_replace('_', ' ', $card->card_type)) }}
                            </div>
                            
                            <div class="card-details">
                                <div class="card-number">{{ $card->card_number }}</div>
                                <div class="card-dates">
                                    <span>Issued: {{ \Carbon\Carbon::parse($card->issue_date)->format('d M Y') }}</span>
                                    @if($card->expiry_date)
                                        <span>Expires: {{ \Carbon\Carbon::parse($card->expiry_date)->format('d M Y') }}</span>
                                    @endif
                                </div>
                                <div class="card-status status-{{ $card->status }}">
                                    {{ ucfirst($card->status) }}
                                </div>
                                @if($card->notes)
                                    <div class="card-notes">{{ $card->notes }}</div>
                                @endif
                            </div>
                            
                            <div class="card-actions">
                                <button class="action-btn edit-btn" onclick="editCard({{ $card->id }})">
                                    <img src="{{ asset('action_icon/edit.svg') }}" width="16" height="16"> Edit
                                </button>
                                <button class="action-btn delete-btn" onclick="deleteCard({{ $card->id }})">
                                    <img src="{{ asset('action_icon/delete.svg') }}" width="16" height="16"> Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">💳</div>
                    <h4>No Digital Cards</h4>
                    <p>This employee doesn't have any digital cards yet.</p>
                    <a href="{{ route('employees.digital-card.create', $employee) }}" class="btn btn-primary">Create First Card</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.container { max-width: 1200px; margin: 0 auto; padding: 20px; }
.card { background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.card-header { padding: 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
.card-header h3 { margin: 0; font-size: 18px; font-weight: 600; }
.header-actions { display: flex; gap: 10px; }
.card-body { padding: 20px; }

.cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
.digital-card-item { border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; position: relative; }

.card-type-badge { 
    display: inline-block; 
    padding: 4px 8px; 
    border-radius: 4px; 
    font-size: 12px; 
    font-weight: 500; 
    margin-bottom: 12px; 
}
.card-type-badge.employee_id { background: #dbeafe; color: #1d4ed8; }
.card-type-badge.access_card { background: #dcfce7; color: #166534; }
.card-type-badge.business_card { background: #fce7f3; color: #be185d; }

.card-details { margin-bottom: 16px; }
.card-number { font-size: 16px; font-weight: 600; margin-bottom: 8px; }
.card-dates { font-size: 14px; color: #6b7280; margin-bottom: 8px; }
.card-dates span { display: block; }
.card-status { 
    display: inline-block; 
    padding: 2px 8px; 
    border-radius: 12px; 
    font-size: 12px; 
    font-weight: 500; 
    margin-bottom: 8px; 
}
.status-active { background: #dcfce7; color: #166534; }
.status-inactive { background: #f3f4f6; color: #374151; }
.status-suspended { background: #fee2e2; color: #b91c1c; }
.card-notes { font-size: 14px; color: #6b7280; font-style: italic; }

.card-actions { display: flex; gap: 8px; }
.action-btn { 
    display: flex; 
    align-items: center; 
    gap: 4px; 
    padding: 6px 12px; 
    border: 1px solid #d1d5db; 
    border-radius: 4px; 
    background: white; 
    font-size: 12px; 
    cursor: pointer; 
}
.action-btn:hover { background: #f9fafb; }
.delete-btn:hover { background: #fef2f2; border-color: #fecaca; }

.empty-state { text-align: center; padding: 60px 20px; }
.empty-icon { font-size: 48px; margin-bottom: 16px; }
.empty-state h4 { margin: 0 0 8px 0; font-size: 18px; font-weight: 600; }
.empty-state p { margin: 0 0 20px 0; color: #6b7280; }

.btn { padding: 10px 20px; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
.btn-primary { background: #3b82f6; color: white; }
.btn-primary:hover { background: #2563eb; }
.btn-secondary { background: #6b7280; color: white; }
.btn-secondary:hover { background: #4b5563; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function editCard(cardId) {
    // Implement edit functionality
    console.log('Edit card:', cardId);
}

function deleteCard(cardId) {
    Swal.fire({
        title: 'Delete this digital card?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/employees/{{ $employee->id }}/digital-card/${cardId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush