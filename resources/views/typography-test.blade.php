@extends('layouts.macos')

@section('page_title', 'Typography Test')

@push('styles')
<link rel="stylesheet" href="{{ asset('new_theme/css/profile-typography.css') }}">
<style>
.typography-test {
  padding: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.test-section {
  margin-bottom: 40px;
  padding: 30px;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 10px 24px rgba(0,0,0,.08);
  border: 1px solid #f0f0f0;
}

.test-section h3 {
  font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
  font-size: 20px;
  font-weight: 800;
  color: #111827;
  margin: 0 0 20px 0;
  border-bottom: 2px solid #e5e7eb;
  padding-bottom: 10px;
}

.font-sample {
  margin-bottom: 15px;
  padding: 15px;
  background: #f9fafb;
  border-radius: 8px;
  border-left: 4px solid #0ea5e9;
}

.font-sample .label {
  font-size: 12px;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 5px;
}

.font-sample .sample-text {
  font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
  color: #111827;
}

.weight-400 { font-weight: 400; }
.weight-500 { font-weight: 500; }
.weight-600 { font-weight: 600; }
.weight-700 { font-weight: 700; }
.weight-800 { font-weight: 800; }

.size-12 { font-size: 12px; }
.size-14 { font-size: 14px; }
.size-16 { font-size: 16px; }
.size-18 { font-size: 18px; }
.size-20 { font-size: 20px; }
.size-24 { font-size: 24px; }
.size-32 { font-size: 32px; }
</style>
@endpush

@section('content')
<div class="typography-test">
  <div class="hrp-card">
    <div class="hrp-card-body">
      <h1 style="font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 32px; font-weight: 800; color: #111827; margin: 0 0 30px 0;">
        Typography Test - Visby Font Family
      </h1>

      <!-- Font Weights Test -->
      <div class="test-section">
        <h3>Font Weights</h3>
        <div class="font-sample">
          <div class="label">Regular (400)</div>
          <div class="sample-text weight-400 size-16">The quick brown fox jumps over the lazy dog</div>
        </div>
        <div class="font-sample">
          <div class="label">Medium (500)</div>
          <div class="sample-text weight-500 size-16">The quick brown fox jumps over the lazy dog</div>
        </div>
        <div class="font-sample">
          <div class="label">Semibold (600)</div>
          <div class="sample-text weight-600 size-16">The quick brown fox jumps over the lazy dog</div>
        </div>
        <div class="font-sample">
          <div class="label">Bold (700)</div>
          <div class="sample-text weight-700 size-16">The quick brown fox jumps over the lazy dog</div>
        </div>
        <div class="font-sample">
          <div class="label">Extrabold (800)</div>
          <div class="sample-text weight-800 size-16">The quick brown fox jumps over the lazy dog</div>
        </div>
      </div>

      <!-- Font Sizes Test -->
      <div class="test-section">
        <h3>Font Sizes</h3>
        <div class="font-sample">
          <div class="label">12px</div>
          <div class="sample-text weight-500 size-12">Small text for captions and labels</div>
        </div>
        <div class="font-sample">
          <div class="label">14px</div>
          <div class="sample-text weight-500 size-14">Body text and form descriptions</div>
        </div>
        <div class="font-sample">
          <div class="label">16px</div>
          <div class="sample-text weight-500 size-16">Standard body text and form inputs</div>
        </div>
        <div class="font-sample">
          <div class="label">18px</div>
          <div class="sample-text weight-500 size-18">Large body text and subheadings</div>
        </div>
        <div class="font-sample">
          <div class="label">20px</div>
          <div class="sample-text weight-600 size-20">Section headings and important text</div>
        </div>
        <div class="font-sample">
          <div class="label">24px</div>
          <div class="sample-text weight-700 size-24">Page subheadings and card titles</div>
        </div>
        <div class="font-sample">
          <div class="label">32px</div>
          <div class="sample-text weight-800 size-32">Main page headings</div>
        </div>
      </div>

      <!-- Form Elements Test -->
      <div class="test-section">
        <h3>Form Elements</h3>
        <div class="hrp-form">
          <div class="hrp-grid">
            <div class="hrp-col-6">
              <label class="hrp-label Mobile-No" for="test-name">Full Name</label>
              <input type="text" id="test-name" name="test-name" class="Rectangle-29" 
                     value="John Doe" placeholder="Enter your full name" />
            </div>
            <div class="hrp-col-6">
              <label class="hrp-label Mobile-No" for="test-email">Email Address</label>
              <input type="email" id="test-email" name="test-email" class="Rectangle-29" 
                     value="john.doe@example.com" placeholder="Enter your email" />
            </div>
          </div>
          
          <div class="hrp-grid" style="margin-top: 20px;">
            <div class="hrp-col-6">
              <label class="hrp-label Mobile-No" for="test-select">Position</label>
              <select id="test-select" name="test-select" class="Rectangle-29 Rectangle-29-select">
                <option value="">Select Position</option>
                <option value="developer" selected>Software Developer</option>
                <option value="designer">UI/UX Designer</option>
                <option value="manager">Project Manager</option>
              </select>
            </div>
            <div class="hrp-col-6">
              <label class="hrp-label Mobile-No" for="test-phone">Mobile Number</label>
              <input type="text" id="test-phone" name="test-phone" class="Rectangle-29" 
                     value="+91 9876543210" placeholder="+91 9729724869" />
            </div>
          </div>

          <div class="hrp-grid" style="margin-top: 20px;">
            <div class="hrp-col-12">
              <label class="hrp-label Mobile-No" for="test-address">Address</label>
              <textarea id="test-address" name="test-address" class="Rectangle-29-textarea" 
                        placeholder="Enter your complete address">123 Main Street, City, State, Country - 123456</textarea>
            </div>
          </div>

          <div class="hrp-actions" style="margin-top: 32px;">
            <button type="button" class="hrp-btn hrp-btn-primary">
              <i class="fa fa-save"></i> SAVE CHANGES
            </button>
          </div>
        </div>
      </div>

      <!-- UI Elements Test -->
      <div class="test-section">
        <h3>UI Elements</h3>
        
        <!-- Tabs -->
        <ul class="nav nav-tabs" style="border-bottom: 2px solid #e5e7eb; margin: 0 0 20px 0; padding: 0; list-style: none; display: flex; gap: 4px;">
          <li class="active">
            <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 14px 24px; color: #0ea5e9; text-decoration: none; border-bottom: 3px solid #0ea5e9; font-weight: 600; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              <i class="fa fa-user"></i> Personal Information
            </a>
          </li>
          <li>
            <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 14px 24px; color: #6b7280; text-decoration: none; border-bottom: 3px solid transparent; font-weight: 600; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              <i class="fa fa-money"></i> Payroll
            </a>
          </li>
          <li>
            <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 14px 24px; color: #6b7280; text-decoration: none; border-bottom: 3px solid transparent; font-weight: 600; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              <i class="fa fa-file-text"></i> Documents
            </a>
          </li>
        </ul>

        <!-- Sample Content -->
        <div style="padding: 20px 0;">
          <h2 style="font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 22px; font-weight: 800; color: #111827; margin: 0 0 10px 0;">
            Section Heading
          </h2>
          <p style="font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0;">
            This is a sample description text that shows how the Visby font family renders in paragraph form. It should be clear, readable, and maintain consistent spacing.
          </p>
        </div>
      </div>

      <!-- Font Loading Status -->
      <div class="test-section">
        <h3>Font Loading Status</h3>
        <div id="font-status" style="padding: 15px; background: #f3f4f6; border-radius: 8px; font-family: monospace; font-size: 14px;">
          Checking font loading status...
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const statusEl = document.getElementById('font-status');
  
  // Check if Visby font is loaded
  function checkFontLoading() {
    if (document.fonts && document.fonts.check) {
      const fonts = [
        '16px Visby',
        '500 16px Visby',
        '600 16px Visby', 
        '700 16px Visby',
        '800 16px Visby'
      ];
      
      const results = fonts.map(font => {
        const loaded = document.fonts.check(font);
        return `${font}: ${loaded ? '✅ Loaded' : '❌ Not Loaded'}`;
      });
      
      statusEl.innerHTML = results.join('<br>');
    } else {
      statusEl.innerHTML = '⚠️ Font loading API not supported in this browser';
    }
  }
  
  // Check immediately and after fonts load
  checkFontLoading();
  
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(checkFontLoading);
  }
  
  // Also check after a delay
  setTimeout(checkFontLoading, 2000);
});
</script>
@endsection