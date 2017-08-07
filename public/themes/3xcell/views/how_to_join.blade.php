@extends("layout")
@section("content")
<div class="content">
	<div class="top-1-container" style="background-image: url('/themes/{{ $shop_theme }}/img/how-to-join-bg.png')">
		<div class="container">
			<div class="top-1-content">
				<h1>How To Join</h1>
				<h2><span>There are three ways to be a</span><span>&nbsp;3xcell-E distributor</span></h2>
			</div>
		</div>
	</div>
	<!-- CONTENT -->
		<div class="mid-content">
			<div class="container">
				<!-- PER DETAIL -->
				<div class="detail-container row clearfix">
					<div class="col-md-6">
						<div class="description-container">
							<div class="title-container">Be a Retailer
								<div class="line-bot"></div>
							</div>
							<div class="description-content">
								<p>
									To be a Retailer one should avail of the RETAIL PACKAGE worth P1,500.
									Entitlement/Opportunities:<br><br>

									    1. Can resell all 3xcell-E products except for the Business package
									    2. Can sell the Retail package and get a 20% commission per entry
									    3. Can enjoy 25% discount on all repurchases<br><br>

									How to be a Retailer?<br><br>

									    1. Visit our website at 3xcell@digimahouse.com or come and visit us at our location to:<br>
										2. Fill up<br>
									    3. Fill up insurance form<br>
									    4. Choose amongst the 4 packages (Retail Package)<br>
									    5. Pay the Retail Package membership fee of P1,500.00 and<br>
									    6. Photo taking for membership ID<br><br>

									**Retailer will receive products, insurance, ID card, and marketing materials.
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="img-container">
							<img src="/themes/{{ $shop_theme }}/img/retail-img.png">
						</div>
					</div>
				</div>
				<div class="detail-container row clearfix">
					<div class="col-md-6">
						<div class="description-container">
							<div class="title-container">Be a FULL PLEDGED DISTRIBUTOR
								<div class="line-bot-2"></div>
							</div>
							<div class="description-content">
								<p>
									To be a Full Pledged Distributor, one should avail of the BUSINESS PACKAGE worth P5,500.00.

									Entitlement/Opportunities:<br><br>

									    1. Can resell all 3xcell-E products and packages<br>
									    2. 20% commission for every Retail and Business Package sold<br>
									    3. 25% off on all repurchase<br><br>

									How to be a Full Pledged Distributor?<br><br>

									    1. Visit our website at 3xcell.digimahouse.com or come and visit us at our location to:	<br>									
										2. Fill up membership form<br>
									    3. Fill up insurance form<br>
									    4. Choose amongst Package A, B, or C. (illustrated below)<br>
									    5. Pay the Business Package fee of P5,500.00 and<br>
									    6. Photo taking for membership ID<br><br>

									**Distributor will receive products, insurance, membership ID card and marketing materials.
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="img-container">
							<img src="/themes/{{ $shop_theme }}/img/full-pledge.png">
						</div>
					</div>
				</div>
				<div class="detail-container row clearfix">
					<div class="col-md-6">
						<div class="description-container">
							<div class="title-container">Avail of the Lay-Away Program
								<div class="line-bot-3"></div>
							</div>
							<div class="description-content">
								<p>									
									If you want to become a 3xcell Distributor and you don’t have enough capital, we have a LAY-AWAY Program for you.<br><br>

									    Fill up the Lay-Away Program Form<br>
									    Sell products worth P7,500.00<br>
									    Complete the task within 45 days.<br>
									    Upon completion, you can be a Full Pledged Distributor and avail of all the entitlements<br><br>

									Inclusions:<br><br>

									    Marketing Collaterals<br>
									    Free Membership ID<br>
									    Insurance<br>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="img-container">
				
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
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/how_to_join.css">
@endsection

@section("js")
<script type="text/javascript">
$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 700) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 700);
        return false;
    });

    /*SCROLL TEXT FADE OUT*/
	    $(window).scroll(function(){
	    	$(".top-1-content").css("opacity", 1 - $(window).scrollTop() / 250);
	  	});
});
</script>
@endsection