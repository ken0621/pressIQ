<form class="global-submit" role="form" action="/member/payroll/deduction/modal_save_deduction" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Deduction</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="payroll_deduction_id" value="{{$deduction->payroll_deduction_id}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Deduction Name</small>
				<input type="text" name="payroll_deduction_name" class="form-control" value="{{$deduction->payroll_deduction_name}}" required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Deduction Amount</small>
				<input type="number" name="payroll_deduction_amount" class="form-control text-right" step="any" required value="{{$deduction->payroll_deduction_amount}}">
			</div>
			
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Monthly Amortization</small>
				<input type="number" name="payroll_monthly_amortization" class="form-control text-right" step="any" required value="{{$deduction->payroll_monthly_amortization}}">
			</div>
			<div class="col-md-6">
				<small>Periodical Deduction</small>
				<input type="number" name="" class="form-control text-right" step="any" required value="{{$deduction->payroll_periodal_deduction}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Date filed</small>
				<input type="text" name="payroll_deduction_date_filed" class="form-control datepicker" required value="{{date('m/d/Y',strtotime($deduction->payroll_deduction_date_filed))}}">
			</div>
			<div class="col-md-6">
				<small>Date start</small>
				<input type="text" name="payroll_deduction_date_start" class="form-control datepicker" required value="{{date('m/d/Y',strtotime($deduction->payroll_deduction_date_start))}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Deduct Every</small>
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_deduction_period" value="First Period" {{$deduction->payroll_deduction_period == 'First Period' ? 'checked':''}}>First Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_deduction_period" value="Second Period" {{$deduction->payroll_deduction_period == 'Second Period' ? 'checked':''}}>Second Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_deduction_period" value="Every other Period" {{$deduction->payroll_deduction_period == 'Every other Period' ? 'checked':''}}>Every other Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_deduction_period" checked value="Every Period" {{$deduction->payroll_deduction_period == 'Every Period' ? 'checked':''}}>Every Period</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Category</small>
				<select class="form-control deduction-category-change" name="payroll_deduction_category" required>
					<option value="">Select Category</option>
					<option value="Cash Advance" {{$deduction->payroll_deduction_category == 'Cash Advance' ? 'selected="selected"':''}}>Cash Advance</option>
					<option value="Cash Bond" {{$deduction->payroll_deduction_category == 'Cash Bond' ? 'selected="selected"':''}}>Cash Bond</option>
					<option value="Loans" {{$deduction->payroll_deduction_category == 'Loans' ? 'selected="selected"':''}}>Loans</option>
					<option value="Other Deduction" {{$deduction->payroll_deduction_category == 'Other Deduction' ? 'selected="selected"':''}}>Other Deduction</option>
				</select>
			</div>
			<div class="col-md-6">
				<small>Type</small>
				<div class="input-group">
					<select class="form-control select-deduction-type" name="payroll_deduction_type" required>
						<option value="">Select Type</option>
						@foreach($_type as $type)
						<option value="{{$type->payroll_deduction_type_id}}" {{$deduction->payroll_deduction_type == $type->payroll_deduction_type_id ? 'selected="selected"':''}}>{{$type->payroll_deduction_type_name}}</option>
						@endforeach
					</select>
					<span class="input-group-btn">
						<a href="#" type="button" class="btn btn-custom-primary btn-add-type" link=""><i class="fa fa-plus"></i></a>
					</span>
				</div>
				
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Remarks</small>
				<textarea class="form-control textarea-expand" name="payroll_deduction_remarks">{{$deduction->payroll_deduction_remarks}}</textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-12">
				<span><b>Affected Employee</b><button class="btn btn-custom-primary pull-right popup" type="button" link="/member/payroll/deduction/modal_deduction_tag_employee">Tag Employee</button></span>
			</div>
		</div>
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#active-employee">Active</a></li>
		  <li><a data-toggle="tab" href="#zero-employee">Zero Balance</a></li>
		  <li><a data-toggle="tab" href="#canceled-employee">Canceled</a></li>
		</ul>

		<div class="tab-content padding-top-10">
		  <div id="active-employee" class="tab-pane fade in active">
		  	<table class="table table-condensed table-bordered">
		  		<thead>
					<tr>
						<th>Employee Name</th>
						<th>Balance</th>
						<th width="5%"></th>
					</tr>
				</thead>
				<tbody class="table-employee-tag">
				@foreach($emp['active'] as $active)
				<tr>
					<td>
						{{$active['deduction']->payroll_employee_title_name.' '.$active['deduction']->payroll_employee_first_name.' '.$active['deduction']->payroll_employee_middle_name.' '.$active['deduction']->payroll_employee_last_name.' '.$active['deduction']->payroll_employee_suffix_name}}
					</td>
					<td class="text-right">
						{{number_format($active['balance'], 2)}}
					</td>
					<td class="text-center">
						<a href="#" payroll_deduction_employee_id><i class="fa fa-times"></i></a>
					</td>
				</tr>
				@endforeach
				</tbody>
		  	</table>
		  </div>
		  <div id="zero-employee" class="tab-pane fade">
		  	<table class="table table-condensed table-bordered">
		  		<thead>
					<tr>
						<th>Employee Name</th>
						<th>Balance</th>
						<th width="5%"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($emp['zero'] as $zero)
				<tr>
					<td>
						{{$zero['deduction']->payroll_employee_title_name.' '.$zero['deduction']->payroll_employee_first_name.' '.$zero['deduction']->payroll_employee_middle_name.' '.$zero['deduction']->payroll_employee_last_name.' '.$zero['deduction']->payroll_employee_suffix_name}}
					</td>
					<td class="text-right">
						{{number_format($zero['balance'], 2)}}
					</td>
					<td class="text-center">
						<a href="#" payroll_deduction_employee_id><i class="fa fa-times"></i></a>
					</td>
				</tr>
				@endforeach
				</tbody>
		  	</table>
		  </div>
		  <div id="canceled-employee" class="tab-pane fade">
		    <table class="table table-condensed table-bordered">
		  		<thead>
					<tr>
						<th>Employee Name</th>
						<th>Balance</th>
						<th width="5%"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($emp['cancel'] as $cancel)
				<tr>
					<td>
						{{$cancel['deduction']->payroll_employee_title_name.' '.$cancel['deduction']->payroll_employee_first_name.' '.$cancel['deduction']->payroll_employee_middle_name.' '.$cancel['deduction']->payroll_employee_last_name.' '.$cancel['deduction']->payroll_employee_suffix_name}}
					</td>
					<td class="text-right">
						{{number_format($cancel['balance'], 2)}}
					</td>
					<td class="text-center">
						<a href="#" payroll_deduction_employee_id><i class="fa fa-times"></i></a>
					</td>
				</tr>
				@endforeach
				</tbody>
		  	</table>
		  </div>
		</div>
		
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-custom-primary btn-submit" type="submit">Save</button>
	</div>
</form>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_deduction.js"></script>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>