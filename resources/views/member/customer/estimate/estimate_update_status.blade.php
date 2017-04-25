<form class="global-submit form-horizontal" role="form" action="/tablet/pis/sir/lof_action_submit" id="confirm_answer" method="post">
{!! csrf_field() !!}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Update</h4>
</div>
<div class="modal-body add_new_package_modal_body clearfix">
    <div class="col-md-12">
        <h3>Update Estimate Status # {{sprintf("%'.05d\n", $estimate_id)}}</h3>
    </div>
    <div class="col-md-12">
        <label>Status</label> <br>
        <select class="status-select" name="status">
        @foreach($status as $stat)
        <option {{$stat == $est->est_status ? 'selected=selected' : ''}} value="{{$stat}}">{{ucfirst($stat)}}</option>
        @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label>Accepted By:</label>
        <input type="text" class="form-control" name="accepted_by" value="{{$est->est_accepted_by}}">
    </div>
    <div class="col-md-12">
        <label>Accepted Date:</label>
        <input type="text" class="form-control datepicker" name="accepted_by" value="{{date($est->est_accepted_date)}}">
    </div>
    <input type="hidden" name="estimate_id" value="{{$estimate_id}}">
</div>
<div class="modal-footer">
    <div class="col-md-6 col-xs-6"><button type="submit" class="btn btn-custom-blue form-control">Yes</button></div>
    <div class="col-md-6 col-xs-6"><button data-dismiss="modal" class="btn btn-def-white btn-custom-white form-control">No</button></div>
</div>	
</form>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>
<script type="text/javascript">
    $(".status-select").globalDropList(
    {
        hasPopup: "false",
        width : "100%"     
    });
     $(".datepicker").datepicker();
    // $(".status-select").val($(".status-select").find("option:first").val()).change();
</script>