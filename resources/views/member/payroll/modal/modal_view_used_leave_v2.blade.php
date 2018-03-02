<!-- Change action, name and function-->
<form class="global-submit" role="form" action="/member/payroll/leave/modal_save_leave_temp" method="POST">

		<button type="button" class="close" data-dismiss="modal" style="margin-right: 15px;">&times;
		</button>
	
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#active-leave_temps"><i class="fa fa-calendar" aria-hidden="true"></i></i>&nbsp;Upcoming Leave</a></li>
	  <li><a data-toggle="tab" href="#archived-leave_temps"><i class="fa fa-trash-o"></i>&nbsp;Used Leave</a></li>
	</ul>
	<div class="tab-content padding-top-10">
		  <div id="active-leave_temps" class="tab-pane fade in active">
		  	
		  	<div class="load-data" target="value-id-1">
				<div id="value-id-1">
				
				  	<table class="table table-condensed table-bordered">
				  		<thead>
				  			<tr>
				  				<th style="text-align: center" width="35%">Name</th>
				  				<th style="text-align: center;" width="20%">Date Applied</th>
				  				<th style="text-align: center;" width="20%">Leave Name</th> 
				  				<th style="text-align: center;" width="15%">Used Leave</th>  
				  				<th width="10%"></th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			@foreach($upcoming_leave as $upcoming)
				  			<tr style="text-align: center;">
				  				<td>{{$name}}</td>
				  				<td>{{$upcoming->payroll_schedule_leave}}</td>
				  				<td>{{$upcoming->payroll_leave_temp_name}}</td>
				  				<td>{{$upcoming->consume}}</td>
				  				<td class="text-center"> 
				  					<div class="dropdown">
										<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu dropdown-menu-custom">
											<li>
												<a href="#" class="popup .btn-archived" link="/member/payroll/leave/v2/modal_leave_action/{{$upcoming->payroll_leave_schedule_id}}/delete_schedule_v2/0" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
											</li>
										</ul>
									</div>
				  				</td>
				  			</tr>
				  			@endforeach
				  		</tbody>
				  	</table>

				  	<div class="pagination">  </div>
		  		</div> 
			</div>

		  </div> 

		  <div id="archived-leave_temps" class="tab-pane fade">
		  	
		  	<div class="load-data" target="value-id-2">
				<div id="value-id-2">
				
				  	<table class="table table-condensed table-bordered">
				  		<thead>
				  			<tr>
				  				<th style="text-align: center" width="35%">Name</th>
				  				<th style="text-align: center;" width="20%">Date Created</th>
				  				<th style="text-align: center;" width="20%">Date Applied</th> 
				  				<th style="text-align: center;" width="15%">Used Leave</th>  
				  				<th width="10%"></th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			@foreach($used_leave as $used)
				  			<tr style="text-align: center;">
								<td>{{$name}}</td>
				  				<td>{{$used->payroll_schedule_leave}}</td>
				  				<td>{{$used->payroll_leave_temp_name}}</td>
				  				<td>{{$used->consume}}</td>
				  				<td class="text-center"> 
				  					<div class="dropdown">
										<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu dropdown-menu-custom">
											<li>
												<a href="#" class="popup .btn-archived" link="/member/payroll/leave/v2/modal_leave_action/{{$used->payroll_leave_schedule_id}}/delete_schedule_v2/0" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
											</li>
										</ul>
									</div>
				  				</td>
				  			</tr>
				  			@endforeach
				  		</tbody>
				  	</table>

				  	<div class="pagination">  </div>
		  		</div> 
			</div>

		  </div> 

  </div>

</form>
