@extends('member.layout')
@section('content')
<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-file-o"></i>
            <h1>
            <span class="page-title">Purchase Requisition</span>
            <small>
            Purchase Request
            </small>
            </h1>
            <div class="dropdown pull-right">
               <!--  <button onclick="location.href=''" class="btn btn-def-white btn-custom-white"><i class="fa fa-check"></i> Secondary Command</button> -->
                <a href="/member/transaction/purchase_requisition/create" class="btn btn-primary"><i class="fa fa-star"></i> Create Purchase Requisition</a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block panel-gray "  style="margin-bottom: -10px;">
    <ul class="nav nav-tabs">
        <li id="all-list" class="active"><a data-toggle="tab" onClick="change_status('open');"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Open</a></li>
        <li id="archived-list"><a data-toggle="tab" onClick="change_status('closed');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Closed</a></li>
    </ul>
    <div class="tab-content codes_container" style="min-height: 300px;">
        <div id="all" class="tab-pane fade in active">
            <div class="form-group order-tags"></div>
            <div class="clearfix">
                <div class="col-md-12">
                    @include('member.accounting_transaction.vendor.purchase_requisition.requisition_slip_table')
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/accounting/vendor/requisition_slip.js"></script>
@endsection
