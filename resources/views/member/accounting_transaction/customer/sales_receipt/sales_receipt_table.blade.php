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
        @if(count($_sales_receipt) > 0)
            @foreach($_sales_receipt as $sr)
                <tr>
                    <td>
                        {{ucwords($sr->company)}} <br>
                        <small> {{ucwords($sr->first_name.' '.$sr->middle_name.' '.$sr->last_name)}} </small>
                    </td>
                    <td class="text-center">{{$sr->transaction_refnum != "" ? $sr->transaction_refnum : $sr->new_inv_id}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($sr->inv_date))}}</td>
                    <td class="text-center">{{currency('',$sr->inv_overall_price)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="/member/transaction/sales_receipt/create?id={{$sr->inv_id}}">Edit Sales Receipt</a></li>
                                <li><a href="javascript">Print</a></li>
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
<div class="pull-right">{!! $_sales_receipt->render() !!}</div>