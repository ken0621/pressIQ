@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
<div class="background-container">
    <div class="container">
    	<div class="border-container">
    		<div class="border-background-container">
                {{-- @foreach ($pr as $prs)
    			<div class="heading-container">{{$prs->pr_headline}}</div>
    			<div class="sender-container"><span class="title-sender">Published by </span><span class="sender-name">Carlo Segovia</span></div>
    			<div class="date-container">10/05/2017</div>
    			<div class="content-container">{!!$prs->pr_content!!}</div>
                @endforeach --}}
                <div class="heading-container">Liana Technology</div>
                <div class="sender-container"><span class="title-sender">Published by </span><span class="sender-name">Carlo Segovia</span></div>
                <div class="date-container">10/05/2017</div>
                <div class="content-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed velit eaque praesentium neque consectetur fugiat, laboriosam blanditiis pariatur cumque saepe voluptatibus, nostrum eum sint necessitatibus magni ut quidem id maiores provident inventore veniam aliquam laudantium? Similique excepturi suscipit recusandae qui ex modi, totam aut, cupiditate dolorem ipsam minus magni beatae, animi vitae tempora eligendi distinctio aliquam. Ut officiis labore, animi voluptate, harum dolore consequatur cum dolores. Totam deserunt maiores eveniet, voluptas nam repudiandae commodi nihil, dolores magnam sunt ut quaerat odio ab consequatur laboriosam provident saepe nostrum, laborum mollitia vero alias animi ex earum. Quibusdam quis minus magni, facilis esse!</div>
                <div class="border"></div>
                <div class="title-about-container">About the publisher</div>
                <div class="title-publisher-container">About Oceania Cruises</div>
                <div class="content-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed velit eaque praesentium neque consectetur fugiat, laboriosam blanditiis pariatur cumque saepe voluptatibus, nostrum eum sint necessitatibus magni ut quidem id maiores provident inventore veniam aliquam laudantium? Similique excepturi suscipit recusandae qui ex modi, totam aut, cupiditate dolorem ipsam minus magni beatae, animi vitae tempora eligendi distinctio aliquam. Ut officiis labore, animi voluptate, harum dolore consequatur cum dolores. Totam deserunt maiores eveniet, voluptas nam repudiandae commodi nihil, dolores magnam sunt ut quaerat odio ab consequatur laboriosam provident saepe nostrum, laborum mollitia vero alias animi ex earum. Quibusdam quis minus magni, facilis esse!</div>
    		</div>
    	</div>
    </div>
</div>

    <!-- SCROLL TO TOP -->
    <div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/news_room_view.css">
@endsection

@section("script")

<script type="text/javascript">
/*$(document).ready(function($) {

        //START MISSION AND VISION
        $(".title-vision").click(function()
        {
            $("#vision").removeClass("hide");
            $("#mission").addClass("hide");
            $(".title-vision").addClass("highlighted");
            $(".title-mission").removeClass("highlighted");
            
        });
        $(".title-mission").click(function()
        {
            $("#vision").addClass("hide");
            $("#mission").removeClass("hide");
            $(".title-mission").addClass("highlighted");
            $(".title-vision").removeClass("highlighted");
        });
        //END MISSION ANF VISION
});*/
</script>

@endsection