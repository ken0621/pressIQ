<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <?php
      header("cache-Control: no-store, no-cache, must-revalidate");
      header("cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
      header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Still processing...</title>
  <base href="{{ URL::to('digima/public') }}">
  <!-- Bootstrap -->
  <link href="assets/member-theme/myphone/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- Font Awesome -->
  <link href="assets/member-theme/myphone/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="resources/assets/distributor/styles/6227bbe5.font-awesome.css" type="text/css" />
  <!-- NProgress -->
  <link href="assets/member-theme/myphone/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="assets/member-theme/myphone/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="assets/member-theme/myphone/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="assets/member-theme/myphone/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
  <link href="assets/member-theme/myphone/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="assets/member-theme/myphone/build/css/custom.min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="assets/member/css/loader.css">
  <link rel="stylesheet" href="assets/member/css/member.css" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="assets/member/plugin/toaster/toastr.css">
    <script>
    (function () {
    var js;
    if (typeof JSON !== 'undefined' && 'querySelector' in document && 'addEventListener' in window) {
    js = '/assets/external/jquery.minv2.js';
    } else {
    js = '/assets/external/jquery.minv1.js';
    }
    document.write('<script src="' + js + '"><\/script>');
    }());
    </script>
    <style>
         .navbar, .left_col { background-color: #5c3424; }
         #menu_toggle { color: #5c3424; }
         body { background-color: #5c3424! important; }
         .nav.side-menu>li.active>a  { background: none; }
         .nav.side-menu>li.active, .nav.side-menu>li.current-page { border-right: 5px solid orange; }
         .sidebar-footer { background: orange; }

         div.box
         {
          height: auto;
          border: 0;
          background-color: #fff;
          position: relative;
          border-radius: 3px;
          background: #ffffff;
          margin-bottom: 20px;
          width: 100%;
          box-shadow: 0 1px 1px rgba(0,0,0,0.1);
         }

        .box-header.with-border 
        {
          border-bottom: 1px solid #f4f4f4;
        }

        .box-header 
        {
          color: #444;
          display: block;
          padding: 10px;
          position: relative;
        }

        .box-header .fa
        {
          display: inline-block;
          font-size: 18px;
          margin: 0;
          line-height: 1;
          margin-right: 5px;
        }

        .box-header .box-title
        {
          display: inline-block;
          font-size: 18px;
          margin: 0;
          line-height: 1;
        }

        .box-body 
        {
          border-top-left-radius: 0;
          border-top-right-radius: 0;
          border-bottom-right-radius: 3px;
          border-bottom-left-radius: 3px;
          padding: 10px;
        }

        .nav.side-menu>li>ul>li>a
        {
          color: #fff;
          display: block;
          padding: 7.5px 0;
        }

        .box.box-primary
        {
          overflow: hidden;
        }

        .bg-aqua, .callout.callout-info, .alert-info, .label-info, .modal-info .modal-body
        {
          background-color: #5C3424 !important;
        }

        .timeline::before
        {
          left: 3.5px;
        }

        .content 
        {
            min-height: 250px;
            padding: 0px;
            margin-right: auto;
            margin-left: auto;
        }

        .info-box
        {
          border: 1px solid #D9DEE4;
        }

        .info-box-icon
        {
          height: 88px;
        }

        .info-box-text h2
        {
          font-weight: 700;
          margin-bottom: 5px;
        }

        .info-box-content
        {
          margin-top: 5px;
        }
      </style>
</head>
<body>
   @if($first_order)
   <br>
   <div class="col-md-offset-2 col-md-8">
      <div class="box box-primary">
        <div class="box-header">
          <center>Your order status: {{$first_order->order_status}}</center>
        </div>
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <td>Order Number:</td>
              <td>{{$first_order->ec_order_id}}</td>
            </tr>
            <tr>
              <td>Customer Email:</td>
              <td>{{$first_order->customer_email}}</td>
            </tr>
            <tr>
              <td>Payment Status:</td>
              <td>{{$first_order->payment_status == 1 ? 'Paid' : 'Unpaid'}}</td>
            </tr>
            <tr>
              <td>Billing Adress:</td>
              <td>{{$first_order->billing_address}}</td>
            </tr>
            <tr>
              <td></td>
              <td><a href="/mlm/login">Click here to Logout</a></td>
            </tr>
            <tr>
              <td></td>
              <td><a href="/member/register?slot=0">Click Order New</a></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  @else
  <div class="panel-heading">No slot</div>
  @endif  
</body>
