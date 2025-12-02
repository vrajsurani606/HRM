@forelse($inquiries as $index => $inquiry)
@php
  $highlightTodayDemo = in_array($inquiry->id, (array)($todayScheduledInquiryIds ?? []));
@endphp
<tr @if($highlightTodayDemo) style="background-color:#fff7ed;" @endif>
  <td>
    <div class="action-icons">
      @can('Inquiries Management.view inquiry')
        <a href="{{ route('inquiries.show', $inquiry->id) }}" title="View Inquiry" aria-label="View Inquiry">
          <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="Show">
        </a>
      @endcan

      @can('Inquiries Management.edit inquiry')
        <a href="{{ route('inquiries.edit', $inquiry->id) }}" title="Edit Inquiry" aria-label="Edit Inquiry">
          <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
        </a>
      @endcan

      @can('Inquiries Management.delete inquiry')
        <form method="POST" action="{{ route('inquiries.destroy', $inquiry->id) }}" class="delete-form" style="display:inline">
          @csrf @method('DELETE')
          <button type="button" onclick="confirmDeleteInquiry(this)" title="Delete Inquiry" aria-label="Delete Inquiry" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
            <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
          </button>
        </form>
      @endcan

      @can('Inquiries Management.follow up')
        <a href="{{ route('inquiry.follow-up', $inquiry->id) }}" title="Follow Up" aria-label="Follow Up">
          <img class="action-icon" src="{{ asset('action_icon/follow-up.svg') }}" alt="Follow Up">
        </a>
      @endcan

      @if(!empty($inquiry->quotation_sent) && strtolower($inquiry->quotation_sent) !== 'no')
        @can('Quotations Management.create quotation')
          <a href="{{ route('quotation.create-from-inquiry', $inquiry->id) }}" title="Make Quotation" aria-label="Make Quotation">
            <img class="action-icon" src="{{ asset('action_icon/make-quatation.svg') }}" alt="Make Quotation">
          </a>
        @endcan
      @endif
    </div>
  </td>
  <td>
    @php($sno = ($inquiries->currentPage()-1) * $inquiries->perPage() + $index + 1)
    {{ $sno }}
  </td>
  <td>{{ $inquiry->unique_code }}</td>
  <td>{{ $inquiry->inquiry_date->format('d-m-Y') }}</td>
  <td>{{ $inquiry->company_name }}</td>
  <td>{{ $inquiry->company_phone }}</td>
  <td>{{ Str::limit($inquiry->company_address, 30) }}</td>
  <td>{{ $inquiry->contact_name }}</td>
  <td>{{ $inquiry->contact_position }}</td>
  <td>{{ $inquiry->industry_type }}</td>
  <td>
    {{ optional(optional($inquiry->followUps->first())->next_followup_date)->format('d-m-Y') }}
  </td>
  <td style="text-align:center;">
    @php
      $latestFollowUp = $inquiry->followUps->first();
    @endphp
    @if($latestFollowUp)
      @if($latestFollowUp->is_confirm)
        <img src="{{ asset('action_icon/completed.svg') }}" alt="Confirmed" title="Follow Up Confirmed" style="width:20px;height:20px;opacity:1;">
      @else
        @can('Inquiries Management.follow up confirm')
          <button type="button" class="confirm-followup-btn" data-followup-id="{{ $latestFollowUp->id }}" data-row-id="{{ $inquiry->id }}" title="Click to Confirm" aria-label="Click to Confirm" style="background:transparent;border:0;padding:0;cursor:pointer;">
            <img src="{{ asset('action_icon/pending.svg') }}" alt="Pending" style="width:20px;height:20px;">
          </button>
        @endcan
      @endif
    @else
      —
    @endif
  </td>
  <td><a href="{{ $inquiry->scope_link }}" class="scope-link">View</a></td>
  <td>
    @if($inquiry->quotation_file)
      <a href="{{ url('public/storage/'.$inquiry->quotation_file) }}" target="_blank" class="scope-link">View</a>
    @else
      —
    @endif
  </td>
</tr>
@empty
<tr>
  <td colspan="14" class="no-data">No inquiries found</td>
</tr>
@endforelse
