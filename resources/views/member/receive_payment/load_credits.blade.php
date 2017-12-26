@if(isset($_applied_credit))
 @if(count($_applied_credit) > 0)
     @foreach($_applied_credit as $cm_data)
     <li class="payment-li" style="list-style: none;">
        <div class="form-group">
            <div class="col-sm-1">
               <a href="javascript:" class="remove-credit" credit-id="{{$cm_data['cm_id']}}"> <i class="fa fa-times-circle" style="color:red"></i></a> 
            </div>
            <div class="col-sm-4">
                {{$cm_data['ref_number']}}
            </div>
            <div class="col-sm-7 text-right">
                {{currency('PHP',$cm_data['cm_amount'])}}
            </div>
            <input type="hidden" class="compute-applied-credit" name="" value="{{$cm_data['cm_amount']}}">
        </div>
    </li>
    @endforeach
 @endif
@endif