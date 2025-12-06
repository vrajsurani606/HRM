@extends('layouts.macos')

@section('page_title', 'Dashboard Overview')

@push('styles')
<style>
  /* Note Popup Modal */
  .note-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
  }
  .note-popup-overlay.active {
    opacity: 1;
    visibility: visible;
  }
  .note-popup-content {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 560px;
    max-height: 80vh;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
    transform: translateY(-20px) scale(0.95);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }
  .note-popup-overlay.active .note-popup-content {
    transform: translateY(0) scale(1);
  }
  .note-popup-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
  }
  .note-popup-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: white !important;
  }
  .note-popup-header h3 span {
    color: white !important;
  }
  .note-popup-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(255,255,255,0.15);
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }
  .note-popup-close:hover {
    background: rgba(255,255,255,0.25);
    transform: scale(1.1);
  }
  .note-popup-body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
  }
  .note-popup-text {
    font-size: 15px;
    line-height: 1.8;
    color: #374151;
    white-space: pre-wrap;
    word-wrap: break-word;
  }
  .note-popup-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 24px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    font-size: 13px;
    color: #64748b;
  }
  .note-popup-assignees {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
  }
  .note-popup-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
  }
  .read-more-link {
    color: #3b82f6;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 8px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
  }
  .read-more-link:hover {
    color: #1d4ed8;
    text-decoration: underline;
  }

  .hrp-content {
    overflow-y: auto !important;
    scroll-behavior: smooth;
    height: calc(100vh - 60px);
  }
  
  body, html {
    overflow: hidden;
  }
  
  .hrp-main {
    display: flex;
    flex-direction: column;
    height: 100vh;
  }
  
  .hrp-breadcrumb {
    position: sticky;
    bottom: 0;
    background: white;
    z-index: 10;
    border-top: 1px solid #e5e7eb;
    padding: 12px 20px;
  }
  
  /* Dashboard content wrapper */
  .dashboard-content-wrapper {
    padding: 20px;
    padding-bottom: 150px;
    background: #f7f4f1;
    min-height: auto;
  }
  
  /* Calendar responsive styles */
  .calendar-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    margin-bottom: 40px;
  }
  
  .calendar-legend {
    background: #f9fafb;
    padding: 16px 20px;
    border-radius: 8px;
    margin-top: 16px;
    margin-bottom: 20px;
  }
  
  .calendar-legend-items {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    align-items: center;
    justify-content: flex-start;
  }
  
  .legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .legend-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    flex-shrink: 0;
  }
  
  .legend-text {
    font-size: 13px;
    color: #374151;
    font-weight: 500;
    white-space: nowrap;
  }
  
  /* Responsive calendar */
  @media (max-width: 1200px) {
    .calendar-legend-items {
      gap: 16px;
    }
    .legend-text {
      font-size: 12px;
    }
  }
  
  @media (max-width: 768px) {
    .calendar-legend-items {
      gap: 12px;
    }
    .legend-dot {
      width: 12px;
      height: 12px;
    }
    .legend-text {
      font-size: 11px;
    }
  }
  
  /* Notes Section - Horizontal Scroll (hidden by default, gray on hover) */
  .notes-scroll-container {
    overflow-x: auto;
    overflow-y: hidden;
    padding-bottom: 8px;
    margin-bottom: 16px;
    scrollbar-width: none; /* Firefox - hide by default */
  }
  
  .notes-scroll-container::-webkit-scrollbar {
    height: 6px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  
  .notes-scroll-container::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 10px;
  }
  
  .notes-scroll-container::-webkit-scrollbar-thumb {
    background: transparent;
    border-radius: 10px;
    transition: background 0.3s ease;
  }
  
  .notes-scroll-container:hover {
    scrollbar-width: thin; /* Firefox - show on hover */
    scrollbar-color: #9ca3af transparent;
  }
  
  .notes-scroll-container:hover::-webkit-scrollbar-thumb {
    background: #9ca3af;
  }
  
  .notes-scroll-container:hover::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
  }
  
  /* Notes Horizontal Layout */
  .notes-grid {
    display: flex;
    gap: 14px;
    padding: 4px;
    min-width: max-content;
  }
  
  /* Note Card Styling - No border */
  .note-card {
    background: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 18px;
    min-width: 280px;
    max-width: 320px;
    width: 320px;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s ease;
    flex-shrink: 0;
    overflow: hidden;
  }
  
  .note-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transform: translateY(-2px);
  }
  
  /* Note card text styling */
  .note-card-text {
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
    margin-bottom: 8px;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }
  
  /* Blue Note Card for EMP. NOTES */
  .note-card-blue {
    background: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 18px;
    min-width: 300px;
    max-width: 360px;
    width: 360px;
    min-height: 160px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s ease;
    flex-shrink: 0;
    overflow: hidden;
  }
  
  .note-card-blue:hover {
    box-shadow: 0 4px 16px rgba(59, 130, 246, 0.15);
    transform: translateY(-2px);
  }
  
  /* Blue note card text styling */
  .note-card-blue-text {
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
    margin-bottom: 8px;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }
  
  /* Emp Notes Horizontal Scroll (hidden by default, gray on hover) */
  .emp-notes-scroll-container {
    overflow-x: auto;
    overflow-y: hidden;
    padding-bottom: 8px;
    margin-bottom: 16px;
    scrollbar-width: none; /* Firefox - hide by default */
  }
  
  .emp-notes-scroll-container::-webkit-scrollbar {
    height: 6px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  
  .emp-notes-scroll-container::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 10px;
  }
  
  .emp-notes-scroll-container::-webkit-scrollbar-thumb {
    background: transparent;
    border-radius: 10px;
    transition: background 0.3s ease;
  }
  
  .emp-notes-scroll-container:hover {
    scrollbar-width: thin; /* Firefox - show on hover */
    scrollbar-color: #9ca3af transparent;
  }
  
  .emp-notes-scroll-container:hover::-webkit-scrollbar-thumb {
    background: #9ca3af;
  }
  
  .emp-notes-scroll-container:hover::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
  }
  
  /* Note Input Area - No outline/border */
  .note-input-area {
    background: #f8fafc;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 18px;
    position: relative;
    min-height: 90px;
    border: none !important;
    outline: none !important;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);
    transition: background 0.2s ease;
  }
  
  .note-input-area:focus-within {
    background: #f1f5f9;
    border: none !important;
    outline: none !important;
    box-shadow: inset 0 1px 4px rgba(0,0,0,0.08);
  }
  
  /* Blue input area for EMP. NOTES - No outline/border */
  .note-input-area-blue {
    background: #f0f9ff;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 18px;
    position: relative;
    min-height: 90px;
    border: none !important;
    outline: none !important;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);
    transition: background 0.2s ease;
  }
  
  .note-input-area-blue:focus-within {
    background: #e0f2fe;
    border: none !important;
    outline: none !important;
    box-shadow: inset 0 1px 4px rgba(0,0,0,0.08);
  }
  
  .note-textarea {
    width: 100%;
    border: none !important;
    background: transparent;
    font-size: 15px;
    color: #374151;
    outline: none !important;
    resize: none;
    height: 80px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.7;
  }
  
  .note-textarea:focus {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
  }
  
  .note-send-btn {
    position: absolute;
    bottom: 14px;
    right: 14px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    transition: all 0.2s ease;
  }
  
  .note-send-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.5);
  }
  
  .note-send-btn:active {
    transform: scale(0.95);
  }
</style>
@endpush

@section('content')
<div class="dashboard-content-wrapper">
  
  <!-- KPI Cards Row -->
  <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 20px;">
    
    <!-- Present Day Card -->
    <div style="background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%); border-radius: 20px; padding: 16px 24px 16px 16px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <img src="{{ asset('dashboard-emp/calendar.svg') }}" alt="Calendar" style="width: 44px; height: 44px;">
        </div>
        <div>
          <div style="font-size: 36px; font-weight: 700; color: #005593; line-height: 1; margin-bottom: 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $stats['present_days'] ?? '00' }}</div>
          <div style="font-size: 14px; font-weight: 600; color: #005593;">Present Day</div>
        </div>
      </div>
    </div>

    <!-- Working Hours Card -->
    <div style="background: linear-gradient(135deg, #dcfce7 0%, #86efac 100%); border-radius: 20px; padding: 16px 24px 16px 16px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <img src="{{ asset('dashboard-emp/watch.svg') }}" alt="Watch" style="width: 40px; height: 40px;">
        </div>
        <div>
          <div style="font-size: 36px; font-weight: 700; color: #216D00; line-height: 1; margin-bottom: 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ number_format($stats['working_hours'] ?? 0, 1) }}</div>
          <div style="font-size: 14px; font-weight: 600; color: #216D00;">Working Hours</div>
        </div>
      </div>
    </div>

    <!-- Late Entries Card -->
    <div style="background: linear-gradient(135deg, #ffedd5 0%, #fdba74 100%); border-radius: 20px; padding: 16px 24px 16px 16px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <img src="{{ asset('dashboard-emp/late.svg') }}" alt="Late" style="width: 40px; height: 40px;">
        </div>
        <div>
          <div style="font-size: 36px; font-weight: 700; color: #DE5A00; line-height: 1; margin-bottom: 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $stats['late_entries'] ?? '00' }}</div>
          <div style="font-size: 14px; font-weight: 600; color: #DE5A00;">Late Entries</div>
        </div>
      </div>
    </div>

    <!-- Early Exits Card -->
    <div style="background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%); border-radius: 20px; padding: 16px 24px 16px 16px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <img src="{{ asset('dashboard-emp/early.svg') }}" alt="Early Exit" style="width: 40px; height: 40px;">
        </div>
        <div>
          <div style="font-size: 36px; font-weight: 700; color: #DA0000; line-height: 1; margin-bottom: 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $stats['early_exits'] ?? '00' }}</div>
          <div style="font-size: 14px; font-weight: 600; color: #DA0000;">Early Exits</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Notes Section -->
  <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); margin-bottom: 16px;">
    <!-- Tabs - Left Aligned -->
    <div style="display: flex; background: #414141; border-radius: 16px 16px 0 0; justify-content: flex-start;">
      <button onclick="switchTab('notes')" id="notesTab" style="padding: 14px 28px; font-size: 13px; font-weight: 700; color: white; cursor: pointer; border: none; background: transparent; display: flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        NOTES
      </button>
      <button onclick="switchTab('empNotes')" id="empNotesTab" style="padding: 14px 28px; font-size: 13px; font-weight: 700; color: #9ca3af; cursor: pointer; border: none; background: transparent; display: flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.7;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        EMP. NOTES
      </button>
    </div>

    <!-- Notes Content -->
    <div id="notesContent" style="padding: 20px;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
        </div>
        <div style="font-size: 16px; color: #1f2937; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Add New Notes</div>
      </div>
      
      <form id="notesForm" onsubmit="submitNote(event, 'notes')">
        @csrf
        <input type="hidden" name="note_type" value="notes">
        <div class="note-input-area">
          <textarea id="notesTextarea" name="note_text" placeholder="Type your note here... (Ctrl+Enter to send)" required class="note-textarea"></textarea>
          <button type="submit" id="notesSendBtn" class="note-send-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </div>
      </form>
      
      <div class="notes-scroll-container">
        <div id="systemNotesContainer" class="notes-grid">
          @forelse($systemNotes ?? [] as $note)
            @php
              $noteText = $note['text'] ?? '';
              $maxLength = 100;
              $isTruncated = strlen($noteText) > $maxLength;
              $displayText = $isTruncated ? substr($noteText, 0, $maxLength) . '...' : $noteText;
            @endphp
            <div class="note-card">
              <div class="note-card-text">{{ $displayText }}</div>
              @if($isTruncated)
                <span class="read-more-link" data-full-text="{{ urlencode($noteText) }}" data-date="{{ $note['date'] }}" data-assignees="" onclick="openNoteFromData(this)">
                  Read More 
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </span>
              @endif
              <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                <span style="font-size: 12px; color: #9ca3af; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $note['date'] }}</span>
                <form action="{{ route('employee.notes.delete', $note['id']) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete this note?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" style="width: 24px; height: 24px; border-radius: 50%; background: #fee2e2; border: none; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='white';" onmouseout="this.style.background='#fee2e2'; this.style.color='#dc2626';">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                  </button>
                </form>
              </div>
            </div>
          @empty
            <div style="text-align: center; padding: 40px; color: #9ca3af; font-size: 13px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; width: 100%;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 12px; opacity: 0.3;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
              <div>No notes yet. Add your first note above!</div>
            </div>
          @endforelse
        </div>
      </div>

    </div>

    <!-- Emp Notes Content -->
    <div id="empNotesContent" style="padding: 20px; display: none;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
        </div>
        <div style="font-size: 16px; color: #1f2937; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Employee Notes</div>
      </div>
      
      <!-- Employee Selector (only for admin/hr) -->
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr') || auth()->user()->hasRole('super-admin'))
        <div style="margin-bottom: 14px;">
          <select id="employeeSelector" style="width: 100%; padding: 10px 14px; border: none; border-radius: 10px; font-size: 13px; color: #374151; background: #f0f9ff; cursor: pointer; box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);">
            <option value="">-- Select an employee --</option>
            @foreach($allEmployees ?? [] as $emp)
              <option value="{{ $emp['id'] }}">{{ $emp['name'] }}</option>
            @endforeach
          </select>
        </div>
      @endif
      
      <form id="empNotesForm" onsubmit="submitNote(event, 'empNotes')">
        @csrf
        <input type="hidden" name="note_type" value="empNotes">
        <input type="hidden" id="selectedEmployeeId" name="employee_id" value="">
        <div class="note-input-area-blue">
          <textarea id="empNotesTextarea" name="note_text" placeholder="Type employee note here... (Ctrl+Enter to send)" required class="note-textarea"></textarea>
          <button type="submit" id="empNotesSendBtn" style="position: absolute; bottom: 14px; right: 14px; width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4); transition: all 0.2s;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </div>
      </form>
      
      <!-- Horizontal Scrolling Notes Container -->
      <div id="empNotesContainer" class="emp-notes-scroll-container">
        <div style="display: flex; gap: 16px; min-width: max-content; padding: 4px;">
          @forelse($empNotes ?? [] as $note)
            @php
              $empNoteText = $note['text'] ?? 'No content';
              $empMaxLength = 100;
              $empIsTruncated = strlen($empNoteText) > $empMaxLength;
              $empDisplayText = $empIsTruncated ? substr($empNoteText, 0, $empMaxLength) . '...' : $empNoteText;
              $assigneesList = isset($note['assignees']) && is_array($note['assignees']) ? $note['assignees'] : [];
            @endphp
            <div class="note-card-blue">
              <div class="note-card-blue-text">{{ $empDisplayText }}</div>
              @if($empIsTruncated)
                <span class="read-more-link" data-full-text="{{ urlencode($empNoteText) }}" data-date="{{ $note['date'] ?? now()->format('M d, Y') }}" data-assignees="{{ urlencode(json_encode($assigneesList)) }}" onclick="openNoteFromData(this)">
                  Read More 
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </span>
              @endif
              <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; margin-top: 8px;">
                @if(count($assigneesList) > 0)
                  @foreach($assigneesList as $assignee)
                    <span style="padding: 5px 12px; background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 12px; font-weight: 600;">{{ $assignee }}</span>
                  @endforeach
                @else
                  <span style="padding: 5px 12px; background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 12px; font-weight: 600;">{{ auth()->user()->name ?? 'Employee' }}</span>
                @endif
              </div>
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: #9ca3af;">{{ $note['date'] ?? now()->format('M d, Y') }}</span>
                @if($note['can_delete'] ?? false)
                  <form action="{{ route('employee.notes.delete', $note['id']) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Delete this note?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 22px; height: 22px; border-radius: 50%; background: #fee2e2; border: none; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                      <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                  </form>
                @endif
              </div>
            </div>
          @empty
            <div style="text-align: center; padding: 40px; color: #9ca3af; font-size: 13px; width: 100%;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px; opacity: 0.3;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
              <div>No employee notes yet.</div>
            </div>
          @endforelse
        </div>
      </div>

    </div>
  </div>

  <!-- Calendar Section - Full Width -->
  <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); margin-bottom: 40px;">
      <!-- Calendar Header -->
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 3px solid #3b82f6;">
        <!-- Left: Navigation and Today -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <button onclick="changeMonth(-1)" style="width: 36px; height: 36px; border-radius: 6px; background: #3b82f6; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">‹</button>
          <button onclick="changeMonth(1)" style="width: 36px; height: 36px; border-radius: 6px; background: #3b82f6; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">›</button>
          <button onclick="goToToday()" style="padding: 8px 16px; border-radius: 6px; background: white; color: #374151; border: 1px solid #d1d5db; cursor: pointer; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s; margin-left: 8px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">Today</button>
        </div>
        
        <!-- Center: Month Year -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <span id="currentMonth" style="font-size: 22px; font-weight: 700; color: #1f2937; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; text-transform: uppercase;">{{ now()->format('F') }}</span>
          <span id="currentYear" style="font-size: 22px; font-weight: 700; color: #1f2937; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ now()->format('Y') }}</span>
        </div>
        
        <!-- Right: Month View Label -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <span style="padding: 8px 20px; background: #3b82f6; color: white; border-radius: 6px; font-size: 13px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Month View</span>
        </div>
      </div>
      
      <!-- Calendar Title -->
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
        <div style="width: 4px; height: 20px; background: #3b82f6; border-radius: 2px;"></div>
        <h3 style="font-size: 15px; font-weight: 600; color: #1f2937; margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Calendar</h3>
      </div>

      <!-- Calendar Table -->
      <table id="calendarTable" style="width: 100%; table-layout: fixed; border-collapse: collapse; margin-bottom: 20px; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
        <thead>
          <tr style="background: #f9fafb;">
            <th style="width: 14.28%; text-align: left; font-size: 15px; font-weight: 600; color: #ef4444; padding: 16px 14px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Sun</th>
            <th style="width: 14.28%; text-align: left; font-size: 15px; font-weight: 600; color: #374151; padding: 16px 14px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Mon</th>
            <th style="width: 14.28%; text-align: left; font-size: 15px; font-weight: 600; color: #374151; padding: 16px 14px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Tue</th>
            <th style="width: 14.28%; text-align: left; font-size: 15px; font-weight: 600; color: #374151; padding: 16px 14px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Wed</th>
            <th style="width: 14.28%; text-align: left; font-size: 15px; font-weight: 600; color: #374151; padding: 16px 14px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Thu</th>
            <th style="width: 14.28%; text-align: left; font-size: 15px; font-weight: 600; color: #374151; padding: 16px 14px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Fri</th>
            <th style="width: 14.28%; text-align: left; font-size: 15px; font-weight: 600; color: #374151; padding: 16px 14px; border-bottom: 1px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Sat</th>
          </tr>
        </thead>
        <tbody id="calendarBody">
          <!-- Calendar will be rendered by JavaScript -->
        </tbody>
      </table>

      <!-- Legend - Bottom of Calendar -->
      <div style="background: #f9fafb; padding: 16px 20px; border-radius: 8px; margin-top: 10px;">
        <div style="display: flex; flex-wrap: wrap; gap: 32px; align-items: center; justify-content: flex-start;">
          
          <!-- Pending - Yellow/Amber -->
          <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 14px; height: 14px; background: #f59e0b; border-radius: 50%; box-shadow: 0 2px 4px rgba(245,158,11,0.3);"></div>
            <span style="font-size: 13px; color: #374151; font-weight: 500;">Pending</span>
          </div>
          
          <!-- Approve - Green -->
          <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 14px; height: 14px; background: #22c55e; border-radius: 50%; box-shadow: 0 2px 4px rgba(34,197,94,0.3);"></div>
            <span style="font-size: 13px; color: #374151; font-weight: 500;">Approve</span>
          </div>
          
          <!-- Reject - Red -->
          <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 14px; height: 14px; background: #ef4444; border-radius: 50%; box-shadow: 0 2px 4px rgba(239,68,68,0.3);"></div>
            <span style="font-size: 13px; color: #374151; font-weight: 500;">Reject</span>
          </div>
          
          <!-- Birthday - Teal -->
          <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 14px; height: 14px; background: #14b8a6; border-radius: 50%; box-shadow: 0 2px 4px rgba(20,184,166,0.3);"></div>
            <span style="font-size: 13px; color: #374151; font-weight: 500;">Birthday</span>
          </div>
          
          <!-- Work Anniversary - Orange -->
          <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 14px; height: 14px; background: #f97316; border-radius: 50%; box-shadow: 0 2px 4px rgba(249,115,22,0.3);"></div>
            <span style="font-size: 13px; color: #374151; font-weight: 500;">Work Anniversary</span>
          </div>
          
        </div>
      </div>
    </div>
    
    <!-- Spacer for footer -->
    <div style="height: 60px;"></div>

  </div>
</div>

<!-- Events Popup Modal -->
<div id="eventsPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 12px; padding: 20px; max-width: 400px; width: 90%; max-height: 80vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
      <h3 id="popupTitle" style="font-size: 16px; font-weight: 700; color: #1f2937; margin: 0;">Events</h3>
      <button onclick="closeEventsPopup()" style="width: 32px; height: 32px; border-radius: 50%; background: #f3f4f6; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 18px; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">&times;</button>
    </div>
    <div id="popupContent" style="display: flex; flex-direction: column; gap: 8px;">
      <!-- Events will be populated here -->
    </div>
  </div>
</div>

<!-- Note Popup Modal -->
<div id="notePopupModal" class="note-popup-overlay" onclick="if(event.target === this) closeNotePopup()">
  <div class="note-popup-content">
    <div class="note-popup-header">
      <h3>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
        <span id="notePopupTitle">Note Details</span>
      </h3>
      <button type="button" class="note-popup-close" onclick="closeNotePopup()">&times;</button>
    </div>
    <div class="note-popup-body">
      <div id="notePopupText" class="note-popup-text"></div>
      <div id="notePopupAssignees" class="note-popup-assignees" style="display: none;"></div>
    </div>
    <div class="note-popup-meta">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
      <span id="notePopupDate">-</span>
    </div>
  </div>
</div>

<script>
// Note popup functions
function escapeHtml(text) {
  var div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

function openNotePopup(text, date, assignees) {
  var modal = document.getElementById('notePopupModal');
  var textEl = document.getElementById('notePopupText');
  var dateEl = document.getElementById('notePopupDate');
  var assigneesEl = document.getElementById('notePopupAssignees');
  var titleEl = document.getElementById('notePopupTitle');
  
  // Handle escaped newlines
  var displayText = text.replace(/\\n/g, '\n');
  textEl.textContent = displayText;
  dateEl.textContent = date || '-';
  titleEl.textContent = assignees && assignees.length > 0 ? 'Employee Note Details' : 'Note Details';
  
  // Handle assignees
  if (assignees && assignees.length > 0) {
    var chipsHtml = '';
    assignees.forEach(function(name) {
      chipsHtml += '<span class="note-popup-chip"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>' + escapeHtml(name) + '</span>';
    });
    assigneesEl.innerHTML = '<div style="font-size: 11px; color: #64748b; margin-bottom: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;">👥 Assigned to:</div>' + chipsHtml;
    assigneesEl.style.display = 'block';
  } else {
    assigneesEl.style.display = 'none';
  }
  
  modal.classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeNotePopup() {
  var modal = document.getElementById('notePopupModal');
  modal.classList.remove('active');
  document.body.style.overflow = '';
}

// Close popup on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeNotePopup();
  }
});

// Helper function to open note popup from data attributes (safer for special characters)
function openNoteFromData(element) {
  try {
    var fullText = decodeURIComponent(element.getAttribute('data-full-text') || '');
    var date = element.getAttribute('data-date') || '-';
    var assigneesStr = element.getAttribute('data-assignees');
    var assignees = null;
    
    if (assigneesStr) {
      try {
        assignees = JSON.parse(decodeURIComponent(assigneesStr));
      } catch(e) {
        assignees = null;
      }
    }
    
    openNotePopup(fullText, date, assignees);
  } catch(e) {
    console.error('Error opening note popup:', e);
  }
}
</script>

<script>
function switchTab(tab) {
  const notesTab = document.getElementById('notesTab');
  const empNotesTab = document.getElementById('empNotesTab');
  const notesContent = document.getElementById('notesContent');
  const empNotesContent = document.getElementById('empNotesContent');
  
  if (tab === 'notes') {
    notesTab.style.color = 'white';
    notesTab.style.background = 'rgba(255,255,255,0.1)';
    const notesSvg = notesTab.querySelector('svg');
    if(notesSvg) notesSvg.style.opacity = '1';
    
    empNotesTab.style.color = '#9ca3af';
    empNotesTab.style.background = 'transparent';
    const empSvg = empNotesTab.querySelector('svg');
    if(empSvg) empSvg.style.opacity = '0.7';
    
    notesContent.style.display = 'block';
    empNotesContent.style.display = 'none';
  } else {
    empNotesTab.style.color = 'white';
    empNotesTab.style.background = 'rgba(255,255,255,0.1)';
    const empSvg = empNotesTab.querySelector('svg');
    if(empSvg) empSvg.style.opacity = '1';
    
    notesTab.style.color = '#9ca3af';
    notesTab.style.background = 'transparent';
    const notesSvg = notesTab.querySelector('svg');
    if(notesSvg) notesSvg.style.opacity = '0.7';
    
    notesContent.style.display = 'none';
    empNotesContent.style.display = 'block';
  }
}

// Calendar data from backend (initial load for current month)
let calendarData = {
  attendance: @json($attendanceCalendar ?? []),
  leaves: @json($leavesCalendar ?? []),
  birthdays: @json($birthdaysCalendar ?? []),
  anniversaries: @json($anniversariesCalendar ?? []),
  pendingLeaves: @json($pendingLeavesCalendar ?? []),
  rejectedLeaves: @json($rejectedLeavesCalendar ?? []),
  today: {
    day: {{ now()->day }},
    month: {{ now()->month }},
    year: {{ now()->year }}
  }
};

// Calendar navigation
let currentDate = new Date();
let isLoadingCalendar = false;

// Fetch calendar data for a specific month via AJAX
async function fetchCalendarData(month, year) {
  if (isLoadingCalendar) return;
  isLoadingCalendar = true;
  
  try {
    const response = await fetch(`{{ route('employee.calendar.data') }}?month=${month}&year=${year}`);
    const data = await response.json();
    
    if (data.success) {
      calendarData.attendance = data.attendance || {};
      calendarData.leaves = data.leaves || {};
      calendarData.birthdays = data.birthdays || {};
      calendarData.anniversaries = data.anniversaries || {};
      calendarData.pendingLeaves = data.pendingLeaves || {};
      calendarData.rejectedLeaves = data.rejectedLeaves || {};
    }
  } catch (error) {
    console.error('Error fetching calendar data:', error);
  } finally {
    isLoadingCalendar = false;
  }
}

async function changeMonth(direction) {
  currentDate.setMonth(currentDate.getMonth() + direction);
  const month = currentDate.getMonth() + 1;
  const year = currentDate.getFullYear();
  
  await fetchCalendarData(month, year);
  renderCalendar();
}

async function goToToday() {
  currentDate = new Date();
  const month = currentDate.getMonth() + 1;
  const year = currentDate.getFullYear();
  
  await fetchCalendarData(month, year);
  renderCalendar();
}

// Show events popup
function showEventsPopup(day, events) {
  const popup = document.getElementById('eventsPopup');
  const title = document.getElementById('popupTitle');
  const content = document.getElementById('popupContent');
  
  const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];
  
  title.textContent = `${monthNames[currentDate.getMonth()]} ${day}, ${currentDate.getFullYear()}`;
  
  let html = '';
  events.forEach(event => {
    html += `<div style="background: ${event.bgColor}; border-left: 4px solid ${event.borderColor}; padding: 10px 14px; border-radius: 6px;">
      <div style="font-size: 13px; font-weight: 600; color: ${event.textColor};">${event.title}</div>
      ${event.subtitle ? `<div style="font-size: 11px; color: ${event.textColor}; opacity: 0.8; margin-top: 2px;">${event.subtitle}</div>` : ''}
    </div>`;
  });
  
  content.innerHTML = html;
  popup.style.display = 'flex';
}

function closeEventsPopup() {
  document.getElementById('eventsPopup').style.display = 'none';
}

// Close popup when clicking outside
document.addEventListener('click', function(e) {
  const popup = document.getElementById('eventsPopup');
  if (e.target === popup) {
    closeEventsPopup();
  }
});

function renderCalendar() {
  const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];
  
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();
  
  document.getElementById('currentMonth').textContent = monthNames[month];
  document.getElementById('currentYear').textContent = year;
  
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const today = new Date();
  const isCurrentMonth = (year === today.getFullYear() && month === today.getMonth());
  
  let html = '';
  let dayCount = 1;
  let totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
  
  for (let i = 0; i < totalCells; i++) {
    if (i % 7 === 0) {
      html += '<tr>';
    }
    
    if (i < firstDay || dayCount > daysInMonth) {
      const prevMonthDay = i < firstDay ? new Date(year, month, 0).getDate() - (firstDay - i - 1) : '';
      const nextMonthDay = dayCount > daysInMonth ? dayCount - daysInMonth : '';
      const displayDay = i < firstDay ? prevMonthDay : nextMonthDay;
      if (dayCount > daysInMonth) dayCount++;
      
      const isSaturdayEmpty = (i % 7 === 6);
      const rightBorderEmpty = isSaturdayEmpty ? '' : 'border-right: 1px solid #e5e7eb;';
      html += `<td style="text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb; ${rightBorderEmpty} background: #fafafa; vertical-align: top; height: 130px;">
        <div style="font-size: 16px; font-weight: 400; color: #d1d5db;">${displayDay}</div>
      </td>`;
    } else {
      const day = dayCount;
      const isToday = isCurrentMonth && day === today.getDate();
      const isSunday = (i % 7 === 0);
      
      let bgColor = 'white';
      const dayColor = isSunday ? '#ef4444' : '#374151';
      
      // Collect all events for this day
      let allEvents = [];
      
      // Birthdays (teal) - "Birthday Of [Full Name]"
      const dayBirthdays = calendarData.birthdays[day] || [];
      dayBirthdays.forEach(b => {
        allEvents.push({
          type: 'birthday',
          title: `Birthday Of ${b.name}`,
          subtitle: null,
          bgColor: 'rgba(20, 184, 166, 0.15)',
          borderColor: '#14b8a6',
          textColor: '#0f766e'
        });
      });
      
      // Work Anniversaries (orange) - "Work Anniversary Of [Full Name]"
      const dayAnniversaries = calendarData.anniversaries[day] || [];
      dayAnniversaries.forEach(a => {
        allEvents.push({
          type: 'anniversary',
          title: `Work Anniversary Of ${a.name}`,
          subtitle: `${a.years} Year${a.years > 1 ? 's' : ''}`,
          bgColor: 'rgba(249, 115, 22, 0.15)',
          borderColor: '#f97316',
          textColor: '#c2410c'
        });
      });
      
      // Approved Leaves (green) - "[Name] - Leave Approved"
      const dayLeaves = calendarData.leaves[day] || [];
      dayLeaves.forEach(l => {
        allEvents.push({
          type: 'leave_approved',
          title: `${l.name}`,
          subtitle: `${l.type || 'Leave'} - Approved`,
          bgColor: 'rgba(34, 197, 94, 0.15)',
          borderColor: '#22c55e',
          textColor: '#15803d'
        });
      });
      
      // Pending Leaves (yellow/amber) - "[Name] - Leave Pending"
      const dayPendingLeaves = calendarData.pendingLeaves[day] || [];
      dayPendingLeaves.forEach(l => {
        allEvents.push({
          type: 'leave_pending',
          title: `${l.name}`,
          subtitle: `${l.type || 'Leave'} - Pending`,
          bgColor: 'rgba(245, 158, 11, 0.15)',
          borderColor: '#f59e0b',
          textColor: '#b45309'
        });
      });
      
      // Rejected Leaves (red) - "[Name] - Leave Rejected"
      const dayRejectedLeaves = calendarData.rejectedLeaves[day] || [];
      dayRejectedLeaves.forEach(l => {
        allEvents.push({
          type: 'leave_rejected',
          title: `${l.name}`,
          subtitle: `${l.type || 'Leave'} - Rejected`,
          bgColor: 'rgba(239, 68, 68, 0.15)',
          borderColor: '#ef4444',
          textColor: '#b91c1c'
        });
      });
      
      const cellBorder = '1px solid #e5e7eb';
      const isSaturday = (i % 7 === 6);
      const rightBorder = isSaturday ? '' : 'border-right: 1px solid #e5e7eb;';
      html += `<td style="text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb; ${rightBorder} background: ${bgColor}; vertical-align: top; height: 130px; position: relative;">`;
      
      // Day number - larger font
      if (isToday) {
        html += `<div style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #3b82f6; border-radius: 50%; margin-bottom: 8px;">
          <span style="font-size: 16px; font-weight: 700; color: white;">${day}</span>
        </div>`;
      } else {
        html += `<div style="font-size: 17px; font-weight: ${isSunday ? '700' : '600'}; color: ${dayColor}; margin-bottom: 8px;">${day}</div>`;
      }
      
      // Events container - show max 3 events
      html += `<div style="display: flex; flex-direction: column; gap: 4px;">`;
      
      const maxVisible = 3;
      const visibleEvents = allEvents.slice(0, maxVisible);
      const remainingCount = allEvents.length - maxVisible;
      
      visibleEvents.forEach(event => {
        html += `<div style="background: ${event.bgColor}; border-left: 4px solid ${event.borderColor}; color: ${event.textColor}; font-size: 12px; font-weight: 600; padding: 5px 10px; border-radius: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: default;" title="${event.title}${event.subtitle ? ' - ' + event.subtitle : ''}">${event.title}</div>`;
      });
      
      // Show "+X more" if there are more events
      if (remainingCount > 0) {
        const eventsJson = JSON.stringify(allEvents).replace(/"/g, '&quot;');
        html += `<div onclick='showEventsPopup(${day}, ${JSON.stringify(allEvents)})' style="background: #e5e7eb; color: #374151; font-size: 12px; font-weight: 600; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-align: center; transition: all 0.2s;" onmouseover="this.style.background='#d1d5db'" onmouseout="this.style.background='#e5e7eb'">+${remainingCount} more</div>`;
      }
      
      html += `</div>`;
      html += '</td>';
      dayCount++;
    }
    
    if (i % 7 === 6) {
      html += '</tr>';
    }
  }
  
  document.getElementById('calendarBody').innerHTML = html;
}

// Initialize calendar on page load
document.addEventListener('DOMContentLoaded', function() {
  renderCalendar();
  
  const employeeSelector = document.getElementById('employeeSelector');
  if (employeeSelector) {
    employeeSelector.addEventListener('change', function() {
      document.getElementById('selectedEmployeeId').value = this.value;
    });
  }
  
  const notesTextarea = document.getElementById('notesTextarea');
  const empNotesTextarea = document.getElementById('empNotesTextarea');
  
  if (notesTextarea) {
    notesTextarea.addEventListener('keydown', function(e) {
      if (e.ctrlKey && e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('notesForm').dispatchEvent(new Event('submit', { cancelable: true }));
      }
    });
  }
  
  if (empNotesTextarea) {
    empNotesTextarea.addEventListener('keydown', function(e) {
      if (e.ctrlKey && e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('empNotesForm').dispatchEvent(new Event('submit', { cancelable: true }));
      }
    });
  }
});

// AJAX Note Submission
function submitNote(event, type) {
  event.preventDefault();
  
  const form = event.target;
  const textarea = form.querySelector('textarea');
  const button = form.querySelector('button[type="submit"]');
  const noteText = textarea.value.trim();
  
  if (!noteText) {
    showMessage('Please enter a note', 'error');
    return;
  }
  
  // For employee notes, check if employee is selected (for admin)
  if (type === 'empNotes') {
    const employeeSelector = document.getElementById('employeeSelector');
    if (employeeSelector && employeeSelector.value === '') {
      // If selector exists but no employee selected, show error
      if (employeeSelector.style.display !== 'none') {
        showMessage('Please select an employee', 'error');
        return;
      }
    }
  }
  
  // Disable button and show loading
  button.disabled = true;
  button.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle></svg>';
  
  // Prepare form data
  const formData = new FormData();
  formData.append('note_text', noteText);
  formData.append('note_type', type);
  
  // Add employee_id if it's an employee note and admin selected someone
  if (type === 'empNotes') {
    const employeeId = document.getElementById('selectedEmployeeId').value;
    if (employeeId) {
      formData.append('employee_id', employeeId);
    }
  }
  
  formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
  
  // Submit via AJAX
  fetch('{{ route("employee.notes.store") }}', {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showMessage(data.message, 'success');
      textarea.value = '';
      
      // Clear employee selector
      const employeeSelector = document.getElementById('employeeSelector');
      if (employeeSelector) {
        employeeSelector.value = '';
        document.getElementById('selectedEmployeeId').value = '';
      }
      
      // Reload notes
      const noteType = type === 'notes' ? 'system' : 'employee';
      loadNotes(noteType, 1);
    } else {
      showMessage(data.message || 'Failed to save note', 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showMessage('Network error. Please try again.', 'error');
  })
  .finally(() => {
    button.disabled = false;
    button.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>';
  });
}

// Load Notes via AJAX
function loadNotes(type, page = 1) {
  const url = `{{ route('employee.notes.get') }}?type=${type}&page=${page}`;
  
  fetch(url, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      renderNotes(type, data.notes, data.currentPage, data.pages);
    } else {
      console.error('Failed to load notes:', data.message);
    }
  })
  .catch(error => {
    console.error('Error loading notes:', error);
  });
}

// Helper function to truncate text
function truncateNoteText(text, maxLength) {
  if (!text || text.length <= maxLength) return { text: text, truncated: false };
  return { text: text.substring(0, maxLength).trim() + '...', truncated: true };
}

// Helper function to escape HTML
function escapeHtmlText(text) {
  var div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Render Notes in UI
function renderNotes(type, notes, currentPage, totalPages) {
  const containerId = type === 'system' ? 'systemNotesContainer' : 'empNotesContainer';
  const maxLength = 100; // Max characters before truncation
  
  let container = document.getElementById(containerId);
  if (!container) {
    console.error('Container not found:', containerId);
    return;
  }
  
  // Render notes based on type
  if (type === 'system') {
    // System notes use horizontal scroll layout
    if (notes.length === 0) {
      container.innerHTML = `<div style="text-align: center; padding: 40px; color: #9ca3af; font-size: 13px; width: 100%;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px; opacity: 0.3;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
        <div>No notes yet. Add your first note above!</div>
      </div>`;
    } else {
      container.innerHTML = notes.map(note => {
        const truncated = truncateNoteText(note.text, maxLength);
        const readMoreHtml = truncated.truncated ? 
          `<span class="read-more-link" data-full-text="${encodeURIComponent(note.text)}" data-date="${note.date}" data-assignees="" onclick="openNoteFromData(this)">Read More <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>` : '';
        
        return `
        <div class="note-card">
          <div class="note-card-text">${escapeHtmlText(truncated.text)}</div>
          ${readMoreHtml}
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
            <span style="font-size: 12px; color: #9ca3af;">${note.date}</span>
            <button onclick="deleteNote(${note.id}, 'system')" style="width: 24px; height: 24px; border-radius: 50%; background: #fee2e2; border: none; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='white';" onmouseout="this.style.background='#fee2e2'; this.style.color='#dc2626';">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
          </div>
        </div>
      `}).join('');
    }
  } else {
    // Employee notes use horizontal scroll layout
    if (notes.length === 0) {
      container.innerHTML = `<div style="display: flex; gap: 14px; min-width: max-content; padding: 4px;">
        <div style="text-align: center; padding: 40px; color: #9ca3af; font-size: 13px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; width: 100%;">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 12px; opacity: 0.3;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          <div>No employee notes yet. Add your first note above!</div>
        </div>
      </div>`;
    } else {
      container.innerHTML = `<div style="display: flex; gap: 14px; min-width: max-content; padding: 4px;">
        ${notes.map(note => {
          const truncated = truncateNoteText(note.text, maxLength);
          const assigneesList = note.assignees || ['Employee'];
          const readMoreHtml = truncated.truncated ? 
            `<span class="read-more-link" data-full-text="${encodeURIComponent(note.text)}" data-date="${note.date}" data-assignees="${encodeURIComponent(JSON.stringify(assigneesList))}" onclick="openNoteFromData(this)">Read More <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>` : '';
          
          return `
          <div class="note-card-blue">
            <div class="note-card-blue-text">${escapeHtmlText(truncated.text)}</div>
            ${readMoreHtml}
            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; margin-top: 8px;">
              ${assigneesList.map(assignee => `<span style="display: inline-flex; align-items: center; padding: 5px 12px; background: #dbeafe; color: #1e40af; border-radius: 6px; font-size: 12px; font-weight: 600;">${escapeHtmlText(assignee)}</span>`).join('')}
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 12px; color: #9ca3af;">${note.date}</span>
              <button onclick="deleteNote(${note.id}, 'employee')" style="width: 22px; height: 22px; border-radius: 50%; background: #fee2e2; border: none; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
              </button>
            </div>
          </div>
        `}).join('')}
      </div>`;
    }
  }
  
}

// Delete Note
function deleteNote(noteId, type) {
  if (!confirm('Are you sure you want to delete this note?')) {
    return;
  }
  
  fetch(`{{ url('/employee/notes') }}/${noteId}`, {
    method: 'DELETE',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showMessage('Note deleted successfully!', 'success');
      loadNotes(type, 1);
    } else {
      showMessage(data.message || 'Failed to delete note', 'error');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showMessage('Network error. Please try again.', 'error');
  });
}

// Show Message
function showMessage(message, type) {
  const messageDiv = document.createElement('div');
  messageDiv.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 20px;
    border-radius: 8px;
    color: white;
    font-size: 14px;
    font-weight: 600;
    z-index: 9999;
    animation: slideIn 0.3s ease;
    background: ${type === 'success' ? '#10b981' : '#ef4444'};
  `;
  messageDiv.textContent = message;
  
  const style = document.createElement('style');
  style.textContent = `
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
  `;
  document.head.appendChild(style);
  
  document.body.appendChild(messageDiv);
  
  setTimeout(() => {
    messageDiv.remove();
    style.remove();
  }, 3000);
}

</script>
@endsection
