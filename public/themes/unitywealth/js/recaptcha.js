var recaptcha = new recaptcha();

function recaptcha()
{
	init();
	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}
	function document_ready()
	{
		action_enable_button($('.g-recaptcha-response').val());
		event_verify();
		console.log('recaptcha.js loaded');
	}
	function event_verify()
	{
		$('body').on('click','#recaptcha-verify-button',function()
		{
			alert(123);
			action_enable_button($('.g-recaptcha-response').val());
		})
	}
	function action_enable_button(data)
	{
		if(data == '' || data == 'undefined')
		{
			$('.submit-captcha').attr('disabled',false);
		}
		else
		{
			$('.submit-captcha').attr('disabled',true);
		}
		
	}
}