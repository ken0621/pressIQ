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
	background-color: #f5f5f5;
	margin: 0px 100px;
	padding: 40px 40px;
	border-radius: 10px;
	min-height: 640px;
}	
	
.heading-container
{
	color: #cd3d35;
	font-size: 60px;
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
	font-family: 'Lato';
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
	padding-top: 15px;
	padding-bottom: 10px;
	text-align: justify;
	font-weight: 400;
	text-indent: 50px;
	color: #404040;
	font-size: 20px;
	font-family: 'PT Sans';
}
.border
{
	border-bottom: 1px solid #ededed;
	padding: 15px 0px;
}
.title-about-container
{
	padding: 40px 0px 15px 0px;
	font-size: 25px;
	color: #404040;
	font-family: 'PT Sans';
	font-weight: 700;
}
</style>

</head>
<body>
	<div class="background-container">
		<div class="container">
			<div class="heading-container">{{$pr_headline}}</div>
			<div class="sender-container"><span class="title-sender">Published by </span><span class="sender-name">{{$pr_sender_name}}</span></div>
			<div class="date-container">{{$pr_date_sent}}</div>
			<div class="content-container"><p>{!!$pr_content!!}</p></div>
			<div class="border"></div>
			<div class="title-about-container">About {{$pr_sender_name}}</div>
			<div class="content-container">{!!$pr_boiler_content!!}</div>
		</div>
	</div>
</body>
</html>


