$(document).ready(function () 
{
	$(document).on('#btn_add_recipient',function(){
	

	});
});
	
$(document).ready(function () 
{
	$(document).on("#choose_recipient1",function()
	{	
		alert("123");
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
		var name = $(this).val();

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



