@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Repurchase';
$data['sub'] = 'All items are shown here.';
$data['icon'] = 'fa fa-shopping-cart';
?>
@include('mlm.header.index', $data)
<div class="row clearfix">
    <div class="col-md-7">
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
                                        <div class="price">Price: {{ currency('PHP', $item->z_price) }}</div>
                                        <div class="price">Discount: {{ currency('PHP', $item->z_discount) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text" style="margin-bottom: 10px;">
                                <div class="price" style="font-weight: 700; font-size: 18px;">Total: {{ currency('PHP', $item->z_total) }}</div>
                            </div>
                            <div>
                                <table style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle;"><input value="1" class="form-control add-to-cart-quantity" item-id="{{ $item->item_id }}" type="number" min="1"></td>
                                            <td style="vertical-align: middle;"><button style="margin: 0;" class="btn add-to-cart-button" item-id="{{ $item->item_id }}">ADD TO CART</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <h1><i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right: 10px;"></i> Cart</h1>
        <div class="panel panel-default panel-block">
            <div class="repurchase-cart">
                <div class="loader"></div>
                {!! $cart !!}
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-primary">Checkout</button>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="/assets/mlm/js/repurchase.js"></script>
@endsection
@section("css")
<style type="text/css">
.repurchase
{
    padding: 15px;
}
.repurchase .holder
{
    margin-bottom: 15px;
}
.repurchase .holder:last-child
{
    margin-bottom: 0;
}
.repurchase .holder .img
{
    padding-bottom: 75%;
    position: relative;
    height: 0;
}
.repurchase .holder .img img
{
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    object-fit: cover;
    object-position: center;
}
.repurchase .holder .name
{
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 7.5px;
}
.repurchase .holder .price
{
    font-size: 16px;
}
.repurchase .holder .btn
{
    background-color: #5C3424;
    color: #fff;
    border: 0;
    border-radius: 0;
    padding: 7.5px 15px;
}
</style>
@endsection