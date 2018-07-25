
$(document).ready(function(){
	$(document).on('click','#search_button',function()
	{
		var search_media = $('#search_media').val();

		$.ajax({
			type:'GET',
			url:'/mediacontacts/search',
			data:{
				search_media: search_media,
			},
			dataType:'text',
		}).done(function(data)
			{		
				$('#showHere_table1').html(data);
		});
    });
});

$(document).ready(function(){
	$(document).on('click','#filter_data',function()
	{
		var filter_country	= $('#country_filter').val();
		var filter_industry	= $('#industry_type_filter').val();
		var filter_media 	= $('#media_type_filter').val();

		$.ajax({
			type:'GET',
			url:'/mediacontacts/filter',
			data:{
				filter_country: filter_country,
				filter_industry: filter_industry,
				filter_media: filter_media,
			},
			dataType:'text',
		}).done(function(data)
			{		
				$('#showHere_table1').html(data);
		});
    });
});

$(document).ready(function () 
{ 
	$(document).on('click',"#select_all",function()
	{	
		var $checkboxes = $('#choose_recipient_form td input.checkbox').prop('checked', true);
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $('#Chosen_total').text(countCheckedCheckboxes);
	});
});	

$(document).ready(function () 
{
	$(document).on('click',"#unselect_all",function()
	{	
		var $checkboxes = $('#choose_recipient_form td input.checkbox').prop('checked', false);
		var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $('#Chosen_total').text(countCheckedCheckboxes);
	});
});	

$(document).ready(function(){
	$(document).on('click','.pop_delete_all',function()
	{

		var checks = [];
		checks = $("form#choose_recipient_form").serialize();

		$.ajax({
			headers: 
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			method:'POST',
			url:'/mediacontacts/delete_all',
			data:checks,
			dataType:'text',
			success:function(data)
			{		
				location.reload();
			}
		});
  	});
  	$(document).on('click','.pop_delete_all_confirm',function()
	{
		var length_check = $('input.checkbox:checked').length;
		if(length_check == 0)			
		{
			var message = "No Selected Contacts!";
			$('#viewPopupMediaDeleteAll').find('.modal-title').html(message);
			$('#viewPopupMediaDeleteAll').find('.modal-footer .pop_delete_all').hide();
			$('#viewPopupMediaDeleteAll').find('.modal-footer .pop_no_del').hide();
			$('#viewPopupMediaDeleteAll').modal('show');
		}
		else
		{
			var message = "Are you sure you want to Delete Checked Checkbox?";
			$('#viewPopupMediaDeleteAll').find('.modal-title').html(message);
			$('#viewPopupMediaDeleteAll').find('.modal-footer .pop_delete_all').show();
			$('#viewPopupMediaDeleteAll').find('.modal-footer .pop_no_del').show();
			$('#viewPopupMediaDeleteAll').modal('show');
		}

  	});
});








