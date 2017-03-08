<form class="global-submit form-horizontal" role="form" action="/member/utilities/archive-user" method="post">
	<input type="hidden" name="_token" value={{csrf_token()}}>
	<input type="hidden" name="user_id" value={{$user->user_id}}>
	<div class="modal-header" style="text-align: center !important;">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Delete this User ({{$user->user_first_name}}) ?</h4>
	</div>
	<div class="modal-footer" style="text-align: center !important;">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="submit">Confirm</button>
	</div>
</form>

@section('script')

@endsection