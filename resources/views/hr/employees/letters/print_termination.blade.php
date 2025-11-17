@extends('layouts.print')

@section('content')
<div class="print-container">
    @include('hr.employees.letters.templates.termination', ['employee' => $employee, 'letter' => $letter])
</div>
@endsection