@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-calendar"></i>
            <h1>
	            <span class="page-title">Membership Codes</span>
	            <small>
	            You can see membership codes from here
	            </small>
            </h1>
        </div>
    </div>
</div>
@endsection