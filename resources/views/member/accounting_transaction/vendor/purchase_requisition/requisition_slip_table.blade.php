<div class="rs-container">
    <div class="table-responsive rs-table">
        <table class="table table-bordered table-striped table-condensed">
            <thead style="text-transform: uppercase">
                <tr>
                    <th>VENDORNAME</th>
                    <th class="text-center" width="400px">PR NUMBER</th>
                    <th class="text-center" width="400px">DATE</th>
                    <th class="text-center" width="400px">TOTAL PRICE</th>
                    <th class="text-center" width="150px"></th>
                </tr>
            </thead>
            <tbody>
                @if(count($_pr) > 0)
                @foreach($_pr as $key => $pr)
                    <tr>
                        <td>{{ $pr->vendor_company }}<br>
                            <small>{{ $pr->vendor_title_name.' '.$pr->vendor_first_name.' '.$pr->vendor_middle_name.' '.$pr->vendor_last_name.' '.$pr->vendor_suffix_name }}</small>
                        </td>
                        <td class="text-center">{{ $pr->requisition_slip_number ==''? $pr->requisition_slip_id : $pr->requisition_slip_number }}</td>
                        <td class="text-center">{{ date('m-d-Y', strtotime($pr->created_date)) }}</td>
                        <td class="text-center">{{ currency('PHP', $pr->rs_item_amount)}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li ><a target="_blank" href="/member/vendor/requisition_slip/print/{{$pr->requisition_slip_id}}"> Print </a></li>
                                    <li><a class="popup" link="/member/vendor/requisition_slip/confirm/{{$pr->requisition_slip_id}}" size="md">Confirm</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr><td class="text-center" colspan="3">NO PROCESS YET</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>