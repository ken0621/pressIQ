@extends("layout")
@section("content")
<div class="intro" style="background-image: url('/themes/{{ $shop_theme }}/img/intro-bg.jpg')">
	<div class="container">
		<div class="text">
			<div class="title">WELCOME TO</div>
			<div></div>
			<div class="desc">
				<div class="first-line">SOVEREIGN</div>
				<div class="second-line">WORLD CORPORATION</div>
				<div class="objective">Our objective is to share with you a system that is proven, tested and has changed lives of millions of people like you.</div>
				<button class="btn btn-learn">Learn More</button>
			</div>
		</div>
	</div>
</div>
<div class="company">
	<div class="container">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#company">Company</a></li>
			<li><a data-toggle="tab" href="#mission">Mission</a></li>
			<li><a data-toggle="tab" href="#vision">Vision</a></li>
		</ul>
		<div class="tab-content">
			<div id="company" class="tab-pane fade in active">
				<div class="row clearfix">
					<div class="col-md-8">
						<h1>Who We Are</h1>
						<p>We are an International direct advertising company from multiple sources of business enterprise formed to create partners all across the world. Companies in the Network Marketing Industry today are creating vast opportunities in line with wellness products for people to form a concrete Global Business Opportunity.</p>
						<div class="read-more">
							<a href="/about">Read More</a>
						</div>
					</div>
					<div class="col-md-4">
						<img class="img-reponsive" src="/themes/{{ $shop_theme }}/img/company-side.jpg">
					</div>
				</div>
			</div>
			<div id="mission" class="tab-pane fade">
				<div class="row clearfix">
					<div class="col-md-8">
						<h1>Company Mission</h1>
						<p>To serve the community and its people by providing opportunity for good health and abundant life. And inspire people to help others make a positive change in their lives.</p>
						<div class="read-more">
							<a href="/about">Read More</a>
						</div>
					</div>
					<div class="col-md-4">
						<img class="img-reponsive" src="/themes/{{ $shop_theme }}/img/mission-side.jpg">
					</div>
				</div>
			</div>
			<div id="vision" class="tab-pane fade">
				<div class="row clearfix">
					<div class="col-md-8">
						<h1>Company Vision</h1>
						<p>To be the trademark in the field of health nutrition, business education and service to the community thru its outstanding products made available for entrepreneurs worldwide.</p>
						<div class="read-more">
							<a href="/about">Read More</a>
						</div>
					</div>
					<div class="col-md-4">
						<img class="img-reponsive" src="/themes/{{ $shop_theme }}/img/vision-side.png">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="values" style="background-image: url('/themes/{{ $shop_theme }}/img/values-bg.jpg')">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-4 left-holder match-height">
				<div class="holder">
					<div class="values-title">Company Core Values</div>
					<div class="divider"></div>
					<div class="values-sub">-Inspired by "Coach Wooden"</div>
				</div>
			</div>
			<div class="col-md-8 match-height">
				<div class="tower">
					<div class="tower-row">
						<div class="holder">
							<div class="name">Excellence</div>
							<div class="desc">Performing at your highest level</div>
						</div>
					</div>
					<div class="tower-row">
						<div class="holder match-height">
							<div class="name">Character</div>
							<div class="desc">The qualities that distinguish individuals</div>
						</div>
						<div class="holder match-height">
							<div class="name">Integrity</div>
							<div class="desc">The faithfulness to maintain high moral standards</div>
						</div>
					</div>
					<div class="tower-row">
						<div class="holder match-height">
							<div class="name">Team Work</div>
							<div class="desc">Subordinating personal prominence to team efficiency</div>
						</div>
						<div class="holder match-height">
							<div class="name">Communication</div>
							<div class="desc">The ingredient to organizational success</div>
						</div>
						<div class="holder match-height">
							<div class="name">Collaboration</div>
							<div class="desc">The willingness to jointly achieve common goals</div>
						</div>
					</div>
					<div class="tower-row">
						<div class="holder match-height">
							<div class="name">Attitude</div>
							<div class="desc">Energy, drive and enjoyment will always inspire others</div>
						</div>
						<div class="holder match-height">
							<div class="name">Discipline</div>
							<div class="desc">Relentless Perseverance in all that you do</div>
						</div>
						<div class="holder match-height">
							<div class="name">Initiative</div>
							<div class="desc">Failure to act will lead to the biggest failures of all</div>
						</div>
						<div class="holder match-height">
							<div class="name">Work Ethic</div>
							<div class="desc">Success travels in the company of very hard work and dedication</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
<div class="product">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-6">
				<div class="image">
					<img src="/themes/{{ $shop_theme }}/img/product-sample.jpg">
				</div>
			</div>
			<div class="col-md-6">
				<div class="name">A Real Product Need</div>
				<div class="desc">Wellness Products are a real need in the marketplace. People may have the money to buy anything, but they can not buy their time on earth. With rising economies and changing lifestyles of people worldwide, people are getting health issues and financial defeat, everybody is looking to save money on hospitalizations.</div>
			</div>
		</div>
	</div>
</div>
<div class="networking">
	<div class="container">
		<div class="title">Networking Marketing has come of age</div>
		<div class="row clearfix">
			<div class="col-md-4">
				<div class="holder">
					<div class="image">
						<img src="/themes/{{ $shop_theme }}/img/marketing-1.jpg">
					</div>
					<div class="desc">58 million people are involved in network marketing worldwide.</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="holder">
					<div class="image">
						<img src="/themes/{{ $shop_theme }}/img/marketing-2.jpg">
					</div>
					<div class="desc">The network marketing industry has surpassed $100 billion in retail revenue.</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="holder">
					<div class="image">
						<img src="/themes/{{ $shop_theme }}/img/marketing-3.jpg">
					</div>
					<div class="desc">North American sales have reached over $34 billion dollars.</div>
				</div>
			</div>
		</div>
		<div class="quote">
			<div class="text">"I think network marketing has come of age. It’s become undeniable that it’s a viable way to entrepreneurship and independence for millions of people."</div>
			<div class="name">- <span>Dr. Stephen R. Covey</span></div>
			<div class="desc">Interview in Network Marketing Lifestyle</div>
		</div>
	</div>
</div>
<div class="saying">
	<div class="container">
		<div class="title">What those who know Network Marketing are saying!</div>
		<div class="row clearfix">
			<div class="col-md-4">
				<div class="holder">
					<div class="image">
						<img src="/themes/{{ $shop_theme }}/img/saying-1.jpg">
					</div>
					<div class="desc">"Network Marketers are creating FORTUNES at breakneck speeds!"</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="holder">
					<div class="image">
						<img src="/themes/{{ $shop_theme }}/img/saying-2.jpg">
					</div>
					<div class="desc">"Network Marketers are creating FORTUNES at breakneck speeds!"</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="holder">
					<div class="image">
						<img src="/themes/{{ $shop_theme }}/img/saying-3.jpg">
					</div>
					<div class="desc">"Network Marketers are creating FORTUNES at breakneck speeds!"</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="professional">
	<div class="container">
		<div class="title">What Professionals Say</div>
		<div class="row clearfix">
			<div class="col-md-4">
				<div class="holder match-height">
					<div class="icon"><img src="/themes/{{ $shop_theme }}/img/black-quote.png"></div>
					<div class="text">If you really want to learn how to be rich, you must begin to know and understand the power found in networks. The Richest People in the world Build Networks</div>
					<div class="author">
						<table>
							<tbody>
								<tr>
									<td class="author-img">
										<img src="/themes/{{ $shop_theme }}/img/author-1.jpg">
									</td>
									<td class="author-text">
										<div class="name">Robert Kiyosaki</div>
										<div class="did">Best Selling Author of Rich Poor Dad and many other internationally acclaimed titles.</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="holder match-height">
					<div class="icon"><img src="/themes/{{ $shop_theme }}/img/black-quote.png"></div>
					<div class="text">If I lost everything and had to start again, I would find myself a great network marketing company and get to work!</div>
					<div class="author">
						<table>
							<tbody>
								<tr>
									<td class="author-img">
										<img src="/themes/{{ $shop_theme }}/img/author-2.jpg">
									</td>
									<td class="author-text">
										<div class="name">Donald Trump</div>
										<div class="did">Globally renowned property mogul and a multi billionaire.</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="holder match-height">
					<div class="icon"><img src="/themes/{{ $shop_theme }}/img/black-quote.png"></div>
					<div class="text">The Best Investment I ever made… Owns 51 businesses today, 3 of which are Network Marketing Companies.</div>
					<div class="author">
						<table>
							<tbody>
								<tr>
									<td class="author-img">
										<img src="/themes/{{ $shop_theme }}/img/author-3.jpg">
									</td>
									<td class="author-text">
										<div class="name">Warren Buffet</div>
										<div class="did">Billionaire Investor and the richest person</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="address" style="background-image: url('/themes/{{ $shop_theme }}/img/bottom-bg.jpg')">
	<div class="container">
		<div class="col-md-6 match-height holder">
			<div class="absolute">
				<div class="name">Global Headquarters</div>
				<div class="line"></div>
			</div>
		</div>
		<div class="col-md-6 match-height">
			<div class="logo"><img src="/themes/{{ $shop_theme }}/img/white-logo.png"></div>
			<div class="from">Address:  8/F Wong Hing Building 74-78 Stanley Street, Central Hong Kong</div>
			<div class="contact">Tel No. (+852) 9472 6184 / (+852) 9145 7698</div>
		</div>
	</div>
</div>
<div class="join">
	<div class="container">
		<div class="holder">
			<div class="row clearfix">
				<div class="col-md-8">
					<div class="text">We offer one of the Strongest Compensations plans in the Industry with Multiple Ways to Earn Weekly and Monthly Income!</div>
				</div>
				<div class="col-md-4 text-center">
					<button class="btn">Join us today</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/home.css">
@endsection

@section("js")

@endsection