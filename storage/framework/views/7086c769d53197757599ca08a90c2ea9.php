<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'mobile_no',
    'label' => 'Mobile Number',
    'value' => '',
    'required' => false,
    'placeholder' => '9876543210',
    'class' => 'hrp-input Rectangle-29'
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name' => 'mobile_no',
    'label' => 'Mobile Number',
    'value' => '',
    'required' => false,
    'placeholder' => '9876543210',
    'class' => 'hrp-input Rectangle-29'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Extract country code and number from existing value
    $countryCode = '+91';
    $phoneNumber = $value;
    
    if (!empty($value)) {
        // Remove any spaces first
        $cleanValue = str_replace(' ', '', $value);
        
        // Check if value already has a country code
        // Use non-greedy match and ensure we get exactly 10 digits for phone number
        if (preg_match('/^(\+\d{1,4}?)(\d{10})$/', $cleanValue, $matches)) {
            $countryCode = $matches[1];
            $phoneNumber = $matches[2];
        } elseif (preg_match('/^\d+$/', $cleanValue)) {
            // If it's just digits without country code
            $phoneNumber = $cleanValue;
        }
    }
?>

<div>
    <label class="hrp-label">
        <?php echo e($label); ?>

        <?php if($required): ?>
            <span class="text-red-500">*</span>
        <?php endif; ?>
    </label>
    
    <div class="phone-input-container <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <!-- Country Code Dropdown -->
        <select 
            name="<?php echo e($name); ?>_country_code" 
            class="country-code-select"
        >
            <option value="+91" <?php echo e($countryCode === '+91' ? 'selected' : ''); ?>>🇮🇳 +91</option>
            <option value="+1" <?php echo e($countryCode === '+1' ? 'selected' : ''); ?>>🇺🇸 +1</option>
            <option value="+44" <?php echo e($countryCode === '+44' ? 'selected' : ''); ?>>🇬🇧 +44</option>
            <option value="+86" <?php echo e($countryCode === '+86' ? 'selected' : ''); ?>>🇨🇳 +86</option>
            <option value="+81" <?php echo e($countryCode === '+81' ? 'selected' : ''); ?>>🇯🇵 +81</option>
            <option value="+49" <?php echo e($countryCode === '+49' ? 'selected' : ''); ?>>🇩🇪 +49</option>
            <option value="+33" <?php echo e($countryCode === '+33' ? 'selected' : ''); ?>>🇫🇷 +33</option>
            <option value="+39" <?php echo e($countryCode === '+39' ? 'selected' : ''); ?>>🇮🇹 +39</option>
            <option value="+34" <?php echo e($countryCode === '+34' ? 'selected' : ''); ?>>🇪🇸 +34</option>
            <option value="+7" <?php echo e($countryCode === '+7' ? 'selected' : ''); ?>>🇷🇺 +7</option>
            <option value="+55" <?php echo e($countryCode === '+55' ? 'selected' : ''); ?>>🇧🇷 +55</option>
            <option value="+61" <?php echo e($countryCode === '+61' ? 'selected' : ''); ?>>🇦🇺 +61</option>
            <option value="+82" <?php echo e($countryCode === '+82' ? 'selected' : ''); ?>>🇰🇷 +82</option>
            <option value="+65" <?php echo e($countryCode === '+65' ? 'selected' : ''); ?>>🇸🇬 +65</option>
            <option value="+60" <?php echo e($countryCode === '+60' ? 'selected' : ''); ?>>🇲🇾 +60</option>
            <option value="+66" <?php echo e($countryCode === '+66' ? 'selected' : ''); ?>>🇹🇭 +66</option>
            <option value="+84" <?php echo e($countryCode === '+84' ? 'selected' : ''); ?>>🇻🇳 +84</option>
            <option value="+62" <?php echo e($countryCode === '+62' ? 'selected' : ''); ?>>🇮🇩 +62</option>
            <option value="+63" <?php echo e($countryCode === '+63' ? 'selected' : ''); ?>>🇵🇭 +63</option>
            <option value="+971" <?php echo e($countryCode === '+971' ? 'selected' : ''); ?>>🇦🇪 +971</option>
            <option value="+966" <?php echo e($countryCode === '+966' ? 'selected' : ''); ?>>🇸🇦 +966</option>
        </select>
        
        <!-- Phone Number Input -->
        <input 
            type="tel" 
            name="<?php echo e($name); ?>" 
            placeholder="<?php echo e($placeholder); ?>" 
            value="<?php echo e($phoneNumber); ?>"
            class="phone-number-input"
            inputmode="numeric"
            maxlength="10"
            minlength="10"
            pattern="[0-9]{10}"
            title="Please enter exactly 10 digits"
            <?php echo e($required ? 'required' : ''); ?>

            <?php echo e($attributes); ?>

        >
        
        <!-- Hidden field to store complete phone number -->
        <input type="hidden" name="<?php echo e($name); ?>_full" class="phone-full-value">
    </div>
    
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="hrp-error"><?php echo e($message); ?></small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<!-- Include phone input CSS -->
<link rel="stylesheet" href="<?php echo e(asset('css/phone-input.css')); ?>"?v=<?php echo e(time()); ?>">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle phone input combination
    const phoneInputs = document.querySelectorAll('.phone-number-input');
    
    phoneInputs.forEach(function(input) {
        const container = input.closest('.phone-input-container');
        if (!container) return;
        
        const countrySelect = container.querySelector('.country-code-select');
        const hiddenInput = container.querySelector('.phone-full-value');
        
        if (!countrySelect || !hiddenInput) return;
        
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
            // Only allow digits and limit to 10 characters
            this.value = this.value.replace(/\D/g, '').substring(0, 10);
            updateFullValue();
        });
        
        // Initialize
        updateFullValue();
        
        // Before form submission, keep only the phone number (without country code)
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                // Keep the phone number as-is (digits only, no country code)
                // The backend validation expects 10 digits without country code
                input.value = input.value.replace(/\D/g, '');
            });
        }
    });
});
</script><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/components/phone-input.blade.php ENDPATH**/ ?>