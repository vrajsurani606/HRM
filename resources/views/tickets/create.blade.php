@extends('layouts.macos')
@section('page_title', 'Create Support Ticket')

@push('styles')
<style>
  .ticket-form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 24px;
  }
  
  .ticket-form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }
  
  .ticket-form-header {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    padding: 32px;
    color: white;
    text-align: center;
  }
  
  .ticket-form-header h1 {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
  }
  
  .ticket-form-header p {
    font-size: 15px;
    opacity: 0.9;
    margin: 0;
  }
  
  .ticket-form-body {
    padding: 40px;
  }
  
  .form-group {
    margin-bottom: 24px;
  }
  
  .form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 8px;
  }
  
  .form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 4px;
  }
  
  .form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 15px;
    color: #0f172a;
    transition: all 0.3s ease;
    font-family: inherit;
  }
  
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }
  
  .form-textarea {
    resize: vertical;
    min-height: 120px;
  }
  
  .form-help {
    font-size: 13px;
    color: #64748b;
    margin-top: 6px;
  }
  
  .priority-options {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
  }
  
  .priority-option {
    position: relative;
  }
  
  .priority-option input[type="radio"] {
    position: absolute;
    opacity: 0;
  }
  
  .priority-label {
    display: block;
    padding: 12px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .priority-option input[type="radio"]:checked + .priority-label {
    border-color: #6366f1;
    background: #ede9fe;
    color: #6366f1;
  }
  
  .priority-label.low { border-color: #10b981; }
  .priority-option input[type="radio"]:checked + .priority-label.low {
    border-color: #10b981;
    background: #d1fae5;
    color: #065f46;
  }
  
  .priority-label.normal { border-color: #3b82f6; }
  .priority-option input[type="radio"]:checked + .priority-label.normal {
    border-color: #3b82f6;
    background: #dbeafe;
    color: #1e40af;
  }
  
  .priority-label.high { border-color: #f59e0b; }
  .priority-option input[type="radio"]:checked + .priority-label.high {
    border-color: #f59e0b;
    background: #fef3c7;
    color: #92400e;
  }
  
  .priority-label.urgent { border-color: #ef4444; }
  .priority-option input[type="radio"]:checked + .priority-label.urgent {
    border-color: #ef4444;
    background: #fee2e2;
    color: #991b1b;
  }
  
  .form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
  }
  
  .btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  
  .btn-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
  }
  
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
  }
  
  .btn-secondary {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
  }
  
  .btn-secondary:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
  }
  
  @media (max-width: 768px) {
    .priority-options {
      grid-template-columns: repeat(2, 1fr);
    }
    
    .form-actions {
      flex-direction: column-reverse;
    }
    
    .btn {
      width: 100%;
      justify-content: center;
    }
  }
</style>
@endpush

@section('content')
<div class="ticket-form-container">
  <div class="ticket-form-card">
    <!-- Header -->
    <div class="ticket-form-header">
      <h1>Create Support Ticket</h1>
      <p>We're here to help! Describe your issue and we'll get back to you soon.</p>
    </div>
    
    <!-- Form Body -->
    <div class="ticket-form-body">
      <form action="{{ route('tickets.store') }}" method="POST">
        @csrf
        
        <!-- Title -->
        <div class="form-group">
          <label for="title" class="form-label required">Subject</label>
          <input 
            type="text" 
            id="title" 
            name="title" 
            class="form-input" 
            placeholder="Brief description of your issue"
            value="{{ old('title') }}"
            required
          >
          @error('title')
            <p class="form-help" style="color: #ef4444;">{{ $message }}</p>
          @enderror
        </div>
        
        <!-- Project Selection (for customers only) -->
        @if(auth()->user()->hasRole('customer') && auth()->user()->company_id)
          @php
            $userProjects = \App\Models\Project::where('company_id', auth()->user()->company_id)
              ->whereIn('status', ['active', 'in_progress'])
              ->orderBy('name')
              ->get();
          @endphp
          
          @if($userProjects->count() > 0)
          <div class="form-group">
            <label for="project_id" class="form-label">Related Project (Optional)</label>
            <select id="project_id" name="project_id" class="form-select">
              <option value="">Select a project (if applicable)</option>
              @foreach($userProjects as $project)
                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                  {{ $project->name }}
                </option>
              @endforeach
            </select>
            <p class="form-help">Select a project if this ticket is related to a specific project</p>
            @error('project_id')
              <p class="form-help" style="color: #ef4444;">{{ $message }}</p>
            @enderror
          </div>
          @endif
        @endif
        
        <!-- Ticket Type -->
        <div class="form-group">
          <label for="ticket_type" class="form-label">Category</label>
          <select id="ticket_type" name="ticket_type" class="form-select">
            <option value="">Select a category</option>
            <option value="Technical Support" {{ old('ticket_type') == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
            <option value="Billing" {{ old('ticket_type') == 'Billing' ? 'selected' : '' }}>Billing</option>
            <option value="Feature Request" {{ old('ticket_type') == 'Feature Request' ? 'selected' : '' }}>Feature Request</option>
            <option value="Bug Report" {{ old('ticket_type') == 'Bug Report' ? 'selected' : '' }}>Bug Report</option>
            <option value="General Inquiry" {{ old('ticket_type') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
            <option value="AMC Renewal" {{ old('ticket_type') == 'AMC Renewal' ? 'selected' : '' }}>AMC Renewal</option>
            <option value="Other" {{ old('ticket_type') == 'Other' ? 'selected' : '' }}>Other</option>
          </select>
          @error('ticket_type')
            <p class="form-help" style="color: #ef4444;">{{ $message }}</p>
          @enderror
        </div>
        
        <!-- Priority -->
        <div class="form-group">
          <label class="form-label">Priority Level</label>
          <div class="priority-options">
            <div class="priority-option">
              <input type="radio" id="priority_low" name="priority" value="low" {{ old('priority', 'normal') == 'low' ? 'checked' : '' }}>
              <label for="priority_low" class="priority-label low">Low</label>
            </div>
            <div class="priority-option">
              <input type="radio" id="priority_normal" name="priority" value="normal" {{ old('priority', 'normal') == 'normal' ? 'checked' : '' }}>
              <label for="priority_normal" class="priority-label normal">Normal</label>
            </div>
            <div class="priority-option">
              <input type="radio" id="priority_high" name="priority" value="high" {{ old('priority') == 'high' ? 'checked' : '' }}>
              <label for="priority_high" class="priority-label high">High</label>
            </div>
            <div class="priority-option">
              <input type="radio" id="priority_urgent" name="priority" value="urgent" {{ old('priority') == 'urgent' ? 'checked' : '' }}>
              <label for="priority_urgent" class="priority-label urgent">Urgent</label>
            </div>
          </div>
          <p class="form-help">Select the urgency level of your request</p>
        </div>
        
        <!-- Description -->
        <div class="form-group">
          <label for="description" class="form-label required">Description</label>
          <textarea 
            id="description" 
            name="description" 
            class="form-textarea" 
            placeholder="Please provide detailed information about your issue..."
            required
          >{{ old('description') }}</textarea>
          <p class="form-help">Include any relevant details, error messages, or steps to reproduce the issue</p>
          @error('description')
            <p class="form-help" style="color: #ef4444;">{{ $message }}</p>
          @enderror
        </div>
        
        <!-- Auto-filled fields for customers -->
        @if(auth()->user()->hasRole('customer') && auth()->user()->company)
          <input type="hidden" name="company" value="{{ auth()->user()->company->company_name }}">
          <input type="hidden" name="customer" value="{{ auth()->user()->name }}">
        @else
          <!-- Company (for non-customers) -->
          <div class="form-group">
            <label for="company" class="form-label">Company</label>
            <input 
              type="text" 
              id="company" 
              name="company" 
              class="form-input" 
              placeholder="Your company name"
              value="{{ old('company') }}"
            >
          </div>
          
          <!-- Customer Name (for non-customers) -->
          <div class="form-group">
            <label for="customer" class="form-label">Your Name</label>
            <input 
              type="text" 
              id="customer" 
              name="customer" 
              class="form-input" 
              placeholder="Your full name"
              value="{{ old('customer', auth()->user()->name) }}"
            >
          </div>
        @endif
        
        <!-- Hidden status field -->
        <input type="hidden" name="status" value="open">
        
        <!-- Form Actions -->
        <div class="form-actions">
          <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 12H5"/>
              <path d="M12 19L5 12L12 5"/>
            </svg>
            Cancel
          </a>
          <button type="submit" class="btn btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.7088 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.76489 14.1003 1.98232 16.07 2.86">
              </path>
              <path d="M22 4L12 14.01L9 11.01"/>
            </svg>
            Submit Ticket
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
