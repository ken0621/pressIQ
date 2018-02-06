<form class="global-submit form-horizontal" role="form" action="/member/item/token/add-token" method="post">
	{{ csrf_field()  }}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">{{$page}}</h4>
	</div>
	<div class="modal-body clearfix">
		<div class="form-group">
	        <div class="col-md-12">
	            <label for="basic-input">Token Name</label>
				<input id="basic-input" class="form-control" name="token_name" placeholder="Token Name">
	        </div>
	    </div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="submit">Save</button>
	</div>
</form>
<script type="text/javascript">
	function success(data)
	{
		toastr.success('Success');
		data.element.modal('hide');
		token.action_load_tokens();
	}
	function error_name()
	{
		toastr.error("Invalid Token Name");
	}
</script>