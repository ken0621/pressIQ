<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="/themes/lokalize/assets/img/favicon.png" type="image/png"/>
		<title>Lokalize</title>
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:100,300,400,500,600,700" rel="stylesheet">
		<!-- Bootstrap 4 -->
		<!-- <link rel="stylesheet" href="/themes/lokalize/assets/bootstrap4/dist/css/bootstrap.min.css"> -->
		<!-- New Font Awesome -->
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
		<script defer src="/themes/lokalize/assets/fontawesome5/svg-with-js/css/fa-svg-with-js.css"></script>
		<script defer src="/themes/lokalize/assets/fontawesome5/svg-with-js/js/fontawesome-all.js"></script>
		<!--External css-->
		<link rel="stylesheet" href="/themes/lokalize/assets/css/app.css">
		<link rel="stylesheet" type="text/css" href="/assets/front/css/loader.css">
		<!--wow animation-->
		<link rel="stylesheet" href="/themes/lokalize/assets/wow/css/animate.css">
		<!-- Slick -->
		<link rel="stylesheet" type="text/css" href="/themes/lokalize/assets/slick-1.8.0/slick/slick.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/lokalize/assets/slick-1.8.0/slick/slick-theme.css"/>
		<!-- MDB -->
		<link rel="stylesheet" type="text/css" href="/themes/lokalize/assets/mdb/css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/lokalize/assets/mdb/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/lokalize/assets/mdb/css/mdb.css"/>
		<link rel="stylesheet" type="text/css" href="/themes/lokalize/assets/mdb/css/mdb.min.css"/>
	</head>
	<body>

		<!--BANNER SECTION-->
		<section class="page-section register-page">
			<div class="container">
				<div class="register-form-holder d-flex flex-column align-items-center justify-content-center">
					<div class="logo-holder">
						<img src="/themes/lokalize/assets/img/lokal-logo.png">
					</div>
					<div class="py-3">
						{{-- <form action="">
							<input class="custom-textfield w-100 my-2 p-2" type="text" placeholder="Email Address">
							<input class="custom-textfield w-100 p-2" type="text" placeholder="Password">
							<button class="btn-lokal-sm w-100 mt-3">REGISTER</button>
						</form> --}}
						<form role="form">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input class="custom-textfield w-100 p-2" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input class="custom-textfield w-100 p-2" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
									</div>
								</div>
							</div>
							<div class="form-group">
								<input class="custom-textfield p-2 w-100" type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input class="custom-textfield w-100 p-2" type="text" name="phone_number" id="first_name" class="form-control input-sm" placeholder="Phone Number">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input class="custom-textfield w-100 p-2" type="text" name="user_name" id="last_name" class="form-control input-sm" placeholder="Username">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input class="custom-textfield w-100 p-2" type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input class="custom-textfield w-100 p-2" type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
									</div>
								</div>
							</div>
							<button class="btn-lokal-sm w-100 mt-2">REGISTER</button>
							{{-- <input type="submit" value="Register" class="btn btn-info btn-block"> --}}
							
						</form>
						<div class="content-text text-center pt-2">Already have an account? <a class="text-link-1" href="/members/login">Click Here.</a></div>
						<div class="content-text text-center pt-4"><a href="/" class="text-link-2">« Back to Homepage</a></div>
					</div>
				</div>
			</div>
		</section>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="/themes/lokalize/assets/bootstrap4/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/themes/lokalize/assets/slick-1.8.0/slick/slick.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script type="text/javascript" src="/themes/lokalize/assets/js/match-height.js"></script>
		<script type="text/javascript" src="/themes/lokalize/assets/js/member_layout.js"></script>
		{{-- <script type="text/javascript" src="/themes/lokalize/assets/scrolltofix/jquery-scrolltofixed.js"></script> --}}
		{{-- <script type="text/javascript" src="/themes/lokalize/assets/scrolltofix/jquery-scrolltofixed-min.js"></script> --}}
		<script type="text/javascript" src="/themes/lokalize/assets/mdb/js/mdb.js"></script>
		<script type="text/javascript" src="/themes/lokalize/assets/mdb/js/mdb.min.js"></script>
		<script type="text/javascript" src="/themes/lokalize/assets/js/custom.js"></script>
		<script type="text/javascript" src="/themes/lokalize/assets/js/smooth-scroll.js"></script>

		<!-- <script type="text/javascript" src="/themes/lokalize/assets/js/globals_js.js"></script> -->
		<!-- <script src="//themes/lokalize/assets/js/popup.js"></script> -->
		<!--START WOW JS-->
		<script src="/themes/lokalize/assets/wow/js/wow.min.js"></script>
		<script>
		new WOW().init();
		</script>
		<!--END WOW JS-->
	</body>
</html>