<table class="table table-bordered table-striped table-condensed">
    <thead style="text-transform: uppercase">
        <tr>
            <th >NAME</th>
            <th class="text-center">REFERENCE NUMBER</th>
            <th class="text-center">TRANSACTION DATE</th>
            <th class="text-center" width="200px">TOTAL PRICE</th>
            <th class="text-center" width="200px">CATEGORY</th>
            <th class="text-center" width="200px"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($_write_check) > 0)
            @foreach($_write_check as $wc)
                <tr>
                @if($wc->wc_reference_name == 'customer')
                    <td>
                        {{ucwords($wc->company)}} <br>
                        <small> {{ucwords($wc->title_name.' '.$wc->first_name.' '.$wc->middle_name.' '.$wc->last_name.' '.$wc->suffix_name)}} </small>
                    </td>
                @else
                    <td>
                        {{ucwords($wc->vendor_company)}} <br>
                        <small> {{ucwords($wc->vendor_title_name.' '.$wc->vendor_first_name.' '.$wc->vendor_middle_name.' '.$wc->vendor_last_name.' '.$wc->vendor_suffix_name)}} </small>
                    </td>
                @endif
                    <td class="text-center">{{$wc->transaction_refnum == "" ? $wc->wc_id : $wc->transaction_refnum}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($wc->date_created))}}</td>
                    <td class="text-center">{{currency('PHP',$wc->wc_total_amount)}}</td>
                    @if($wc->wc_ref_id != 0 && $wc->wc_ref_name == 'paybill')
                        <td class="text-center">Bill Payment (Check)</td>
                    @else
                        <td class="text-center">Check</td>
                    @endif
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a href="/member/transaction/write_check/create?id={{$wc->wc_id}}">Edit</a></li>
                                <li><a target="_blank" href="/member/transaction/write_check/print?id={{$wc->wc_id}}">Print</a></li>
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
<div class="pull-right">{!! $_write_check->render() !!}</div>