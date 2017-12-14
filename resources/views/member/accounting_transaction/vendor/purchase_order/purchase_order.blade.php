@extends('member.layout')
@section('content')
<form class="global-submit form-to-submit-transfer load-po-container" role="form" action="" method="POST" >
    <input type="hidden" name="_token" value="{{csrf_token()}}" >
    <input type="hidden" class="button-action" name="button_action" value="">
    <input type="hidden" name="po_id" value="{{$po->po_id or ''}}" >
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">{{$page}}</span>
                    <small>
                    	Create {{ $page }}
                    </small>
                </h1>
                
                  <div class="btn-group pull-right" role="group">
                  	<button type="button" class="btn btn-md btn-custom-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Saving Option <span class="caret"></span></button>
              		<ul class="dropdown-menu dropdown-menu-custom">
	                  	<li class="panel-buttons btn" data-action="save-and-print">Save and Print</li>
	                	<li class="panel-buttons btn" data-action="save-and-edit">Save and Edit</li>
	                	<li class="panel-buttons btn" data-action="save-and-close">Save and Close</li>
	                	<li class="panel-buttons btn" data-action="save-and-new">Save and New</li>
	                    <li class="panel-buttons btn" onclick="window.location='{{ URL::previous() }}'">Cancel</li>
              		</ul>
                </div>
            <!-- <div class="btn-group pull">
                <button class="panel-buttons btn btn-custom-white pull-right" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                <button type="submit" class="panel-buttons btn btn-custom-primary pull-right" data-action="save-and-edit">Save</button>
                <button type="submit" class="panel-buttons btn btn-custom-white pull-right" data-action="save-and-new">Save and New</button>
            </div> -->
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
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <select class="form-control droplist-vendor input-sm pull-left" name="po_vendor_id" data-placeholder="Select a Customer" required>
                                   
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control input-sm customer-email" name="po_vendor_email" placeholder="E-Mail (Separate E-Mails with comma)" value="{{$po->po_vendor_email or ''}}"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Billing Address</label>
                            <textarea class="form-control input-sm textarea-expand" name="po_billing_address" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-2">  
                            <label>Terms</label>
                            <select class="form-control input-sm droplist-terms" name="po_terms_id">
                                    
                                </select>
                        </div>
                        <div class="col-sm-2">
                            <label>P.O Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="po_date" value="{{$po->po_date or date('m/d/y')}}"/>
                        </div>
                        <div class="col-sm-2">
                            <label>Due Date</label>
                            <input type="text" class="datepicker form-control input-sm" name="po_due_date" value="{{$po->po_due_date or date('m/d/y')}}" />
                        </div>
                    </div>
                    
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
                                        <tr>
                                            <th style="width: 10px;" ></th>
                                            <th style="width: 120px;">Service Date</th>
                                            <th style="width: 15px;" class="text-right">#</th>
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
                                        
                                                <tr class="tr-draggable">
                                                    <td class="text-center cursor-move move"><i class="fa fa-th-large colo-mid-dark-gray"></i></td>

                                                    <td><input type="text" class="for-datepicker" name="poline_service_date[]" value="" /></td>

                                                    <td class="invoice-number-td text-right">1</td>
                                                    <td>
                                                        <select class="form-control select-item droplist-item input-sm pull-left" name="poline_item_id[]" required>
                                                           
                                                        </select>
                                                    </td>
                                                    <td>
                                                       
                                                            <label class="textarea-expand txt-desc" name="poline_description[]" value=""></label>
                                                       
                                                            <textarea class="textarea-expand txt-desc" name="poline_description[]" value=""></textarea>
                                                        
                                                    </td>
                                                    <td>
                                                        <select class="1111 droplist-um select-um  name="poline_um[]">
                                                           
                                                                <option class="hidden" value="" />
                                                           
                                                        </select>
                                                    </td>
                                                    <td><input class="text-center number-input txt-qty compute" type="text" name="poline_qty[]" value="" /></td>
                                                    <td><input class="text-right number-input txt-rate compute" type="text" name="poline_rate[]" value="" /></td>
                                                    <td><input class="text-right txt-discount compute" type="text" name="poline_discount[]" value="" /></td>
                                                    <td><textarea class="textarea-expand" type="text" name="poline_discount_remark[]" value=""></textarea></td>
                                                    <td><input class="text-right number-input txt-amount" type="text" name="poline_amount[]" value="" /></td>
                                                    <td class="text-center">
                                                        <input type="hidden" class="poline_taxable" name="poline_taxable[]" value="" >
                                                        <input type="checkbox" name="" class="taxable-check">
                                                    </td>
                                                    <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
                                                </tr>
                                                                          
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label>Message Displayed on P.O</label>
                            <textarea class="form-control input-sm textarea-expand" name="po_message" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-3">
                            <label>Statement Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="po_memo" placeholder=""></textarea>
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
                                            <select class="form-control input-sm ewt-value compute" name="ewt">  
                                                <option value="0" ></option>
                                                <option value="0.01">1%</option>
                                                <option value="0.02" >2%</option>
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
                                            <select class="form-control input-sm compute discount_selection" name="po_discount_type">  
                                                <option value="percent" >Discount percentage</option>
                                                <option value="value">Discount value</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2  padding-lr-1">
                                            <input class="form-control input-sm text-right number-input discount_txt compute" type="text" name="po_discount_value" value="{{$po->po_discount_value or ''}}">
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
                                            <select class="form-control input-sm tax_selection compute" name="taxable">  
                                                <option value="0">No Tax</option>
                                                <option value="1">Vat (12%)</option>
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
            <td class="text-center cursor-move move" ><i class="fa fa-th-large colo-mid-dark-gray"></i></td>
            <td><input type="text" class="for-datepicker"  name="poline_service_date[]"/></td>
            <td class="invoice-number-td text-right">2</td>
            <td>
                <select class="form-control select-item input-sm pull-left" name="poline_item_id[]">
                    <option class="hidden" value="" />
                </select>
            </td>
            <td>
                    <label class="textarea-expand txt-desc" name="poline_description[]"></label>
                
                    <textarea class="textarea-expand txt-desc" name="poline_description[]"></textarea>
               
            </td>

            <td><select class="select-um" name="poline_um[]"><option class="hidden" value="" /></select></td>
            <td><input class="text-center number-input txt-qty compute" type="text" name="poline_qty[]"/></td>
            <td><input class="text-right number-input txt-rate compute" type="text" name="poline_rate[]"/></td>
            <td><input class="text-right txt-discount compute" type="text" name="poline_discount[]"/></td>
            <td><textarea class="textarea-expand" type="text" name="poline_discount_remark[]" ></textarea></td>
            <td><input class="text-right number-input txt-amount" type="text" name="poline_amount[]"/></td>
            <td class="text-center">
                <input type="hidden" class="poline_taxable" name="poline_taxable[]" value="" >
                <input type="checkbox" name="" class="taxable-check" value="checked">
            </td>
            <td class="text-center remove-tr cursor-pointer"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
        </tr>
    </table>
</div>
@endsection


@section('script')
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript" src="/assets/member/js/draggable_row.js"></script>
<script type="text/javascript" src="/assets/member/js/purchase_order.js"></script>
@endsection