@extends('layouts.macos')
@section('page_title', 'Event Gallery')

@push('styles')
<link rel="stylesheet" href="{{ asset('new_theme/css/events.css') }}">
<style>
  /* Full-page gallery */
  .gallery-page{ padding:0 24px 20px; height:calc(100vh - 120px); overflow:auto; }
  /* Toolbar flush with header edges */
  .gallery-toolbar{ margin: 0 -24px 0; padding: 12px 24px; }
  .jv-filter.gallery-toolbar{ padding-left: 24px; padding-right: 24px; margin-bottom: 10px;}
  .filter-group{ display:flex; gap:6px; flex-wrap:wrap; }
  .pill-btn.active{ background:#111; color:#fff; border-color:#111; }
  .back-btn{ display:inline-flex; align-items:center; gap:6px; }
  .bulk-group{ display:flex; align-items:center; gap:10px; }
  .select-all{ display:flex; align-items:center; gap:8px; font-weight:600; }
  /* Make select-all look like a JV pill */
  .select-all.filter-pill{ display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px; border:1.5px solid #d1d5db; background:#fff; color:#111; line-height:1; height:36px; transition:border-color .15s ease, box-shadow .15s ease; }
  .select-all.filter-pill:hover{ border-color:#9ca3af; }
  .select-all.filter-pill:focus-within{ border-color:#111; box-shadow:0 0 0 3px rgba(17,17,17,.1); }
  .select-all.filter-pill input{ margin:0; position:relative; top:0; }
  .bulk-actions{ display:flex; gap:8px; }
  .bulk-btn{ padding:8px 12px; border-radius:10px; border:1px solid #e5e7eb; background:#fff; color:#111; font-weight:600; cursor:pointer; }
  .bulk-btn:disabled{ opacity:.5; cursor:not-allowed; }
  .bulk-btn.delete{ border-color:#ef4444; color:#ef4444; }
  .bulk-btn.delete:hover{ background:#ef4444; color:#fff; }
  .bulk-btn.download{ border-color:#111; }
  .bulk-btn.download:hover{ background:#111; color:#fff; }
  .media-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:16px; }
  .media-item{ position:relative; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.08); background:#f3f4f6;  }
  .media-thumb{ width:100%; height:160px; object-fit:cover; display:block; }
  .media-overlay{ position:absolute; inset:0; display:flex; align-items:center; justify-content:center; padding:0; background:rgba(0,0,0,.45); opacity:0; transition:opacity .2s ease; }
  .media-item:hover .media-overlay{ opacity:1; }
  .select-check{ position:absolute; top:8px; left:8px; width:20px; height:20px; display:none; }
  .media-item:hover .select-check{ display:block; }
  .media-item.selected .select-check{ display:block; }
  .media-item.selected{ outline:3px solid #111; }
  .ovl-actions{ display:flex; gap:10px; }
  .ovl-btn{ width:40px; height:40px; border-radius:10px; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; color:#111; background:#fff; cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,.12); transition:background .15s ease, color .15s ease, border-color .15s ease; }
  .ovl-btn:hover{ background:#111; color:#fff; border-color:#111; }
  .ovl-btn img, .ovl-btn svg{ width:18px; height:18px; }
  .ovl-btn svg path{ stroke: currentColor; fill: currentColor; }
  .ovl-btn:hover img{ filter: invert(1) brightness(1.2); }
  /* Hide header menu toggle on Events page only */
  .hrp-menu-toggle{ display:none !important; }
  @media (max-width: 768px){
    .hrp-menu-toggle{ display:inline-flex !important; }
  }
  /* Keep header title area aligned */
  .hrp-header-left{ gap: 0; }
  /* Scoped styles for Create Event modal */
  .event-modal .modal-title{ font-size: 18px; font-weight: 800; }
  .event-modal .hrp-label{ font-size: 14px; font-weight: 700; color:#374151; margin-bottom:6px; }
  .event-modal .Rectangle-29{ font-size:14px; padding:10px 12px; height:auto; border-radius:12px; }
  .event-modal textarea.Rectangle-29{ min-height:100px; }
  .event-modal .hrp-btn{ padding:10px 18px; border-radius:10px; font-size:14px; font-weight:700; }
</style>
@endpush

@section('content')
<div class="gallery-page">
  <!-- Toolbar (JV Datatable Filter) -->
  <div class="jv-filter gallery-toolbar">
    <div class="filter-group" role="tablist">
      <a href="{{ route('events.index') }}" class="pill-btn back-btn" title="Back to Events">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back
      </a>
      <button class="pill-btn filter-toggle active" data-filter="all" type="button">ALL</button>
      <button class="pill-btn filter-toggle" data-filter="image" type="button">PHOTOS</button>
      <button class="pill-btn filter-toggle" data-filter="video" type="button">VIDEOS</button>
    </div>
    <div class="filter-right">
      <label class="select-all filter-pill"><input type="checkbox" id="selectAll"> Select all</label>
      <div id="bulkActionsWrap" class="bulk-actions" style="display:none;">
        @can('Events Management.download event image')
        <button id="bulkDownload" class="bulk-btn download" disabled title="Download selected" type="button">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 17v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
        @endcan
        @can('Events Management.delete event image')
        <button id="bulkDelete" class="bulk-btn delete" disabled title="Delete selected" type="button">
          <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" width="16" height="16">
        </button>
        @endcan
      </div>
    </div>
  </div>

  <div class="media-grid" id="mediaGrid">
    @foreach($event->images as $image)
      @php $url = asset('storage/' . $image->image_path); @endphp
      <div class="media-item" data-type="image" data-image-id="{{ $image->id }}">
        <input type="checkbox" class="select-check" data-kind="image" value="{{ $image->id }}">
        <img class="media-thumb" src="{{ $url }}" alt="Image">
        <div class="media-overlay">
          <div class="ovl-actions">
            @can('Events Management.view event image')
              <a class="ovl-btn" href="{{ route('events.images.open', $image) }}" target="_blank" title="Open">
                <img src="{{ asset('action_icon/show.svg') }}" alt="Open">
              </a>
            @endcan
            @can('Events Management.download event image')
              <a class="ovl-btn" href="{{ route('events.images.download', $image) }}" title="Download">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 17v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
              </a>
            @endcan
            @can('Events Management.delete event image')
              <button class="ovl-btn" onclick="deleteImage({{ $image->id }})" title="Delete">
                <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              </button>
            @endcan
          </div>
        </div>
      </div>
    @endforeach

    @foreach($event->videos as $video)
      @php $url = asset('storage/' . $video->video_path); @endphp
      <div class="media-item" data-type="video" data-video-id="{{ $video->id }}">
        <input type="checkbox" class="select-check" data-kind="video" value="{{ $video->id }}">
        <video class="media-thumb" controls preload="metadata" playsinline>
          <source src="{{ route('events.videos.open', $video) }}" type="{{ $video->mime ?? 'video/mp4' }}">
        </video>
        <div class="media-overlay">
          <div class="ovl-actions">
            @can('Events Management.view event image')
              <a class="ovl-btn" href="{{ route('events.videos.open', $video) }}" target="_blank" title="Open">
                <img src="{{ asset('action_icon/view.svg') }}" alt="Open">
              </a>
            @endcan
            @can('Events Management.download event image')
              <a class="ovl-btn" href="{{ route('events.videos.download', $video) }}" title="Download">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 17v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
              </a>
            @endcan
            @can('Events Management.delete event image')
              <button class="ovl-btn" onclick="deleteVideo({{ $video->id }})" title="Delete">
                <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              </button>
            @endcan
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@push('scripts')
<script>
const CSRF_TOKEN = '{{ csrf_token() }}';

// Filtering
document.querySelectorAll('.filter-toggle').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-toggle').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const type = btn.getAttribute('data-filter');
    document.querySelectorAll('#mediaGrid .media-item').forEach(item => {
      item.style.display = (type === 'all' || item.dataset.type === type) ? '' : 'none';
    });
    // Update select all for current view
    document.getElementById('selectAll').checked = false;
    updateSelectionState();
  });
});

// Initial filter via URL param (?filter=image|video)
document.addEventListener('DOMContentLoaded', function(){
  const params = new URLSearchParams(window.location.search);
  const f = (params.get('filter') || '').toLowerCase();
  if(f === 'image' || f === 'video'){
    const btn = document.querySelector(`.filter-toggle[data-filter="${f}"]`);
    if(btn){ btn.click(); }
  }
});

// Selection mode: show checkboxes when any selection happens (via select all)
const grid = document.getElementById('mediaGrid');
const selectAll = document.getElementById('selectAll');
const bulkDelete = document.getElementById('bulkDelete');
const bulkDownload = document.getElementById('bulkDownload');
const bulkActionsWrap = document.getElementById('bulkActionsWrap');

function visibleItems(){
  return Array.from(grid.querySelectorAll('.media-item')).filter(i => i.style.display !== 'none');
}

function updateSelectionState(){
  const vis = visibleItems();
  const checked = grid.querySelectorAll('.select-check:checked').length;
  const visibleChecks = vis.map(i => i.querySelector('.select-check')).filter(Boolean);
  const visibleChecked = visibleChecks.filter(cb => cb.checked).length;
  // Sync select-all for current view
  selectAll.checked = visibleChecks.length > 0 && visibleChecked === visibleChecks.length;
  const multi = checked >= 2;
  bulkActionsWrap.style.display = multi ? 'flex' : 'none';
  bulkDelete.disabled = !multi;
  bulkDownload.disabled = !multi;
}

// Select all toggles only visible items
selectAll.addEventListener('change', () => {
  const vis = visibleItems();
  vis.forEach(item => {
    const cb = item.querySelector('.select-check');
    if(cb){ cb.checked = selectAll.checked; item.classList.toggle('selected', cb.checked); }
  });
  updateSelectionState();
});

// Individual selection
grid.addEventListener('change', (e) => {
  if(!e.target.classList.contains('select-check')) return;
  const item = e.target.closest('.media-item');
  item.classList.toggle('selected', e.target.checked);
  updateSelectionState();
});

// Clicking on tile toggles selection when in select-mode
grid.addEventListener('click', (e) => {
  const item = e.target.closest('.media-item');
  if(!item) return;
  // Ignore clicks on overlay buttons
  if(e.target.closest('.ovl-actions')) return;
  // Clicking tile toggles selection directly
  const cb = item.querySelector('.select-check');
  if(cb){ cb.checked = !cb.checked; item.classList.toggle('selected', cb.checked); updateSelectionState(); }
});

function getSelected(){
  const ids = { images: [], videos: [] };
  grid.querySelectorAll('.select-check:checked').forEach(cb => {
    const kind = cb.dataset.kind;
    if(kind === 'image') ids.images.push(cb.value);
    else if(kind === 'video') ids.videos.push(cb.value);
  });
  return ids;
}

// Bulk delete
bulkDelete.addEventListener('click', () => {
  const sel = getSelected();
  if(sel.images.length + sel.videos.length === 0) return;
  Swal.fire({
    title: 'Delete selected media?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete'
  }).then(async (result) => {
    if(!result.isConfirmed) return;
    try {
      // Delete images
      for(const id of sel.images){
        await fetch(`{{ url('event-images') }}/${id}`, { method:'DELETE', headers:{ 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept':'application/json' } });
        const node = grid.querySelector(`[data-image-id="${id}"]`); if(node) node.remove();
      }
      // Delete videos
      for(const id of sel.videos){
        await fetch(`{{ url('event-videos') }}/${id}`, { method:'DELETE', headers:{ 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept':'application/json' } });
        const node = grid.querySelector(`[data-video-id="${id}"]`); if(node) node.remove();
      }
      toastr.success('Selected media deleted');
      selectAll.checked = false;
      updateSelectionState();
    } catch(e){ toastr.error('Failed to delete some items'); }
  });
});

// Bulk download (open each in a new tab; note browsers may block many tabs)
bulkDownload.addEventListener('click', () => {
  const sel = getSelected();
  if(sel.images.length + sel.videos.length === 0) return;
  const urls = [
    ...sel.images.map(id => `{{ url('event-images') }}/${id}/download`),
    ...sel.videos.map(id => `{{ url('event-videos') }}/${id}/download`)
  ];
  let delay = 0;
  urls.forEach(u => { setTimeout(() => { const a = document.createElement('a'); a.href = u; a.target = '_blank'; a.rel = 'noopener'; document.body.appendChild(a); a.click(); a.remove(); }, delay); delay += 200; });
});

function deleteImage(imageId) {
    Swal.fire({
        title: 'Delete this image?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch(`{{ url('event-images') }}/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const node = document.querySelector(`[data-image-id="${imageId}"]`);
                if (node) node.remove();
                toastr.success(data.message || 'Deleted');
            } else {
                toastr.error(data.message || 'Failed to delete image');
            }
        })
        .catch(() => toastr.error('An error occurred'));
    });
}

function deleteVideo(videoId) {
    Swal.fire({
        title: 'Delete this video?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch(`{{ url('event-videos') }}/${videoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const node = document.querySelector(`[data-video-id="${videoId}"]`);
                if (node) node.remove();
                toastr.success(data.message || 'Deleted');
            } else {
                toastr.error(data.message || 'Failed to delete video');
            }
        })
        .catch(() => toastr.error('An error occurred'));
    });
}
</script>
@endpush
@endsection