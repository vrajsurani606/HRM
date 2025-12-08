@extends('layouts.macos')
@section('page_title', 'Create New Project')

@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
  .project-form-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 24px;
  }
  .project-form-card {
    background: white;
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  .form-header {
    margin-bottom: 32px;
  }
  .form-header h1 {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 8px 0;
  }
  .form-header p {
    color: #64748b;
    margin: 0;
  }
  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
  }
  .form-group {
    display: flex;
    flex-direction: column;
  }
  .form-group.full-width {
    grid-column: 1 / -1;
  }
  .form-label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
  }
  .form-label .required {
    color: #ef4444;
  }
  .form-input, .form-select, .form-textarea {
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }
  .form-textarea {
    resize: vertical;
    min-height: 100px;
  }
  .form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
  }
  .btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
  }
  .btn-primary {
    background: #3b82f6;
    color: white;
  }
  .btn-primary:hover {
    background: #2563eb;
  }
  .btn-secondary {
    background: #f1f5f9;
    color: #475569;
  }
  .btn-secondary:hover {
    background: #e2e8f0;
  }
  
  /* Date Picker Styling */
  .date-picker {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 40px;
    cursor: pointer;
  }
</style>
@endpush

@section('content')
<div class="project-form-container">
  <div class="project-form-card">
    <div class="form-header">
      <h1>Create New Project</h1>
      <p>Fill in the details below to create a new project</p>
    </div>

    <form action="{{ route('projects.store') }}" method="POST">
      @csrf
      
      <div class="form-grid">
        <!-- Project Name -->
        <div class="form-group full-width">
          <label class="form-label">
            Project Name <span class="required">*</span>
          </label>
          <input type="text" 
                 name="name" 
                 class="form-input" 
                 placeholder="Enter project name" 
                 value="{{ old('name') }}" 
                 required>
          @error('name')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>

        <!-- Company -->
        <div class="form-group">
          <label class="form-label">
            Company <span class="required">*</span>
          </label>
          <select name="company_id" class="form-select" required>
            <option value="">Select Company</option>
            @if(isset($companies))
              @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                  {{ $company->company_name }}
                </option>
              @endforeach
            @endif
          </select>
          @error('company_id')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>

        <!-- Status -->
        <div class="form-group">
          <label class="form-label">
            Status <span class="required">*</span>
          </label>
          <select name="status" class="form-select" required>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
          </select>
          @error('status')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>

        <!-- Start Date with Date Picker -->
        <div class="form-group">
          <label class="form-label">
            Start Date <span class="required">*</span>
          </label>
          <input type="text" 
                 id="start_date" 
                 name="start_date" 
                 class="form-input date-picker" 
                 placeholder="dd/mm/yyyy" 
                 value="{{ old('start_date') }}" 
                 autocomplete="off"
                 required>
          @error('start_date')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>

        <!-- Due Date with Date Picker -->
        <div class="form-group">
          <label class="form-label">
            Due Date (Deadline) <span class="required">*</span>
          </label>
          <input type="text" 
                 id="due_date" 
                 name="due_date" 
                 class="form-input date-picker" 
                 placeholder="dd/mm/yyyy" 
                 value="{{ old('due_date') }}" 
                 autocomplete="off"
                 required>
          @error('due_date')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>

        <!-- Priority -->
        <div class="form-group">
          <label class="form-label">Priority</label>
          <select name="priority" class="form-select">
            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
          </select>
        </div>

        <!-- Description -->
        <div class="form-group full-width">
          <label class="form-label">Description</label>
          <textarea name="description" 
                    class="form-textarea" 
                    placeholder="Enter project description">{{ old('description') }}</textarea>
          @error('description')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <!-- Form Actions -->
      <div class="form-actions">
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Create Project</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
// Initialize jQuery datepicker with dd/mm/yyyy format (same as inquiry)
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy', // In jQuery UI, 'yy' means 4-digit year
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({
                    marginTop: '2px',
                    marginLeft: '0px'
                });
            }, 0);
        },
        onSelect: function(dateText) {
            $(this).trigger('change');
        }
    });
    
    // Set minimum date for due_date based on start_date
    $('#start_date').on('change', function() {
        var startDate = $(this).datepicker('getDate');
        if (startDate) {
            $('#due_date').datepicker('option', 'minDate', startDate);
        }
    });
});
</script>
@endpush
