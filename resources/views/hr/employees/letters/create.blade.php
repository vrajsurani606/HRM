@extends('layouts.macos')

@section('page_title', 'Create New Letter - ' . $employee->name)

@section('content')
<div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
        <form method="POST" action="{{ route('employees.letters.store', $employee) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="letterForm">
            @csrf
            
            
            <div>
                <label class="hrp-label">Employee Name:</label>
                <input type="text" class="hrp-input Rectangle-29" value="{{ $employee->name }}" readonly>
            </div>
            
            <div>
                <label class="hrp-label">Employee ID:</label>
                <input type="text" class="hrp-input Rectangle-29" value="{{ $employee->employee_id }}" readonly>
            </div>
            
            <div>
                <label class="hrp-label">Reference Number: <span class="text-red-500">*</span></label>
                <div class="flex">
                    <input type="text" name="reference_number" id="reference_number" value="{{ $referenceNumber }}" 
                           class="hrp-input Rectangle-29 flex-grow" readonly>
                    <button type="button" id="generateRefBtn" class="ml-2 px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <small class="text-xs text-gray-500">Auto-generated reference number</small>
                @error('reference_number')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div>
                <label class="hrp-label">Letter Type: <span class="text-red-500">*</span></label>
                <select name="type" id="type" class="hrp-input Rectangle-29" required>
                    <option value="appointment" {{ old('type') == 'appointment' ? 'selected' : '' }}>Appointment Letter</option>
                    <option value="offer" {{ old('type') == 'offer' ? 'selected' : '' }}>Offer Letter</option>
                    <option value="experience" {{ old('type') == 'experience' ? 'selected' : '' }}>Experience Letter</option>
                    <option value="relieving" {{ old('type') == 'relieving' ? 'selected' : '' }}>Relieving Letter</option>
                    <option value="confirmation" {{ old('type') == 'confirmation' ? 'selected' : '' }}>Confirmation Letter</option>
                    <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Warning Letter</option>
                    <option value="termination" {{ old('type') == 'termination' ? 'selected' : '' }}>Termination Letter</option>
                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('type')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div>
                <label class="hrp-label">Title: <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" class="hrp-input Rectangle-29" 
                       placeholder="Enter letter title" value="{{ old('title') }}" required>
                @error('title')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div>
                <label class="hrp-label">Issue Date: <span class="text-red-500">*</span></label>
                <input type="date" name="issue_date" id="issue_date" class="hrp-input Rectangle-29" 
                       value="{{ old('issue_date', now()->format('Y-m-d')) }}" required>
                @error('issue_date')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="hrp-label">Letter Content: <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" class="hrp-textarea" rows="10" required>{{ old('content') }}</textarea>
                @error('content')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="hrp-label">Notes:</label>
                <textarea name="notes" id="notes" class="hrp-textarea" rows="3" 
                          placeholder="Any additional notes about this letter">{{ old('notes') }}</textarea>
                @error('notes')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="col-span-2 flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button type="submit" class="hrp-btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Letter
                </button>
            </div>
        </form>
    </div>
</div>

@endsection