@extends('member.layout')
@section('css')
@endsection
@section('content')



<div class="panel panel-default panel-block panel-title-block" id="top">
	<div class="form-group">
	  	<div class="panel-heading">
		    <div>	
		    	<i class="fa fa-building-o"></i>
		     	 <h1>
			      	<span class="page-title">13th Month Pay Report</span>
			     	<small>
			      	Payroll
			     	 </small>
		    	</h1>
	    	</div>
	    	<div>
		      	<div class="pull-right export_excel">
			        <button class="btn btn-custom-primary dropdown-toggle " type="button" data-toggle="dropdown"><i class="fa fa-file-excel-o"></i>&nbsp;Export From Excel
			        </button> 
	     		</div> 		      	
		      	<div class="pull-right">
		      		<input type="text" class="datepicker form-control end-date" name="end_date" placeholder="End Date" value="{{$end_date}}" />
		      	</div>       
		      	<div class="pull-right margin-lr-5" >
		      		<input type="text" class="datepicker form-control start-date" name="start_date" placeholder="Start Date" value="{{$start_date}}"/>
		      	</div>
	      	</div>
	      	<input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
	    </div>
	</div>

</div>

<div class="tab-content tab-pane-div padding-top-10">
  <div id="active-employee-tab" class="tab-pane fade in active">
    <div class="form-horizontal">

      <div class="form-group">
        <div class="col-md-12">
          <div class="col-md-2 padding-lr-1">
            <small>Filter by Company</small>
            <select class="form-control filter-change company_id">
              <option value="0">Select company</option>
              @foreach($_company as $company)
              <option value="{{$company['company']->payroll_company_id}}">{{$company['company']->payroll_company_name}}</option> 
                @foreach($company['branch'] as $branch)
                <option value="{{$branch->payroll_company_id}}">&nbsp;&nbsp;• {{$branch->payroll_company_name}}</option>
                @endforeach
              @endforeach
            </select>
          </div>
          <div class="col-md-2 padding-lr-1">
            <small>Filter by Department</small>
            <select class="form-control filter-change department_id">
              <option value="0">Select Department</option>             
				@foreach($_department as $department)			
					<option value="{{ $department->payroll_department_id }}">{{ $department->payroll_department_name }}</option>													
				@endforeach				
            </select>
          </div>
          
          <div class="col-md-4 pull-right padding-lr-1">
          <div class="search_emp">
            <small>Search Employee</small>
            <select class="form-control filter-change emp_id">
              <option value="">Select Employee</option>
           		@if($_active != FALSE)	   	
	              	@foreach($_active as $active)
						@foreach($active as $a)
							@if($a['name'] != '' || $a['name'] != NULL)
								<option value="{{  $a['employee_id'] }}">{{ $a['name'] }}</option>	
							@endif
						@endforeach										
					@endforeach
				@endif
            </select>        
          	</div>
          </div>

        </div>
      </div>

      <div class="form-group">
        <div class="col-md-12">
         <div class="table-responsive load-data">
          <table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Employee Name</th>
						<th>Department</th>
						<th>job Title</th>
						<th>Payroll Period</th>
						<th>Basic Salary</th>
						<th>13 Month</th>
						<th>Sub Total</th>
					</tr>
				</thead>
				<tbody>

					@if($_active != FALSE)
						@foreach($_active as $active)
							@foreach($active as $a)
								<tr>
									<td>{{ $a['name'] }}</td>
									<td>{{ $a['department'] }}</td>
									<td>{{ $a['job_title'] }}</td>
									<td>{{ $a['period'] }}</td>
									<td class="text-right">{{ $a['basic_salary'] }}</td>
									<td class="text-right">{{ $a['amount_of_13'] }}</td>
									<td class="text-right">{{ $a['sub_total'] }}</td>
								</tr>
							@endforeach										
						@endforeach
					@else
						<tr>
							<td colspan="7" class="text-center"><h3>No Records Found</h3></td>
						</tr>
					@endif
				</tbody>
			</table>        
          </div>
        </div>
      </div>

    </div>    
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="/assets/member/js/paginate_ajax_multiple.js"></script>
<script>

var payroll_journal_entry = new payroll_journal_entry();

function payroll_journal_entry()
{
	init();

	function init()
	{
		document_ready();
	}

	function document_ready()
	{
		on_event();
	}

	function on_event()
	{
		$('body').on('change', '.start-date, .end-date, .emp_id', function(event) {
			action_get_data_table();	
		});
		$('body').on('change', '.department_id, .company_id', function(event) {
			action_get_data_table();
			action_get_data_table('.search_emp');	
		});
		//onclick button export to excel
		$('body').on('click', '.export_excel', function(event) {
			/*console.log('button click');*/
			action_export_excel();
			 //$("#w3s").attr("href", "https://www.w3schools.com/jquery");
		});
	}

		

	function action_get_data_table(target = '.load-data')
	{
		//console.log('pasok');
		event.preventDefault();
		var start 			= $(".start-date").val();
		var end 			= $(".end-date").val();
		var department_id 	= $(".department_id").val();
		var company_id 		= $(".company_id").val();
		var emp_id			= $(".emp_id").val();

		var loader 	= '<div class="loader-16-gray"></div>';
		if(target == '.load-data')
		{
			$(target).html(loader);
		}
		
		$(target).load("/member/payroll/report_13th_month_pay?start_date=" +start +"&&end_date=" +end +"&&department_id="+department_id +"&&company_id="+company_id +"&&emp_id="+emp_id+" "+target, function()
		{
			if(target == '.load-data')
			{
				toastr.success("Generated");	
			}			
		})
		/* Act on the event */	
	}

	function action_export_excel()
	{
		event.preventDefault();
		var start 			= $(".start-date").val();
		var end 			= $(".end-date").val();
		var department_id 	= $(".department_id").val();
		var company_id 		= $(".company_id").val();
		var emp_id			= $(".emp_id").val();
	
		location.href = "/member/payroll/report_13th_month_pay/excel_export?start_date=" +start +"&&end_date=" +end +"&&department_id="+department_id +"&&company_id="+company_id +"&&emp_id="+emp_id;
		
	}
}

</script>
@endsection