@extends('layouts.macos')
@section('page_title', $page_title)


@push('styles')
<link rel="stylesheet" href="{{ asset('css/employee-grid.css') }}">
<style>
    .letters-container {
        padding: 20px;
    }
    .letters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 0 10px;
    }
    .letters-title {
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }
    .letters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .letter-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    .letter-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .letter-title {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .letter-badge {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        text-transform: capitalize;
        color: white;
    }
    .letter-body {
        padding: 16px;
    }
    .letter-meta {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 12px;
    }
    .letter-content {
        font-size: 14px;
        color: #4b5563;
        line-height: 1.5;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .letter-actions {
        display: flex;
        gap: 8px;
        padding: 8px 16px 16px;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        border: 1px solid transparent;
    }
    .action-btn.view {
        background-color: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .action-btn.view:hover {
        background-color: #bae6fd;
    }
    .action-btn.print {
        background-color: #f0fdf4;
        color: #059669;
        border-color: #bbf7d0;
    }
    .action-btn.print:hover {
        background-color: #bbf7d0;
    }
    .action-btn.edit {
        background-color: #ede9fe;
        color: #7c3aed;
        border: 1px solid #ddd6fe;
    }
    .action-btn.edit:hover {
        background-color: #ddd6fe;
    }
    .action-btn.delete {
        background-color: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .action-btn.delete:hover {
        background-color: #fecaca;
    }
    .action-btn i {
        font-size: 14px;
    }
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
        font-size: 16px;
    }
    .add-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #3b82f6;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: background-color 0.2s;
        text-decoration: none;
    }
    .add-btn:hover {
        background-color: #2563eb;
        color: white;
    }
    /* Badge colors for different letter types */
    .badge-appointment { background-color: #3b82f6; }
    .badge-offer { background-color: #10b981; }
    .badge-joining { background-color: #f59e0b; }
    .badge-confidentiality { background-color: #8b5cf6; }
    .badge-impartiality { background-color: #f97316; }
    .badge-experience { background-color: #06b6d4; }
    .badge-agreement { background-color: #14b8a6; }
    .badge-relieving { background-color: #8b5cf6; }
    .badge-confirmation { background-color: #2563eb; }
    .badge-warning { background-color: #f59e0b; }
    .badge-termination { background-color: #ef4444; }
    .badge-other { background-color: #6b7280; }
    .badge-increment { background-color: #059669; }
    .badge-internship_offer { background-color: #7c3aed; }
    .badge-internship_letter { background-color: #dc2626; }
    
    /* Modal styles */
    .modal-header {
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 20px;
    }
    .modal-title {
        font-weight: 600;
        color: #111827;
        font-size: 18px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-control {
        border-radius: 6px;
        border: 1px solid #d1d5db;
        padding: 8px 12px;
        height: auto;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.5);
    }
    .btn {
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    .btn-default {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        color: #4b5563;
    }
    .btn-default:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
    }
    .input-group-addon {
        background-color: #f9fafb;
        border: 1px solid #d1d5db;
        border-right: none;
        padding: 8px 12px;
        border-radius: 6px 0 0 6px;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="letters-container">
    <div class="letters-header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('employees.letters.create', $employee) }}" 
               class="add-btn" 
               target="_blank">
                <i class="fa fa-plus"></i> Add New Letter
            </a>
        </div>
    </div>
    <div class="letters-grid">
        @forelse ($letters as $letter)
            <div class="letter-card">
                <div class="card-header">
                    <h3 class="letter-title" title="{{ $letter->title }}">{{ $letter->title }}</h3>
                    <span class="letter-badge badge-{{ $letter->type }}">
                        {{ ucfirst($letter->type) }}
                    </span>
                </div>
                <div class="letter-body">
                    <div class="letter-meta">
                        <span class="letter-ref" title="Ref: {{ $letter->reference_number }}">
                            <i class="fa fa-hashtag"></i> {{ $letter->reference_number }}
                        </span>
                        <span class="letter-date">
                            <i class="fa fa-calendar"></i> {{ $letter->issue_date->format('d M Y') }}
                        </span>
                    </div>
                    <div class="letter-content" title="{{ strip_tags($letter->content) }}">
                        {{ Str::limit(strip_tags($letter->content), 150) }}
                    </div>
                </div>
                <div class="letter-actions">
                    <a href="{{ route('employees.letters.print', ['employee' => $employee, 'letter' => $letter]) }}" 
                       class="action-btn print" 
                       title="Print Letter" 
                       target="_blank">
                        <i class="fa fa-print"></i> Print
                    </a>
                    <a href="#" class="action-btn edit" title="Edit Letter" target="_blank">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <form action="#" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this letter?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete" title="Delete Letter">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fa fa-file-text-o"></i> No letters found for this employee.
            </div>
        @endforelse
    </div>

    @if($letters->hasPages())
        <div class="text-center">
            {{ $letters->links() }}
        </div>
    @endif
</div>

<!-- Add Letter Modal -->
<div class="modal fade" id="addLetterModal" tabindex="-1" role="dialog" aria-labelledby="addLetterModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('employees.letters.store', $employee) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addLetterModalLabel">
                        <i class="fa fa-file-text-o"></i> Create New Letter
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" style="display: block; margin-bottom: 6px; font-weight: 500; color: #374151;">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required style="width: 100%;">
                        <input type="text" class="form-control" id="title" name="title" required 
                               placeholder="E.g., Offer Letter for {{ $employee->name }}" 
                               value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="content" class="control-label">Letter Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="10" 
                                 placeholder="Enter the letter content here..." required>{{ old('content') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="control-label">Notes <small class="text-muted">(Optional)</small></label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                 placeholder="Any additional notes about this letter">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Letter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('hiring.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Employee Letters</span>
@endsection
@push('scripts')
<script>
    $(function () {
        // Initialize datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        // Initialize CKEditor for content
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('content', {
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote'] },
                    { name: 'links', items: ['Link', 'Unlink'] },
                    { name: 'insert', items: ['Image', 'Table'] },
                    { name: 'styles', items: ['Format', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize', 'Source'] }
                ],
                height: 200,
                removePlugins: 'elementspath',
                resize_enabled: true
            });
        }

        // Handle modal close events
        $('#addLetterModal').on('hidden.bs.modal', function () {
            // Clear the modal content
            $(this).find('form')[0].reset();
            
            // Clear any validation errors
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').remove();
            
            // Reset CKEditor content if it exists
            if (typeof CKEDITOR.instances.content !== 'undefined') {
                CKEDITOR.instances.content.setData('');
            }
        });

        // Handle form submission
        $('#addLetterModal form').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            
            // Submit form via AJAX
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Close the modal
                    $('#addLetterModal').modal('hide');
                    
                    // Show success message
                    const successHtml = `
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i> Letter added successfully!
                        </div>
                    `;
                    
                    // Prepend success message and reload the page after a short delay
                    $('.box-body').prepend(successHtml);
                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function(xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        // Clear previous errors
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        
                        // Display new errors
                        for (const field in errors) {
                            const input = $(`#${field}`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback" style="display:block">${errors[field][0]}</div>`);
                        }
                    }
                }
            });
        });
    });
</script>
@endpush