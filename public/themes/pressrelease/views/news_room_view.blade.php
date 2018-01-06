@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
<div class="background-container">
    <div class="container">
    	<div class="border-container">
    		<div class="border-background-container">
                <div class="row-no-padding clearfix">
                    <div class="col-md-9">
                        <div class="left-container">
                            @foreach ($pr as $prs)
                            <div class="heading-container">{{$prs->pr_headline}}</div>
                            <div class="sender-container"><span class="title-sender">Published by </span><span class="sender-name">{{$prs->pr_sender_name}}</span></div>
                            <div class="date-container">{{$prs->pr_date_sent}}</div>
                            <div class="content-container">{!!$prs->pr_content!!}</div>
                            <div class="border"></div>
                            <div class="title-about-container">About {{$prs->pr_sender_name}}</div>
                            <div class="content-container">{!!$prs->pr_boiler_content!!}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="right-container">
                            <div class="company-name-container">
                                <div class="company-name">Press Release</div>
                            </div>
                            <div class="logo-holder">
                                <img src="/themes/{{ $shop_theme }}/img/header-logo.png">
                            </div>
                        </div>
                            
                        </div>
                    </div>
                </div>
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