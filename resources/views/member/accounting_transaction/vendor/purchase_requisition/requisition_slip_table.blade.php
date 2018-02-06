<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th class="text-center" width="400px">PR NUMBER</th>
            <th class="text-center" width="400px">DATE</th>
            <th class="text-center" width="400px">TOTAL PRICE</th>
            <th class="text-center" width="150px"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($_requisition_slip) > 0)
        @foreach($_requisition_slip as $key => $pr)
            <tr>
                <td class="text-center">{{ $pr->transaction_refnum ==''? $pr->requisition_slip_id : $pr->transaction_refnum }}</td>
                <td class="text-center">{{ date('m-d-Y', strtotime($pr->requisition_slip_date_created)) }}</td>
                <td class="text-center">{{ currency('PHP', $pr->total_amount)}}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li ><a href="/member/transaction/purchase_requisition/create?id={{$pr->requisition_slip_id}}"> Edit </a></li>
                            <li ><a target="_blank" href="/member/transaction/purchase_requisition/print/{{$pr->requisition_slip_id}}"> Print </a></li>
                            <li><a class="popup" link="/member/transaction/purchase_requisition/confirm/{{$pr->requisition_slip_id}}" size="md">Confirm</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        @else
        <tr><td class="text-center" colspan="5">NO PROCESS YET</td></tr>
        @endif
    </tbody>
</table>
<div class="pull-right">{!! $_requisition_slip->render() !!}</div>