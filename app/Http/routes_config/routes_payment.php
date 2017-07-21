<?php
/* Payment Integration with Dragon Pay */
Route::get('/payment/dragonpay', 'PaymentController@index');
Route::post('/payment/dragonpay', 'PaymentController@onSubmitPayment');
Route::any('/payment/dragonpay/postback', 'Shop\ShopCheckoutController@dragonpay_postback');
Route::any('/payment/dragonpay/logs', 'Shop\ShopCheckoutController@dragonpay_logs');
Route::get('/payment/dragonpay/return', 'Shop\ShopCheckoutController@dragonpay_return');
/* End Dragon Pay */

/* Payment Integration with iPay88 */
Route::any("/payment/ipay88/response","Shop\ShopCheckoutController@ipay88_response");
Route::any("/payment/ipay88/backend","Shop\ShopCheckoutController@ipay88_backend");
/* End iPay88 */

/* Payment Integration with Paymaya */
Route::any('/payment/paymaya/success', 'Shop\ShopCheckoutController@paymaya_success');
Route::any('/payment/paymaya/failure', 'Shop\ShopCheckoutController@paymaya_failure');
Route::any('/payment/paymaya/cancel', 'Shop\ShopCheckoutController@paymaya_cancel');
/* End Paymaya */