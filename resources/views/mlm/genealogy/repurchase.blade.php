@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Repurchase Genealogy';
$data['sub'] = '';
$data['icon'] = 'fa fa-link';
?>
@include('mlm.header.index', $data)
<style type="text/css">

</style>
@foreach($repurchase_slot as $key => $value)
<a class="btn btn-primary" href="/mlm/genealogy/repurchase?slot_repurchase={{$value->repurchase_slot_id}}">View Repurchase Slot: #{{$value->repurchase_slot_id}}</a>
@endforeach
<div id="loadingMessage" class="col-md-12 hide"><center>Loading ...</center></div>
<iframe src="" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" id="foo"></iframe>

@endsection
@section('js')
<script type="text/javascript">
$('#foo').attr('width', screen.width);
$('#foo').attr('height', screen.height);
$('#foo').css('width', screen.width);
$('#foo').css('height', screen.height);
$(document).ready(function() {
	@if($slot_repurchase != null)
	var src1 = '/mlm/slot/genealogy?id={{$slot_repurchase}}&mode=repurchase';
	$("#foo").attr("src", src1);
	@endif
 });
$('#foo').ready(function () {
    $('#loadingMessage').css('display', 'block');
});
$('#foo').load(function () {
    $('#loadingMessage').css('display', 'none');
});</script>
@endsection