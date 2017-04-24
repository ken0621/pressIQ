<form class="global-submit " role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">TITLE HERE</h4>
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-6">
				<small>Schedule date</small>
				<input type="text" name="" class="date_picker form-control">
			</div>
			<div class="col-md-6">
				<small>Leave Name</small>
				<select class="form-control">
					<option value="">Select leave</option>
				</select>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
	</div>
</form>
<script type="text/javascript">
	$(".date_picker").datepicker();
</script>