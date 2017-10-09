$(document).ready(function(){
	$('#filteredrr').on('change', function(e){
		var shop_id = $(this).val();
		$.ajax({
			type: 'GET',
			url: '/admin/shop_user_accounts_filter1',
			data: {shop_id: shop_id},
			success:function(data)
			{
				$('.shop_table').html(data);
			}
		
	});
	
});
});	

var ajaxdata = {};
      $('.fa-spin').hide();
      $("body").on("click", ".pagination a", function(e)
      {
      $('.fa-spin').show();
      $url = $(e.currentTarget).attr("href"); //get URL (string)
      var url = new URL($url); //convert format URL
      $page = url.searchParams.get("page"); //get the page in the URL
      ajaxdata.page = $page;
      ajaxdata.page = 1;
      action_load_table($url);
      return false;
    });

  function action_load_table($url)
  {

  	$(".shop_table").load($url+" .shop_table"); 
  	$(".pagination-container").load($url+" .pagination-container", function()
    {
     $('.fa-spin').hide();
   }); 
  } 