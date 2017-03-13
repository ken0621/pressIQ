@extends("mlm.register.layout")
@section("content")
<div class="container-fluid">
	<div class="register">
		<div class="title">Create a Brown ID</div>
		<div class="sub">Nulla dolor lacus, viverra sed laoreet a, tristique ut elit.</div>
		<form method="post" action="/member/register/submit" onsubmit="validateMyForm();">
		{!! csrf_field() !!}
			<div class="form-container">
				<div class="row clearfix">
					<div class="col-md-6">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Company (Optional)</label>
							<input type="text" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Tin No. (Optional)</label>
							<input type="text" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Country</label>
							<select class="form-control input-lg">
								@foreach($country as $value)
	                                <option value="{{$value->country_id}}" @if($value->country_id == 420) selected @endif >{{$value->country_name}}</option>
	                            @endforeach							
	                        </select>
						</div>
					</div>
				</div>
			</div>
			<div class="form-container second">
				<div class="row clearfix">
					<div class="col-md-6">
						<div class="form-group">
							<label>Username</label>
							<input type="text" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Membership Code of Sponsor (Optional)</label>
							<input type="text" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control input-lg">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" class="form-control input-lg">
						</div>
					</div>
				</div>
			</div>
			<div class="button-holder">
				<div class="agreement">
					<div class="checkbox">
					  <label><input type="checkbox" value=""> I agree to the Brown <span>Terms of Use</span> and <span>Privacy Policy</span></label>
					</div>
				</div>
				<div class="main">
					<button class="btn btn-green btn-lg">SIGN UP</button>
					<div class="already">Already have an account</div>
					<button class="btn btn-black btn-lg">LOGIN AN ACCOUNT</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register.css">
@endsection
@section('script')
<script type="text/javascript">
	function validateMyForm()
	{
		event.preventDefault();
	}
</script>
@endsection