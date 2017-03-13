@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-users"></i>
            <h1>
                <span class="page-title">{{$customer->title_name." ".$customer->first_name." ".$customer->last_name." ".$customer->suffix_name}}</span>
                <input type="hidden" name="customer_id" class="customer-id" value="{{$customer->customer_id}}" />
                <small>
                Customer Details
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
    	<div class="form-group">
    		<a class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/customer/customeredit/{{$customer->customer_id}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit Customer</a>
    	</div>
    	<div class="form-group load-customer-detail">
    		<div class="customer-detail-container">
				<h4>Full Name : {{$customer->first_name." ".$customer->middle_name." ".$customer->last_name." ".$customer->suffix_name}}</h4>
				<h4>Email : {{$customer->email}}</h4>
				<h4>Phone : {{$customer->customer_phone}}</h4>
				<h4>Mobile : {{$customer->customer_mobile}}</h4>
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
			                <th>ID</th>
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
			            <tr  onClick="window.location='/member/customer/{{$transaction->reference_name}}?id={{$transaction->no}}'">
			                <td>{{ $transaction->date }}</td>
			                <td>{{ $transaction->type }}</td>
			                <td>{{ $transaction->no }}</td>
			                <td>{{ $transaction->due_date }}</td>
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
							There is no existing transaction for this customer.
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
<script type="text/javascript" src="/assets/member/js/customer_detail.js"></script>
@endsection