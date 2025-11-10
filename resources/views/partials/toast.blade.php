<div x-data="{ show: false, msg: '', type: 'success' }" x-init="
  $nextTick(() => {
    let t = '{{ session('success') ?? session('status') ?? session('error') ?? session('info') ?? '' }}'.trim();
    let ty = '{{ session()->has('error') ? 'error' : (session()->has('info') ? 'info' : 'success') }}';
    if(t){ msg = t; type = ty; show = true; setTimeout(() => show = false, 3000); }
  })
" class="fixed z-50 top-4 right-4">
  <template x-if="show">
    <div :class="{
        'bg-green-600 text-white': type === 'success',
        'bg-red-600 text-white': type === 'error',
        'bg-blue-600 text-white': type === 'info'
      }" class="shadow-lg rounded-md px-4 py-3 flex items-center gap-2 min-w-[240px]">
      <span x-text="msg" class="text-sm"></span>
      <button @click="show=false" class="ml-auto/ text-white/">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M6.225 4.811a1 1 0 0 0-1.414 1.414L10.586 12l-5.775 5.775a1 1 0 1 0 1.414 1.414L12 13.414l5.775 5.775a1 1 0 1 0 1.414-1.414L13.414 12l5.775-5.775a1 1 0 0 0-1.414-1.414L12 10.586 6.225 4.811z"/></svg>
      </button>
    </div>
  </template>
</div>
