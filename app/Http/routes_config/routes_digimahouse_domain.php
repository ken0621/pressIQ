<?php
if(($domain != "digimahouse.com" && $domain != "digimahouse.dev" && $domain != "digimatest.com") || (hasSubdomain() && $domain != "my168shop-primia.c9users.io"))
{
	Route::get('/', 'Shop\ShopHomeController@index');
	Route::get('/cart', 'Shop\ShopCartController@index');
	Route::get('/mini_cart', 'Shop\ShopCartController@mini_cart');
	Route::get('/cart/quick', 'Shop\ShopCartController@quick_cart');
	Route::get('/cart/add', 'Shop\ShopCartController@add_cart');
	Route::get('/cart/remove', 'Shop\ShopCartController@remove_cart');
	Route::get('/cart/update', 'Shop\ShopCartController@update_cart');
	Route::get('/cart/clear', 'Shop\ShopCartController@clear_cart');
	Route::get('/product', 'Shop\ShopProductController@index');
	Route::get('/product/view/{id}', 'Shop\ShopProductContentController@index');
	Route::get('/product/variant', 'Shop\ShopProductContentController@variant');
	Route::get('/product/search', 'Shop\ShopProductContentController@search');
	Route::get('/about', 'Shop\ShopAboutController@index');
	Route::get('/contact', 'Shop\ShopContactController@index');
	Route::post('/contact', 'Shop\ShopContactController@contact_submit');
	Route::get('/contact/find_store', 'Shop\ShopContactController@find_store'); //EDWARD GUEVARRA
	Route::get('/career', 'Shop\ShopCareerController@index'); //EDWARD GUEVARRA
	Route::get('/how', 'Shop\ShopHowController@index'); //EDWARD GUEVARRA
	Route::get('/youwin', 'Shop\ShopYouWinController@index'); //EDWARD GUEVARRA
	Route::get('/events', 'Shop\ShopEventsController@index'); //EDWARD GUEVARRA
	Route::get('/events/view/{id}', 'Shop\ShopEventsController@view'); //EDWARD GUEVARRA
	Route::get('/policy', 'Shop\ShopPolicyController@index'); //EDWARD GUEVARRA
	Route::get('/testimony', 'Shop\ShopTestimonyController@index'); //EDWARD GUEVARRA
	Route::get('/runruno', 'Shop\ShopAboutController@runruno'); //EDWARD GUEVARRA
	Route::get('/news', 'Shop\ShopAboutController@news'); //EDWARD GUEVARRA
	Route::get('/contactus', 'Shop\ShopAboutController@contactus'); //EDWARD GUEVARRA
	Route::get('/account', 'Shop\ShopAccountController@index');

	Route::get('/blog', 'Shop\ShopBlogController@index');
	Route::get('/blog/content', 'Shop\ShopBlogContentController@index');
	Route::get('/checkout/login', 'Shop\ShopCheckoutLoginController@login');
	Route::get('/checkout', 'Shop\ShopCheckoutController@index');
	Route::post('/checkout', 'Shop\ShopCheckoutController@submit');
	Route::get('/payment', 'Shop\ShopPaymentController@index');
	Route::get('/order_placed', 'Shop\ShopCheckoutController@order_placed');
	Route::get('/addto_cart', 'Shop\ShopCheckoutController@addtocart');
	Route::get('/admin', 'Shop\Shop@admin');
	Route::get('/file/{theme}/{type}/{filename}', 'Shop\Shop@file');

	/*Payment Integration with iPay88*/
	Route::any("/postPaymentWithIPay88","Shop\ShopCheckoutController@postPaymentWithIPay88"); //Brain
	Route::any("/ipay88_response","Shop\ShopCheckoutController@ipay88_response"); //Brain

	/*End ipay88*/
}