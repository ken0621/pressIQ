<form class="global-submit" role="form" action="/member/mlm/point_log_complan/add" method="post">
    {{ csrf_field()  }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title redeemable-add-page-title">{{$page}}</h4>
    </div>
    <div class="modal-body clearfix">
        <div class="row">
            <div class="clearfix modal-body"> 
                <div class="form-horizontal">

                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Plan Code</label>
                            @if(isset($settings))
                            @foreach($settings as $setting)
                            <input id="basic-input" value="{{$setting->point_log_setting_plan_code}}" name="point_log_setting_name" class="form-control" autocomplete="off" required>
                            @endforeach
                            @else
                            <input id="basic-input" name="point_log_setting_plan_code" class="form-control" autocomplete="off" required>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label>Type</label>
                            <select name="point_log_setting_type" class="form-control type" style="width:100;" required>
                                <option value="RPV">RPV</option>
                                <option value="RGPV">RGPV</option>
                                <option value="SPV">SPV</option>
                                <option value="SGPV">SGPV</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Plan Name</label>
                            @if(isset($settings))
                            @foreach($settings as $setting)
                            <input id="basic-input" value="{{$setting->point_log_setting_name}}" name="point_log_setting_name" class="form-control" autocomplete="off" required>
                            @endforeach
                            @else
                            <input id="basic-input" name="point_log_setting_name" class="form-control" autocomplete="off" required>
                            @endif
                        </div>
                    </div>

                    <label>Notification</label>

                    <div class="notif">
                        <div class="form-group" id="notif1">
                            <div class="col-md-12">
                                @if(isset($settings))
                                @foreach($settings as $setting)
                                <input id="basic-input" value="{{$setting->point_log_notification}}" class="form-control sentence" id="sentence" autocomplete="off" required>
                                @endforeach
                                @else
                                <input id="basic-input" class="form-control sentence" id="sentence" autocomplete="off" required>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-4">
                            <a string="slot_no" style="width: 100%" class="btn btn-primary btn-custom-primary send append-variable">Slot no</a>
                        </div>
                        <div class="col-md-4">
                            <a string="sponsor_slot_no" style="width: 100%" class="btn btn-primary btn-custom-primary send append-variable">Sponsor slot no</a>
                        </div>
                        <div class="col-md-4">
                            <a string="amount" style="width: 100%" class="btn btn-primary btn-custom-primary send append-variable">Amount</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Notification: </label>
                        <label class="notification"></label>
                        <input type="hidden" name="point_log_notification" class="point_log_notification">
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal"><span class="fa fa-close" /> Close</button>
        <button class="btn btn-primary btn-custom-primary send" type="submit"><span class="fa fa-save" />
        @if(isset($settings))
         Save
        @else
         Create
        @endif
        </button>
    </div>
</form>

<script type="text/javascript">
    var x = null;
    $(document).ready(function()
    {
        var counter = 1;
        setSentence();
        $('body').on('keyup',function()
        {
            $('input').on('keyup',function()
            {
                clearTimeout(x);

                setTimeout(function()
                {
                    setSentence();
                    console.log("set sentence");
                },1000);
                
            });

            
        });
        // $("body").unbind('click');
        
    });
    function setSentence()
    {
        $('.notification').text("");

        var sentence = $('.sentence').val();

        $('.notification').text(sentence);
        $('.point_log_notification').val(sentence);
    }
</script>


