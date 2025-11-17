@extends('layouts.print')

@section('content')
<div class="print-container">
    @include('hr.employees.letters.templates.confidentiality', ['employee' => $employee, 'letter' => $letter])
</div>
@endsection