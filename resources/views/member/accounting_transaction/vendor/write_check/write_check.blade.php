@extends('member.layout')
@section('content')

<form class="global-submit" role="form" action="{{ $action or ''}}" method="post" >
    <input type="hidden" class="token" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" class="button-action" name="button_action" value="">
    <input type="hidden" name="wc_id" value="{{ $wc->wc_id or ''}}">

    <button class="drawer-toggle" type="button"> <i class="fa fa-angle-double-left"></i></button>
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">{{ $page or ''}}</span>
                    <small>
                    <!--Add a product on your website-->
                    </small>
                </h1>
                <div class="dropdown pull-right">
                    <div>
                        <a class="btn btn-custom-white" href="/member/transaction/write_check">Cancel</a>
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Action
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu  dropdown-menu-custom">
                          <li><a class="select-action" code="sclose">Save & Close</a></li>
                          <li><a class="select-action" code="sedit">Save & Edit</a></li>
                          <li><a class="select-action" code="sprint">Save & Print</a></li>
                          <li><a class="select-action" code="snew">Save & New</a></li>
                        </ul>
                    </div>
                </div>
                @if(isset($wc))
                <div class="pull-right">
                    <div class="dropdown">
                        <button class="btn btn-custom-white dropdown-toggle" type="button" data-toggle="dropdown">More
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <!-- <li class="dropdown-header">Dropdown header 1</li> -->
                            <li><a href="/member/accounting/journal/entry/write-check/{{$wc->wc_id}}">Transaction Journal</a></li>
                            <!-- <li class="divider"></li> -->
                            <!-- <li class="dropdown-header">Dropdown header 2</li> -->
                            <li><a href="#">Void</a></li>
                        </ul>
                    </div>
                </div>
                @endif 
            </div>
        </div>
    </div>
    <div class="panel panel-default panel-block panel-title-block panel-gray">  
        <div class="tab-content">
            <div class="row">
                 <div class="form-group">
                     <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12" style="padding: 30px;">
                                <!-- START CONTENT -->
                                <div style="padding-bottom: 10px; margin-bottom: 10px;">
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <label>Reference Number</label>
                                            <input type="text" class="form-control" name="transaction_refnumber" value="{{ isset($wc->transaction_refnum) ? $wc->transaction_refnum : $transaction_refnum }}">
                                        </div>
                                    </div>
                                </div>
                                <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <select class="form-control drop-down-name input-sm pull-left" name="wc_ref_id">
                                                @include("member.load_ajax_data.load_name", ['name_id'=> isset($wc->wc_reference_id) ? $wc->wc_reference_id : '', 'ref_name'=>isset($wc->wc_reference_name) ? $wc->wc_reference_name : ''])
                                                <option class="hidden" value="" />
                                            </select>
                                            <input type="hidden" name="wc_reference_name" class="wc-ref-name" value="{{$wc->wc_reference_name or ''}}">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control input-sm customer-email" name="wc_customer_vendor_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$wc->wc_customer_vendor_email or ''}}"/>
                                        </div>
                                        <div class="col-sm-4 text-right open-transaction" style="display: none;">
                                            <h4><a class="popup popup-link-open-transaction" size="md" link="/member/transaction/write_check/load-transaction?vendor_id="><i class="fa fa-handshake-o"></i> <span class="count-open-transaction">0</span> Open Transaction</a></h4>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                                    <div class="row clearfix">
                                        <div class="col-sm-3">
                                            <label>Mailing Address</label>
                                            <textarea class="form-control input-sm textarea-expand" name="wc_mailing_address" placeholder="">{{isset($wc) ? $wc->wc_mailing_address : ''}}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Payment Date</label>
                                            <input type="text" class="form-control input-sm datepicker" value="{{isset($wc) ? date('m/d/Y', strtotime($wc->wc_payment_date)) : date('m/d/Y')}}" name="wc_payment_date">
                                        </div>
                                    </div>
                                </div>
                                 <div class="row clearfix draggable-container">
                                    <div class="table-responsive " id="item-tbl">
                                        <div class="col-sm-12">
                                            <table class="digima-table">
                                                <thead >
                                                    <tr>
                                                        <th style="width: 15px;">#</th>
                                                        <th style="width: 200px;">Product/Service</th>
                                                        <th>Description</th>
                                                        <th style="width: 70px;">U/M</th>
                                                        <th style="width: 70px;">Qty</th>
                                                        <th style="width: 120px;">Rate</th>
                                                        <th style="width: 120px;">Amount</th>
                                                        <th style="width: 15px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-item">
                                                    @if(isset($wc))
                                                        @foreach($_wcline as $item)
                                                        <tr class="tr-draggable">
                                                            <td class="invoice-number-td text-right">1</td>
                                                            <td>
                                                                <input type="hidden" class="poline_id" name="itemline_ref_name[]" value="{{$item->wcline_ref_name}}">
                                                                <input type="hidden" class="itemline_po_id" name="itemline_ref_id[]" value="{{$item->wcline_ref_id}}">

                                                                <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                                    @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $item->wcline_item_id])
                                                                </select>
                                                            </td>
                                                            <td><textarea class="textarea-expand txt-desc" name="item_description[]">{{$item->wcline_description}}</textarea></td>
                                                            <td>
                                                                <select class="1111 droplist-um select-um {{isset($item->wcline_um) ? 'has-value' : ''}}" name="item_um[]">
                                                                    @if($item->wcline_um)
                                                                        @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $item->multi_um_id, 'selected_um_id' => $item->wcline_um])
                                                                    @else
                                                                        <option class="hidden" value="" />
                                                                    @endif
                                                            </select>
                                                            </td>
                                                            <td><input class="text-center number-input txt-qty compute" type="text" value="{{$item->wcline_qty}}" name="item_qty[]"/></td>
                                                            <td><input class="text-right number-input txt-rate compute" type="text" value="{{$item->wcline_rate}}" name="item_rate[]"/></td>
                                                            <td><input class="text-right number-input txt-amount" type="text" value="{{$item->wcline_amount}}" name="item_amount[]"/></td>
                                                            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                    <tr class="tr-draggable">
                                                        <td class="invoice-number-td text-right">1</td>
                                                        <td>
                                                        <input type="hidden" class="poline_id" name="itemline_ref_name[]">
                                                        <input type="hidden" class="itemline_po_id" name="itemline_ref_id[]">
                                                            <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                                @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                            </select>
                                                        </td>
                                                        <td><textarea class="textarea-expand txt-desc" name="item_description[]"></textarea></td>
                                                        <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                        <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                        <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                        <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                        <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                    </tr>
                                                    <tr class="tr-draggable">
                                                        <td class="invoice-number-td text-right">2</td>
                                                        <td>
                                                        <input type="hidden" class="poline_id" name="itemline_ref_name[]">
                                                        <input type="hidden" class="itemline_po_id" name="itemline_ref_id[]">
                                                            <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                                @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                            </select>
                                                        </td>
                                                        <td><textarea class="textarea-expand txt-desc" name="item_description[]"></textarea></td>
                                                        <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                        <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                        <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                        <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                        <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <label>Memo</label>
                                        <textarea class="form-control input-sm textarea-expand" name="wc_memo" >{{ isset($wc->wc_memo) ? $wc->wc_memo : '' }}</textarea>
                                    </div>
                                    <div class="col-sm-6">                      
                                        <div class="row">
                                            <div class="col-md-7 text-right digima-table-label">
                                                Total
                                            </div>
                                            <div class="col-md-5 text-right digima-table-value total">
                                               <input type="hidden" name="wc_total_amount" class="total-amount-input" />
                                                    PHP&nbsp;<span class="total-amount">0.00</span>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                
                                <!-- END CONTENT -->
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="po-listing hide">
</div>
</form>
<div class="div-script-po hide">
    <div class="po_id">
        <input type="text" class="po-id-input" name="po_id[]">    
    </div>
</div>
<div class="div-script">
    <table class="div-item-row-script hide">
        <tr class="tr-draggable">
            <td class="invoice-number-td text-right">1</td>
            <td>
            <input type="hidden" class="poline_id" name="itemline_ref_name[]">
            <input type="hidden" class="itemline_po_id" name="itemline_ref_id[]">
                <select class="1111 form-control select-item input-sm pull-left" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                </select>
            </td>
            <td><textarea class="textarea-expand txt-desc" name="item_description[]"></textarea></td>
            <td><select class="2222 select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/bootstrap_drawer/cooker.drawer.js"></script>

<!-- <script type="text/javascript" src="/assets/member/js/write_check.js"></script> -->
<script type="text/javascript" src="/assets/member/js/accounting_transaction/vendor/write_check.js"></script>

<script type="text/javascript">

    $("#acct-a").click(function()
    {
    	$('#account-tbl').toggle();
    	$('i',this).toggleClass("fa-caret-right fa-caret-down")
    });
    $("#item-a").click(function()
    {
    	$('#item-tbl').toggle();
    	$('i',this).toggleClass("fa-caret-right fa-caret-down")
    });
$(document).ready(function() {
  $('.drawer').drawer({
    desktopEvent:'click'
  });
});
</script>

@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/assets/member/bootstrap_drawer/cooker.drawer.css">
<style type="text/css">
.po-style
{
    padding: 10px;
    background-color: #fff;
}
.drawer-toggle
{
    background-color: #76B6EC;
    color: #fff;
    border-top-left-radius: 2px;
    border-bottom-left-radius: 2px;
    border-bottom-right-radius: 0;
}
.drawer-toggle:hover
{
    background-color: #76B6EC;
    color: #fff;
}

.drawer-default
{
    -webkit-box-shadow: -1px 0px 10px 0px rgba(184,184,184,1);
    -moz-box-shadow: -1px 0px 10px 0px rgba(184,184,184,1);
    box-shadow: -1px 0px 10px 0px rgba(184,184,184,1);
    -webkit-transition: all 0.4s ease;
       -o-transition: all 0.4s ease;
          transition: all 0.4s ease;
    z-index: 2;
}
.drawer-toggle
{
    -webkit-transition: all 0.4s ease;
       -o-transition: all 0.4s ease;
          transition: all 0.4s ease;
}
.drawer-default + .drawer-overlay
{
    background-color: transparent !important;
    -webkit-transition: all 0.4s ease;
       -o-transition: all 0.4s ease;
          transition: all 0.4s ease;
}
.drawer-open .drawer-overlay
{
    padding-right: 30px;
}
.drawer-close .drawer.drawer-default
{
    right: -280px;
}
.drawer-open .drawer.drawer-default
{
    right: 0;
}
nav.user-menu
{
    background-color: #F5F5F5;
}
</style>
@endsection