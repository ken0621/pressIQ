<table class="table table-bordered table-condensed pos-table">
    <thead>
        <tr>
            <th class="text-left" width="250px">ITEM NAME</th>
            <th class="text-center" width="180px">PRICE</th>
            <th class="text-center" width="100px">QTY</th>
            <th class="text-center">DISCOUNT</th>
            <th class="text-right" width="180px">AMOUNT</th>
            <th width="50px"></th>
        </tr>
    </thead>
    @if($cart == null)
    <tbody>
        <tr>
            <td colspan="6" class="text-center">NO ITEM YET</td>
        </tr>
    </tbody>
    <input class="table-amount-due" type="hidden" value="PHP 0.00">
    <input class="table-grand-total" type="hidden" value="PHP 0.00">
    @else
        <tbody  class="item-cart-pos">
            @foreach($cart["_item"] as $item)
            <tr class="item-info" item_id="{{ $item->item_id }}">
                <td class="text-left">
                    <div class="item-name">{{ $item->item_name }}</div>
                    <div class="item-sku">{{ $item->item_sku }}</div>
                </td>
                <td class="text-center">{{ $item->display_item_price }}</td>
                <td class="text-center td-change-qty" item-id={{ $item->item_id }}>
                  <!--   <a href="javascript:" class="change-quantity {{ $item->item_id }}" item-id="{{ $item->item_id }}">{{ $item->quantity }}</a> -->
                    <input type="text" class="text-right form-control input-change-qty" item-id="{{ $item->item_id }}" value="{{ $item->quantity }}">
                </td>
                <td class="text-center"><a href="javascript:">{{ $item->discount }} %</a></td>
                <td class="text-right">{{ $item->display_subtotal }}</td>
                <td class="text-center red-button remove-item-from-cart"><i class="fa fa-close fa-fw"></i></td>
            </tr>
            @endforeach

        </tbody>
        <tfoot>
            @if($cart["_total"]->display_total != $cart["_total"]->display_grand_total)
            <tr>
                <td class="text-right" colspan="4">SUB TOTAL</td>
                <td class="text-right text-bold">{{  $cart["_total"]->display_total }}</td>
                <td class="text-center red-button"></td>
            </tr>
            @endif

            @if($cart["_total"]->global_discount != 0)
            <tr>
                <td class="text-right" colspan="4">{{ $cart['_total']->display_discount_label }}</td>
                <td class="text-right" style="color: red;">{{  $cart["_total"]->display_global_discount }}</td>
                <td class="text-center red-button"></td>
            </tr>
            @endif

            <tr>
                <td class="text-right" colspan="4">TOTAL</td>
                <td class="text-right text-bold">{{  $cart["_total"]->display_grand_total }}</td>
                <td class="text-center red-button"></td>
            </tr>
        </tfoot>
        <input class="table-amount-due" type="hidden" value="{{ $cart["_total"]->display_grand_total }}">
        <input class="table-grand-total" type="hidden" value="{{ $cart["_total"]->display_grand_total }}">
    @endif
</table>
<div id="changeQuantity">
    <input type="text" class="form-control text-right" name="">
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        event_load_popover();
        action_click_change_qty();
    });
    function action_click_change_qty()
    {
        $('body').on('click','.td-change-qty', function(e)
        {
            var item_id = $(e.currentTarget).attr('item-id');
            $('.input-qty-'+item_id).removeClass('hidden');
            $('.change-quantity.'+item_id).addClass('hidden');
        });
    }
    function event_load_popover()
    {
        $('[data-toggle="popover"]').popover(
        {
            placement: 'top',
            title: 'Change Quantity',
            html: true,
            content:  $('#changeQuantity').html()
        }).on('click', getDetails());
    }
    function getDetails()
    {

    }
</script>

