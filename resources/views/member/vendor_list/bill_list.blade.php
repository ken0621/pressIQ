@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Bill &raquo; List </span>
                <small>
                    List of Bills
                </small>
            </h1>
            <a class="panel-buttons btn btn-custom-primary pull-right" href="/member/vendor/create_bill" >Create Bill</a>
        </div>
    </div>
</div>

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
                            <th>Bill No</th>
                            <th>Vendor Name</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($_bill_list)
                        @foreach($_bill_list as $bill_list)
                            <tr>
                                <td>{{$bill_list->bill_id}}</td>
                                <td>{{$bill_list->vendor_company}}</td>
                                <td>{{currency("PHP",$bill_list->bill_total_amount)}}</td>
                                <td>
                                    @if($bill_list->bill_is_paid == 0)
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
                                        @if($bill_list->bill_is_paid == 0)
                                        <li><a href="/member/vendor/create_bill?id={{$bill_list->bill_id}}">Edit Bill </a></li>
                                        <li><a href="/member/vendor/paybill?bill_id={{$bill_list->bill_id}}&vendor_id={{$bill_list->vendor_id}}">Pay Bill</a></li>
                                        @endif
                                        <li><a href="/member/vendor/print_bill?id={{$bill_list->bill_id}}">Print Bill </a></li>
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
@endsection