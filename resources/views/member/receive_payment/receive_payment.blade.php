@extends('member.layout')
@section('content')
<form class="global-submit" action="{{$action}}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}"> 
    <input type="hidden" class="button-action" name="button_action" value="">
    <div class="panel panel-default panel-block panel-title-block" id="top">
        <div class="panel-heading">
            <div>
                <i class="fa fa-tags"></i>
                <h1>
                    <span class="page-title">Customer &raquo; Receive Payment</span>
                    <small>
                    <!--Add a product on your website-->
                    </small>
                </h1>
                <button type="submit" class="panel-buttons btn btn-custom-primary pull-right" data-action="save-and-edit">Save</button>
                <button type="submit" class="panel-buttons btn btn-custom-white pull-right" data-action="save-and-new">Save and New</button>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-block panel-title-block panel-gray">
        
        <div class="tab-content rcvpymnt-container">
            <div class="row rcvpymnt-load-data">
                <div class="col-md-12" style="padding: 30px;">
                    <!-- START CONTENT -->
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <select class="drop-down-customer" name="rp_customer_id" required>
                                    @include("member.load_ajax_data.load_customer", ['customer_id' => isset($rcvpayment) ? $rcvpayment->rp_customer_id : (isset($c_id) ? $c_id : '')])
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-custom-white btn-sm" data-placement="bottom" data-html="true" id="example" data-content="<form><br><input type='text' class='form-control input-sm' ><br><a style='cursor:pointer' class='pull-left' onclick='$(&quot;#example&quot;).popover(&quot;hide&quot;);'>Cancel</a><a style='cursor:pointer' class='pull-right'>Find</a><br></form>" data-toggle="popover">Find by invoice no.</button>
                            </div>
                        </div>
                    </div>
                                    
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                     <div class="row clearfix">
                      <div class="col-sm-2">
                                <label>Payment Date</label>
                                <input type="text" class="datepicker form-control input-sm" value="{{$rp_date or ''}}" />
                            </div>
                        <div class="col-sm-3">
                            <label>Payment Method</label>
                            <select class="drop-down-payment" name="rp_payment_method">
                                @include("member.load_ajax_data.load_payment_method", ['payment_method_id' => isset($rcvpayment) ? $rcvpayment->rp_payment_method : ''])
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Reference No</label>
                            <input type="text" class="form-control input-sm" />
                        </div>
                        <div class="col-sm-3">
                            <label>Deposit to</label>
                            <select class="drop-down-coa" name="rp_ar_account">
                                @include("member.load_ajax_data.load_chart_account", ['add_search' => "", "account_id" => isset($rcvpayment) ? $rcvpayment->rp_ar_account : ''])
                            </select>
                        </div>
                        <div class="col-sm-2 pull-right">
                        	<label>Amount Received</label>
                        	<input type="text" class="input-sm form-control amount-received" value="{{$rcvpayment->rp_total_amount or ''}}">
                        </div>
                    </div>
                   <!--  <div class="row clearfix">
                        <div class="col-sm-3">
                            <a>Accept Payment in My168shop</a>
                       </div>
                    </div> -->
                    </div>
                    <div class="row clearfix draggable-container">
                        <div class="table-responsive">
                            <div class="col-sm-12">
                                <table class="digima-table">
                                    <thead >
                                        <tr>
                                            <th style="width: 15px;"></th>
                                            <th>Description</th>
                                            <th style="width: 150px;" >Due Date</th>
                                            <th class="text-right" style="width: 120px;" class="text-right">Original Amount</th>
                                            <th class="text-right" style="width: 120px;">Balance Due</th>
                                            <th class="text-right" style="width: 120px;">Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody-item">
                                        @include('member.receive_payment.load_receive_payment_items')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <label>Memo</label>
                            <textarea class="form-control input-sm textarea-expand" name="rp_memo" placeholder=""></textarea>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-7 text-right digima-table-label">
                                    Amount to Apply
                                </div>
                                <div class="col-md-5 text-right digima-table-value total">
                                    <input type="hidden" name="rp_total_amount" class="amount-to-apply" />
                                    <span class="amount-apply">PHP 0.00</span>
                                </div>
                            </div> 
                            <div class="row">
                              <div class="col-md-7 text-right digima-table-label">
                                    Amount to Credit
                                </div>
                                <div class="col-md-5 text-right digima-table-value red">
                                    <input type="hidden" name="amount_to_credit" class="amount-to-credit" />
                                    <span class="amount-credit">PHP 0.00</span>
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
@endsection


@section('script')
<script type="text/javascript">
    $(".chosen-select").chosen({no_results_text: "The customer doesn't exist."});
    $('[data-toggle="popover"]').popover(); 
</script>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript" src="/assets/member/js/receive_payment.js"></script>
@endsection