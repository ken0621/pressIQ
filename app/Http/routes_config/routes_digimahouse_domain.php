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
	Route::get('/jobs', 'Shop\ShopAboutController@jobs'); //EDWARD GUEVARRA
	Route::get('/job', 'Shop\ShopAboutController@job'); //EDWARD GUEVARRA

	Route::get('/promos', 'Shop\ShopAboutController@promos'); //MARK FIGS
	Route::get('/promo_view', 'Shop\ShopAboutController@promo_view'); //MARK FIGS
	Route::get('/history', 'Shop\ShopAboutController@history'); //MARK FIGS
	Route::get('/how_to_join', 'Shop\ShopAboutController@how_to_join'); //MARK FIGS
	Route::get('/3xcell_login', 'Shop\ShopAboutController@xcell_login'); //MARK FIGS
	Route::get('/about_red_fruit', 'Shop\ShopAboutController@about_red_fruit'); //MARK FIGS

	Route::get('/gallery', 'Shop\ShopGalleryController@gallery'); //MARK FIGS
	Route::get('/gallery_content', 'Shop\ShopGalleryController@gallery_content'); //MARK FIGS
	
	Route::get('/MyCart', 'Shop\ShopMyCartController@MyCart'); //MARK FIGS
	Route::get('/item_checkout', 'Shop\ShopItemCheckoutController@item_checkout'); //MARK FIGS
	Route::get('/item_payment', 'Shop\ShopItemPaymentController@item_payment'); //MARK FIGS
	Route::get('/payment_success', 'Shop\ShopItemPaymentController@payment_success'); //MARK FIGS



	Route::get('/blog', 'Shop\ShopBlogController@index');
	Route::get('/blog/content', 'Shop\ShopBlogContentController@index');
	Route::get('/payment', 'Shop\ShopPaymentController@index');
	Route::get('/order_placed', 'Shop\ShopCheckoutController@order_placed');
	Route::get('/addto_cart', 'Shop\ShopCheckoutController@addtocart');
	Route::get('/admin', 'Shop\Shop@admin');
	Route::get('/file/{theme}/{type}/{filename}', 'Shop\Shop@file');

	/*Payment Integration with iPay88*/
	Route::any("/postPaymentWithIPay88","Shop\ShopCheckoutController@postPaymentWithIPay88"); //Brain
	Route::any("/ipay88_response","Shop\ShopCheckoutController@ipay88_response"); //Brain
	/*End ipay88*/

	/*Product search*/
	Route::get('/product_search', 'Shop\ShopSearchController@index');
	/*End Product search*/

	/* Checkout */
	Route::get('/checkout/login', 'Shop\ShopCheckoutLoginController@index');
	Route::get('/checkout', 'Shop\ShopCheckoutController@index');
	Route::get('/checkout/payment', 'Shop\ShopCheckoutController@payment');
	Route::post('/checkout', 'Shop\ShopCheckoutController@submit');
	/* End Checkout */

	/* Wishlist */
	Route::get('/wishlist/add/{id}', 'Shop\ShopWishlistController@add');
	Route::get('/wishlist/remove/{id}', 'Shop\ShopWishlistController@remove');

	/* Login E-commerce */
	Route::get('/account', 'Shop\ShopAccountController@index');
	Route::get('/account/order', 'Shop\ShopAccountController@order');
	Route::get('/account/wishlist', 'Shop\ShopAccountController@wishlist');
	Route::get('/account/settings', 'Shop\ShopAccountController@settings');
	Route::get('/account/security', 'Shop\ShopAccountController@security');
	Route::post('/account/security', 'Shop\ShopAccountController@security_submit');
	Route::get('/account/invoice/{id}', 'Shop\ShopAccountController@invoice');
	Route::get('/account/logout', 'Shop\ShopAccountController@logout');
	Route::post('/account/login', 'Shop\ShopLoginController@submit');

	/*E-commerce registration*/
	Route::get('/account/register', 'Shop\ShopAccountController@account_register'); //Brain
	Route::post('/account/register', 'Mlm\MlmRegisterController@register_ecomm'); //Brain

}