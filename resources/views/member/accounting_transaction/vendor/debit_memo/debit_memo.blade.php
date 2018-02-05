@extends('member.layout')
@section('content')
<form class="global-submit" role="form" action="{{ $action or ''}}" method="post" >
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" class="button-action" name="button_action" value="">
    <input type="hidden" name="dm_id" value="{{ $dm->db_id or ''}}">
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">Create {{$type or ''}}</span>
                    <small>
                    
                    </small>
                </h1>
                <div class="dropdown pull-right">
                    <div>
                        <a class="btn btn-custom-white" href="/member/transaction/debit_memo">Cancel</a>
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
                @if(isset($dm))
                <div class="pull-right">
                    <div class="dropdown">
                        <button class="btn btn-custom-white dropdown-toggle" type="button" data-toggle="dropdown">More
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="/member/accounting/journal/entry/debit-memo/{{$dm->db_id}}">Transaction Journal</a></li>
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
                <div class="col-md-12" style="padding: 30px;">
                    <!-- START CONTENT -->
                    <div style="padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <label>Reference Number</label>
                                <input type="text" class="form-control" name="transaction_refnumber" value="{{ isset($dm->transaction_refnum) ? $dm->transaction_refnum : $transaction_refnum }}">
                            </div>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <select class="form-control droplist-vendor input-sm pull-left" name="vendor_id" data-placeholder="Select a Vendor" required>
                                    @include('member.load_ajax_data.load_vendor', ['vendor_id' => isset($dm->db_vendor_id) ? $dm->db_vendor_id : ''])
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control input-sm vendor-email" name="vendor_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{isset($dm->db_vendor_email)? $dm->db_vendor_email : ''}}"/>
                            </div>
                            <div class="col-sm-4 text-right open-transaction" style="display: none;">
                                <h4><a class="popup popup-link-open-transaction" size="md" link="/member/transaction/debit_memo/load-transaction?vendor="><i class="fa fa-handshake-o"></i> <span class="count-open-transaction">0</span> Open Transaction</a></h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <label>Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="transaction_date" value="{{isset($dm->db_date) ? date('m/d/Y', strtotime($dm->db_date)) : date('m/d/Y')}}"/>
                        </div>
                    </div>
                    
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
                                        <tr>
                                            <th style="width: 15px;" class="text-right">#</th>
                                            <th style="width: 180px;">Product/Service</th>
                                            <th>Description</th>
                                            <th style="width: 120px;">U/M</th>
                                            <th style="width: 70px;">Qty</th>
                                            <th style="width: 100px;">Rate</th>
                                            <th style="width: 100px;">Amount</th>
                                            @include("member.load_ajax_data.load_th_serial_number")
                                            <th width="10"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="applied-transaction-list"></tbody>
                                    <tbody class="draggable tbody-item">     
                                        @if(isset($dm))
                                            @foreach($_dmline as $dmline)
                                                <tr class="tr-draggable">
                                                    <td class="invoice-number-td text-right">1</td>
                                                    <td>
                                                        <select class="form-control select-item droplist-item input-sm pull-left {{$dmline->dbline_item_id}}" name="item_id[]" required>
                                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $dmline->dbline_item_id])
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea class="textarea-expand txt-desc" name="item_description[]">{{$dmline->dbline_description}}</textarea>
                                                    </td>
                                                    <td>
                                                        <select class="1111 droplist-um select-um {{isset($dmline->multi_id) ? 'has-value' : ''}}" name="item_um[]">
                                                            @if($dmline->dbline_um)
                                                                @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $dmline->multi_um_id, 'selected_um_id' => $dmline->dbline_um])
                                                            @else
                                                                <option class="hidden" value="" />
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]" value="{{$dmline->dbline_qty}}" /></td>
                                                    <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]" value="{{$dmline->dbline_rate}}" /></td>
                                                    <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{$dmline->dbline_amount}}" /></td>
                                                    @if(isset($serial)) 
                                                    <td>
                                                        <textarea class="txt-serial-number" name="item_serialnumber[]">{{$dmline->serial_number}}</textarea>
                                                    </td>
                                                    @endif
                                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                </tr>
                                            @endforeach
                                        @endif                                
                                        <tr class="tr-draggable">
                                            <td class="invoice-number-td text-right">1</td>
                                            <td>
                                                <select class="1111 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                    <option class="hidden" value="" />
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                            </td>
                                            <td><select class="2222 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                            <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                            @include("member.load_ajax_data.load_td_serial_number")
                                            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                        </tr>
                                        <tr class="tr-draggable">
                                            <td class="invoice-number-td text-right">2</td>
                                            <td>
                                                <select class="22222 form-control select-item droplist-item input-sm pull-left" name="item_id[]" >
                                                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                                                    <option class="hidden" value="" />
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
                                            </td>
                                            <td><select class="3333 droplist-um select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
                                            <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
                                            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
                                            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                            @include("member.load_ajax_data.load_td_serial_number")
                                            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Vendor Message</label>
                            <textarea class="form-control input-sm textarea-expand" name="vendor_message" placeholder="">{{ isset($dm->db_message)? $dm->db_message : ''}}</textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="vendor_memo" placeholder="">{{ isset($dm->db_memo) ? $dm->db_memo : ''}}</textarea>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    Total
                                </div>
                                <div class="col-md-5 text-right digima-table-value">
                                    <input type="hidden" name="subtotal_price" class="subtotal-amount-input" />
                                    PHP&nbsp;<span class="sub-total">0.00</span>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    Remaining Total
                                </div>
                                <div class="col-md-5 text-right digima-table-value total">
                                    <input type="hidden" name="overall_price" class="total-amount-input" />
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
</form>

<div class="div-script">
    <table class="div-item-row-script hide">
        <tr class="tr-draggable">
            <td class="invoice-number-td text-right">2</td>
            <td>
                <select class="form-control select-item input-sm pull-left" name="item_id[]">
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td><textarea class="textarea-expand txt-desc" name="item_description[]"></textarea></td>
            <td><select class="select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
    <!--         <td><input class="text-right txt-discount compute" type="text" name="dbline_discount[]"/></td>
            <td><textarea class="textarea-expand" type="text" name="dbline_discount_remark[]" ></textarea></td> -->
            <td><input class="text-right number-input txt-amount" type="text" name="dbline_amount[]"/></td>
       <!--      <td class="text-center">
                <input type="hidden" class="dbline_taxable" name="dbline_taxable[]" value="" >
                <input type="checkbox" name="" class="taxable-check" value="checked">
            </td> -->
            @include("member.load_ajax_data.load_td_serial_number")
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/member/js/accounting_transaction/vendor/debit_memo.js"></script>
@endsection