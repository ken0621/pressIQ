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
                            <input type="text" class="form-control input-sm" name="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Select Agent</label>
                            <select class="select-agent form-control input-sm">
                                <option>Juan Dela Cruz</option>
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
                                 @include("member.load_ajax_data.load_item_category")
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Total Selling Price</label>
                            <input type="text" class="form-control input-sm" name="">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Downpayment</label>
                            <input type="text" class="form-control input-sm text-right" name="" value="5%">
                        </div>
                        <div class="col-md-6">
                            <label>Amount of Downpayment</label>
                            <input type="text" class="form-control input-sm" name="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <label>Discount</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" name="">
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
                            <h4><div class="">Amount of NDP</div></h4>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-md-6">
                            <select class="select-customer form-control input-sm">
                                <option>Downpayment Term</option>
                            </select>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="">Monthly Amort of DP</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 padding-top-here">
                            <div class="col-md-6">
                                <label>Miscellaneous Fee</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="">
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="">Miscellaneous Amount</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <h4><b>Loanable Amount :</b></h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="">Loanable Amount</div></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 text-right">
                            <h4><b>Total Contract Price :</b></h4>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4><div class="">TCP Amount</div></h4>
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
                            <a href="javascript:"><h4><div class="">TC Amount</div></h4></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 padding-top-here">
                            <div class="col-md-6">
                                <label>NDP Commission</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control input-sm" name="">
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
                                <input type="text" class="form-control input-sm" name="">
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
