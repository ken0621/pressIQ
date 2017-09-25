@extends("super_admin/admin_layout")
@section("content")
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="text_user_account" style="padding-top: 10px;">
      Update Shop User Accounts
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
    <div class="col-md-4">
      <section class="login-form">
        <form method="post" action="/admin/shop_user_accounts_update_submit/{{$_user_password_update->user_id}}" role="login">
          {{ csrf_field() }}
          <img src="/admin_assets/IT_Pics/digimahouse-logo.png" class="img-responsive" alt="" />
          <input type="text" name="password" required class="form-control input-lg" value="{{$password1}}" /> 
          <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Update Password</button>   
        </form>
      </section>  
      </div>
</div>  
@endsection
