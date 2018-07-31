<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Export PDF</h4>
</div>
<div class="modal-body clearfix">
	<div class="row clearfix">
		<form class="pdf-filter-report">
			<div class="col-md-6">
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'unused')">Unused</a>
				</div>
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'reserved')">Reserved</a>
				</div>
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'blocked')">Blocked</a>
				</div>
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'sold')">Sold</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'printed')">Printed</a>
				</div>
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'released')">Released</a>
				</div>
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'distributed')">Distributed</a>
				</div>
				<div class="form-check">
				  <a href="javascript:" onclick="pdf_report_file('per_file_in_pdf', 'used')">Used</a>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
</div>

<script type="text/javascript" src="http://danml.com/js/download.js"></script>
<script type="text/javascript">
function pdf_report_file(type, filter_type)
{
    var link        = $("form.filter").attr("action");
    var serialize   = $("form.filter").serialize();
	var linkz 		= link + '?' + serialize + '&report_type=' + type + "&filter_type=" + filter_type;
	window.open(linkz, "_blank");
}
</script>