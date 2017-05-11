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
    		<form data-target="#active-employee" method="POST" action="/member/utilities/audit">
	            <input type="hidden" name="_token" value="{{csrf_token()}}">
	    		<div class="col-md-12 filter-div">
	    			<div class="col-md-2 padding-lr-1">
		        		<small>Date From:</small>
	        			<input type="date" name="date_from" class="form-control perdictive perdictive-active width-100" value="{{ ($date_from != "") ? $date_from : '' }}" >	
		        	</div>	
		        	<div class="col-md-2 padding-lr-1">
		        		<small>Date To:</small>
	        			<input type="date" name="date_to" class="form-control perdictive perdictive-active width-100" value="{{ ($date_to != "") ? $date_to : '' }}" 	>	
		        	</div>	
	        	</div>
		        <div class="col-md-12 filter-div">
		        	
		          <div class="col-md-2 padding-lr-1">
		            <small>Filter by: </small>
		            <select class="form-control filter-change filter-change-col" name="col" data-target="#active-employee" >
		             {{--  <option value="0">Select Column</option> --}}
		              @foreach($_column as $key => $value)
		              	<option value="{{ $key }}" {{ ($key==$col) ? 'selected' : '' }} >{{ $value }}</option>
		              @endforeach
		            </select>
		          </div>
		          <div class="col-md-4 padding-lr-1">
		            <input type="hidden" id="col" value="">
		            <small>Search Keyword</small>
		            <div class="input-group">
		              <input type="search" name="keyword" id="keyword" class="form-control perdictive perdictive-active width-100" placeholder="Search  here" value="{{ isset($keyword) ? $keyword : '' }}" >
		              <span class="input-group-btn">
		                <button class="btn btn-custom-primary" type="submit"><i class="fa fa-search"></i></button>
		              </span>
		            </div>           
	          </form>
	        </div>
	     </div>


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

<script type="text/javascript">
	
	/*function onSelCol()
	{
		var col = $(".filter-change-col").val();
		if (col != "0" )
		{
			$("#col").val(col);	
		} 
			else 
		{
			$(),prop
		}

		
		
	} 	*/

</script>
@endsection

