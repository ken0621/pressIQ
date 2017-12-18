$('body').on('click','.select-action', function()
{
	$('.button-action').val($(this).attr('code'));
	$('.global-submit').submit();
});