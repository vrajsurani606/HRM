@extends('layouts.macos')
@section('page_title', 'Leave Management')

@section('content')
<div class="inquiry-index-container">
  <!-- Header Actions -->
  <div style="display: flex; justify-content: flex-end; margin-bottom: 16px; padding: 0 4px;">
    <a href="{{ route('leaves.create') }}" class="pill-btn pill-success">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;">
        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
      </svg>
      Create Leave Request
    </a>
  </div>

  <!-- Leave Requests Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th style="text-align: center;">Type</th>
          <th style="text-align: center;">Category</th>
          <th style="text-align: center;">Dates</th>
          <th style="text-align: center;">Days</th>
          <th style="text-align: center;">Description</th>
          <th style="text-align: center;">Status</th>
          <th style="text-align: center;">Applied</th>
        </tr>
      </thead>
      <tbody>
        @forelse($leaves as $leave)
        <tr>
          <td style="padding: 12px 8px; text-align: center;">
            <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;
              @if($leave->leave_type == 'casual') background: #dbeafe; color: #0c4a6e;
              @elseif($leave->leave_type == 'medical') background: #fee2e2; color: #991b1b;
              @elseif($leave->leave_type == 'personal') background: #fef3c7; color: #92400e;
              @else background: #fbbf24; color: #78350f;
              @endif
            ">{{ ucfirst($leave->leave_type) }}</span>
          </td>
          <td style="padding: 12px 8px; text-align: center;">
            <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;
              @if($leave->is_paid) background: #d1fae5; color: #065f46;
              @else background: #f3f4f6; color: #374151;
              @endif
            ">{{ $leave->is_paid ? 'Paid' : 'Unpaid' }}</span>
          </td>
          <td style="padding: 12px 8px; text-align: center; color: #1f2937; font-size: 14px;">
            {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M, Y') }}
          </td>
          <td style="padding: 12px 8px; text-align: center;">
            <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 600; color: #0f172a; font-size: 13px;">{{ $leave->total_days }}</span>
          </td>
          <td style="padding: 12px 8px; text-align: center; color: #6b7280; font-size: 13px;">{{ $leave->reason ?? '-' }}</td>
          <td style="padding: 12px 8px; text-align: center;">
            @php
              $statusColors = [
                'approved' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
              ];
              $statusColor = $statusColors[$leave->status] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
            @endphp
            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }};">
              {{ ucfirst($leave->status) }}
            </span>
          </td>
          <td style="padding: 12px 8px; text-align: center; color: #6b7280; font-size: 13px;">{{ $leave->created_at->format('d M, Y') }}</td>
        </tr>
        @empty
          <x-empty-state 
              colspan="7" 
              title="No leave requests found" 
              message="Click 'Create Leave Request' to add your first leave"
          />
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection

@section('footer_pagination')
  @if(isset($leaves) && method_exists($leaves,'links'))
  <form method="GET" class="hrp-entries-form">
    <span>Entries</span>
    @php($currentPerPage = (int) request()->get('per_page', 10))
    <select name="per_page" onchange="this.form.submit()">
      @foreach([10,25,50,100] as $size)
      <option value="{{ $size }}" {{ $currentPerPage === $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    @foreach(request()->except(['per_page','page']) as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
    @endforeach
  </form>
  {{ $leaves->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('leaves.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Leave Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">My Leaves</span>
@endsection

