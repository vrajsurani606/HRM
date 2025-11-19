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
</style>
@endpush

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
                    <option value="offer" {{ old('type') == 'offer' ? 'selected' : '' }}>Offer Letter</option>
                    <option value="joining" {{ old('type') == 'joining' ? 'selected' : '' }}>Joining Letter</option>
                    <option value="confidentiality" {{ old('type') == 'confidentiality' ? 'selected' : '' }}>Confidentiality Letter</option>
                    <option value="impartiality" {{ old('type') == 'impartiality' ? 'selected' : '' }}>Impartiality Letter</option>
                    <option value="experience" {{ old('type') == 'experience' ? 'selected' : '' }}>Experience Letter</option>
                    <option value="agreement" {{ old('type') == 'agreement' ? 'selected' : '' }}>Agreement Letter</option>
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
                <textarea name="content" id="content" class="form-control summernote" required  style="min-height: 200px;">{{ old('content') }}</textarea>
                @error('content')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="col-span-2 mt-4">
                <label class="hrp-label">Notes:</label>
                <textarea name="notes" id="notes" class="form-control summernote-notes" 
                         placeholder="Any additional notes about this letter" style="min-height: 225px;">{{ old('notes') }}</textarea>
                @error('notes')
                    <small class="hrp-error">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <div class="hrp-actions">
                    <button type="submit" class="hrp-btn hrp-btn-primary">
                        <i class="fas fa-save mr-1"></i> Save Letter
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
                // Make sure the editor has focus when initialized
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
        styleTags: ['p', 'pre', 'h4', 'h5', 'h6']
    });

    // Generate new reference number
    $('#generateRefBtn').click(function() {
        $.ajax({
            url: '{{ route("employees.letters.generate-number", $employee) }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#reference_number').val(response.reference_number);
            },
            error: function() {
                alert('Error generating reference number');
            }
        });
    });

    // Handle form submission
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        // Update textarea content before form submission
        $('.summernote, .summernote-notes').each(function() {
            $(this).val($(this).summernote('code'));
        });
        
        // Get form data
        var formData = new FormData(this);
        var url = $(this).attr('action');
        
        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        // Clear previous errors
        $('.hrp-error').text('').hide();
        $('.is-invalid').removeClass('is-invalid');
        
        // Submit form via AJAX
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    // If no redirect URL is provided, just reload the page
                    window.location.reload();
                }
            },
            error: function(xhr) {
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                // Handle validation errors
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
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
                } else {
                    // Show generic error message
                    var errorMsg = xhr.responseJSON && xhr.responseJSON.message 
                        ? xhr.responseJSON.message 
                        : 'An error occurred while saving. Please try again.';
                    alert(errorMsg);
                }
            }
        });
    });
});
</script>
@endpush

@endsection