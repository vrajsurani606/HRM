@extends('layouts.macos')
@section('page_title', 'Add Quotation')
@section('content')
  <div class="hrp-card">
    <div class="hrp-card-header flex items-center justify-between gap-4">
      <h2 class="hrp-card-title">Add Quotation</h2>
    </div>
    <div class="hrp-card-body">
      <div class="bg-white rounded p-6">Form for creating quotation.</div>
    </div>
  </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('quotations.index') }}" class="hrp-link">Quotation Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add Quotation</span>
@endsection
