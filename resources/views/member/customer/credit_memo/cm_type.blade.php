
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Confirm</h4>
</div>
<!-- 	<div class="modal-body add_new_package_modal_body clearfix">
    <div class="col-md-12">
    </div>
</div> -->
<div class="modal-footer">
    @if(isset($for_tablet))
    <div class="col-md-6 col-xs-12">
    	<a class="btn btn-custom-blue form-control" href="/tablet/credit_memo/add?sir_id={{Session::get('sir_id')}}&type=returns">RETURNS</a>
    </div>
    <div class="col-md-6 col-xs-12">
    	<a class="btn btn-def-white btn-custom-white form-control" href="/tablet/credit_memo/add?sir_id={{Session::get('sir_id')}}&type=others">OTHERS</a>
    </div>
    @else
    <div class="col-md-6 col-xs-12">
        <a class="btn btn-custom-blue form-control" href="/member/customer/credit_memo?type=returns">RETURNS</a>
    </div>
    <div class="col-md-6 col-xs-12">
        <a class="btn btn-def-white btn-custom-white form-control" href="/member/customer/credit_memo?type=others">OTHERS</a>
    </div>
    @endif
</div>