@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
    <div class="hrp-card-body">
      <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <label class="hrp-label">Name</label>
        <input name="name" class="hrp-input" required>
        <label class="hrp-label">Email</label>
        <input name="email" type="email" class="hrp-input" required>
        <label class="hrp-label">Photo</label>
        <input name="photo" type="file" class="hrp-file">
        <div class="hrp-actions"><button class="hrp-btn hrp-btn-primary">Save</button></div>
      </form>
    </div>
  </div>
  <div class="hrp-breadcrumb"><div class="crumb"><a href="{{ route('dashboard') }}">Dashboard</a>  ›  <a href="{{ route('employees.index') }}">Employee List</a>  ›  Add</div></div>
@endsection
