<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">All Available Credits</h4>
</div>
<div class="modal-body clearfix">
	<div class="row">
        <div class="clearfix modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <h4>Customer Name : {{isset($customer_data) ? ($customer_data->company != '' ? $customer_data->company  : $customer_data->first_name. ' '.$customer_data->last_name) : 'No Customer'}}</h4>
                </div>
            </div>
            <div class="form-horizontal">
                @if($customer_id)
                <div class="form-group">
                    @if(count($_credits) > 0)
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" name=""></th>
                                <th>Credit Memo Number</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($_credits as $credit)
                        <tr>
                            <td class="text-center"><input type="checkbox" name=""></td>
                            <td>{{$credit->cm_id}}</td>
                            <td>{{currency('PHP',$credit->cm_amount)}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="form-group text-center"><h4>No Available Credits </h4></div>
                    @endif                   
                </div>
                @else
                <div class="form-group text-center"><h4>No Customer Selected </h4></div>
                @endif
            </div>
        </div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
	<button class="btn btn-primary btn-custom-primary" type="button">Apply</button>
</div>