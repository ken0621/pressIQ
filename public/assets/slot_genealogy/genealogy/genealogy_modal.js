var genealogy_modal = new genealogy_modal();

function genealogy_modal()
{
	init();
	
	function init()
	{
		$(document).ready(function()
		{
			document_ready();
			console.log('genealogy_modal');
		});
	}
	function document_ready()
	{
		event_add_slot();
		event_close_modal();
		select2();
	}
	function select2()
	{
		$('.code-vault').select2();
	}
	function event_add_slot()
	{
		$('body').on('click','.positioning',function(e)
        {
            console.log($(e.currentTarget).attr('placement'));
            event_show_modal();
        });
	}
	function event_close_modal()
	{
		$('.close-modal').on('click',function()
		{
			var modal = document.getElementById('myModal');
			modal.style.display = "none";
		});
	}
	function event_show_modal()
	{
        var modal = document.getElementById('myModal');
		modal.style.display = "block";
	}
}