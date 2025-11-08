@extends('layouts.macos')
@section('page_title', 'Leave Management')

@section('content')
<div style="padding:20px 30px">
  <!-- Filters Section -->
  <div style="display:flex;gap:16px;margin-bottom:24px;align-items:center">
    <select style="padding:8px 16px;border:1px solid #d1d5db;border-radius:8px;background:white;color:#374151;font-size:14px;min-width:150px">
      <option>Select Date Range</option>
      <option>Last 7 days</option>
      <option>Last 30 days</option>
      <option>Custom Range</option>
    </select>
    
    <select style="padding:8px 16px;border:1px solid #d1d5db;border-radius:8px;background:white;color:#374151;font-size:14px;min-width:120px">
      <option>All Employee</option>
      <option>Active</option>
      <option>Inactive</option>
    </select>
    
    <select style="padding:8px 16px;border:1px solid #d1d5db;border-radius:8px;background:white;color:#374151;font-size:14px;min-width:100px">
      <option>All Status</option>
      <option>Approved</option>
      <option>Pending</option>
      <option>Rejected</option>
    </select>
    
    <button style="width:40px;height:40px;background:#374151;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
      </svg>
    </button>
    
    <button style="width:40px;height:40px;background:#6b7280;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
      </svg>
    </button>
  </div>
  
  <!-- Leave Table -->
  <div style="background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border:1px solid #e5e7eb;overflow:hidden">
    <div style="overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
        <thead>
          <tr style="background:#f8f9fa;border-bottom:1px solid #e5e7eb">
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb;width:80px">Action</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">EMP Code</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">EMPLOYEE</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Start to End Date</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Duration</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Leave Type</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Leave Reason</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Status</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Applied Date</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Row 1 -->
          <tr style="border-bottom:1px solid #f3f4f6">
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <div style="display:flex;gap:4px">
                <div style="width:20px;height:20px;background:#10b981;border-radius:50%;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                  </svg>
                </div>
                <div style="width:20px;height:20px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                  </svg>
                </div>
              </div>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">CHITRI_0024</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Patel Ravi Raghavbhai</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">30 Jul, 2025 to 31 Jul, 2025</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">01 Day</td>
            <td style="padding:16px 12px;color:#3b82f6;font-weight:600;font-size:14px;border-right:1px solid #e5e7eb">Casual</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Marriage Function</td>
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <span style="background:#fed7aa;color:#ea580c;padding:4px 8px;border-radius:12px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/>
                </svg>
              </span>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">30 Jul, 2025, 10:19 AM</td>
            <td style="padding:16px 12px">
              <button style="background:none;border:none;cursor:pointer;padding:4px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"/>
                </svg>
              </button>
            </td>
          </tr>
          
          <!-- Row 2 -->
          <tr style="border-bottom:1px solid #f3f4f6">
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <div style="width:20px;height:20px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                  <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
              </div>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">CHITRI_0025</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Savaliya Jayesh Mansukhbhai</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">25 Jul, 2025 to 27 Jul, 2025</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">02 Day</td>
            <td style="padding:16px 12px;color:#ef4444;font-weight:600;font-size:14px;border-right:1px solid #e5e7eb">Medical</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Marriage Function</td>
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <span style="background:#dcfce7;color:#059669;padding:4px 8px;border-radius:12px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
              </span>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">27 Jul, 2025, 12:29 PM</td>
            <td style="padding:16px 12px">
              <button style="background:none;border:none;cursor:pointer;padding:4px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"/>
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
