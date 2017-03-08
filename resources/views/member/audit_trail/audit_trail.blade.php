@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-clock-o"></i>
            <h1>
                <span class="page-title">Audit History</span>
                <small>
                    Transaction History
                </small>
            </h1>
        </div>
    </div>
</div>

<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body form-horizontal">
        <div class="form-group">
        	<div class="col-md-12">  		
		        <div class="form-group tab-content panel-body warehouse-container">
		            <div id="all" class="tab-pane fade in active">
		                <div class="form-group order-tags"></div>
		                <div class="table-responsive">
		                    <table class="table table-bordered table-condensed">
		                    <thead>
		                    	<tr>
		                    		<th>Date</th>
		                    		<th>User</th>
		                    		<th>Transaction</th>
		                    		<th>Desription</th>
		                    		<th>Issue Date</th>
		                    		<th>Amount</th>
		                    		<!-- <th></th> -->
		                    	</tr>
		                    </thead>
		                    <tbody>
		                    	@if($_audit != null)
		                    		@foreach($_audit as $audit)
		                    			<tr>
		                    				<td>{{date('M d, g:i A',strtotime($audit->created_at))}}</td>
		                    				<td>{{$audit->user}}</td>
		                    				<td>{{ucfirst($audit->action)}} <a>{{$audit->transaction_txt}}</a></td>
		                    				<td>{{$audit->transaction_client}}</td>
		                    				<td>{{$audit->transaction_date}}</td>
		                    				<td>{{$audit->transaction_amount}}</td>
		                    				<!-- <td><a href="">{{$audit->transaction_txt != "" ? "View" : ""}}</a></td> -->
		                    			</tr>
		                    		@endforeach
		                    	@endif
		                    </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
        	</div>
        </div>
    </div>
</div>
@endsection