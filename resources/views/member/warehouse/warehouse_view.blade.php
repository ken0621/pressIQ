
<form class="global-submit form-to-submit-add" action="/member/item/warehouse/edit_submit" method="post">
<style type="text/css">
    .chosen-container
    {
        width: 100% !important;
    }
</style>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title layout-modallarge-title item_title">Warehouse Information</h4>
</div>
<div class="modal-body modallarge-body-layout background-white form-horizontal menu_container" >
    <div class="panel-body form-horizontal">
        <div class="form-group">
            <div class="col-md-6">            
                <h2>{{$warehouse->warehouse_name}}</h2>
            </div>
        </div>
        <div class="form-group">
       <!--  <div class="col-md-12"><h3>Select Item</h3></div>        
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
                <div class="load-data" target="warehouse_data">
                    <div id="warehouse_data">                        
                        <div class="col-sm-12">
                            <table class="digima-table">
                                <thead >
                                    <tr>
                                        <th class="text-center" style="width: 40px">Product ID</th>
                                        <th style="width: 150px;">Product Name</th>
                                        <th style="width: 100px;">Product SKU</th>
                                        <th style="width: 100px;">Current Stocks</th>
                                        @if($pis != 0)
                                        <th style="width: 100px;">SIR Stocks</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="draggable">
                                @if($warehouse_item != null)
                                    @foreach($warehouse_item as $key => $w_item)
                                    <tr class="tr-draggable tr-draggable-html count_row">
                                        <td class="text-center"> {{$w_item->product_id}}</td>
                                        <td class="">
                                           <label class="count-select">{{$w_item->product_name}}</label>
                                        </td>
                                        <td><label class="sku-txt sku-txt{{$key+1}}">{{$w_item->product_sku}}</label></td>
                                        <td class="text-center"> 
                                            @if($w_item->product_warehouse_stocks <= $w_item->product_reorder_point)
                                            <label style="color: red">{{$w_item->product_qty_um}}</label>
                                            @else
                                            <label >{{$w_item->product_qty_um}}</label>
                                            @endif
                                        </td>
                                        @if($pis != 0)
                                        <td class="text-center"><a class="popup" link="/warehouse/sir/{{$warehouse->warehouse_id}}/{{$w_item->product_id}}" size="md">{{$w_item->total_stock_sir}}</a></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center pull-right">
                            {!!$warehouse_item->render()!!}
                        </div> 
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<div class="modal-footer" >
    <button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
</div>
</form>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<!-- <script type="text/javascript" src="/assets/member/js/draggable_row.js"></script> -->
<script type="text/javascript" src="/assets/member/js/transfer_warehouse.js"></script>
<script type="text/javascript" src="/assets/member/js/warehouse.js"></script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>