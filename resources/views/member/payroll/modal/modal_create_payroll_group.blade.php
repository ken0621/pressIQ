<form class="global-submit form-horizontal" role="form" action="" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Create Payroll</h4>
	</div>
	<div class="modal-body clearfix">
		
		
		<div class="form-group">
			<div class="col-m-d12">
				<ul class="nav nav-tabs nav-tabs-custom">
				  <li class="active"><a data-toggle="tab" href="#basic">Basic</a></li>
				  <li><a data-toggle="tab" href="#deduction-basis">Deduction Basis</a></li>
				  <li><a data-toggle="tab" href="#over-time-rates">Over Time Rates</a></li>
				  <li><a data-toggle="tab" href="#shifting">Shifting</a></li>
				  <li><a data-toggle="tab" href="#13month">13 Month</a></li>
				</ul>

				<div class="tab-content tab-content-custom tab-pane-div margin-bottom-0">
				  <div id="basic" class="tab-pane fade in active form-horizontal">
					    <div class="form-group">
							<div class="col-md-4">
								<small>Payroll Code</small>
								<input type="text" name="" class="form-control">
							</div>
							<div class="col-md-4">
								<small>Working Days(Per Month)</small>
								<input type="number" name="" class="form-control text-right">
							</div>
							<div class="col-md-4">
								<small>Working Hours(Per day):</small>
								<input type="number" name="" class="form-control text-right">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4">
								<small>Salary Computation</small>
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="radio">
											<label><input type="radio" name="salary_computation">Flat Rate</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="salary_computation">Daily</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<small>Payroll Period</small>
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="radio">
											<label><input type="radio" name="payroll_period">Weekly</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_period">Semi-Monthly</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="payroll_period">Monthly</label>
										</div>
									</div>
								</div>
							</div>
						</div>
				  </div>
				  <div id="deduction-basis" class="tab-pane fade">
				    
				  </div>
				  <div id="over-time-rates" class="tab-pane fade">
				    
				  </div>
				  <div id="shifting" class="tab-pane fade">
				    
				  </div>
				  <div id="13month" class="tab-pane fade">
				    
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