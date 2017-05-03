<?php
Route::get('/mlm/membership_active_code/{pin}', 'Mlm\MlmLoginController@membership_active_code'); 
Route::post('/mlm/membership_active_code/active/code', 'Mlm\MlmLoginController@membership_active_code_post'); 
Route::get('/mlm/login', 'Mlm\MlmLoginController@index'); 
Route::post('/mlm/login', 'Mlm\MlmLoginController@post_login'); 

Route::get('/mlm/login/forgot_password','Mlm\MlmLoginController@forgot_password'); //ARCY
Route::any('/mlm/login/forgot_password/submit','Mlm\MlmLoginController@forgot_password_submit'); //ARCY

Route::get('/mlm/register', 'Mlm\MlmRegisterController@index'); 
Route::get('/mlm/register/package', 'Mlm\MlmRegisterController@package'); 
Route::get('/mlm/register/payment', 'Mlm\MlmRegisterController@payment'); 
Route::post('/mlm/register', 'Mlm\MlmRegisterController@post_register'); 

Route::get('/mlm/register/get/membership_code/{membership_code}', 'Mlm\MlmRegisterController@view_customer_info_via_mem_code');

Route::get('/mlm', 'Mlm\MlmDashboardController@index'); 
Route::get('/mlm/news/{id}', 'Mlm\MlmDashboardController@news_content'); 
Route::get('/mlm/profile', 'Mlm\MlmProfileController@index'); 
Route::get('/mlm/notification', 'Mlm\MlmNotificationController@index'); 
Route::any('/mlm/claim/slot', 'Mlm\MlmDashboardController@claim_slot'); 

Route::any('/mlm/network/binary', 'Mlm\MlmNetworkController@binary'); 
Route::any('/mlm/network/unilevel', 'Mlm\MlmNetworkController@unilevel'); 
//
Route::any('/mlm/profile/edit/password', 'Mlm\MlmProfileController@password'); 
Route::any('/mlm/profile/edit/contact', 'Mlm\MlmProfileController@contact');
Route::any('/mlm/profile/edit/basic', 'Mlm\MlmProfileController@basic');
Route::any('/mlm/profile/edit/picture', 'Mlm\MlmProfileController@profile_picture_upload');
Route::any('/mlm/profile/edit/encashment', 'Mlm\MlmProfileController@update_encashment');
//
Route::get('/mlm/repurchase', 'Mlm\MlmRepurchaseController@index'); 
Route::get('/mlm/repurchase/cart', 'Mlm\MlmRepurchaseController@cart'); 
Route::get('/mlm/repurchase/add_cart', 'Mlm\MlmRepurchaseController@add_cart'); 
Route::get('/mlm/repurchase/remove_item', 'Mlm\MlmRepurchaseController@remove_item'); 
Route::get('/mlm/repurchase/clear_cart', 'Mlm\MlmRepurchaseController@clear_cart'); 
Route::get('/mlm/repurchase/checkout', 'Mlm\MlmRepurchaseController@checkout'); 
Route::post('/mlm/repurchase/checkout/submit', 'Mlm\MlmRepurchaseController@checkout_submit'); 

Route::get('/mlm/vouchers', 'Mlm\MlmVouchersController@index'); 
Route::get('/mlm/cheque', 'Mlm\MlmChequeController@index'); 
Route::any('/mlm/changeslot', 'Mlm\Mlm@changeslot');

Route::get('/mlm/cheque', 'Mlm\MlmChequeController@index'); 
Route::get('/mlm/wallet', 'Mlm\MlmTransferController@index'); 
Route::get('/mlm/refill', 'Mlm\MlmTransferController@refill'); 
Route::get('/mlm/refill/request', 'Mlm\MlmTransferController@request_refill'); 
Route::any('/mlm/refill/request/submit', 'Mlm\MlmTransferController@request_refill_post'); 
Route::get('/mlm/transfer', 'Mlm\MlmTransferController@transfer'); 
Route::post('/mlm/transfer/submit', 'Mlm\MlmTransferController@transfer_submit'); 
Route::get('/mlm/transfer/get/customer/{id}', 'Mlm\MlmTransferController@transfer_get_customer'); 
Route::get('/mlm/encashment', 'Mlm\MlmTransferController@encashment'); 
Route::post('/mlm/encashment/request', 'Mlm\MlmTransferController@encashment_request'); 
Route::any('/mlm/encashment/view/breakdown/{encashment_process}/{slot_id}', 'Mlm\MlmTransferController@breakdown_slot');//luke
/* MLM VOUCHERS */
Route::get('/mlm/vouchers', 'Mlm\MlmVouchersController@index'); 
Route::get('/mlm/vouchers/view_voucher', 'Mlm\MlmVouchersController@view_voucher'); 
Route::get('/mlm/gc', 'Mlm\MlmVouchersController@gc'); 

/* MLM GENEALOGY */
Route::get('/mlm/genealogy/{tree}', 'Mlm\MlmGenealogyController@index'); 
Route::any('/mlm/slot/genealogy', 'Mlm\MlmGenealogyController@tree');
Route::any('/mlm/slot/genealogy/downline', 'Mlm\MlmGenealogyController@downline');
/* MLM GENEALOGY REPORTS */

/* MLM MEMBER REPORTS */
Route::get('/mlm/report/{complan}', 'Mlm\MlmReportController@index'); 
Route::get('/mlm/report/discount_card/use', 'Mlm\MlmDiscountCardController@use_discount'); 
Route::get('/mlm/report/discount_card/use/get/customer/{id}', 'Mlm\MlmDiscountCardController@get_customer_info'); 
Route::post('/mlm/report/discount_add/use/submit', 'Mlm\MlmDiscountCardController@submit_use_discount_card'); 
Route::post('/mlm/report/binary_promotions/request', 'Mlm\MlmReportController@request_binary_promotions'); 
/* End MLM MEMBER REPORTS */

/* MLM SLOTs */
Route::get('/mlm/slots', 'Mlm\MlmSlotsController@index'); 
Route::post('/mlm/slots/set_nickname', 'Mlm\MlmSlotsController@set_nickname'); 

/* MLM SLOTs REPORTS */