<?php
Route::group(array('prefix' => '/member/transaction'), function()
{





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