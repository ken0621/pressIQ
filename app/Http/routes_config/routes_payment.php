<?php
/* Payment Integration with Dragon Pay */
Route::get('/payment/dragonpay', 'PaymentController@index');
Route::post('/payment/dragonpay', 'PaymentController@onSubmitPayment');
Route::get('/payment/dragonpay/postback', 'PaymentController@postback_url'); //confirmation upon payment
Route::get('/payment/dragonpay/return', 'ShopCheckoutController@dragonpay_response'); //
/* End Dragon Pay */

/* Payment Integration with iPay88 */
Route::any("/ipay88_response","Shop\ShopCheckoutController@ipay88_response"); //Brain
/* End iPay88 */