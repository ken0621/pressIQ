<form class="global-submit" role="form" action="/member/payroll/company_list/modal_save_company" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Company</h4>
		<input type="hidden" name="_token" value="{{csrf_token()}}">
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Company Name</small>
				<input type="text" name="payroll_company_name" placeholder="Company Name" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Parent Company</small>
				<select class="form-control" name="payroll_parent_company_id">
					<option value="0">Select Parent</option>
					@foreach($_company as $company)
					<option value="{{$company->payroll_company_id}}">{{$company->payroll_company_name}}</option>
					@endforeach
				</select>
			</div>
		</div> 
		<div class="form-group">
			<div class="col-md-6">
				<small>Company Code</small>
				<input type="text" name="payroll_company_code" placeholder="Company Code" class="form-control" required>
			</div>
			<div class="col-md-6">
				<small>Company RDO</small>
				<select class="form-control" required name="payroll_company_rdo">
					<option value="">Select</option>
					@foreach($_rdo as $rdo)
					<option value="{{$rdo->payroll_rdo_id}}">{{$rdo->rdo_code.' - '.$rdo->rdo_location}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<small>Company Address</small>
				<input type="text" name="payroll_company_address" placeholder="Company Address" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Company Contact</small>
				<input type="text" name="payroll_company_contact" placeholder="Company Contact" class="form-control">
			</div>
			<div class="col-md-6">
				<small>Company Email</small>
				<input type="email" name="payroll_company_email" placeholder="Company Email" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Nature of Business</small>
				<input type="text" name="payroll_company_nature_of_business" placeholder="Nature of Business" class="form-control">
			</div>
			<div class="col-md-6">
				<small>Company Date Started</small>
				<input type="text" name="payroll_company_date_started" placeholder="Company Date Started" class="form-control datepicker">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Bank</small>
				<select class="form-control" name="payroll_company_bank">
					<option value="">Select Bank</option>
					@foreach($_bank as $bank)
					<option value="{{$bank->payroll_bank_convertion_id}}">{{$bank->bank_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Company TIN</small>
				<input type="text" name="payroll_company_tin" placeholder="Company TIN" class="form-control">
			</div>
			<div class="col-md-6">
				<small>Company SSS</small>
				<input type="text" name="payroll_company_sss" placeholder="Company SSS" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<small>Company Philhealth</small>
				<input type="text" name="payroll_company_philhealth" placeholder="Company Philhealth" class="form-control">
			</div>
			<div class="col-md-6">
				<small>Company PAGIBIG</small>
				<input type="text" name="payroll_company_pagibig" placeholder="Company PAGIBIG" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12 text-center">
				<img src="{{$company_logo}}" class="company_logo img-200-200">
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12 text-center">
				<div class="width-200px margin-auto">
					<div class="custom-progress-container margin-auto display-none">
						<div class="custom-progress"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12 text-center">
				<label class="btn btn-success"><input type="file" name="" class="hide" id="files" accept=".jpg, .JPG, .jpeg, .png, .gif, .bmp">Upload Logo</label>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-custom-primary btn-submit" type="submit">Save</button>
	</div>
</form>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_company.js"></script>