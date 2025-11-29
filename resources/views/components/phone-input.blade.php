@props([
    'name' => 'mobile_no',
    'label' => 'Mobile Number',
    'value' => '',
    'required' => false,
    'placeholder' => '9876543210',
    'class' => 'hrp-input Rectangle-29'
])

@php
    // Extract country code and number from existing value
    $countryCode = '+91';
    $phoneNumber = $value;
    
    if (!empty($value)) {
        // Check if value already has a country code
        if (preg_match('/^(\+\d{1,4})(.*)$/', $value, $matches)) {
            $countryCode = $matches[1];
            $phoneNumber = ltrim($matches[2], ' ');
        }
    }
@endphp

<div>
    <label class="hrp-label">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <div class="phone-input-container @error($name) error @enderror">
        <!-- Country Code Dropdown -->
        <select 
            name="{{ $name }}_country_code" 
            class="country-code-select"
        >
            <option value="+91" {{ $countryCode === '+91' ? 'selected' : '' }}>🇮🇳 +91</option>
            <option value="+1" {{ $countryCode === '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
            <option value="+44" {{ $countryCode === '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
            <option value="+86" {{ $countryCode === '+86' ? 'selected' : '' }}>🇨🇳 +86</option>
            <option value="+81" {{ $countryCode === '+81' ? 'selected' : '' }}>🇯🇵 +81</option>
            <option value="+49" {{ $countryCode === '+49' ? 'selected' : '' }}>🇩🇪 +49</option>
            <option value="+33" {{ $countryCode === '+33' ? 'selected' : '' }}>🇫🇷 +33</option>
            <option value="+39" {{ $countryCode === '+39' ? 'selected' : '' }}>🇮🇹 +39</option>
            <option value="+34" {{ $countryCode === '+34' ? 'selected' : '' }}>🇪🇸 +34</option>
            <option value="+7" {{ $countryCode === '+7' ? 'selected' : '' }}>🇷🇺 +7</option>
            <option value="+55" {{ $countryCode === '+55' ? 'selected' : '' }}>🇧🇷 +55</option>
            <option value="+61" {{ $countryCode === '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
            <option value="+82" {{ $countryCode === '+82' ? 'selected' : '' }}>🇰🇷 +82</option>
            <option value="+65" {{ $countryCode === '+65' ? 'selected' : '' }}>🇸🇬 +65</option>
            <option value="+60" {{ $countryCode === '+60' ? 'selected' : '' }}>🇲🇾 +60</option>
            <option value="+66" {{ $countryCode === '+66' ? 'selected' : '' }}>🇹🇭 +66</option>
            <option value="+84" {{ $countryCode === '+84' ? 'selected' : '' }}>🇻🇳 +84</option>
            <option value="+62" {{ $countryCode === '+62' ? 'selected' : '' }}>🇮🇩 +62</option>
            <option value="+63" {{ $countryCode === '+63' ? 'selected' : '' }}>🇵🇭 +63</option>
            <option value="+971" {{ $countryCode === '+971' ? 'selected' : '' }}>🇦🇪 +971</option>
            <option value="+966" {{ $countryCode === '+966' ? 'selected' : '' }}>🇸🇦 +966</option>
        </select>
        
        <!-- Phone Number Input -->
        <input 
            type="tel" 
            name="{{ $name }}" 
            placeholder="{{ $placeholder }}" 
            value="{{ $phoneNumber }}"
            class="phone-number-input"
            inputmode="numeric"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
        
        <!-- Hidden field to store complete phone number -->
        <input type="hidden" name="{{ $name }}_full" class="phone-full-value">
    </div>
    
    @error($name)
        <small class="hrp-error">{{ $message }}</small>
    @enderror
</div>

<!-- Include phone input CSS -->
<link rel="stylesheet" href="{{ asset('css/phone-input.css') }}"?v={{ time() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle phone input combination
    const phoneInputs = document.querySelectorAll('.phone-number-input');
    
    phoneInputs.forEach(function(input) {
        const container = input.closest('div[style*="display: flex"]');
        const countrySelect = container.querySelector('.country-code-select');
        const hiddenInput = container.querySelector('.phone-full-value');
        
        function updateFullValue() {
            const countryCode = countrySelect.value;
            const phoneNumber = input.value.replace(/\D/g, ''); // Remove non-digits
            const fullValue = phoneNumber ? countryCode + phoneNumber : '';
            hiddenInput.value = fullValue;
            
            // Also update the main input's value for form submission
            input.setAttribute('data-full-value', fullValue);
        }
        
        // Update on country code change
        countrySelect.addEventListener('change', updateFullValue);
        
        // Update on phone number input
        input.addEventListener('input', function() {
            // Only allow digits
            this.value = this.value.replace(/\D/g, '');
            updateFullValue();
        });
        
        // Initialize
        updateFullValue();
        
        // Before form submission, update the main input value
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                const fullValue = hiddenInput.value;
                if (fullValue) {
                    input.value = fullValue;
                }
            });
        }
    });
});
</script>