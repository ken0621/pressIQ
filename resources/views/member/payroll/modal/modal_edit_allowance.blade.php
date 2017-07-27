<form class="global-submit" role="form" action="/member/payroll/allowance/update_allowance" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Allowance Details</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="payroll_allowance_id" id="payroll_allowance_id" value="{{$allowance->payroll_allowance_id}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Allowance Name</small>
				<input type="text" name="payroll_allowance_name" step="any" class="form-control" required value="{{$allowance->payroll_allowance_name}}">
			</div>
			
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Amount</small>
				<input type="number" name="payroll_allowance_amount" class="form-control text-right" required value="{{$allowance->payroll_allowance_amount}}">
			</div>
			<div class="col-md-6">
				<small>Category</small>
				<select class="form-control" name="payroll_allowance_category">
					<option value="fixed" {{$allowance->payroll_allowance_category == 'fixed' ? 'selected' : ''}}>fixed</option>
					<option value="daily" {{$allowance->payroll_allowance_category == 'daily' ? 'selected' : ''}}>daily</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Add Every</small>
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_allowance_add_period"  value="First Period" {{$allowance->payroll_allowance_add_period == 'First Period' ? 'checked' : ''}}>First Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_allowance_add_period" value="Second Period" {{$allowance->payroll_allowance_add_period == 'Second Period' ? 'checked' : ''}}>Second Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_allowance_add_period" value="Last Period" {{$allowance->payroll_allowance_add_period == 'Last Period' ? 'checked' : ''}}>Last Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_allowance_add_period" value="Every Period" {{$allowance->payroll_allowance_add_period == 'Every Period' ? 'checked' : ''}}>Every Period</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<span><b>Affected Employee<a href="#" class="btn btn-custom-primary pull-right popup" link="/member/payroll/allowance/modal_allowance_tag_employee/{{$allowance->payroll_allowance_id}}'">Tag Employee</a></b></span>
			</div>
		</div>
		<div class="allowance-employee">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#active-emp"><i class="fa fa-star"></i>&nbsp;Active</a></li>
				<li><a data-toggle="tab" href="#archived-emp"><i class="fa fa-trash-o"></i>Archived</a></li>
			</ul>
			<div class="tab-content padding-top-10">
				<div id="active-emp" class="tab-pane fade in active">
					<table class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th>Employee Name</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($_active as $active)
							<tr>
								<td>
									{{$active->payroll_employee_title_name.' '.$active->payroll_employee_first_name.' '.$active->payroll_employee_middle_name.' '.$active->payroll_employee_last_name.' '.$active->payroll_employee_suffix_name}}
								</td>
								<td class="text-center">
									<a href="#" class="popup" size="sm" link="/member/payroll/allowance/modal_archived_llowance_employee/1/{{$active->payroll_employee_allowance_id}}"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div id="archived-emp" class="tab-pane fade">
					<table class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th>Employee Name</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($_archived as $archived)
							<tr>
								<td>
									{{$archived->payroll_employee_title_name.' '.$archived->payroll_employee_first_name.' '.$archived->payroll_employee_middle_name.' '.$archived->payroll_employee_last_name.' '.$archived->payroll_employee_suffix_name}}
								</td>
								<td class="text-center">
									<a href="#" class="popup" size="sm" link="/member/payroll/allowance/modal_archived_llowance_employee/0/{{$archived->payroll_employee_allowance_id}}"><i class="fa fa-refresh"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-custom-primary btn-submit" type="submit">Update</button>
	</div>
</form>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_allowance.js"></script>