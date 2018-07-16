@extends("layout")
@section("content")
<div class="content">
	<section style="padding: 60px 0;">
		<div class="container">
			<div class="media-wrapper">
				<div class="embed-responsive embed-responsive-16by9">
				    <!-- <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/sy655Z-7TZE?autoplay=1&showinfo=0&controls=0" controls="0" allowfullscreen="" frameborder="0">                            
				    </iframe> -->
				    <!-- <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/rzyKBUX18Wc?ecver=1&modestbranding=1&rel=0&autohide=1&showinfo=0&controls=0" controls="0" frameborder="0" allowfullscreen>
				    </iframe> -->
				    <iframe class="embed-responsive-item" src="{{ get_content($shop_theme_info, "video", "video_link") }}?ecver=1&modestbranding=1&rel=0&autohide=1&showinfo=0&controls=0" controls="0" frameborder="0" allowfullscreen>
				    </iframe>
				</div>
				<h1 style="color: #006cc5;">You have been invited!</h1>
				<div>
					<button style="background-color: #ff8500; border: none; padding: 10px; color: #fff; font-weight: bold;" onclick="location.href='/members/register'">Click here to register</button>
				</div>
			</div>	
		</div>
	</section>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/replicated.css">
@endsection