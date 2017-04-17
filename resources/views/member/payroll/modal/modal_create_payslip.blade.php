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
							<div class="col-md-12">
								<small>Paper width</small>
								<input type="number" name="" placeholder="0" min="1" class="form-control text-right" step="any">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<small>Paper orientation</small>
								<select class="form-control">
									<option value="Landscape">Landscape</option>
									<option value="Landscape">Portrait</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<small>Payslip size</small>
								<input type="number" name="" class="form-control text-right" placeholder="0" width="1" step="any">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<small>Copy per page</small>
								<input type="number" name="" min="1" class="form-control text-right" placeholder="0" >
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="checkbox">
									<label><input type="checkbox" name="">Include Time Summary</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="checkbox">
									<label><input type="checkbox" name="">Include Company Name and Logo</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-12">
								<small>Company Name and Logo Template</small>
								<div class="list-group">
								  <a href="#" class="list-group-item">
								  	<img src="/assets/images/noimage.png" class="img30x30">&nbsp;Company Name
								  </a>
								  <a href="#" class="list-group-item text-right">
								  	Company Name&nbsp;<img src="/assets/images/noimage.png" class="img30x30">
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
						<div class="payslip-div"></div>
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