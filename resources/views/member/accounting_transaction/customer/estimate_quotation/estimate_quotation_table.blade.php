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
        @if(count($_estimate_quotation) > 0)
            @foreach($_estimate_quotation as $eq)
                <tr>
                    <td>
                        {{ucwords($eq->company)}} <br>
                        <small> {{ucwords($eq->first_name.' '.$eq->middle_name.' '.$eq->last_name)}} </small>
                    </td>
                    <td class="text-center">{{$eq->transaction_refnum != "" ? $eq->transaction_refnum : $eq->est_id}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($eq->est_date))}}</td>
                    <td class="text-center">{{currency('',$eq->est_overall_price)}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="/member/transaction/estimate_quotation/create?id={{$eq->est_id}}">Edit Estimate & Quotation</a></li>
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
<div class="pull-right">{!! $_estimate_quotation->render() !!}</div>