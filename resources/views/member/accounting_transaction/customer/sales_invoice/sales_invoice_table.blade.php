 <table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th >NAME</th>
            <th class="text-center">REFERENCE NUMBER</th>
            <th class="text-center">TRANSACTION DATE</th>
            <th class="text-center" width="200px">TOTAL PRICE</th>
            <th class="text-center" width="200px"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($_sales_invoice) > 0)
            @foreach($_sales_invoice as $si)
                <tr>
                    <td>
                        {{ucwords($si->company)}} <br>
                        <small> {{ucwords($si->first_name.' '.$si->middle_name.' '.$si->last_name)}} </small>
                    </td>
                    <td class="text-center">{{$si->transaction_refnum != "" ? $si->transaction_refnum : $si->new_inv_id}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($si->inv_date))}}</td>
                    <td class="text-center">{{currency('',$si->inv_overall_price)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="/member/transaction/sales_invoice/create?id={{$si->inv_id}}">Edit Sales Invoice</a></li>
                                <li><a target="_blank" href="/member/transaction/sales_invoice/print?id={{$si->inv_id}}">Print</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>                                    
            @endforeach
        @else
            <tr><td colspan="5" class="text-center">NO TRANSACTION YET</td></tr>
        @endif
    </tbody>
</table>
<div class="pull-right">{!! $_sales_invoice->render() !!}</div>