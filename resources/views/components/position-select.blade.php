@props([
    'name' => 'position',
    'id' => 'positionSelect',
    'value' => null,
    'required' => false,
    'class' => 'Rectangle-29 Rectangle-29-select',
    'showOther' => true
])

@php
    $positions = config('positions.groups');
    $currentValue = old($name, $value);
    $allPositions = config('positions.all');
    $isCustomPosition = $currentValue && !in_array($currentValue, $allPositions) && $currentValue !== 'Other';
@endphp

<select name="{{ $name }}" id="{{ $id }}" class="{{ $class }}" {{ $required ? 'required' : '' }}>
    <option value="">Select Position</option>
    @foreach($positions as $group => $items)
        <optgroup label="{{ $group }}">
            @foreach($items as $position)
                <option value="{{ $position }}" {{ $currentValue === $position ? 'selected' : '' }}>{{ $position }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select>

@if($showOther)
<div id="{{ $id }}OtherWrap" style="display: {{ $isCustomPosition || $currentValue === 'Other' ? 'block' : 'none' }}; margin-top: 10px;">
    <label class="hrp-label">Specify Position:</label>
    <input type="text" 
           id="{{ $id }}OtherInput" 
           value="{{ $isCustomPosition ? $currentValue : old($name . '_other') }}" 
           placeholder="Enter custom position" 
           class="hrp-input Rectangle-29">
</div>

<script>
(function() {
    var selectId = '{{ $id }}';
    var select = document.getElementById(selectId);
    var otherWrap = document.getElementById(selectId + 'OtherWrap');
    var otherInput = document.getElementById(selectId + 'OtherInput');
    var isRequired = {{ $required ? 'true' : 'false' }};
    
    if (!select) return;
    
    // Check if current value is custom (not in list)
    var isCustom = {{ $isCustomPosition ? 'true' : 'false' }};
    if (isCustom) {
        select.value = 'Other';
    }
    
    function toggleOther() {
        var isOther = select.value === 'Other';
        if (otherWrap) otherWrap.style.display = isOther ? 'block' : 'none';
        if (otherInput && !isOther && !isCustom) {
            otherInput.value = '';
        }
        // Update required state
        updateValidation();
    }
    
    function updateValidation() {
        var isOther = select.value === 'Other';
        var hasCustomValue = otherInput && otherInput.value.trim().length > 0;
        
        if (isOther && hasCustomValue) {
            // Remove required from select since we have a custom value
            select.removeAttribute('required');
            select.setCustomValidity('');
        } else if (isOther && !hasCustomValue) {
            // Other selected but no custom value - make input required
            select.setCustomValidity('Please enter a custom position');
        } else if (isRequired) {
            // Normal selection - restore required
            select.setAttribute('required', 'required');
            select.setCustomValidity('');
        }
    }
    
    select.addEventListener('change', toggleOther);
    if (otherInput) {
        otherInput.addEventListener('input', updateValidation);
        otherInput.addEventListener('blur', updateValidation);
    }
    
    // Initial state
    toggleOther();
    
    // Handle form submission
    var form = select.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // If "Other" is selected and custom input has value
            if (select.value === 'Other' && otherInput && otherInput.value.trim()) {
                var customValue = otherInput.value.trim();
                
                // Check if option already exists
                var exists = false;
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].value === customValue) {
                        exists = true;
                        select.value = customValue;
                        break;
                    }
                }
                
                // Create new option if doesn't exist
                if (!exists) {
                    var customOption = document.createElement('option');
                    customOption.value = customValue;
                    customOption.text = customValue;
                    customOption.selected = true;
                    select.appendChild(customOption);
                    select.value = customValue;
                }
                
                // Clear any validation errors
                select.setCustomValidity('');
            } else if (select.value === 'Other') {
                // Other selected but no custom value
                e.preventDefault();
                if (otherInput) {
                    otherInput.focus();
                    otherInput.style.borderColor = '#ef4444';
                }
                alert('Please enter a custom position name');
                return false;
            }
        }, true); // Use capture phase to run before other handlers
    }
})();
</script>
@endif
