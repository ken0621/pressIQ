<?php
Route::group(array('prefix' => '/member/cashier'), function()
{
	Route::any('/pos','Member\CashierController@pos');
	Route::any('/pos/table_item','Member\CashierController@pos_table_item');
	Route::post('/pos/search_item','Member\CashierController@pos_search_item');
});