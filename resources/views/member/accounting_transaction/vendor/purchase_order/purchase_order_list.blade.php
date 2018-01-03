@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
            <span class="page-title">{{$page}}</span>
            <small>
            List of {{$page}}
            </small>
            </h1>
            <div class="dropdown pull-right">
                <button onclick="location.href='/member/transaction/purchase_order/create'" class="btn btn-primary"><i class="fa fa-star"></i> Create Purchase Order</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
    <ul class="nav nav-tabs">
        <li class="active change-tab open-tab cursor-pointer" mode="open"><a class="cursor-pointer"><i class="fa fa-check"></i> Open</a></li>
        <li class="cursor-pointer change-tab close-tab" mode="close"><a class="cursor-pointer"><i class="fa fa-times"></i> Close</a></li>
        <li class="cursor-pointer change-tab all-tab" mode="all"><a class="cursor-pointer"><i class="fa fa-trash"></i> All</a></li>
    </ul>
    <div class="search-filter-box">
        <div class="col-md-3" style="padding: 10px">
            
        </div>
        <div class="col-md-3" style="padding: 10px">
            
        </div>
        <div class="col-md-2" style="padding: 10px">
        </div>
        <div class="col-md-4" style="padding: 10px">
            <div class="input-group">
                <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search-employee-name" placeholder="Search by employee name / number" aria-describedby="basic-addon1">
            </div>
        </div>
    </div>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>VENDORNAME</th>
                                    <th class="text-center">REFERENCE NUMBER</th>
                                    <th class="text-center">DATE</th>
                                    <th class="text-center" width="120px">TOTAL PRICE</th>
                                    <th class="text-center" width="100px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($_pr)>0)
                                    @foreach($_pr as $pr)
                                    <tr>
                                        <td>{{ $pr->vendor_company }}<br>
                                            <small>{{ $pr->vendor_title_name.' '.$pr->vendor_first_name.' '.$pr->vendor_middle_name.' '.$pr->vendor_last_name.' '.$pr->vendor_suffix_name }}/small>
                                        </td>
                                        <td class="text-center">{{ $pr->transaction_refnum == ''? $pr->requisition_slip_id : $pr->transaction_refnum}}</td>
                                        <td class="text-center">{{ date('m-d-Y', strtotime($pr->requisition_slip_date_created)) }}</td>
                                        <td class="text-center">{{ currency('PHP',$pr->rs_item_amount) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action <span class="caret"></span>
                                              </button>
                                              <ul class="dropdown-menu dropdown-menu-custom">
                                                <li>
                                                    <a link="" class="popup" size="lg">Print</a>
                                                </li>
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>'No Transaction'</tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection