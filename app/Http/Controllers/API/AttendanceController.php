<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Check if user has already checked in today
     */
    public function checkStatus()
    {
        $today = now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', $today)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'has_checked_in' => $attendance && $attendance->check_in !== null,
                'has_checked_out' => $attendance && $attendance->check_out !== null,
                'current_time' => now()->format('H:i:s'),
                'attendance' => $attendance
            ]
        ]);
    }

    /**
     * Check in the user
     */
    public function checkIn(Request $request)
    {
        $today = now()->format('Y-m-d');
        
        // Check if already checked in today
        $existing = Attendance::where('user_id', auth()->id())
            ->whereDate('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'You have already checked in today.'
            ], 400);
        }

        $attendance = $existing ?? new Attendance();
        $attendance->user_id = auth()->id();
        $attendance->date = $today;
        $attendance->check_in = now();
        $attendance->status = 'present';
        $attendance->ip_address = $request->ip();
        $attendance->user_agent = $request->userAgent();
        $attendance->location = $this->getLocation($request->ip());
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully checked in at ' . now()->format('h:i A'),
            'data' => $attendance
        ]);
    }

    /**
     * Check out the user
     */
    public function checkOut(Request $request)
    {
        $today = now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'You need to check in first.'
            ], 400);
        }

        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'You have already checked out today.'
            ], 400);
        }

        $checkIn = Carbon::parse($attendance->check_in);
        $checkOut = now();
        $totalSeconds = $checkIn->diffInSeconds($checkOut);

        $attendance->check_out = $checkOut;
        $attendance->total_seconds = $totalSeconds;
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully checked out at ' . $checkOut->format('h:i A'),
            'data' => [
                'total_hours' => $this->formatSeconds($totalSeconds),
                'attendance' => $attendance
            ]
        ]);
    }

    /**
     * Get user's attendance history
     */
    public function history()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->paginate(30);

        return response()->json([
            'success' => true,
            'data' => $attendance
        ]);
    }

    /**
     * Helper to format seconds to H:i:s
     */
    private function formatSeconds($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    /**
     * Helper to get location from IP (basic implementation)
     */
    private function getLocation($ip)
    {
        try {
            $data = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
            return $data->city . ', ' . $data->region . ', ' . $data->country;
        } catch (\Exception $e) {
            return 'Location not available';
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
