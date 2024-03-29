<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Available Credit - {{$customer_name or 'Juan Dela Cruz'}}</h4>
</div>
<div class="modal-body">
	<div class="row">
        <div class="clearfix modal-body"> 
            <div class="form-group">
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Credits</h4>
                </div>
                <div class="col-md-12">
                    @if(count($_cm) > 0)
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($_cm as $cm)
                            <tr>
                                <td class="text-center"><input type="checkbox" name=""></td>
                                <td class="text-center">{{$cm->transaction_refnum != "" ? $cm->transaction_refnum : $cm->cm_id}}</td>
                                <td class="text-center">{{currency('PHP',$cm->cm_amount)}}</td>
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