@extends('member.layout')
@section('content')

<div class="panel panel-default panel-block panel-title-block col-md-3 no-float" id="top" style="height: 100%">
    <div class="panel-heading clearfix">
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

@endsection
@section('script')
<script type="text/javascript">
    $('.search_order').on('change', function(){
        var search = $(this).val();
        $('.load_order').load('/member/ecommerce/paymaya/verify/' + search);
    });
</script>
@endsection
