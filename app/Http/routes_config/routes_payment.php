<?php
/* Payment Integration with Dragon Pay */
Route::get('/payment/dragonpay', 'PaymentController@index');
Route::post('/payment/dragonpay', 'PaymentController@onSubmitPayment');
Route::any('/payment/dragonpay/postback', 'Shop\ShopCheckoutController@dragonpay_postback');
Route::any('/payment/dragonpay/logs', 'Shop\ShopCheckoutController@dragonpay_logs');
Route::get('/payment/dragonpay/return', 'Shop\ShopCheckoutController@dragonpay_return');
/* End Dragon Pay */

/* Payment Integration with iPay88 */	
Route::any("/ipay88_response","Shop\ShopCheckoutController@ipay88_response"); //Brain
/* End iPay88 */

/* Payment Integration with Paymaya */
Route::any('/payment/paymaya/success', 'Shop\ShopCheckoutController@paymaya_success');
Route::any('/payment/paymaya/failure', 'Shop\ShopCheckoutController@paymaya_failure');
Route::any('/payment/paymaya/cancel', 'Shop\ShopCheckoutController@paymaya_cancel');
/* Webhook */
Route::any('/payment/paymaya/webhook/success', 'Shop\ShopCheckoutController@paymaya_webhook_success');
Route::any('/payment/paymaya/webhook/failure', 'Shop\ShopCheckoutController@paymaya_webhook_failure');
Route::any('/payment/paymaya/webhook/cancel', 'Shop\ShopCheckoutController@paymaya_webhook_cancel');
/* End Webhook */
Route::any('/payment/paymaya/maintenance', 'MemberController@paymaya_maintenance');
Route::get('/payment/paymaya/maintenance/edit/{id}', 'MemberController@paymaya_maintenance_edit');
Route::post('/payment/paymaya/maintenance/edit/{id}', 'MemberController@paymaya_maintenance_edit_post');
Route::any('/payment/paymaya/logs', 'Shop\ShopCheckoutController@paymaya_logs');
Route::any('/payment/paymaya/logs/view/{id}', 'Shop\ShopCheckoutController@paymaya_logs_view');
/* End Paymaya */