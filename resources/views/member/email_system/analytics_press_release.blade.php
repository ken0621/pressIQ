@extends('member.layout')
@section('content')
@foreach($array as $array)
{{$array->stats->today}}
@endforeach
@endsection

