@extends('member.layout')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="panel panel-default panel-block panel-title-block" id="top">
    <div class="panel-heading">
        <div>
            <i class="fa fa-tags"></i>
            <h1>
                <span class="page-title">Auto Balance Tree</span>
                <small>
                    Fix Numbering of Auto Balance
                </small>
            </h1>
        </div>
    </div> 
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="col-md-6">
                <label for="rematrix_status">Slot No</label>
                <input class="form-control" id="retree_status" value="----" disabled>
            </div>
            <div class="col-md-6">
                <label for="rematrix_status">Slot Id</label>
                <input class="form-control" id="slot_id" value="----" disabled>
            </div>
            <div class="col-md-6">
                <label for="rematrix_status">Slot Count</label>
                <input class="form-control" id="slot_count" value="----" disabled>
            </div>
            <div class="col-md-12" style="min-height: 10px;"></div>
            <div class="col-md-2 pull-right">
                <button class="form-control btn-custom-primary apply_auto_entry">Apply Retree</button>
            </div>
        </div>
    </div>
</div>
@endsection
<style type="text/css">

</style>
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $("#retree_status").val("----");
    $("#slot_count").val($("#slot_count").attr("hidden_count"));
    var ctr       = 0;
    var slot_list = null;
    $(".apply_auto_entry").click(function()
    {
        $("#retree_status").val("Loading....");

        var link             = "/member/developer/auto_balance_tree/initialize";

        $.ajax(
        {
            url:link,
            dataType:"json",
            data: {_token: $(".token").val()},
            type:"post",
            success: function(data)
            {
                slot_list = data;
                retree(slot_list._slot[ctr].slot_id,slot_list._slot[ctr].slot_no);
            },
            error: function()
            {
              alert("Please try again, refresh the webpage.")
            }
        });

        
    });


    function retree($slot,$slot_no)
    {
        var link             = "/member/developer/auto_balance_tree/retree";
        var current_count    = ctr + 1;
        $("#retree_status").val("Current Slot No: "+$slot_no);
        $("#slot_id").val("Current Slot Id: "+$slot);
        $("#slot_count").val("Current Slot Count: "+current_count);
        $.ajax(
        {
            url:link,
            dataType:"json",
            data: {_token: $(".token").val(),slot_id : $slot},
            type:"post",
            success: function(data)
            {
                ctr++;
                if(typeof slot_list._slot[ctr] == 'undefined')
                {
                    $("#retree_status").val("Complete!  (Last Slot No is "+$slot_no+")");
                }
                else
                {
                    retree(slot_list._slot[ctr].slot_id,slot_list._slot[ctr].slot_no);
                }
                
            },
            error: function()
            {
                setTimeout(function()
                {
                    retree(slot_list._slot[ctr].slot_id,slot_list._slot[ctr].slot_no);
                }, 2000);
            }
        });
    }


</script>
@endsection