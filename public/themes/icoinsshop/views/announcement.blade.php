@extends("layout")
@section("content")
<!-- NEWS AND ANNOUNCEMENT -->
<div class="content">
	<div class="main-container">
		<div class="container">
			<div class="row clearfix">
				<!-- NEWS CONTENT -->
				<div class="col-md-8">
					<div class="news-container">
						<div class="image-holder">
							<img src="/themes/{{ $shop_theme }}/img/announcement-3.jpg">
						</div>
						<div class="title-container">
							<div class="title">Investing in Bitcoin Throughout 2017 – is it too Late?</div>
							<span class="by">By:</span><span class="company-name">Icoins Shop</span>
						</div>
						<div class="details-container">
							<p>Everyone would love to buy bitcoin at the cheapest price possible. Preferably at the price of $0.01 per BTC or lower, which was effectively the real price when Bitcoin was first created. Despite the gains Bitcoin has made over the past few years, there is no reason to think the price has peaked already. The third wave is coming for Bitcoin and other cryptocurrencies, and it is only a matter of time until it happens.</p>
							<p>People who have missed out on the early days of Bitcoin may find it hard to justify investing at this point in time. That is understandable, as over $2, 500 per Bitcoin is quite a steep price. At the same time, people have to keep in mind the current value of all bitcoins in existence pales in comparison to the trillions of dollars being moved around the world through banks and other financial institutions. Bitcoin may never achieve that high level of value, but for all we know, it could happen in five years from now.</p>
							<p>The best time to invest in Bitcoin was yesterday. One should not contemplate whether or not to invest for too long. Opportunities will come and go with Bitcoin. Even if you would buy today and the value dropped by 20% overnight, there is still a good chance one will score a profit by just holding onto this Bitcoin balance for the foreseeable future.</p>
						</div>
					</div>
				</div>
				<!-- OTHER NEWS -->
				<div class="col-md-4">
					<div class="other-news-container">
						<div class="header">Other News</div>
						<div class="other-news-container">
							<a href="/news">
								<div class="other-news-per-container row-no-padding clearfix">
									<div class="col-md-4">
										<div class="news-img"><img src="/themes/{{ $shop_theme }}/img/news-img-1.jpg"></div>
									</div>
									<div class="col-md-8">
										<div class="news-details">
											<div class="news-title">Bitcoin</div>
											<div class="news-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium explicabo ab natus optio fuga officiis unde ullam quae, provident adipisci nulla quasi dolorem.</div>
											<div class="read-more">READ MORE</div>
										</div>
									</div>							
								</div>
							</a>
							<a href="/news">
								<div class="other-news-per-container row-no-padding clearfix">
									<div class="col-md-4">
										<div class="news-img"><img src="/themes/{{ $shop_theme }}/img/news-img-2.jpg"></div>
									</div>
									<div class="col-md-8">
										<div class="news-details">
											<div class="news-title">The Rise of Ico</div>
											<div class="news-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium explicabo ab natus optio fuga officiis unde ullam quae, provident adipisci nulla quasi dolorem.</div>
											<div class="read-more">READ MORE</div>
										</div>
									</div>							
								</div>
							</a>
							<a href="/news">
								<div class="other-news-per-container row-no-padding clearfix">
									<div class="col-md-4">
										<div class="news-img"><img src="/themes/{{ $shop_theme }}/img/announcement-3.jpg"></div>
									</div>
									<div class="col-md-8">
										<div class="news-details">
											<div class="news-title">Investing in Bitcoin Throughout 2017 – is it too Late?</div>
											<div class="news-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium explicabo ab natus optio fuga officiis unde ullam quae, provident adipisci nulla quasi dolorem.</div>
											<div class="read-more">READ MORE</div>
										</div>
									</div>							
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- SCROLL TO TOP -->
		<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>
	</div>
</div>
@endsection

@section("js")
<script type="text/javascript">

$(document).ready(function()
{
	/*scroll up*/
	$(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });


});	

</script>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/announcement.css">
@endsection

