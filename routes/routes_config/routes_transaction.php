<?php
Route::group(array('prefix' => '/member/transaction'), function()
{
	/* PURCHASE ORDER V2 */
	AdvancedRoute::controller('/purchase_order', 'Member\TransactionPurchaseOrderController');

});