@extends('layouts.macos')

@section('page_title', 'Create New Letter - ' . $employee->name)

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<style>
    /* Summernote Custom Styling */
    .note-editor {
        border: 1px solid #d2d6de !important;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    .note-toolbar {
        background-color: #f9f9f9 !important;
        border-bottom: 1px solid #d2d6de !important;
        padding: 5px !important;
    }
    .note-btn-group .btn {
        padding: 5px 8px !important;
        background: #fff !important;
        border: 1px solid #ddd !important;
        color: #333 !important;
        font-size: 12px !important;
        line-height: 1.2 !important;
        margin-right: 2px !important;
        margin-bottom: 3px !important;
    }
    .note-btn-group .btn:hover {
        background-color: #e9ecef !important;
    }
    .note-btn-group .dropdown-toggle::after {
        vertical-align: middle !important;
    }
    .note-editable {
        min-height: 200px;
        padding: 15px !important;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        line-height: 1.6;
    }
    /* Make sure the modal appears above other elements */
    .note-modal {
        z-index: 1050 !important;
    }
    .note-modal-backdrop {
        z-index: 1040 !important;
    }
    /* Smaller toolbar icons */
    .note-toolbar .note-btn i {
        font-size: 14px !important;
    }
    /* Set minimum heights for editors */
    #content + .note-editor {
        min-height: 200px !important;
    }
    #content + .note-editor .note-editable {
        min-height: 200px !important;
    }
    #notes + .note-editor {
        min-height: 225px !important;
    }
    #notes + .note-editor .note-editable {
        min-height: 200px !important;
    }
    /* Ensure termination fields use full width */
    #terminationFields {
        width: 100% !important;
        grid-column: 1 / -1 !important;
    }
</style>
@endpush

@section('content')
<div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
        <form method="POST" action="{{ isset($letter) ? route('employees.letters.update', ['employee'=>$employee, 'letter'=>$letter]) : route('employees.letters.store', $employee) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="letterForm">
            @csrf
            @if(isset($letter))
                @method('PUT')
            @endif
            
            <div>
                <label class="hrp-label">Employee Name:</label>
                <input type="text" class="hrp-input Rectangle-29" value="{{ $employee->name }}" readonly>
            </div>
            
            <div>
                <label class="hrp-label">Employee ID:</label>
                <input type="text" class="hrp-input Rectangle-29" value="{{ $employee->code }}" readonly>
            </div>
            
            <div>
                <label class="hrp-label">Reference Number: <span class="text-red-500">*</span></label>
                <div class="flex">
                    <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number', $referenceNumber) }}" 
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
                    @php($t = old('type', isset($letter) ? $letter->type : ''))
                    <option value="">-- Select Type --</option>
                    <option value="offer" {{ $t == 'offer' ? 'selected' : '' }}>Offer Letter</option>
                    <option value="joining" {{ $t == 'joining' ? 'selected' : '' }}>Joining Letter</option>
                    <option value="confidentiality" {{ $t == 'confidentiality' ? 'selected' : '' }}>Confidentiality Letter</option>
                    <option value="impartiality" {{ $t == 'impartiality' ? 'selected' : '' }}>Impartiality Letter</option>
                    <option value="experience" {{ $t == 'experience' ? 'selected' : '' }}>Experience Letter</option>
                    <option value="agreement" {{ $t == 'agreement' ? 'selected' : '' }}>Agreement Letter</option>
                    <option value="warning" {{ $t == 'warning' ? 'selected' : '' }}>Warning Letter</option>
                    <option value="termination" {{ $t == 'termination' ? 'selected' : '' }}>Termination Letter</option>
                    <option value="increment" {{ $t == 'increment' ? 'selected' : '' }}>Increment Letter</option>
                    <option value="internship_offer" {{ $t == 'internship_offer' ? 'selected' : '' }}>Internship Offer Letter</option>
                    <option value="internship_letter" {{ $t == 'internship_letter' ? 'selected' : '' }}>Internship Letter</option>
                    <option value="other" {{ $t == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('type')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div>
                <label class="hrp-label">Title: <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" class="hrp-input Rectangle-29" 
                       placeholder="Enter letter title" value="{{ old('title', isset($letter)?$letter->title:'') }}" required>
                @error('title')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div>
                <label class="hrp-label">Issue Date: <span class="text-red-500">*</span></label>
                <input type="date" name="issue_date" id="issue_date" class="hrp-input Rectangle-29" 
                       value="{{ old('issue_date', isset($letter) ? optional($letter->issue_date)->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                @error('issue_date')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <!-- Experience Letter Fields -->
            <div id="experienceFields" class="hidden col-span-2 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="hrp-label">Start Date: <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="hrp-input Rectangle-29" 
                               value="{{ old('start_date', isset($letter)?optional($letter->start_date)->format('Y-m-d'):optional($employee->joining_date)->format('Y-m-d')) }}">
                        @error('start_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">End Date: <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="hrp-input Rectangle-29" 
                               value="{{ old('end_date', isset($letter)?optional($letter->end_date)->format('Y-m-d'):now()->format('Y-m-d')) }}">
                        @error('end_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Termination Letter Fields -->
            <div id="terminationFields" class="hidden col-span-2 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="hrp-label">Termination Date (Last Working Day): <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="termination_date" class="hrp-input Rectangle-29" 
                               value="{{ old('end_date', isset($letter)?optional($letter->end_date)->format('Y-m-d'):null) }}">
                        <small class="text-xs text-gray-500">Employee's last working day</small>
                        @error('end_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">Notes:</label>
                        <input type="text" name="notes" id="termination_notes" class="hrp-input Rectangle-29" 
                               placeholder="Additional notes" value="{{ old('notes') }}">
                        @error('notes')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="hrp-label">Reason for Termination:</label>
                    <small class="text-xs text-gray-500">Maximum 10,000 characters. Content over 2,000 characters will use smaller font in print.</small>
                    <textarea name="content" id="termination_reason" class="form-control summernote-notes w-full" 
                             placeholder="Enter detailed reason for termination (e.g., consistently low performance despite prior discussions and performance improvement plans)" style="min-height: 200px;">{{ old('content', isset($letter) ? $letter->content : '') }}</textarea>
                    @error('content')
                        <small class="hrp-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Increment Letter Fields -->
            <div id="incrementFields" class="hidden col-span-2 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="hrp-label">Current Salary: <span class="text-red-500">*</span></label>
                        <input type="number" name="monthly_salary" id="current_salary" class="hrp-input Rectangle-29" 
                               placeholder="Current monthly salary" value="{{ old('monthly_salary', isset($letter)?$letter->monthly_salary:'') }}">
                        @error('monthly_salary')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">New Salary: <span class="text-red-500">*</span></label>
                        <input type="number" name="increment_amount" id="new_salary" class="hrp-input Rectangle-29" 
                               placeholder="New monthly salary" value="{{ old('increment_amount', isset($letter)?$letter->increment_amount:'') }}">
                        @error('increment_amount')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">Effective Date: <span class="text-red-500">*</span></label>
                        <input type="date" name="increment_effective_date" id="increment_effective_date" class="hrp-input Rectangle-29" 
                               value="{{ old('increment_effective_date', isset($letter)?optional($letter->increment_effective_date)->format('Y-m-d'):null) }}">
                        @error('increment_effective_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Internship Offer Letter Fields -->
            <div id="internshipOfferFields" class="hidden col-span-2 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="hrp-label">Position: <span class="text-red-500">*</span></label>
                        <input type="text" name="internship_position" id="internship_position" class="hrp-input Rectangle-29" 
                               placeholder="e.g., Full Stack Developer" value="{{ old('internship_position', isset($letter)?$letter->internship_position:'') }}">
                        @error('internship_position')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">Start Date:</label>
                        <input type="date" name="internship_start_date" id="internship_start_date" class="hrp-input Rectangle-29" 
                               value="{{ old('internship_start_date', isset($letter)?optional($letter->internship_start_date)->format('Y-m-d'):null) }}">
                        @error('internship_start_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">End Date:</label>
                        <input type="date" name="internship_end_date" id="internship_end_date" class="hrp-input Rectangle-29" 
                               value="{{ old('internship_end_date', isset($letter)?optional($letter->internship_end_date)->format('Y-m-d'):null) }}">
                        @error('internship_end_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="hrp-label">Address:</label>
                    <textarea name="internship_address" id="internship_address" class="hrp-input Rectangle-29" rows="3" 
                             placeholder="Enter complete address">{{ old('internship_address', isset($letter)?$letter->internship_address:'') }}</textarea>
                    @error('internship_address')
                        <small class="hrp-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Internship Letter Fields -->
            <div id="internshipLetterFields" class="hidden col-span-2 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="hrp-label">Position: <span class="text-red-500">*</span></label>
                        <input type="text" name="internship_position" id="internship_letter_position" class="hrp-input Rectangle-29" 
                               placeholder="e.g., Developer" value="{{ old('internship_position') }}">
                        @error('internship_position')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">Start Date: <span class="text-red-500">*</span></label>
                        <input type="date" name="internship_start_date" id="internship_letter_start_date" class="hrp-input Rectangle-29" 
                               value="{{ old('internship_start_date') }}">
                        @error('internship_start_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label class="hrp-label">End Date:</label>
                        <input type="date" name="internship_end_date" id="internship_letter_end_date" class="hrp-input Rectangle-29" 
                               value="{{ old('internship_end_date') }}">
                        @error('internship_end_date')
                            <small class="hrp-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Warning Letter Fields -->
            <div id="warningFields" class="hidden col-span-2 space-y-4">
                <div>
                    <label class="hrp-label">Warning Content: <span class="text-red-500">*</span></label>
                    <small class="text-xs text-gray-500">Maximum 10,000 characters. Content over 2,000 characters will use smaller font in print.</small>
                    <textarea name="content" id="warning_content" class="form-control summernote-notes w-full" 
                             placeholder="Enter detailed warning content (e.g., specific issues, expected improvements, consequences)" style="min-height: 200px;">{{ old('content', isset($letter) ? $letter->content : '') }}</textarea>
                    @error('content')
                        <small class="hrp-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Other Letter Fields -->
            <div id="otherFields" class="hidden col-span-2 space-y-4">
                <div>
                    <label class="hrp-label">Subject: <span class="text-red-500">*</span></label>
                    <input type="text" id="other_subject" class="hrp-input Rectangle-29" 
                           placeholder="Enter letter subject" value="{{ old('subject', isset($letter)?$letter->subject:'') }}">
                    @error('subject')
                        <small class="hrp-error">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label class="hrp-label">Content: <span class="text-red-500">*</span></label>
                    <small class="text-xs text-gray-500">Maximum 10,000 characters. Content over 2,000 characters will use smaller font in print.</small>
                    <textarea name="content" id="other_content" class="form-control summernote w-full" 
                             placeholder="Enter letter content" style="min-height: 300px;">{{ old('content', isset($letter) ? $letter->content : '') }}</textarea>
                    @error('content')
                        <small class="hrp-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Standard Letter Fields -->
            <div id="standardLetterFields">
                <div class="col-span-2 mt-4">
                    <label class="hrp-label">Notes:</label>
                    <input type="text" name="notes" id="notes" class="hrp-input Rectangle-29" 
                           placeholder="Any additional notes about this letter" value="{{ old('notes', isset($letter)?$letter->notes:'') }}">
                    @error('notes')
                        <small class="hrp-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <!-- Offer Letter Specific Fields (Initially Hidden) -->
            <div id="offerLetterFields" class="hidden md:col-span-2 space-y-4">
                <div class="p-6">
                   
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="hrp-label">Monthly Salary:</label>
                            <input type="text" name="monthly_salary" class="hrp-input Rectangle-29 w-full" placeholder="e.g., 50,000">
                        </div>
                        <div>
                            <label class="hrp-label">Annual CTC:</label>
                            <input type="text" name="annual_ctc" class="hrp-input Rectangle-29 w-full" placeholder="e.g., 6,00,000">
                        </div>
                        <div>
                            <label class="hrp-label">Reporting Manager:</label>
                            <input type="text" name="reporting_manager" class="hrp-input Rectangle-29 w-full" placeholder="e.g., John Doe">
                        </div>
                        <div>
                            <label class="hrp-label">Working Hours:</label>
                            <input type="text" name="working_hours" class="hrp-input Rectangle-29 w-full" placeholder="e.g., 9:30 AM to 6:30 PM">
                        </div>
                        <div>
                            <label class="hrp-label">Date of Joining:</label>
                            <input type="date" name="date_of_joining" class="hrp-input Rectangle-29 w-full" id="joiningDate">
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                                            <div class="md:col-span-2">
                            <label class="hrp-label">Probation Period (bulleted lines):</label>
                            <textarea name="probation_period" rows="4" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter each point on new line">{{ old('probation_period', isset($letter)?$letter->probation_period:'') }}</textarea>
                            @error('probation_period')<small class="hrp-error">{{ $message }}</small>@enderror
                            </div>

                            <div class="md:col-span-2">
                            <label class="hrp-label">Salary & Increment (bulleted lines):</label>
                            <textarea name="salary_increment" rows="4" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter each point on new line">{{ old('salary_increment', isset($letter)?$letter->salary_increment:'') }}</textarea>
                            @error('salary_increment')<small class="hrp-error">{{ $message }}</small>@enderror
                            </div>
                    </div>
                    
                  
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="hrp-actions">
                    <button type="submit" class="hrp-btn hrp-btn-primary" id="submitBtn">
                        <i class="fas fa-save mr-1"></i> {{ isset($letter) ? 'Update Letter' : 'Save Letter' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
// Function to add probation field
function addProbationField() {
    const container = document.getElementById('probationFields');
    const newField = `
        <div class="flex items-center gap-2">
            <input type="text" name="probation_period[]" class="hrp-input Rectangle-29 flex-1" placeholder="Enter probation point">
            <button type="button" class="text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-red-50 transition-colors" onclick="removeField(this, 'probation')" title="Remove this point">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>`;
    container.insertAdjacentHTML('beforeend', newField);
}

// Function to add salary field
function addSalaryField() {
    const container = document.getElementById('salaryIncrementFields');
    const newField = `
        <div class="flex items-center gap-2">
            <input type="text" name="salary_increment[]" class="hrp-input Rectangle-29 flex-1" placeholder="Enter salary/increment point">
            <button type="button" class="text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-red-50 transition-colors" onclick="removeField(this, 'salary')" title="Remove this point">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>`;
    container.insertAdjacentHTML('beforeend', newField);
}

// Function to remove field
function removeField(button, type) {
    button.closest('.flex').remove();
}

// Set today's date as default for issue date
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const issueDateEl = document.getElementById('issue_date');
    if (issueDateEl) issueDateEl.value = today;
    
    // Set default joining date to 7 days from now (only if field exists)
    const joiningEl = document.getElementById('joiningDate');
    if (joiningEl) {
        const nextWeek = new Date();
        nextWeek.setDate(nextWeek.getDate() + 7);
        joiningEl.value = nextWeek.toISOString().split('T')[0];
    }
});

// Toggle fields based on letter type selection
$(document).on('change', 'select[name="type"]', function() {

    const offerLetterFields = document.getElementById('offerLetterFields');
    const experienceFields = document.getElementById('experienceFields');
    const terminationFields = document.getElementById('terminationFields');
    const incrementFields = document.getElementById('incrementFields');
    const internshipOfferFields = document.getElementById('internshipOfferFields');
    const internshipLetterFields = document.getElementById('internshipLetterFields');
    const warningFields = document.getElementById('warningFields');
    const otherFields = document.getElementById('otherFields');
    const standardFields = document.getElementById('standardLetterFields');
    const submitBtn = document.getElementById('submitBtn');
    
    // Hide all fields first
    offerLetterFields.classList.add('hidden');
    experienceFields.classList.add('hidden');
    terminationFields.classList.add('hidden');
    incrementFields.classList.add('hidden');
    internshipOfferFields.classList.add('hidden');
    internshipLetterFields.classList.add('hidden');
    warningFields.classList.add('hidden');
    otherFields.classList.add('hidden');
    standardFields.classList.add('hidden');
    
    if (this.value === 'offer') {
        offerLetterFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-file-pdf mr-1"></i> Generate & Save Letter';
    } else if (this.value === 'experience') {
        experienceFields.classList.remove('hidden');
        standardFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else if (this.value === 'termination') {
        terminationFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else if (this.value === 'warning') {
        document.getElementById('warningFields').classList.remove('hidden');
        standardFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else if (this.value === 'increment') {
        incrementFields.classList.remove('hidden');
        standardFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else if (this.value === 'internship_offer') {
        internshipOfferFields.classList.remove('hidden');
        standardFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else if (this.value === 'internship_letter') {
        internshipLetterFields.classList.remove('hidden');
        standardFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else if (this.value === 'other') {
        otherFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else if (this.value) {
        standardFields.classList.remove('hidden');
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    } else {
        submitBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Save Letter';
    }

    // Ensure only the visible content textarea is submitted as 'content'
    const mapping = {
      warning: 'warning_content',
      termination: 'termination_reason',
      other: 'other_content'
    };
    const ids = ['warning_content','termination_reason','other_content'];
    ids.forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;
      // Temporarily remove name so it doesn't get posted
      el.setAttribute('data-orig-name', el.getAttribute('name') || '');
      el.removeAttribute('name');
    });
    const selectedId = mapping[this.value];
    if (selectedId) {
      const active = document.getElementById(selectedId);
      if (active) active.setAttribute('name','content');
    }

    // Toggle subject name only for 'other' type so it isn't posted for other types
    const subj = document.getElementById('other_subject');
    if (subj) {
      if (this.value === 'other') {
        subj.setAttribute('name','subject');
      } else {
        subj.removeAttribute('name');
      }
    }

    // Toggle required attributes for common cases
    const req = (id, on) => { const el = document.getElementById(id); if (el) on ? el.setAttribute('required','required') : el.removeAttribute('required'); };
    // Base required
    req('title', true); req('issue_date', true);
    // Per-type requirements
    req('start_date', this.value==='experience');
    req('end_date', this.value==='experience');
    req('termination_date', this.value==='termination');
    req('other_subject', this.value==='other');
    // Content required for warning/termination/other
    req('warning_content', this.value==='warning');
    req('termination_reason', this.value==='termination');
    req('other_content', this.value==='other');
});
// Trigger change event on page load to set initial state
$('select[name="type"]').trigger('change');

$(document).ready(function() {
    // Initialize Summernote for Letter Content
    $('.summernote').summernote({
        height: 200,
        focus: true,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['misc', ['undo', 'redo']]
        ],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
        callbacks: {
            onInit: function() {
                $('.note-editable').focus();
            }
        },
        styleTags: [
            'p',
            { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
            'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
        ]
    });

    // Initialize a simpler Summernote for Notes
    $('.summernote-notes').summernote({
        height: 225,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol']],
            ['insert', ['link']]
        ],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18'],
        styleTags: ['p', 'h4', 'h5', 'h6']
    });

    // Generate new reference number
    $('#generateRefBtn').click(function() {
        $.ajax({
            url: '{{ route("employees.letters.generate-reference") }}',
            type: 'GET',
            success: function(response) {
                $('#reference_number').val(response.reference_number);
            },
            error: function() {
                toastr.error('Error generating reference number');
            }
        });
    });

    // Auto-populate content based on letter type
    $('#type').change(function() {
        var letterType = $(this).val();
        var companyName = 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
        
        var templates = {
            'joining': 'Subject: Welcome to ' + companyName,
            'confidentiality': 'Subject: Confidentiality Agreement',
            'impartiality': 'Subject: Impartiality Agreement', 
            'experience': 'Subject: Experience Certificate',
            'agreement': 'Subject: Employment Agreement',
            'warning': 'Subject: Warning Notice',
            'termination': 'Subject: Termination of Employment'
        };
        
        if (templates[letterType]) {
            $('#title').val(templates[letterType]);
        }
    });

    // Handle form submission
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        $('.summernote, .summernote-notes').each(function() {
            var content = $(this).summernote('code');
            // Decode HTML entities to prevent double encoding
            var tempDiv = $('<div>').html(content);
            $(this).val(tempDiv.html());
        });
        
        var formData = new FormData(this);
        var url = $(this).attr('action');
        
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        $('.hrp-error').text('').hide();
        $('.is-invalid').removeClass('is-invalid');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    window.location.reload();
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    console.error('Validation errors:', errors);
                    $.each(errors, function(field, messages) {
                        var input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        var errorContainer = input.siblings('.hrp-error');
                        if (errorContainer.length === 0) {
                            errorContainer = $('<small class="hrp-error text-red-500 text-xs"></small>');
                            input.after(errorContainer);
                        }
                        errorContainer.html(messages[0]).show();
                    });
                    // Scroll to first error field
                    var firstKey = Object.keys(errors)[0];
                    var firstEl = $('[name="' + firstKey + '"]');
                    if (firstEl && firstEl.length) {
                        $('html, body').animate({ scrollTop: Math.max(0, firstEl.offset().top - 120) }, 300);
                        firstEl.focus();
                    }
                } else {
                    var errorMsg = xhr.responseJSON && xhr.responseJSON.message 
                        ? xhr.responseJSON.message 
                        : 'An error occurred while saving. Please try again.';
                    toastr.error(errorMsg);
                }
            }
        });
    });
    
    // Content length validation and warning
    function checkContentLength() {
        const contentFields = ['warning_content', 'termination_reason', 'other_content'];
        
        contentFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field) return;
            
            const checkLength = () => {
                const content = $(field).summernote('code');
                const textContent = $('<div>').html(content).text();
                const length = textContent.length;
                
                // Remove existing warning
                const existingWarning = field.parentElement.querySelector('.content-length-warning');
                if (existingWarning) existingWarning.remove();
                
                if (length > 10000) {
                    // Show error - exceeds max
                    const warning = document.createElement('div');
                    warning.className = 'content-length-warning text-red-600 text-sm mt-2 font-semibold';
                    warning.innerHTML = `<i class="fas fa-exclamation-circle"></i> Content is too long (${length}/10000 characters). Please reduce content to save.`;
                    field.parentElement.appendChild(warning);
                    return false;
                } else if (length > 3000) {
                    // Show warning - will use smaller font
                    const warning = document.createElement('div');
                    warning.className = 'content-length-warning text-orange-600 text-sm mt-2';
                    warning.innerHTML = `<i class="fas fa-info-circle"></i> Large content (${length} characters). Font size will be reduced in print for better fit.`;
                    field.parentElement.appendChild(warning);
                } else if (length > 2000) {
                    // Show info - will use slightly smaller font
                    const warning = document.createElement('div');
                    warning.className = 'content-length-warning text-blue-600 text-sm mt-2';
                    warning.innerHTML = `<i class="fas fa-info-circle"></i> Content length: ${length} characters. Font will be slightly reduced in print.`;
                    field.parentElement.appendChild(warning);
                }
                return true;
            };
            
            // Check on change
            $(field).on('summernote.change', checkLength);
        });
    }
    
    // Initialize content length checking after summernote is ready
    setTimeout(checkContentLength, 1000);
});
</script>
@endpush

@endsection

