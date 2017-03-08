@extends('mlm.layout')
@section('content')
<div class="panel-group ">
  <div class="panel panel-default panel-info">
    <div class="panel-body">
        {!! $cus_info !!}
    </div>
  </div>  
</div>
@if(isset($card))
<div class="panel-group ">
  <div class="panel panel-default panel-info">
    <div class="panel-body">

  {!! $card !!}
  </div>
  </div>  
</div>
@endif
<div class="">
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-text-width"></i>

      <h3 class="box-title">BASIC INFORMATION</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <dl>
        <form method="post" action="/mlm/profile/edit/basic" class="global-submit">
          {!! csrf_field() !!}
              <label>Full Name</label>  
              <input id="first-name" name="first-name" class="form-control" disabled="disabled" value="{{$customer_info->title_name}} {{$customer_info->first_name}} {{$customer_info->middle_name}} {{$customer_info->last_name}} {{$customer_info->suffix_name}}">

              <label>Birth date </label>
              <input type="date" id="datepicker" name="b_day" class="form-control" style="font-family: 'Titillium Web',sans-serif !important;" value="{{$customer_info->b_day}}" placeholder="mm/dd/yyyy">     
              
              <label>Country</label>
              <select name="country_id" id="account-location" class="form-control" style="font-family: 'Titillium Web',sans-serif !important;">
                @foreach($country as $value)
                <option value="{{$value->country_id}}" @if($customer_info->country_id == $value->country_id) selected @endif >{{$value->country_name}}</option>
                @endforeach
              </select>

              <!-- <label>Address</label> -->
              <label>Province</label>  
              <input id="first-name" name="customer_state" class="form-control"  value="{{isset($customer_address->customer_state) ? $customer_address->customer_state : ''}}">
              <label>City</label>  
              <input id="first-name" name="customer_city" class="form-control" value="{{isset($customer_address->customer_city) ? $customer_address->customer_city : ''}}">
              <label>Zip Code</label>  
              <input id="first-name" name="customer_zipcode" class="form-control"  value="{{isset($customer_address->customer_zipcode) ? $customer_address->customer_zipcode : ''}}">
              <label>Street</label>  
              <input id="first-name" name="customer_street" class="form-control"  value="{{isset($customer_address->customer_street) ? $customer_address->customer_street : ''}}">
              <div style="margin-top: 10px">
                <button class="btn btn-primary pull-right">Submit</button>
              </div>
        </form>
      </dl>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
<div class="">
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-text-width"></i>

      <h3 class="box-title">CONTACT INFORMATION</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <dl>
      <form method="post" action="/mlm/profile/edit/contact" class="global-submit">
        {!! csrf_field() !!}
        <label>Tin Number</label>
        <input type="text" id="first-name" name="tin_number" class="form-control"  readonly value="{{$customer_info->tin_number}}">
        <label>Email</label>
        <input type="email" id="first-name" name="email" class="form-control email"  value="{{$customer_info->email}}" readonly>
        <label>Phone</label>  
        <input id="first-name" name="customer_phone" class="form-control" value="{{isset($other_info->customer_phone) ? $other_info->customer_phone : ''}}">
        <label>Mobile</label>  
        <input id="first-name" name="customer_mobile" class="form-control" value="{{isset($other_info->customer_mobile) ? $other_info->customer_mobile : ''}}">
        <label>Fax</label>  
        <input id="first-name" name="customer_fax" class="form-control" value="{{isset($other_info->customer_fax) ? $other_info->customer_fax : ''}}">

        <div style="margin-top: 10px">
          <button class="btn btn-primary pull-right">Submit</button>
        </div>
      </form>
      </dl>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
<div class="">
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-text-width"></i>

      <h3 class="box-title">PASSWORD</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <dl>
      <form method="post" action="/mlm/profile/edit/password" class="global-submit">
    {!! csrf_field() !!}
        <label>Old Password</label>  
        <input type="password" id="first-name" name="password_o" class="form-control" value="">
        <label>New Password</label>  
        <input type="password" id="first-name" name="password_n" class="form-control" value="">
        <label>Confirm New Password</label>  
        <input type="password" id="first-name" name="password_n_c" class="form-control" value="">
        <div style="margin-top: 10px">
          <button class="btn btn-primary pull-right">Submit</button>
        </div>
    </form>
      </dl>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
@endsection
@section('js')
<script type="text/javascript">
  function submit_done (data) {
    // body...
    console.log(data);
    if(data.status == 'success')
    {
      toastr.success(data.message);
    }
    if(data.status == 'warning')
    {
      toastr.warning(data.message);
    }
    else if(data.response_status == "warning_2")
    {
      var erross = data.warning_validator;
      $.each(erross, function(index, value) 
      {
          toastr.error(value);
      }); 
    }
  }
</script>
@endsection