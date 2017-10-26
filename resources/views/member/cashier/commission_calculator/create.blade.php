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
                            <label>Select Customer</label>
                            <select class="select-customer form-control input-sm">
                                 @include('member.load_ajax_data.load_customer')
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Customer Email</label>
                            <input type="text" class="form-control input-sm customer-email" name="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Select Agent</label>
                            <select class="select-agent form-control input-sm">
                                <option commission-percent="8" value="1">Juan Dela Cruz</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input type="text" class="form-control input-sm datepicker" name="">
                            </div>
                            <div class="col-md-6">
                                <label>Due Date</label>
                                <input type="text" class="form-control input-sm datepicker" name="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Select Property</label>
                            <select class="select-property form-control input-sm">
                                 @include("member.load_ajax_data.load_item_category",['add_search' => ''])
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Total Selling Price</label>
                            <input type="text" class="number-input form-control input-sm sales-price text-right" name="">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Downpayment</label>
                            <input type="text" class="form-control input-sm text-right downpayment compute-all" name="" value="15%">
                        </div>
                        <div class="col-md-6">
                            <label>Amount of Downpayment</label>
                            <input type="text" class="form-control text-right input-sm amount-downpayment" name="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <label>Discount</label>
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
                                <label>Miscellaneous Fee</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control text-right input-sm misc" name="" value="5%">
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
                            <a href="javascript:"><h4><div class="amount-tc">TC Amount</div></h4></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 padding-top-here">
                            <div class="col-md-6">
                                <label>NDP Commission</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm text-right" value="60%" name="">
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="">NDP Commission Amount</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 padding-top-here">
                            <div class="col-md-6">
                                <label>TCP Commission</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm text-right" name="" value="40%">
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="">TCP Commission Amount</div></h4>
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
<style type="text/css">
    .padding-top-here
    {
        padding-top: 7px;
    }
</style>
<script type="text/javascript" src="/assets/member/js/create_commission_calculator.js"></script>
