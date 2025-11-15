@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Attendance Dashboard</h4>
                    <p class="mb-0 text-muted">{{ now()->format('l, F j, Y') }}</p>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        @if(!$attendance || !$attendance->check_in)
                            <form action="{{ route('attendance.check-in') }}" method="POST" class="d-inline-block">
                                @csrf
                                <div class="form-group">
                                    <label for="notes">Notes (Optional)</label>
                                    <textarea name="notes" id="notes" class="form-control mb-3" rows="2" placeholder="Add any notes..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-sign-in-alt"></i> Check In
                                </button>
                            </form>
                        @elseif($attendance->check_in && !$attendance->check_out)
                            <div class="alert alert-info">
                                <h5>You checked in at: {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}</h5>
                                <p class="mb-0">Duration: {{ now()->diff(\Carbon\Carbon::parse($attendance->check_in))->format('%h hours %i minutes') }}</p>
                            </div>
                            
                            <form action="{{ route('attendance.check-out') }}" method="POST" class="mt-3">
                                @csrf
                                <div class="form-group">
                                    <label for="notes">End of Day Notes (Optional)</label>
                                    <textarea name="notes" id="notes" class="form-control mb-3" rows="2" placeholder="How was your day? Any notes for today..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="fas fa-sign-out-alt"></i> Check Out
                                </button>
                            </form>
                        @else
                            <div class="alert alert-success">
                                <h5>Today's Attendance</h5>
                                <p class="mb-1"><strong>Check In:</strong> {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}</p>
                                <p class="mb-1"><strong>Check Out:</strong> {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}</p>
                                <p class="mb-0"><strong>Total Hours:</strong> {{ $attendance->total_working_hours ?? 'N/A' }}</p>
                            </div>
                            <p class="text-muted">You have completed your attendance for today.</p>
                        @endif
                    </div>

                    @if($attendanceHistory->isNotEmpty())
                        <hr>
                        <h5>Recent Attendance</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendanceHistory as $record)
                                        <tr>
                                            <td>{{ $record->date->format('M d, Y') }}</td>
                                            <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '--:--' }}</td>
                                            <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('h:i A') : '--:--' }}</td>
                                            <td>{{ $record->total_working_hours ?? '--:--' }}</td>
                                            <td>
                                                @if($record->status === 'present')
                                                    <span class="badge bg-success">Present</span>
                                                @elseif($record->status === 'half_day')
                                                    <span class="badge bg-warning text-dark">Half Day</span>
                                                @elseif($record->status === 'leave')
                                                    <span class="badge bg-info">On Leave</span>
                                                @else
                                                    <span class="badge bg-danger">Absent</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('attendance.history') }}" class="btn btn-sm btn-outline-primary">View All History</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
