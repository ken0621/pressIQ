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
        @if(count($_enter_bills) > 0)
            @foreach($_enter_bills as $eb)
                <tr>
                    <td>
                        {{ucwords($eb->vendor_company)}} <br>
                        <small> {{ucwords($eb->vendor_title_name.' '.$eb->vendor_first_name.' '.$eb->vendor_middle_name.' '.$eb->vendor_last_name.' '.$eb->vendor_suffix_name)}} </small>
                    </td>
                    <td class="text-center">{{$eb->transaction_refnum == "" ? $eb->bill_id : $eb->transaction_refnum}}</td>
                    <td class="text-center">{{date('F d, Y',strtotime($eb->date_created))}}</td>
                    <td class="text-center">{{currency('PHP',$eb->bill_total_amount)}}</td>
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
<div class="pull-right">{!! $_enter_bills->render() !!}</div>