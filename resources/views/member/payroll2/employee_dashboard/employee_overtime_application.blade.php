<div class="modal-header">
    <h5 class="modal-title">{{ $page }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body form-horizontal">
	<div class="row">
		<div class="col-md-6" class="text-center">
			<a href="/employee_overtime_view_shift">View Shift Schedule</a>
		</div>
		<div class="col-md-6">
			<small>Overtime Type</small>
			<select class="form-control" required></select>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<small>OT Date</small>
			<input class="form-control" type="date" class="date_picker" required>
		</div>
		<div class="col-md-3">
			<small>OT in</small>
			<input class="form-control" type="time" required>
		</div>
		<div class="col-md-3">
			<small>OT out</small>
			<input class="form-control" type="time">
		</div>
	</div>
	<div class="row">
        <div class="col-sm-12">
        <small>Remarks</small>
        	<textarea class="form-control" name="other_info" rows="4" required></textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
	<button type="button"  class="btn btn-primary btn-md">Cancel</button>
	<button type="submit"  class="btn btn-primary btn-md">Submit</button>
</div>
