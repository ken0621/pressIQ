@extends("super_admin/admin_layout")
@section("content")
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="text_user_account" style="padding-top: 10px;">
      Shop User Accounts
      <small> table</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
   <!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Client User's Account Table</h3>
        </div>
            <!-- /.box-header -->
    <div class="box-body-user-account">
   <div class="container filter">
   <select class="selectpicker" id="filteredrr">
    @foreach($_shop as $shop)
    <option value="{{$shop->shop_id}}">{{$shop->shop_key}}</option>
    @endforeach
  </select>
  </div>
<input type="hidden" value="{{csrf_token()}}" class="token" name="">
<!-- <div class="border"> -->
<div class="shop_table_container">

</div>
</div>         
</div>
<!-- </div> -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->  
@section("js")
<script type="text/javascript" src ="/admin_assets/js/filtering_shop.js"></script>
@endsection
@endsection
