@extends('layouts.macos')
@section('page_title', 'Project Stages Settings')

@push('styles')
<style>
  /* Drag and Drop Styles */
  .stages-list { max-width: 900px; margin: 0 auto; }
  .stage-item { background: white; border-radius: 12px; padding: 20px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); transition: all 0.3s; cursor: move; border-left: 4px solid; display: flex; align-items: center; gap: 16px; }
  .stage-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
  .stage-item.sortable-ghost { opacity: 0.4; background: #f3f4f6; }
  .stage-item.sortable-drag { box-shadow: 0 8px 24px rgba(0,0,0,0.2); transform: rotate(2deg); }
  
  .drag-handle { display: flex; flex-direction: column; gap: 3px; cursor: grab; padding: 8px; border-radius: 6px; transition: all 0.2s; }
  .drag-handle:hover { background: #f3f4f6; }
  .drag-handle:active { cursor: grabbing; }
  .drag-handle span { width: 20px; height: 3px; background: #9ca3af; border-radius: 2px; }
  
  .stage-order { min-width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #f3f4f6; border-radius: 10px; font-weight: 700; color: #6b7280; font-size: 16px; }
  
  .stage-color-indicator { width: 48px; height: 48px; border-radius: 10px; flex-shrink: 0; }
  
  .stage-info { flex: 1; min-width: 0; }
  .stage-name { font-size: 16px; font-weight: 600; color: #1f2937; margin: 0 0 4px 0; }
  .stage-meta { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #6b7280; }
  .stage-count { display: inline-flex; align-items: center; gap: 4px; background: #f3f4f6; padding: 4px 10px; border-radius: 12px; font-weight: 500; }
  .stage-description { font-size: 13px; color: #6b7280; margin-top: 8px; line-height: 1.4; }
  
  .stage-actions { display: flex; gap: 8px; }
  .stage-action-btn { padding: 8px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; border: 1px solid; display: inline-flex; align-items: center; gap: 6px; background: white; }
  .btn-edit-stage { border-color: #f59e0b; color: #f59e0b; }
  .btn-edit-stage:hover { background: #f59e0b; color: white; }
  .btn-delete-stage { border-color: #ef4444; color: #ef4444; }
  .btn-delete-stage:hover { background: #ef4444; color: white; }
  
  /* Modal Styles */
  .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 9999; }
  .modal-content { background: white; border-radius: 16px; padding: 24px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; }
  .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
  .modal-header h3 { font-size: 20px; font-weight: 600; color: #1f2937; margin: 0; }
  .close-btn { background: none; border: none; font-size: 28px; color: #6b7280; cursor: pointer; line-height: 1; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; transition: all 0.2s; }
  .close-btn:hover { background: #f3f4f6; color: #1f2937; }
  
  .form-group { margin-bottom: 20px; }
  .form-group label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px; }
  .form-input { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; }
  .form-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
  
  .color-input-wrapper { display: flex; align-items: center; gap: 12px; }
  .color-preview { width: 48px; height: 48px; border-radius: 8px; border: 2px solid #e5e7eb; cursor: pointer; transition: all 0.2s; }
  .color-preview:hover { border-color: #3b82f6; transform: scale(1.05); }
  .color-input { display: none; }
  .color-text { flex: 1; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-family: monospace; text-transform: uppercase; }
  
  .color-presets { display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px; margin-top: 12px; }
  .color-preset { width: 100%; aspect-ratio: 1; border-radius: 8px; cursor: pointer; transition: all 0.2s; border: 2px solid transparent; }
  .color-preset:hover { transform: scale(1.1); border-color: #3b82f6; }
  
  .form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; }
  .btn-cancel { padding: 10px 20px; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
  .btn-cancel:hover { background: #e5e7eb; }
  .btn-create { padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
  .btn-create:hover { background: #2563eb; }
  
  .empty-state { text-align: center; padding: 60px 20px; color: #6b7280; }
  .empty-state svg { width: 64px; height: 64px; margin-bottom: 16px; opacity: 0.5; }
</style>
@endpush

@section('content')
<div class="hrp-card">
  <div class="hrp-card-body">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <div>
        <h2 style="font-size: 20px; font-weight: 700; color: #1f2937; margin: 0 0 4px 0;"></h2>
        <p style="font-size: 14px; color: #6b7280; margin: 0;"></p>
      </div>
      <div style="display: flex; gap: 12px;">
        <a href="{{ route('projects.index') }}" class="pill-btn pill-secondary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          Back
        </a>
        <button onclick="openStageModal()" class="pill-btn pill-success">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Add Stage
        </button>
      </div>
    </div>

    <div class="stages-list" id="stagesList">
      @forelse($stages as $index => $stage)
      <div class="stage-item" data-id="{{ $stage->id }}" style="border-left-color: {{ $stage->color }};">
        <div class="drag-handle">
          <span></span>
          <span></span>
          <span></span>
        </div>
        
        <div class="stage-order">{{ $index + 1 }}</div>
        
        <div class="stage-color-indicator" style="background: {{ $stage->color }};"></div>
        
        <div class="stage-info">
          <h3 class="stage-name">{{ $stage->name }}</h3>
          <div class="stage-meta">
            <span class="stage-count">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
              </svg>
              {{ $stage->projects_count }} {{ Str::plural('project', $stage->projects_count) }}
            </span>
            <span style="font-family: monospace; font-size: 12px;">{{ $stage->color }}</span>
          </div>
          @if($stage->description)
          <p class="stage-description">{{ $stage->description }}</p>
          @endif
        </div>
        
        <div class="stage-actions">
          <button onclick="editStage({{ $stage->id }})" class="stage-action-btn btn-edit-stage">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            Edit
          </button>
          <button onclick="deleteStage({{ $stage->id }}, '{{ $stage->name }}', {{ $stage->projects_count }})" class="stage-action-btn btn-delete-stage">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
            Delete
          </button>
        </div>
      </div>
      @empty
      <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin: 0 auto 16px; opacity: 0.5;">
          <rect x="3" y="3" width="7" height="18" rx="1"></rect>
          <rect x="14" y="3" width="7" height="10" rx="1"></rect>
        </svg>
        <p style="font-size: 16px; margin: 0;">No stages created yet</p>
        <p style="font-size: 14px; margin-top: 8px;">Create your first project stage to get started</p>
      </div>
      @endforelse
    </div>
  </div>
</div>

<!-- Create/Edit Stage Modal -->
<div id="stageModal" class="modal-overlay" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <h3 id="modalTitle">Create New Stage</h3>
      <button onclick="closeStageModal()" class="close-btn">&times;</button>
    </div>
    <form id="stageForm">
      @csrf
      <input type="hidden" id="stageId" name="stage_id">
      <input type="hidden" id="formMethod" value="POST">
      
      <div class="form-group">
        <label for="stageName">Stage Name <span style="color: #ef4444;">*</span></label>
        <input type="text" id="stageName" name="name" class="form-input" placeholder="e.g., Planning, In Progress, Completed" required>
      </div>
      
      <div class="form-group">
        <label for="stageDescription">Description</label>
        <textarea id="stageDescription" name="description" class="form-input" rows="3" placeholder="Optional description for this stage"></textarea>
      </div>
      
      <div class="form-group">
        <label for="stageColor">Stage Color <span style="color: #ef4444;">*</span></label>
        <div class="color-input-wrapper">
          <div class="color-preview" id="colorPreview" style="background-color: #6b7280;" onclick="document.getElementById('stageColor').click()"></div>
          <input type="color" id="stageColor" name="color" class="color-input" value="#6b7280" required>
          <input type="text" id="colorText" class="color-text" value="#6B7280" readonly>
        </div>
        <div class="color-presets">
          <div class="color-preset" style="background: #d3b5df;" onclick="setColor('#d3b5df')" title="Purple"></div>
          <div class="color-preset" style="background: #ebc58f;" onclick="setColor('#ebc58f')" title="Orange"></div>
          <div class="color-preset" style="background: #b9f3fc;" onclick="setColor('#b9f3fc')" title="Blue"></div>
          <div class="color-preset" style="background: #abd1a5;" onclick="setColor('#abd1a5')" title="Green"></div>
          <div class="color-preset" style="background: #fca5a5;" onclick="setColor('#fca5a5')" title="Red"></div>
          <div class="color-preset" style="background: #fde68a;" onclick="setColor('#fde68a')" title="Yellow"></div>
          <div class="color-preset" style="background: #c7d2fe;" onclick="setColor('#c7d2fe')" title="Indigo"></div>
          <div class="color-preset" style="background: #fed7d7;" onclick="setColor('#fed7d7')" title="Pink"></div>
        </div>
      </div>
      
      <div class="form-actions">
        <button type="button" onclick="closeStageModal()" class="btn-cancel">Cancel</button>
        <button type="submit" class="btn-create" id="submitBtn">Create Stage</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('breadcrumb')
<a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
<span class="hrp-bc-sep">›</span>
<a href="{{ route('projects.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Projects</a>
<span class="hrp-bc-sep">›</span>
<span class="hrp-bc-current">Stages Settings</span>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
  // Toast notification function
  function showToast(message, type = 'success') {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });

    Toast.fire({
      icon: type,
      title: message
    });
  }

  // Initialize Sortable for drag and drop
  const stagesList = document.getElementById('stagesList');
  if (stagesList) {
    const sortable = new Sortable(stagesList, {
      animation: 150,
      handle: '.drag-handle',
      ghostClass: 'sortable-ghost',
      dragClass: 'sortable-drag',
      onEnd: function(evt) {
        updateStageOrder();
      }
    });
  }

  // Update stage order numbers visually
  function updateOrderNumbers() {
    const items = document.querySelectorAll('.stage-item');
    items.forEach((item, index) => {
      const orderEl = item.querySelector('.stage-order');
      if (orderEl) {
        orderEl.textContent = index + 1;
      }
    });
  }

  // Save new order to server
  async function updateStageOrder() {
    const items = document.querySelectorAll('.stage-item');
    const stages = Array.from(items).map((item, index) => ({
      id: parseInt(item.dataset.id),
      order: index
    }));

    const updateUrl = '{{ route("project-stages.update-order") }}';
    console.log('Updating stage order:', stages);
    console.log('Update URL:', updateUrl);

    try {
      const response = await fetch(updateUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ stages })
      });

      console.log('Response status:', response.status);
      
      if (!response.ok) {
        const errorText = await response.text();
        console.error('Response error:', errorText);
        throw new Error(`HTTP ${response.status}: ${errorText}`);
      }

      const data = await response.json();
      console.log('Response data:', data);
      
      if (data.success) {
        updateOrderNumbers();
        // Show success notification
        showToast('Stage order updated successfully', 'success');
      } else {
        throw new Error(data.message || 'Failed to update order');
      }
    } catch (error) {
      console.error('Update order error:', error);
      showToast('Failed to update stage order', 'error');
      // Reload to restore correct order
      setTimeout(() => window.location.reload(), 2000);
    }
  }
</script>
<script>
  // Color picker functionality
  document.getElementById('stageColor').addEventListener('input', function(e) {
    const color = e.target.value;
    document.getElementById('colorPreview').style.backgroundColor = color;
    document.getElementById('colorText').value = color.toUpperCase();
  });

  function setColor(color) {
    document.getElementById('stageColor').value = color;
    document.getElementById('colorPreview').style.backgroundColor = color;
    document.getElementById('colorText').value = color.toUpperCase();
  }

  // Modal functions
  function openStageModal() {
    document.getElementById('modalTitle').textContent = 'Create New Stage';
    document.getElementById('submitBtn').textContent = 'Create Stage';
    document.getElementById('stageForm').reset();
    document.getElementById('stageId').value = '';
    document.getElementById('formMethod').value = 'POST';
    setColor('#6b7280');
    document.getElementById('stageModal').style.display = 'flex';
  }

  function closeStageModal() {
    document.getElementById('stageModal').style.display = 'none';
  }

  // Create/Update stage
  document.getElementById('stageForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const stageId = document.getElementById('stageId').value;
    const method = document.getElementById('formMethod').value;
    const url = stageId ? `{{ url('project-stages') }}/${stageId}` : '{{ route("project-stages.store") }}';
    
    const formData = {
      name: document.getElementById('stageName').value,
      description: document.getElementById('stageDescription').value,
      color: document.getElementById('stageColor').value,
      _token: '{{ csrf_token() }}'
    };
    
    if (method === 'PATCH') {
      formData._method = 'PATCH';
    }
    
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
      });
      
      const data = await response.json();
      
      if (data.success) {
        closeStageModal();
        showToast(data.message, 'success');
        setTimeout(() => window.location.reload(), 1500);
      } else {
        showToast(data.message || 'Something went wrong', 'error');
      }
    } catch (error) {
      showToast('Failed to save stage', 'error');
    }
  });

  // Edit stage
  async function editStage(id) {
    try {
      const response = await fetch(`{{ url('project-stages') }}/${id}`);
      const data = await response.json();
      
      if (data.success) {
        const stage = data.stage;
        document.getElementById('modalTitle').textContent = 'Edit Stage';
        document.getElementById('submitBtn').textContent = 'Update Stage';
        document.getElementById('stageId').value = stage.id;
        document.getElementById('formMethod').value = 'PATCH';
        document.getElementById('stageName').value = stage.name;
        document.getElementById('stageDescription').value = stage.description || '';
        setColor(stage.color);
        document.getElementById('stageModal').style.display = 'flex';
      }
    } catch (error) {
      showToast('Failed to load stage data', 'error');
    }
  }

  // Delete stage
  function deleteStage(id, name, projectCount) {
    if (projectCount > 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Cannot Delete',
        text: `This stage has ${projectCount} project(s). Please move or delete the projects first.`,
        confirmButtonColor: '#3b82f6'
      });
      return;
    }
    
    Swal.fire({
      title: `Delete "${name}"?`,
      text: "This action cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then(async (result) => {
      if (result.isConfirmed) {
        try {
          const response = await fetch(`{{ url('project-stages') }}/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          });
          
          const data = await response.json();
          
          if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1500);
          } else {
            showToast(data.message, 'error');
          }
        } catch (error) {
          showToast('Failed to delete stage', 'error');
        }
      }
    });
  }
</script>
@endpush
