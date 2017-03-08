<form class="global-submit form-horizontal" role="form" action="/member/item/confirm_serial_submit" id="confirm_answer" method="post">
{!! csrf_field() !!}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Confirm Serial Number</h4>
</div>
<div class="modal-body add_new_package_modal_body clearfix">
    <div class="col-md-12">
        <h3>Do you want to add serial number to this product ?</h3>
    </div>
    <input type="hidden" name="answer" id="answer">
</div>
<div class="modal-footer">
    <div class="col-md-6"><button type="button" onclick="click_answer('yes')" class="btn btn-custom-blue col-md-12">Yes</button></div>
    <div class="col-md-6"><button type="button" onclick="click_answer('no')" class="btn btn-def-white btn-custom-white col-md-12">No</button></div>
</div>	
</form>
<script type="text/javascript">
    function click_answer(ans)
    {
        $("#answer").val(ans);
        $("#confirm_answer").submit();
    }
</script>
<!-- <script type="text/javascript" src="/assets/member/js/warehouse.js"></script> -->
<!-- <script type="text/javascript" src="/assets/member/js/transfer_warehouse.js"></script> -->