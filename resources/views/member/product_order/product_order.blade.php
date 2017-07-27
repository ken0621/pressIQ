@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Product Order Lists</span>
                <small>
                    List of orders
                </small>
            </h1>
            <!-- <a class="panel-buttons btn btn-custom-primary pull-right" href="product_order/create_order" >Create Invoice</a> -->
<!--             <a class="panel-buttons btn btn-default pull-right" href="product_order/create_order" >Sales by product (Report)</a>
            <a class="panel-buttons btn btn-default pull-right" href="product_order/create_order" >Sales by month (Report)</a>
            <a class="panel-buttons btn btn-default pull-right" href="product_order/create_order" >Sales by variant (Report)</a> -->
        </div>
    </div>
</div>

<!-- NO PRODUCT YET -->


<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#pending"><i class="fa fa-star"></i> Pending</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#failed"><i class="fa fa-star"></i> Failed</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#processing"><i class="fa fa-star"></i> Processing</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#shipped"><i class="fa fa-star"></i> Shipped</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#completed"><i class="fa fa-star"></i> Completed</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#onhold"><i class="fa fa-star"></i> On-Hold</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#cancelled"><i class="fa fa-trash"></i> Cancelled</a></li>
    </ul>
    
    <div class="tab-content">
        <div id="pending" class="tab-pane fade in active">
            <div class="load-data" target="value-pending">
                <div id="value-pending">
                @include("member.product_order.load_product_order",['ec_order' => $ec_order_pending])
                </div>
            </div>
        </div>
        
        <div id="failed" class="tab-pane fade in">
            <div class="load-data" target="value-failed">
                <div id="value-failed">
                    @include("member.product_order.load_product_order",['ec_order' => $ec_order_failed])
                </div>
            </div>
        </div>

        <div id="processing" class="tab-pane fade in ">
            <div class="load-data" target="value-processing">
                <div id="value-processing">
                    @include("member.product_order.load_product_order",['ec_order' => $ec_order_processing])
                </div>
            </div>
        </div>

        <div id="shipped" class="tab-pane fade in ">
            <div class="load-data" target="value-shipped">
                <div id="value-shipped">
                    @include("member.product_order.load_product_order",['ec_order' => $ec_order_shipped])
                </div>
            </div>
        </div> 

        <div id="completed" class="tab-pane fade in ">
            <div class="load-data" target="value-completed">
                <div id="value-completed">
                    @include("member.product_order.load_product_order",['ec_order' => $ec_order_completed])
                </div>
            </div>
        </div> 

        <div id="onhold" class="tab-pane fade in ">
            <div class="load-data" target="value-onhold">
                <div id="value-onhold">
                    @include("member.product_order.load_product_order",['ec_order' => $ec_order_on_hold])
                </div>
            </div>
        </div>

        <div id="cancelled" class="tab-pane fade in ">
            <div class="load-data" target="value-cancelled">
                <div id="value-cancelled">
                    @include("member.product_order.load_product_order",['ec_order' => $ec_order_cancelled])
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection
@section('script')
<script type="text/javascript">
@if (Session::has('success'))
   toastr.success("{{ Session::get('success') }}");
@endif  
@if (Session::has('warning'))
   toastr.warning("{{ Session::get('warning') }}");
@endif  
</script>
@endsection
