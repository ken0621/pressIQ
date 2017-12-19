@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
<div class="background-container">
    <div class="container">
        <div class="border-container">
            <div class="background-border-container">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="search-container">
                            <input type="text" placeholder="Search News"><span><a href="#"><i class="fa fa-search" aria-hidden="true" her></i></span></a>
                        </div>
                    </div>
                </div>
                @foreach ($pr as $prs)
                <div class="news-title-container">
                    <div class="title"><a href="/newsroom/view/{{$prs->pr_id}}">{{$prs->pr_headline}}</a></div>
                </div>  
                <div class="details-container">
                    <p class="details">{!!$prs->pr_content!!}</p>
                </div>
                <div class="button-container">
                    <button onclick="window.location.href='/newsroom/view/{{$prs->pr_id}}'">Read More</button>
                </div>
                @endforeach
                {{-- <div class="news-title-container">
                    <a href="/newsroom/view">Liana Technology</a>
                </div>  
                <div class="details-container">
                    <p class="details">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor consequuntur eaque autem nihil excepturi fugiat, voluptates aspernatur provident odit beatae aliquam natus eveniet, iusto ex alias eum officia quod labore voluptatem corporis, sunt expedita ullam rerum non! Minus officiis ratione eum. Quasi, molestiae! Sequi vel debitis non, nostrum sit iste hic tenetur expedita! Ut molestiae reprehenderit tempora fugit. Perferendis autem cumque et, itaque asperiores eligendi culpa ipsam exercitationem explicabo, distinctio enim unde harum laborum ducimus aspernatur ratione accusantium neque! Rem itaque, saepe nobis consectetur quod provident iure, doloremque culpa tempora delectus voluptas accusantium repellendus optio. Ducimus corrupti architecto amet vero.</p>
                </div>
                <div class="button-container">
                    <button onclick="window.location.href='/newsroom/view'">Read More</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>

    <!-- SCROLL TO TOP -->
    <div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/news_room.css">
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