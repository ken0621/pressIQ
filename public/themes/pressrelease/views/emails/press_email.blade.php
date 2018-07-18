<!DOCTYPE html>
<html>
<head>

<style>
@media screen and (max-width: 1366px)
{
	
}
@media screen and (max-width: 768px)
{
	.container
	{
		margin: 0px 0px !important;
		padding: 0px 0px !important;
	}
	.heading-container
	{
		font-size: 20px !important;
	}
	.title-about-container
	{
		font-size: 16px !important;
	}
	.content-container
	{
		font-size: 13px !important;
	}
}
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
	margin: 0px 50px;
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
	padding: 30px 20px 30px 20px;

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
	padding: 10px 0px 5px 0px;
	font-size: 20px;
	color: #404040;
	font-family: 'PT Sans';
	font-weight: 700;
}
.logo-holder
{
	margin: auto;
	/*box-shadow: 0px 12px 25px -15px rgba(0,0,0,0.2);*/
	padding: 0px 0px;
	/*padding: 15px 20px;*/
	/*border: 1px solid #ededed;*/
	/*width: 100%;*/
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
			<table width="100%">
				<tr>
					<td width="70%">
						<div class="heading-container">{{$pr_headline}}</div>
					</td>
					<td width="50%">
						<div class="logo-holder">
							<img src="{!!$pr_co_img!!}" style="width: 100%;">
						</div>
					</td>
				</tr>
			</table>

			<div class="sender-container"><span class="title-sender">Published by </span><span class="sender-name">{{$pr_sender_name}}</span></div>
			<div class="date-container">{{$pr_date_sent}}</div>
			<div class="content-container"><p>{!! str_replace('../', 'http://digimaweb.solutions/public/uploadthirdparty/', $pr_content); !!}</p></div>
			<div class="border"></div>
			<div class="title-about-container">About {{$pr_co_name}}</div>
			<div class="title-about-container">{{$pr_type}}</div>
			<div class="content-container">{!! str_replace('../', 'http://digimaweb.solutions/public/uploadthirdparty/', $pr_boiler_content); !!}</div>			
		</div>
	</div>
	<div style="text-align: center;padding: 0px 20px 0px 20px">                                         
		You can reply to me. <a href="{{$pr_from}}" >{{$pr_from}}</a>
	</div><br>
	<div style="text-align: center;padding: 0px 20px 0px 20px">                                         
		Don't want to recieve amazing emails from us? <a href="*|UNSUB:http://mywebsite.com/unsub|*">Unsubscribe.</a>
	</div>
</body>
</html>
