<form class="global-submit " role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Create Journal Tags</h4>
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-12">
				<small>Accounts Name</small>
				<select class="form-control select-account">
					<option value="">Select Account</option>
					@foreach($_expense as $expense)
					<option value="{{$expense->account_id}}">{{$expense->account_number.' . '.$expense->account_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
	</div>
</form>
<script type="text/javascript" src="/assets/member/js/payroll/modal_create_journal_tag.js"></script>