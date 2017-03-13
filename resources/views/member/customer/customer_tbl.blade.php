<table style="table-layout: fixed;" class="table table-hover table-condensed table-bordered table-sale-month">
    <thead>
        <tr>
            <th class="text-left">Name</th>
            <th class="text-left">Phone/Mobile</th>
            <th class="text-left">Email</th>
            <th class="text-center">Balance Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($_customer as $customer)
         <tr class="cursor-pointer" id="tr-customer-{{$customer->customer_id}}" style="color: {{$customer->approved == 1? '#000' : '#ff3333' }};">
            <td class="text-left">{{$customer->title_name.' '.$customer->first_name.' '.$customer->middle_name.' '.$customer->last_name.' '.$customer->suffix_name}}</td>
            <td class="text-left">{{$customer->customer_phone != null ? $customer->customer_phone : 'No Phone Number' }} / {{$customer->customer_mobile != null ? $customer->customer_mobile : 'No Mobile Number'}} </td>
            <td class="text-left">{{$customer->email}}</td>
            <td class="text-right  {{$customer->customer_opening_balance > 0? 'color-red': ''}}"><span class="pull-left">PHP</span>{{number_format($customer->customer_opening_balance,2)}}</td>
            <td class="text-center">
                <!-- ACTION BUTTON -->
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-custom">
                    <li><a href="/member/customer/receive_payment">Receive Payment</a></li>
                    <li><a href="/member/customer/invoice">Create Invoice</a></li>
                    <li><a href="/member/customer/sales_receipt">Create Sales Receipt</a></li>
                    <!-- <li><a href="/member/customer/estimate">Create Estimate</li> -->
                    <li><a href="javascript:" class="active-toggle" data-content="{{$customer->customer_id}}" data-target="#tr-customer-{{$customer->customer_id}}" data-value="{{$customer->archived}}" data-html="{{$customer->archived == 0? 'inactive':'active'}}">{{$customer->archived == 0? 'Make Inactive':'Make active'}}</a></li>
                    <li><a href="javascript:" class="popup" link="/member/customer/customeredit/{{$customer->customer_id}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit Customer Info</a></li>
                  </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="padding-10 text-center">
    {!!$_customer->render()!!}
</div>