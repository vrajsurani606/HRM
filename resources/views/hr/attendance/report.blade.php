@extends('layouts.macos')
@section('page_title', 'Attendance Reports')

@section('content')
<div style="padding:20px 30px">
  <!-- Filters Section -->
  <div style="display:flex;gap:16px;margin-bottom:24px;align-items:center">
    <input type="text" placeholder="From : dd/mm/yyyy" style="padding:8px 16px;border:1px solid #d1d5db;border-radius:8px;background:white;color:#6b7280;font-size:14px;min-width:150px">
    <input type="text" placeholder="To : dd/mm/yyyy" style="padding:8px 16px;border:1px solid #d1d5db;border-radius:8px;background:white;color:#6b7280;font-size:14px;min-width:150px">
    
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
    
    <div style="margin-left:auto">
      <button style="background:#10b981;color:white;padding:8px 16px;border:none;border-radius:8px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px">
        Export to Excel
      </button>
    </div>
  </div>

  <!-- Attendance Table -->
  <div style="background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border:1px solid #e5e7eb;overflow:hidden">
    <div style="overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
        <thead>
          <tr style="background:#f8f9fa;border-bottom:1px solid #e5e7eb">
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb;width:80px">Action</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">EMP Code</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">EMPLOYEE</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Check IN & OUT</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Overtime</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Status</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr style="border-bottom:1px solid #f3f4f6">
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <div style="display:flex;gap:4px">
                <button style="width:20px;height:20px;background:#3b82f6;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button style="width:20px;height:20px;background:#ef4444;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                </button>
              </div>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">CHITRI_0024</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Patel Ravi Raghavbhai</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">
              <span style="color:#f97316;font-weight:600">09:36 AM</span> — <span style="color:#6b7280">08h 49m</span> — <span style="color:#ef4444;font-weight:600">06:25 PM</span>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">0h 19m</td>
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <span style="background:#dcfce7;color:#059669;padding:4px 8px;border-radius:12px;font-size:12px;font-weight:600">Present</span>
            </td>
            <td style="padding:16px 12px">
              <button style="background:none;border:none;cursor:pointer;padding:4px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"/>
                </svg>
              </button>
            </td>
          </tr>
          <tr style="border-bottom:1px solid #f3f4f6">
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <div style="display:flex;gap:4px">
                <button style="width:20px;height:20px;background:#3b82f6;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button style="width:20px;height:20px;background:#ef4444;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                </button>
              </div>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">CHITRI_0025</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Savaliya Jayesh Mansukhbhai</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">
              <span style="color:#f97316;font-weight:600">09:40 AM</span> — <span style="color:#6b7280">08h 35m</span> — <span style="color:#ef4444;font-weight:600">06:15 PM</span>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">--</td>
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <span style="background:#fed7aa;color:#ea580c;padding:4px 8px;border-radius:12px;font-size:12px;font-weight:600">Half Day</span>
            </td>
            <td style="padding:16px 12px">
              <button style="background:none;border:none;cursor:pointer;padding:4px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"/>
                </svg>
              </button>
            </td>
          </tr>
          <tr style="border-bottom:1px solid #f3f4f6">
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <div style="display:flex;gap:4px">
                <button style="width:20px;height:20px;background:#3b82f6;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button style="width:20px;height:20px;background:#ef4444;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                </button>
              </div>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">CHITRI_0017</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Panchal Swara Piyushbhai</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">
              <span style="color:#f97316;font-weight:600">09:55 AM</span> — <span style="color:#6b7280">08h 45m</span> — <span style="color:#10b981;font-weight:600">06:40 PM</span>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">0h 15m</td>
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <span style="background:#dcfce7;color:#059669;padding:4px 8px;border-radius:12px;font-size:12px;font-weight:600">Present</span>
            </td>
            <td style="padding:16px 12px">
              <button style="background:none;border:none;cursor:pointer;padding:4px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"/>
                </svg>
              </button>
            </td>
          </tr>
          <tr style="border-bottom:1px solid #f3f4f6">
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <div style="display:flex;gap:4px">
                <button style="width:20px;height:20px;background:#3b82f6;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </button>
                <button style="width:20px;height:20px;background:#ef4444;border:none;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="white">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                </button>
              </div>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">CHITRI_0032</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">Vasani Chirag Mukeshbhai</td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">
              <span style="color:#10b981;font-weight:600">09:17 AM</span> — <span style="color:#6b7280">10h 03m</span> — <span style="color:#10b981;font-weight:600">07:20 PM</span>
            </td>
            <td style="padding:16px 12px;color:#374151;font-weight:500;font-size:14px;border-right:1px solid #e5e7eb">1h 33m</td>
            <td style="padding:16px 12px;border-right:1px solid #e5e7eb">
              <span style="background:#dcfce7;color:#059669;padding:4px 8px;border-radius:12px;font-size:12px;font-weight:600">Present</span>
            </td>
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
    
    <!-- Footer -->
    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-top:1px solid #e5e7eb">
      <div style="display:flex;align-items:center;gap:8px;color:#6b7280;font-size:14px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span><a href="{{ route('dashboard') }}" style="text-decoration:none;color:#374151">Dashboard</a></span>
        <span>›</span>
        <span>Attendance Reports</span>
      </div>
      
      <div style="display:flex;align-items:center;gap:16px">
        <div style="display:flex;align-items:center;gap:8px;color:#6b7280;font-size:14px">
          <span>Entries</span>
          <select style="padding:4px 8px;border:1px solid #d1d5db;border-radius:4px;background:white;color:#374151;font-size:14px">
            <option>25</option>
          </select>
        </div>
        
        <div style="display:flex;align-items:center;gap:8px">
          <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">«</button>
          <button style="padding:8px 12px;border:1px solid #ef4444;background:#ef4444;color:white;border-radius:4px;font-weight:600;font-size:14px">01</button>
          <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">02</button>
          <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">03</button>
          <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">04</button>
          <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">05</button>
          <span style="color:#6b7280;font-size:14px">…</span>
          <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">20</button>
          <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">»</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
