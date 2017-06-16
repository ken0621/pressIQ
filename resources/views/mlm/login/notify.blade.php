<center>
	Hello!
	You're just a few steps away to use your account, please check your email to see your username and password. 
	
	<hr>
	@if(Request::input('notify') == 2)
		Your payment gateway will also send send an email to you regarding your payment.
	@endif
</center>