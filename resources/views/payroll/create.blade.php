@extends('layouts.macos')

@section('page_title', 'Create Payroll Entry')

@section('content')
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Payroll</h1>
  <div class="bg-white shadow rounded p-6">
    <form>
      <div class="grid grid-cols-1 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Employee</label>
          <input type="text" class="mt-1 block w-full border-gray-300 rounded" placeholder="Employee name">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Month</label>
          <input type="month" class="mt-1 block w-full border-gray-300 rounded">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Amount</label>
          <input type="number" class="mt-1 block w-full border-gray-300 rounded" placeholder="0.00">
        </div>
      </div>
      <div class="mt-6">
        <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
      </div>
    </form>
  </div>
</div>
@endsection
