@extends('member.layout')
@section('content')
<div style="margin-top: 20px">
    <div class="panel panel-default panel-block panel-title-block col-md-4 no-float" style="height: 100%">
        <div class="panel-heading">
            <div>
                <table class="table">
                    <tr>
                        <td>
                            <label>Search Order</label>
                            <input type="text" class="form-control search_order" placeholder="order id or customer name">
                        </td>
                    </tr>
                </table>
                <div class="load_order"></div>
            </div>
        </div>
    </div>        
    <div class="panel panel-default panel-block panel-title-block  col-md-8" style="height: 100%">
        <div class="panel-heading">
            <div class="append_order">
            </div>
        </div>
    </div>
</div>        
@endsection
@section('script')
<script type="text/javascript">
    $('.search_order').on('change', function(){
        var search = $(this).val();
        $('.load_order').load('/member/ecommerce/paymaya/verify/' + search);
    });
    function load_append_order (id) 
    {
        $('.append_order').html('<center>Loading..</center>');
        $('.append_order').load('/member/ecommerce/paymaya/verify/order/' + id);
    }
</script>
@endsection
