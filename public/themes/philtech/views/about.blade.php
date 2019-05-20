@extends("layout")
@section("content")
<!-- OUR VALUES -->


	<div class="greetings">
		<div class="container">
			<div class="title-holder">
				{{-- Welcome to the --}}{!! get_content($shop_theme_info, "about", "about_title_1") !!} <span>{{-- BUSINESS OPPORTUNITY --}}{!! get_content($shop_theme_info, "about", "about_title_2") !!}</span>
			</div>
			<div class="paragraph">
				{{-- This is a very unique business model that would make all of us realize and achieve our DREAMS. My greatest vision and passion have been to help more Filipinos to own an affordable and profitable BUSINESS and be truly successful holistically in their lives, thus the PhilTECH company was founded.
				<br><br>
				For me, SUCCESS is not just about FINANCIAL FREEDOM, it is also about the TOTAL LIFE TRANSFORMATION: FINANCIALLY, EMOTIONALLY AND SPIRITUALLY. To MENTOR, MOTIVATE and INSPIRE other people regardless of age, gender, socio-economic status and educational background. 
				<br><br>
				PhilTECH, INC. has been established to provide the right vehicle to ride on to earn limitless passive income and to become MILLIONAIRE in the future. PhilTECH, INC. is soaring at its highest potential to offer the BUSINESS PACKAGES to all FILIPINOS anywhere in the world. It is one of my dreams that many people will be successful for the rest of their lives. 
				<br><br>
				Again, I would like to welcome you all to this Life-Changing- Opportunity! --}}
				{!! get_content($shop_theme_info, "about", "about_content_1") !!}
			</div>
			<div class="owner">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="image-holder">
							<img src="{{-- /themes/{{ $shop_theme }}/img/greeting-owner.jpg --}}{!! get_content($shop_theme_info, "about", "about_image_1") !!}">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="name-holder">
							<div class="name">{{-- ARNOLD A. ARBILLERA --}}{!! get_content($shop_theme_info, "about", "about_author") !!}</div>
							<div class="position">{{-- President & CEO --}}{!! get_content($shop_theme_info, "about", "about_position") !!}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="about">
		<div class="container">
			<div class="header">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="title-holder">
							{{-- Welcome to --}}{!! get_content($shop_theme_info, "about", "about_title_3") !!} <span>{{-- Philtech --}}{!! get_content($shop_theme_info, "about", "about_title_4") !!}</span>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="image-holder">
							<img src="{{-- /themes/{{ $shop_theme }}/img/gold-logo.png --}}{!! get_content($shop_theme_info, "about", "about_image_2") !!}">
						</div>
					</div>
				</div>
			</div>
			
			<div class="paragraph">
				{{-- <strong>COMPANY PROFILE</strong>
				<br><br>
				PHILTECH, INC. is a SALES AND MARKETING  Company offering a wide range of PRODUCTS and SERVICES. The first and pioneer in the Philippines to provide MULTI-BUSINESS-SYSTEMS with UNIQUE CONSUMERS LOYALTY, REWARDS and CASHBACK SYSTEM. 
				<br><br>
				PHILTECH is an ISO, Non-Bank Platform providing latest technology for ENTREPRENEURS to have complete payment options to offer CASHLESS PAYMENT SOLUTIONS, CASH WITHDRAWALS SYSTEM using BancNet Certified Device, Credit Card Payment POS, QR CODE CASHLESS PAYMENT, MONEY REMITTANCE, BILLS PAYMENT, E-LOADING SYSTEM, DISBURSEMENT SYSTEM, WIFI ZONE CONNECTIVITY SOLUTIONS and E-COMMERCE SYSTEM.
				<br><br>
				PHILTECH, INC. is offering COMPLETE PAYMENT ECO-SYSTEM, ALL-IN-ONE BUSINESS SOLUTIONS for SME’s and Large Scale Enterprises. 
				Our primary objective is to provide RISK-FREE, HASSLE FREE and CONVENIENCE to both MERCHANTS and CUSTOMERS by providing PAYMENTS SOLUTIONS like QR CODE, CREDIT CARDS POS and DEBIT CARD CASH-OUT Device. PHILTECH MERCHANTS eliminate the risk of CASH SHORTAGE, FAKE MONEY and any RISK involving HUMAN manipulations in doing business.
				<br><br>
				The company is partnered by Philippine-Multi-National Company servicing  globally such as Airline Ticketing, Hotels Booking platform and Travel and Tours for both Domestic and International. --}}{!! get_content($shop_theme_info, "about", "about_content_2") !!}
			</div>
		</div>
	</div>

	<div class="mission-and-vision">
		<div class="container">
			<div class="mission">
				<div class="title-holder">
					{{-- Our --}}{!! get_content($shop_theme_info, "about", "about_mission_title_1") !!} <span>{{-- Mission --}}{!! get_content($shop_theme_info, "about", "about_mission_title_2") !!}</span>
				</div>
				<div class="paragraph">
					{{-- To empower all consumers to experience convenience in shopping with unique benefits and privileges. To become successful entrepreneurs for them to achieve their goals and dreams by providing an excellent business model towards financial freedom and developing a SENSE of OWNERSHIP. --}}{!! get_content($shop_theme_info, "about", "about_mission_content") !!}
				</div>
			</div>
			<div class="vision">
				<div class="title-holder">
					{{-- Our --}}{!! get_content($shop_theme_info, "about", "about_vision_title_1") !!} <span>{{-- Vision --}}{!! get_content($shop_theme_info, "about", "about_vision_title_2") !!}</span>
				</div>
				<div class="paragraph">
					{{-- To continually provide affordable ONE-STOP-SHOP Multi Business Systems to all Filipinos, to provide convenience and Payment Solutions to both MERCHANTS and CUSTOMERS, to carry and engage in SALES and  MARKETING with LATEST TECHNOLOGY PRODUCTS  and  LATEST CONSUMERS PRODUCTS for all Filipinos.  To constantly develop and innovate PhilTECH’s unique business model and marketing system strategy by providing sustainable and long term business for all. --}}{!! get_content($shop_theme_info, "about", "about_vision_content") !!}
				</div>
			</div>
		</div>
	</div>

	<div class="core-values">
		<div class="container">
			<div class="title-holder">
				{{-- Our --}}{!! get_content($shop_theme_info, "about", "about_corevalues_title_1") !!} <span>{{-- Values --}}{!! get_content($shop_theme_info, "about", "about_corevalues_title_2") !!}</span>
			</div>
			<div class="image-holder">
				<img src="{{-- /themes/{{ $shop_theme }}/img/CoreValue.png --}}{!! get_content($shop_theme_info, "about", "about_corevalues_image") !!}">
			</div>
		</div>
	</div>

	<div class="organizational-chart">
		<div class="container">
			<div class="title-holder-1">
				THE BOARD <span>OF DIRECTORS</span>
			</div>
			<div class="org-chart-holder">
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/greeting-owner.jpg')">
					</div>
					<div class="info-box">
						<a href="https://www.linkedin.com/in/arnold-arbillera-a84646159/">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Arnold A. Arbillera
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								Chairman, President / CEO
							</div>
						</div>
					</div>
				</div>
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/karl.jpg')">
					</div>
					<div class="info-box">
						<a href="https://www.linkedin.com/in/mark-karl-landicho-b593a048/">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Karl Landicho
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								BOD / Vice President for IT
							</div>
						</div>
					</div>
				</div>
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/lenin.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Lenim Gan
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								BOD / Corporate Secretary
							</div>
						</div>
					</div>
				</div>
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/zenaida.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Zenaida M. Arbillera
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								BOD / Vice President for Finance
							</div>
						</div>
					</div>
				</div>
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/Belsie.jpg')">
					</div>
					<div class="info-box">
						<a href="https://www.linkedin.com/in/belsie-agustin-b608711a/">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Belsie Agustin
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								BOD / Vice President for Marketing
							</div>
						</div>
					</div>
				</div>
			</div>	
			
			<div class="title-holder-2">
				THE MANAGEMENT <span>TEAMS</span>
			</div>
			<div class="org-chart-holder">
				{{-- <div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/blank.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Vacant
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								Director Sales & Marketing Department
							</div>
						</div>
					</div>
				</div> --}}
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/saturn.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Saturnino C. Apdal, Jr.
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								Director, Operations Department
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/ramil.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Ramil Duque
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								Head, Accounting Department
							</div>
						</div>
					</div>
				</div> --}}
				{{-- <div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/Quincy.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Quincy Bernardo
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								Head, System Admin
							</div>
						</div>
					</div>
				</div> --}}
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/luisa.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Luisa Marcelo
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								Chief Marketing Officer
							</div>
						</div>
					</div>
				</div>
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/dig-logo.jpg')">
					</div>
					<div class="info-box">
						<a href="https://ph.linkedin.com/in/digima-web-solutions-incorporated-00058b146">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Digima Web Solutions
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								System Development Partner
							</div>
						</div>
					</div>
				</div>
				<div class="people">
					<div class="image-holder" style="background-image: url('/themes/{{ $shop_theme }}/img/blank.jpg')">
					</div>
					<div class="info-box">
						<a href="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<div class="info-container">
							<div class="name-holder">
								Castillo & Climaco Law
							</div>
							<div class="border-holder"></div>
							<div class="position-holder">
								Legal Council
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SCROLL TO TOP -->
	<div class="scroll-up"><img src="/themes/{{ $shop_theme }}/img/scroll-up.png"></div>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/css/aboutus.css">
@endsection
