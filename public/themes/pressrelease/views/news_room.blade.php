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
                <div class="news-title-container">
                    <div class="title"><a href="/newsroom/view">Liana Technology</a></div>
                </div>  
                <div class="details-container">
                    <p class="details">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos asperiores in recusandae officiis quae soluta culpa eveniet explicabo, iusto atque doloribus id accusamus dolores aspernatur veritatis. Ab minus, amet nam cupiditate eligendi ad harum dolorem commodi inventore minima, dolores. Est magnam, molestiae temporibus ex optio blanditiis quas! In, voluptates, laborum. Soluta sit impedit illo architecto iste provident ipsa eveniet qui praesentium odit laudantium quam obcaecati, ducimus eos itaque eum tempora, possimus quidem error ipsam minima assumenda minus. Ipsa, sint natus voluptates laborum perspiciatis inventore harum aliquid odio.<br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos asperiores in recusandae officiis quae soluta culpa eveniet explicabo, iusto atque doloribus id accusamus dolores aspernatur veritatis. Ab minus, amet nam cupiditate eligendi ad harum dolorem commodi inventore minima, dolores. Est magnam, molestiae temporibus ex optio blanditiis quas! In, voluptates, laborum. Soluta sit impedit illo architecto iste provident ipsa eveniet qui praesentium odit laudantium quam obcaecati, ducimus eos itaque eum tempora, possimus quidem error ipsam minima assumenda minus. Ipsa, sint natus voluptates laborum perspiciatis inventore harum aliquid odio.</p>
                </div>
                <div class="button-container">
                    <button onclick="window.location.href='/newsroom/view'">Read More</button>
                </div>
                <div class="news-title-container">
                    <div class="title"><a href="/newsroom/view">Press Release</a></div>
                </div>  
                <div class="details-container">
                    <p class="details">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos asperiores in recusandae officiis quae soluta culpa eveniet explicabo, iusto atque doloribus id accusamus dolores aspernatur veritatis. Ab minus, amet nam cupiditate eligendi ad harum dolorem commodi inventore minima, dolores. Est magnam, molestiae temporibus ex optio blanditiis quas! In, voluptates, laborum. Soluta sit impedit illo architecto iste provident ipsa eveniet qui praesentium odit laudantium quam obcaecati, ducimus eos itaque eum tempora, possimus quidem error ipsam minima assumenda minus. Ipsa, sint natus voluptates laborum perspiciatis inventore harum aliquid odio.<br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos asperiores in recusandae officiis quae soluta culpa eveniet explicabo, iusto atque doloribus id accusamus dolores aspernatur veritatis. Ab minus, amet nam cupiditate eligendi ad harum dolorem commodi inventore minima, dolores. Est magnam, molestiae temporibus ex optio blanditiis quas! In, voluptates, laborum. Soluta sit impedit illo architecto iste provident ipsa eveniet qui praesentium odit laudantium quam obcaecati, ducimus eos itaque eum tempora, possimus quidem error ipsam minima assumenda minus. Ipsa, sint natus voluptates laborum perspiciatis inventore harum aliquid odio.</p>
                </div>
                <div class="button-container">
                    <button onclick="window.location.href='/newsroom/view'">Read More</button>
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