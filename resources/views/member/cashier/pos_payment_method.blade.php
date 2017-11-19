 <div class="payment-list row clearfix">
    @if(count($_payment) > 0)
        @foreach($_payment as $payment)
        <li class="payment-li">
            <div class="col-sm-1">
               <a href="javascript:" class="remove-payment" payment-id={{$payment->cart_payment_id}}> <i class="fa fa-times-circle" style="color:red"></i></a> 
            </div>
            <div class="col-sm-4">
                {{strtoupper($payment->payment_type)}}
            </div>
            <div class="col-sm-7 text-right">
                {{currency('PHP',$payment->payment_amount)}}
            </div>
            <input type="hidden" value="{{$payment->payment_amount}}" class="compute-payment-amount" name="">
        </li>
        @endforeach
    @else
    <li class="text-center">No Payment Selected</li>
    @endif
    <!-- <li>
        <div class="col-sm-1">
           <a href="javascript:"> <i class="fa fa-times-circle" style="color:red"></i></a> 
        </div>
        <div class="col-sm-4">
            Check
        </div>
        <div class="col-sm-7 text-right">
            PHP49.00
        </div>
    </li> -->
</div>