@extends("mlm.register.layout")
@section("content")

<div class="container-fluid">
	<div class="register">
		<div class="title">Create a Brown ID</div>
		<div class="sub">Nulla dolor lacus, viverra sed laoreet a, tristique ut elit.</div>
		<form method="post" class="register-submit" action="/member/register/submit" >
		{!! csrf_field() !!}
			<div class="form-container">
				<div class="row clearfix">
					<div class="col-md-6">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control input-lg" name="first_name" value="{{Request::old('first_name')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control input-lg" name="last_name" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control input-lg" name="email" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Contact Number</label>
							<input type="text" class="form-control input-lg" name="contact_number" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Tin No.</label>
							<input type="text" class="form-control input-lg" name="tin_number" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Country</label>
							<select class="form-control input-lg" name="country" required>
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
							<input type="text" class="form-control input-lg" name="username" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Sponsor (Optional)</label>
							<input type="text" class="form-control input-lg" name="sponsor" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control input-lg" name="password">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" class="form-control input-lg" name="password_confirm">
						</div>
					</div>
				</div>
			</div>
			<div class="button-holder">
				<div class="agreement">
					<div class="checkbox">
					  <label><input type="checkbox" value="1" name="terms"> I agree to the Brown <span>Terms of Use</span> and <span>Privacy Policy</span></label>
					</div>
				</div>
				<div class="main">
					<button class="btn btn-green btn-lg">SIGN UP</button>
					</form>
					<div class="already">Already have an account</div>
					<button class="btn btn-black btn-lg">LOGIN AN ACCOUNT</button>
				</div>
			</div>
		
	</div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/assets/mlm/css/register.css">
@endsection
@section('script')
<script type="text/javascript">
	$(document).on("submit", ".register-submit", function(e)
        {
            var data = $(e.currentTarget).serialize();
            var link = $(e.currentTarget).attr("action");
            $('#load').removeClass('hide');
            submit_form_register(link, data);
            e.preventDefault();
            
        })
	function submit_form_register(link, data)
    {
        
        $.ajax({
            url:link,
            dataType:"json",
            data:data,
            type:"post",
            success: function(data)
            {
            	$('#load').addClass('hide');
            	if(data.status == 'warning')
            	{
            		var message = data.message;
            		$.each( message, function( index, value ){
					    toastr.warning(value);
					});
            	}
            	else if(data.status == 'success')
            	{
						window.location = data.link;            		
            	}
            },
            error: function()
            {
                $('#load').addClass('hide');
            }
        })
    }
</script>
@endsection