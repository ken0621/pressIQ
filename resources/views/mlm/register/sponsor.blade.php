<label>Referror Info</label>
@if($slot_sponsor)
<div><h2>{{name_format_from_customer_info($slot_sponsor)}} (#{{$slot_sponsor->slot_no}})</h2></div>
@else
<div>Refferror Does not Exist</div>
@endif