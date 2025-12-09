@forelse($inquiries as $index => $inquiry)
@php
  $highlightTodayDemo = in_array($inquiry->id, (array)($todayScheduledInquiryIds ?? []));
@endphp
<tr @if($highlightTodayDemo) style="background-color:#fff7ed;" @endif>
  @if(user_has_any_action_permission('Inquiries Management', ['view inquiry', 'edit inquiry', 'delete inquiry', 'follow up']) || auth()->user()->can('Quotations Management.create quotation'))
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

        @can('Quotations Management.create quotation')
          <a href="{{ route('quotation.create-from-inquiry', $inquiry->id) }}" title="Make Quotation" aria-label="Make Quotation">
            <img class="action-icon" src="{{ asset('action_icon/make-quatation.svg') }}" alt="Make Quotation">
          </a>
        @endcan
      </div>
    </td>
  @endif
  <td>
    @php($sno = ($inquiries->currentPage()-1) * $inquiries->perPage() + $index + 1)
    {{ $sno }}
  </td>
  <td>{{ $inquiry->unique_code }}</td>
  <td>{{ $inquiry->inquiry_date->format('d-m-Y') }}</td>
  <td>{{ $inquiry->company_name }}</td>
  <td>{{ display_mobile($inquiry->company_phone) }}</td>
  <td>{{ $inquiry->contact_name }}</td>
  <td>{{ $inquiry->contact_position }}</td>
  <td>{{ $inquiry->industry_type }}</td>
  <td>
    {{ optional(optional($inquiry->followUps->first())->next_followup_date)->format('d-m-Y') }}
  </td>
  <td style="text-align:center;">
    @if($inquiry->followUps && $inquiry->followUps->count() > 0)
      @php($latestFollowUp = $inquiry->followUps->first())
      @if($latestFollowUp && $latestFollowUp->is_confirm)
        <div style="width: 24px; height: 24px; background: #10b981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="Confirmed">
          <span style="color: white; font-size: 14px; font-weight: bold;">✓</span>
        </div>
      @elseif($latestFollowUp)
        @can('Inquiries Management.follow up confirm')
          <button type="button" class="confirm-followup-btn" data-followup-id="{{ $latestFollowUp->id }}" data-row-id="{{ $inquiry->id }}" title="Click to Confirm" aria-label="Click to Confirm" style="background:transparent;border:0;padding:0;cursor:pointer;">
            <div style="width: 24px; height: 24px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
              <span style="color: white; font-size: 14px; font-weight: bold;">✗</span>
            </div>
          </button>
        @else
          <div style="width: 24px; height: 24px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="Not Confirmed">
            <span style="color: white; font-size: 14px; font-weight: bold;">✗</span>
          </div>
        @endcan
      @endif
    @else
      <div style="width: 24px; height: 24px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="No Follow Up">
        <span style="color: white; font-size: 14px; font-weight: bold;">✗</span>
      </div>
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
  <x-empty-state 
      colspan="{{ (user_has_any_action_permission('Inquiries Management', ['view inquiry', 'edit inquiry', 'delete inquiry', 'follow up']) || auth()->user()->can('Quotations Management.create quotation')) ? '14' : '13' }}" 
      title="No inquiries found" 
      message="Try adjusting your filters or create a new inquiry"
  />
@endforelse
