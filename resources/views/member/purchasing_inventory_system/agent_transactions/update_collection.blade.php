<form class="global-submit form-horizontal" role="form" action="/member/pis_agent/collection_update_submit" id="confirm_answer" method="post">
{!! csrf_field() !!}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Update Collection</h4>
</div>
<div class="modal-body add_new_package_modal_body clearfix">
    <div class="col-md-12">
        <label>Amount Remitted</label>
        <input type="text" class="form-control" required name="agent_collection">
    </div>
    <div class="col-md-12">
        <label>Collection Remarks</label>
        <textarea class="form-control textarea-expand" required name="agent_remarks"></textarea>
    </div>
    <input type="hidden" name="sir_id" value="{{$sir_id}}">
</div>
<div class="modal-footer">
    <div class="col-md-6 col-xs-6"><button type="submit" class="btn btn-custom-blue form-control">Update</button></div>
    <div class="col-md-6 col-xs-6"><button data-dismiss="modal" class="btn btn-def-white btn-custom-white form-control">Cancel</button></div>
</div>	
</form>
<script type="text/javascript" src="/assets/member/js/textExpand.js"></script>