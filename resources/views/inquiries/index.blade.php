@extends('layouts.macos')
@section('page_title', 'Inquiries')
@section('content')
  <div class="hrp-card">
    <div class="hrp-card-header flex items-center justify-between gap-4">
      <h2 class="hrp-card-title">Inquiries</h2>
    </div>
    <div class="hrp-card-body">
      <div class="hrp-table-surface">
        <div class="bg-white rounded p-6">List of inquiries goes here.</div>
      </div>
    </div>
  </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Inquiries</span>
@endsection
