<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title">EARNINGS SUMMARY FOR SLOT NO. 123</h4>
</div>
<div class="modal-body clearfix">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-condensed">
            <thead style="text-transform: uppercase">
                <tr> 
                    <th class="text-center" width="250px">COMPLAN</th>
                    <th class="text-center" width="200px">DATE</th>
                    <th class="text-center" width="200px">TRIGGER</th>
                    <th class="text-right" width="120px">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($_wallet as $wallet)
                <tr>
                    <td class="text-center">{{ $wallet->wallet_log_plan }}</td>
                    <td class="text-center">{{ $wallet->display_date }}</td>
                    <td class="text-center">N/A</td>
                    <td class="text-right text-bold">{{ $wallet->display_amount }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" colspan="3">ENDING BALANCE</td>
                    <td class="text-right text-bold" style="color: #00c5ed">{{ $log_total }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
    <button class="btn btn-primary btn-custom-primary" type="button">Submit</button>
</div>