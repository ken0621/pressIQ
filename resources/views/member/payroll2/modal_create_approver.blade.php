<form class="global-submit" role="form" action="/member/payroll/deduction/modal_save_deduction" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Approver</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<div class="checkbox col-md-4">
					<label><input type="checkbox" name="payroll_approver_overtime">Overtime Approver</label>
				</div>
				<div class="checkbox col-md-4">
					<label><input type="checkbox" name="payroll_approver_ob">Official Business Approver</label>
				</div>
				<div class="checkbox col-md-4">
					<label><input type="checkbox" name="payroll_approver_leave">Leave Approver</label>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-12">
				<span><b>Affected Employee</b><button class="btn btn-custom-primary pull-right popup" type="button" link="/member/payroll/deduction/modal_deduction_tag_employee/0" size="md">Tag Employee</button></span>
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
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>