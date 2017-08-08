<form class="global-submit form-horizontal" role="form" action="/member/mlm/developer/create_slot" method="post">
	{{ csrf_field() }}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">CREATE MLM SLOT FOR TESTING</h4>
	</div>
	<div class="modal-body clearfix">
         <div class="form-group">
            <div class="col-md-12">            
                <label>SPONSOR</label>
                <input name="sponsor" type="text" class="form-control" placeholder="RANDOM (IF EMPTY)">
            </div>
        </div>
        @if($enable_binary == 1)
        <div class="form-group">
            @if($enable_auto_place == 0)
                <div class="col-md-6">            
                    <label>PLACEMENT</label>
                    <input name="placement" type="text" class="form-control" placeholder="RANDOM (IF EMPTY)">
                </div>
                <div class="col-md-6">            
                    <label>POSITION</label>
                    <select name="position" class="form-control">
                        <option>RANDOM</option>
                    	<option>LEFT</option>
                    	<option>RIGHT</option>
                    </select>
                </div>
            @else
                    <!-- Auto place  -->
            @endif

        </div>
        @endif
        <div class="form-group">
            <div class="col-md-12">            
                <label>MEMBERSHIP</label>
                <select name="membership" class="form-control">
                    @foreach($_membership as $membership)
                	<option value="{{ $membership->membership_package_id }}">{{ $membership->membership_package_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="submit">Create Slot</button>
	</div>
</form>

<script type="text/javascript">
	function create_test_slot_done(data)
	{
		$("#global_modal").modal("hide");
        mlm_developer.action_load_data();
	}
</script>