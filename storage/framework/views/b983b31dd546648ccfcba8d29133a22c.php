<!-- Quick Edit Modal -->
<div class="modal fade" id="quickEditModal" tabindex="-1" aria-labelledby="quickEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
                <h5 class="modal-title" id="quickEditModalLabel" style="font-weight: 700; color: #1f2937;">
                    <i class="fas fa-bolt" style="color: #3b82f6; margin-right: 8px;"></i>
                    Quick Edit Digital Card
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quickEditForm">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 style="font-weight: 600; color: #374151; margin-bottom: 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                                <i class="fas fa-user" style="color: #3b82f6; margin-right: 8px;"></i>
                                Basic Information
                            </h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Full Name</label>
                            <input type="text" class="form-control" name="full_name" id="quick_full_name" 
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Current Position</label>
                            <input type="text" class="form-control" name="current_position" id="quick_current_position"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Company Name</label>
                            <input type="text" class="form-control" name="company_name" id="quick_company_name"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Location</label>
                            <input type="text" class="form-control" name="location" id="quick_location"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>

                        <!-- Contact Information -->
                        <div class="col-12 mt-4">
                            <h6 style="font-weight: 600; color: #374151; margin-bottom: 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                                <i class="fas fa-address-book" style="color: #3b82f6; margin-right: 8px;"></i>
                                Contact Information
                            </h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Email</label>
                            <input type="email" class="form-control" name="email" id="quick_email"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Phone</label>
                            <input type="text" class="form-control" name="phone" id="quick_phone"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>

                        <!-- Social Links -->
                        <div class="col-12 mt-4">
                            <h6 style="font-weight: 600; color: #374151; margin-bottom: 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                                <i class="fas fa-share-alt" style="color: #3b82f6; margin-right: 8px;"></i>
                                Social Links
                            </h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">LinkedIn</label>
                            <input type="url" class="form-control" name="linkedin" id="quick_linkedin"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">GitHub</label>
                            <input type="url" class="form-control" name="github" id="quick_github"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Portfolio</label>
                            <input type="url" class="form-control" name="portfolio" id="quick_portfolio"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Twitter</label>
                            <input type="url" class="form-control" name="twitter" id="quick_twitter"
                                   style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;">
                        </div>

                        <!-- Skills & Summary -->
                        <div class="col-12 mt-4">
                            <h6 style="font-weight: 600; color: #374151; margin-bottom: 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                                <i class="fas fa-code" style="color: #3b82f6; margin-right: 8px;"></i>
                                Skills & Summary
                            </h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Skills (comma separated)</label>
                            <textarea class="form-control" name="skills" id="quick_skills" rows="3"
                                      style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Hobbies (comma separated)</label>
                            <textarea class="form-control" name="hobbies" id="quick_hobbies" rows="3"
                                      style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;"></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label" style="font-weight: 600; color: #374151;">Professional Summary</label>
                            <textarea class="form-control" name="summary" id="quick_summary" rows="4"
                                      style="border-radius: 10px; border: 1px solid #d1d5db; padding: 12px;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                        style="border-radius: 25px; padding: 10px 20px; font-weight: 600;">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="saveQuickEdit()" id="quickSaveBtn"
                        style="background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; border-radius: 25px; padding: 10px 20px; font-weight: 600;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Quick Edit Modal Functions
function openQuickEditModal(employeeId) {
    // Fetch current data and populate modal
    fetch(`/employees/${employeeId}/digital-card`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch digital card data');
            }
            return response.text();
        })
        .then(html => {
            // Parse the HTML to extract data (this is a simple approach)
            // In a real application, you'd want a dedicated API endpoint
            populateQuickEditForm(employeeId);
            const modal = new bootstrap.Modal(document.getElementById('quickEditModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load digital card data', 'error');
        });
}

function populateQuickEditForm(employeeId) {
    // Store employee ID for saving
    document.getElementById('quickEditForm').setAttribute('data-employee-id', employeeId);
    
    // You can populate with existing data here if needed
    // For now, we'll let users edit from current values
}

function saveQuickEdit() {
    const form = document.getElementById('quickEditForm');
    const employeeId = form.getAttribute('data-employee-id');
    const formData = new FormData(form);
    const saveBtn = document.getElementById('quickSaveBtn');
    
    // Show loading state
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
    // Convert FormData to JSON
    const data = {};
    for (let [key, value] of formData.entries()) {
        if (value.trim() !== '') {
            data[key] = value;
        }
    }
    
    // Add CSRF token
    data._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/employees/${employeeId}/digital-card/quick-edit`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Digital card updated successfully!', 'success');
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('quickEditModal'));
            modal.hide();
            // Reload page to show changes
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Failed to update digital card');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Failed to update digital card', 'error');
    })
    .finally(() => {
        // Reset button state
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
    });
}

// Enhanced quick edit with individual field updates
function quickEditField(employeeId, field, value) {
    const data = {
        field: field,
        value: value,
        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
    
    return fetch(`/employees/${employeeId}/digital-card/quick-edit`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`${field.replace('_', ' ')} updated successfully!`, 'success');
            return true;
        } else {
            throw new Error(data.message || 'Failed to update field');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Failed to update field', 'error');
        return false;
    });
}
</script><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/employees/digital-card/quick-edit-modal.blade.php ENDPATH**/ ?>