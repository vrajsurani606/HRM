@extends('layouts.macos')
@section('page_title', 'Add Receipt')
@section('content')
  <div class="hrp-content">
    <form action="{{ route('receipts.store') }}" method="POST" class="hrp-form">
      @csrf
      <div class="Rectangle-30 hrp-compact">
        <!-- First Row: 3 equal columns -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Unique Code:</label>
            <input type="text" name="unique_code" class="Rectangle-29" placeholder="CMS/LEAD/OO22" value="CMS/LEAD/OO22"
              required>
          </div>
          <div>
            <label class="hrp-label">Rec Date :</label>
            <input type="date" name="rec_date" class="Rectangle-29" placeholder="dd/mm/yyyy" required>
          </div>
          <div>
            <label class="hrp-label">Company Name :</label>
            <select name="company_name" class="Rectangle-29-select" required>
              <option value="">-- Select Company --</option>
              <option value="ABC Corp">ABC Corp</option>
              <option value="XYZ Ltd">XYZ Ltd</option>
              <option value="Tech Solutions">Tech Solutions</option>
              <option value="Global Industries">Global Industries</option>
            </select>
          </div>
        </div>

        <!-- Second Row: 3 equal columns for amounts -->
        <div class="grid grid-cols-3 gap-4 mb-8">
          <div>
            <label class="hrp-label">Total :</label>
            <input type="number" name="total_amount" class="Rectangle-29 amount-blue" placeholder="0000000.00" step="0.01"
              required>
          </div>
          <div>
            <label class="hrp-label">Paid :</label>
            <input type="number" name="paid_amount" class="Rectangle-29 amount-green" placeholder="0000000.00" step="0.01"
              required>
          </div>
          <div>
            <label class="hrp-label">Remain :</label>
            <input type="number" name="remain_amount" class="Rectangle-29 amount-red" placeholder="0000000.00" step="0.01"
              readonly>
          </div>
        </div>
      </div>



      <!-- Third Row: 4 equal columns -->
      <div class="Rectangle-30 hrp-compact">

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Received Amount:</label>
            <input type="number" name="received_amount" class="Rectangle-29" placeholder="Enter Description" step="0.01"
              required>
          </div>
          <div>
            <label class="hrp-label">Payment Type:</label>
            <select name="payment_type" class="Rectangle-29-select" required>
              <option value="">Select Mode</option>
              <option value="cash">Cash</option>
              <option value="cheque">Cheque</option>
              <option value="bank_transfer">Bank Transfer</option>
              <option value="online">Online</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Narration:</label>
            <input type="text" name="narration" class="Rectangle-29" placeholder="Enter Narration" required>
          </div>
          <div>
            <label class="hrp-label">Trans Code:</label>
            <input type="text" name="trans_code" class="Rectangle-29" placeholder="Enter SAC Code" required>
          </div>
        </div>
      </div>

      <div style="display:flex;justify-content:end;margin:20px;">
        <button type="submit" class="add-receipt-btn" style="padding: 15px 40px; font-size: 16px; width: fit-content;background: #28a745;">
          Add Receipt
        </button>
      </div>
  </div>
  </form>
  </div>

  <style>
    /* Amount field colors */
    .amount-blue {
      background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%) !important;
      color: white !important;
      font-weight: 600;
    }

    .amount-green {
      background: linear-gradient(135deg, #86efac 0%, #4ade80 100%) !important;
      color: white !important;
      font-weight: 600;
    }

    .amount-red {
      background: linear-gradient(135deg, #fca5a5 0%, #f87171 100%) !important;
      color: white !important;
      font-weight: 600;
    }

    .amount-blue::placeholder,
    .amount-green::placeholder,
    .amount-red::placeholder {
      color: rgba(255, 255, 255, 0.8) !important;
    }

    /* Add Receipt Button */
    .add-receipt-btn {
      background: #10b981;
      color: white;
      border: none;
      padding: 12px 32px;
      border-radius: 25px;
      font-weight: 700;
      font-size: 16px;
      cursor: pointer;
      font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      transition: all 0.2s ease;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
      min-width: 160px;
    }

    .add-receipt-btn:hover {
      background: #059669;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    }

    /* Auto-calculate remain amount */
    script {
      document.addEventListener('DOMContentLoaded', function() {
          const totalInput=document.querySelector('input[name="total_amount"]');
          const paidInput=document.querySelector('input[name="paid_amount"]');
          const remainInput=document.querySelector('input[name="remain_amount"]');

          function calculateRemain() {
            const total=parseFloat(totalInput.value) || 0;
            const paid=parseFloat(paidInput.value) || 0;
            const remain=total - paid;
            remainInput.value=remain.toFixed(2);
          }

          totalInput.addEventListener('input', calculateRemain);
          paidInput.addEventListener('input', calculateRemain);
        });
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const totalInput = document.querySelector('input[name="total_amount"]');
      const paidInput = document.querySelector('input[name="paid_amount"]');
      const remainInput = document.querySelector('input[name="remain_amount"]');

      function calculateRemain() {
        const total = parseFloat(totalInput.value) || 0;
        const paid = parseFloat(paidInput.value) || 0;
        const remain = total - paid;
        remainInput.value = remain.toFixed(2);
      }

      totalInput.addEventListener('input', calculateRemain);
      paidInput.addEventListener('input', calculateRemain);
    });
  </script>
@endsection