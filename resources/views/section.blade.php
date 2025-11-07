@extends('layouts.macos')

@section('content')
<section class="content" style="padding: 40px;">
  <div class="box box-solid" style="max-width:800px;margin:0 auto;background: rgba(255,255,255,0.9); border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
    <div class="box-header with-border" style="border-radius: 12px 12px 0 0; background: #f8f8f8;">
      <h3 class="box-title" style="font-weight:700; color:#111; text-transform: uppercase;">{{ str_replace('-', ' ', $name) }}</h3>
    </div>
    <div class="box-body" style="padding: 20px;">
      <p style="font-weight:600; color:#333;">This is a placeholder page for the <strong>{{ $name }}</strong> section. Tell me which content or Laravel pages should load here and I will wire them up.</p>
      <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
  </div>
</section>
@endsection
