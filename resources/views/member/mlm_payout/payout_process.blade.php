<form target="_blank" action="/member/mlm/payout/process-output" method="get">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><i class="fa fa-money"></i> PROCESS PAYOUT</h4>
    </div>
    <div class="modal-body clearfix">
        <div class="row">
            <div class="clearfix modal-body"> 
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="basic-input">What would you like to process?</label>
                            <select name="source" class="form-control">
                                <option value="wallet">Member's Wallet</option>
                                <option value="request">Member's Request</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="basic-input">Tax (%)</label>
                            <input type="text" class="form-control" name="tax" value="10">
                        </div>
                        <div class="col-md-6">
                            <label for="basic-input">Service Charge (PHP)</label>
                            <input type="text" class="form-control" name="service-charge" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="basic-input">Other Charge (PHP)</label>
                            <input type="text" class="form-control" name="other-charge" value="0">
                        </div>
                        <div class="col-md-6">
                            <label for="basic-input">Minimum Payout (PHP)</label>
                            <input type="text" class="form-control" name="minimum" value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="basic-input">Cutoff Date</label>
                            <input type="text" class="form-control datepicker" name="cutoff-date" value="{{ date('m/d/Y') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="basic-input">Method</label>
                            <select class="form-control" name="method">
                                <option value="all">Don't Filter Method</option>
                                <option value="unset">Unset Payout Method</option>
                                <option value="eon">Eon Card</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-primary btn-custom-primary"  type="button"><i class="fa fa-check"></i> Process Payout</button>
    </div>
</form>

<script type="text/javascript">
    $(".datepicker").datepicker();
</script>