<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title"><i class="fa fa-file-excel-o color-green" aria-hidden="true"></i>&nbsp;Import Time Sheet</h4>
</div>
<div class="modal-body clearfix form-horizontal">
	<form class="form-group" action="/member/payroll/shift_template/company_template" method="GET">
		<input type="hidden" value="{{csrf_token()}}" class="_token" name="_token">
		<div class="col-md-6">
			<button class="btn btn-custom-primary">Download Template</button>
		</div>
		{{-- <div class="col-md-6">
			<select class="form-control" id="template_name" name="template_name">
				<option value="Template 1">Template 1</option>
				<option value="Template 2">Template 2</option>
				<option value="Template 3">Template 3</option>
			</select>
		</div> --}}
	</form>
	<div class="form-group">
		<div class="col-md-6">
			<label class="btn btm-custom-green"><input type="file" name="" id="temp-file" class="hide" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, text/plain, .dat">Choose File</label>
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
<script type="text/javascript" src="/assets/js/modal_shift_import_template.js"></script>
<script type="text/javascript" src="/assets/member/js/payroll/payrollconfiguration.js"></script>
