@extends('member.layout')
@section('content')

<form class="global-submit" action="/member/report/query-submit">
	<div class="panel panel-default panel-block panel-title-block">
	    <div class="panel-body form-horizontal">
	    	<div class="form-group">
	    	</div>
	    	<div class="form-group text-center">
	    		<button class="btn btn-primary" type="submit">Submit</button>
	    	</div>
	    </div>
	</div>
</form>
@endsection