<form class="global-submit" role="form" action="/member/payroll/allowance/modal_save_allowances" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Allowance</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Allowance Name</small>
				<input type="text" name="payroll_allowance_name" class="form-control" required>
			</div>
			
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Amount</small>
				<input type="number" name="payroll_allowance_amount" class="form-control text-right" required>
			</div>
			<div class="col-md-6">
				<small>Category</small>
				<div class="form-control padding-b-37">
					<div class="col-md-6">
						<div class="radio">
							<label><input type="radio" name="payroll_allowance_category" value="fixed" checked>fixed</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="radio">
							<label><input type="radio" name="payroll_allowance_category" value="daily">daily</label>
						</div>
					</div>
					
				</div>
				
			
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<span><b>Affected Employee<a href="#" class="btn btn-custom-primary pull-right popup" link="/member/payroll/allowance/modal_allowance_tag_employee/0'">Tag Employee</a></b></span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<table class="table table-bordered table-condensed">
					<th>
						<tr>
							<th>Employee Name</th>
							<th width="5%"></th>
						</tr>
					</th>
					<tbody class="tbl-tag">
						
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
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_allowance.js"></script>