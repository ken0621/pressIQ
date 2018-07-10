<form action="/member/mlm/product_code2/distribute" method="post" class="global-submit">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value="{{ Request::input("id") }}">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    	<h4 class="modal-title">Distribute Product Code</h4>
    </div>
    <div class="modal-body clearfix">
        <div class="form-group">
            <label>Philtech VIP Name</label>
            <select name="customer_id" class="vip-name-distribute form-control">
                @foreach($_customer as $customer)
                    <option selected></option>
                    <option value="{{ $customer->customer_id }}">{{ ucwords(strtolower($customer->first_name)) }} {{ ucwords(strtolower($customer->middle_name)) }} {{ ucwords(strtolower($customer->last_name)) }}({{$customer->membership_name}})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group slot-no-container">
            <label>Slot No.</label>
            <select name="slot_no" class="slot-no form-control disabled" disabled>
                <option value="1">Select VIP First</option>
            </select>
        </div>

        <div class="form-group">
            <label>Receipt No.</label>
            <input class="form-control" type="text" name="receipt_number">
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input class="form-control" type="number" step="any" name="amount">
        </div>
        <div class="form-group">
            <label>Cellphone No.</label>
            <input class="form-control" id="contact" type="text"  name="cellphone_number" required>
        </div>
        {{-- <div class="form-group">
            <label>Email</label>
            <input class="form-control" id="contact_email" type="email" name="email">
        </div> --}}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary" type="submit">Submit</button>
    </div>
</form>

<script type="text/javascript">
$('.vip-name-distribute').chosen();
$('.vip-name-distribute').on('change', function(e) 
{
    $('.slot-no').addClass('disabled').prop('disabled', true).attr('disabled', true);
    $('.slot-no option').text('Loading...');
    $('.slot-no').chosen('destroy');

    $.ajax({
        url: '/member/mlm/product_code2/distribute/get_slot',
        type: 'GET',
        dataType: 'json',
        data: {
            customer_id: $(e.currentTarget).val()
        },
    })
    .done(function(result) 
    {
        console.log(result);
        var slot_no = '';
        var number = 0;
        var email ='';
        $.each(result, function(index, val) 
        {
            slot_no += '<option value="'+val.slot_no+'">'+val.slot_no+'</option>';
            number = val.contact;
        });

        $('.slot-no').empty();
        $('.slot-no').append(slot_no);
        $('.slot-no').removeClass('disabled').removeProp('disabled').removeAttr('disabled');
        $('.slot-no').chosen();
        $('#contact').val(number);
    })
    .fail(function() 
    {
        console.log("error");
    })
    .always(function() 
    {
        console.log("complete");
    });
});

function submit_done(data)
{
    if (data.response_status == "success") 
    {
        toastr.success("Product code distributed!", 'Success');
        window.location.reload();
    }
    else
    {
        toastr.error('This product code is already distributed.', 'Error');
    }
}


</script>