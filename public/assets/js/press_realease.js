$(document).ready(function () 
{
	$(document).on('#btn_add_recipient',function(){
	

	});
});
	
$(document).ready(function () 
{
	$(document).on("#done_recipients",function()
	{	
		var name = $(this).data("name");
		$('#recipient_name').val(name);
		$('#recipient-modal').modal('hide');
		alert(pr_receiver_name);
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



