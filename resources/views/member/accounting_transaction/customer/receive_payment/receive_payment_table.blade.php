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
        @if(count($_receive_payment) > 0)
            @foreach($_receive_payment as $rp)
                <tr>
                    <td>
                        {{ucwords($rp->company)}} <br>
                        <small> {{ucwords($rp->first_name.' '.$rp->middle_name.' '.$rp->last_name)}} </small>
                    </td>
                    <td class="text-center">{{$rp->transaction_refnum != "" ? $rp->transaction_refnum : $rp->rp_id}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($rp->date_created))}}</td>
                    <td class="text-center">{{currency('',$rp->rp_total_amount)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="javascript">PRINT</a></li>
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
<div class="pull-right">{!! $_receive_payment->render() !!}</div>