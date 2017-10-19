var global_shop_id = 0;
$(document).ready(function(){
  // $('.shop_table_container').load("/admin/shop_user_accounts_filter1");
	
    var shop_id = 0;
    $.ajax(
    {
      type: 'GET',
      url: '/admin/shop_user_accounts_filter1',
      data: {shop_id: shop_id},
      success:function(data)
      {
        $('.shop_table_container').html(data);
      }
    
    });

  $('#filteredrr').on('change', function(e){
		var shop_id = $(this).val();
        global_shop_id = shop_id;
		$.ajax({
			type: 'GET',
			url: '/admin/shop_user_accounts_filter1',
			data: {shop_id: shop_id},
			success:function(data)
			{
				$('.shop_table_container').html(data);
			}
		
	});
	
});
});	

var ajaxdata = {};
      $("body").on("click", ".pagination a", function(e)
      {
      $url = $(e.currentTarget).attr("href"); //get URL (string)
      var url = new URL($url); //convert format URL
      $page = url.searchParams.get("page"); //get the page in the URL
      ajaxdata.page = $page;
      ajaxdata.page = 1;
      action_load_table($url,$page);
      return false;
    });

  function action_load_table($url,$page)
  {
    // alert($url,$page);
    $.ajax(
    {
      type: 'GET',
      url: '/admin/shop_user_accounts_filter1',
      data: {shop_id: global_shop_id,page:$page},
      success:function(data)
      {
        $('.shop_table_container').html(data);
      }
    
    });
  	/*$(".pagination-container").load($url+" .pagination-container", function()*/
    /*{*/
  /* }); */
  } 

  
