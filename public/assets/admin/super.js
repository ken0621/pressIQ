var myApp = new Framework7(
{
	animateNavBackIcon:true,
	cache:false,
    onAjaxStart: function (xhr) { myApp.showIndicator(); },
    onAjaxComplete: function (xhr) { myApp.hideIndicator(); }
});

var $$ = Dom7;
var mainView = null;
var admin = new admin();

function admin()
{
	init();

	function init()
	{
		framework7init();

		$(document).ready(function()
		{
			page_ready();
		});

        myApp.onPageInit('customer-list', function(page)
        {
        	var mySearchbar = $$('.searchbar')[0].f7Searchbar;
        });

        myApp.onPageInit('customer-edit', function(page)
        {
			$$('.confirm-archive').on('click', function ()
			{
			    myApp.confirm('Are you sure you want to archive this customer?','Confirm Archive', function ()
			    {
			        $shop_id = $(".customer-edit-shop-id").val();

			        $.ajax(
			        {
			        	url:"/super/customer-archive",
			  			data: {'shop_id':$shop_id},
			  			type:"get",
			  			success: function(data)
			  			{
			  				mainView.router.back(
			  				{
			  					url: page.view.history[page.view.history.length - 2],
			  					force: true,
                    			ignoreCache: true
                			});

			  			}
			        });

  
				});
			});

			$$('.confirm-restore').on('click', function ()
			{
			    myApp.confirm('Are you sure you want to restore this customer?','Confirm Restore', function ()
			    {
			        $shop_id = $(".customer-edit-shop-id").val();

			        $.ajax(
			        {
			        	url:"/super/customer-restore",
			  			data: {'shop_id':$shop_id},
			  			type:"get",
			  			success: function(data)
			  			{
			  				mainView.router.back(
			  				{
			  					url: page.view.history[page.view.history.length - 3],
			  					force: true,
                    			ignoreCache: true
                			});
			  			}
			        });

  
				});
			});
		});

        myApp.onPageInit('*', function(page)
        {
			$$('form.ajax-submit').on('form:success', function (e)
			{
				var isjson = true;

				try
				{
					var data = $.parseJSON(e.detail.data);
				}
				catch(err)
				{
					isjson = false;
				}

				if(isjson)
				{
					myApp.alert(data.message, data.title);
				}
				else
				{
					myApp.alert("Kindly check your internet connection.", "Error Occurred");
				}

				myApp.hideIndicator();
			});

			$$('form.ajax-submit').on('form:beforesend', function (e) { myApp.showIndicator(); });
			$$('form.ajax-submit').on('form:error', function (e) { myApp.hideIndicator(); });
        });

	}
	function page_ready()
	{

	}
	function framework7init()
	{
		mainView = myApp.addView('.view-main',
		{
		    dynamicNavbar: true,
		    domCache: true
		});
	}
}