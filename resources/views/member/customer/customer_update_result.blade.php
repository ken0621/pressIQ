<td class="text-left">{{$customer->title_name.' '.$customer->first_name.' '.$customer->middle_name.' '.$customer->last_name.' '.$customer->suffix_name}}</td>
<td class="text-left">{{$customer->customer_phone}}</td>
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
        <li><a href="#">Make Inactive</a></li>
        <li><a href="javascript:" class="popup" link="/member/customer/customeredit/{{$customer->customer_id}}" size="lg" data-toggle="modal" data-target="#global_modal">Edit Customer Info</a></li>
      </ul>
    </div>
</td>