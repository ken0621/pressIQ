<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">COPY LEAD LINK BELOW</h4>
</div>
<div class="modal-body clearfix">
	<input style="width: calc(100% - 200px)" class="form-control pull-left" type="text" value="{{ $url }}/ref/{{ request('slot_no') }}"/>
    <button onclick="return ClipBoard()" class="pull-right btn btn-primary" style="width: 190px;">COPY LINK</button>
</div>

<script type="text/javascript">
    
function ClipBoard()
{
    window.clipboardData.setData("Text", "gu");
}

</script>