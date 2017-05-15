@extends('account_layout')
@section('account_content')
<form class="security" action="/account/security/change" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="security-line"></div>
	<div class="security-header">
		<i class="fa fa-unlock-alt"></i><div class="security-header-text"><span>Change</span> Password</div>
		<div class="message">{{ Session::get('message') }}</div>
	</div>
	<div class="security-content">
		<div class="field col-md-12">
			<div class="col-md-12">
				<div class="labels">New Password</div>
			</div>
			<div class="col-md-12"><input required type="password" name="npass" class="form-control"></div>
		</div>
		<div class="field col-md-12">
			<div class="col-md-12">
				<div class="labels">Confirm Password</div>
			</div>
			<div class="col-md-12"><input required type="password" name="cpass" class="form-control"></div>
		</div>
		<div class="field col-md-12">
			<div class="col-md-12">
				<div class="labels">Old Password</div>
			</div>
			<div class="col-md-12"><input required type="password" name="opass" class="form-control"></div>
		</div>
		<button class="security-button">Change Password</button>
	</div>
</form>
@endsection

@section('css')
<link rel="stylesheet" href="resources/assets/frontend/css/profile.css">
@endsection