<form class="global-submit" role="form" action="/member/payroll/branch_name/modal_update_branch" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Branch Location</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="branch_location_id" value="{{$branch->branch_location_id}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Branch Location</small>
				<input type="text" name="branch_location_name" class="form-control" placeholder="Branch Location" required value="{{$branch->branch_location_name}}">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-custom-primary btn-submit" type="submit">Update</button>
	</div>
</form>