<center>
	Hello!
	@if(Request::input('notify') == 5)
	You're just a few steps away to use your account, please check your email to verify payment through <strong>DragonPay</strong> instruction.
	@else
	You're just a few steps away to use your account, please check your email to see your username and password. 
	@endif
	
	<hr>
	@if(Request::input('notify') == 2)
		Your payment gateway will also send send an email to you regarding your payment.
	@endif
	@if(Request::input('notify') == 3)
		Your payment has failed.
	@endif
	@if(Request::input('notify') == 4)
		Your payment has been cancelled.
	@endif
</center>