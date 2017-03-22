<form class="global-submit" role="form" action="/member/payroll/employee_list/modal_update_salary" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create New Salary</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="payroll_employee_salary_id" value="{{$salary->payroll_employee_salary_id}}">

	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-6">
				<small>Monthly Rate</small>
				<input type="number" name="payroll_employee_salary_monthly" step="any" class="form-control text-right" required placeholder="0.00" value="{{$salary->payroll_employee_salary_monthly}}">
			</div>
			<div class="col-md-6">
				<small>Daily Rate</small>
				<input type="number" step="any" name="payroll_employee_salary_daily" class="form-control text-right" placeholder="0.00" value="{{$salary->payroll_employee_salary_daily}}">
			</div>
			
		</div>
		
		<div class="form-group">
			<div class="col-md-6">
				<small>Taxable Salary</small>
				<input type="number" name="payroll_employee_salary_taxable" class="form-control text-right" step="any" placeholder="0.00" value="{{$salary->payroll_employee_salary_taxable}}">
			</div>
			<div class="col-md-6">
				<small>SSS Salary</small>
				<input type="number" name="payroll_employee_salary_sss" class="form-control text-right" step="any" placeholder="0.00" value="{{$salary->payroll_employee_salary_sss}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Philhealth Salary</small>
				<input type="number" name="payroll_employee_salary_philhealth" class="form-control text-right" step="any" placeholder="0.00" value="{{$salary->payroll_employee_salary_philhealth}}">
			</div>
			<div class="col-md-6">
				<small>Pagibig Salary</small>
				<input type="number" name="payroll_employee_salary_pagibig" class="form-control text-right" step="any" placeholder="0.00" value="{{$salary->payroll_employee_salary_pagibig}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>COLA (monthly)</small>
				<input type="number" step="any" name="payroll_employee_salary_cola" class="form-control text-right" placeholder="0.00" value="{{$salary->payroll_employee_salary_cola}}">
			</div>
			<div class="col-md-6">
				<small>Effective date</small>
				<input type="text" name="payroll_employee_salary_effective_date" class="form-control datepicker" value="{{$salary->payroll_employee_salary_effective_date != '0000-00-00' ?  date('m/d/Y', strtotime($salary->payroll_employee_salary_effective_date)):''}}">
			</div>
		</div>
		<div class="form-group">
			
			<div class="col-md-6">
				<div class="checkbox">
					<label><input type="checkbox" name="payroll_employee_salary_minimum_wage" value="1" {{$salary->payroll_employee_salary_minimum_wage == 1 ? 'checked':''}}>Minimum wage earner</label>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-custom-primary btn-submit" type="submit">Update</button>
	</div>
</form>
<script type="text/javascript">
	function submit_done(data)
	{
		
		// console.log(data.element);
		data.element.modal("toggle");
		executeFunctionByName(data.function_name, window);
		
	}
</script>