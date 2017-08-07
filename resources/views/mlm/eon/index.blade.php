@extends('mlm.layout')
@section('content')
<?php 
$data['title'] = 'Eon Card Registration';
$data['sub'] = '';
$data['icon'] = 'icon-credit-card';
?>
@include('mlm.header.index', $data)
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="info-box">
            <div class="info-box-content" style="margin-left: 0 !important;">
                <table class="table table-hover">
                    <thead>
                        <th>Slot</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Card No</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($all_slots_p as $key => $value)
                            <tr>
                                <td>{{$value->slot_no}}</td>
                                <td><input type="text" class="form-control slot_eon_{{$value->slot_id}}" name="slot_eon" value="@if(!$value->slot_eon){{$customer_info_active->first_name . ' ' . $customer_info_active->middle_name . ' ' .  $customer_info_active->last_name  }}@else{{$value->slot_eon}}@endif"></td>
                                <td><input type="tel" placeholder="000000000000" id="txt_cardNumber" pattern="[0-9.]+" onkeypress="return checkDigitaccnt(event, $(this))"class="form-control slot_eon_account_no_{{$value->slot_id}}" name="slot_eon_account_no" value="{{$value->slot_eon_account_no}}"></td>
                                <td><input type="tel" placeholder="0000000000000000" id="txt_cardNumber" pattern="[0-9.]+" onkeypress="return checkDigit(event, $(this))" class="form-control slot_eon_card_no_{{$value->slot_id}}" name="slot_eon_card_no" value="{{$value->slot_eon_card_no}}"></td>
                                <td>
                                    <button class="btn btn-primary" onClick="update_eon({{$value->slot_id}})">
                                      <i class="fa fa-check" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
</div>   
<form class="global-submit form_update_eon" method="post" action="/mlm/slots/eon/update">
    {!! csrf_field() !!}
    <input type="hidden" class="slot_id_hidden" name="slot_id">
    <input type="hidden" class="slot_eon_hidden" name="slot_eon" >
    <input type="hidden" class="slot_eon_account_no_hidden" name="slot_eon_account_no" >
    <input type="hidden" class="slot_eon_card_no_hidden" name="slot_eon_card_no" >
</form>
@endsection
@section('js')
<script type="text/javascript">
 function update_eon(slot_id)
 {
    $('.slot_id_hidden').val(slot_id);
    $('.slot_eon_hidden').val($('.slot_eon_' + slot_id).val());
    $('.slot_eon_account_no_hidden').val($('.slot_eon_account_no_' + slot_id).val());
    $('.slot_eon_card_no_hidden').val($('.slot_eon_card_no_' + slot_id).val());
    
    var slot_eon_account_no_hidden_l = $('.slot_eon_account_no_hidden').val();
    var slot_eon_card_no_hidden_l = $('.slot_eon_card_no_hidden').val();
    if( slot_eon_account_no_hidden_l.length == 12 && slot_eon_card_no_hidden_l.length == 16)
    {
        $('.form_update_eon').submit();
    }
    else
    {
        toastr.warning('Card #/ Account # must be 16 digits');
    }
    
 }
 function submit_done(messagee){
    var statusss = messagee.status;
    if(statusss == 'warning')
    {
        toastr.warning(messagee.message);
    }
    else
    {
        toastr.success(messagee.message);
    }
 }
function checkDigit (e, ito) {
    if ((e.which < 48 || e.which > 57) && (e.which !== 8) && (e.which !== 0)) {
        return false;
    }

    var current = $(ito).val();
    if(current.length >= 16)
    {
        return false;
    }
    return true;
}
function checkDigitaccnt(e, ito)
{
    if ((e.which < 48 || e.which > 57) && (e.which !== 8) && (e.which !== 0)) {
        return false;
    }

    var current = $(ito).val();
    if(current.length >= 12)
    {
        return false;
    }
    return true;
}

</script>
@endsection