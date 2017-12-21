<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Open Transaction - {{$customer_name or 'Juan Dela Cruz'}}</h4>
</div>
<div class="modal-body">
	<div class="row">
        <div class="clearfix modal-body"> 
            <div class="form-group">
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Estimate and Quotation</h4>
                </div>
                <div class="col-md-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="">
                                </td>
                                <td class="text-center">EQ20171214-0001</td>
                                <td class="text-center">PHP 1,000.00</td>
                            </tr>
                        </tbody>                        
                    </table>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <h4> <i class="fa fa-caret-down"></i> Sales Order</h4>
                </div> 
                <div class="col-md-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Reference Number</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="">
                                </td>
                                <td class="text-center">SO20171214-0001</td>
                                <td class="text-center">PHP 1,000.00</td>
                            </tr>
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
	<button class="btn btn-primary btn-custom-primary" type="button">Add</button>
</div>