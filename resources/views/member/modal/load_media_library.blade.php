@if(!Request::input("page"))
<div class="wew-container">
@endif

<div class="loader-aa">
	@if(isset($_image))
		@foreach($_image as $image)
			@if($image)
			<div class="image-container" img-id="{{$image->image_id}}">
		        <a href="javascript:" class="delete-image"><div class="check-logo" style="padding: 4px 9px;background-color: #c0392b; border: 0;"><i class="fa fa-times" aria-hidden="true"></i></div></a>
		        <img src="{{$image->image_path}}">
		    </div>
			@endif
		@endforeach

		<div class="text-right image-pagination">
			{{ $_image->appends(Request::input())->links() }}
		</div>
	@endif
</div>

@if(!Request::input("page"))
</div>
@endif

@if(!Request::input("page"))
<div class="text-center loader-bb hide">
	<img src="/assets/member/img/91.gif">
</div>

<script type="text/javascript">
$('body').off('click', '.image-pagination a');
$('body').on('click', '.image-pagination a', function(event)
{
	$(".loader-aa").addClass('hide');
	$(".loader-bb").removeClass('hide');

	event.stopPropagation();
	event.preventDefault();

	var page_url = $(event.currentTarget).attr("href");

	$.ajax({
		url: page_url,
		type: 'GET',
		dataType: 'html',
	})
	.done(function(html) 
	{
		$(".loader-aa").removeClass('hide');
		$(".loader-bb").addClass('hide');
		$(".wew-container").html(html);
	})
	.fail(function() 
	{
		console.log("error");
	})
	.always(function() 
	{
		console.log("complete");
	});
});

$('body').off('click', '.delete-image');
$('body').on('click', '.delete-image', function(event) 
{
	var r = confirm("Are you sure to delete?");

	if (r == true) 
	{
	    event.preventDefault();
		event.stopPropagation();

		$(".loader-aa").addClass('hide');
		$(".loader-bb").removeClass('hide');

		var img_id = $(event.currentTarget).parent().attr('img-id');

		$.ajax({
			url: '/image/delete_image',
			type: 'GET',
			dataType: 'json',
			data: 
			{
				img_id: img_id
			},
		})
		.done(function() 
		{
			$(event.currentTarget).parent().remove();
			$(".loader-aa").removeClass('hide');
			$(".loader-bb").addClass('hide');
		})
		.fail(function() 
		{
			console.log("error");
		})
		.always(function() 
		{
			console.log("complete");
		});
	}
});
</script>

<style type="text/css">
.image-wrapper .check-logo
{
	display: none;
}
</style>
@endif