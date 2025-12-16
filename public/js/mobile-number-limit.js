/**
 * Mobile Number 10-Digit Limit Enforcer
 * Automatically applies 10-digit limit to all mobile/phone number fields
 * Allows +91 country code prefix for proforma/quotation forms
 */

(function() {
    'use strict';
    
    // Function to enforce 10-digit limit on an input
    function enforceMobileLimit(input) {
        // Skip if already has maxlength set
        if (input.hasAttribute('maxlength') && parseInt(input.getAttribute('maxlength')) === 10) {
            return;
        }
        
        // Skip if input has 'allow-country-code' class (for proforma/quotation forms)
        if (input.classList.contains('allow-country-code')) {
            return;
        }
        
        // Set maxlength attribute
        input.setAttribute('maxlength', '10');
        input.setAttribute('minlength', '10');
        input.setAttribute('inputmode', 'numeric');
        input.setAttribute('pattern', '[0-9]{10}');
        input.setAttribute('title', 'Please enter exactly 10 digits');
        
        // Add input event listener to enforce digits only
        input.addEventListener('input', function(e) {
            // Remove any non-digit characters
            let value = this.value.replace(/\D/g, '');
            
            // Limit to 10 digits
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            
            this.value = value;
        });
        
        // Add paste event listener
        input.addEventListener('paste', function(e) {
            setTimeout(() => {
                let value = this.value.replace(/\D/g, '');
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }
                this.value = value;
            }, 10);
        });
    }
    
    // Function to find and process all mobile number inputs
    function processMobileInputs() {
        // Selectors for mobile/phone number fields
        const selectors = [
            'input[name*="mobile"]',
            'input[name*="phone"]',
            'input[name*="contact_number"]',
            'input[name*="contact_mobile"]',
            'input[name*="company_phone"]',
            'input[name*="father_mobile"]',
            'input[name*="mother_mobile"]',
            'input[name*="emergency_contact"]',
            'input[placeholder*="mobile"]',
            'input[placeholder*="phone"]',
            'input[placeholder*="10 digit"]',
            'input[type="tel"]',
            '.phone-number-input'
        ];
        
        // Find all matching inputs
        const inputs = document.querySelectorAll(selectors.join(', '));
        
        inputs.forEach(input => {
            // Skip if it's a country code selector, already processed, or allows country code
            if (input.classList.contains('country-code-select') || 
                input.classList.contains('mobile-limit-processed') ||
                input.classList.contains('allow-country-code')) {
                return;
            }
            
            // Mark as processed
            input.classList.add('mobile-limit-processed');
            
            // Apply limit
            enforceMobileLimit(input);
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', processMobileInputs);
    } else {
        processMobileInputs();
    }
    
    // Re-process when new content is added (for dynamic forms)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                processMobileInputs();
            }
        });
    });
    
    // Start observing
    if (document.body) {
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    // Export function for manual use
    window.enforceMobileLimits = processMobileInputs;
})();
