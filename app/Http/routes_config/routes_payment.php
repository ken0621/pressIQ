<?php
/* Payment Integration with Dragon Pay */
Route::get('/payment/dragonpay', 'PaymentController@index');
Route::post('/payment/dragonpay', 'PaymentController@onSubmitPayment');
Route::post('/payment/dragonpay/postback', 'Shop\ShopCheckoutController@dragonpay_postback');
// Route::any('/payment/dragonpay/post', 'Shop\ShopCheckoutController@dragonpay_postback');
Route::get('/payment/dragonpay/return', 'Shop\ShopCheckoutController@dragonpay_return');
/* End Dragon Pay */

/* Payment Integration with iPay88 */
Route::any("/ipay88_response","Shop\ShopCheckoutController@ipay88_response"); //Brain
/* End iPay88 */