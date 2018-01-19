@extends("layout")
@section("content")
<div class="content">
    <div class="container">
        <div class="main-container">
            <div class="title-container">
                <span class="icon-container"><img src="/themes/{{ $shop_theme }}/img/p4ward-icon-blue.png"></span><span class="title-blue">Our </span><span class="title-orange">History</span>
            </div>
            <div class="details-container">
                <p>P4ward Global Marketing started through the concept of giving.</p>
                <p>On December 22, 2016, a tragedy hit our family. An accident happened in the apartment of my brother which started a fire that engulfed the entire flat including his body. He suffered 60% body burn up to the 3rd degrees.</p>
                <p>The nearest hospital he can be rushed to was a big private hospital. He will stay in the ICU for almost 2 weeks and will stay in the hospital for the next 3 months until he will fully recover.</p>
                <p>During the first 3 days in the ICU, his bill already reached 6 digits just for the hospital and medicine bills alone. That bill was already bigger than our entire family’s savings combined and with the rate of his medical expenses, it’ll reach 7 figures within the next few days.</p>
                <p>I swallowed my pride and asked for help by posting about my brother in Facebook. I rarely post personal stuff in FB, but I had to do it for my brother.</p>
                <p>That post garnered thousands of reactions. Our relative, friends, and people I don’t even know together with other Nationalities from other parts of the world, sent financial assistance and most importantly, offered prayers for the healing of my brother.</p>
                <p>I know I can’t pay all of these incredible people back, but I can Pay it Forward. Their kindness and generosity will be forever engraved in our hearts.</p>
                <p>Hence P4ward Global Marketing was established on November 21, 2017, to promote great 100% Pinoy made products and to give opportunity for people not only to succeed financially but also to be significant.</p>
                <p>Moreover, we aim to continuously support charitable institutions and soon build our own foundation that will support burn victims.</p>
                <p>Our concept may be different from other companies simply because we are encouraging a helping hand strategy (to know more about it please click this link).</p>
                <p>Together, let’s create a different kind of “Network Marketing” by promoting world class Pinoy products and focusing more in building relationships by creating a network of giving. Giving of our time, our efforts and talents to help others succeed.</p>
                <p>It takes one simple strategy to change your MLM career for the better. We teach that simple strategy. But do you know why people usually don’t get this simple strategy? Because we always look for complicated solutions.</p>
                <p> Our product for example, comes from a very simple main ingredient (coffee). But we overlook the benefits it can do to our skin. Instead, we look for expensive cosmetics full of chemicals we don’t even know.</p>
                <p>Friend, stop looking for complicated solutions because life isn’t complicated, we just tend to make it one.</p>
            </div>
            <div class="p4ward_partner_container">
                <p>May you live a life of significance.</p>
                <p>Your P4ward Partner,</p>
                <div class="image-holder">
                    <img src="/themes/{{ $shop_theme }}/img/p4ward_image_partner.jpg">
                </div>
                <p style="font-weight: 700;">Chris Sarmiento</p>
            </div>
        </div>
    </div>
    <!-- SCROLL TO TOP -->
    <div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>

</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/about.css">
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