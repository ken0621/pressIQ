<style type="text/css">

</style>
<link rel="stylesheet" type="text/css" href="/assets/custom_plugin/myDropList/css/myDropList.css">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title layout-modallarge-title item_title">Maintenance</h4>
</div>
<div class="modal-body modallarge-body-layout background-white">
	<div class="text-right">
		<button class="btn btn-primary popup" button="type" link="/member/page/content/add-maintenance?field={{ $field }}&key={{ $key }}">Add</button>
	</div>
	<div class="table-holder" style="margin-top: 15px;">
		@if(count($_content) > 0)
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					@foreach(reset($_content) as $keys => $header)
					<th>{{ ucwords(str_replace(' ', '_', $keys)) }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($_content as $content)
				<tr>
					@foreach($content as $value)
					<td>{{ $value }}</td>
					@endforeach
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
	</div>
</div>
<script type="text/javascript">
function submit_done(data) 
{ 
	if (data.response_status == "success") 
	{
		$('.modal-loader').addClass("hidden");
		$('.table-holder').load('/member/page/content/maintenance?field={{ $field }}&key={{ $key }} .table-holder',
			function(){
			$('.maintenance-holder[key="'+data.key+'"]').val(data.result);
			$('.modal-loader').removeClass("hidden");
			toastr.success("Data has been successfully added.");
			$(data.element).modal("hide");
		});
	}
}
</script>