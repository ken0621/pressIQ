<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Import Time Sheet</h4>
</div>
<div class="modal-body clearfix form-horizontal">
	<form class="form-group" action="/member/payroll/import_bio/template_dmsph" method="POST">
		<input type="hidden" value="{{csrf_token()}}" name="_token">
		<div class="col-md-6">
			<button class="btn btn-custom-primary">Download Template</button>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="biometric_name" name="biometric_name">
				<option value="name">Bio Metric Name here</option>
			</select>
		</div>
	</form>
	<div class="form-group">
		<div class="col-md-12">
			<label class="btn btm-custom-green"><input type="file" name="" id="bio-file" class="hide" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"></label>
		</div>
		<div class="col-md-12">
			<span class="file-name"></span>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
</div>
