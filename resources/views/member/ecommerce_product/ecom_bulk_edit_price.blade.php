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
                <button type="submit" class="panel-buttons btn btn-custom-white pull-right save-and-new" method="post">Save And New</button>
                <a href="/member/ecommerce/product/list" class="panel-buttons btn btn-default pull-right">Cancel</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- FORM.TITLE -->
            <div class="form-box-divider">
                <div class="row clearfix">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Current Price</th>
                                    <th>New Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($_product as $product)
                                <tr>
                                    <td>{{$product['eprod_name']}}</td>
                                    <td>{{currency('',$product['evariant_price'])}}</td>
                                    <td>
                                        <input type="hidden" name="evariant_id" value="{{$product['evariant_id']}}">
                                        <input type="text" class="form-control input-sm" name="evariant_new_price">
                                    </td>
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

    function formatMoney($this)
    {
        var n = formatFloat($this), 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }

</script>
@endsection