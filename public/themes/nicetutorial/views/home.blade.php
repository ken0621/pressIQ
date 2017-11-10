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
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, vel, totam. Eaque itaque molestiae, eos hic ullam libero ducimus? Incidunt optio impedit repellendus doloribus veniam quas dicta, a pariatur sunt.Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, vel, totam. Eaque itaque molestiae, eos hic ullam libero ducimus? Incidunt optio impedit repellendus doloribus veniam quas dicta, a pariatur sunt.Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, vel, totam. Eaque itaque molestiae, eos hic ullam libero ducimus? Incidunt optio impedit repellendus doloribus veniam quas dicta, a pariatur sunt.
                        </p>
                        <div class="btn-more">More</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img-holder">
                        <img src="/themes/{{ $shop_theme }}/img/whoWeAre.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper3">
        <div class="container">
            <div class="title">
                Why Join in NICE Enterprises
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                   <div class="per-col col-1">
                       <div class="img-holder">
                           <img src="/themes/{{ $shop_theme }}/img/join-1.png">
                       </div>
                       <div class="info-title">
                           Lorem Ipsum
                       </div>
                       <div class="info">
                           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias nobis, quaerat qui illo vel maxime accusamus beatae sit iste ipsa obcaecati aliquid cum aut unde quidem eligendi assumenda minima quasi.</p>
                       </div>
                   </div> 
                </div>
                <div class="col-md-4">
                    <div class="per-col col-2">
                        <div class="img-holder">
                            <img src="/themes/{{ $shop_theme }}/img/join-2.png">
                        </div>
                        <div class="info-title">
                            Lorem Ipsum
                        </div>
                        <div class="info">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias nobis, quaerat qui illo vel maxime accusamus beatae sit iste ipsa obcaecati aliquid cum aut unde quidem eligendi assumenda minima quasi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                   <div class="per-col col-3">
                       <div class="img-holder">
                           <img src="/themes/{{ $shop_theme }}/img/join-3.png">
                       </div>
                       <div class="info-title">
                           Lorem Ipsum
                       </div>
                       <div class="info">
                           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias nobis, quaerat qui illo vel maxime accusamus beatae sit iste ipsa obcaecati aliquid cum aut unde quidem eligendi assumenda minima quasi.</p>
                       </div>
                   </div> 
                </div>
                
            </div>
        </div>
    </div>
    <div class="wrapper4">
        <div class="container">
            <div class="title">Membership Packages</div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="col-1">
                        <div class="rectangle-1">
                            <div class="rectangle-2">
                                <div class="title-package">
                                    Package 1
                                </div>
                                <div class="title-package">
                                    $20
                                </div>
                            </div>
                            <div class="info">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi quasi aliquid inventore, dolore reiciendis unde sequi nemo mollitia debitis totam illo nisi eveniet commodi. Sit iusto, mollitia impedit repudiandae exdolore reiciendis unde sequi nemo mollitia debitis totam illo nisi eveniet commodi. Sit iusto, mollitia impedit repudiandae.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-2">
                        <div class="rectangle-1">
                            <div class="rectangle-2">
                                <div class="title-package">
                                    Package 2
                                </div>
                                <div class="title-package">
                                    $20
                                </div>
                            </div>
                            <div class="info">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi quasi aliquid inventore, dolore reiciendis unde sequi nemo mollitia debitis totam illo nisi eveniet commodi. Sit iusto, mollitia impedit repudiandae exdolore reiciendis unde sequi nemo mollitia debitis totam illo nisi eveniet commodi. Sit iusto, mollitia impedit repudiandae.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-3">
                        <div class="rectangle-1">
                            <div class="rectangle-2">
                                <div class="title-package">
                                    Package 3
                                </div>
                                <div class="title-package">
                                    $20
                                </div>
                            </div>
                            <div class="info">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi quasi aliquid inventore, dolore reiciendis unde sequi nemo mollitia debitis totam illo nisi eveniet commodi. Sit iusto, mollitia impedit repudiandae exdolore reiciendis unde sequi nemo mollitia debitis totam illo nisi eveniet commodi. Sit iusto, mollitia impedit repudiandae.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
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