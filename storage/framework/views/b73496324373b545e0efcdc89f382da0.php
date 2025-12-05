<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Record - <?php echo e($attendance->employee->name ?? 'N/A'); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #1f2937;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #6b7280;
            font-size: 14px;
        }
        
        .content {
            margin-bottom: 30px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 16px;
            color: #1f2937;
            font-weight: 500;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            width: fit-content;
        }
        
        .status-present {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-absent {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-late {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-early-leave {
            background: #fce7f3;
            color: #831843;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .print-button button {
            padding: 10px 20px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }
        
        .print-button button:hover {
            background: #2563eb;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .container {
                box-shadow: none;
                padding: 0;
            }
            
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="print-button">
            <button onclick="window.print()">🖨️ Print</button>
        </div>
        
        <div class="header">
            <h1>Attendance Record</h1>
            <p>Employee Attendance Details</p>
        </div>
        
        <div class="content">
            <!-- Employee Information -->
            <div class="section">
                <div class="section-title">Employee Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Employee Name</span>
                        <span class="info-value"><?php echo e($attendance->employee->name ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Employee Code</span>
                        <span class="info-value"><?php echo e($attendance->employee->code ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Position</span>
                        <span class="info-value"><?php echo e($attendance->employee->position ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Department</span>
                        <span class="info-value"><?php echo e($attendance->employee->department ?? 'N/A'); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Attendance Details -->
            <div class="section">
                <div class="section-title">Attendance Details</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Date</span>
                        <span class="info-value"><?php echo e(\Carbon\Carbon::parse($attendance->date)->format('d M, Y')); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            <span class="status-badge status-<?php echo e(str_replace('_', '-', $attendance->status)); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $attendance->status))); ?>

                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check In Time</span>
                        <span class="info-value">
                            <?php if($attendance->check_in): ?>
                                <?php echo e(\Carbon\Carbon::parse($attendance->check_in)->format('H:i:s')); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Check Out Time</span>
                        <span class="info-value">
                            <?php if($attendance->check_out): ?>
                                <?php echo e(\Carbon\Carbon::parse($attendance->check_out)->format('H:i:s')); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Working Hours</span>
                        <span class="info-value"><?php echo e($attendance->total_working_hours ?? '—'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Remarks</span>
                        <span class="info-value"><?php echo e($attendance->remarks ?? '—'); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div class="section">
                <div class="section-title">Additional Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Record Created</span>
                        <span class="info-value"><?php echo e($attendance->created_at->format('d M, Y H:i:s')); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Last Updated</span>
                        <span class="info-value"><?php echo e($attendance->updated_at->format('d M, Y H:i:s')); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an official attendance record. Printed on <?php echo e(now()->format('d M, Y H:i:s')); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/attendance/print.blade.php ENDPATH**/ ?>