@extends('layout')
@section('content')
<div class="top_wrapper no-transparent">
   <!-- SLIDER -->
   <div class="slide-container">
      @if(isset($_slider[0]))
         @foreach($_slider as $slider)
         <div>
            <img src="/uploads/{{ $slider->image }}">
         </div>
         @endforeach
      @else
         <div>
            <img src="resources/assets/front/img/1.jpg">
         </div>
         <div>
            <img src="resources/assets/front/img/2.jpg">
         </div>
         <div>
            <img src="resources/assets/front/img/3.jpg">
         </div>
      @endif
   </div>
   <!-- INFO TABS -->
   <div class="container">
      <div class="info-tabs">
         <ul class="nav nav-tabs nav-justified">
            <li class="active"><a class="clearfix" data-toggle="tab" href="#home">Welcome <img src="resources/assets/front/img/arrow-hehe.png"></a></li>
            <li><a class="clearfix" data-toggle="tab" href="#nature">Nature <img src="resources/assets/front/img/arrow-hehe.png"></a></li>
            <li><a class="clearfix" data-toggle="tab" href="#wealth">Wealth <img src="resources/assets/front/img/arrow-hehe.png"></a></li>
            <li><a class="clearfix" data-toggle="tab" href="#technology">Technology <img src="resources/assets/front/img/arrow-hehe.png"></a></li>
         </ul>
         <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
               <div class="welcome">
                  <h3>Welcome to Alpha Global Prestige Family!</h3>
                  <p>Alpha Global Prestige believes in Family, the fundamental unit of a society. It is the living treasure of gold. It is made strong not by the headcounts but by the root of valued culture, commitment of time and harmony. Just like in Prolife Family, we want the best and all the convenience we can share to our members. Together, we have established a company that delivers high quality products and excellent e-services that brings each home the benefits of our natural environment and the comfort of technology. Prolife NWT has strategically ventured with trusted and reputed companies for our associates to enjoy hassle-free online services and privileges at their fingertips. </p>
               </div>
            </div>
            <div id="nature" class="tab-pane fade">
               <div class="general">
                  <div class="clearfix">
                     <div class="vc_col-sm-7 wpb_column column_container">
                        <h3><img src="resources/assets/front/img/nature-icon.png"> Nature</h3>
                        <p>We offer various lines of natural and organic beauty products that keeps you beautiful and healthy inside and out. Alpha Global Prestige wants to bring out the best in you! Our essential beauty products can help you achieve what you want. Fairer and beautiful skin is not only for the few. Regular use of Alpha Global Prestige beauty soaps will help you achieve that radiant and supple skin . Start your day with our herbal power drinks, from green coffee to chocolate to the very healthy and revitalizing juice!</p>
                        <div class="note"><strong>BE HEALTHY.</strong> Live a life of beauty and youth.</div>
                     </div>
                     <div class="vc_col-sm-5 wpb_column column_container">
                        <img class="img-responsive" src="resources/assets/front/img/nature-pic.jpg">
                     </div>
                  </div>
               </div>
            </div>
            <div id="wealth" class="tab-pane fade">
               <div class="general">
                  <div class="clearfix">
                     <div class="vc_col-sm-7 wpb_column column_container">
                        <h3><img src="resources/assets/front/img/wealth-icon.png"> Wealth</h3>
                        <p>Unravel the mystery of financial freedom. Unlock your ability to earn more money, save and get what you dream. We can show you how it can be done. Everybody wishes of alleviating their financial status. Venture into a world wherein you can have the chance to break free from financial lock-ups. Build your dream house, buy a new car or travel as often as you want. Everything is possible. All you need to do is just to invest your time. Act now!</p>
                        <div class="note"><strong>BE FREE.</strong> Enjoy financial freedom. Earn more, save more... for a better future.</div>
                     </div>
                     <div class="vc_col-sm-5 wpb_column column_container">
                        <img class="img-responsive" src="resources/assets/front/img/wealth-pic.jpg">
                     </div>
                  </div>
               </div>
            </div>
            <div id="technology" class="tab-pane fade">
               <div class="general">
                  <div class="clearfix">
                     <div class="vc_col-sm-7 wpb_column column_container">
                        <h3><img src="resources/assets/front/img/technology-icon.png"> Technology</h3>
                        <p>Experience the speed and comfort at your fingertips through our fast and reliable on –line services. PROLIFE is your one-stop shop from sending your remittances to booking your flights. We want you to avoid the long queue to send money. Move out of the line and do all these at the comfort of your home.</p>
                        <div class="note"><strong>BE CONNECTED.</strong> Your e-services at your fingertips.</div>
                     </div>
                     <div class="vc_col-sm-5 wpb_column column_container">
                        <img class="img-responsive" src="resources/assets/front/img/technology-pic.jpg">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- CATEGORY -->
   <div class="cat-holder">
      <div class="clearfix">
       	 <div class="vc_col-sm-3 wpb_column column_container">
            <div class="holder match-height" style="background-image: url('resources/assets/front/img/cat-beverages.jpg');">
               <img class="icon" src="resources/assets/front/img/beverages-icon.png">
               <div class="name">BEVERAGES</div>
               <div class="view">
                  <div class="not-hover"><img class="img-responsive" src="resources/assets/front/img/big-arrow.png"></div>
                  <div class="hover"><a href="/product">VIEW PRODUCTS <img src="resources/assets/front/img/small-arrow.png"></a></div>
               </div>
            </div>
         </div>
         <div class="vc_col-sm-3 wpb_column column_container">
            <div class="holder match-height" style="background-image: url('resources/assets/front/img/cat-beauty.jpg');">
               <img class="icon" src="resources/assets/front/img/beauty-icon.png">
               <div class="name">BEAUTY PRODUCTS</div>
               <div class="view">
                  <div class="not-hover"><img class="img-responsive" src="resources/assets/front/img/big-arrow.png"></div>
                  <div class="hover"><a href="/product">VIEW PRODUCTS <img src="resources/assets/front/img/small-arrow.png"></a></div>
               </div>
            </div>
         </div>
         <div class="vc_col-sm-3 wpb_column column_container">
            <div class="holder match-height" style="background-image: url('resources/assets/front/img/cat-hygiene.jpg');">
               <img class="icon" src="resources/assets/front/img/hygiene-icon.png">
               <div class="name">HYGIENE</div>
               <div class="view">
                  <div class="not-hover"><img class="img-responsive" src="resources/assets/front/img/big-arrow.png"></div>
                  <div class="hover"><a href="/product">VIEW PRODUCTS <img src="resources/assets/front/img/small-arrow.png"></a></div>
               </div>
            </div>
         </div>
         <div class="vc_col-sm-3 wpb_column column_container">
            <div class="holder match-height" style="background-image: url('resources/assets/front/img/cat-package.jpg');">
               <img class="icon" src="resources/assets/front/img/package-icon.png">
               <div class="name">PACKAGES</div>
               <div class="view">
                  <div class="not-hover"><img class="img-responsive" src="resources/assets/front/img/big-arrow.png"></div>
                  <div class="hover"><a href="/product">VIEW PRODUCTS <img src="resources/assets/front/img/small-arrow.png"></a></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- QUOTE -->
   <div class="quote clearfix" style="border: 0;">
      <div class="container">
         <div class="clearfix">
            <div class="vc_col-sm-9 wpb_column column_container">
               Say something to motivate them and start your business. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </div>
            <div class="vc_col-sm-3 wpb_column column_container">
               <button class="btn btn-default" type="button" onClick="location.href='/member/register'">START NOW!</button>
            </div>
         </div>
      </div>
   </div>
   <div class="clearfix"></div>
   <!-- ANOTHER INFO TABS -->
   <div class="container">
      <div class="info-tabs">
         <ul class="nav nav-tabs nav-justified">
            <li class="active"><a class="clearfix" data-toggle="tab" href="#partners">Our Partners</a></li>
            <li><a class="clearfix" data-toggle="tab" href="#team">Team Members</a></li>
            <li><a class="clearfix" data-toggle="tab" href="#earners">Top Earners Of The Month</a></li>
            <li><a class="clearfix" data-toggle="tab" href="#news">News</a></li>
         </ul>
         <div class="tab-content">
            <div id="partners" class="tab-pane fade in active">
               <div class="list">
                  <div class="clearfix">
                     @if(isset($_partners[0]))
                     <div class="loli-list">
                     @foreach($_partners as $partners)
                     <div>
                        <img class="img-responsive" src="/uploads/{{ $partners->image }}">
                        <h4>{{ $partners->name }}</h4>
                     </div>
                     @endforeach
                     </div>
                     @else
                     <h2>There are Currently No Partners</h2>
                     @endif
                  </div>
               </div>
            </div>
            <div id="team" class="tab-pane fade in">
               <div class="list">
                  <div class="clearfix">
                     @if(isset($_team_members[0]))
                     <div class="loli-list">
                     @foreach($_team_members as $team_members)
                     <div>
                        <img class="img-responsive" src="/uploads/{{ $team_members->image }}">
                        <h4>{{ $team_members->name }}</h4>
                     </div>
                     @endforeach
                     </div>
                     @else
                     <h2>There are Currently No Team Members</h2>
                     @endif
                  </div>
               </div>
            </div>
            <div id="earners" class="tab-pane fade in">
               <div class="list">
                  <div class="clearfix">
                     @if(isset($_top_earners[0]))
                     @foreach($_top_earners as $top_earners)
                     <div class="vc_col-sm-3 wpb_column column_container">
                        <img class="img-responsive" src="{{ $top_earners->image }}">
                        <h4>{{ ucwords($top_earners->account_name) }}</h4>
                     </div>
                     @endforeach
                     @else
                     <h2>There are Currently No Top Earners Of The Month</h2>
                     @endif
                  </div>
               </div>
            </div>
            <div id="news" class="tab-pane fade in">
               <div class="news-list">
                  <div class="holder">
                     @if(isset($_news[0]))
                     @foreach($_news as $news)
                     <div class="clearfix row">
                        <div class="vc_col-sm-3 wpb_column column_container">
                           <img src="/uploads/{{ $news->image }}">
                        </div>
                        <div class="vc_col-sm-9 wpb_column column_container">
                           <h2>{{ $news->news_name }}</h2>
                           <p>{{ substr($news->news_description, 0, 400) }} ...</p>
                           <div class="text-right" style="text-align: right">
                              <a class="btn btn-default" href="/news_content?id={{ $news->id }}" style="background-color: #252525">Read More</a>
                           </div>
                        </div>
                     </div>
                     @endforeach
                     @else
                     <h2 style="text-align: center;">There are Currently No News</h2>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- SOME PARAGRAPH -->
   <div class="quote clearfix" style="border: 0;">
      <div class="container">
         <div class="clearfix">
            <div class="vc_col-sm-12 wpb_column column_container" style="text-align: center;">
               Say something to motivate them and start your business. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section("script")
<script type="text/javascript">
;(function($){
    $('.testimony-carousel .carousel-holder').slick({
      prevArrow:"<img style='height: 30px; top: 40%;' class='a-left control-c prev slick-prev' src='resources/assets/front/img/slick-arrow-left.png'>",
      nextArrow:"<img style='height: 30px; top: 40%;' class='a-right control-c next slick-next' src='resources/assets/front/img/slick-arrow-right.png'>",
      autoplay: true,
      autoplaySpeed: 3000,
    });
    $('.slide-container').slick({
      prevArrow:"<img style='height: 71px; width: 25px;' class='a-left control-c prev slick-prev' src='resources/assets/front/img/left-desu.png'>",
      nextArrow:"<img style='height: 71px; width: 25px;' class='a-right control-c next slick-next' src='resources/assets/front/img/right-desu.png'>",
      autoplay: true,
      autoplaySpeed: 3000,
    });
    $('.loli-list').slick({
      autoplay: true,
      autoplaySpeed: 3000,
      slidesToShow: 4,
      slidesToScroll: 1,
      infinite: true,
    });
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) 
    {
      $('.loli-list').slick("unslick");
      $('.loli-list').hide();
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e)
    {
      $('.loli-list').show();
      $('.loli-list').slick({
         autoplay: true,
         autoplaySpeed: 3000,
         slidesToShow: 4,
         slidesToScroll: 1,
         infinite: true,
       });
    });
})(jQuery);
</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="resources/assets/front/css/home.css">
@endsection