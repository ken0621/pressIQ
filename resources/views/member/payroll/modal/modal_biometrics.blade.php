<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title"><i class="fa fa-file-excel-o color-green" aria-hidden="true"></i>&nbsp;Import Time Sheet</h4>
</div>
<div class="modal-body clearfix form-horizontal">
	<form class="form-group" action="/member/payroll/import_bio/template_global" method="GET">
		<input type="hidden" value="{{csrf_token()}}" class="_token" name="_token">
		<div class="col-md-6">
			<button class="btn btn-custom-primary">Download Template</button>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="biometric_name" name="biometric_name">
				<option value="ZKTime 5.0">ZKTime 5.0</option>
				<option value="Digital Persona">Digital Persona</option>
				<option value="C7">C7</option>
			</select>
		</div>
	</form>
	<div class="form-group">
		<div class="col-md-12">
			<label class="btn btm-custom-green"><input type="file" name="" id="bio-file" class="hide" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, text/plain">Choose File</label>
		</div>
		<div class="col-md-12">
			<i><span class="file-name"></span></i>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<button class="btn btn-custom-primary btn-import">Import File</button>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12 import-status">
			
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
</div>
<script type="text/javascript" src="/assets/member/js/payroll/modal_biometrics.js"></script>