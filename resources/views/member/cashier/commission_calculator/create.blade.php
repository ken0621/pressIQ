<form>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    	<h4 class="modal-title">Commission Calculator</h4>
    </div>
    <div class="modal-body clearfix">
    	<div class="row">
            <div class="clearfix modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-6">
                            <strong>Select Customer</strong>
                            <select class="select-customer form-control input-sm">
                                 @include('member.load_ajax_data.load_customer')
                            </select>
                        </div>
                        <div class="col-md-6">
                            <strong>Customer Email</strong>
                            <input type="text" class="form-control input-sm customer-email" name="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <strong>Select Agent</strong>
                            <select class="select-agent form-control input-sm">
                                <option commission-percent="8" value="1">Juan Dela Cruz</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <strong>Start Date</strong>
                                <input type="text" class="form-control input-sm datepicker" name="">
                            </div>
                            <div class="col-md-6">
                                <strong>Due Date</strong>
                                <input type="text" class="form-control input-sm datepicker" name="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <strong>Select Property</strong>
                            <select class="select-property form-control input-sm">
                                 @include("member.load_ajax_data.load_item_category",['add_search' => ''])
                            </select>
                        </div>
                        <div class="col-md-6">
                            <strong>Total Selling Price</strong>
                            <input type="text" class="number-input form-control input-sm sales-price text-right compute-all" name="">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-md-6">
                            <strong>Downpayment</strong>
                            <input type="text" class="form-control input-sm text-right downpayment compute-all" name="" value="15%">
                        </div>
                        <div class="col-md-6">
                            <strong>Amount of Downpayment</strong>
                            <input type="text" class="form-control text-right input-sm amount-downpayment" name="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <strong>Discount</strong>
                        </div>
                        <div class="col-md-6">
                            <input type="text" value="0.00" class="number-input form-control input-sm text-right discount compute-all" name="">
                        </div>
                    </div>
                </div>
                <div style="border: 1px solid #000;margin: 10px;"></div>
                <div class="form-horizontal">
                    <div class="form-group text-center">
                        <div class="col-md-6 text-right">
                            <h4><b>Net Downpayment :</b></h4>
                        </div>
                        <div class="col-md-6">
                            <h4><div class="amount-net-downpayment">Amount of NDP</div></h4>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-md-6">
                            <select class="select-term text-right form-control input-sm">
                                @for($i = 1; $i <= 30; $i++)
                                <option value="{{$i}}" {{$i == 1 ? 'selected' : ''}}>{{$i}} Month{{$i == 1 ? '' : 's'}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="amount-monthly-amort-dp">Monthly Amort of DP</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 padding-top-here">
                            <div class="col-md-6">
                                <strong>Miscellaneous Fee</strong>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control text-right input-sm misc compute-all" name="" value="5%">
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="amount-misc">Miscellaneous Amount</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <h4><b>Loanable Amount :</b></h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="amount-loanable">Loanable Amount</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <h4><b>Total Contract Price :</b></h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="amount-tcp">TCP Amount</div></h4>
                        </div>
                    </div>
                </div>
                <div style="border: 1px solid #000;margin: 10px;"></div>
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <h4><b>Total Commission :</b></h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <a id="popover" data-trigger="hover" data-placement="top" href="javascript:"><h4><div class="amount-tc">TC Amount</div></h4></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 padding-top-here">
                            <div class="col-md-6">
                                <strong>NDP Commission</strong>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm text-right compute-all ndp-commission" value="60%" name="">
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="amount-ndp">NDP Commission Amount</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 padding-top-here">
                            <div class="col-md-6">
                                <strong>TCP Commission</strong>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="change-tcp form-control input-sm text-right compute-all tcp-commission" name="" value="40%">
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="amount-tcp1">TCP Commission Amount</div></h4>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
    	<button class="btn btn-primary btn-custom-primary" type="button">Save</button>
    </div>
</form>
<div class="hidden row clearfix" id="computation-content">
    <div style="width: 300px">
        <div class="col-md-7 text-center">
            <div>TSP - DISCOUNT </div>
            <div style="border: 0.5px solid #000"></div>
            <div><label class="c-amount-tax">Tax Exclu</label></div> 
        </div>
        <div class="col-md-5">
            <div style="padding-top:10px">* Comm.</div>
        </div>
        <br>
        <div class="col-md-7 text-center">
            <div><label class="c-amount-tsp">1,000,000</label> - <label class="c-amount-disc">10,000</label> </div>
            <div style="border: 0.5px solid #000"></div>
            <div><label class="c-amount-tax">1.12</label></div>
        </div>
        <div class="col-md-5">
            <div style="padding-top:10px">* <label class="c-amount-commission">8%</label></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#popover').popover({ 
        html : true,
        title: '<h4 style="padding:5px">Commission Computation</h4>',
        content: function() {
          return $("#computation-content").html();
        }
    });
</script>
<style type="text/css">
    .padding-top-here
    {
        padding-top: 7px;
    }
</style>
<script type="text/javascript" src="/assets/member/js/create_commission_calculator.js"></script>
