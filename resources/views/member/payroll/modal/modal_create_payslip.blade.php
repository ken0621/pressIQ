<form class="global-submit " role="form" action="" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Custom Payslip</h4>
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-4">
				<div class="panel panel-default background-white">
					<div class="panel-body ">
						<div class="form-group">
							<div class="col-md-6">
								<small>Paper width (cm)</small>
								<input type="number" name="" placeholder="0" min="1" class="form-control text-right paper-width" step="any">
							</div>
							<div class="col-md-6">
								<small>Paper height (cm)</small>
								<input type="number" name="" placeholder="0" min="1" class="form-control text-right paper-height" step="any">
							</div>
						</div>
						<!-- <div class="form-group">
							<div class="col-md-12">
								<small>Paper orientation</small>
								<select class="form-control paper-orientation">
									<option value="Landscape">Landscape</option>
									<option value="Portrait">Portrait</option>
								</select>
							</div>
						</div> -->
						<div class="form-group">
							<div class="col-md-12">
								<small>Payslip width (%)</small>
								<input type="number" name="" class="form-control text-right payslip-width" placeholder="0" min="1" value="50" step="any">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<small>Copy per page</small>
								<input type="number" name="" value="1" min="1" class="form-control text-right copy-per-page" placeholder="0" >
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="checkbox">
									<label><input type="checkbox" name="" class="time-summary">Include Time Summary</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="checkbox">
									<label><input type="checkbox" name="" class="company-name-logo">Include Company Name and Logo</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-12">
								<small>Company Name and Logo Template</small>
								<div class="list-group">
								  <a href="#" class="list-group-item active">
								  	<img src="/assets/images/noimage.png" class="img30x30">&nbsp;<span class="margin-top-10px  pos-absolute">Company Name</span>
								  </a>
								  <a href="#" class="list-group-item text-right">
								  	<span class="margin-top-10px  pos-absolute" style="right: 49px">Company Name</span>&nbsp;<img src="/assets/images/noimage.png" class="img30x30">
								  </a>
								  <a href="#" class="list-group-item text-center">
								  	<img src="/assets/images/noimage.png" class="img30x30"><br>
								  	Company Name
								  </a>
								  <a href="#" class="list-group-item">
								  	Company Name
								  </a>
								  <a href="#" class="list-group-item text-right">
								  	Company Name
								  </a>
								  <a href="#" class="list-group-item text-center">
								  	Company Name
								  </a>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default background-white">
					<div class="panel-heading">Payslip Preview</div>
					<div class="panel-body">
						<div class="payslip-div paper-portrait">
							<div class="payslip-gray-dotted width-25-n payslip-container height-50">
								<div class="width-50 padding-5 height-100">
									<div class="payslip-div"></div>
								</div>
								<div class="width-50 padding-5 height-100">
									<div class="payslip-div"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
	</div>
</form>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_payslip.js"></script>