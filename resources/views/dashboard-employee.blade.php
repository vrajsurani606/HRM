@extends('layouts.macos')

@section('page_title', 'Dashboard Overview')

@push('styles')
<style>
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
    padding-bottom: 100px; /* Extra space for footer */
    background: #f7f4f1;
    min-height: calc(100vh - 60px);
  }* Dashboard content wrapper */
  .dashboard-content-wrapper {
    padding: 20px;
    background: #f7f4f1;
    min-height: 100%;
  }
</style>
@endpush

@section('content')
<div class="dashboard-content-wrapper">
  
  <!-- KPI Cards Row -->
  <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 16px;">
    
    <!-- Present Day Card -->
    <div style="background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%); border-radius: 16px; padding: 18px 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 48px; height: 48px; background: #3b82f6; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <img src="{{ asset('dashboard-emp/calendar.svg') }}" alt="Calendar" style="width: 26px; height: 26px;">
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #1e40af; line-height: 1; margin-bottom: 2px;">0{{ $stats['present_days'] ?? '41' }}</div>
          <div style="font-size: 11px; font-weight: 600; color: #1e40af;">Present Day</div>
        </div>
      </div>
    </div>

    <!-- Working Hours Card -->
    <div style="background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%); border-radius: 16px; padding: 18px 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 48px; height: 48px; background: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <img src="{{ asset('dashboard-emp/watch.svg') }}" alt="Watch" style="width: 26px; height: 26px;">
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #065f46; line-height: 1; margin-bottom: 2px;">{{ isset($stats['working_hours']) ? number_format($stats['working_hours'], 1) : '312.1' }}</div>
          <div style="font-size: 11px; font-weight: 600; color: #065f46;">Working Hours</div>
        </div>
      </div>
    </div>

    <!-- Late Entries Card -->
    <div style="background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); border-radius: 16px; padding: 18px 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 48px; height: 48px; background: #f59e0b; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <img src="{{ asset('dashboard-emp/late.svg') }}" alt="Late" style="width: 26px; height: 26px;">
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #92400e; line-height: 1; margin-bottom: 2px;">0{{ $stats['late_entries'] ?? '37' }}</div>
          <div style="font-size: 11px; font-weight: 600; color: #92400e;">Late Entries</div>
        </div>
      </div>
    </div>

    <!-- Early Exits Card -->
    <div style="background: linear-gradient(135deg, #fca5a5 0%, #f87171 100%); border-radius: 16px; padding: 18px 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 48px; height: 48px; background: #ef4444; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <img src="{{ asset('dashboard-emp/early.svg') }}" alt="Early" style="width: 26px; height: 26px;">
        </div>
        <div>
          <div style="font-size: 28px; font-weight: 700; color: #991b1b; line-height: 1; margin-bottom: 2px;">00{{ $stats['early_exits'] ?? '1' }}</div>
          <div style="font-size: 11px; font-weight: 600; color: #991b1b;">Early Exits</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Notes Section -->
  <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); margin-bottom: 16px;">
    <!-- Tabs - Left Aligned -->
    <div style="display: flex; background: #414141; border-radius: 16px 16px 0 0; justify-content: flex-start;">
      <button onclick="switchTab('notes')" id="notesTab" style="padding: 10px 24px; font-size: 11px; font-weight: 700; color: white; cursor: pointer; border: none; background: transparent; display: flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        NOTES
      </button>
      <button onclick="switchTab('empNotes')" id="empNotesTab" style="padding: 10px 24px; font-size: 11px; font-weight: 700; color: #9ca3af; cursor: pointer; border: none; background: transparent; display: flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.7;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        EMP. NOTES
      </button>
    </div>

    <!-- Notes Content -->
    <div id="notesContent" style="padding: 16px;">
      <div style="font-size: 13px; color: #1f2937; margin-bottom: 12px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Add New Notes</div>
      
      <form action="{{ route('employee.notes.store') }}" method="POST">
        @csrf
        <input type="hidden" name="note_type" value="notes">
        <div style="background: #f1f5f9; border-radius: 10px; padding: 14px; margin-bottom: 18px; position: relative; min-height: 100px;">
          <textarea name="note_text" placeholder="Type your note here..." required style="width: 100%; border: none; background: transparent; font-size: 13px; color: #475569; outline: none; resize: none; height: 70px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.5;"></textarea>
          <button type="submit" style="position: absolute; bottom: 14px; right: 14px; width: 36px; height: 36px; border-radius: 50%; background: #10b981; border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.4); transition: all 0.2s;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </div>
      </form>
      
      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 16px;">
        @forelse($systemNotes ?? [] as $note)
          <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 14px; min-height: 120px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
            <div style="font-size: 12px; color: #374151; line-height: 1.6; margin-bottom: 10px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $note['text'] }}</div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 10px; color: #9ca3af; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $note['date'] }}</span>
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
          <div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: #9ca3af; font-size: 13px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            No notes yet. Add your first note above!
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if(($systemNotesTotalPages ?? 1) > 1)
        <div style="display: flex; justify-content: center; align-items: center; gap: 6px; padding: 12px 0; border-top: 1px solid #e5e7eb;">
          @if($notesPage > 1)
            <a href="?notes_page=1" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">«</a>
            <a href="?notes_page={{ $notesPage - 1 }}" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">‹</a>
          @endif
          
          @for($i = max(1, $notesPage - 2); $i <= min($systemNotesTotalPages, $notesPage + 2); $i++)
            <a href="?notes_page={{ $i }}" style="min-width: 28px; height: 28px; padding: 0 8px; border: none; background: {{ $i == $notesPage ? '#10b981' : '#f3f4f6' }}; color: {{ $i == $notesPage ? 'white' : '#6b7280' }}; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: {{ $i == $notesPage ? '600' : '500' }}; display: flex; align-items: center; justify-content: center; text-decoration: none; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s;" onmouseover="if({{ $i != $notesPage }}) this.style.background='#e5e7eb'" onmouseout="if({{ $i != $notesPage }}) this.style.background='#f3f4f6'">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
          @endfor
          
          @if($notesPage < $systemNotesTotalPages)
            <a href="?notes_page={{ $notesPage + 1 }}" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">›</a>
            <a href="?notes_page={{ $systemNotesTotalPages }}" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">»</a>
          @endif
        </div>
      @endif
    </div>

    <!-- Emp Notes Content -->
    <div id="empNotesContent" style="padding: 16px; display: none;">
      <div style="font-size: 13px; color: #1f2937; margin-bottom: 12px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Add Employee Note</div>
      
      <form action="{{ route('employee.notes.store') }}" method="POST">
        @csrf
        <input type="hidden" name="note_type" value="empNotes">
        <div style="background: #f1f5f9; border-radius: 10px; padding: 14px; margin-bottom: 18px; position: relative; min-height: 100px;">
          <textarea name="note_text" placeholder="Type employee note here..." required style="width: 100%; border: none; background: transparent; font-size: 13px; color: #475569; outline: none; resize: none; height: 70px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.5;"></textarea>
          <button type="submit" style="position: absolute; bottom: 14px; right: 14px; width: 36px; height: 36px; border-radius: 50%; background: #3b82f6; border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 6px rgba(59, 130, 246, 0.4); transition: all 0.2s;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </div>
      </form>
      
      <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 16px;">
        @forelse($empNotes ?? [] as $note)
          <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
              <div style="font-size: 13px; color: #374151; line-height: 1.6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; flex: 1;">{{ $note['text'] ?? 'No content' }}</div>
              <form action="{{ route('employee.notes.delete', $note['id']) }}" method="POST" style="margin: 0 0 0 12px;" onsubmit="return confirm('Are you sure you want to delete this note?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="width: 24px; height: 24px; border-radius: 50%; background: #fee2e2; border: none; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; flex-shrink: 0;" onmouseover="this.style.background='#ef4444'; this.style.color='white';" onmouseout="this.style.background='#fee2e2'; this.style.color='#dc2626';">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
              </form>
            </div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px;">
              @if(isset($note['assignees']) && is_array($note['assignees']))
                @foreach($note['assignees'] as $assignee)
                  <span style="display: inline-flex; align-items: center; padding: 5px 12px; background: #3b82f6; color: white; border-radius: 6px; font-size: 11px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $assignee }}</span>
                @endforeach
              @else
                <span style="display: inline-flex; align-items: center; padding: 5px 12px; background: #3b82f6; color: white; border-radius: 6px; font-size: 11px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ auth()->user()->name ?? 'Employee' }}</span>
              @endif
            </div>
            <div style="display: flex; align-items: center; gap: 14px; font-size: 11px; color: #9ca3af; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
              <span style="display: flex; align-items: center; gap: 4px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                {{ $note['date'] ?? now()->format('M d, Y') }}
              </span>
              <span style="display: flex; align-items: center; gap: 4px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                No expiration
              </span>
            </div>
          </div>
        @empty
          <div style="text-align: center; padding: 40px; color: #9ca3af; font-size: 13px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 12px; opacity: 0.3;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <div>No employee notes yet. Add your first note above!</div>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if(($empNotesTotalPages ?? 1) > 1)
        <div style="display: flex; justify-content: center; align-items: center; gap: 6px; padding: 12px 0; border-top: 1px solid #e5e7eb;">
          @if($empNotesPage > 1)
            <a href="?emp_notes_page=1" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">«</a>
            <a href="?emp_notes_page={{ $empNotesPage - 1 }}" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">‹</a>
          @endif
          
          @for($i = max(1, $empNotesPage - 2); $i <= min($empNotesTotalPages, $empNotesPage + 2); $i++)
            <a href="?emp_notes_page={{ $i }}" style="min-width: 28px; height: 28px; padding: 0 8px; border: none; background: {{ $i == $empNotesPage ? '#3b82f6' : '#f3f4f6' }}; color: {{ $i == $empNotesPage ? 'white' : '#6b7280' }}; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: {{ $i == $empNotesPage ? '600' : '500' }}; display: flex; align-items: center; justify-content: center; text-decoration: none; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s;" onmouseover="if({{ $i != $empNotesPage }}) this.style.background='#e5e7eb'" onmouseout="if({{ $i != $empNotesPage }}) this.style.background='#f3f4f6'">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
          @endfor
          
          @if($empNotesPage < $empNotesTotalPages)
            <a href="?emp_notes_page={{ $empNotesPage + 1 }}" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">›</a>
            <a href="?emp_notes_page={{ $empNotesTotalPages }}" style="width: 28px; height: 28px; border: none; background: #f3f4f6; border-radius: 6px; cursor: pointer; color: #6b7280; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">»</a>
          @endif
        </div>
      @endif
    </div>
  </div>

  <!-- Calendar Section - Full Width -->
  <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); margin-bottom: 20px;">
      <!-- Calendar Header -->
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div style="display: flex; align-items: center; gap: 8px;">
          <div style="width: 32px; height: 32px; background: #10b981; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
          </div>
          <h3 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Events & Holidays Calendar</h3>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
          <button onclick="changeMonth(-1)" style="width: 30px; height: 30px; border-radius: 6px; background: #f3f4f6; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-weight: 700; font-size: 16px; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">‹</button>
          <div style="display: flex; align-items: center; gap: 6px; min-width: 140px; justify-content: center;">
            <span id="currentMonth" style="font-size: 13px; font-weight: 600; color: #1f2937; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ now()->format('F') }}</span>
            <span style="font-size: 13px; color: #d1d5db;">|</span>
            <span id="currentYear" style="font-size: 13px; font-weight: 600; color: #1f2937; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ now()->format('Y') }}</span>
          </div>
          <button onclick="changeMonth(1)" style="width: 30px; height: 30px; border-radius: 6px; background: #f3f4f6; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-weight: 700; font-size: 16px; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">›</button>
          <button onclick="goToToday()" style="padding: 5px 10px; border-radius: 6px; background: #10b981; color: white; border: none; cursor: pointer; font-size: 11px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Today</button>
        </div>
      </div>

      <!-- Calendar Table -->
      <table id="calendarTable" style="width: 100%; table-layout: fixed; border-collapse: collapse; margin-bottom: 16px;">
        <thead>
          <tr>
            <th style="width: 14.28%; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Sunday</th>
            <th style="width: 14.28%; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Monday</th>
            <th style="width: 14.28%; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Tuesday</th>
            <th style="width: 14.28%; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Wednesday</th>
            <th style="width: 14.28%; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Thursday</th>
            <th style="width: 14.28%; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Friday</th>
            <th style="width: 14.28%; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Saturday</th>
          </tr>
        </thead>
        <tbody id="calendarBody">
          <!-- Calendar will be rendered by JavaScript -->
        </tbody>
      </table>

      <!-- Legend -->
      <div style="display: flex; flex-wrap: wrap; gap: 14px; align-items: center; padding-top: 14px; border-top: 1px solid #e5e7eb;">
        <div style="display: flex; align-items: center; gap: 6px;">
          <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
          <span style="font-size: 12px; color: #6b7280; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Present</span>
        </div>
        <div style="display: flex; align-items: center; gap: 6px;">
          <div style="width: 10px; height: 10px; border-radius: 50%; background: #fbbf24;"></div>
          <span style="font-size: 12px; color: #6b7280; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Late</span>
        </div>
        <div style="display: flex; align-items: center; gap: 6px;">
          <div style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></div>
          <span style="font-size: 12px; color: #6b7280; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Early Exit</span>
        </div>
        <div style="display: flex; align-items: center; gap: 6px;">
          <div style="width: 10px; height: 10px; border-radius: 50%; background: #a855f7;"></div>
          <span style="font-size: 12px; color: #6b7280; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Leave</span>
        </div>
        <div style="display: flex; align-items: center; gap: 6px;">
          <span style="font-size: 16px;">🎂</span>
          <span style="font-size: 12px; color: #6b7280; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Birthday</span>
        </div>
        <div style="display: flex; align-items: center; gap: 6px;">
          <span style="font-size: 16px;">🏖️</span>
          <span style="font-size: 12px; color: #6b7280; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">On Leave</span>
        </div>
      </div>
    </div>

  </div>
</div>

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

// Calendar data from backend
const calendarData = {
  attendance: @json($attendanceCalendar ?? []),
  leaves: @json($leavesCalendar ?? []),
  birthdays: @json($birthdaysCalendar ?? []),
  today: {
    day: {{ now()->day }},
    month: {{ now()->month }},
    year: {{ now()->year }}
  }
};

// Calendar navigation
let currentDate = new Date();

function changeMonth(direction) {
  currentDate.setMonth(currentDate.getMonth() + direction);
  renderCalendar();
}

function goToToday() {
  currentDate = new Date();
  renderCalendar();
}

function renderCalendar() {
  const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];
  
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();
  
  // Update header
  document.getElementById('currentMonth').textContent = monthNames[month];
  document.getElementById('currentYear').textContent = year;
  
  // Calculate calendar data
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const today = new Date();
  const isCurrentMonth = (year === today.getFullYear() && month === today.getMonth());
  
  // Build calendar HTML
  let html = '';
  let dayCount = 1;
  let totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
  
  for (let i = 0; i < totalCells; i++) {
    if (i % 7 === 0) {
      html += '<tr>';
    }
    
    if (i < firstDay || dayCount > daysInMonth) {
      html += '<td style="text-align: center; padding: 8px; border: 1px solid #f3f4f6; background: white; vertical-align: top; height: 80px;"></td>';
    } else {
      const day = dayCount;
      const isToday = isCurrentMonth && day === today.getDate();
      const bgColor = isToday ? '#dbeafe' : 'white';
      const borderColor = isToday ? '#3b82f6' : '#f3f4f6';
      const fontWeight = isToday ? '700' : '500';
      
      // Check for birthdays
      const dayBirthdays = calendarData.birthdays[day] || [];
      const dayLeaves = calendarData.leaves[day] || [];
      const dayStatus = calendarData.attendance[day] || null;
      
      html += `<td style="text-align: center; padding: 10px 8px; border: 1px solid ${borderColor}; background: ${bgColor}; vertical-align: top; height: 90px; position: relative;">`;
      html += `<div style="font-size: 14px; font-weight: ${fontWeight}; color: #1f2937; margin-bottom: 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">${day}</div>`;
      
      // Birthday indicator
      if (dayBirthdays.length > 0) {
        const names = dayBirthdays.map(b => b.name).join(', ');
        html += `<div style="display: flex; align-items: center; justify-content: center; gap: 2px; margin-bottom: 2px;" title="Birthday: ${names}">`;
        html += `<span style="font-size: 18px;">🎂</span>`;
        if (dayBirthdays.length > 1) {
          html += `<span style="font-size: 9px; color: #ef4444; font-weight: 600;">+${dayBirthdays.length}</span>`;
        }
        html += `</div>`;
      }
      
      // Leave indicator
      if (dayLeaves.length > 0) {
        const names = dayLeaves.map(l => l.name).join(', ');
        html += `<div style="display: flex; align-items: center; justify-content: center; gap: 2px; margin-bottom: 2px;" title="On Leave: ${names}">`;
        html += `<div style="width: 22px; height: 22px; background: #fef3c7; border-radius: 4px; display: flex; align-items: center; justify-content: center;">`;
        html += `<span style="font-size: 12px;">🏖️</span>`;
        html += `</div>`;
        if (dayLeaves.length > 1) {
          html += `<span style="font-size: 9px; color: #f59e0b; font-weight: 600;">+${dayLeaves.length}</span>`;
        }
        html += `</div>`;
      }
      
      // Attendance status dot
      if (dayStatus) {
        let dotColor = '#10b981'; // present
        if (dayStatus === 'late') dotColor = '#fbbf24';
        else if (dayStatus === 'early_leave') dotColor = '#ef4444';
        else if (dayStatus === 'half_day') dotColor = '#3b82f6';
        else if (dayStatus === 'leave') dotColor = '#a855f7';
        else if (dayStatus === 'absent') dotColor = '#dc2626';
        
        html += `<div style="position: absolute; bottom: 4px; right: 4px; width: 7px; height: 7px; border-radius: 50%; background: ${dotColor};"></div>`;
      }
      
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
});
</script>
@endsection
