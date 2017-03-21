<?php
Route::get('/mlm/membership_active_code/{pin}', 'Mlm\MlmLoginController@membership_active_code'); //EDWARD GUEVARRA
Route::post('/mlm/membership_active_code/active/code', 'Mlm\MlmLoginController@membership_active_code_post'); //EDWARD GUEVARRA
Route::get('/mlm/login', 'Mlm\MlmLoginController@index'); //EDWARD GUEVARRA
Route::post('/mlm/login', 'Mlm\MlmLoginController@post_login'); //EDWARD GUEVARRA

Route::get('/mlm/register', 'Mlm\MlmRegisterController@index'); //EDWARD GUEVARRA
Route::get('/mlm/register/package', 'Mlm\MlmRegisterController@package'); //EDWARD GUEVARRA
Route::get('/mlm/register/payment', 'Mlm\MlmRegisterController@payment'); //EDWARD GUEVARRA
Route::post('/mlm/register', 'Mlm\MlmRegisterController@post_register'); //EDWARD GUEVARRA

Route::get('/mlm/register/get/membership_code/{membership_code}', 'Mlm\MlmRegisterController@view_customer_info_via_mem_code');

Route::get('/mlm', 'Mlm\MlmDashboardController@index'); //EDWARD GUEVARRA
Route::get('/mlm/profile', 'Mlm\MlmProfileController@index'); //EDWARD GUEVARRA
Route::get('/mlm/notification', 'Mlm\MlmNotificationController@index'); //EDWARD GUEVARRA
Route::any('/mlm/claim/slot', 'Mlm\MlmDashboardController@claim_slot'); //EDWARD GUEVARRA

Route::any('/mlm/network/binary', 'Mlm\MlmNetworkController@binary'); //EDWARD GUEVARRA
Route::any('/mlm/network/unilevel', 'Mlm\MlmNetworkController@unilevel'); //EDWARD GUEVARRA
//
Route::any('/mlm/profile/edit/password', 'Mlm\MlmProfileController@password'); //EDWARD GUEVARRA
Route::any('/mlm/profile/edit/contact', 'Mlm\MlmProfileController@contact');
Route::any('/mlm/profile/edit/basic', 'Mlm\MlmProfileController@basic');
Route::any('/mlm/profile/edit/picture', 'Mlm\MlmProfileController@profile_picture_upload');
Route::any('/mlm/profile/edit/encashment', 'Mlm\MlmProfileController@update_encashment');
//
Route::get('/mlm/repurchase', 'Mlm\MlmRepurchaseController@index'); //EDWARD GUEVARRA

Route::any('/mlm/repurchase/add/cart', 'Mlm\MlmRepurchaseController@add_to_cart'); //EDWARD GUEVARRA
Route::any('/mlm/repurchase/get/cart', 'Mlm\MlmRepurchaseController@get_cart_repurchase'); //EDWARD GUEVARRA
Route::any('/mlm/repurchase/remove/cart', 'Mlm\MlmRepurchaseController@remove_from_cart_repurchase'); //EDWARD GUEVARRA
Route::any('/mlm/repurchase/cart/checkout', 'Mlm\MlmRepurchaseController@cart_checkout'); //EDWARD GUEVARRA

Route::get('/mlm/vouchers', 'Mlm\MlmVouchersController@index'); //EDWARD GUEVARRA
Route::get('/mlm/cheque', 'Mlm\MlmChequeController@index'); //EDWARD GUEVARRA
Route::any('/mlm/changeslot', 'Mlm\Mlm@changeslot');

Route::get('/mlm/cheque', 'Mlm\MlmChequeController@index'); //EDWARD GUEVARRA
Route::get('/mlm/wallet', 'Mlm\MlmTransferController@index'); //EDWARD GUEVARRA
Route::get('/mlm/refill', 'Mlm\MlmTransferController@refill'); //EDWARD GUEVARRA
Route::get('/mlm/refill/request', 'Mlm\MlmTransferController@request_refill'); //EDWARD GUEVARRA
Route::any('/mlm/refill/request/submit', 'Mlm\MlmTransferController@request_refill_post'); //EDWARD GUEVARRA
Route::get('/mlm/transfer', 'Mlm\MlmTransferController@transfer'); //EDWARD GUEVARRA
Route::post('/mlm/transfer/submit', 'Mlm\MlmTransferController@transfer_submit'); //EDWARD GUEVARRA
Route::get('/mlm/transfer/get/customer/{id}', 'Mlm\MlmTransferController@transfer_get_customer'); //EDWARD GUEVARRA
Route::get('/mlm/encashment', 'Mlm\MlmTransferController@encashment'); //EDWARD GUEVARRA
Route::post('/mlm/encashment/request', 'Mlm\MlmTransferController@encashment_request'); //EDWARD GUEVARRA
Route::any('/mlm/encashment/view/breakdown/{encashment_process}/{slot_id}', 'Mlm\MlmTransferController@breakdown_slot');//luke
/* MLM VOUCHERS */
Route::get('/mlm/vouchers', 'Mlm\MlmVouchersController@index'); //EDWARD GUEVARRA
Route::get('/mlm/vouchers/view_voucher', 'Mlm\MlmVouchersController@view_voucher'); //EDWARD GUEVARRA
Route::get('/mlm/gc', 'Mlm\MlmVouchersController@gc'); //EDWARD GUEVARRA

/* MLM GENEALOGY */
Route::get('/mlm/genealogy/{tree}', 'Mlm\MlmGenealogyController@index'); //EDWARD GUEVARRA
Route::any('/mlm/slot/genealogy', 'Mlm\MlmGenealogyController@tree');
Route::any('/mlm/slot/genealogy/downline', 'Mlm\MlmGenealogyController@downline');
/* MLM GENEALOGY REPORTS */

/* MLM MEMBER REPORTS */
Route::get('/mlm/report/{complan}', 'Mlm\MlmReportController@index'); //EDWARD GUEVARRA
Route::get('/mlm/report/discount_card/use', 'Mlm\MlmDiscountCardController@use_discount'); //EDWARD GUEVARRA
Route::get('/mlm/report/discount_card/use/get/customer/{id}', 'Mlm\MlmDiscountCardController@get_customer_info'); 
Route::post('/mlm/report/discount_add/use/submit', 'Mlm\MlmDiscountCardController@submit_use_discount_card'); 
/* End MLM MEMBER REPORTS */

/* MLM SLOTs */
Route::get('/mlm/slots', 'Mlm\MlmSlotsController@index'); 
Route::post('/mlm/slots/set_nickname', 'Mlm\MlmSlotsController@set_nickname'); 
/* MLM SLOTs REPORTS */