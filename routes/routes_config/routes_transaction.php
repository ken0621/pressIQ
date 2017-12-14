<?php
Route::group(array('prefix' => '/member/transaction'), function()
{
	/* Purchase Order */
	AdvancedRoute::controller('/purchase_order', 'Member\TransactionPurchaseOrderController');
	/* Receive Inventory */
	AdvancedRoute::controller('/receive_inventory', 'Member\TransactionReceiveInventoryController');
	/* Receive Inventory With Bill */
	AdvancedRoute::controller('/receive_inventory_with_bill', 'Member\TransactionReceiveInventoryWithBillController');
	/* 	Pay Bills */
	AdvancedRoute::controller('/pay_bills', 'Member\TransactionPayBIllsController');
	/* 	Write Check */
	AdvancedRoute::controller('/write_check', 'Member\TransactionWriteCheckController');
	/* 	Debit Memo */
	AdvancedRoute::controller('/debit_memo', 'Member\TransactionDebitMemoController');
	/* 	Import */
	AdvancedRoute::controller('/import', 'Member\TransactionVendorImportController');


	/* <-- CUSTOMER TRANSACTION --> */

	/* Estimate and Quotation */
	AdvancedRoute::controller('/estimate_quotation', 'Member\TransactionEstimateQuotationController');
	/* Sales Order */
	AdvancedRoute::controller('/sales_order', 'Member\TransactionSalesOrderController');
	/* Sales Invoice */
	AdvancedRoute::controller('/sales_invoice', 'Member\TransactionSalesInvoiceController');
	/* Sales Receipt */
	AdvancedRoute::controller('/sales_receipt', 'Member\TransactionSalesReceiptController');
	/* Receive Payment */
	AdvancedRoute::controller('/receive_payment', 'Member\TransactionReceivePaymentController');
	/* Credit Memo */
	AdvancedRoute::controller('/credit_memo', 'Member\TransactionCreditMemoController');
});