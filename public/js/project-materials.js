// Project Materials Management
let materialsData = [];
let selectedMaterials = {};

console.log('✅ project-materials.js loaded successfully');

async function openMaterialsModal(projectId) {
    console.log('🔵 openMaterialsModal called with projectId:', projectId);
    
    if (!projectId) {
        console.error('❌ No project ID provided!');
        alert('Error: No project ID provided');
        return;
    }
    
    try {
        const baseUrl = window.appBaseUrl || '';
        const apiUrl = `${baseUrl}/projects/${projectId}/materials`;
        console.log('📡 Fetching materials from:', apiUrl);
        
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });
        
        console.log('📥 Response status:', response.status);
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        console.log('📄 Content-Type:', contentType);
        
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('❌ Response is not JSON:', text.substring(0, 500));
            throw new Error('Server returned HTML instead of JSON. Check Laravel logs.');
        }
        
        const data = await response.json();
        console.log('📦 Response data:', data);
        
        if (data.success) {
            materialsData = data.materials;
            selectedMaterials = data.selected || {};
            console.log('✅ Materials loaded:', materialsData.length);
            renderMaterialsModal();
        } else {
            console.error('❌ API returned success: false');
            alert('Failed to load materials: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('❌ Error loading materials:', error);
        alert('Error loading materials: ' + error.message);
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to load materials');
        }
    }
}

function renderMaterialsModal() {
    console.log('🎨 Rendering materials modal...');
    
    const modalHTML = `
        <div id="materialsModal" class="modal-overlay" style="display: flex; z-index: 10000; background: rgba(0, 0, 0, 0.6); align-items: center; justify-content: center;">
            <div class="modal-content" style="width: 95%; max-width: 1200px; height: 85vh; display: flex; flex-direction: column; background: white; border-radius: 16px; box-shadow: 0 25px 80px rgba(0,0,0,0.4);">
                <div class="modal-header" style="padding: 24px 32px; border-bottom: 2px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: #f9fafb;">
                    <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #000; letter-spacing: 0.5px;">--- Select Your List ---</h3>
                    <button onclick="closeMaterialsModal()" class="close-btn" style="background: #fff; border: 1px solid #d1d5db; font-size: 24px; color: #6b7280; cursor: pointer; padding: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">&times;</button>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0; flex: 1; overflow: hidden;">
                    <!-- Left Panel: Material List -->
                    <div style="border-right: 2px solid #e5e7eb; padding: 24px; overflow-y: auto; background: #fafafa;">
                        <div style="margin-bottom: 20px;">
                            <input type="text" id="materialSearch" placeholder="🔍 Search here..." 
                                style="width: 100%; padding: 12px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; color: #000; transition: all 0.2s;"
                                oninput="filterMaterials(this.value)"
                                onfocus="this.style.borderColor='#3b82f6'"
                                onblur="this.style.borderColor='#d1d5db'">
                        </div>
                        <div id="materialsList">
                            ${renderMaterialsList()}
                        </div>
                    </div>
                    
                    <!-- Right Panel: Selected Reports -->
                    <div style="overflow-y: auto; padding: 24px; background: #ffffff;">
                        <div id="selectedReportsList">
                            ${renderSelectedReports()}
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="margin-top: 0; padding: 24px 32px; border-top: 2px solid #e5e7eb; display: flex; gap: 16px; justify-content: flex-end; background: #f9fafb;">
                    <button type="button" onclick="closeMaterialsModal()" class="btn-cancel" style="padding: 12px 28px; background: white; color: #4b5563; border: 2px solid #d1d5db; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">Cancel</button>
                    <button type="button" onclick="saveMaterialsAsTasks()" class="btn-create" style="padding: 12px 28px; background: #10b981; color: white; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                        ✓ Add to Checklist
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('materialsModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

function renderMaterialsList() {
    let html = '<div style="display: flex; flex-direction: column; gap: 8px;">';
    
    // "All" checkbox
    const allChecked = materialsData.length > 0 && materialsData.every(m => 
        selectedMaterials[m.id] && selectedMaterials[m.id].length === m.reports.length
    );
    
    html += `
        <div style="padding: 12px; background: #f9fafb; border-radius: 6px; cursor: pointer; margin-bottom: 8px;" onclick="toggleAllMaterials()">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600; color: #000;">
                <input type="checkbox" ${allChecked ? 'checked' : ''} id="checkAll" onclick="event.stopPropagation(); toggleAllMaterials()" style="width: 18px; height: 18px; cursor: pointer;">
                <span style="color: #000;">▼ All</span>
            </label>
        </div>
    `;
    
    materialsData.forEach(material => {
        const isExpanded = selectedMaterials[material.id] && selectedMaterials[material.id].length > 0;
        const allReportsSelected = selectedMaterials[material.id] && selectedMaterials[material.id].length === material.reports.length;
        
        html += `
            <div class="material-item" data-material-id="${material.id}" style="border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; margin-bottom: 8px;">
                <div style="padding: 12px; background: white; cursor: pointer;" onclick="toggleMaterial(${material.id})">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600; color: #000;">
                        <input type="checkbox" ${allReportsSelected ? 'checked' : ''} 
                            onclick="event.stopPropagation(); toggleMaterialAll(${material.id})" 
                            id="material_${material.id}"
                            style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="color: #000;">${isExpanded ? '▼' : '▶'} ${material.name} (${material.reports.length})</span>
                    </label>
                </div>
                <div id="reports_${material.id}" style="display: ${isExpanded ? 'block' : 'none'}; padding: 12px 16px 16px 44px; background: #f9fafb;">
                    ${material.reports.map(report => `
                        <label style="display: flex; align-items: center; gap: 10px; padding: 8px 0; cursor: pointer;">
                            <input type="checkbox" 
                                ${selectedMaterials[material.id] && selectedMaterials[material.id].includes(report.id) ? 'checked' : ''}
                                onchange="toggleReport(${material.id}, ${report.id})"
                                class="report-checkbox-${material.id}"
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <span style="font-size: 14px; color: #000;">${report.name}</span>
                        </label>
                    `).join('')}
                    <button onclick="addNewReport(${material.id}, '${material.name}')" style="margin-top: 12px; padding: 8px 16px; background: white; border: 2px dashed #d1d5db; border-radius: 6px; color: #6b7280; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.borderColor='#3b82f6'; this.style.color='#3b82f6'" onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#6b7280'">
                        <span style="font-size: 16px;">+</span> Add an item
                    </button>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    return html;
}

function renderSelectedReports() {
    let html = '<div style="display: flex; flex-direction: column; gap: 12px; padding: 12px;">';
    
    const hasSelections = Object.keys(selectedMaterials).some(key => selectedMaterials[key] && selectedMaterials[key].length > 0);
    
    if (!hasSelections) {
        html += '<p style="text-align: center; color: #9ca3af; padding: 40px; font-size: 14px;">No items selected</p>';
    } else {
        materialsData.forEach(material => {
            if (selectedMaterials[material.id] && selectedMaterials[material.id].length > 0) {
                const selectedReports = material.reports.filter(r => selectedMaterials[material.id].includes(r.id));
                
                html += `
                    <div style="border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; background: white;">
                        <div style="padding: 10px 12px; background: #f3f4f6; font-weight: 600; font-size: 14px; color: #000;">
                            ▼ ${material.name} (${selectedReports.length}/${material.reports.length})
                        </div>
                        <div style="padding: 8px 12px; background: white;">
                            ${selectedReports.map(report => `
                                <div style="display: flex; align-items: center; gap: 8px; padding: 4px 0;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <span style="font-size: 13px; color: #000;">${report.name}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }
        });
    }
    
    html += '</div>';
    return html;
}

function toggleMaterial(materialId) {
    const reportsDiv = document.getElementById(`reports_${materialId}`);
    if (reportsDiv) {
        reportsDiv.style.display = reportsDiv.style.display === 'none' ? 'block' : 'none';
    }
}

function toggleMaterialAll(materialId) {
    const material = materialsData.find(m => m.id === materialId);
    if (!material) return;
    
    const checkbox = document.getElementById(`material_${materialId}`);
    const isChecked = checkbox.checked;
    
    if (isChecked) {
        selectedMaterials[materialId] = material.reports.map(r => r.id);
    } else {
        selectedMaterials[materialId] = [];
    }
    
    // Update all report checkboxes
    const reportCheckboxes = document.querySelectorAll(`.report-checkbox-${materialId}`);
    reportCheckboxes.forEach(cb => cb.checked = isChecked);
    
    updateSelectedReports();
}

function toggleReport(materialId, reportId) {
    if (!selectedMaterials[materialId]) {
        selectedMaterials[materialId] = [];
    }
    
    const index = selectedMaterials[materialId].indexOf(reportId);
    if (index > -1) {
        selectedMaterials[materialId].splice(index, 1);
    } else {
        selectedMaterials[materialId].push(reportId);
    }
    
    // Update material checkbox
    const material = materialsData.find(m => m.id === materialId);
    const materialCheckbox = document.getElementById(`material_${materialId}`);
    if (materialCheckbox && material) {
        materialCheckbox.checked = selectedMaterials[materialId].length === material.reports.length;
    }
    
    updateSelectedReports();
}

function toggleAllMaterials() {
    const checkAll = document.getElementById('checkAll');
    const isChecked = checkAll.checked;
    
    materialsData.forEach(material => {
        if (isChecked) {
            selectedMaterials[material.id] = material.reports.map(r => r.id);
        } else {
            selectedMaterials[material.id] = [];
        }
        
        const materialCheckbox = document.getElementById(`material_${material.id}`);
        if (materialCheckbox) {
            materialCheckbox.checked = isChecked;
        }
        
        const reportCheckboxes = document.querySelectorAll(`.report-checkbox-${material.id}`);
        reportCheckboxes.forEach(cb => cb.checked = isChecked);
    });
    
    updateSelectedReports();
}

function updateSelectedReports() {
    const selectedReportsDiv = document.getElementById('selectedReportsList');
    if (selectedReportsDiv) {
        selectedReportsDiv.innerHTML = renderSelectedReports();
    }
}

function filterMaterials(searchTerm) {
    const term = searchTerm.toLowerCase();
    const materialItems = document.querySelectorAll('.material-item');
    
    materialItems.forEach(item => {
        const materialId = item.getAttribute('data-material-id');
        const material = materialsData.find(m => m.id == materialId);
        
        if (!material) return;
        
        const materialNameMatch = material.name.toLowerCase().includes(term);
        const reportMatch = material.reports.some(r => r.name.toLowerCase().includes(term));
        
        if (materialNameMatch || reportMatch || term === '') {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

async function saveMaterials() {
    try {
        const materials = [];
        
        Object.keys(selectedMaterials).forEach(materialId => {
            if (selectedMaterials[materialId] && selectedMaterials[materialId].length > 0) {
                materials.push({
                    material_id: parseInt(materialId),
                    report_ids: selectedMaterials[materialId]
                });
            }
        });
        
        const baseUrl = window.appBaseUrl || '';
        const apiUrl = `${baseUrl}/projects/${projectId}/materials`;
        
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin',
            body: JSON.stringify({ materials })
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (typeof toastr !== 'undefined') {
                toastr.success('Materials updated successfully');
            }
            closeMaterialsModal();
            // Reload tasks or refresh the page
            if (typeof loadTasks === 'function') {
                loadTasks();
            }
        } else {
            throw new Error(data.message || 'Failed to save materials');
        }
    } catch (error) {
        console.error('Error saving materials:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to save materials: ' + error.message);
        }
    }
}

function closeMaterialsModal() {
    const modal = document.getElementById('materialsModal');
    if (modal) {
        modal.remove();
    }
}

// Add new report to a material
async function addNewReport(materialId, materialName) {
    const reportName = prompt(`Add new report to "${materialName}":`, '');
    
    if (!reportName || reportName.trim() === '') {
        return;
    }
    
    try {
        const baseUrl = window.appBaseUrl || '';
        const response = await fetch(`${baseUrl}/api/materials/${materialId}/reports`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin',
            body: JSON.stringify({ name: reportName.trim() })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Add the new report to the material
            const material = materialsData.find(m => m.id === materialId);
            if (material) {
                material.reports.push(data.report);
            }
            
            // Re-render the modal
            document.getElementById('materialsList').innerHTML = renderMaterialsList();
            
            if (typeof toastr !== 'undefined') {
                toastr.success('Report added successfully');
            } else {
                alert('Report added successfully!');
            }
        } else {
            throw new Error(data.message || 'Failed to add report');
        }
    } catch (error) {
        console.error('Error adding report:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to add report: ' + error.message);
        } else {
            alert('Failed to add report: ' + error.message);
        }
    }
}

// Save materials as tasks and reports as subtasks
async function saveMaterialsAsTasks() {
    try {
        const tasksToCreate = [];
        
        // Build tasks structure: materials as tasks, reports as subtasks
        Object.keys(selectedMaterials).forEach(materialId => {
            if (selectedMaterials[materialId] && selectedMaterials[materialId].length > 0) {
                const material = materialsData.find(m => m.id == materialId);
                if (material) {
                    const subtasks = selectedMaterials[materialId].map(reportId => {
                        const report = material.reports.find(r => r.id === reportId);
                        return report ? report.name : null;
                    }).filter(name => name !== null);
                    
                    tasksToCreate.push({
                        material_id: parseInt(materialId),
                        material_name: material.name,
                        report_ids: selectedMaterials[materialId],
                        subtasks: subtasks
                    });
                }
            }
        });
        
        if (tasksToCreate.length === 0) {
            alert('Please select at least one material and report');
            return;
        }
        
        const baseUrl = window.appBaseUrl || '';
        const response = await fetch(`${baseUrl}/projects/${projectId}/materials/create-tasks`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin',
            body: JSON.stringify({ tasks: tasksToCreate })
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (typeof toastr !== 'undefined') {
                toastr.success(`Created ${data.tasks_created} tasks with ${data.subtasks_created} subtasks`);
            } else {
                alert(`Success! Created ${data.tasks_created} tasks with ${data.subtasks_created} subtasks`);
            }
            
            closeMaterialsModal();
            
            // Reload tasks
            if (typeof loadTasks === 'function') {
                loadTasks();
            } else {
                // Refresh the page to show new tasks
                location.reload();
            }
        } else {
            throw new Error(data.message || 'Failed to create tasks');
        }
    } catch (error) {
        console.error('Error creating tasks:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to create tasks: ' + error.message);
        } else {
            alert('Failed to create tasks: ' + error.message);
        }
    }
}
