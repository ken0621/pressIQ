<table class="table table-bordered table-condensed pos-table">
    <thead>
        <tr>
            <th class="text-center" width="250px">ITEM NAME</th>
            <th class="text-center" width="180px">PRICE</th>
            <th class="text-center">QTY</th>
            <th class="text-center">DISCOUNT</th>
            <th class="text-center" width="180px">SUB TOTAL</th>
            <th width="30px"></th>
        </tr>
    </thead>
    <tbody>

        @if($_items == null)
        <tr>
            <td colspan="6" class="text-center">NO ITEM YET</td>
        </tr>
        @else
        <tr>
            <td class="text-left">
                <div>Air Wick Fresh Waters 8oz (12)</div>
            </td>
            <td class="text-center">PHP 1,500.00</td>
            <td class="text-center"><a href="javascript:">25</a></td>
            <td class="text-center"><a href="javascript:">0.00 %</a></td>
            <td class="text-center">PHP 37,500.00</td>
            <td class="text-center red-button"><i class="fa fa-close"></i></td>
        </tr>
        <tr>
            <td class="text-left">
                <div>Air Wick Apple Cinnamon Melody 8oz (12)</div>
            </td>
            <td class="text-center">PHP 1,500.00</td>
            <td class="text-center"><a href="javascript:">25</a></td>
            <td class="text-center"><a href="javascript:">0.00 %</a></td>
            <td class="text-center">PHP 37,500.00</td>
            <td class="text-center red-button"><i class="fa fa-close"></i></td>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" colspan="4">TOTAL</td>
            <td class="text-center text-bold">PHP 0.00</td>
            <td class="text-center red-button"></td>
        </tr>
    </tfoot>
</table>

<input class="table-amount-due" type="hidden" value="PHP 0.00">
<input class="table-grand-total" type="hidden" value="PHP 0.00">