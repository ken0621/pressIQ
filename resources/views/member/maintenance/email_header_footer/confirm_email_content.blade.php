<form class="global-submit form-horizontal" role="form" action="/member/maintenance/email_content/archived_submit" id="confirm_answer" method="post">
{!! csrf_field() !!}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Confirm</h4>
</div>
<div class="modal-body add_new_package_modal_body clearfix">
    <div class="col-md-12">
        <h3>Are you sure you want to {{$action}} this email content ?</h3>
    </div>
    <div class="col-md-12 text-center">
        <h4>{{$email_content->payment_name}}</h4>
    </div>
    <input type="hidden" name="email_content_id" value="{{$email_content_id}}">
    <input type="hidden" name="action" value="{{$action}}">
</div>
<div class="modal-footer">
    <div class="col-md-6"><button type="submit" class="btn btn-custom-blue col-md-12">Yes</button></div>
    <div class="col-md-6"><button data-dismiss="modal" class="btn btn-def-white btn-custom-white col-md-12">No</button></div>
</div>	
</form>