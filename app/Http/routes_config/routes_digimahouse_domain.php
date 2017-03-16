<?php
if(($domain != "digimahouse.com" && $domain != "digimahouse.dev" && $domain != "my168shop-primia.c9users.io") || (hasSubdomain() && $domain != "my168shop-primia.c9users.io"))
{
	Route::get('/', 'Shop\ShopHomeController@index');
	Route::get('/cart', 'Shop\ShopCartController@index'); //EDWARD GUEVARRA
	Route::get('/cart/add', 'Shop\ShopCartController@add_cart'); //EDWARD GUEVARRA
	Route::get('/cart/remove', 'Shop\ShopCartController@remove_cart'); //EDWARD GUEVARRA
	Route::get('/cart/update', 'Shop\ShopCartController@update_cart'); //EDWARD GUEVARRA
	Route::get('/cart/clear', 'Shop\ShopCartController@clear_cart'); //EDWARD GUEVARRA
	Route::get('/product', 'Shop\ShopProductController@index'); //EDWARD GUEVARRA
	Route::get('/product/view/{id}', 'Shop\ShopProductContentController@index'); //EDWARD GUEVARRA
	Route::get('/product/variant', 'Shop\ShopProductContentController@variant'); //EDWARD GUEVARRA
	Route::get('/about', 'Shop\ShopAboutController@index'); //EDWARD GUEVARRA
	Route::get('/contact', 'Shop\ShopContactController@index'); //EDWARD GUEVARRA
	Route::get('/career', 'Shop\ShopCareerController@index'); //EDWARD GUEVARRA
	Route::get('/how', 'Shop\ShopHowController@index'); //EDWARD GUEVARRA

	Route::get('/blog', 'Shop\ShopBlogController@index'); //EDWARD GUEVARRA
	Route::get('/blog/content', 'Shop\ShopBlogContentController@index'); //EDWARD GUEVARRA
	Route::get('/checkout', 'Shop\ShopCheckoutController@index'); //EDWARD GUEVARRA
	Route::get('/payment', 'Shop\ShopPaymentController@index'); //EDWARD GUEVARRA
	Route::get('/order_placed', 'Shop\ShopCheckoutController@order_placed'); //EDWARD GUEVARRA
	Route::get('/addto_cart', 'Shop\ShopCheckoutController@addtocart');
	Route::get('/admin', 'Shop\Shop@admin');
	Route::get('/file/{theme}/{type}/{filename}', 'Shop\Shop@file');
}