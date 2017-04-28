<form class="global-submit form-horizontal" role="form" action="{link_submit_here}" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Paper Sizes</h4>
	</div>
	<div class="modal-body form-horizontal">
		<div class="form-group">
			<div class="col-md-6">
				<div class="form-group">
					<div class="col-md-12">
						<small>Paper size name</small>
						<input type="text" name="" class="form-control" placeholder="Paper size name">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-6">
						<small>Paper width (cm)</small>
						<input type="number" step="any" name="" class="form-control text-right">
					</div>	
					<div class="col-md-6">
						<small>Paper height (cm)</small>
						<input type="number" step="any" name="" class="form-control text-right">
					</div>
				</div>
			</div>
		
			<div class="col-md-6">
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>Paper Name</th>
							<th>Width (cm)</th>
							<th>Height (cm)</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($_paper as $paper)
						<tr>
							<td>
								{{$paper->paper_size_name}}
							</td>
							<td class="text-right">
								{{$paper->paper_size_width}}
							</td>
							<td class="text-right">
								{{$paper->paper_size_height}}
							</td>
							<td></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-def-white btn-custom-white" data-dismiss="modal">Close</button>
		<button class="btn btn-primary btn-custom-primary" type="button"">Submit</button>
	</div>
</form>