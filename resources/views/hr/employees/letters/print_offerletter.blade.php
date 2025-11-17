@extends('layouts.print')

@section('content')
<div class="print-container">
    @include('hr.employees.letters.templates.offer', ['employee' => $employee, 'letter' => $letter])
</div>
@endsection