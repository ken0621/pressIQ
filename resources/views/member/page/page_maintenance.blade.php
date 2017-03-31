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
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($_content as $id => $content)
				<tr>
					@foreach($content as $value)
					<td>{!! $value !!}</td>
					@endforeach
					<td><a style="cursor: pointer;" class="popup" link="/member/page/content/edit-maintenance?key={{ $key }}&id={{ $id }}&field={{ $field }}">Edit</a> | <a class="popup" style="cursor: pointer;" link="/member/page/content/delete-maintenance?key={{ $key }}&id={{ $id }}">Delete</a></td>
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
		$('.modal-loader').removeClass("hidden");
		$('.table-holder').load('/member/page/content/maintenance?field={!! $field !!}&key={{ $key }} .table-holder table',
		function()
		{
			$('.maintenance-holder[key="'+data.key+'"]').val(data.result);
			$('.modal-loader').addClass("hidden");
			if (data.do == "delete") 
			{
				toastr.success("Data has been successfully deleted.");
			}
			else
			{
				toastr.success("Data has been successfully added.");
			}
			$(data.element).modal("hide");
		});

		$.ajax({
			url: '/member/page/content/maintenance-count',
			type: 'GET',
			dataType: 'json',
			data: {
				key: "{{ $key }}"
			},
		})
		.done(function(data) {
			$('.maintenance-count[key="{{ $key }}"]').html(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}
}
</script>