$(document).ready(function () 
{
	$(document).on('#btn_add_recipient',function(){
	

	});
});
	
$(document).ready(function () 
{
	$(document).on("#choose_recipient",function()
	{	
		var name = $(this).data("name");
		var email = $(this).data("name1");
		$('#recipient_name').val(name);
		$('#recipient_email').val(email);
		$('#recipient-modal').modal('hide');
		// alert(email);
	});
});

$(document).ready(function () 
{
	$(document).on("change","#choose_country",function()
	{
		var country = $(this).val();
		var name = $(this).val();
		alert(country);

		 $.ajax({
            type:'POST',
            url:'/pressuser/pressrelease/recipient',
            data:
            	{
            	name: name,
            	country: country,
            	},
            dataType:'text',
            }).done(function(data)
            {
             	$('#country_table').show(data);
             	
            });
	});
});



