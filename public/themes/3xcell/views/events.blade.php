@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container">
		<div class="container">
			<div class="title-container">Company Events</div>
		</div>
	</div>
	<div class="top-2-container">
		<div class="container">
			<div class="events-container row clearfix">
				@if(count(get_front_news($shop_id)) > 0)
					@foreach(get_front_news($shop_id) as $news)
							<div class="col-md-6">
								<div class="per-event row clearfix">
									<div class="col-md-6">
										<div class="event-image-container">
											<a href="/news?id={{ $news->post_id }}">
												<img src="{{ $news->post_image }}">
											</a>
										</div>
									</div>
									<div class="col-md-6">
										<div class="event-details-container">
											<h1>
												{{ $news->post_title }}	
											</h1>
											<h2>
												{{ $news->post_excerpt }}
											</h2>
										</div>
									</div>
								</div>
							</div>
					@endforeach
				@else
					<span>Coming Soon!</span>
				@endif
			</div>			
		</div>
	</div>

	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/events.css">
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 700) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 700);
        return false;
    });
});
</script>
@endsection