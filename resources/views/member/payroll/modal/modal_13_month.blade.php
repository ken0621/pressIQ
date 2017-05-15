<form class="global-submit" role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Process 13 month</h4>
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-6">
				<small>Start</small>
				<input type="text" name="" class="form-control datepicker" placeholder="mm/dd/YYYY">
			</div>
			<div class="col-md-6">
				<small>End</small>
				<input type="text" name="" class="form-control datepicker" placeholder="mm/dd/YYYY">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Search by name</small>
				<div class="input-group">
					<span class="input-group-btn"><button class="btn btn-custom-primary"> <i class="fa fa-search"></i></button></span>
					<input type="search" name="" class="form-control">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Select By Department</small>
				<select class="form-control">
					<option value="">Select</option>
				</select>
			</div>
			<div class="col-md-6">
				<small>Select By Job Title</small>
				<select class="form-control">
					<option value="">Select</option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-12 employee-list-div"></div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
	</div>
</form>
<script type="text/javascript">
	$(".datepicker").datepicker();
</script>