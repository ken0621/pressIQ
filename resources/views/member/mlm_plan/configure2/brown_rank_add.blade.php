<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4 class="modal-title">CREATE BROWN RANK</h4>
</div>
<div class="modal-body clearfix">
    <div class="row">
        <div class="clearfix modal-body"> 
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="basic-input">Rank Name</label>
                        <input id="basic-input" value="" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Required Slots</label>
                        <input id="basic-input" value="5" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-6">
                        <label for="basic-input">Up to Level</label>
                        <select class="form-control">
                            @for($ctr=1; $ctr<=20; $ctr++)
                            <option value="1">{{ ordinal($ctr) }} Level</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Builder Reward Percentage</label>
                        <input id="basic-input" value="5" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-6">
                        <label for="basic-input">Up to Level</label>
                        <select class="form-control">
                            @for($ctr=1; $ctr<=20; $ctr++)
                            <option value="1">{{ ordinal($ctr) }} Level</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Leader Override Build Reward</label>
                        <input id="basic-input" value="10" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-6">
                        <label for="basic-input">Up to Level</label>
                        <select class="form-control">
                            <option value="0">Unlimited</option>
                            @for($ctr=1; $ctr<=20; $ctr++)
                            <option value="1">{{ ordinal($ctr) }} Level</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <label for="basic-input">Leader Override Direct Referral</label>
                        <input id="basic-input" value="10" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-6">
                        <label for="basic-input">Up to Level</label>
                        <select class="form-control">
                            <option value="0">Unlimited</option>
                            @for($ctr=1; $ctr<=20; $ctr++)
                            <option value="1">{{ ordinal($ctr) }} Level</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
    <button class="btn btn-primary btn-custom-primary" type="button">Save Rank</button>
</div>