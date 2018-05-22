<form action="/member/mlm/product_code2/release" method="post" class="global-submit">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value="{{ Request::input("id") }}">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    	<h4 class="modal-title">Release Product Code</h4>
    </div>
    <div class="modal-body clearfix">
        <div class="form-group">
            <label>Philtech VIP Name</label>
            <select name="customer_id" class="vip-name form-control">
                @foreach($_customer as $customer)
                    <option value="{{ $customer->customer_id }}">{{ ucwords(strtolower($customer->first_name)) }} {{ ucwords(strtolower($customer->middle_name)) }} {{ ucwords(strtolower($customer->last_name)) }}</option>
                @endforeach
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
            <input class="form-control" type="text" value="+63" name="cellphone_number" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" type="email" name="email">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-custom-primary" type="submit">Submit</button>
    </div>
</form>

<script type="text/javascript">
$('.vip-name').chosen();

function submit_done(data)
{
    if (data.response_status == "success") 
    {
        toastr.success("Product code released!", 'Success');
        window.location.reload();
    }
    else
    {
        toastr.error('This product code is already released.', 'Error');
    }
}
</script>