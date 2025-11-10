<div>
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Documents') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6;">
      {{ __('View and manage your uploaded documents.') }}
    </p>
  </div>

  @if($employee)
  <div class="hrp-grid" style="margin-top: 32px; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
    <div class="hrp-card" style="text-align: center; padding: 20px; background: #f9fafb; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s ease;" onclick="viewDocument('aadhaar_front')" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 4px 12px rgba(14,165,233,0.15)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      <i class="fa fa-id-card" style="font-size: 48px; color: #0ea5e9; margin-bottom: 12px; display: block;"></i>
      <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 8px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Aadhaar Card (Front)</h4>
      @if($employee->aadhaar_photo_front)
        <p style="color: #10b981; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-check-circle"></i> Uploaded</p>
      @else
        <p style="color: #ef4444; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-times-circle"></i> Not Uploaded</p>
      @endif
    </div>

    <div class="hrp-card" style="text-align: center; padding: 20px; background: #f9fafb; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s ease;" onclick="viewDocument('aadhaar_back')" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 4px 12px rgba(14,165,233,0.15)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      <i class="fa fa-id-card" style="font-size: 48px; color: #0ea5e9; margin-bottom: 12px; display: block;"></i>
      <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 8px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Aadhaar Card (Back)</h4>
      @if($employee->aadhaar_photo_back)
        <p style="color: #10b981; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-check-circle"></i> Uploaded</p>
      @else
        <p style="color: #ef4444; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-times-circle"></i> Not Uploaded</p>
      @endif
    </div>

    <div class="hrp-card" style="text-align: center; padding: 20px; background: #f9fafb; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s ease;" onclick="viewDocument('pan')" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 4px 12px rgba(14,165,233,0.15)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      <i class="fa fa-credit-card" style="font-size: 48px; color: #0ea5e9; margin-bottom: 12px; display: block;"></i>
      <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 8px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">PAN Card</h4>
      @if($employee->pan_photo)
        <p style="color: #10b981; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-check-circle"></i> Uploaded</p>
      @else
        <p style="color: #ef4444; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-times-circle"></i> Not Uploaded</p>
      @endif
    </div>

    <div class="hrp-card" style="text-align: center; padding: 20px; background: #f9fafb; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s ease;" onclick="viewDocument('cheque')" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 4px 12px rgba(14,165,233,0.15)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      <i class="fa fa-bank" style="font-size: 48px; color: #0ea5e9; margin-bottom: 12px; display: block;"></i>
      <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 8px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Bank Cheque</h4>
      @if($employee->cheque_photo)
        <p style="color: #10b981; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-check-circle"></i> Uploaded</p>
      @else
        <p style="color: #ef4444; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-times-circle"></i> Not Uploaded</p>
      @endif
    </div>

    <div class="hrp-card" style="text-align: center; padding: 20px; background: #f9fafb; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s ease;" onclick="viewDocument('marksheet')" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 4px 12px rgba(14,165,233,0.15)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      <i class="fa fa-graduation-cap" style="font-size: 48px; color: #0ea5e9; margin-bottom: 12px; display: block;"></i>
      <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 8px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Marksheet</h4>
      @if($employee->marksheet_photo)
        <p style="color: #10b981; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-check-circle"></i> Uploaded</p>
      @else
        <p style="color: #ef4444; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-times-circle"></i> Not Uploaded</p>
      @endif
    </div>

    @if($employee->socials && $employee->socials->resume_path)
    <div class="hrp-card" style="text-align: center; padding: 20px; background: #f9fafb; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.3s ease;" onclick="viewDocument('resume')" onmouseover="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 4px 12px rgba(14,165,233,0.15)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      <i class="fa fa-file-pdf-o" style="font-size: 48px; color: #0ea5e9; margin-bottom: 12px; display: block;"></i>
      <h4 style="font-size: 14px; font-weight: 600; color: #111; margin: 0 0 8px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Resume</h4>
      <p style="color: #10b981; font-size: 12px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><i class="fa fa-check-circle"></i> Uploaded</p>
    </div>
    @endif
  </div>

  <div class="hrp-card" style="margin-top: 32px; background: #f9fafb; border: 1px solid #e5e7eb;">
    <div class="hrp-card-body">
      <h3 style="font-size: 16px; font-weight: 700; color: #111; margin: 0 0 16px 0; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
        <i class="fa fa-info-circle"></i> Document Details
      </h3>
      <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
        <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Aadhaar Number</span>
        <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">{{ $employee->aadhaar_no ?? 'N/A' }}</span>
      </div>
      <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
        <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">PAN Number</span>
        <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">{{ $employee->pan_no ?? 'N/A' }}</span>
      </div>
      <div style="display: flex; justify-content: space-between; padding: 12px 0;">
        <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Documents Status</span>
        <span style="font-weight: 500; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
          @php
            $docCount = 0;
            if($employee->aadhaar_photo_front) $docCount++;
            if($employee->aadhaar_photo_back) $docCount++;
            if($employee->pan_photo) $docCount++;
            if($employee->cheque_photo) $docCount++;
            if($employee->marksheet_photo) $docCount++;
          @endphp
          <span style="color: {{ $docCount >= 3 ? '#10b981' : '#ef4444' }}; font-weight: 600;">
            {{ $docCount }}/5 Uploaded
          </span>
        </span>
      </div>
    </div>
  </div>
  @else
  <div class="hrp-card" style="text-align: center; padding: 40px; background: #f9fafb; border: 1px solid #e5e7eb;">
    <i class="fa fa-info-circle" style="font-size: 48px; color: #9ca3af; margin-bottom: 16px;"></i>
    <p style="color: #6b7280; font-size: 16px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      No documents available. Please contact HR for document upload.
    </p>
  </div>
  @endif
</div>

<script>
function viewDocument(type) {
  console.log('View document:', type);
  // Can be implemented to show document in modal
}
</script>
