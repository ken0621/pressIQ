@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Customer Sales Receipt &raquo; List </span>
                <small>
                    List of Sales Receipt
                </small>
            </h1>
            <a class="panel-buttons btn btn-custom-primary pull-right" href="{{isset($sir_id) ? '/member/pis/manual_invoice/add/'.$sir_id : '/member/customer/sales_receipt'}}" >Create Sales Receipt</a>
        </div>
    </div>
</div>

@if ($check_user == true)
<!-- NO PRODUCT YET -->
<div class="panel panel-default panel-block panel-title-block panel-gray ">
   <!--  <ul class="nav nav-tabs">
        <li class="active cursor-pointer"><a class="cursor-pointer" onclick="select('all')" data-toggle="tab" href="#all"><i class="fa fa-star"></i> All SIR</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer"  onclick="select(0,0)" data-toggle="tab" href="#open"><i class="fa fa-folder-open"></i> Open SIR</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer"  onclick="select(1,0)" data-toggle="tab" href="#closed"><i class="fa fa-window-close"></i> Closed SIR</a></li>
        <li class="cursor-pointer"><a class="cursor-pointer" onclick="select('',1)" data-toggle="tab" href="#archived"><i class="fa fa-trash"></i> Archived SIR</a></li>
    </ul> -->
    <!-- <div class="search-filter-box">
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search_name" placeholder="Search by SIR Number" aria-describedby="basic-addon1">
            </div>
        </div>  
    </div> -->
    <div class="form-group tab-content panel-body sir_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Customer Name</th>
                            <th>Sales Receipt No</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($_invoices)
                        @foreach($_invoices as $invoice)
                            <tr>
                                <td>{{$invoice->title_name." ".$invoice->first_name." ".$invoice->middle_name." ".$invoice->last_name." ".$invoice->suffix_name}}</td>
                                <td>{{$invoice->inv_id}}</td>
                                <td>{{currency("PHP",$invoice->inv_overall_price)}}</td>
                                <td>
                                    @if($invoice->inv_is_paid == 0)
                                    <a class="btn btn-warning form-control">Open</a>
                                    @else
                                    <a class="btn form-control" style="background-color: #78C500;color: #fff">Paid</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-custom">
                                          <li ><a class="popup" link="/member/customer/customer_invoice_view/{{$invoice->inv_id}}" size="lg">View Sales Receipt</a></li>
                                          @if($invoice->manual_invoice_id == null)
                                          <li ><a href="/member/customer/sales_receipt?id={{$invoice->inv_id}}">Edit Sales Receipt</a></li>
                                          @endif
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div class="panel panel-default panel-block panel-title-block panel-gray ">
    <div class="form-group tab-content panel-body sir_container">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead style="text-transform: uppercase">
                        <tr>
                            <th>Sales Receipt No</th>
                            <th>Customer Name</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($_invoices)
                        @foreach($_invoices as $invoice)
                            <tr>
                                <td>{{$invoice->inv_id}}</td>
                                <td>{{$invoice->title_name." ".$invoice->first_name." ".$invoice->middle_name." ".$invoice->last_name." ".$invoice->suffix_name}}</td>
                                <td>{{currency("PHP",$invoice->inv_overall_price)}}</td>
                                <td>
                                    @if($invoice->inv_is_paid == 0)
                                    <a class="btn btn-warning form-control">Open</a>
                                    @else
                                    <a class="btn form-control" style="background-color: #78C500;color: #fff">Paid</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-custom">
                                          <li ><a class="popup" link="/member/customer/customer_invoice_view/{{$invoice->inv_id}}" size="lg">View Sales Receipt</a></li>
                                          @if($invoice->manual_invoice_id == null)
                                          <li ><a href="/member/customer/sales_receipt?id={{$invoice->inv_id}}">Edit Sales Receipt</a></li>
                                          @endif
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection