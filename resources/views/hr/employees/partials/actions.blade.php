<div class="flex gap-2">
  <a href="{{ route('employees.show', $row) }}" class="px-3 py-1 rounded bg-green-600 text-white text-xs">View</a>
  @can('employees.edit')
  <a href="{{ route('employees.edit', $row) }}" class="px-3 py-1 rounded bg-blue-600 text-white text-xs">Edit</a>
  @endcan
  @can('employees.delete')
  <form method="POST" action="{{ route('employees.destroy', $row) }}">
    @csrf @method('DELETE')
    <button class="px-3 py-1 rounded bg-red-600 text-white text-xs js-confirm-delete">Delete</button>
  </form>
  @endcan
</div>
