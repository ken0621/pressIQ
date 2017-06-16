<form class="global-submit form-horizontal" role="form" action="{{$action or ''}}" id="confirm_answer" method="post">
	{!! csrf_field() !!}
	<div class="modal-header">
       <input type="hidden" name="" class="amount-to-credit" value="{{$cm_amount}}">
       <input type="hidden" class="form-control input-sm" name="cm_id" value="{{$cm_data->cm_id or ''}}" />
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Apply Credit to Invoice</h4>
	</div>
	<div class="modal-body add_new_package_modal_body clearfix">
    <div class="form-group">
        <div class="col-md-12">
            <h4> <strong>Customer Name :</strong> {{$_customer->company != "" ? $_customer->company : $_customer->first_name." ".$_customer->middle_name." ".$_customer->last_name }}</h4>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <strong>Date : </strong> {{$cm_data->cm_date}}
        </div>
        <div class="col-md-4">
            <strong>Original Amount : </strong> {{currency('PHP ',$cm_amount)}}
        </div>
        <div class="col-md-4">
           <strong> Remaining Credit : <span class="remaining-credit"> {{currency('PHP ',0)}} </span></strong>
        </div>
    </div>
    <div class="form-group">
        <div class="row clearfix draggable-container">
            <div class="table-responsive">
                <div class="col-sm-12">
                    <table class="digima-table">
                        <thead >
                            <tr>
                                <th style="width: 15px;"></th>
                                <th>Description</th>
                                <th style="width: 150px;" >Due Date</th>
                                <th class="text-right" style="width: 120px;" class="text-right">Original Amount</th>
                                <th class="text-right" style="width: 120px;">Balance Due</th>
                                <th class="text-right" style="width: 120px;">AMT APPLIED</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-item">
                            @include('member.customer.credit_memo.load_invoices_for_applied_cm')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	</div>
	<div class="modal-footer text-right">
	    <div class="col-md-12">
	    	<button type="submit" class="btn btn-custom-blue">Save</button>
	    	<button data-dismiss="modal" class="btn btn-def-white btn-custom-white">Cancel</button>
	    </div>
	</div>  
</form>
<script type="text/javascript" src="/assets/member/js/credit_memo_applied.js"></script>