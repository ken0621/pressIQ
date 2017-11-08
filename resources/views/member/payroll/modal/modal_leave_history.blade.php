<!-- Change action, name and function-->
<form class="global-submit" role="form" action="/member/payroll/leave/modal_save_leave_temp" method="POST">

		<button type="button" class="close" data-dismiss="modal" style="margin-right: 15px;">&times;
		</button>
	
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#active-leave_temp"><i class="fa fa-star"></i>&nbsp;Active</a></li>
	  <li><a data-toggle="tab" href="#archived-leave_temp"><i class="fa fa-trash-o"></i>&nbsp;Archived</a></li>
	</ul>
	<div class="tab-content padding-top-10">
		  <div id="active-leave_temp" class="tab-pane fade in active">
		  	
		  	<div class="load-data" target="value-id-1">
				<div id="value-id-1">
				
				  	<table class="table table-condensed table-bordered">
				  		<thead>
				  			<tr>
				  				<th style="text-align: center;">Date Created</th>
				  				<th style="text-align: center;">Date Applied</th> 
				  				<th style="text-align: center;">Used Leave</th>  
				  				<th width="10%"></th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			<tr style="text-align: center;">
				  				<td>Sample Date</td>
				  				<td>Sample Date</td>
				  				<td>Sample Leave</td>
				  				<td class="text-center"> 
				  					<div class="dropdown">
										<button class="btn btn-custom-white dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu dropdown-menu-custom">
											<li>
												<a href="#" class="popup" link=""><i class="fa fa-pencil"></i>&nbsp;Edit</a>
											</li>
											<li>
												<a href="#" class="popup" link="" size="sm"><i class="fa fa-trash-o"></i>&nbsp;Archive</a>
											</li>
										</ul>
									</div>
				  				</td>
				  			</tr>
				  		</tbody>
				  	</table>

				  	<div class="pagination">  </div>
		  		</div> 
			</div>

		  </div> 

  </div>

</form>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_leave_temp.js"></script>