@extends("layout")
@section("content")
<div class="content">
    <!-- Media Slider -->
<div class="background-container">
    <div class="container">
    	<div class="border-container">
    		<div class="border-background-container">
    			<div class="heading-container">Liana Technologies</div>
    			<div class="sender-container"><span class="title-sender">Published by </span><span class="sender-name">Carlo Segovia</span></div>
    			<div class="date-container">10/05/2017</div>
    			<div class="content-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos asperiores in recusandae officiis quae soluta culpa eveniet explicabo, iusto atque doloribus id accusamus dolores aspernatur veritatis. Ab minus, amet nam cupiditate eligendi ad harum dolorem commodi inventore minima, dolores. Est magnam, molestiae temporibus ex optio blanditiis quas! In, voluptates, laborum. Soluta sit impedit illo architecto iste provident ipsa eveniet qui praesentium odit laudantium quam obcaecati, ducimus eos itaque eum tempora, possimus quidem error ipsam minima assumenda minus. Ipsa, sint natus voluptates laborum perspiciatis inventore harum aliquid odio.</div>
    			<div class="content-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos asperiores in recusandae officiis quae soluta culpa eveniet explicabo, iusto atque doloribus id accusamus dolores aspernatur veritatis. Ab minus, amet nam cupiditate eligendi ad harum dolorem commodi inventore minima, dolores. Est magnam, molestiae temporibus ex optio blanditiis quas! In, voluptates, laborum. Soluta sit impedit illo architecto iste provident ipsa eveniet qui praesentium odit laudantium quam obcaecati, ducimus eos itaque eum tempora, possimus quidem error ipsam minima assumenda minus. Ipsa, sint natus voluptates laborum perspiciatis inventore harum aliquid odio.</div>
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