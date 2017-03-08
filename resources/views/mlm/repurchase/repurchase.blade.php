

@extends('mlm.layout')
@section('content')
<style type="text/css">
    .img-50-50
    {
            width: 50px;
            height: 50px;
            object-fit: contain;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                
                <h1>
                <i class="icon-star"></i>
                    <span class="page-title">Repurchase</span>
                    <hr>
                    <small>
                        This tab is use for purchasing item.
                    </small>
                </h1>
                
            </div>
        </div>
    </div>
        <div class="cart-repo">{!! $cart !!}</div>
        <div class="col-md-12">
            <div class="panel panel-default panel-block">
                <div class="list-group">
                    <div class="list-group-item" id="responsive-bordered-table">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <th></th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Membership <br>Discount</th>
                                    <th>Price After <br>Discount</th>
                                    <th>Membership Points</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </thead>
                                    @if(isset($items))
                                        @if(count($items) >= 1)
                                            @foreach($items as $key => $value)
                                                <tr>
                                                    <td><img src="{{$value->item_img}}" class="img-50-50"></img></td>
                                                    <td>
                                                        <div class="col-md-12">
                                                            {{$value->item_name}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <small>
                                                            Stock:
                                                            <span style="color: gray;">
                                                                @if($value->type_category =='non-inventory')
                                                                    Infinite 
                                                                @else
                                                                    @if(isset($item_w[$value->item_id]))
                                                                    {{$item_w[$value->item_id]->product_warehouse_stocks}}
                                                                    @else
                                                                    0
                                                                    @endif
                                                                @endif
                                                            </span>
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{$value->item_price}}
                                                    </td>
                                                    <td>
                                                    <?PHP $discount = 0; ?>
                                                    @if(isset($item_discount[$value->item_id]))
                                                        @if($item_discount[$value->item_id] != null)
                                                            @if($item_discount_percentage[$value->item_id] == 0)
                                                                <div class="col-md-12">
                                                                    {{$discount = $item_discount[$value->item_id]}}
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <small>
                                                                        <span style="color: gray">
                                                                        ({{($item_discount[$value->item_id]/$value->item_price)*100}}%)
                                                                        </span>
                                                                    </small>
                                                                </div>
                                                            @else
                                                                <div class="col-md-12">
                                                                    {{($item_discount[$value->item_id]/100)*$value->item_price}}
                                                                    <?php $discount = ($item_discount[$value->item_id]/100)*$value->item_price; ?>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <small>
                                                                        <span style="color: gray">
                                                                        ({{$item_discount[$value->item_id]}}%)
                                                                        </span>
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        @else

                                                        <div class="col-md-12">
                                                            0
                                                            <small>
                                                            <span style="color: gray">
                                                                No Discount
                                                            </span>
                                                        </small>
                                                        </div>
                                                        @endif
                                                    @else
                                                        0
                                                        <small>
                                                            <span style="color: gray">
                                                                No Discount
                                                            </span>
                                                        </small>
                                                    @endif  
                                                    </td>
                                                    <td>
                                                    	{{$value->item_price - $discount}}
                                                    </td>
                                                    <td>
                                                        @foreach($active as $key2 => $value2)
                                                            @if($value->$value2 != 0)
                                                            <div class="col-md-12">
                                                            {{$value->$value2}}
                                                                <small>
                                                                        <span style="color: gray">
                                                                        {{$active_label[$key2]}}
                                                                        </span>
                                                                </small>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                        <div class="col-md-12">
                                                            @if($slot_id == null)
                                                            <small>
                                                                <span style="color: blue">
                                                                    Membership points are only available for member with slot/s.
                                                                </span>
                                                            </small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <form class="global-submit" id="form_item_{{$value->item_id}}" action="/mlm/repurchase/add/cart" method="post">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="item_id" value="{{$value->item_id}}">
                                                        <input type="number" name="quantity" class="form-control" value="0">
                            
                                                    </form>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" onclick="add_to_cart({{$value->item_id}})">
                                                            <i class="icon-shopping-cart"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td>
                                                <center>No. Items Available</center>
                                            </td>
                                        </tr>
                                        @endif
                                    @else
                                    <tr>
                                        <td>
                                            <center>No. Items Available</center>
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                                <center></center>
                            </div>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>                   
    </div>
</div>
@endsection
@section('js')
 <script type="text/javascript">
 load_cart();
 function add_to_cart(item_id)
 {
    $('#form_item_'+item_id).submit();
 }
 function submit_done(data)
 {
 	console.log(data);
 	if(data.status == 'warning')
 	{
 		toastr.warning(data.message);
 	}
 	else if(data.status == 'success')
 	{
 		load_cart();
 		toastr.success(data.message);
 	}
 }
 function load_cart()
 {
 	$('.cart-repo').html('<div style="margin: 100px auto;" class="loader-16-gray"></div></center>')
 	$('.cart-repo').load('/mlm/repurchase/get/cart');
 }
 function submit_form_item(key)
 {
 	$('#cart_id_' + key).submit();
 }
 </script>
@endsection