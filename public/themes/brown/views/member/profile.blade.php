@extends("member.member_layout")
@section("member_content")
<div class="profile-container">
	<div class="row clearfix row-no-padding">
		<div class="col-md-4 left match-height">
			<div class="profile-main">
				<div class="img"><img src="{{ $profile->profile }}"></div>
				<div class="name">{{ $profile->first_name }} {{ $profile->middle_name }} {{ $profile->last_name }}</div>
				<div class="sub">{{ $profile->email }}</div>
			</div>
			<div class="profile-status">
				<table>
					<tr>
						<td class="green">
							<div class="status-number">0</div>
							<div class="status-label">Direct Employee</div>
						</td>
						<td class="blue">
							<div class="status-number">0</div>
							<div class="status-label">Active Slot</div>
						</td>
						<td class="orange">
							<div class="status-number">P 0.00</div>
							<div class="status-label">Current Wallet</div>
						</td>
					</tr>
				</table>
			</div>
			@if($mlm == 1)
			<div class="profile-lead">
				<a data-toggle="modal" data-target="#leads_modal" href="javascript:">
					<img src="/themes/{{ $shop_theme }}/img/leads.png"> Leads Link
				</a>
				<!-- Modal -->
				<div id="leads_modal" class="modal fade leads-modal" role="dialog">
				   <div class="modal-dialog">
				      <!-- Modal content-->
				      <div class="modal-content">
				         <div class="modal-header">
				            {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
				            <h4 class="modal-title">LEADS LINK</h4>
				         </div>
				         <div class="modal-body">
				         	<div class="leads-holder">
				         		<input class="form-control" type="text" name="" value="http://brownandproud/myleadslink/link#000123">
				         	</div>
				         	<div class="leads-button">
				         		<button class="btn btn-grey">Copy Link</button>
				         	</div>
				         </div>
				      </div>
				   </div>
				</div>
			</div>
			@endif
			<div class="profile-about">
				<div class="title">About Me</div>
				<table>
					<tr>
						<td>
							<img src="/themes/{{ $shop_theme }}/img/calendar.png"> Date Joined
						</td>
						<td>{{ $profile->created_date }}</td>
					</tr>
					<tr>
						<td>
							<img src="/themes/{{ $shop_theme }}/img/location.png"> Location
						</td>
						@if($profile_address)
							<td>{{ $profile_address->customer_state }} {{ $profile_address->customer_city }} {{ $profile_address->customer_zipcode }} {{ $profile_address->customer_street }}</td>
						@else
							<td><button class="btn btn-orange" type="button">+ Add Location</button></td>
						@endif
					</tr>
				</table>
			</div>
		</div>
		<div class="col-md-8 right match-height">
			<div class="profile-form">
				<ul class="nav nav-tabs">
				   <li class="active"><a data-toggle="tab" href="#basic_info">Basic Info</a></li>
				   <li><a data-toggle="tab" href="#contact_info">Reward Configuration</a></li>
				   <li><a data-toggle="tab" href="#profile_picture">Profile Picture</a></li>
				   <li><a data-toggle="tab" href="#password">Password</a></li>
				</ul>
				<div class="tab-content">
				   <div id="basic_info" class="tab-pane fade in active">
				   		<div class="row clearfix">
				   			<div class="col-md-6">
				   				<div class="form-group">
						   			<label>First Name</label>
						   			<input type="text" class="form-control" name="" value="{{ $profile->first_name }}">
						   		</div>
						   		<div class="form-group">
						   			<label>Middle Name</label>
						   			<input type="text" class="form-control" name="" value="{{ $profile->middle_name }}">
						   		</div>
						   		<div class="form-group">
						   			<label>Last Name</label>
						   			<input type="text" class="form-control" name="" value="{{ $profile->last_name }}">
						   		</div>
						   		<div class="form-group">
						   			<label>Birth Date</label>
						   			<div style="margin-top: 5px;">
						   				<div class="date-holder">
											<select name="b_month" class="form-control">
												@for($ctr = 1; $ctr <= 12; $ctr++)
												<option {{ date("mm", strtotime($profile->birthday)) == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ date("F", strtotime($ctr . "/01/17")) }}</option>
												@endfor
											</select>
										</div>
										<div class="date-holder">
											<select name="b_day" class="form-control">
												@for($ctr = 1; $ctr <= 31; $ctr++)
												<option {{ date("d", strtotime($profile->birthday)) == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ $ctr }}</option>
												@endfor
											</select>
										</div>
										<div class="date-holder">
											<select name="b_year" class="form-control">
												@for($ctr = date("Y"); $ctr >= (date("Y")-100); $ctr--)
												<option {{ date("Y", strtotime($profile->birthday)) == $ctr ? 'selected' : '' }} value="{{ $ctr }}">{{ $ctr }}</option>
												@endfor
											</select>
										</div>
						   			</div>
						   		</div>
						   		<div class="form-group">
						   			<label>Country</label>
						   			<select class="form-control">
						   				@foreach($_country as $country)
						   				<option {{ $profile->country_id == $country->country_id ? "selected" : "" }} value="{{ $country->country_id }}">{{ $country->country_name }}</option>
						   				@endforeach
						   			</select>
						   		</div>
				   			</div>
					   		<div class="col-md-6">
					   			<div class="form-group">
						   			<label>Province</label>
						   			<input type="text" class="form-control" name="">
						   		</div>
						   		<div class="form-group">
						   			<label>City</label>
						   			<input type="text" class="form-control" name="">
						   		</div>
						   		<div class="form-group">
						   			<label>Barangay</label>
						   			<input type="text" class="form-control" name="">
						   		</div>
						   		<div class="form-group">
						   			<label>Full Address</label>
						   			<textarea style="height: 107px" class="form-control" name=""></textarea>
						   		</div>
					   		</div>
					   		<div class="col-md-12">
					   			<div class="form-group btn-holder">
						   			<button class="btn btn-brown">Update</button>
						   		</div>
					   		</div>
				   		</div>
				   </div>
				   <!-- CONTACT INFO -->
				   <div id="contact_info" class="tab-pane fade">
				   		<div class="contact_info_success_message hidden">
							<div class="alert alert-success">
							  <strong>Success!</strong> Sponsor Rule has been successfully updated.
							</div>
				   		</div>
				   		<form method="post" class="reward-configuration-form">
				   			{{ csrf_field() }}
					   		<div class="row clearfix">
					   			<div class="col-md-12">
					   				<div class="form-group">
							   			<label>New Sponsor Rule</label>
							   			<select name="downline_rule" class="form-control">
							   				<option value="auto" {{ $customer->downline_rule == "auto" ? "selected" : "" }}>AUTO PLACEMENT</option>
							   				<option value="manual" {{ $customer->downline_rule == "manual" ? "selected" : "" }}>MANUAL PLACEMENT</option>
							   			</select>
							   		</div>
					   			</div>
						   		<div class="col-md-12">
						   			<div class="form-group btn-holder">
							   			<button type="submit" class="submit-button btn btn-brown"><i class="fa fa-save"></i> Update</button>
							   		</div>
						   		</div>
					   		</div>
				   		</form>
				   </div>
				   <div id="profile_picture" class="tab-pane fade">
					<div class="upload-profile-pic">
						<div class="icon">
							<img src="/themes/{{ $shop_theme }}/img/cloud.png">
						</div>
						<div class="name">Choose New Profile Image</div>
						<button class="btn btn-cloud">Browse</button>
						<div class="file">No File Selected</div>
					</div>
				   </div>
				   <div id="password" class="tab-pane fade">
				   	<h2>Under Development</h2>
				   </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("member_script")
<script type="text/javascript" src="/themes/{{ $shop_theme }}/js/profile.js"></script>
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/profile.css">
@endsection