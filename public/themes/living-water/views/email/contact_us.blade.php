<!DOCTYPE html>
<html>
<head>

<style>
.background-container
{
	position: relative;
	width: 100%;
	background-position: center;
	background-attachment: fixed;
	background-repeat: no-repeat;
	background-size: cover;
	padding: 10px 0px;
	min-height: 640px;
	background-color: #f5f5f5;
}
.container
{
	margin: 0px 230px;
	min-height: 640px;
	width: 900px !important;
	padding-left: 0px;
	padding-right: 0px;
}	
.header-container
{
	background-color: #000;
	text-align: center;
	padding: 20px;
	font-family: 'Cantarell', sans-serif;
	color: #fff;
	font-size: 30px;
	font-weight: 600;
}
.greetings-container
{
	background-color: inherit;
	text-align: center;
	font-family: 'Cantarell', sans-serif;
	color: #000;
	font-size: 25px;
	padding: 20px 0;
	font-weight: 600;
}
.details
{
	font-family: 'PT Sans', sans-serif;
	color: #4a4c4d;
	font-size: 18px;
	text-align: center;
}
.content-container
{
	padding: 0 50px;
}
.info-container
{
	font-size: 18px;
	text-align: left;
	font-family: 'PT Sans', sans-serif;
	font-size: 20px;
	margin-top: 10px;
}
.title
{
	font-weight: 700;
}
.contact-container
{
	font-size: 25px;
	text-align: left;
	font-family: 'PT Sans', sans-serif;
	margin-top: 20px;
	font-weight: 700;
}
</style>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="background-container">
		<div class="container">
			<div class="header-container">Get Intouch With Us</div>
			<div class="greetings-container">Good Day Living Water,</div>
			<div class="content-container">
				<div class="details">There is someone who emailed you</div>
				<div class="info-container"><span class="title">From: </span><span class="info">{{$contactus_first_name}} {{$contactus_last_name}}</span></div>
				<div class="info-container"><span class="title">Subject: </span><span class="info">{{$contactus_subject}}</span></div>
				<div class="info-container"><span class="title">Message: </span><span class="info">{{$contactus_message}}</span></div>
				<div class="contact-container">Contact Information:</div>
				<div class="info-container"><span class="title">Email Address: </span><span class="info">{{$contactus_email}}</span></div>
				<div class="info-container"><span class="title">Phone Number: </span><span class="info">{{$contactus_phone_number}}</span></div>
			</div>
			{{-- <div class="row">
				<div class="content-container"><p>Subject: {{$contactus_subject}}</p></div>
				<div class="content-container"><p>First Name: {{$contactus_first_name}}</p></div>
				<div class="content-container"><p>Last Name: {{$contactus_last_name}}</p></div>
				<div class="content-container"><p>Phone Number: {{$contactus_phone_number}}</p></div>
				<div class="content-container"><p>Email: {{$contactus_email}}</p></div>
				<div class="content-container"><p>Message: {{$contactus_message}}</p></div>
			</div> --}}
		</div>
	</div>
</body>
</html>
