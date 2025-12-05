/**
 * Live Search Implementation
 * Automatically submits search forms as user types
 */

(function() {
    'use strict';
    
    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Initialize live search on page load
    function initLiveSearch() {
        // Find all search inputs
        const searchInputs = document.querySelectorAll('input[name="search"], input[type="search"], input.live-search');
        
        searchInputs.forEach(input => {
            const form = input.closest('form');
            if (!form) return;
            
            // Keep search button visible - users can click it or wait for auto-submit
            // Button stays visible for manual search option
            
            // Create debounced submit function
            const debouncedSubmit = debounce(() => {
                // Trigger form submission
                form.submit();
            }, 500); // Wait 500ms after user stops typing
            
            // Add input event listener
            input.addEventListener('input', function() {
                debouncedSubmit();
            });
            
            // Add visual feedback
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.style.borderColor = '#3b82f6';
                    this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
                } else {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                }
            });
        });
        
        // Also handle filter selects for live filtering
        const filterSelects = document.querySelectorAll('select.live-filter, select[name*="filter"]');
        
        filterSelects.forEach(select => {
            const form = select.closest('form');
            if (!form) return;
            
            select.addEventListener('change', function() {
                form.submit();
            });
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLiveSearch);
    } else {
        initLiveSearch();
    }
    
    // Re-initialize after AJAX content loads (if using AJAX)
    window.reinitLiveSearch = initLiveSearch;
})();
