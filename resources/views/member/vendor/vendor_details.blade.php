@extends('member.layout') @section('content') <div class="panel panel-default
panel-block panel-title-block">     <input type="hidden" name="_token"
id="_token" value="{{csrf_token()}}"/>     <div class="panel-heading">
<div>             <i class="fa fa-users"></i>             <h1>
<span class="page-title">{{$vendor->vendor_title_name."
".$vendor->vendor_first_name." ".$vendor->vendor_last_name."
".$vendor->suffix_name}}</span>                 <input type="hidden"
name="vendor_id" class="vendor-id" value="{{$vendor->vendor_id}}" />
<small>                 Vendor Details                 </small>
</h1>         </div>     </div> </div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
    	<div class="row">
	    	<div class="form-group load-vendor-detail col-md-6">
	    		<div class="vendor-detail-container">
					<h4>Full Name : {{$vendor->vendor_first_name." ".$vendor->vendor_middle_name." ".$vendor->vendor_last_name." ".$vendor->suffix_name}}</h4>
					<h4>Email : {{$vendor->email}}</h4>
					<h4>Phone : {{$vendor->vendor_phone}}</h4>
					<h4>Mobile : {{$vendor->vendor_mobile}}</h4>
				</div>
	    	</div>
	    	<div class="form-group col-md-6">
	    		<!-- <div class="col-md-12">
	    			<a class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/vendor/vendoredit/{{$vendor->vendor_id}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit vendor</a>
	    		</div> -->
	    		<div clas="col-md-12">
		    		<div class="pull-right">
		    			<h3> BALANCE <span class="green">{{currency("PHP", $vendor->balance)}}</span></h3>
		    		</div>
	    		</div>
	    	</div>
	    </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
    	@if(count($_transaction) > 0)
	    	<div class="table-responsive">
			    <table class="table table-hover table-bordered table-striped table-condensed">
			        <thead>
			            <tr>
			                <!-- <td class="col-md-2"></td> -->
			                <th>Date</th>
			                <th>Type</th>
			                <th>No</th>
			                <th>Due Date</th>
			                <th>Balance</th>
			                <th>Total</th>
			                <th>Status</th>
			                <th>Action</th>
			            </tr>
			        </thead>
			        <tbody>
			            @foreach($_transaction as $transaction)
			            <tr class="cursor-pointer" onClick="window.location='/member/{{$transaction->reference_url}}?id={{$transaction->no}}'">
			                <td>{{ dateFormat($transaction->date) }}</td>
			                <td>{{ $transaction->type }}</td>
			                <td>{{ $transaction->no }}</td>
			                <td>{{ dateFormat($transaction->due_date) }}</td>
			                <td>{{ currency("PHP",$transaction->balance) }}</td>
			                <td>{{ currency("PHP", $transaction->total) }}</td>
			                <td>{{ $transaction->status }}</td>
			                <td>
			                    <!-- ACTION BUTTON -->
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-sm btn-custom-white  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                            Action <span class="caret"></span>
		                            </button>
		                            <ul class="dropdown-menu dropdown-menu-custom">
		                                <li><a href="javascript:">Sample</a></li>
		                            </ul>
		                        </div>
			                </td>
			            </tr>
			            @endforeach
			        </tbody>
			    </table>
			</div>
		@else
			<div class="container text-center">
				<div class="row vcenter">
					<div class="col-md-12">
						<div class="error-template">
							<h2 class="message">No Trasaction Found</h2>
							<div class="error-details">
							There is no existing transaction for this vendor.
							</div>		
						</div>
					</div>
				</div>
			</div>												
        @endif
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
var customer_detail = new customer_detail();

function customer_detail()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}

	function document_ready()
	{
	}
}


</script>
@endsection