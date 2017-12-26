<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Open Transaction - {{ $vendor->vendor_company }}</h4>
</div>
<div class="modal-body">
	<div class="row">
        <div class="clearfix modal-body"> 
            <div class="form-group">
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Sales Order</h4>
                </div> 
                <div class="col-md-12">
                    @if(count($_po) > 0)
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_po as $po)
                            <tr>
                                <td class="text-center"><input type="checkbox" name=""></td>
                                <td class="text-center">{{$po->transaction_refnum != "" ? $po->transaction_refnum : $po->po_id}}</td>
                                <td class="text-right">{{currency('PHP',$po->po_overall_price)}}</td>
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                    @else
                    <label class="text-center form-control">No Transaction</label>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Debit Memo</h4>
                </div> 
                <div class="col-md-12">
                    @if(count($_dm) > 0)
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_dm as $dm)
                            <tr>
                                <td class="text-center"><input type="checkbox" name=""></td>
                                <td class="text-center">{{$dm->transaction_refnum != "" ? $dm->transaction_refnum : $dm->db_id}}</td>
                                <td class="text-right">{{currency('PHP',$dm->db_amount)}}</td>
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                    @else
                    <label class="text-center form-control">No Transaction</label>
                    @endif
                </div>
            </div>
        </div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
	<button class="btn btn-primary btn-custom-primary" type="button">Add</button>
</div>