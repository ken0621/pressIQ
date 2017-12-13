$(document).ready(function () 
{
	$(document).on('#btn_add_recipient',function(){
	

	});
});
	
$(document).ready(function () 
{
	$(document).on('click',"#select_all",function()
	{	
		  $('input[name=checkbox').prop('checked', true);
		
	});
});	

$(document).ready(function () 
{
	$(document).on('click',"#unselect_all",function()
	{	
		  $('input[name=checkbox').prop('checked', false);
		
	});
});	


$(document).ready(function(){
	$(document).on('click','#search_button',function()
	{
		var search_key = $('#search_key').val();
	
		$.ajax({
			type:'GET',
			url:'/pressuser/pressrelease/recipient/search',
			data:{
				search_key: search_key,
			},
			dataType:'text',
		}).done(function(data)
			{		
				$('#showHere_table').html(data);
			});
    });
});


$(document).ready(function(){
	$(document).on('click','#recipient_submit',function()
	{
	    var recipient_id = $(this).data("id");
        alert(recipient_id);

  
    });
});


