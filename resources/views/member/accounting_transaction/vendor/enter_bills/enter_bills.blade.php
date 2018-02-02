@extends('member.layout')
@section('content')

<form class="global-submit" role="form" action="{{ $action or ''}}" method="post" >
    <input type="hidden" class="token" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" class="button-action" name="button_action" value="">
    <input type="hidden" name="bill_id" value="{{ $eb->bill_id or ''}}">

<div class="drawer-overlay">
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
                        <a class="btn btn-custom-white" href="/member/transaction/enter_bills">Cancel</a>
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
                @if(isset($eb))
                <div class="pull-right">
                    <div class="dropdown">
                        <button class="btn btn-custom-white dropdown-toggle" type="button" data-toggle="dropdown">More
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <!-- <li class="dropdown-header">Dropdown header 1</li> -->
                            <li><a href="/member/accounting/journal/entry/bill/{{$eb->bill_id}}">Transaction Journal</a></li>
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
                                            <input type="text" class="form-control" name="transaction_refnumber" value="{{isset($eb->transaction_refnum)? $eb->transaction_refnum : $transaction_refnum}}">
                                        </div>
                                    </div>
                                </div>
                                <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <select class="form-control droplist-vendor input-sm pull-left" name="vendor_id">
                                                 @include('member.load_ajax_data.load_vendor', ['vendor_id' => isset($eb->bill_vendor_id) ? $eb->bill_vendor_id : (isset($vendor_id) ? $vendor_id : '')])
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control input-sm vendor-email" name="vendor_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$eb->bill_vendor_email or ''}}"/>
                                        </div>
                                        <div class="col-sm-4 text-right open-transaction" style="display: none;">
                                            <h4><a class="popup popup-link-open-transaction" size="md" link="/member/transaction/enter_bills/load-transaction?vendor_id="><i class="fa fa-handshake-o"></i> <span class="count-open-transaction">0</span> Open Transaction</a></h4>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                                    <div class="row clearfix">
                                        <div class="col-sm-3">
                                            <label>Mailing Address</label>
                                            <textarea class="form-control input-sm textarea-expand" name="vendor_address" placeholder="">{{isset($eb) ? $eb->bill_mailing_address : ''}}</textarea>
                                        </div>              
                                        <div class="col-sm-2">
                                            <label>Terms</label>
                                            <select class="form-control input-sm droplist-terms" name="vendor_terms">
                                                @include("member.load_ajax_data.load_terms", ['terms_id' => isset($eb) ? $eb->bill_terms_id : ''])
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Billing Date</label>
                                            <input type="text" class="form-control input-sm datepicker" value="{{isset($eb) ? date('m/d/Y', strtotime($eb->bill_date)) : date('m/d/Y')}}" name="transaction_date">
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Due Date</label>
                                            <input type="text" class="form-control input-sm datepicker" value="{{isset($eb) ? date('m/d/Y', strtotime($eb->bill_due_date)) : date('m/d/Y')}}" name="transaction_duedate">
                                        </div>
                                    </div>
                                </div>
                                <div class="title">    
                                    <h3><a id="acct-a"> <i class="fa fa-caret-down"></i>  Account Details </a></h3>
                                </div>
                                <div class="row clearfix">
                                    <div class="table-responsive" id="account-tbl">
                                        <div class="col-sm-12">
                                            <table class="digima-table">
                                                <thead >
                                                    <tr>
                                                        <th style="width: 15px;">#</th>
                                                        <th style="width: 200px;">Account</th>
                                                        <th>Description</th>
                                                        <th style="width: 150px;">Amount</th>
                                                        <th style="width: 15px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="draggable tbody-acct">
                                                    @if(isset($_bill_account_line))
                                                        @foreach($_bill_account_line as $accline)
                                                        <tr class="tr-draggable">
                                                            <td class="acct-number-td text-right">1</td>
                                                            <td >                                           
                                                                <select name="expense_account[]" class="form-control drop-down-coa select-coa input-sm" >
                                                                    @include("member.load_ajax_data.load_chart_account", ['add_search' => "", 'account_id' => $accline->accline_coa_id])
                                                                </select>
                                                            </td>
                                                            <td><textarea class="textarea-expand acct-desc" name="account_desc[]">{{$accline->accline_description}}</textarea></td>
                                                            <td><input type="text"  name="account_amount[]" class="form-control text-right number-input input-sm acct-amount compute" value="{{currency('',$accline->accline_amount)}}"></td>
                                                            <td class="text-center acct-remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                    <tr class="tr-draggable">
                                                        <td class="acct-number-td text-right">1</td>
                                                        <td >                                           
                                                            <select name="expense_account[]" class="form-control drop-down-coa select-coa input-sm" >
                                                                @include("member.load_ajax_data.load_chart_account", ['add_search' => ""])
                                                            </select>
                                                        </td>
                                                        <td><textarea class="textarea-expand acct-desc" name="account_desc[]"></textarea></td>
                                                        <td><input type="text" class="form-control text-right input-sm number-input acct-amount compute" value="0.00" name="account_amount[]"></td>
                                                        <td class="text-center acct-remove-tr  cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="title">
                                    <h3><a id="item-a" > <i class="fa fa-caret-down"></i>  Item Details </a></h3>
                                </div> 
                                <div class="row clearfix">
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
                                                <tbody class="applied-transaction-list">
                                                </tbody>
                                                <tbody class="draggable tbody-item">
                                                    @if(isset($eb))
                                                        @foreach($_ebline as $ebline)
                                                            <tr class="tr-draggable">
                                                                <td class="invoice-number-td text-right">1</td>
                                                                <td>
                                                                    <input type="hidden" class="poline_id" name="item_ref_name[]">
                                                                    <input type="hidden" class="itemline_po_id" name="item_ref_id[]">
                                                                        <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $ebline->itemline_item_id])
                                                                        </select>
                                                                </td>
                                                                <td><textarea class="textarea-expand txt-desc" name="item_description[]">{{ $ebline->itemline_description }}</textarea></td>
                                                                <td>
                                                                    <select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" />
                                                                        @if($ebline->itemline_um)
                                                                            @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $ebline->multi_um_id, 'selected_um_id' => $ebline->itemline_um])
                                                                        @else
                                                                            <option class="hidden" value="" />
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]" value="{{ $ebline->itemline_qty }}" /></td>
                                                                <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]" value="{{ $ebline->itemline_rate }}" /></td>
                                                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{ $ebline->itemline_amount }}" /></td>
                                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    <tr class="tr-draggable">
                                                        <td class="invoice-number-td text-right">1</td>
                                                        <td>
                                                        <input type="hidden" class="poline_id" name="item_ref_name[]">
                                                        <input type="hidden" class="itemline_po_id" name="item_ref_id[]">
                                                            <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                                @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                                        </td>
                                                        <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                        <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                        <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                        <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                        
                                                        <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                    </tr>
                                                    <tr class="tr-draggable">
                                                        <td class="invoice-number-td text-right">2</td>
                                                        <td>
                                                        <input type="hidden" class="poline_id" name="item_ref_name[]">
                                                        <input type="hidden" class="itemline_po_id" name="item_ref_id[]">
                                                            <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                                @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                                        </td>
                                                        <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                                        <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                                        <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                                        <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                        
                                                        <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <label>Remarks</label>
                                        <textarea class="form-control input-sm textarea-expand remarks-eb" name="vendor_memo" >{{isset($eb->bill_memo)? $eb->bill_memo : ''}}</textarea>
                                    </div>
                                    <div class="col-sm-6">                      
                                        <div class="row">
                                            <div class="col-md-7 text-right digima-table-label">
                                                Total
                                            </div>
                                            <div class="col-md-5 text-right digima-table-value total">
                                               <input type="hidden" name="bill_total_amount" class="total-amount-input" />
                                                    PHP&nbsp;<span class="total-amount">0.00</span>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <label>Memo</label>
                                        <textarea class="form-control input-sm textarea-expand" name="vendor_memo" >{{isset($eb->bill_memo)? $eb->bill_memo : ''}}</textarea>
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
</form>
<div class="acct-div-script">
    <table class="div-acct-row-script hide">
        <tr class="tr-draggable">
            <td class="acct-number-td text-right">1</td>
            <td >                                           
                <select name="expense_account[]" class="form-control drop-down-coa select-coa input-sm" >
                    @include("member.load_ajax_data.load_chart_account", ['add_search' => ""])
                </select>
            </td>
            <td><textarea class="textarea-expand acct-desc" name="account_desc[]"></textarea></td>
            <td><input type="text" class="form-control text-right number-input input-sm acct-amount compute" value="0.00" name="account_amount[]"></td>
            <td class="text-center acct-remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
<div class="div-script">
    <table class="div-item-row-script hide">
       <tr class="tr-draggable">
            <td class="invoice-number-td text-right">1</td>
            <td>
                <input type="hidden" class="poline_id" name="item_ref_name[]">
                <input type="hidden" class="itemline_po_id" name="item_ref_id[]">
                <select class="1111 form-control select-item input-sm pull-left" name="item_id[]" >
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                </select>
            </td>
            <td>
                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
            </td>
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
<script type="text/javascript" src="/assets/member/js/accounting_transaction/vendor/enter_bills.js"></script>
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
</script>
@endsection
