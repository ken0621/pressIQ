$(document).ready(function () 
{
	$(document).on('#btn_add_recipient',function(){
	

	});
});
	
$(document).ready(function () 
{
	$(document).on("change","#choose_country",function()
	{
		var country = $(this).val();

		 $.ajax({
            type:'POST',
            url:'/pressuser/pressrelease/recipient',
            data:
            	{
            	country: country,
            	},
            dataType:'text',
            }).done(function(data)
            {
             	$('#country_table').show(data);
             	
            });
	});
});



