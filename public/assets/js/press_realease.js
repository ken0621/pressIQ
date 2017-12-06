$(document).ready(function () 
{
	$(document).on('click','#btn_add_recipient',function(){
		var name 					= $('#name').val();
		var research_email_address	= $('#research_email_address').val();
		var website 				= $('#website').val();
		var description 			= $('#description').val();
		var country 				= $('#country').val();
		// alert(website);

	});
});

	
$(document).ready(function () 
{
	$(document).on("click","#choose_recipient",function()
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
		alert(country);

		 $.ajax({
            type:'POST',
            url:'/pressuser/pressrelease',
            data:
            	{
            	country: country,
            	},
            dataType:'text',
            }).done(function(data)
            {
            	alert(country);
             	$('#country_table').show(data);
             	
            });
 
	});
});



