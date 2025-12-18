  @extends('layouts.macos')
  @section('page_title', 'Payroll Management')

  @section('content')
  <div class="inquiry-index-container">
    <!-- JV Filter -->
    <form method="GET" action="{{ route('payroll.index') }}" class="jv-filter" data-no-loader="true">
      <select class="filter-pill" name="month">
        <option value="">All Months</option>
        @foreach($months as $month)
          <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
        @endforeach
      </select>

      <select class="filter-pill" name="year">
        <option value="">All Years</option>
        @foreach($years as $year)
          <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
        @endforeach
      </select>

      <select class="filter-pill" name="status">
        <option value="">All Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
        <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>Hold</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
      </select>

      <select class="filter-pill" name="employee_id">
        <option value="">All Employees</option>
        @foreach($employees as $emp)
          <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
        @endforeach
      </select>

      <button type="submit" class="filter-search" aria-label="Search">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
      </button>

      <a href="{{ route('payroll.index') }}" class="filter-search" style="background: #6b7280;" aria-label="Reset">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
        </svg>
      </a>

      <div class="filter-right">
        <input name="q" class="filter-pill" placeholder="Search employee..." value="{{ request('q') }}">
        
        @can('Payroll Management.export payroll')
        <a href="{{ route('payroll.export-csv', request()->query()) }}" class="pill-btn pill-success">CSV</a>
        @endcan
        
        @can('Payroll Management.create payroll')
        <a href="{{ route('payroll.create') }}" class="pill-btn pill-success">+ Add</a>
        @endcan
        
        @can('Payroll Management.bulk generate payroll')
        <a href="{{ route('payroll.bulk') }}" class="pill-btn" style="background:#2563eb; color:#fff;">Bulk Generate</a>
        @endcan
      </div>
    </form>

    <!-- List View -->
    <div class="inquiries-list-view active">
      <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
        <table>
          <thead>
            <tr>
              @if(user_has_any_action_permission('Payroll Management', ['view payroll', 'edit payroll', 'delete payroll']))
                <th style="width: 100px; text-align: center;">Action</th>
              @endif
              <th style="width: 100px; text-align: center;">EMP Code</th>
              <th style="width: 180px; text-align: center;">Employee</th>
              <th style="width: 120px; text-align: center;">Month/Year</th>
              <th style="width: 120px; text-align: center;">Basic Salary</th>
              <th style="width: 130px; text-align: center;">Total Allowance</th>
              <th style="width: 130px; text-align: center;">Total Deduction</th>
              <th style="width: 130px; text-align: center;">Net Salary</th>
              <th style="width: 100px; text-align: center;">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($payrolls as $payroll)
              @php
                // Calculate totals
                $totalAllowances = ($payroll->hra ?? 0) + ($payroll->medical_allowance ?? 0) + 
                                  ($payroll->city_allowance ?? 0) + ($payroll->tiffin_allowance ?? 0) + 
                                  ($payroll->assistant_allowance ?? 0) + ($payroll->dearness_allowance ?? 0);
                $totalDeductions = ($payroll->pf ?? 0) + ($payroll->professional_tax ?? 0) + 
                                  ($payroll->tds ?? 0) + ($payroll->esic ?? 0) + 
                                  ($payroll->security_deposit ?? 0) + ($payroll->leave_deduction ?? 0);
                $netSalary = ($payroll->basic_salary + $totalAllowances + ($payroll->bonuses ?? 0)) - $totalDeductions;
              @endphp
              <tr>
                @if(user_has_any_action_permission('Payroll Management', ['view payroll', 'edit payroll', 'delete payroll']))
                  <td style="padding: 12px 8px; text-align: center;">
                    <div style="display: flex; gap: 6px; align-items: center; justify-content: center;">
                      @can('Payroll Management.view payroll')
                      <img src="{{ asset('action_icon/view.svg') }}" alt="View" style="cursor: pointer; width: 16px; height: 16px;" onclick="window.location.href='{{ route('payroll.show', $payroll->id) }}'" title="View Salary Slip">
                      @endcan
                      
                      @can('Payroll Management.edit payroll')
                      <a href="{{ route('payroll.edit', $payroll->id) }}" title="Edit">
                        <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" style="cursor: pointer; width: 16px; height: 16px;">
                      </a>
                      @endcan
                      
                      @can('Payroll Management.delete payroll')
                      <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" style="cursor: pointer; width: 16px; height: 16px;" onclick="deletePayroll({{ $payroll->id }})" title="Delete">
                      @endcan
                    </div>
                  </td>
                @endif
                <td style="padding: 12px 8px; text-align: center; font-weight: 600; color: #1e40af;">{{ $payroll->employee->code ?? 'N/A' }}</td>
                <td style="padding: 12px 8px; text-align: center;">
                  <div style="font-weight: 600; color: #1f2937;">{{ $payroll->employee->name ?? 'N/A' }}</div>
                  <div style="font-size: 11px; color: #6b7280;">{{ $payroll->employee->position ?? 'N/A' }}</div>
                </td>
                <td style="padding: 12px 8px; text-align: center;">
                  <div style="font-weight: 600; color: #1f2937;">{{ $payroll->month }}</div>
                  <div style="font-size: 11px; color: #6b7280;">{{ $payroll->year }}</div>
                </td>
                <td style="padding: 12px 8px; text-align: center !important; font-weight: 600; color: #1f2937;">₹{{ number_format($payroll->basic_salary, 0) }}</td>
                <td style="padding: 12px 8px; text-align: center !important; font-weight: 600; color: #059669;">₹{{ number_format($totalAllowances, 0) }}</td>
                <td style="padding: 12px 8px; text-align: center !important; font-weight: 600; color: #dc2626;">₹{{ number_format($totalDeductions, 0) }}</td>
                <td style="padding: 12px 8px; text-align: center !important; font-weight: 700; color: #10b981; font-size: 15px;">₹{{ number_format($netSalary, 0) }}</td>
                <td style="padding: 12px 8px; text-align: center;">
                  @php
                    $statusColors = [
                      'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                      'paid' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                      'hold' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                      'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                    ];
                    $statusColor = $statusColors[$payroll->status] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
                  @endphp
                  <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }};">
                    {{ ucfirst($payroll->status) }}
                  </span>
                </td>
              </tr>
            @empty
              <x-empty-state 
                  colspan="{{ user_has_any_action_permission('Payroll Management', ['view payroll', 'edit payroll', 'delete payroll']) ? '9' : '8' }}" 
                  title="No payroll records found" 
                  message="Try adjusting your filters or create a new payroll record"
              />
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <script>
  function deletePayroll(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`{{ url('payroll') }}/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire('Deleted!', data.message, 'success');
            setTimeout(() => location.reload(), 1000);
          } else {
            Swal.fire('Error!', data.message, 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error!', 'Failed to delete payroll', 'error');
        });
      }
    });
  }
  </script>
  @endsection

  @section('footer_pagination')
    @if(isset($payrolls) && method_exists($payrolls,'links'))
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
    {{ $payrolls->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
    @endif
  @endsection

  @section('breadcrumb')
    <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
    <span class="hrp-bc-sep">›</span>
    <a href="{{ route('payroll.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Payroll Management</a>
    <span class="hrp-bc-sep">›</span>
    <span class="hrp-bc-current">Payroll List</span>
  @endsection
