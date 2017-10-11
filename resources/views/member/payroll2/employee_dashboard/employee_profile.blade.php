@extends('member.payroll2.employee_dashboard.employee_layout')
@section('content')
<div class="page-title">
    <h3>{{ $page }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">{{ $page }}</li>
        </ol>
    </div>
</div>

@endsection