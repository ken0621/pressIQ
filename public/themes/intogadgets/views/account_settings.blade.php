@extends('account_layout')
@section('account_content')
<form class="settings-container" action="/account/settings/change" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="setting-line"></div>
	<div class="setting-header"><i class="fa fa-cog"></i><span>Account</span> Setting</div>
	<div class="message">{{ Session::get('message') }}</div>
	<div class="setting-content">
		<div class="field">
			<div class="col-md-12 primia-gallery main-image" target_input=".profile-image-input" target_image=".profile-image-img">
			    <img class="pull-right profile-image-img" src="">
			    <input class="hidden profile-image-input text-center top-space-small borderless" name="profile-pix" value="" type="text">
	        </div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">Full Name</div>
			</div>
			<div class="col-md-9"><input required type="text" name="fn" class="form-control" value=""></div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">Birthday</div>
			</div>
			<div class="col-md-3">
				<select name="mm" class="form-control">
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>
			</div>
			<div class="col-md-3">
				<select name="dd" class="form-control">
					@for($birthday = 1; $birthday <= 31; $birthday++)
						<option> 
							{{ $birthday }}
						</option>
					@endfor	
				</select>
			</div>
			<div class="col-md-3">
				<select name="yy" class="form-control">
					@for($birthday=(date("Y")-120);$birthday<=date("Y");$birthday++)
						<option>
							{{ $birthday }}
						</option>
					@endfor
				</select>
			</div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">Email</div>
			</div>
			<div class="col-md-9"><input type="email" name="ea" class="form-control" value=""></div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">Gender</div>
			</div>
			<div class="col-md-9" style="padding-top: 5px; padding-bottom: 5px;">
				<div style="display: inline-block; margin-right: 20px;"><input type="radio" name="gender" style="display: inline-block; vertical-align: middle; margin: 0 10px;" value="Male" id="m"><label for="m" style="display: inline-block; vertical-align: middle; margin: 0;">Male</label></div>
				<div style="display: inline-block;"><input type="radio" name="gender" style="display: inline-block; vertical-align: middle; margin: 0 10px;" value="Female" id="fm"><label for="fm" style="display: inline-block; vertical-align: middle; margin: 0;">Female</label></div>
			</div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">Address</div>
			</div>
			<div class="col-md-9"><input type="text" name="address" class="form-control" value=""></div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">Province</div>
			</div>
			<div class="col-md-9">
				<select name="p_id" class="form-control province load-child-location" target=".municipality">
					<option value=""></option>
				</select>
			</div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">City/Municipality</div>
			</div>
			<div class="col-md-9">
				<select name="m_id" class="form-control municipality load-child-location" target=".barangay">						
					<option value=""></option>
				</select>
			</div>
		</div>
		<div class="field">
			<div class="col-md-3">
				<div class="labels">Barangay</div>
			</div>
			<div class="col-md-9">
				<select name="b_id" class="form-control barangay">
					<option value=""></option>
				</select>
			</div>
		</div>
		<button class="setting-button">Update Data</button>
	</div>
</form>
@endsection
@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/profile.css">
@endsection

@section('script')
<script type = "text/javascript" src="resources/assets/rutsen/js/birthday.js"></script>
<script type="text/javascript" src="resources/assets/rutsen/js/checkout.js"></script>
<script type="text/javascript" src="/resources/assets/primia/primia-admin.js"></script>
@endsection	