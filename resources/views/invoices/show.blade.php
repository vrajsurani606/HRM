@extends('layouts.macos')
@section('page_title', 'Invoice')
@section('content')
<div class="max-w-5xl mx-auto">
  <h1 class="text-2xl font-semibold text-gray-800 mb-6">Invoice #{{ $id }}</h1>
  <div class="bg-white shadow rounded p-6">Invoice details for #{{ $id }}.</div>
</div>
@endsection
