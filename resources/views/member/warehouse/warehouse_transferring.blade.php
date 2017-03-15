@extends('member.layout')
@section('content')
<form class="global-submit-page form-to-submit-transfer" role="form" action="/member/item/warehouse/transfer_submit" method="post">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="panel-heading">
        <div>
            <i class="fa fa-building"></i>
            <h1>
                <span class="page-title">Warehouse &raquo; Transfer Inventory</span>
                <small>
                    Start Transferring inventory
                </small>
            </h1>
            <div class="text-right">
            <a class="btn btn-custom-white panel-buttons" href="/member/item/warehouse">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit Transfer</button>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <input type="hidden" name="warehouse_from" value="{{$from->warehouse_id}}">
        <input type="hidden" name="warehouse_to" value="{{$to->warehouse_id}}">
        <div class="form-group" >
            <div class="col-md-4">            
                <h3><strong>From :</strong> <label> {{$from->warehouse_name}}</label></h3>
            </div>
            <div class="col-md-4">            
                <h3><strong> To :</strong> <label> {{$to->warehouse_name}}</label></h3>
            </div>
            <div class="col-md-4 text-right" style="padding-top: 30px">            
                <a href="javascript:" style="text-decoration: underline;font-size: 16px">Load {{$ctr}} critical items</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label>Remarks *</label>
                <textarea required class="form-control input-sm" name="remarks"></textarea>
            </div>
        </div>
      <!--   <div class="form-group">        
            <div class="col-md-3" >
                <select class="form-control">
                    <option>All Items</option>
                </select>
            </div>
            <div class="col-md-9" > 
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="search" name="" class="form-control" placeholder="Start typing item">
                </div>
            </div>
        </div> -->
        <div class="row clearfix draggable-container">
                <div class="table-responsive">
                    <div class="col-sm-12">
                        <table class="digima-table">
                            <thead >
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Product SKU</th>
                                    <th class="text-center" style="width: 250px;">Source QTY</th>
                                    <th class="text-center" style="width: 250px;">Current QTY</th>
                                    <th class="text-center" style="width: 250px;">Transfer QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($warehouse_list)
                                    @foreach($warehouse_list as $item)
                                        <tr>
                                            <td>
                                                {{$item->product_id}}
                                            </td>
                                            <td>                                                
                                                {{$item->product_name}}
                                            </td>                                            
                                            <td>                                                
                                                {{$item->product_sku}}
                                            </td>                                            
                                            <td class="text-center">                                                
                                                {{$item->product_source_qty == null ? 0 : $item->product_source_qty}}
                                            </td>                  
                                            <td class="text-center">                                                
                                                @if($item->product_current_qty <= $item->product_reorder_point)
                                                <label style="color: red">{{$item->product_current_qty == null ? 0 : $item->product_current_qty}}</label>
                                                @else
                                                <label style="color: {{$item->product_current_qty == null ? red :''}}" >{{$item->product_current_qty == null ? 0 : $item->product_current_qty}}</label>
                                                @endif
                                            </td>
                                            <td><input type="text" value="0" class="form-control number-input input-sm" name="quantity[{{$item->product_id}}]"></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
        
    </div>
</div>
</form>

@endsection

@section('script')
<!-- <script type="text/javascript">
    $(".chosen-select").chosen({no_results_text: "The customer doesn't exist."});
</script>
 --><!-- <script type="text/javascript" src="/assets/member/js/draggable_row.js"></script> -->
<script type="text/javascript" src="/assets/member/js/transfer_warehouse.js"></script>
<script type="text/javascript" src="/assets/member/js/warehouse.js"></script>
@endsection