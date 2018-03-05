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
}
.container
{
	/*background-color: #f5f5f5;*/
	margin: 0px 130px;
	padding: 40px 40px;
	border-radius: 10px;
	min-height: 640px;
}	
	
.heading-container
{
	color: #000000;
	font-size: 30px;
	text-align: center;
	font-weight: 700;
	font-family: 'PT Serif';
	padding: 0px 20px 0px 20px;
}
.sender-container
{
	color: #404040;
	font-size: 18px;
	text-align: center;
	font-family: 'PT Serif';
	padding-top: 5px;
}
.sender-name
{
	font-weight: 700;
}
.date-container
{
	color: #404040;
	text-align: center;
	padding-top: 8px;
	padding-bottom: 10px;
	font-size: 15px;
}
.content-container
{
	padding-bottom: 10px;
	font-weight: 400;
	text-indent: 50px;
	color: #404040;
	font-size: 15px;
	font-family: 'PT Sans';
}
.border
{
	border-bottom: 1px solid #ededed;	
}
.title-about-container
{
	padding: 20px 0px 15px 0px;
	font-size: 20px;
	color: #404040;
	font-family: 'PT Sans';
	font-weight: 700;
}
.logo-holder
{
	margin: auto;
	/*box-shadow: 0px 12px 25px -15px rgba(0,0,0,0.2);*/
	padding: 15px 20px;
	/*border: 1px solid #ededed;*/
	width: 75%;
	/*background-color: #fff;*/
}
</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="background-container">
		<div class="container">
			<div class="row">
				<div class="col-xs-9" style="padding-left: 0px; padding-right: 0px;">
					<div class="heading-container">Account already expired</div>
				</div>
			</div>
			<div class="row">
				<div class="content-container"><p>Account Information</p></div>
				<div class="content-container"><p>Name: {{$pr_sender_name}}</p></div>
				<div class="content-container"><p>Company: {{$pr_co_name}}</p></div>
				<div class="content-container"><p>Email: {{$pr_from}}</p></div>
				
			</div>
		</div>
	</div>

</body>
</html>
