<div class="rs-container">
    <div class="table-responsive rs-table">
        <table class="table table-bordered table-striped table-condensed">
            <thead style="text-transform: uppercase">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">SLIP REFERENCE NUMBER</th>
                    <th class="text-center" width="300px"></th>
                </tr>
            </thead>
            <tbody>
                @if(count($_list) > 0)
                @foreach($_list as $key => $list)
                    <tr>
                        <td class="text-center">{{$key+1}}</td>
                        <td class="text-center">{{$list->requisition_slip_number}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-custom-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li ><a target="_blank" href="/member/vendor/requisition_slip/print/{{$list->requisition_slip_id}}"> Print </a></li>
                                    <li><a class="popup" link="/member/vendor/requisition_slip/confirm/{{$list->requisition_slip_id}}" size="md">Confirm</a></li>
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