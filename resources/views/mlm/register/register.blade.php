@extends("mlm.register.layout")
@section("content")
<style type="text/css">
	.uppercase_input_text
	{
		text-transform:uppercase;
	}
</style>
<div class="container-fluid">
	<div class="register">
		<div class="title"><b><h1>CHANGE</h1><h3>HAPPENS HERE</h3></b><h5>Join & be part of the biggest movement</h5></div>
		<form method="post" class="register-submit" action="/member/register/submit" >
			{!! csrf_field() !!}
			<div class="form-container">
				<div class="row clearfix">
					<div class="col-md-6">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control input-lg uppercase_input_text" name="first_name" value="{{ Request::old('first_name') ? Request::old('first_name') : ( isset($current['tbl_customer']['first_name']) ? $current['tbl_customer']['first_name'] : '' ) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Middle Name</label>
							<input type="text" class="form-control input-lg uppercase_input_text" name="middle_name" value="{{ Request::old('middle_name') ? Request::old('middle_name') : ( isset($current['tbl_customer']['middle_name']) ? $current['tbl_customer']['middle_name'] : '' ) }}" required>
						</div>
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control input-lg uppercase_input_text" name="last_name" value="{{ Request::old('last_name') ? Request::old('last_name') : ( isset($current['tbl_customer']['last_name']) ? $current['tbl_customer']['last_name'] : '' ) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Contact Number</label>
							<input type="text" class="form-control input-lg" name="contact_number" value="{{ Request::old('contact_number') ? Request::old('contact_number') : ( isset($current['tbl_customer']['customer_contact']) ? $current['tbl_customer']['customer_contact'] : '' ) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						
						<div class="form-group">
							<label>Date of Birth</label>
							<input type="date" class="form-control input-lg" name="date_of_birth" value="{{ Request::old('date_of_birth') ? Request::old('date_of_birth') : ( isset($current['tbl_customer']['date_of_birth']) ? $current['tbl_customer']['date_of_birth'] : '' ) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Country</label>
							@foreach($country as $value)
								@if($value->country_id == 420)
									<input type="text" class="form-control input-lg" value="{{$value->country_name}}" readonly>
									<input type="hidden" name="country" value="{{$value->country_id}}">
								@endif
							@endforeach
							<!-- <select class="form-control input-lg" name="country" required>
								@foreach($country as $value)
	                                <option value="{{$value->country_id}}" @if($value->country_id == 420) selected @endif >{{$value->country_name}}</option>
	                            @endforeach							
	                        </select> -->
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Permanent Address</label>
							<!-- <input type="text" class="form-control input-lg" name="permanent_address" value="{{ Request::old('permanent_address') ? Request::old('permanent_address') : ( isset($current['tbl_customer']['permanent_address']) ? $current['tbl_customer']['permanent_address'] : '' ) }}" required> -->
							<textarea class="form-control input-lg" name="permanent_address">{{ Request::old('permanent_address') ? Request::old('permanent_address') : ( isset($current['tbl_customer']['permanent_address']) ? $current['tbl_customer']['permanent_address'] : '' ) }}</textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Gender</label>
							<div class="row clearfix">
								<div class="col-md-12">
									<div class="form-group">
										<label><input type="radio" name="gender"  value="Male" checked> Male</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label><input type="radio" name="gender" value="Female"> Female</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>E-Mail</label>
							<input type="email" class="form-control input-lg" name="email" value="{{ Request::old('email') ? Request::old('email') : ( isset($current['tbl_customer']['email']) ? $current['tbl_customer']['email'] : '' ) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Confirm E-Mail</label>
							<input type="email" class="form-control input-lg" name="confirm_email" value="{{ Request::old('confirm_email') ? Request::old('confirm_email') : ( isset($current['tbl_customer']['confirm_email']) ? $current['tbl_customer']['confirm_email'] : '' ) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Tin</label>
							<input type="text" pattern="[0-9.]+" onkeypress="return checkDigit(event, $(this))" class="form-control input-lg tin_number_confirm" name="tin_number" value="{{ Request::old('tin_number') ? Request::old('tin_number') : ( isset($current['tbl_customer']['tin_number']) ? $current['tbl_customer']['tin_number'] : '' ) }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Confirm Tin</label>
							<input type="text" pattern="[0-9.]+" onkeypress="return checkDigit(event, $(this))" class="form-control input-lg tin_number_confirm_2" name="confirm_tin_number" value="{{ Request::old('confirm_tin_number') ? Request::old('confirm_tin_number') : ( isset($current['tbl_customer']['confirm_tin_number']) ? $current['tbl_customer']['confirm_tin_number'] : '' ) }}" required>
						</div>
					</div>
					
					
					<div class="col-md-6">
						<div class="form-group">

							<label> Referror/Upline</label>

							<input type="text" class="form-control input-lg" name="sponsor" value="{{ Request::old('slot_sponsor') ? Request::old('slot_sponsor') : ( isset($current['tbl_mlm_slot']['slot_sponsor']) ? $current['tbl_mlm_slot']['slot_sponsor'] : '' ) }}" 
							{{$sponsor_r == 1 ? 'required' : ''}}
							onChange="get_sponsor(this)"
							>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group reforrer_get">
							
						</div>
					</div>
				</div>
			</div>
			<div class="form-container third hide">
				<div class="row clearfix text-center">
					<div class="col-md-6">
						<div class="form-group">
							<label><input type="radio" name="customer_type" onclick="toggle('.corporate-type','personal', this)" value="0"> Individual</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><input type="radio" name="customer_type" onclick="toggle('.corporate-type','corporate', this)" value="1"> Corporate</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-container fourth corporate-type" style="display: none" >
				<div class="row clearfix">
					<div class="col-md-12">
						<div class="form-group">
							<label>Company</label>
							<input type="text" class="form-control input-lg" name="company">
						</div>
					</div>
				</div>
			</div>
			<div class="button-holder">
				<div class="agreement">
					<div class="checkbox">
					  <label><input type="checkbox" class="check_box_terms" value="1" name="terms"> I agree to the Brown <span>Terms of Use</span> and <span>Privacy Policy</span></label>
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
<!-- Modal -->
<div class="modal fade" id="modal_terms_and_agreement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        {!! isset($terms_and_agreement->settings_value) ? $terms_and_agreement->settings_value : '' !!}
        <br>
        <center><button href="javascript:" class="btn_i_agree_modal modal-button btn btn-green btn-lg">I agree to the Brown Terms of Use and Privacy Policy</button></center>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_resend_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	
    <form class="form-horizontal put-action-here">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	    <div class="modal-content">
		    <div class="modal-header" >
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title layout-modallarge-title item_title">Email Verification</h4>
		    </div>
		    <div class="modal-body">
		      	<h4>
		      	Your email is already used (You already have an account). 
		      	In order to use your account click the resend button below. <br><br>
		      	Your username and password will be sent to your email. 
		      	Once you recieve the email, a login link will be provided. <br><br>
		      	After you are logged in you can click New Purchase to purchase using your account.
		      	</h4>
		    </div>
	        <div class="modal-footer" >
	            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            <button class="btn btn-success" type="submit" data-url="">Resend Verification Email</button>
	        </div>
	    </div>
    </form>
  </div>
</div>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="assets/mlm/css/register.css">
<style type="text/css">
	.modal-body {
    max-height: calc(100vh - 212px);
    overflow-y: auto;
	}
	.modal-button
	{
		color: #21cc21;
    	border-color: #21cc21;
    	background-color: transparent;
	}
</style>
@endsection
@section('script')
<script type="text/javascript">
$('.check_box_terms').on('click', function(){
	$('.check_box_terms').prop('checked', false); 
	$('#modal_terms_and_agreement').modal('toggle');
});
$('.btn_i_agree_modal').on('click', function(){
	$('.check_box_terms').prop('checked', true); 
	$('#modal_terms_and_agreement').modal('toggle');
});

function checkDigit (e, ito) 
{
    if ((e.which < 48 || e.which > 57) && (e.which !== 8) && (e.which !== 0)) {
        return false;
    }

    var current = $(ito).val();
    if(current.length >= 9)
    {
        return false;
    }
    return true;
}

	function toggle(className,type, obj) 
	{
		if(type == 'personal')
		{
			$(className).slideUp()
		}
		if(type == 'corporate')
		{
			$(className).slideDown()
		}
    }
	$(document).on("submit", ".register-submit", function(e)
        {
        	var tin_number_confirm = $('.tin_number_confirm').val();
        	var tin_number_confirm_2 = $('.tin_number_confirm_2').val();
        	var data = $(e.currentTarget).serialize();
	        var link = $(e.currentTarget).attr("action");
	        
        	if( tin_number_confirm.length == 9 && tin_number_confirm_2.length == 9)
        	{
	            $('#load').removeClass('hide');
	            submit_form_register(link, data);
	            e.preventDefault();
        	}
        	else
        	{
        		toastr.warning('Tin Number must be 9 digits');
        		e.preventDefault();
        	}
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
            	else if(data.status == 'popup-warning')
	            {
					var message = data.message;
					$('.warning-text').text(message[0]);
					$("#popup-warning").modal();             
	            }
	            else if(data.status == 'error-email')
	            {
	            	$(".put-action-here").attr("action",data.action);
	            	$("#modal_resend_email").modal();
	            }
            },
            error: function()
            {
                $('#load').addClass('hide');
            }
        })
    }
    
    function get_sponsor(ito) {
    	// body...
    	var link = '/member/register/sponsor/' + $(ito).val();
    	$('.reforrer_get').load(link)	
    }
</script>
@endsection