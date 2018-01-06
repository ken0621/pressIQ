@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
<div class="background-container">
    <div class="container">
    	<div class="border-container">
    		<div class="border-background-container">
                <div class="row-no-padding clearfix">
                @foreach ($pr as $prs)    
                    <div class="col-md-9">
                        <div class="left-container">
                            
                            <div class="heading-container">{{$prs->pr_headline}}</div>
                            <div class="sender-container"><span class="title-sender">Published by </span><span class="sender-name">{{$prs->pr_sender_name}}</span></div>
                            <div class="date-container">{{$prs->pr_date_sent}}</div>
                            <div class="content-container">{!!$prs->pr_content!!}</div>
                            <div class="border"></div>
                            <div class="title-about-container">About {{$prs->pr_co_name}}</div>
                            <div class="content-container">{!!$prs->pr_boiler_content!!}</div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="right-container">
                            <div class="company-name-container">
                                <div class="company-name">{{$prs->pr_co_name}}</div>
                            </div>
                            <div class="logo-holder">
                                <img src="{{$prs->pr_co_img}}">
                            </div>
                            <div class="header">Latest releases of industry</div>
                            <div class="release-container">
                                <div class="title"><a href="#">5 IMPORTANT THINGS TO LOOK IN A PLAY AREA FOR YOUR KIDS</a></div>
                                <div class="date-container"><span><i class="fa fa-clock-o" aria-hidden="true"></i></span><span>28.12.2017 10:28</span></div>
                            </div>
                            <div class="release-container">
                                <div class="title"><a href="#">SnapPop Update Lets You Attach Your Christmas Singing To Stamps</a></div>
                                <div class="date-container"><span><i class="fa fa-clock-o" aria-hidden="true"></i></span><span>22.12.2017 11:16</span></div>
                            </div>
                            <div class="release-container">
                                <div class="title"><a href="#">Sail To Taiwan - The Ultimate Blue-Water Experience</a></div>
                                <div class="date-container"><span><i class="fa fa-clock-o" aria-hidden="true"></i></span><span>07.12.2017 15:49</span></div>
                            </div>
                            <div class="release-container">
                                <div class="title"><a href="#">Liana Technologies ranked on the Deloitte Technology Fast 50 Finland list for the eighth year in a row</a></div>
                                <div class="date-container"><span><i class="fa fa-clock-o" aria-hidden="true"></i></span><span>04.12.2017 07:00</span></div>
                            </div>
                        </div>  
                    </div>
                @endforeach    
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