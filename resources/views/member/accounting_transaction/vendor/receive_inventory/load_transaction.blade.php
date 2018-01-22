<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Open Transaction - {{ $vendor->vendor_company }}</h4>
</div>
<div class="modal-body">
	<div class="row">
        <div class="clearfix modal-body"> 
            <div class="form-group">
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Purchase Order</h4>
                </div>
                <div class="col-md-12">
                    @if(count($_po) > 0)
                    <table class="table table-condensed table-bordered {{$total_po_amount = 0}}">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_po as $po)
                            <tr class="{{ $total_po_amount += $po->po_overall_price}}">
                                <td class="text-center">
                                    <input type="checkbox" class="check-received-po-per-line po-amount-per-line" value=""></td>
                                <td class="text-center" value="{{$po->transaction_refnum != '' ? $po->transaction_refnum : $po->po_id}}">{{$po->transaction_refnum != "" ? $po->transaction_refnum : $po->po_id}}</td>
                                <td class="text-right" value="{{currency('PHP',$po->po_overall_price)}}">{{currency('PHP',$po->po_overall_price)}}</td>
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                    @else
                    <label class="text-center form-control">No Transaction</label>
                    @endif
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
                                    <td class="text-center">
                                        <input type="checkbox" name=""></td>
                                    <td class="text-center" name="ref_number">{{$dm->transaction_refnum != "" ? $dm->transaction_refnum : $dm->db_id}}</td>
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
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
	<button class="btn btn-primary btn-custom-primary" type="submit">Add</button>
    <!-- <a onclick="add_po_to_bill({{$po->po_id}})">Add</a>
    <input type="button" value="Add PO" onclick="add_po()" /> -->
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('body').on('click','.check-received-po-per-line', function()
        {
            $(this).prop('checked', this.checked); 
            compute_credit();        
        });

        compute_credit();
        function compute_credit()
        {
            var total_apply_credit = 0;
            $('.po-amount-per-line').each(function(a, b)
            {
                if($(b).is( ":checked" ))
                {
                    total_apply_credit += parseFloat($(b).attr('data-content'));
                }
            });
            $('.total-apply-credit').html('PHP '+total_apply_credit.toFixed(2));
        }   
    }); 
</script>