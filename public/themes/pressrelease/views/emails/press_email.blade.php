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
	margin: 0px 150px;
	padding: 0px 15px;
	border-radius: 10px;
}	
	
.heading-container
{
	color: #cd3d35;
	font-size: 80px;
	text-align: center;
	padding-top: 30px;
	font-weight: 700;
}
.subheading-container
{
	color: #cd3d35;
	font-size: 40px;
	text-align: center;
	padding-top: 15px;
}
.sender-container
{
	color: #404040;
	font-size: 30px;
	text-align: center;
	padding-top: 15px;
}
.date-container
{
	color: #404040;
	text-align: center;
	padding-top: 10px;
	font-size: 18px;
}
.content-container
{
	padding-top: 10px;
	padding-left: 20px;
	padding-right: 20px;
	padding-bottom: 10px;
	text-align: justify;
	text-indent: 50px;
	color: #404040;
	font-size: 20px;
}
</style>

</head>
<body>
	<div class="background-container">
		<div class="container">
			<div class="heading-container">{{$pr_headline}}</div>
			<div class="subheading-container">{{$pr_subheading}}</div>
			<div class="sender-container">Published by {{$pr_sender_name}}</div>
			<div class="date-container">{{$pr_date_sent}}</div>
			<div class="content-container">{!!$pr_content!!}</div>
		</div>
	</div>
</body>
</html>


