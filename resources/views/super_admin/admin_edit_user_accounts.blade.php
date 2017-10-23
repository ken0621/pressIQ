@extends("super_admin/admin_layout")
@section("content")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update User's Account
        <small>Information</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users' Account</a></li>
        <li class="active">Information</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <!-- SELECT2 EXAMPLE -->
      <!-- <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Update User Account Info</h3>
      
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        /.box-header
        <div class="box-body">
        	 <form method="post" action="/admin/shop_user_accounts_update_submit/{{$_user_info_update->user_id}}" role="login">
        		{{ csrf_field() }}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" name="user_first_name" required class="form-control input-lg" value="{{$_user_info_update->user_first_name}}" /> 
              </div>
              	<div class="form-group">
                <label>Last Name</label>
                <input type="text" name="user_last_name" required class="form-control input-lg" value="{{$_user_info_update->user_last_name}}" /> 
              </div>
      				<div class="form-group">
                <label>Email</label>
                <input type="text" name="user_email" required class="form-control input-lg" value="{{$_user_info_update->user_email}}" /> 
              </div>
              <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="user_contact_number" required class="form-control input-lg" value="{{$_user_info_update->user_contact_number}}" /> 
              </div>
              <div class="form-group">
                <label>User Level</label>
                <input type="text" name="user_level" required class="form-control input-lg" value="{{$_user_info_update->user_level}}" /> 
              </div>
              <div class="form-group">
                <label>Shop</label>
                <input type="text" name="shop_key" required class="form-control input-lg" value="{{$_user_info_update->shop_key}}" /> 
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" required class="form-control input-lg" value="{{$password1}}" /> 
              </div>
              <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Update Password</button>     
            </div>
          </div>
          </form>
        </div> 
          	</div> -->

	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Update User Account Info</h3>
	          <div class="box-tools pull-right">
	            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
	          </div>

			<div class="box-body">
        <form class ="update_form" method="post" action="/admin/shop_user_accounts_update_submit/{{$_user_info_update->user_id}}" role="login">
            {{ csrf_field() }}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group1">
                <label class="form_label">First Name</label>
                <input type="text" name="user_first_name" required class="form-control input-lg" style="width:550px;" value="{{$_user_info_update->user_first_name}}" /> 
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label class="form_label">Last Name</label>
                <input type="text" name="user_last_name" required class="form-control input-lg" style="width:550px;" value="{{$_user_info_update->user_last_name}}" /> 
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-form">
              <div class="form-group2">
                <label class="form_label">Email</label>
                <input type="text" name="user_email" required class="form-control input-lg" style="width:550px;" value="{{$_user_info_update->user_email}}" /> 
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label class="form_label">Contact Number</label>
                <input type="text" name="user_contact_number" required class="form-control input-lg" style="width:550px;" value="{{$_user_info_update->user_contact_number}}" /> 
              </div>
              <!-- /.form-group -->
            </div>
            <div class="col-md-6 col-form1">
              <div class="form-group3">
                <label class="form_label">User Level</label>
                <input type="text" name="user_email" required class="form-control input-lg" style="width:550px"; value="{{$_user_info_update->user_level}}" /> 
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label class="form_label">Shop</label>
                <input type="text" name="shop_key" required class="form-control input-lg" style="width:550px"; value="{{$_user_info_update->shop_key}}" /> 
              </div>
              <!-- /.form-group -->
            </div>
            <div class="col-md-6 col-form2">
              <div class="form-group">
                <label class="form_label">Password</label>
                <input type="text" name="password" required class="form-control input-lg" style="width:550px"; value="{{$password1}}" /> 
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <button type="submit" name="go" class="btn btn-lg btn-primary btn-block button_submit" style="width:550px";>Update Password</button>   
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          </form>
        </div>
        <!-- /.box-body -->


		</div>
	</div>


  </section>
</div>
@endsection