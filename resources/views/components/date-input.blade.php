@props([
    'name' => 'date',
    'label' => 'Date',
    'value' => '',
    'required' => false,
    'placeholder' => 'dd/mm/yyyy',
    'class' => 'Rectangle-29'
])

@php
    // Format the value to dd/mm/yyyy if it's a date object or Y-m-d format
    $formattedValue = $value;
    
    if (!empty($value)) {
        try {
            // If it's a Carbon instance or date object
            if (is_object($value) && method_exists($value, 'format')) {
                $formattedValue = $value->format('d/m/Y');
            }
            // If it's a Y-m-d string, convert it
            elseif (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $date = \Carbon\Carbon::createFromFormat('Y-m-d', $value);
                $formattedValue = $date->format('d/m/Y');
            }
            // If it's already in dd/mm/yyyy format, keep it
            elseif (is_string($value) && preg_match('/^\d{1,2}\/\d{1,2}\/\d{2,4}$/', $value)) {
                $formattedValue = $value;
            }
        } catch (\Exception $e) {
            // If parsing fails, use the original value
            $formattedValue = $value;
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
    
    <input 
        type="text" 
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}" 
        value="{{ $formattedValue }}"
        class="date-input-field {{ $class }} @error($name) is-invalid @enderror"
        autocomplete="off"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
    
    @error($name)
        <small class="hrp-error">{{ $message }}</small>
    @enderror
</div>

<!-- Include date input CSS and JS -->
<link rel="stylesheet" href="{{ asset('css/date-input.css') }}?v={{ time() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date picker for all date input fields
    const dateInputs = document.querySelectorAll('.date-input-field');
    
    dateInputs.forEach(function(input) {
        // Add input formatting
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            
            // Format as dd/mm/yyyy
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            if (value.length >= 5) {
                value = value.substring(0, 5) + '/' + value.substring(5, 9);
            }
            
            e.target.value = value;
        });
        
        // Add date validation
        input.addEventListener('blur', function(e) {
            const value = e.target.value;
            if (value && !isValidDate(value)) {
                e.target.classList.add('invalid-date');
                // Show validation message
                showDateError(e.target, 'Please enter a valid date in dd/mm/yyyy format');
            } else {
                e.target.classList.remove('invalid-date');
                hideDateError(e.target);
            }
        });
        
        // Add calendar icon click handler
        const calendarIcon = input.nextElementSibling;
        if (calendarIcon && calendarIcon.classList.contains('calendar-icon')) {
            calendarIcon.addEventListener('click', function() {
                // Create a temporary date input to open native date picker
                const tempInput = document.createElement('input');
                tempInput.type = 'date';
                tempInput.style.position = 'absolute';
                tempInput.style.left = '-9999px';
                document.body.appendChild(tempInput);
                
                // Convert current value to Y-m-d format for date input
                const currentValue = input.value;
                if (currentValue && isValidDate(currentValue)) {
                    const parts = currentValue.split('/');
                    if (parts.length === 3) {
                        let year = parts[2];
                        if (year.length === 2) {
                            year = '20' + year;
                        }
                        tempInput.value = year + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
                    }
                }
                
                tempInput.addEventListener('change', function() {
                    if (this.value) {
                        const date = new Date(this.value);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = String(date.getFullYear());
                        input.value = day + '/' + month + '/' + year;
                        input.dispatchEvent(new Event('change'));
                    }
                    document.body.removeChild(this);
                });
                
                tempInput.click();
            });
        }
    });
    
    function isValidDate(dateString) {
        const regex = /^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/;
        const match = dateString.match(regex);
        
        if (!match) return false;
        
        const day = parseInt(match[1], 10);
        const month = parseInt(match[2], 10);
        let year = parseInt(match[3], 10);
        
        // Convert 2-digit year to 4-digit
        if (year < 100) {
            year += 2000;
        }
        
        // Check if date is valid
        const date = new Date(year, month - 1, day);
        return date.getFullYear() === year && 
               date.getMonth() === month - 1 && 
               date.getDate() === day;
    }
    
    function showDateError(input, message) {
        hideDateError(input); // Remove existing error
        
        const errorElement = document.createElement('small');
        errorElement.className = 'hrp-error date-error';
        errorElement.textContent = message;
        input.parentNode.appendChild(errorElement);
    }
    
    function hideDateError(input) {
        const existingError = input.parentNode.querySelector('.date-error');
        if (existingError) {
            existingError.remove();
        }
    }
});
</script>