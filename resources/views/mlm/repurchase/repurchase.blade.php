@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Repurchase';
$data['sub'] = 'All items are shown here.';
$data['icon'] = 'fa fa-shopping-cart';
?>
@include('mlm.header.index', $data)
<div class="panel panel-default panel-block">
    <div class="repurchase">
        @foreach($_item as $item)
        <div class="holder">
            <div class="row clearfix">
                <div class="col-md-8">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="img">
                                <img src="{{ $item->item_img ? $item->item_img : "/assets/front/img/default.jpg" }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="text">
                                <div class="name">{{ $item->item_name }}</div>
                                <div class="desc">{{ $item->item_price }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary">ADD TO CART</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@section("css")
<style type="text/css">
.repurchase
{
    padding: 15px;
}
.repurchase
{

}
</style>
@endsection
@section('js')
<script type="text/javascript">

</script>
@endsection
