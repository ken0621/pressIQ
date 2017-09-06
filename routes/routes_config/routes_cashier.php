<?php
Route::group(array('prefix' => '/member/cashier'), function()
{
	Route::any('/pos','Member\CashierController@pos');
	Route::any('/pos/table_item','Member\CashierController@pos_table_item');
	Route::post('/pos/search_item','Member\CashierController@pos_search_item');
	Route::post('/pos/scan_item','Member\CashierController@pos_scan_item');
	Route::any('/pos/remove_item','Member\CashierController@pos_remove_item');
	Route::any('/pos/set_cart_info/{key}/{value}','Member\CashierController@set_cart_info');
});