@extends("member.member_layout")
@section("member_content")
<div class="profile-container">
	<div class="row clearfix row-no-padding">
		<div class="col-md-8">
			<div class="profile-main">
				<div class="img"><img src="/themes/{{ $shop_theme }}/img/profile-pic.png"></div>
				<div class="name">Mr. Brown Lorem Ipsum</div>
				<div class="sub">Member</div>
			</div>
			<div class="profile-status">
				<table>
					<tr>
						<td class="green">
							<div class="status-number">61</div>
							<div class="status-label">Direct Employee</div>
						</td>
						<td class="blue">
							<div class="status-number">272842</div>
							<div class="status-label">Active Slot</div>
						</td>
						<td class="orange">
							<div class="status-number">P 99,000.00</div>
							<div class="status-label">Current Wallet</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="profile-about">
				<div class="title">About Me</div>
				<table>
					<tr>
						<td>
							<img src="/themes/{{ $shop_theme }}/img/calendar.png"> Date Joined
						</td>
						<td>2017-06-19 10:39:18</td>
					</tr>
					<tr>
						<td>
							<img src="/themes/{{ $shop_theme }}/img/location.png"> Location
						</td>
						<td>20 Somerset St, McKinley Hill Village, Taguig City</td>
					</tr>
				</table>
			</div>
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
		</div>
	</div>
	<div class="profile-form">
		<ul class="nav nav-tabs">
		   <li class="active"><a data-toggle="tab" href="#basic_info">Basic Info</a></li>
		   <li><a data-toggle="tab" href="#contact_info">Contact Info</a></li>
		   <li><a data-toggle="tab" href="#profile_picture">Profile Picture</a></li>
		   <li><a data-toggle="tab" href="#password">Password</a></li>
		</ul>
		<div class="tab-content">
		   <div id="basic_info" class="tab-pane fade in active">
		   		<div class="row clearfix">
		   			<div class="col-md-6">
		   				<div class="form-group">
				   			<label>First Name</label>
				   			<input type="text" class="form-control" name="">
				   		</div>
				   		<div class="form-group">
				   			<label>Middle Name</label>
				   			<input type="text" class="form-control" name="">
				   		</div>
				   		<div class="form-group">
				   			<label>Last Name</label>
				   			<input type="text" class="form-control" name="">
				   		</div>
				   		<div class="form-group">
				   			<label>Birth Date</label>
				   			<input type="text" class="form-control" name="">
				   		</div>
				   		<div class="form-group">
				   			<label>Country</label>
				   			<input type="text" class="form-control" name="">
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
				   			<input type="text" class="form-control" name="">
				   		</div>
			   		</div>
			   		<div class="col-md-12">
			   			<div class="form-group btn-holder">
				   			<button class="btn btn-update">Update</button>
				   		</div>
			   		</div>
		   		</div>
		   </div>
		   <div id="contact_info" class="tab-pane fade">
		   	<h2>Under Development</h2>
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
@endsection
@section("member_script")
@endsection
@section("member_css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/profile.css">
@endsection