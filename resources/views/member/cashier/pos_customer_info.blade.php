@if(!isset($exist))
<div class="row">
    <div class="col-md-12">
        <div class="input-group">
            <span style="background-color: #eee" class="input-group-addon customer-button-scan" id="basic-addon1">
                <i class="fa fa-user customer-scan-icon"></i>
                <i style="display: none;" class="fa fa-spinner fa-pulse fa-fw customer-scan-load"></i>
            </span>
            <input type="text" class="form-control event_search_customer" placeholder="Enter Customer Name" aria-describedby="basic-addon1">
        </div>
        <div class="pos-search-container-customer"></div>
    </div>
</div>
@else
<div class="row" style="padding: 15px">
    <div class="col-md-4 avatar-container">
        <img class="cashier-avatar" src="/assets/member/images/user.png">
    </div>
    <div class="col-md-8">
        <div class="customer-name text-bold">{{strtoupper($exist['customer']->first_name.' '.$exist['customer']->middle_name.' '.$exist['customer']->last_name)}}</div>
        <div class="customer-name">
            <div class="row">
                <div class="col-md-5">Customer</div>
                <div class="col-md-7">{{$exist['customer']->slot_no != null ? $exist['customer']->slot_no : $exist['customer']->customer_id}}</div>
            </div>
            <div class="customer-name">
                <div class="row">
                    <div class="col-md-5">Phone</div>
                    <div class="col-md-7">{{isset($exist['other']->customer_mobile) ? $exist['other']->customer_mobile : '- - -'}}</div>
                </div>
            </div>
            <div class="customer-name">
                <div class="row">
                    <div class="col-md-5">Balance</div>
                    <div class="col-md-7">PHP 0.00</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pos-customer-action-button text-center" style="padding: 5px">
    <div class="col-md-6">
        <a class="btn btn-custom-white full-width popup" size="lg" link="/member/customer/customeredit/{{$exist['customer']->customer_id}}"><i class="fa fa-edit"></i> Update Customer</a>
    </div>
    <div class="col-md-6">
        <a class="btn btn-custom-white full-width detach-customer"><i class="fa fa-close"></i> Detach</a>
    </div>
</div>
@endif