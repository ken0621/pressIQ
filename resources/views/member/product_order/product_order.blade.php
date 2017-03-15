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
            <a class="panel-buttons btn btn-custom-primary pull-right" href="product_order/create_order" >Create Invoice</a>
        </div>
    </div>
</div>

<!-- NO PRODUCT YET -->


<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <ul class="nav nav-tabs">
        <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#unpaid"><i class="fa fa-star"></i> Unpaid</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#paid"><i class="fa fa-trash"></i> Paid</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab"  href="#void"><i class="fa fa-trash"></i> Void</a></li>
    </ul>
    
    <div class="tab-content">
        <div id="unpaid" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Payment Status</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($ec_order_unpaid)
                            @foreach($ec_order_unpaid as $order)
                            <tr>
                                <td>{{$order->ec_order_id}}</td>
                                <td>{{$order->created_date}}</td>
                                <td>{{$order->first_name}} {{$order->middle_name}} {{$order->last_name}}</td>
                                <td>{{$order->order_status}}</td>
                                <td>{{$order->total}}</td>
                                <th>
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-grp-primary" href="/member/ecommerce/product_order/create_order?id={{$order->ec_order_id}}">View</a>
                                    </div>
                                </th>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5"><center>No Order</center></td>    
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
        <div id="paid" class="tab-pane fade in ">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Payment Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($ec_order_paid)
                            @foreach($ec_order_paid as $order)
                            <tr>
                                <td>{{$order->ec_order_id}}</td>
                                <td>{{$order->created_date}}</td>
                                <td>{{$order->first_name}} {{$order->middle_name}} {{$order->last_name}}</td>
                                <td>{{$order->order_status}}</td>
                                <td>{{$order->total}}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5"><center>No Order</center></td>    
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div id="void" class="tab-pane fade in ">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Payment Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($ec_order_void)
                            @foreach($ec_order_void as $order)
                            <tr>
                                <td>{{$order->ec_order_id}}</td>
                                <td>{{$order->created_date}}</td>
                                <td>{{$order->first_name}} {{$order->middle_name}} {{$order->last_name}}</td>
                                <td>{{$order->order_status}}</td>
                                <td>{{$order->total}}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5"><center>No Order</center></td>    
                            </tr>
                        @endif
                    </tbody>
                </table>
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
