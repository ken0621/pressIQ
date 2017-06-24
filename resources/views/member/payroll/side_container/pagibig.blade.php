<form class="form-horizontal global-submit" role="form" action="/member/payroll/pagibig_formula/pagibig_formula_save" method="POST">
	<h4>PAGIBIG / HDMF</h4>
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<div class="form-group">
		<div class="col-md-4">
			<small>Percentage</small>
			<input type="number" name="payroll_pagibig_percent" class="form-control text-right" value="{{$pagibig->payroll_pagibig_percent}}">
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			<button class="btn btn-primary pull-right">Save</button>
		</div>
	</div>
	
</form>