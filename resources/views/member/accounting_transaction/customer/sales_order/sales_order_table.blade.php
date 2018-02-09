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
        @if(count($_sales_order) > 0)
            @foreach($_sales_order as $so)
                <tr>
                    <td>
                        {{ucwords($so->company)}} <br>
                        <small> {{ucwords($so->first_name.' '.$so->middle_name.' '.$so->last_name)}} </small>
                    </td>
                    <td class="text-center">{{$so->transaction_refnum != "" ? $so->transaction_refnum : $so->est_id}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($so->est_date))}}</td>
                    <td class="text-center">{{currency('',$so->est_overall_price)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="/member/transaction/sales_order/create?id={{$so->est_id}}">Edit Sales Order</a></li>
                                <li><a href="/member/transaction/sales_order/print?id={{$so->est_id}}">Print</a></li>
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
<div class="pull-right">{!! $_sales_order->render() !!}</div>