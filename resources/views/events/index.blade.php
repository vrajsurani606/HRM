@extends('layouts.macos')
@section('page_title', 'Events Management')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
<link rel="stylesheet" href="{{ asset('new_theme/css/events.css') }}">
<style>
  /* Hide header menu toggle on Events page only */
  .hrp-menu-toggle{ display:none !important; }
  @media (max-width: 768px){
    .hrp-menu-toggle{ display:inline-flex !important; }
  }
  /* Keep header title area aligned */
  .hrp-header-left{ gap: 0; }
  /* Scoped styles for Create/Edit Event modals */
  .event-modal .modal-title{ font-size: 18px; font-weight: 800; }
  .event-modal .hrp-label{ font-size: 14px; font-weight: 700; color:#374151; margin-bottom:6px; }
  .event-modal .form-control{ width:100%; font-size:14px; padding:10px 12px; height:auto; border-radius:12px; border:1px solid #e5e7eb; background:#fff; color:#111; }
  .event-modal .form-control:focus{ border-color:#111; box-shadow:0 0 0 3px rgba(17,17,17,.08); outline:0; }
  .event-modal .form-textarea{ min-height:100px; resize:vertical; }
  .event-modal .form-file{ padding:8px 12px; }
  .event-modal .hrp-btn{ padding:10px 18px; border-radius:10px; font-size:14px; font-weight:700; }
  /* Card footer pills */
  .event-footer{ display:flex; align-items:center; justify-content:space-between; padding:10px 12px; border-top:1px solid #eef0f2; }
  .count-pills{ display:flex; gap:8px; }
  .count-pill{ display:inline-flex; align-items:center; gap:6px; border:1px solid #e5e7eb; border-radius:999px; padding:4px 10px; font-size:12px; color:#111; background:#fff; }
  .count-pill img{ width:14px; height:14px; }
  .event-actions{ display:flex; align-items:center; justify-content:center; gap:10px; padding:8px 12px; }
 </style>
@endpush

@section('content')
<div class="events-page">
  <!-- Header row: search + Add -->
  <div class="events-header">
    <div class="events-search-container">
      <input type="text" id="eventSearch" class="events-search" placeholder="Type to search...">
    </div>
    @can('Events Management.create event')
      <button class="add-event-btn" data-toggle="modal" data-target="#addEventModal">
        <img src="{{ asset('action_icon/pluse.svg') }}" alt="Add" class="btn-icon"> Add
      </button>
    @endcan
  </div>

  <!-- Grid -->
  <div class="events-grid" id="eventsGrid">
    @forelse($events as $event)
      @php
        $coverPath = $event->coverImage?->image_path ?? optional($event->images->first())->image_path;
        $cover = $coverPath ? storage_asset(''. $coverPath) : null;
        $imgCount = $event->images->count();
        $vidCount = $event->videos->count();
        $initial = strtoupper(mb_substr($event->name ?? '', 0, 1));
      @endphp
      <div class="event-card" data-event-id="{{ $event->id }}" data-has-cover="{{ $cover ? '1' : '0' }}">
        @if($cover)
          <img src="{{ $cover }}" alt="{{ $event->name }}" class="event-image">
        @else
          <div class="event-image" style="display:flex;align-items:center;justify-content:center;background:#f3f4f6;color:#9ca3af;font-weight:800;font-size:48px;">{{ $initial }}</div>
        @endif
        <div class="event-content">
          <div class="event-title" title="{{ $event->name }}">{{ \Illuminate\Support\Str::limit($event->name, 24) }}</div>
          <div class="event-date">{{ $event->created_at?->format('M d, Y') }}</div>
        </div>
        <div class="event-actions">
          @can('Events Management.upload event image')
          <button class="action-btn js-upload" data-id="{{ $event->id }}" title="Upload Images">
            <!-- upload icon -->
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 16V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M8 8L12 4L16 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20 16v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>
          @endcan
          @can('Events Management.edit event')
          <button class="action-btn js-edit" data-id="{{ $event->id }}" data-name="{{ $event->name }}" data-description="{{ $event->description }}" data-cover="{{ $cover }}" title="Edit">
            <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
          </button>
          @endcan
          @can('Events Management.view event')
          <a href="{{ route('events.show', $event) }}" class="action-btn view" title="View">
            <img src="{{ asset('action_icon/view.svg') }}" alt="View">
          </a>
          @endcan
          @can('Events Management.delete event')
          <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn js-confirm-delete" title="Delete">
              <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
            </button>
          </form>
          @endcan
        </div>
        <div class="event-footer">
          <div class="count-pills">
            <a class="count-pill" href="{{ route('events.show', $event) }}?filter=image" title="View photos">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="2"/><circle cx="16.5" cy="10.5" r="2.5" stroke="currentColor" stroke-width="2"/><path d="M3 15l4.5-4.5L14 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              {{ $imgCount }}
            </a>
            <a class="count-pill" href="{{ route('events.show', $event) }}?filter=video" title="View videos">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M10 9l5 3-5 3V9z" fill="currentColor"/></svg>
              {{ $vidCount }}
            </a>
          </div>
          @can('Events Management.view event')
            <a href="{{ route('events.show', $event) }}" class="pill-btn" style="padding:6px 10px; font-weight:700;">Open</a>
          @endcan
        </div>
      </div>
    @empty
      <div class="empty-state">No events found. Click Add to create your first event.</div>
    @endforelse
  </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered event-modal" role="document">
    <div class="modal-content" style="border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
      <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header" style="border-bottom:1px solid #e5e7eb; padding:16px 20px;">
          <h5 class="modal-title" id="addEventLabel" style="font-weight:800; color:#111;">Create Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity:.6;">
            <span aria-hidden="true" style="font-size:28px;">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding:20px;">
          <div class="form-group" style="margin-bottom:16px;">
            <label class="hrp-label">Event Name <span style="color:#ef4444;">*</span></label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Diwali Celebration">
            @error('name')
              <div style="color:#ef4444; font-size:13px; margin-top:6px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group" style="margin-bottom:16px;">
            <label class="hrp-label">Cover Image</label>
            <input type="file" name="cover" id="create_cover" accept="image/*" class="form-control form-file">
            <div style="margin-top:10px;">
              <img id="create_cover_preview" src="" alt="Cover preview" style="max-width:100%; max-height:180px; border-radius:12px; display:none;">
            </div>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label class="hrp-label">Description</label>
            <textarea name="description" class="form-control form-textarea" placeholder="Enter description">{{ old('description') }}</textarea>
            @error('description')
              <div style="color:#ef4444; font-size:13px; margin-top:6px;">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer" style="border-top:1px solid #e5e7eb; padding:14px 20px;">
          <button type="button" class="hrp-btn" data-dismiss="modal" style="background:#f3f4f6; color:#111;">Cancel</button>
          <button type="submit" class="hrp-btn" style="background:#111; color:#fff;">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered event-modal" role="document">
    <div class="modal-content" style="border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
      <form id="editEventForm" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header" style="border-bottom:1px solid #e5e7eb; padding:16px 20px;">
          <h5 class="modal-title" id="editEventLabel" style="font-weight:800; color:#111;">Edit Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity:.6;">
            <span aria-hidden="true" style="font-size:28px;">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding:20px;">
          <div class="form-group" style="margin-bottom:16px;">
            <label class="hrp-label">Event Name <span style="color:#ef4444;">*</span></label>
            <input type="text" id="edit_name" name="name" class="form-control" required>
          </div>
          <div class="form-group" style="margin-bottom:16px;">
            <label class="hrp-label">Cover Image</label>
            <input type="file" name="cover" id="edit_cover" accept="image/*" class="form-control form-file">
            <div style="margin-top:10px;">
              <img id="edit_cover_preview" src="" alt="Cover preview" style="max-width:100%; max-height:180px; border-radius:12px; display:none;">
            </div>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label class="hrp-label">Description</label>
            <textarea id="edit_description" name="description" class="form-control form-textarea"></textarea>
          </div>
        </div>
        <div class="modal-footer" style="border-top:1px solid #e5e7eb; padding:14px 20px;">
          <button type="button" class="hrp-btn" data-dismiss="modal" style="background:#f3f4f6; color:#111;">Cancel</button>
          <button type="submit" class="hrp-btn" style="background:#111; color:#fff;">Update</button>
        </div>
      </form>
    </div>
  </div>
  </div>

<!-- Upload Images/Media Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius:16px;">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadLabel">Upload Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="#" class="dropzone" id="eventDropzoneIndex">
          @csrf
          <div class="dz-message"><strong>Drop files here or click to upload images.</strong></div>
        </form>
        <div id="uploadPreviewStrip" class="upload-strip"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="hrp-btn" data-dismiss="modal" style="background:#111;color:#fff;">Done</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
  // Ensure modals render above any overflow containers
  $(function(){
    $('#addEventModal').appendTo('body');
    $('#editEventModal').appendTo('body');
    $('#uploadModal').appendTo('body');
  });

  // Simple client-side search filter
  document.getElementById('eventSearch').addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('.event-card').forEach(card => {
      const name = card.querySelector('.event-title').textContent.toLowerCase();
      card.style.display = name.includes(q) ? '' : 'none';
    });
  });

  // Upload modal logic
  let currentEventId = null;
  const baseUploadUrl = "{{ url('events') }}";
  const baseEventsUrl = "{{ url('events') }}";
  Dropzone.autoDiscover = false;
  const dz = new Dropzone('#eventDropzoneIndex', {
    url: '#',
    paramName: 'files',
    maxFilesize: 50,
    acceptedFiles: 'image/*,video/*',
    parallelUploads: 5,
    uploadMultiple: true,
    addRemoveLinks: true,
    dictRemoveFile: '×',
    init: function(){
      this.on('processing', function(){
        if(!currentEventId){ this.cancelUpload(); return; }
        this.options.url = `${baseUploadUrl}/${currentEventId}/media`;
      });
      this.on('success', function(file, resp){
        if(resp && resp.success){
          toastr.success(resp.message || 'Uploaded');
          const firstImage = (resp.images||[])[0];
          if(firstImage){
            const cardWrap = document.querySelector(`.event-card[data-event-id="${currentEventId}"]`);
            const cardImg = cardWrap && cardWrap.querySelector('.event-image');
            const hasCover = cardWrap && cardWrap.getAttribute('data-has-cover') === '1';
            if(cardImg && !hasCover){
              cardImg.src = firstImage.url;
              cardWrap.setAttribute('data-has-cover','1');
            }
          }
        } else {
          toastr.error('Upload failed');
        }
        this.removeFile(file);
      });
      this.on('queuecomplete', function(){
        setTimeout(function(){ $('#uploadModal').modal('hide'); }, 250);
        currentEventId = null;
        dz.removeAllFiles(true);
      });
      this.on('error', function(file, err){
        const msg = (err && err.message) ? err.message : 'Upload failed';
        toastr.error(msg);
        this.removeFile(file);
      });
    }
  });

  document.addEventListener('click', function(e){
    const btn = e.target.closest('.js-upload');
    if(!btn) return;
    currentEventId = btn.getAttribute('data-id');
    // reset previews from previous session
    dz.removeAllFiles(true);
    $('#uploadModal').modal('show');
  });

  // Edit modal logic
  document.addEventListener('click', function(e){
    const btn = e.target.closest('.js-edit');
    if(!btn) return;
    const id = btn.getAttribute('data-id');
    const name = btn.getAttribute('data-name') || '';
    const description = btn.getAttribute('data-description') || '';
    const cover = btn.getAttribute('data-cover') || '';
    const form = document.getElementById('editEventForm');
    form.action = `${baseEventsUrl}/${id}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    const editPrev = document.getElementById('edit_cover_preview');
    if(cover){ editPrev.src = cover; editPrev.style.display = 'block'; } else { editPrev.src = ''; editPrev.style.display = 'none'; }
    $('#editEventModal').modal('show');
  });

  // Cover preview handlers
  function bindCoverPreview(inputId, imgId){
    const input = document.getElementById(inputId);
    const img = document.getElementById(imgId);
    if(!input || !img) return;
    input.addEventListener('change', function(){
      const file = this.files && this.files[0];
      if(!file){ img.src=''; img.style.display='none'; return; }
      const reader = new FileReader();
      reader.onload = e => { img.src = e.target.result; img.style.display = 'block'; };
      reader.readAsDataURL(file);
    });
  }
  bindCoverPreview('create_cover', 'create_cover_preview');
  bindCoverPreview('edit_cover', 'edit_cover_preview');
</script>
@endpush
@endsection
