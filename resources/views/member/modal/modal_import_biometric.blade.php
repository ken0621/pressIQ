<html lang="en">
<head>

</head>
<body>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title"><i class="fa fa-calendar color-green" aria-hidden="true"></i>&nbsp;Import From Biometric</h4>
	</div>
	<div class="modal-body clearfix form-horizontal">

		<div class="row">
			<div class="col-md-5">
				<small>Date From</small>
				<input type="text" name="date_from" class="form-control datepicker date_from">
			</div>

			<div class="col-md-5">
				<small>Date To</small>
				<input type="text" name="date_to" class="form-control datepicker date_to">
			</div>

			<div class="col-md-2">
				<button class="btn btn-primary btn-import-data" style="margin-top: 20px">Import</button>
			</div>
		</div>
		<div class="report-import">
			
		</div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
	</div>
</body>
</html>

<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>

<script type="text/javascript" src="/assets/member/js/payroll/payroll_biometric.js"></script>
<script type="text/javascript">
	$(".datepicker").datepicker();
</script>
