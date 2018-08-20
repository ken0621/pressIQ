@extends('member.layout')
@section('css')
<style type="text/css">
    .popover{
        left: 1122px !important;
    }
</style>
@endsection

@section('content')

<div class="panel panel-default panel-block panel-title-block">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
    <div class="panel-heading">
        <div>
            <i class="fa fa-users"></i>
            <h1>
                <span class="page-title">Customers</span>
                <small>
                Manage your customer
                </small>
            </h1>
            <a href="javascript:" class="panel-buttons btn btn-custom-primary pull-right popup" link="/member/customer/modalcreatecustomer" size="lg" data-toggle="modal" data-target="#global_modal">Create Customer</a>
            <a href="javascript:" class="panel-buttons btn btn-default pull-right popup" link="/member/customer/bulk_archive" size="lg">Customer Bulk Archive</a>
        </div>
    </div>
</div>
<div class="panel panel-default panel-block panel-title-block">
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active cursor-pointer customer-tab" data-value="1"><a class="cursor-pointer" data-toggle="tab"><i class="fa fa-star"></i> Active Customers</a></li>
            <li class="cursor-pointer customer-tab" data-value="0"><a class="cursor-pointer" data-toggle="tab"><i class="fa fa-trash"></i> Inactive Customers</a></li>
        </ul>
        
        <div class="search-filter-box">
            <div class="col-md-3 hide" style="padding: 10px">
                <select class="form-control">
                    <option>All Customers</option>
                    <option>Customer with Open Balances</option>
                    <option>Customer with Overdue Invoices</option>
                </select>
            </div>
            <div class="col-md-3" style="padding: 10px">
                @if(!$pis)
                <select class="form-control" onChange="filter_customer_slot(this)">
                    <option value="all" {{Request::input('filter_slot') == 'all' ? 'selected' : ''}}>All V.I.P.s</option>
                    <option value="w_slot" {{Request::input('filter_slot') == 'w_slot' ? 'selected' : ''}}>Active V.I.P.s</option>
                    <option value="w_o_slot" {{Request::input('filter_slot') == 'w_o_slot' ? 'selected' : ''}}>Inactive V.I.P.s</option>
                </select>
                @endif
            </div>
            <div class="col-md-4 col-md-offset-5" style="padding: 10px">
                <div class="input-group">
                    <span style="background-color: #fff; cursor: pointer;" class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control customer-search" data-value="1" placeholder="Search by Customer Name press Enter" aria-describedby="basic-addon1">
                </div>
            </div>  
        </div>
        
        <div class=" panel-customer load-data">
            <table style="table-layout: fixed;" class="table table-condensed table-bordered table-sale-month">
                <thead>
                    <tr>
                        <th class="text-left">Company Name</th>
                        <th class="text-left">Contact Person</th>
                        <th class="text-left">Contact Details</th>
                        <th class="text-center">Balance Total</th>
                        <th class="text-center">Date/Time Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                @if(count($_customer) > 0)
                    @foreach($_customer as $customer)
                        <tr class="cursor-pointer" id="tr-customer-{{$customer->customer_id1}}" style="color: {{$customer->approved == 1? '#000' : '#ff3333' }};">
                             <td class="text-left">
                                {{$customer->company}}
                            </td>
                            <td class="text-left">
                                {{$customer->title_name.' '.$customer->first_name.' '.$customer->middle_name.' '.$customer->last_name.' '.$customer->suffix_name}}
                            </td>
                            <td class="text-left">
                                Tel No: {{$customer->customer_phone != null ? $customer->customer_phone : 'No Phone Number' }}<br> 
                                Mobile: {{$customer->customer_mobile != null ? $customer->customer_mobile : 'No Mobile Number'}} <br>
                                Email Address : <a target="_blank" {{$customer->email != "" ? 'href=https://mail.google.com/mail/?view=cm&fs=1&to='.$customer->email : '' }}>{{$customer->email != "" ? $customer->email : "---" }}
                            </td>
                            <td class="text-right  {{$customer->customer_opening_balance > 0? 'color-red': ''}}"><span class="pull-left"></span>{{currency('PHP',$customer->balance)}}</td>
                            <td class="text-right"><span class="pull-left"></span>{{date_format($customer->created_at, 'M-d-Y / h:i:s A')}}</td>
                            <td class="text-center">
                                <!-- ACTION BUTTON -->
                                <!-- <div class="dropdown">
                                    <button class="btn btn-custom-white dropdown-toggle" type="button" data-toggle="dropdown">More
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-header">Create Transaction</li>
                                        <li><a href="/member/customer/receive_payment?customer_id={{$customer->customer_id1}}">Receive Payment</a></li>
                                        <li><a href="/member/customer/invoice?customer_id={{$customer->customer_id1}}">Invoice</a></li>
                                        <li><a href="/member/customer/sales_receipt">Sales Receipt</a></li>
                                        <li class="divider"></li>
                                        <li><a href="/member/customer/details/{{$customer->customer_id1}}">View Customer Details</a></li>
                                        <li><a class="popup" link="/member/customer/customeredit/{{$customer->customer_id1}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit Customer Info</a></li>
                                        <li class="divider"></li>
                                        <li><li><a class="active-toggle" data-content="{{$customer->customer_id1}}" data-target="#tr-customer-{{$customer->customer_id1}}" data-value="0" data-html="inactive">Make Inactive</a></li></li>
                                    </ul>
                                </div> -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-custom-white btn-action-{{$customer->customer_id1}} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                    </button>
                                        <ul class="dropdown-menu dropdown-menu-custom">
                                        <li><a href="/member/customer/receive_payment?customer_id={{$customer->customer_id1}}">Receive Payment</a></li>
                                        <li><a href="/member/customer/invoice?customer_id={{$customer->customer_id1}}">Create Invoice</a></li>
                                        <li><a href="/member/customer/sales_receipt">Create Sales Receipt</a></li>
                                        <!-- <li><a href="/member/customer/transaction_list">Transaction List</a></li> -->
                                        @if(!$pis)
                                        <li><a href="/member/customer/estimate">Create Estimate</li>

                                        <li><a class="popup" link="/member/customer/viewlead/{{$customer->customer_id}}" size="md" data-toggle="modal">View Lead</li>   
                                        @endif
                                        <li><a href="/member/customer/details/{{$customer->customer_id1}}">View Customer Details</a></li>
                                        <li><a class="popup" link="/member/customer/customeredit/{{$customer->customer_id1}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit Customer Info</a></li>
                                        <li><a class="active-toggle" data-content="{{$customer->customer_id1}}" data-target="#tr-customer-{{$customer->customer_id1}}" data-value="0" data-html="inactive">Make Inactive</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td  colspan="5" class="text-center"> NO CUSTOMER </td></tr>
                @endif
                </tbody>
            </table>
            <div class="padding-10 text-center">
                {!!$_customer->appends(Request::capture()->except('page'))->render()!!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function filter_customer_slot(sel)
    {
        var filter = $(sel).val();
        var link = '/member/customer/list?filter_slot=' + filter;
        // location.redirect(link);
        window.location = link;
        // $('.load-data').html('<div style="margin: 100px auto;" class="loader-16-gray"></div>');
        // $('.load-data').load(link);
    }
    function submit_done(data)
    {
        if(data.message == "success")
        {
            console.log(121212);
        }
    }
    function success_update_customer(data)
    {
        if(data.message == 'success')
        {
            toastr.success('Success');
            setInterval(function()
            {
                location.href = '/member/customer/list';
            },2000);
        }
    }
</script>
<script type="text/javascript" src="/assets/member/js/customer.js"></script>
<script type="text/javascript" src="/assets/member/js/customerlist.js"></script>
<script type="text/javascript" src="/assets/member/js/paginate_ajax.js"></script>
@endsection