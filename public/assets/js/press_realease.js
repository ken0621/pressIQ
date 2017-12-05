$(document).ready(function () 
{
	$(document).on('click','#btn_add_recipient',function(){
		var name 					= $('#name_recipient').val();
		var research_email_address	= $('#research_email_address').val();
		var website 				= $('#website').val();
		var description 			= $('#description').val();
		var country 				= $('#country').val();
		// alert(123);

		// $.ajax({
		// 	type:'POST',
		// 	url:'/pressadmin/pressreleases_addrecipient',
		// 	data:{
		// 		name_recipient: name_recipient,
		// 		research_email_address: research_email_address,
		// 		website: website,
		// 		description: description,
		// 		country: country,
		// 		},
		// 	dataType:'text',
		// }).done(function(data){
		// 	alert(123);
		// 	$('#message').html(data);
		// 		setTimeout(function(){
		// 		   location.reload();
		// 		}, 1000);
		// 	});

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



