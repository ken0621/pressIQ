@extends('member.layout')
@section('content')
<form class="global-submit" action="/member/ecommerce/product/bulk-edit-price" method="post">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="button-action" name="button_action" value="">
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">Products &raquo; Prices</span>
                    <small>
                    Update Product Prices
                    </small>
                </h1>
                <button type="submit" class="panel-buttons btn btn-custom-primary pull-right save-and-edit" method="post">Save</button>
                <a href="/member/ecommerce/product/list" class="panel-buttons btn btn-default pull-right">Cancel</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- FORM.TITLE -->
            <div class="form-box-divider">
                <div class="row clearfix load-data">
                    <div class="table-responsive data-content">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Current Price</th>
                                    <th class="text-center">New Price</th>
                                    <th class="text-center">Current Promo Price</th>
                                    <th class="text-center">New Promo Price</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($_product as $product)
                                <tr>
                                    <td>{{$product['eprod_name']}}</td>
                                    <td>{{currency('',$product['evariant_price'])}}</td>
                                    <td>
                                        <input type="hidden" name="evariant_id[]" value="{{$product['evariant_id']}}">
                                        <input type="text" class="form-control input-sm money-format" name="evariant_new_price[]">
                                    </td>
                                    <td>
                                        @if($product['item_discount_value'] != null)
                                            {{currency('',$product['item_discount_value'])}}
                                            </br>
                                            ({{dateFormat($product['item_discount_date_start'])}}-{{dateFormat($product['item_discount_date_end'])}})
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control input-sm money-format" name="item_promo_price[]"></td>
                                    <td><input type="text" class="form-control input-sm datepicker" name="item_start_date[]"></td>
                                    <td><input type="text" class="form-control input-sm datepicker" name="item_end_date[]"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</form>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/css/product.css">
@endsection

@section('script')
<script type="text/javascript">
    product_id = 0;
    @if(Session::has('success'))
        toastr.success('{{Session::get('success')}}');
    @endif

    function submit_done(data)
    {
        if(data.status == "success")
        {
            $('.load-data').load("/member/ecommerce/product/bulk-edit-price .data-content", function()
            {
                toastr.success(data.message);
                $(".datepicker").datepicker();
            })
        }
    }
</script>
@endsection