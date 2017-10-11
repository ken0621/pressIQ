@extends("super_admin/admin_layout")
@section("content")
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="text_user_account" style="padding-top: 10px;"><center>
      Shop User Accounts</center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
   <!-- Main content -->
   <div class="container filter">
   <select class="selectpicker" id="filteredrr">
    @foreach($_shop as $shop)
    <option value="{{$shop->shop_id}}">{{$shop->shop_key}}</option>
    @endforeach
  </select>
  </div>
<input type="hidden" value="{{csrf_token()}}" class="token" name="">
<table class="table table-condensed shop_table">
  <thead class="thead thead-inverse">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Contact Number</th>
      <th>User Level</th>
      <th>Shop Name</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($_user_account as $user_accounts)
    <tr>
      <td>{{$user_accounts->user_first_name }}</td>
      <td>{{$user_accounts->user_last_name }}</td>
      <td>{{$user_accounts->user_email }}</td>
      <td>{{$user_accounts->user_contact_number }}</td>
      <td>{{$user_accounts->user_level }}</td>
      <td>{{$user_accounts->shop_key }}</td>
      <td class="text-center">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Action
          <span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-custom-update">
            <li>
              <a href="/admin/shop_user_accounts_update/{{$user_accounts->user_id }}">&nbsp;Edit</a>
            </li>
          </ul>
        </div>
        </td>
      </tr>
    @endforeach
  </tbody>
  </table>
  <span class="pagination-container"><?php echo $_user_account->render(); ?></span>
           
</div>  
@section("js")
<script type="text/javascript" src ="/admin_assets/js/filtering_shop.js"></script>
@endsection
@endsection
