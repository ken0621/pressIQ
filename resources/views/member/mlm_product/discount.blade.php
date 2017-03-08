@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Product Discount Per Membership </span>
                <small>
                    You can set the price of your product here.
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="form-group">
                <div class="col-md-12 table-responsive">
                    <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>
                                <div class="col-md-4">
                                    <div class="col-md-3">Item Name</div>
                                    <div class="col-md-3">Item Category</div>
                                    <div class="col-md-3">Item Type</div>
                                    <div class="col-md-3">Item Price</div>
                                </div>
                                <div class="col-md-7">
                                   <center>Membership Price</center>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td >
                                <div class="col-md-4">
                                    <div class="col-md-3">{{$item->item_name}}</div>
                                    <div class="col-md-3">{{$item->type_name}}</div>
                                    <div class="col-md-3">{{$item->item_type_name}}</div>
                                    <div class="col-md-3">{{$item->item_price}}</div>
                                </div>
                                <form class="global-submit" id="update_item_discount_{{$item->item_id}}" role="form" action="/member/mlm/product/discount/submit" method="post">
                                {!! csrf_field() !!}
                                <input type="hidden" name="item_id" value="{{$item->item_id}}">
                                <div class="col-md-7 item_id_{{$item->item_id}}">
                                    @foreach($membership_active as $key => $value)
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label>{{$value->membership_name}}</label>
                                            <input type="number" price="{{$item->item_price}}" onchange="change_price(this)" item_id="{{$item->item_id}}" membership_id="{{$value->membership_id}}" required  min="0" name="price[{{$value->membership_id}}]" class="form-control item_{{$item->item_id}}_membership_{{$value->membership_id}}_discount_value" value="{{ $item_discount[$item->item_id][$value->membership_id] == null ? 0 : $item_discount[$item->item_id][$value->membership_id]}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Discount Type</label>
                                            <select price="{{$item->item_price}}" onchange="change_price(this)" name="percentage[{{$value->membership_id}}]" item_id="{{$item->item_id}}" membership_id="{{$value->membership_id}}" class="form-control item_{{$item->item_id}}_membership_{{$value->membership_id}}_discount_type" >
                                                <option value="0" @if($item_discount_percentage[$item->item_id][$value->membership_id] == 0) selected @endif>Fixed</option>
                                                <option value="1" @if($item_discount_percentage[$item->item_id][$value->membership_id] == 1) selected @endif>Percentage</option>
                                            </select>                                            
                                        </div>
                                        <div class="col-md-4">
                                            <label>Price after discount</label>
                                            <input type="text" class="form-control item_{{$item->item_id}}_membership_{{$value->membership_id}}" value="{{get_discount_price($item->item_price, $item_discount_percentage[$item->item_id][$value->membership_id], $item_discount[$item->item_id][$value->membership_id])}}" readonly>
                                        </div>

                                        <input type="hidden" name="membership_id[{{$value->membership_id}}]"class="form-control" value="{{$value->membership_id}}">
                                    </div>
                                        
                                    @endforeach
                                </div>
                                <div class="col-md-1">
                                    <a href="javascript:" onclick="save_item_discount({{$item->item_id}})" class="pull-right btn btn-primary">Save</a>
                                </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 text-center">
                    {!!$items->render()!!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hide">
    <form class="global-submit" id="update_item_discount_g" role="form" action="/member/mlm/product/discount/submit" method="post">
        {!! csrf_field() !!}
        <div class="append_form"></div>
    </form>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function save_item_discount(item_id)
    {
        $('#update_item_discount_' + item_id).submit();
    }
    function submit_done(data)
    {
        if(data.response_status == "success_add_slot")
        {
            toastr.success('Item Price Edited');
        }
        console.log(data);
    }
    function change_price(ito)
    {

        var item_id = $(ito).attr('item_id');
        var membership_id = $(ito).attr('membership_id');
        var price = $(ito).attr('price');
        // var discount_value = $(ito).val();
        var discount_value = $('.item_' + item_id + '_membership_' + membership_id + '_discount_value').val();
        var discount_type = $('.item_' + item_id + '_membership_' + membership_id + '_discount_type').val();
        var discounted_value = get_discount_price(price, discount_type, discount_value);

        console.log(discounted_value);
        $('.item_' + item_id + '_membership_' + membership_id).val(discounted_value);
    }
    function get_discount_price(price, discount_type, discount_value)
    {
        
        if(price != null)
        {
            if(discount_type != null)
            {
                if(discount_value != null)
                {
                    var return_price = 0;
                    // fixed
                    if(discount_type == 0)
                    {
                        return_price = price - discount_value;
                    }
                    // percentage
                    else if(discount_type == 1)
                    {
                        var return_discount = price *  (discount_value/100);
                        return_price = price - return_discount;
                    }
                    return return_price;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }
    }
</script>
@endsection
