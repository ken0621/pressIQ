<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Transaction Receipt</h4>
</div>
<div class="modal-body">
	<div class="form-group text-center">
	    <h3><b>{{$shop_key or ''}}</b></h3>
	    <h4>{{$shop_address or ''}}</h4>
	</div>
	<div class="form-group">
	    &nbsp;
	</div>
	<div class="form-group">
	    <div class="col-md-6">
	        <label for="">Customer Name : </label> {{ucwords($customer_name)}} <br>
	        <label>Transaction Number :</label> {{$list->transaction_number}}<br>
	    </div>
	    <div class="col-md-3 text-right">
	        <label>Date :</label> <br>
	        <label>Due Date :</label> 
	    </div>
	    <div class="col-md-3"> 
	    {{date('M d, Y',strtotime($list->transaction_date))}} <br>
	    {{date('M d, Y',strtotime($list->transaction_due_date))}}
	    </div>
	</div>
	<div class="form-group">
	    &nbsp;
	</div>
	<div class="form-group">
	    <div class="table-responsive">
            <table class="table table-bordered table-condensed text-center">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Item Details</th>
                        <th>Item Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($_item as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td class="text-left">
                                <b>{{$item->item_name}}</b>
                            </td>
                            <td>{{currency('PHP',$item->item_price)}}</td>
                            <td>{{number_format($item->quantity)}}</td>
                            <td>{{currency('PHP',$item->subtotal)}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan='4' class="text-right"><b>TOTAL</b></td>
                        <td class="text-center">{{currency('PHP', $list->transaction_total)}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!--<div class="modal-body">-->
<!--    <div class="form-group">-->
        
<!--    </div>-->
<!--</div>-->
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
</div>