@extends('layouts.macos')

@section('page_title', 'Dashboard Overview')

@section('content')
<div style="padding: 20px; background: #f7f4f1; min-height: 100vh;">
  
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
    <!-- Tabs -->
    <div style="display: flex; background: #414141; border-radius: 16px 16px 0 0;">
      <button onclick="switchTab('notes')" id="notesTab" style="flex: 1; padding: 10px 20px; font-size: 11px; font-weight: 700; color: white; cursor: pointer; border: none; background: transparent; display: flex; align-items: center; justify-content: center; gap: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
        <img src="{{ asset('dashboard-emp/notes.svg') }}" alt="Notes" style="width: 16px; height: 20px;">
        NOTES
      </button>
      <button onclick="switchTab('empNotes')" id="empNotesTab" style="flex: 1; padding: 10px 20px; font-size: 11px; font-weight: 700; color: #9ca3af; cursor: pointer; border: none; background: transparent; display: flex; align-items: center; justify-content: center; gap: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
        <img src="{{ asset('dashboard-emp/users.svg') }}" alt="Users" style="width: 22px; height: 16px; opacity: 0.7;">
        EMP. NOTES
      </button>
    </div>

    <!-- Notes Content -->
    <div id="notesContent" style="padding: 16px;">
      <div style="font-size: 12px; color: #0f172a; margin-bottom: 10px; font-weight: 600;">Add New Notes</div>
      
      <form action="{{ route('employee.notes.store') }}" method="POST">
        @csrf
        <div style="background: #f1f5f9; border-radius: 8px; padding: 12px; margin-bottom: 16px; position: relative; min-height: 90px;">
          <textarea name="note_text" placeholder="Enter your Note..." required style="width: 100%; border: none; background: transparent; font-size: 11px; color: #94a3b8; outline: none; resize: none; height: 60px; font-family: inherit;"></textarea>
          <button type="submit" style="position: absolute; bottom: 12px; right: 12px; width: 32px; height: 32px; border-radius: 50%; background: #10b981; border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
            <img src="{{ asset('dashboard-emp/send.svg') }}" alt="Send" style="width: 14px; height: 14px;">
          </button>
        </div>
      </form>
      
      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 12px;">
        @php
          $sampleNotes = $notes ?? [];
          if (empty($sampleNotes)) {
            $sampleNotes = [
              ['text' => 'Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem has been the industry\'s standard dummy text ever since the 1500s', 'date' => 'Oct 25, 2025 9:47 AM'],
              ['text' => 'Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem has been the industry\'s standard dummy text ever since the 1500s', 'date' => 'Oct 25, 2025 9:47 AM'],
              ['text' => 'Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem has been the industry\'s standard dummy text ever since the 1500s', 'date' => 'Oct 25, 2025 9:47 AM'],
              ['text' => 'Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem has been the industry\'s standard dummy text ever since the 1500s', 'date' => 'Oct 25, 2025 9:47 AM'],
            ];
          }
        @endphp
        
        @foreach($sampleNotes as $note)
          <div style="background: #f9fafb; border-radius: 10px; padding: 10px; min-height: 100px; display: flex; flex-direction: column; justify-content: space-between;">
            <div style="font-size: 10px; color: #374151; line-height: 1.4; margin-bottom: 8px; font-weight: 500;">{{ $note['text'] }}</div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 9px; color: #9ca3af;">{{ $note['date'] }}</span>
              <div style="width: 14px; height: 14px; border-radius: 50%; background: #ef4444; cursor: pointer;"></div>
            </div>
          </div>
        @endforeach
      </div>

      <div style="display: flex; justify-content: center; align-items: center; gap: 4px; padding: 8px 0; border-top: 1px solid #e5e7eb;">
        <button style="width: 18px; height: 18px; border: none; background: transparent; cursor: pointer; color: #6b7280; font-size: 12px;">⏮</button>
        <span style="font-size: 9px; color: #ef4444; padding: 0 2px; cursor: pointer; font-weight: 600;">01</span>
        <span style="font-size: 9px; color: #6b7280; padding: 0 2px; cursor: pointer;">02</span>
        <span style="font-size: 9px; color: #6b7280; padding: 0 2px; cursor: pointer;">03</span>
        <span style="font-size: 9px; color: #6b7280; padding: 0 2px; cursor: pointer;">04</span>
        <span style="font-size: 9px; color: #6b7280; padding: 0 2px; cursor: pointer;">05</span>
        <span style="font-size: 9px; color: #6b7280; padding: 0 2px;">...</span>
        <span style="font-size: 9px; color: #6b7280; padding: 0 2px; cursor: pointer;">20</span>
        <button style="width: 18px; height: 18px; border: none; background: transparent; cursor: pointer; color: #6b7280; font-size: 12px;">⏭</button>
      </div>
    </div>

    <!-- Emp Notes Content -->
    <div id="empNotesContent" style="padding: 16px; display: none;">
      <div style="display: flex; flex-direction: column; gap: 12px;">
        @forelse(($notes ?? []) as $note)
          <div style="background: #f9fafb; border-radius: 10px; padding: 14px;">
            <div style="font-size: 12px; color: #475569; line-height: 1.5; margin-bottom: 12px;">{{ $note['text'] ?? 'No content' }}</div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px;">
              @if(isset($note['assignees']) && is_array($note['assignees']))
                @foreach($note['assignees'] as $assignee)
                  <span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #267bf5; color: white; border-radius: 4px; font-size: 11px; font-weight: 500;">{{ $assignee }}</span>
                @endforeach
              @else
                <span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #267bf5; color: white; border-radius: 4px; font-size: 11px; font-weight: 500;">{{ auth()->user()->name ?? 'Employee' }}</span>
              @endif
            </div>
            <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #6b7280;">
              <span>⏰ {{ $note['date'] ?? now()->format('M d, Y') }}</span>
              <span>⏳ No expiration</span>
            </div>
          </div>
        @empty
          <div style="background: #f9fafb; border-radius: 10px; padding: 14px;">
            <div style="font-size: 12px; color: #475569; line-height: 1.5; margin-bottom: 12px;">No employee notes available yet.</div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px;">
              <span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #267bf5; color: white; border-radius: 4px; font-size: 11px; font-weight: 500;">{{ auth()->user()->name ?? 'Employee' }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #6b7280;">
              <span>⏰ {{ now()->format('M d, Y') }}</span>
              <span>⏳ No expiration</span>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Calendar Section -->
  <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
    <!-- Calendar Header -->
    <div style="text-align: center; margin-bottom: 20px;">
      <div style="display: inline-flex; align-items: center; gap: 12px;">
        <select style="padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 15px; font-weight: 600; color: #1f2937; cursor: pointer; background: white; outline: none;">
          <option>July ▼</option>
        </select>
        <span style="font-size: 18px; color: #d1d5db; font-weight: 300;">|</span>
        <select style="padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 15px; font-weight: 600; color: #1f2937; cursor: pointer; background: white; outline: none;">
          <option>2025 ▼</option>
        </select>
      </div>
    </div>

    <!-- Calendar Table -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
      <thead>
        <tr>
          <th style="text-align: left; font-size: 11px; font-weight: 600; color: #6b7280; padding: 10px; border-bottom: 1px solid #e5e7eb;">Monday</th>
          <th style="text-align: left; font-size: 11px; font-weight: 600; color: #6b7280; padding: 10px; border-bottom: 1px solid #e5e7eb;">Tuesday</th>
          <th style="text-align: left; font-size: 11px; font-weight: 600; color: #6b7280; padding: 10px; border-bottom: 1px solid #e5e7eb;">Wednesday</th>
          <th style="text-align: left; font-size: 11px; font-weight: 600; color: #6b7280; padding: 10px; border-bottom: 1px solid #e5e7eb;">Thursday</th>
          <th style="text-align: left; font-size: 11px; font-weight: 600; color: #6b7280; padding: 10px; border-bottom: 1px solid #e5e7eb;">Friday</th>
          <th style="text-align: left; font-size: 11px; font-weight: 600; color: #6b7280; padding: 10px; border-bottom: 1px solid #e5e7eb;">Saturday</th>
          <th style="text-align: left; font-size: 11px; font-weight: 600; color: #6b7280; padding: 10px; border-bottom: 1px solid #e5e7eb;">Sunday</th>
        </tr>
      </thead>
      <tbody>
        @php
          $today = now()->day;
          $daysInMonth = now()->daysInMonth;
          $firstDayOfMonth = now()->startOfMonth()->dayOfWeekIso;
          $attendanceCalendar = $attendanceCalendar ?? [];
          
          $weeks = [];
          $currentWeek = [];
          
          // Add empty cells before first day
          for ($i = 1; $i < $firstDayOfMonth; $i++) {
            $currentWeek[] = ['day' => '', 'empty' => true];
          }
          
          // Add all days of the month
          for ($day = 1; $day <= $daysInMonth; $day++) {
            $status = $attendanceCalendar[$day] ?? null;
            $currentWeek[] = [
              'day' => $day,
              'status' => $status,
              'isToday' => $day === $today,
              'empty' => false
            ];
            
            // If week is complete (7 days), start new week
            if (count($currentWeek) === 7) {
              $weeks[] = $currentWeek;
              $currentWeek = [];
            }
          }
          
          // Fill remaining cells in last week
          while (count($currentWeek) > 0 && count($currentWeek) < 7) {
            $currentWeek[] = ['day' => '', 'empty' => true];
          }
          if (count($currentWeek) > 0) {
            $weeks[] = $currentWeek;
          }
        @endphp
        
        @foreach($weeks as $week)
          <tr>
            @foreach($week as $cell)
              @php
                $bgColor = 'white';
                $textColor = '#1f2937';
                $fontWeight = '500';
                
                if (!$cell['empty'] && isset($cell['status'])) {
                  $status = $cell['status'];
                  if ($status === 'present') {
                    $bgColor = '#d1fae5';
                    $textColor = '#065f46';
                  } elseif ($status === 'late') {
                    $bgColor = '#fef3c7';
                    $textColor = '#92400e';
                  } elseif ($status === 'early_leave') {
                    $bgColor = '#fee2e2';
                    $textColor = '#991b1b';
                  } elseif ($status === 'half_day') {
                    $bgColor = '#dbeafe';
                    $textColor = '#1e40af';
                  } elseif ($status === 'leave') {
                    $bgColor = '#e9d5ff';
                    $textColor = '#6b21a8';
                  } elseif ($status === 'absent') {
                    $bgColor = '#fecaca';
                    $textColor = '#7f1d1d';
                  }
                }
                
                if (!$cell['empty'] && isset($cell['isToday']) && $cell['isToday']) {
                  $bgColor = '#3b82f6';
                  $textColor = 'white';
                  $fontWeight = '700';
                }
              @endphp
              
              <td style="text-align: left; padding: 16px; border-bottom: 1px solid #e5e7eb; background: {{ $bgColor }}; color: {{ $textColor }}; font-size: 14px; font-weight: {{ $fontWeight }}; min-height: 50px; vertical-align: top;">
                {{ $cell['day'] }}
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Legend -->
    <div style="display: flex; flex-wrap: wrap; gap: 14px; align-items: center;">
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></div>
        <span style="font-size: 12px; color: #4b5563; font-weight: 500;">Present</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 50%; background: #fbbf24;"></div>
        <span style="font-size: 12px; color: #4b5563; font-weight: 500;">Late Entry</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></div>
        <span style="font-size: 12px; color: #4b5563; font-weight: 500;">Early Exit</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 50%; background: #3b82f6;"></div>
        <span style="font-size: 12px; color: #4b5563; font-weight: 500;">Half Exit</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 50%; background: #a855f7;"></div>
        <span style="font-size: 12px; color: #4b5563; font-weight: 500;">Leave</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <div style="width: 12px; height: 12px; border-radius: 50%; background: #dc2626;"></div>
        <span style="font-size: 12px; color: #4b5563; font-weight: 500;">Absent</span>
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
    notesTab.querySelector('img').style.opacity = '1';
    empNotesTab.style.color = '#9ca3af';
    empNotesTab.querySelector('img').style.opacity = '0.7';
    notesContent.style.display = 'block';
    empNotesContent.style.display = 'none';
  } else {
    empNotesTab.style.color = 'white';
    empNotesTab.querySelector('img').style.opacity = '1';
    notesTab.style.color = '#9ca3af';
    notesTab.querySelector('img').style.opacity = '0.7';
    notesContent.style.display = 'none';
    empNotesContent.style.display = 'block';
  }
}
</script>
@endsection
