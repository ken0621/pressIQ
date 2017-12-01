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
                            <input id="basic-input" name="point_log_setting_plan_code" class="form-control" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label>Type</label>
                            <select name="point_log_setting_type" class="form-control type" style="width:100;">
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
                            <input id="basic-input" name="point_log_setting_name" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <label>Notification</label>

                    <div class="notif">
                        <div class="form-group" id="notif1">
                            <div class="col-md-7">
                                <input id="basic-input" class="form-control sentence" id="sentence" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <select onchange="setSentence()" class="form-control variable" style="width:100;">
                                    <option value=""></option>
                                    <option value="<slot no>">&lt;slot no&gt;</option>
                                    <option value="<sponsor slot no>">&lt;sponsor slot no&gt;</option>
                                    <option value="<sponsor name>">&lt;sponsor name&gt;</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <font color="green"><i style="margin-top: 10px;float: left;" class="fa fa-plus plus"></i></font>
                                <font color="red"><i style="margin-top: 10px;float: right;" class="fa fa-close minus"></i></font>
                            </div>
                                
                        </div>
                    </div>
                    <br>
                    <div>
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
        <button class="btn btn-primary btn-custom-primary send" type="submit"><span class="fa fa-save" />  Create</button>
    </div>
</form>

<script type="text/javascript">
    var x = null;
    $(document).ready(function()
    {
        var counter = 1;
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
        $('body').unbind('click');
        $('body').on('click','.plus',function()
        {
            $('.notif').append('<div class="form-group" id="notif">'+
                            '<div class="col-md-7">'+
                                '<input id="basic-input" class="form-control sentence" id="sentence" autocomplete="off">'+
                           '</div>'+
                            '<div class="col-md-4">'+
                                '<select onchange="setSentence()" class="form-control variable" style="width:100;">'+
                                    '<option value=""></option>'+
                                    '<option value="<slot no>">&lt;slot no&gt;</option>'+
                                    '<option value="<sponsor slot no>">&lt;sponsor slot no&gt;</option>'+
                                    '<option value="<sponsor name>">&lt;sponsor name&gt;</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="col-md-1">'+
                                '<font color="green"><i style="margin-top: 10px;float: left;" class="fa fa-plus plus"></i></font>'+
                                '<font color="red"><i style="margin-top: 10px;float: right;" class="fa fa-close minus"></i></font>'+
                            '</div>'+
                                
                        '</div>');
        });
    });
    function setSentence()
    {
        $('.notification').text("");

                var x ="";

                var sentences='';
                var variables='';

                $( ".sentence" ).each(function( index )
                {
                    // var variable = document.getElementByClass('variable');
                  sentences += $( this ).val()+"/";
                });

                $( ".variable" ).each(function( index )
                {
                    // var variable = document.getElementByClass('variable');
                  variables += $( this ).val()+"/";
                });

                // console.log(sentences);
                // console.log(variables);
                var split_sen = sentences.split("/");
                var split_var = variables.split("/");

                // console.log(split_sen[0]+" "+split_var[0]);  

                for(var y=0;y<split_sen.length;y++)
                {
                    x+=split_sen[y]+" "+split_var[y]+" ";
                }

                 $('.notification').text(x);
                 $('.point_log_notification').val(x);
    }
</script>

<script type="text/javascript">
    function success(data)
    {
        toastr.success("Setting created");
        data.element.modal('hide');
    }
    function error(data)
    {
        toastr.error("Error");
    }
</script>

