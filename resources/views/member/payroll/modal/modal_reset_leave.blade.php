<!-- Change action, name and function-->
<form class="global-submit" role="form" action="/member/payroll/leave/v2/modal_leave_schedule_action" method="POST">
	
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Reset</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">

					<div class="col-md-12">
						<div class="radio">
							<label><input type="radio" name="payroll_leave_schedule_convert" value="convert_to_cash" checked>Convert to Cash</label>
						</div>
					</div>
					<div class="col-md-12">
						<div class="radio">
							<label><input type="radio" name="payroll_leave_schedule_accumulate" value="accumulate">Accumulate</label>
						</div>
					</div>
					<div class="col-md-12">
						<div class="radio">
							<label><input type="radio" name="payroll_leave_schedule_reset" value="reset">No Action, Just Reset</label>
						</div>
					</div>						

		</div>

	</div>	
	<div class="modal-footer">
		<button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-custom-primary btn-submit" type="submit">Apply</button>
	</div>
</form>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_leave_temp.js"></script>