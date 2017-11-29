
<div class="form-group tab-content panel-body customer-wis-container">
    <div id="all" class="tab-pane fade in active customer-wis-table">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">SLIP NO.</th>
                        <th class="text-center">TOTAL ISSUED INVENTORY</th>
                        @if($status== 'confirm')
                        <th class="text-center">RECEIVER CODE</th>
                        @endif
                        @if($status == 'received')
                        <th class="text-center">TOTAL RECEIVED INVENTORY</th>
                        <th class="text-center">TOTAL REMAINING INVENTORY</th>
                        @endif
                        @if($status == 'pending' || $status == 'confirm')
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="text-center" colspan="7">NO PROCESS YET</td>
                    </tr>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>