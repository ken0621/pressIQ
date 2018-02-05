<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Open Transaction</h4>
</div>
<div class="modal-body">
	<div class="row">
        <div class="clearfix modal-body"> 
            <div class="form-group">
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Sales Order</h4>
                </div> 
                <div class="col-md-12">
                    @if(count($_so) > 0)
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_so as $so)
                            <tr>
                                <td class="text-center"><input type="checkbox" name=""></td>
                                <td class="text-center">{{$so->transaction_refnum != "" ? $so->transaction_refnum : $so->est_id}}</td>
                                <td class="text-center">{{$so->title_name.' '.$so->first_name.' '.$so->middle_name.' '.$so->last_name}}</td>
                                <td class="text-right">{{currency('PHP',$so->est_overall_price)}}</td>
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                    @else
                    <label class="text-center form-control">No Transaction</label>
                    @endif
                </div>
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Purchase Requisition</h4>
                </div> 
                <div class="col-md-12">
                    @if(count($_pr) > 0)
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Vendor Name</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_pr as $pr)
                            <tr>
                                <td class="text-center td-check-po "><input type="checkbox" name=""></td>
                                <td class="text-center">{{$pr->transaction_refnum != "" ? $pr->transaction_refnum : $pr->requisition_slip_id}}</td>
                                <td class="text-center">{{$pr->vendor_company}}</td>
                                <td class="text-right">{{currency('PHP',$pr->rs_item_amount)}}</td>
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

<script type="text/javascript">
    $(document).ready(function()
    {
        $('body').on('click','.td-check-po', function()
        {
            $(this).prop('checked', this.checked); 
            compute();
        });

        compute();
        function compute()
        {
            var total_po_amount = 0;
            $('.td-check-po').each(function(a, b)
            {
                if($(b).is( ":checked" ))
                {
                    total_po_amount += parseFloat($(b).attr('data-content'));
                }
            });
            $('.total-apply-bill').html('PHP '+total_po_amount.toFixed(2));
        }   
    }); 
</script>