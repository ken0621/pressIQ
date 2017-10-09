<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Coming Soon - {{ ucfirst($shop_info->shop_key) }}</title>
		<base href="{{ URL::to('/themes/' . $shop_theme) }}/">
		<!-- CSS -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,100italic,300italic,400italic,700,700italic">
		
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/animate.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/media-queries.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Favicon and touch icons -->
		{{-- <link rel="shortcut icon" href="assets/ico/favicon.png"> --}}
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
		<style type="text/css">
		.backstretch
		{
			display: none !important;
		}
		</style>
	</head>
	<body>
		<!-- Coming Soon -->
		<div class="coming-soon">
			<div class="inner-bg" style="height: 100%; position: absolute; top: 0; bottom: 0; left: 0; right: 0; background-image: url('assets/img/philtech-countdown-img.jpg'); background-size: cover;">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="logo wow fadeInDown">
								<h1>
									<img src="assets/img/count-down-logo.png">
								</h1>
							</div>
							<h2 class="wow fadeInLeftBig">We Are Updating</h2>
							<div class="timer wow fadeInUp">
								<div class="days-wrapper">
									<span class="days"></span> <br>days
								</div>
								<span class="slash">/</span>
								<div class="hours-wrapper">
									<span class="hours"></span> <br>hours
								</div>
								<span class="slash">/</span>
								<div class="minutes-wrapper">
									<span class="minutes"></span> <br>minutes
								</div>
								<span class="slash">/</span>
								<div class="seconds-wrapper">
									<span class="seconds"></span> <br>seconds
								</div>
							</div>
							<div class="wow fadeInLeftBig">
								<p>
									We are working very hard on the new version of our site
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Javascript -->
		<script src="assets/js/jquery-1.10.2.min.js"></script>
		<script src="assets/js/jquery.backstretch.min.js"></script>
		<script src="assets/js/jquery.countdown.min.js"></script>
		<script src="assets/js/wow.min.js"></script>
		<script src="assets/js/scripts.js"></script>
		
		<!--[if lt IE 10]>
		<script src="assets/js/placeholder.js"></script>
		<![endif]-->
	</body>
</html>