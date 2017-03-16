<form class="global-submit" role="form" action="/member/payroll/departmentlist/modal_update_department" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Deduction</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Deduction Name</small>
				<input type="text" name="payroll_deduction_name" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Deduction Amount</small>
				<input type="number" name="payroll_deduction_amount" class="form-control text-right" step="any" required>
			</div>
			
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Monthly Amortization</small>
				<input type="number" name="payroll_monthly_amortization" class="form-control text-right" step="any" required>
			</div>
			<div class="col-md-6">
				<small>Periodical Deduction</small>
				<input type="number" name="payroll_periodal_deduction" class="form-control text-right" step="any" required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Date filed</small>
				<input type="text" name="payroll_deduction_date_filed" class="form-control datepicker">
			</div>
			<div class="col-md-6">
				<small>Date start</small>
				<input type="text" name="payroll_deduction_date_start" class="form-control datepicker">
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
									<label><input type="radio" name="payroll_deduction_period" value="First Period">First Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_deduction_period" value="Second Period">Second Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_deduction_period" value="Every other Period">Every other Period</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="radio">
									<label><input type="radio" name="payroll_deduction_period" checked value="Every Period">Every Period</label>
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
					<option value="Cash Advance">Cash Advance</option>
					<option value="Cash Bond">Cash Bond</option>
					<option value="Loans">Loans</option>
					<option value="Other Deduction">Other Deduction</option>
				</select>
			</div>
			<div class="col-md-6">
				<small>Type</small>
				<div class="input-group">
					<select class="form-control select-deduction-type" name="payroll_deduction_type" required>
						<option value="">Select Type</option>
					</select>
					<span class="input-group-btn">
						<a href="#" type="button" class="btn btn-custom-primary btn-add-type" link=""><i class="fa fa-plus"></i></a>
					</span>
				</div>
				
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-12">
				<span><b>Affected Employee</b><button class="btn btn-custom-primary pull-right popup" type="button" link="/member/payroll/deduction/modal_deduction_tag_employee">Tag Employee</button></span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<table class="table table-condensed table-bordered">
					<thead>
						<tr>
							<th>Employee Name</th>
							<th width="5%"></th>
						</tr>
					</thead>
					<tbody class="table-employee-tag">
						
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