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

$('body').off('click', '#delete-selected-image');
$('body').on('click', '#delete-selected-image', function(event)
{
	event.preventDefault();
	event.stopPropagation();

	var r = confirm("Are you sure to delete?");

	if (r == true) 
	{
		$(".loader-aa").addClass('hide');
		$(".loader-bb").removeClass('hide');

		 to_be_delete = [];

	    $('.image-wrapper .image-container').each(function(index, el) 
		{
			to_be_delete.push($(el).attr('img-id'));
		});

		if (to_be_delete.length > 0) 
		{
			action_delete_selected_image(0)
		}
	}
});

function action_delete_selected_image(index)
{
	var img_id = to_be_delete[index];

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
		$('.image-container[img-id="'+img_id+'"]').remove();
		
		if (index == to_be_delete.length - 1) 
		{
			$(".loader-aa").removeClass('hide');
			$(".loader-bb").addClass('hide');

			$("#ModalGallery .selected").html(0);
		}
		else
		{
			action_delete_selected_image(index + 1);
		}
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
</script>

<style type="text/css">
.image-wrapper .check-logo
{
	display: none;
}
</style>
@endif