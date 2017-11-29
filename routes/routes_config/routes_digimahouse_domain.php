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
	Route::get('/product/view2/{id}', 'Shop\ShopProductContent2Controller@index');
	Route::get('/product/variant', 'Shop\ShopProductContentController@variant');
	Route::get('/product/search', 'Shop\ShopProductContentController@search');
	Route::get('/about', 'Shop\ShopAboutController@index');
	Route::get('/contact', 'Shop\ShopContactController@index');
	Route::post('/contact', 'Shop\ShopContactController@contact_submit');
	Route::get('/contact/find_store', 'Shop\ShopContactController@find_store'); //EDWARD GUEVARRA
	Route::any('/career', 'Shop\ShopCareerController@index'); //EDWARD GUEVARRA
	Route::get('/career/success', 'Shop\ShopCareerController@success'); //EDWARD GUEVARRA
	Route::get('/how', 'Shop\ShopHowController@index'); //EDWARD GUEVARRA
	Route::get('/youwin', 'Shop\ShopYouWinController@index'); //EDWARD GUEVARRA

	Route::get('/events', 'Shop\ShopEventsController@index'); //EDWARD GUEVARRA
	Route::get('/events/view/{id}', 'Shop\ShopEventsController@view'); //EDWARD GUEVARRA
	Route::any('/events/view_details','Shop\ShopEventsController@view_details'); // ARCY
	Route::any('/events/event_reserve','Shop\ShopEventsController@event_reserve'); // ARCY
	Route::any('/events/event_reserve_submit','Shop\ShopEventsController@event_reserve_submit'); // ARCY

	Route::get('/policy', 'Shop\ShopPolicyController@index'); //EDWARD GUEVARRA
	Route::get('/testimony', 'Shop\ShopTestimonyController@index'); //EDWARD GUEVARRA
	Route::get('/runruno', 'Shop\ShopAboutController@runruno'); //EDWARD GUEVARRA
	Route::get('/news', 'Shop\ShopAboutController@news'); //EDWARD GUEVARRA
	Route::get('/email_payment', 'Shop\ShopAboutController@email_payment'); //EDWARD GUEVARRA
	Route::get('/contactus', 'Shop\ShopAboutController@contactus'); //EDWARD GUEVARRA
	Route::get('/jobs', 'Shop\ShopAboutController@jobs'); //EDWARD GUEVARRA
	Route::get('/job', 'Shop\ShopAboutController@job'); //EDWARD GUEVARRA
	Route::post('/job/submit', 'Shop\ShopAboutController@job_submit');
	Route::get('/term','Shop\ShopTermsController@index');

	Route::get('/promos', 'Shop\ShopAboutController@promos'); //MARK FIGS
	Route::get('/promo_view', 'Shop\ShopAboutController@promo_view'); //MARK FIGS
	Route::get('/history', 'Shop\ShopAboutController@history'); //MARK FIGS
	Route::get('/how_to_join', 'Shop\ShopAboutController@how_to_join'); //MARK FIGS
	Route::get('/3xcell_login', 'Shop\ShopAboutController@xcell_login'); //MARK FIGS
	Route::get('/3xcell_signup', 'Shop\ShopAboutController@xcell_signup'); //MARK FIGS
	Route::get('/about_red_fruit', 'Shop\ShopAboutController@about_red_fruit'); //MARK FIGS

	Route::get('/gallery', 'Shop\ShopGalleryController@gallery'); //MARK FIGS
	Route::get('/gallery_content/{id}', 'Shop\ShopGalleryController@gallery_content'); //MARK FIGS
	
	Route::get('/mycart', 'Shop\ShopMyCartController@MyCart'); //MARK FIGS
	Route::get('/item_checkout', 'Shop\ShopItemCheckoutController@item_checkout'); //MARK FIGS
	Route::get('/item_payment', 'Shop\ShopItemPaymentController@item_payment'); //MARK FIGS
	Route::get('/payment_success', 'Shop\ShopItemPaymentController@payment_success'); //MARK FIGS

	Route::get('/replicated', 'Shop\ShopAboutController@replicated'); //MARK FIGS

	Route::get('/terms_and_conditions', 'Shop\ShopAboutController@terms_and_conditions'); //MARK FIGS

	Route::get('/signin', 'Shop\ShopLoginController@signin'); //ROMMEL C.

	Route::get('/sign_up', 'Shop\ShopRegisterController@press_signup'); //PRESS RELEASE
	Route::get('/pressmember', 'Shop\ShopMemberController@pressmember'); //PRESS RELEASE
	Route::get('/pressmember/view', 'Shop\ShopMemberController@pressmember_view'); //PRESS RELEASE

	Route::get('/blog', 'Shop\ShopBlogController@index');
	Route::get('/blog/content', 'Shop\ShopBlogContentController@index');
	Route::get('/payment', 'Shop\ShopPaymentController@index');
	Route::get('/order_placed', 'Shop\ShopCheckoutController@order_placed');
	Route::get('/addto_cart', 'Shop\ShopCheckoutController@addtocart');
	Route::get('/file/{theme}/{type}/{filename}', 'Shop\Shop@file');

	/*Product search*/
	Route::get('/product_search', 'Shop\ShopSearchController@index');
	/*End Product search*/

	/* Checkout */
	Route::any('/checkout/login', 'Shop\ShopCheckoutLoginController@index');
	Route::get('/checkout', 'Shop\ShopCheckoutController@index');
	Route::get('/checkout/side', 'Shop\ShopCheckoutController@checkout_side');
	Route::get('/checkout/locale', 'Shop\ShopCheckoutController@locale');
	Route::get('/checkout/session', 'Shop\ShopCheckoutController@session');
	Route::post('/checkout', 'Shop\ShopCheckoutController@submit');
	Route::any('/checkout/payment', 'Shop\ShopCheckoutController@payment');
	Route::any('/checkout/payment/upload', 'Shop\ShopCheckoutController@payment_upload');
	Route::get('/checkout/method', 'Shop\ShopCheckoutController@update_method');
	/* End Checkout */

	/* Wishlist */
	Route::get('/wishlist/add/{id}', 'Shop\ShopWishlistController@add');
	Route::get('/wishlist/remove/{id}', 'Shop\ShopWishlistController@remove');

	/* Login E-commerce */
	Route::get('/account', 'Shop\ShopAccountController@index');
	Route::get('/account/order', 'Shop\ShopAccountController@order');
	Route::get('/account/wishlist', 'Shop\ShopAccountController@wishlist');
	Route::get('/account/settings', 'Shop\ShopAccountController@settings');
	Route::post('/account/settings', 'Shop\ShopAccountController@settings_submit');
	Route::get('/account/security', 'Shop\ShopAccountController@security');
	Route::post('/account/security', 'Shop\ShopAccountController@security_submit');
	Route::get('/account/invoice/{id}', 'Shop\ShopAccountController@invoice');
	Route::get('/account/logout', 'Shop\ShopAccountController@logout');
	Route::post('/account/login', 'Shop\ShopLoginController@submit');

	/*E-commerce registration*/
	Route::get('/account/register', 'Shop\ShopAccountController@account_register'); //Brain
	Route::post('/account/register', 'Mlm\MlmRegisterController@register_ecomm'); //Brain

	/* Others */
	Route::get('/partners', 'Shop\ShopPartnersController@index');
	Route::get('/partners_views', 'Shop\ShopPartnersController@partners_views');
	Route::get('/partner-filtering-location', 'Shop\ShopPartnersController@partnerFilterByLocation');
	Route::get('/legalities', 'Shop\ShopLegalitiesController@index');


	Route::get('/manual_checkout', 'Shop\ShopManualCheckout@index');
	Route::post('/manual_checkout', 'Shop\ShopManualCheckout@submit_proof');
	Route::get('/manual_checkout/success', 'Shop\ShopManualCheckout@success');

	/* Cart V2 */
	Route::get('/cartv2', 'Shop\ShopCart2Controller@index');
	Route::get('/cartv2/add', 'Shop\ShopCart2Controller@add_cart');
	Route::get('/cartv2/remove', 'Shop\ShopCart2Controller@remove_cart');
	Route::get('/cartv2/update', 'Shop\ShopCart2Controller@update_cart');
	Route::get('/cartv2/clear', 'Shop\ShopCart2Controller@clear_cart');
	Route::get('/cartv2/quantity', 'Shop\ShopCart2Controller@quantity_cart');
	Route::get("/cartv2/buy_kit_mobile/{id}", 'Shop\ShopCart2Controller@buy_kit_mobile');
}