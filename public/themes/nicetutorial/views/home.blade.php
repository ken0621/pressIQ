@extends("layout")
@section("content")
<div class="content">
    <!-- BANNER -->
    <div class="wrapper1">
       <div class="container">
           <div class="logo-holder">
               <img src="/themes/{{ $shop_theme }}/img/logo-caption.png">
           </div>
            <div class="btn-scroll">Show More</div>
       </div>
    </div>
    <!-- WHO WE ARE -->
    <div class="wrapper2">
        <div class="container">
            <div class="title">
                Who we are
            </div>
            <div class="row clearfix ">
                <div class="col-md-6">
                    <div class="info">
                        <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, vel, totam. Eaque itaque molestiae, eos hic ullam libero ducimus? Incidunt optio impedit repellendus doloribus veniam quas dicta, a pariatur sunt.
                        </p>
                        div.
                    </div>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper3"></div>
    <div class="wrapper4"></div>
    <div class="wrapper5"></div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
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