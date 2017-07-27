@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
    @if(isset($links))
    @foreach($links as $key => $value)
    
    <div class="col-md-12">
        <span ><a href="{{$value['link']}}" target="_blank">{{$value['label']}}</a></span>
        <hr>
    </div>
    @endforeach
    @endif
    </div>
</div>    
@endsection
@section('script')

@endsection