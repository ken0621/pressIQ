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
        @if(count($_purchase_order) > 0)
            @foreach($_purchase_order as $po)
                <tr>
                    <td>
                        {{ucwords($po->vendor_company)}} <br>
                        <small> {{ucwords($po->vendor_title_name.' '.$po->vendor_first_name.' '.$po->vendor_middle_name.' '.$po->vendor_last_name.' '.$po->vendor_suffix_name)}} </small>
                    </td>
                    <td class="text-center">{{$po->transaction_refnum == "" ? $po->po_id : $po->transaction_refnum}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($po->date_created))}}</td>
                    <td class="text-center">{{currency('PHP',$po->po_overall_price)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="/member/transaction/purchase_order/create?id={{$po->po_id}}">Edit</a></li>
                                <li><a target="_blank" href="/member/transaction/purchase_order/print?id={{$po->po_id}}">Print</a></li>
                        </div>
                    </td>
                </tr>                                    
            @endforeach
        @else
            <tr><td colspan="5" class="text-center">NO TRANSACTION YET</td></tr>
        @endif
    </tbody>
</table>
<div class="pull-right">{!! $_purchase_order->render() !!}</div>