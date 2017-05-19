<form class="global-submit" role="form" action="/member/payroll/payroll_period_list/modal_save_payroll_period" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Create Payroll Period</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body clearfix form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Payroll Tax Period</small>
				<select class="form-control" name="payroll_period_category" required>
					@foreach($_tax as $tax)
					<option value="{{$tax->payroll_tax_period}}">{{$tax->payroll_tax_period}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Period Start</small>
				<input type="text" name="payroll_period_start" class="datepicker form-control" required>
			</div>
			<div class="col-md-6">
				<small>Period End</small>
				<input type="text" name="payroll_period_end" class="datepicker form-control" required>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="submit">Next</button>
	</div>
</form>
<script type="text/javascript">
	$(".datepicker").datepicker();
</script>