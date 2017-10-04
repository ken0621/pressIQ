<?php
Route::group(array('prefix' => '/member/cashier'), function()
{
	Route::any('/pos','Member\CashierController@pos');
	Route::any('/pos/table_item','Member\CashierController@pos_table_item');
	Route::post('/pos/search_item','Member\CashierController@pos_search_item');
	Route::post('/pos/scan_item','Member\CashierController@pos_scan_item');
	Route::any('/pos/remove_item','Member\CashierController@pos_remove_item');
	Route::any('/pos/set_cart_info/{key}/{value}','Member\CashierController@set_cart_info');
	Route::any('/transactions','Member\TransactionController@index');
	Route::any('/transactions/view_list/{transaction_id}','Member\TransactionController@view_list');
	Route::any('/transactions/view_item/{transaction_list_id}','Member\TransactionController@view_item');
	
	Route::any('/transactions_list','Member\TransactionController@transaction_list');
	Route::any('/transactions_list/table','Member\TransactionController@transaction_list_table');
	Route::any('/transactions_list/view/{id}','Member\TransactionController@view_pdf');

	Route::any('/transactions_list/payref', 'Member\TransactionController@payref');
});