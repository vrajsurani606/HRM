@extends('layouts.print')

@section('content')
<div class="print-container">
    @include('hr.employees.letters.templates.agreement', ['employee' => $employee, 'letter' => $letter])
</div>
@endsection