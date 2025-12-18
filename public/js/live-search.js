/**
 * Live Search Implementation
 * Automatically submits search forms as user types
 * Does NOT show the global page loader for filter operations
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

    // Hide loader function
    function hideLoader() {
        const loader = document.getElementById('globalPageLoader');
        if (loader) {
            loader.classList.add('hidden');
        }
    }

    // Initialize live search on page load
    function initLiveSearch() {
        // Find all search inputs with live-search class
        const searchInputs = document.querySelectorAll('input.live-search, input[name="search"], input[name="q"], input[type="search"]');

        searchInputs.forEach(input => {
            const form = input.closest('form');
            if (!form) return;

            // Mark form as no-loader to prevent global loader from showing
            form.setAttribute('data-no-loader', 'true');

            // Create debounced submit function
            const debouncedSubmit = debounce(() => {
                // Ensure loader is hidden before submit
                hideLoader();
                // Trigger form submission without loader
                form.submit();
            }, 500); // Wait 500ms after user stops typing

            // Add input event listener
            input.addEventListener('input', function() {
                // Immediately hide loader when typing
                hideLoader();
                debouncedSubmit();
            });

            // Also hide loader on keydown
            input.addEventListener('keydown', function() {
                hideLoader();
            });

            // Add visual feedback
            input.addEventListener('focus', function() {
                hideLoader();
                this.style.borderColor = '#3b82f6';
                this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
            });

            // Clear visual feedback on blur if empty
            input.addEventListener('blur', function() {
                if (this.value.length === 0) {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                }
            });
        });

        // Also handle filter selects for live filtering
        const filterSelects = document.querySelectorAll('select.live-filter, select[name*="filter"], .jv-filter select, .filter-form select');

        filterSelects.forEach(select => {
            const form = select.closest('form');
            if (!form) return;

            // Mark form as no-loader
            form.setAttribute('data-no-loader', 'true');

            select.addEventListener('change', function() {
                hideLoader();
                form.submit();
            });
        });

        // Mark all filter forms to not show loader
        const filterForms = document.querySelectorAll('.jv-filter, .filter-form, .hrp-entries-form, .performa-filter, form[id*="filter"], form[id*="Filter"]');
        filterForms.forEach(form => {
            form.setAttribute('data-no-loader', 'true');

            // Add submit listener to hide loader
            form.addEventListener('submit', function() {
                hideLoader();
            });
        });

        // Handle all filter-pill inputs
        const filterPills = document.querySelectorAll('.filter-pill');
        filterPills.forEach(input => {
            const form = input.closest('form');
            if (!form) return;

            form.setAttribute('data-no-loader', 'true');

            // For text inputs, hide loader on any interaction
            if (input.tagName === 'INPUT') {
                input.addEventListener('input', hideLoader);
                input.addEventListener('keydown', hideLoader);
                input.addEventListener('focus', hideLoader);
            }

            // For selects, hide loader on change
            if (input.tagName === 'SELECT') {
                input.addEventListener('change', function() {
                    hideLoader();
                    if (form) form.submit();
                });
            }
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

    // Expose hideLoader globally for manual use
    window.hideFilterLoader = hideLoader;
})();
