@extends('member.layout')
@section('content')
<form class="global-submit" role="form" action="{{$action or ''}}" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" class="button-action" name="button_action" value="">
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">{{$page or ''}}</span>
                    <small>
                    Insert Description Here
                    </small>
                </h1>
	            <div class="dropdown pull-right">
                    <div>
                        <a class="btn btn-custom-white" href="/member/transaction/purchase_order">Cancel</a>
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
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-block panel-title-block panel-gray">
       <!--  <ul class="nav nav-tabs">
            <li class="active cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#pending-codes"><i class="fa fa-star"></i> Invoice Information</a></li>
            <li class="cursor-pointer"><a class="cursor-pointer" data-toggle="tab" href="#used-codes"><i class="fa fa-list"></i> Activities</a></li>
        </ul> -->
        <div class="tab-content">
            <div class="row">
                <div class="col-md-12" style="padding: 30px;">
                    <!-- START CONTENT -->
                    <div style="padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <label>Reference Number</label>
                                <input type="text" class="form-control" name="transaction_refnumber" value="PO20171225-0001">
                            </div>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <select class="form-control droplist-vendor input-sm pull-left" name="vendor_id" required>
                                    @include('member.load_ajax_data.load_vendor', ['vendor_id' => isset($po->po_vendor_id) ? $po->po_vendor_id : (isset($v_id) ? $v_id : '')])
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control input-sm vendor-email" name="vendor_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$po->po_vendor_email or ''}}"/>
                            </div>
                            <div class="col-sm-4 text-right">
                                <h4><a class="popup popup-link-open-transaction" size="md" link="/member/transaction/purchase_order/load-transaction"><i class="fa fa-handshake-o"></i> {{$count_so}} Open Transaction</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Billing Address</label>
                            <textarea class="form-control input-sm textarea-expand" name="vendor_address" placeholder="">{{$po->po_billing_address or ''}}</textarea>
                        </div>
                        <div class="col-sm-2">  
                            <label>Terms</label>
                                <select class="form-control input-sm droplist-terms" name="vendor_terms">
                                    @include("member.load_ajax_data.load_terms")
                                </select>
                        </div>
                        <div class="col-sm-2">
                            <label>P.O Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="transaction_date" value="{{$po->po_date or date('m/d/y')}}"/>
                        </div>
                        <div class="col-sm-2">
                            <label>Due Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="transaction_duedate" value="{{$po->po_due_date or date('m/d/y')}}" />
                        </div>
                    </div>
                    
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
                                        <tr>
                                            <th style="width: 15px;" class="text-right">#</th>
                                            <th style="width: 120px;">Service Date</th>
                                            <th style="width: 180px;">Product/Service</th>
                                            <th>Description</th>
                                            <th style="width: 120px;">U/M</th>
                                            <th style="width: 70px;">Qty</th>
                                            <th style="width: 100px;">Rate</th>
                                            <th style="width: 100px;">Discount</th>
                                            <th style="width: 100px;">Remark</th>
                                            <th style="width: 100px;">Amount</th>
                                            <th style="width: 10px;">Tax</th>
                                            <th width="10"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="draggable tbody-item">     
                                        @if(isset($po))
                                            @foreach($_poline as $poline)
                                                <tr class="tr-draggable">
                                                    <td class="invoice-number-td text-right">1</td>
                                                    <td><input type="text" class="for-datepicker" name="item_servicedate[]" value="{{$poline->poline_service_date}}" /></td>
                                                    <td>
                                                        <select class="form-control select-item droplist-item input-sm pull-left {{$poline->poline_item_id}}" name="item_id[]" required>
                                                            @include("member.load_ajax_data.load_item_category", ['add_search' => "", 'item_id' => $poline->poline_item_id])
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea class="textarea-expand txt-desc" name="item_description[]" value="{{$poline->poline_description}}"></textarea>
                                                    </td>
                                                    <td>
                                                        <select class="1111 droplist-um select-um {{isset($poline->poline_um) ? 'has-value' : ''}}" name="item_um[]">
                                                            @if($poline->poline_um)
                                                                @include("member.load_ajax_data.load_one_unit_measure", ['item_um_id' => $poline->multi_um_id, 'selected_um_id' => $poline->poline_um])
                                                            @else
                                                                <option class="hidden" value="" />
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]" value="{{$poline->poline_qty}}" /></td>
                                                    <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]" value="{{$poline->poline_rate}}" /></td>
                                                    <td><input class="text-right txt-discount compute" type="text" name="item_discount[]" value="{{$poline->poline_discount}}" /></td>
                                                    <td><textarea class="textarea-expand" type="text" name="item_remark[]" value="{{$poline->poline_discount_remark}}"></textarea></td>
                                                    <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]" value="{{$poline->item_amount}}" /></td>
                                                    <td class="text-center">
                                                        <input type="hidden" class="poline_taxable" name="item_taxable[]" value="{{$poline->taxable}}" >
                                                        <input type="checkbox" name="" class="taxable-check" {{$poline->taxable == 1 ? 'checked' : ''}}>
                                                    </td>
                                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                </tr>
                                            @endforeach
                                        @else                                
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">1</td>
                                                <td><input type="text" class="for-datepicker" name="item_servicedate[]"/></td>
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
                                                <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
                                                <td><textarea class="textarea-expand" type="text" name="item_remark[]" ></textarea></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                <td class="text-center">
                                                    <input type="hidden" class="poline_taxable" name="item_taxable[]" value="" >
                                                    <input type="checkbox" name="" class="taxable-check" value="checked">
                                                </td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                                
                                            <tr class="tr-draggable">
                                                <td class="invoice-number-td text-right">2</td>
                                                <td><input type="text" class="datepicker" name="item_servicedate[]"/></td>
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
                                                <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
                                                <td><textarea class="text-right number-input" type="text" name="item_remark[]"></textarea></td>
                                                <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
                                                <td class="text-center">
                                                    <input type="hidden" class="poline_taxable" name="item_taxable[]" value="" >
                                                    <input type="checkbox" name="" class="taxable-check" value="checked">
                                                </td>
                                                <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Message Displayed on P.O</label>
                            <textarea class="form-control input-sm textarea-expand" name="vendor_message" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="vendor_memo" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    Sub Total
                                </div>
                                <div class="col-md-5 text-right digima-table-value">
                                    <input type="hidden" name="subtotal_price" class="subtotal-amount-input" />
                                    PHP&nbsp;<span class="sub-total">0.00</span>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3  padding-lr-1">
                                            <label>EWT</label>
                                        </div>
                                        <div class="col-sm-3  padding-lr-1">
                                            <!-- <input class="form-control input-sm text-right ewt_value number-input" type="text" name="ewt"> -->
                                            <select class="form-control input-sm ewt-value compute" name="vendor_ewt">  
                                                <option value="0" {{isset($po) ? $po->ewt == 0 ? 'selected' : '' : ''}}></option>
                                                <option value="0.01" {{isset($po) ? $po->ewt == 0.01 ? 'selected' : '' : ''}}>1%</option>
                                                <option value="0.02" {{isset($po) ? $po->ewt == 0.02 ? 'selected' : '' : ''}}>2%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-right digima-table-value">
                                    PHP&nbsp;<span class="ewt-total">0.00</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-4  padding-lr-1">
                                            <select class="form-control input-sm compute discount_selection" name="vendor_discounttype">  
                                                <option value="percent" {{isset($po) ? $po->po_discount_type == 'percent' ? 'selected' : '' : ''}}>Discount percentage</option>
                                                <option value="value" {{isset($po) ? $po->po_discount_type == 'value' ? 'selected' : '' : ''}}>Discount value</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2  padding-lr-1">
                                            <input class="form-control input-sm text-right number-input discount_txt compute" type="text" name="vendor_discount" value="{{$po->po_discount_value or ''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-right digima-table-value">
                                    PHP&nbsp;<span class="discount-total">0.00</span>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    <div class="row">
                                        <div class="col-sm-4 col-sm-offset-8  padding-lr-1">
                                            <select class="form-control input-sm tax_selection compute" name="vendor_tax">  
                                                <option value="0" {{isset($po) ? $po->taxable == 0 ? 'selected' : '' : ''}}>No Tax</option>
                                                <option value="1" {{isset($po) ? $po->taxable == 1 ? 'selected' : '' : ''}}>Vat (12%)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-right digima-table-value">
                                    PHP&nbsp;<span class="tax-total">0.00</span>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    Total
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
            <td><input type="text" class="for-datepicker"  name="item_servicedate[]"/></td>
            <td>
                <select class="form-control select-item input-sm pull-left" name="item_id[]">
                    @include("member.load_ajax_data.load_item_category", ['add_search' => ""])
                    <option class="hidden" value="" />
                </select>
            </td>
            <td>
                <textarea class="textarea-expand txt-desc" name="item_description[]"></textarea>
            </td>

            <td><select class="select-um" name="item_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="item_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="item_rate[]"/></td>
            <td><input class="text-right txt-discount compute" type="text" name="item_discount[]"/></td>
            <td><textarea class="textarea-expand" type="text" name="item_remark[]" ></textarea></td>
            <td><input class="text-right number-input txt-amount" type="text" name="item_amount[]"/></td>
            <td class="text-center">
                <input type="hidden" class="poline_taxable" name="item_taxable[]" value="" >
                <input type="checkbox" name="" class="taxable-check" value="checked">
            </td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection


@section('script')
<script type="text/javascript" src="/assets/member/js/accounting_transaction/vendor/purchase_order.js"></script>
@endsection