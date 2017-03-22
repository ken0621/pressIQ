<?php

Route::any('/member/instant_add_slot', 'Member\MLM_SlotController@instant_add_slot');

Route::any('/member/raymond', 'Member\RaymondController@index'); //RAYMOND

/* FRONTEND - SHIGUMA RIKA */
Route::get('/', 'Frontend\HomeController@index');
Route::get('/barcode', 'MemberController@barcodes');

// for testing only
// Route::get('/card', 'MemberController@card');
// Route::get('/card/all', 'MemberController@all_slot');

Route::get('member/register', 'MemberController@register');
Route::post('member/register/submit', 'MemberController@register_post');

Route::get('member/register/package', 'MemberController@package');
Route::post('member/register/package/submit', 'MemberController@package_post');

Route::get('member/register/payment', 'MemberController@payment');
Route::post('member/register/payment/submit', 'MemberController@payment_post');


Route::get('member/card', 'Member\MLM_CardController@card');
Route::get('member/card/all', 'Member\MLM_CardController@all_slot');

// end

Route::get('/pricing', 'Frontend\HomeController@pricing');
Route::get('/support', 'Frontend\HomeController@support');
/* END FRONTEND - SHIGUMA RIKA */

/* SHOP FRONTENT */
if(get_domain() == "c9users.io")
{
	$domain = "my168shop-primia.c9users.io"; //USE FOR TESTING
}
else
{
	$domain = get_domain();
}

Route::any("send","Member\EmailContentController@test");

/* CHECK IF LOOKING AT CLIENT PAGE */
include_once('routes_config/routes_digimahouse_domain.php');
/* MLM (REPORTS, GENEALOGY, VOUCHER) */
include_once('routes_config/routes_mlm.php');
/* END MLM (REPORTS, GENEALOGY, VOUCHER)

/* MEMBER - MANAGE PAGE */
include_once('routes_config/routes_member_manage_page.php');
/* END MEMBER - MANAGE PAGE */

/* MEMBER - MULTILEVEL MARKETING */
include_once('routes_config/routes_member_mlm.php');
/* END MEMBER - MULTILEVEL MARKETING */

/* MANAGE STORE INFORMATION */
Route::any("/member/page/store_information","Member\ManageStoreInformationController@index"); 
Route::any("/member/page/store_information/update_submit","Member\ManageStoreInformationController@update_submit");

/* MEMBER - DEVELOPER  */
Route::any('/member/developer/status', 'Member\Developer_StatusController@index'); //GUILLERMO TABLIGAN
Route::any('/member/developer/rematrix', 'Member\Developer_RematrixController@index'); //ERWIN GUEVARRA
Route::any('/member/developer/documentation', 'Member\Developer_DocumentationController@index'); //EVERYONE

Route::any('/member/developer/auto_entry', 'Member\Developer_AutoentryController@index'); //EVERYONE
Route::post('/member/developer/auto_entry/instant_add_slot', 'Member\Developer_AutoentryController@instant_add_slot'); //EVERYONE

Route::any('/member/developer/simulate', 'Member\Developer_RematrixController@simulate'); //EVERYONE
Route::any('/member/developer/simulate/submit', 'Member\Developer_RematrixController@simulate_submit'); //EVERYONE
/* END MEMBER - VENDOR - GUILLERMO TABLIGAN */

/* MEMBER - ACCOUNTING - CHART OF ACCOUNTS */
Route::get('/member/accounting/chart_of_account', 'Member\ChartOfAccountController@index');
Route::any('/member/accounting/chart_of_account/add', 'Member\ChartOfAccountController@add_account');
Route::any('/member/accounting/chart_of_account/update/{id}', 'Member\ChartOfAccountController@update_account');
Route::any('/member/accounting/chart_of_account/delete/{id}', 'Member\ChartOfAccountController@delete_account');
Route::any('/member/accounting/chart_of_account/popup/add', 'Member\ChartOfAccountController@load_add_account');
Route::any('/member/accounting/chart_of_account/popup/update/{id}', 'Member\ChartOfAccountController@load_update_account');
/* END ACCOUNTNG - CHART OF ACCOUNTS - BRYAN KIER ARADANAS */

/* API - Bryan Kier Aradanas */
Route::get('/api/{shop_id}/{shop_key}/product', 'Api\Api@product');
Route::get('/api/{shop_id}/{shop_key}/product/{product_id}', 'Api\Api@product_info');

Route::any('/login', 'Login\MemberLoginController@login');
Route::get('/logout', 'Login\MemberLoginController@logout');
Route::any('/register', 'Login\MemberLoginController@register');
Route::post('/createAccount', 'Frontend\HomeController@createAccount');

Route::group(array('prefix' => '/member/{page}/'), function()
{
	//order start
	Route::any('order','Member\OrderController@orders');
	Route::get('order/new_order','Member\OrderController@new_order');
	Route::post('order/new_order/create_customer','Member\OrderController@create_customer');
	Route::post('order/new_order/searchscustomer','Member\OrderController@searchscustomer');
	Route::any('order/new_order/customerinfo','Member\OrderController@customerinfo');
	Route::post('order/new_order/updateEmail','Member\OrderController@updateEmail');
	Route::post('order/new_order/updateShipping','Member\O/member/itemrderController@updateShipping');
	Route::post('order/new_order/itemlist','Member\OrderController@itemlist');
	Route::post('order/new_order/create_order','Member\OrderController@create_order');
	Route::post('order/new_order/removeitemorder','Member\OrderController@removeitemorder');
	Route::post('order/new_order/addIndiDiscount','Member\OrderController@addIndiDiscount');
	Route::post('order/new_order/chagequantity','Member\OrderController@chagequantity');
	Route::post('order/new_order/addMainDiscount','Member\OrderController@addMainDiscount');
	Route::post('order/new_order/applytax','Member\OrderController@applytax');
	Route::post('order/new_order/removecustomer','Member\OrderController@removecustomer');
	Route::post('order/new_order/addshipping','Member\OrderController@addshipping');
	Route::post('order/new_order/savetodraft','Member\OrderController@savetodraft');
	Route::post('order/new_order/OrderStatus','Member\OrderController@OrderStatus');
	
	//search for item start
	Route::post('search_item','Member\OrderController@search_item');
	//search for item end

	Route::get('order/{id}','Member\OrderListController@item');
	Route::post('order/addnote','Member\OrderListController@addnote');
	Route::post('order/refunditem','Member\OrderListController@refunditem');
	Route::post('order/recordrefund','Member\OrderListController@recordrefund');
	Route::post('order/updatepaystatus','Member\OrderListController@update_pay_status');
	Route::get('order/filter/{status}/{payment_stat}/{fulfillment_status}','Member\OrderController@get_orders_with_view');
	
	Route::get('orders/draft','Member\DraftController@index');
	Route::get('orders/draft/{id}','Member\DraftController@view_draft');
	Route::get('orders/abandoned','Member\CheckOutController@index');
	//order end
	
	//shipping start
	Route::get('shipping','Member\ShipInfoController@index');
	Route::post('shipping/create','Member\ShipInfoController@create');
	Route::post('shipping/load','Member\ShipInfoController@load');
	Route::get('shipping/remove','Member\ShipInfoController@remove');
	Route::post('shipping/update','Member\ShipInfoController@update');
	//shipping end

	//product order start
	Route::get('product_order','Member\ProductOrderController@invoice_list');
	Route::get('product_order/create_order','Member\ProductOrderController@index');
	Route::post('product_order/create_order/create_invoice','Member\ProductOrderController@create_invoice');
	Route::post('product_order/create_order/update_invoice','Member\ProductOrderController@update_invoice');
	Route::get('product_order/create_order/submit_coupon','Member\ProductOrderController@submit_coupon');
	//product order end
});


Route::get('/member', 'Member\DashboardController@index');
Route::post('/member/change_warehouse', 'Member\DashboardController@change_warehouse');
Route::any('/member/setup', 'Member\SetupController@index');
Route::any('/member/product/service_list', 'Member\Product_ServiceListController@index'); //GUILLERMO TABLGIAN
Route::any('/member/product/list', 'Member\ProductController@index');
Route::any('/member/product/add', 'Member\ProductController@add');
Route::post('/member/product/upload', 'Member\ProductController@upload');
Route::post('/member/product/delete_image', 'Member\ProductController@delete_image');
Route::any('/member/product/edit/{id}', 'Member\ProductController@edit');
Route::any('/member/product/edit/variant/{id}', 'Member\ProductController@edit_variant');
Route::post('/member/product/edit/variant/image/save_image', 'Member\ProductController@save_image_variant');
Route::get('/member/product/edit/variant/delete/{id}', 'Member\ProductController@delete_variant');

Route::get('/member/product/variant_item', 'Member\ProductController@get_variant_item_info'); //$ajax_get
Route::get('/member/product/variant_options', 'Member\ProductController@get_variant_options'); //$ajax_get

Route::post('/member/product/save_option_name', 'Member\ProductController@save_option_name'); //form
Route::post('/member/product/remove_option_value', 'Member\ProductController@remove_option_value');
Route::get('search','Member\ProductController@insertSearchTemp');

Route::any("/member/ecommerce/product/collection","Member\CollectionController@index");
Route::any("/member/ecommerce/product/collection_modal","Member\CollectionController@collection_modal");
Route::any("/member/ecommerce/product/collection/list","Member\CollectionController@collection_list");
Route::any("/member/ecommerce/product/collection/add_submit","Member\CollectionController@add_submit");
Route::any("/member/ecommerce/product/collection/edit_submit","Member\CollectionController@edit_submit");
Route::any("/member/ecommerce/product/collection/set_active","Member\CollectionController@set_active");
Route::any("/member/ecommerce/product/collection/archived/{id}/{action}","Member\CollectionController@archived");
Route::any("/member/ecommerce/product/collection/archived_submit","Member\CollectionController@archived_submit");

Route::any('/member/item', 'Member\ItemController@index'); /* ERWIN */  
Route::any('/member/item/add', 'Member\ItemController@add'); /* ERWIN */
Route::any('/member/item/load_all_um','Member\ItemController@load_all_um');
Route::any('/member/item/add_submit', 'Member\ItemController@add_submit'); /* ERWIN */
Route::any('/member/item/edit/{id}', 'Member\ItemController@edit'); /* ERWIN */
Route::any('/member/item/edit/show/mlm', 'Member\ItemController@show_mlm');
Route::any('/member/item/edit_submit', 'Member\ItemController@edit_submit'); /* ERWIN */
Route::any('/member/item/archive/{id}', 'Member\ItemController@archive'); /* ERWIN */
Route::any('/member/item/archive_submit', 'Member\ItemController@archive_submit'); /* ERWIN */
Route::any('/member/item/restore/{id}', 'Member\ItemController@restore'); /* B */
Route::any('/member/item/restore_submit', 'Member\ItemController@restore_submit'); /* B */
Route::any('/member/item/insert_saved_data', 'Member\ItemController@insert_session'); /* ERWIN */
Route::any('/member/item/data', 'Member\ItemController@data'); /* ERWIN */
Route::get('/member/item/mulitple_price_modal/{id}', 'Member\ItemController@get_multiple_price_modal'); /* B */
Route::post('/member/item/mulitple_price_modal', 'Member\ItemController@update_multiple_price_modal'); /* B */

Route::any("/member/item/view_serials/{id}","Member\ItemSerialController@index");
Route::any("/member/item/serial_number/{id}",'Member\ItemSerialController@view_serial');

Route::any('/member/functiontester', 'Member\FunctionTesterController@index'); /* ERWIN */
Route::any('/member/functiontester/clear_all', 'Member\FunctionTesterController@clear_all'); /* ERWIN */
Route::any('/member/functiontester/clear_one', 'Member\FunctionTesterController@clear_one'); /* ERWIN */
Route::any('/member/functiontester/get_cart', 'Member\FunctionTesterController@get_cart'); /* ERWIN */

/* MANAGE CATEGORIES */
Route::any('/member/item/category', 'Member\Manage_Category_Controller@index');
Route::any('/member/item/category/modal_create_category', 'Member\Manage_Category_Controller@modal_create_category');
Route::any('/member/item/category/edit_category/{id}', 'Member\Manage_Category_Controller@edit_category');
Route::any('/member/item/category/update_category', 'Member\Manage_Category_Controller@update_category');
Route::any('/member/item/category/archived/{id}/{action}','Member\Manage_Category_Controller@archived');
Route::any('/member/item/category/archived_submit','Member\Manage_Category_Controller@archived_submit');

Route::any('/member/item/category/create_category', 'Member\Manage_Category_Controller@create_category');
Route::any('/member/item/category/search_category', 'Member\Manage_Category_Controller@search_category');

/* START U/M ARCY*/
Route::any('/member/item/unit_of_measurement','Member\UnitOfMeasurementController@index');
Route::any('/member/item/unit_of_measurement/add','Member\UnitOfMeasurementController@add');
Route::any('/member/item/unit_of_measurement/add_submit','Member\UnitOfMeasurementController@add_submit');
Route::any('/member/item/unit_of_measurement/edit/{id}','Member\UnitOfMeasurementController@edit');
Route::any('/member/item/unit_of_measurement/edit_submit','Member\UnitOfMeasurementController@edit_submit');
Route::any('/member/item/um/select_type','Member\UnitOfMeasurementController@select_type');
/* END U/M ARCY*/

/* START AUDIT TRAIL*/
Route::any('/member/utilities/audit','Member\AuditTrailController@index');
/* END AUDIT TRAIL*/

/* START CLIENT INFO*/
Route::any('/member/utilities/client_list','Member\UtilitiesClientController@index');
Route::any('/member/utilities/client/update/{id}','Member\UtilitiesClientController@update');
Route::any('/member/utilities/client/update_submit','Member\UtilitiesClientController@update_submit');
/*END CLIENT INFO*/


/* START TRUCK ARCY*/
Route::any('/member/pis/truck_list','Member\TruckController@index');
Route::any('/member/pis/truck_list/add','Member\TruckController@add');
Route::any('/member/pis/truck_list/add_submit','Member\TruckController@add_submit');
Route::any('/member/pis/truck_list/edit/{id}','Member\TruckController@edit');
Route::any('/member/pis/truck_list/edit_submit','Member\TruckController@edit_submit');
Route::any('/member/pis/truck_list/archived/{id}/{action}','Member\TruckController@archived');
Route::any('/member/pis/truck_list/archived_submit','Member\TruckController@archived_submit');
/* END TRUCK ARCY*/


/* START EMPLOYEE POSITION*/
Route::any('/member/pis/agent_position','Member\AgentPositionController@index');
Route::any('/member/pis/agent/position/add','Member\AgentPositionController@add');
Route::any('/member/pis/agent/position/add_submit','Member\AgentPositionController@add_submit');
Route::any('/member/pis/agent/position/edit/{id}','Member\AgentPositionController@edit');
Route::any('/member/pis/agent/position/edit_submit','Member\AgentPositionController@edit_submit');
Route::any('/member/pis/agent/position/archived/{id}/{action}','Member\AgentPositionController@archived');
Route::any('/member/pis/agent/position/archived_submit','Member\AgentPositionController@archived_submit');
/* END EMPLOYEE POSITION*/


/* START EMPLOYEE*/
Route::any('/member/pis/agent_list','Member\AgentController@index');
Route::any('/member/pis/agent/add','Member\AgentController@add');
Route::any('/member/pis/agent/add_submit','Member\AgentController@add_submit');
Route::any('/member/pis/agent/edit/{id}','Member\AgentController@edit');
Route::any('/member/pis/agent/edit_submit','Member\AgentController@edit_submit');
Route::any('/member/pis/agent/archived/{id}/{action}','Member\AgentController@archived');
Route::any('/member/pis/agent/archived_submit','Member\AgentController@archived_submit');
/* END EMPLOYEE*/

/* START U/M TYPES ARCY*/
Route::any('/member/item/um_type','Member\UnitMeasurementTypeController@index');
Route::any('/member/item/um_type/add','Member\UnitMeasurementTypeController@add');
Route::any('/member/item/um_type/add_submit','Member\UnitMeasurementTypeController@add_submit');
Route::any('/member/item/um_type/edit/{id}','Member\UnitMeasurementTypeController@edit');
Route::any('/member/item/um_type/edit_submit','Member\UnitMeasurementTypeController@edit_submit');

Route::any('/member/item/select_um','Member\UnitOfMeasurementController@select_um');
/* END U/M TYPES ARCY*/


/* WAREHOUSE ARCY*/
Route::any('/member/item/warehouse', 'Member\WarehouseController@index');
Route::any('/member/item/inventory_log/{id}','Member\WarehouseController@inventory_log');
Route::any('/member/item/warehouse/add', 'Member\WarehouseController@add');
Route::any('/member/item/warehouse/edit/{id}', 'Member\WarehouseController@edit');
Route::any('/member/item/warehouse/edit_submit', 'Member\WarehouseController@edit_submit');
Route::any('/member/item/transferinventory','Member\WarehouseController@transferinventory');
Route::any('/member/item/warehouse/transfer_inventory_submit','Member\WarehouseController@transferinventory_submit');
Route::post('/member/item/warehouse/transfer_submit','Member\WarehouseController@transfer_submit');
Route::any('/member/item/warehouse/archived/{id}','Member\WarehouseController@archived');
Route::any('/member/item/warehouse/archive_submit','Member\WarehouseController@archived_submit');
Route::any('/member/item/warehouse/view/{id}','Member\WarehouseController@view');
Route::any('/member/item/warehouse/refill','Member\WarehouseController@refill');
Route::any('/member/item/warehouse/refill_submit','Member\WarehouseController@refill_submit');

Route::any('/member/item/warehouse/load_item','Member\WarehouseController@filter_item');

Route::any('/member/item/warehouse/restore/{id}','Member\WarehouseController@restore');
Route::any('/member/item/warehouse/restore_submit','Member\WarehouseController@restore_submit');
Route::any('/member/item/warehouse/load_warehouse','Member\WarehouseController@load_warehouse');

Route::any('/member/item/warehouse/add_submit','Member\WarehouseController@add_submit');
Route::any('/member/item/warehouse/select_item','Member\WarehouseController@select_item');
Route::any('/member/warehouse/load_item','Member\WarehouseController@load_item');

Route::any('/member/item/add_serial','Member\WarehouseController@add_serial_number');
Route::any('/member/item/add_serial_number_submit','Member\WarehouseController@add_serial_number_submit');

Route::any('/member/item/confirm_serial','Member\WarehouseController@confirm_serial');
Route::any('/member/item/confirm_serial_submit','Member\WarehouseController@confirm_serial_submit');

/* END WAREHOUSE ARCY*/

/* START PIS ARCY*/
Route::any('/member/pis/sir/view_status/{id}','Member\PurchasingInventorySystemController@view_status');

Route::any('/member/pis/sir','Member\PurchasingInventorySystemController@sir');
Route::any('/member/pis/sir/archived_submit','Member\PurchasingInventorySystemController@archived_sir_submit');
Route::any('/member/pis/sir/create','Member\PurchasingInventorySystemController@create_sir');
Route::any('/member/pis/sir/create_submit','Member\PurchasingInventorySystemController@create_sir_submit');
Route::any('/member/pis/sir/view/{id}/{type}','Member\PurchasingInventorySystemController@view');
Route::any('/member/pis/sir/view_pdf/{id}/{type_code}','Member\PurchasingInventorySystemController@view_pdf');
Route::any('/member/pis/sir/edit/{id}','Member\PurchasingInventorySystemController@edit_sir');
Route::any('/member/pis/sir/edit_submit','Member\PurchasingInventorySystemController@edit_sir_submit');

Route::any('/member/pis/ilr/update_count_submit','Member\PurchasingInventorySystemController@update_count_submit');
Route::any('/member/pis/ilr/update_count/{sir_id}/{item_id}','Member\PurchasingInventorySystemController@update_count');
//lof
Route::any('/member/pis/lof','Member\PurchasingInventorySystemController@lof');
Route::any('/member/pis/lof/archived_submit','Member\PurchasingInventorySystemController@archived_sir_submit');
Route::any('/member/pis/lof/create','Member\PurchasingInventorySystemController@create_sir');
Route::any('/member/pis/lof/create_submit','Member\PurchasingInventorySystemController@create_sir_submit');
Route::any('/member/pis/lof/edit/{id}','Member\PurchasingInventorySystemController@edit_sir');
Route::any('/member/pis/lof/edit_submit','Member\PurchasingInventorySystemController@edit_sir_submit');
//syncs
Route::any('/member/pis/sir/sync_import','Member\PurchasingInventorySystemController@sync_import');
Route::any('/member/pis/sir/sync_export','Member\PurchasingInventorySystemController@sync_export');
Route::any('/member/pis/sir/confirm_sync/{action}','Member\PurchasingInventorySystemController@confirm_syncing');

Route::any('/member/pis/ilr','Member\PurchasingInventorySystemController@load_ilr');
Route::any('/member/pis/ilr/ilr_submit','Member\PurchasingInventorySystemController@ilr_submit');
Route::any('/member/pis/ilr/{id}','Member\PurchasingInventorySystemController@ilr');
Route::any('/member/pis/sir/{id}/{action}','Member\PurchasingInventorySystemController@archived_sir');
Route::any('/member/pis/sir/open/{id}/{action}','Member\PurchasingInventorySystemController@open_sir');
Route::any('/member/pis/ilr/ilr_confirm/{id}/{action}','Member\PurchasingInventorySystemController@ilr_confirm');
Route::any('/member/pis/ilr/view/{id}','Member\PurchasingInventorySystemController@ilr_view');
Route::any('/member/pis/ilr/view_pdf/{id}','Member\PurchasingInventorySystemController@ilr_pdf');

//Manual Invoicing
Route::any('/member/pis/manual_invoice','Member\ManualInvoiceController@index');
Route::any('/member/pis/manual_invoice/add/{id}','Member\ManualInvoiceController@manual_invoice_add');
Route::any('/member/pis/manual_invoice/add_submit','Member\ManualInvoiceController@manual_invoice_add_submit');
Route::any('/member/customer/invoice/manual_invoice_update',"Member\ManualInvoiceController@manual_invoice_edit_submit");

Route::any('/member/pis/view_invoices/{id}','Member\ManualInvoiceController@view_invoices');
/* END PIS ARCY*/

Route::any('/tablet/pis/sir/review/{id}',"Member\TabletPISController@review_sir");
Route::any('/tablet/pis/sir/{id}/{action}',"Member\TabletPISController@lof_action");
Route::any('/tablet/pis/sir/lof_action_submit',"Member\TabletPISController@lof_action_submit");
Route::any('/tablet/selected_sir',"Member\TabletPISController@selected_sir");

/* END PIS TABLEt*/
Route::any('/tablet','Member\TabletPISController@login');
Route::any('/tablet/login_submit','Member\TabletPISController@login_submit');
Route::any('/tablet/dashboard','Member\TabletPISController@index');
Route::any('/tablet/sync_import',"Member\TabletPISController@sync_import");
Route::any('/tablet/sync_export','Member\TabletPISController@sync_export');
Route::any('/tablet/logout','Member\TabletPISController@logout');
Route::any('/tablet/sir_inventory/{id}','Member\TabletPISController@inventory_sir');

Route::any('/tablet/customer',"Member\TabletPISController@customer");
Route::any('/tablet/customer_details/{id}',"Member\TabletPISController@customer_details");

Route::any('/tablet/invoice','Member\TabletPISController@invoice');
Route::any('/tablet/view_invoices/{id}','Member\TabletPISController@view_invoices');
Route::any('/tablet/create_invoices/add','Member\TabletPISController@tablet_create_invoice');
Route::any('/tablet/create_invoice/add_submit','Member\TabletPISController@create_invoice_submit');
Route::any('/tablet/update_invoice/edit_submit',"Member\TabletPISController@update_invoice_submit");

Route::any('/tablet/receive_payment','Member\TabletPISController@receive_payment');
Route::any('/tablet/view_receive_payment/{id}','Member\TabletPISController@view_receive_payment');
Route::any('/tablet/receive_payment/add','Member\TabletPISController@tablet_receive_payment');
Route::any('/tablet/receive_payment/add_submit','Member\TabletPISController@add_receive_payment');
Route::any('/tablet/receive_payment/update/{id}','Member\TabletPISController@update_receive_payment');

Route::any('/tablet/view_invoice_view/{id}','Member\TabletPISController@view_invoices_view');
Route::any('/tablet/view_invoice_pdf/{id}','Member\TabletPISController@view_invoice_pdf');

Route::any('/tablet/submit_all_transaction','Member\TabletPISController@confirm_submission');
Route::any('/tablet/submit_all_transaction/submit','Member\TabletPISController@submit_transactions');
/* END PIS TABLEt*/

 //form

//member
// Route::any('/member/order','Orders\OrdersController@orders');
// Route::get('/member/order/new_order','Orders\OrdersController@new_order');
// Route::post('/member/order/new_order/create_customer','Orders\OrdersController@create_customer');
// Route::post('/member/order/new_order/searchscustomer','Orders\OrdersController@searchscustomer');
// Route::any('/member/order/new_order/customerinfo','Orders\OrdersController@customerinfo');
// Route::post('/member/order/new_order/updateEmail','Orders\OrdersController@updateEmail');
// Route::post('/member/order/new_order/updateShipping','Orders\OrdersController@updateShipping');
// Route::post('/member/order/new_order/itemlist','Orders\OrdersController@itemlist');
// Route::post('/member/order/new_order/create_order','Orders\OrdersController@create_order');
// Route::post('/member/order/new_order/removeitemorder','Orders\OrdersController@removeitemorder');
// Route::post('/member/order/new_order/addIndiDiscount','Orders\OrdersController@addIndiDiscount');
// Route::post('/member/order/new_order/chagequantity','Orders\OrdersController@chagequantity');
// Route::post('/member/order/new_order/addMainDiscount','Orders\OrdersController@addMainDiscount');
// Route::post('/member/order/new_order/applytax','Orders\OrdersController@applytax');
// Route::post('/member/order/new_order/removecustomer','Orders\OrdersController@removecustomer');
// Route::post('/member/order/new_order/addshipping','Orders\OrdersController@addshipping');
// Route::post('/member/order/new_order/savetodraft','Orders\OrdersController@savetodraft');
// Route::post('/member/order/new_order/OrderStatus','Orders\OrdersController@OrderStatus');

// Route::get('/member/order/{id}','Orders\OrderListController@item');
Route::post('/member/order/addnote','Orders\OrderListController@addnote');
Route::post('/member/order/refunditem','Orders\OrderListController@refunditem');
Route::post('/member/order/recordrefund','Orders\OrderListController@recordrefund');

Route::get('/member/orders/draft','Orders\DraftController@index');
Route::get('/member/orders/abandoned','Orders\CheckOuts@index');

Route::get('/member/info','Store\StoreInfoController@storeInfo');
Route::post('/member/info/storeDescription','Store\StoreInfoController@storeDescription');
Route::get('/member/info/edit/{id}','Store\StoreInfoController@edit');
Route::post('/member/info/update','Store\StoreInfoController@update');
Route::get('/member/info/remove/{id}','Store\StoreInfoController@remove');

//contact start
Route::get('/member/contact','Store\StoreInfoController@contactInfo');
Route::post('/member/contact/craeteContact','Store\StoreInfoController@craeteContact');
//contact end

Route::any('/member/customer/invoice_list','Member\Customer_InvoiceController@invoice_list');
Route::get('/member/customer/invoice','Member\Customer_InvoiceController@index');
Route::any('/member/customer/invoice/error/{id}', 'Member\Customer_InvoiceController@error_inv_no');
Route::post('/member/customer/invoice/create','Member\Customer_InvoiceController@create_invoice');
Route::post('/member/customer/invoice/update','Member\Customer_InvoiceController@update_invoice');
Route::any('/member/customer/customer_invoice_view/{id}','Member\Customer_InvoiceController@invoice_view');
Route::any('/member/customer/customer_invoice_pdf/{id}','Member\Customer_InvoiceController@invoice_view_pdf');

Route::get('/member/customer/product_repurchase','Member\MLM_ProductRepurchaseController@index');//ERWIN
Route::post('/member/customer/product_repurchase/submit','Member\MLM_ProductRepurchaseController@submit');//ERWIN
Route::get('/member/customer/product_repurchase/get_product_code/{id}','Member\MLM_ProductRepurchaseController@get_code');//ERWIN
Route::get('/member/customer/product_repurchase/get_slot/{id}','Member\MLM_ProductRepurchaseController@get_slot');//ERWIN
Route::get('/member/customer/product_repurchase/get_slot_v_membership_code/{membership_code}','Member\MLM_ProductRepurchaseController@get_membership_code');//ERWIN
Route::get('/member/customer/product_repurchase/get_product_code/info/{id}','Member\MLM_ProductRepurchaseController@get_code_info');

Route::get('/member/about','Member\StoreInfoController@storeInfo');
Route::post('/member/about/storeDescription','Member\StoreInfoController@storeDescription');
Route::get('/member/about/edit/{id}','Member\StoreInfoController@edit');
Route::post('/member/about/update','Member\StoreInfoController@update');
Route::get('/member/about/remove/{id}','Member\StoreInfoController@remove');

//arcy
//-sales-receipt start
Route::get('/member/customer/sales_receipt','Member\Customer_SaleReceiptController@index');
Route::get('/member/customer/estimate','Member\Customer_EstimateController@index');
Route::any('/member/customer/credit_memo','Member\CreditMemoController@index');

/* Customer - Receive Payment */
Route::get('/member/customer/receive_payment','Member\Customer_ReceivePaymentController@index');
Route::get('/member/customer/load_rp/{id}','Member\Customer_ReceivePaymentController@load_customer_rp');
Route::post('/member/customer/receive_payment/add','Member\Customer_ReceivePaymentController@add_receive_payment');
Route::post('/member/customer/receive_payment/update/{id}','Member\Customer_ReceivePaymentController@update_receive_payment');


/* CUSTOMER CREDIT MEMO*/
Route::any('/member/customer/credit_memo','Member\CreditMemoController@index');
Route::any('/member/customer/credit_memo/list',"Member\CreditMemoController@cm_list");
Route::any('/member/customer/credit_memo/create_submit','Member\CreditMemoController@create_submit');
Route::any('/member/customer/credit_memo/update',"Member\CreditMemoController@update_submit");



/* Vendor - Purchase Order */
Route::get('/member/vendor/purchase_order','Member\Vendor_PurchaseOrderController@index');
Route::get('/member/vendor/purchase_order/list','Member\Vendor_PurchaseOrderController@po_list');
Route::any('/member/vendor/purchase_order/create_po','Member\Vendor_PurchaseOrderController@create_po');
Route::any('/member/vendor/purchase_order/update_po','Member\Vendor_PurchaseOrderController@upate_po');

Route::get('/member/vendor/create_bill','Member\Vendor_CreateBillController@index');
Route::any('/member/vendor/load_purchase_order/{id}','Member\Vendor_CreateBillController@load_purchase_order');
Route::any('/member/vendor/create_bill/add','Member\Vendor_CreateBillController@add_bill');
Route::any('/member/vendor/create_bill/update','Member\Vendor_CreateBillController@update_bill');
Route::any('/member/vendor/load_po_item','Member\Vendor_CreateBillController@load_po_item');

Route::get('/member/vendor/write_check','Member\Vendor_WriteCheckController@index');

/*Manufacturer*/
Route::any('/member/item/manufacturer','Member\ManufacturerController@manufacturer_list');
Route::any('/member/item/manufacturer/add','Member\ManufacturerController@index');
Route::any('/member/item/manufacturer/add_submit','Member\ManufacturerController@add_submit');
Route::any('/member/item/manufacturer/edit_submit','Member\ManufacturerController@edit_submit');
Route::any('/member/item/manufacturer/archived/{id}/{action}','Member\ManufacturerController@archived');
Route::any('/member/item/manufacturer/archived_submit','Member\ManufacturerController@archived_submit');

/* MAINTENACE */
Route::any('/member/maintenance/payment_method','Member\MaintenancePaymentMethodController@index');
Route::any('/member/maintenance/payment_method/add','Member\MaintenancePaymentMethodController@add');
Route::any('/member/maintenance/payment_method/add_submit','Member\MaintenancePaymentMethodController@add_submit');
Route::any('/member/maintenance/payment_method/edit_submit','Member\MaintenancePaymentMethodController@edit_submit');
Route::any('/member/maintenance/payment_method/archived/{id}/{action}','Member\MaintenancePaymentMethodController@archived');
Route::any('/member/maintenance/payment_method/archived_submit','Member\MaintenancePaymentMethodController@archived_submit');
Route::any('/member/maintenance/payment_method/update','Member\MaintenancePaymentMethodController@update_default');


Route::any('/member/maintenance/email_content','Member\EmailContentController@index');
Route::any('/member/maintenance/email_content/add','Member\EmailContentController@add');
Route::any('/member/maintenance/email_content/add_submit','Member\EmailContentController@add_submit');
Route::any('/member/maintenance/email_content/edit_submit','Member\EmailContentController@edit_submit');
Route::any('/member/maintenance/email_content/archived/{id}/{action}','Member\EmailContentController@archived');
Route::any('/member/maintenance/email_content/archived_submit','Member\EmailContentController@archived_submit');

Route::any('/member/maintenance/email_header_footer',"Member\EmailHeaderFooterController@index");
Route::any('/member/maintenance/email_header_footer/update/{type}',"Member\EmailHeaderFooterController@update");
Route::any('/member/maintenance/email_header_footer/update_submit',"Member\EmailHeaderFooterController@update_submit");
//contact start
Route::get('/member/contact','Member\StoreInfoController@contactInfo');
Route::post('/member/contact/createContact','Member\StoreInfoController@createContact');
Route::post('/member/contact/loadContact','Member\StoreInfoController@loadContact');
Route::get('/member/contact/remContact/{id}','Member\StoreInfoController@remContact');
Route::post('/member/contact/updateContact','Member\StoreInfoController@updateContact');
Route::post('/member/contact/displaycontact','Member\StoreInfoController@displaycontact');
//contact end

//location start
Route::post('/member/contact/createLocation','Member\StoreInfoController@createLocation');
Route::post('/member/contact/loadlocation','Member\StoreInfoController@loadlocation');
Route::get('/member/contact/removeLocation/{id}','Member\StoreInfoController@removeLocation');
Route::post('/member/contact/updateLocation','Member\StoreInfoController@updateLocation');
Route::post('/member/contact/setPrimary','Member\StoreInfoController@setPrimary');
//location end

//inventory start
Route::get('/member/product/inventory','Member\InventoryController@index');
Route::post('/member/product/inventory/updatquantity','Member\InventoryController@updatquantity');
Route::post('/member/product/inventory/filter','Member\InventoryController@filter');
//inventory end


//collectio start
Route::get('/member/product/collection','Member\ProductController@collections');
Route::post('/member/product/collection/collectionvisibility','Member\ProductController@collectionvisibility');
Route::get('/member/product/collection/edit/{id}','Member\ProductController@editcollection');
Route::post('/member/product/collection/update','Member\ProductController@updatecollection');
Route::post('/member/product/collection/updateitemCOllection','Member\ProductController@updateitemCOllection');
Route::get('/member/product/createcollection','Member\ProductController@createcollection');
Route::post('/member/product/additemcollection','Member\ProductController@additemcollection');
Route::post('/member/product/collectionitemvisibility','Member\ProductController@collectionitemvisibility');
Route::post('/member/product/removeitemcollection','Member\ProductController@removeitemcollection');
Route::post('/member/product/saveCollection','Member\ProductController@saveCollection');
//collection end


//ecommerce setting start
Route::group(array('prefix' => '/member/ecommerce/settings'), function()
{
	Route::get('','Member\EcommerceSettingController@setting');
	Route::get('/paypalsetting','Member\EcommerceSettingController@paypalsetting');
	Route::get('/banksetting','Member\EcommerceSettingController@banksetting');
	Route::get('/remittancesetting','Member\EcommerceSettingController@remittancesetting');
	Route::get('/cashondeliverysetting','Member\EcommerceSettingController@cashondeliverysetting');
	
	Route::any('/create_banking','Member\EcommerceSettingController@create_banking');
	Route::post('/insert_banking','Member\EcommerceSettingController@insert_banking');
	Route::get('/loadBankdata/{id}','Member\EcommerceSettingController@loadBankdata');
	Route::post('/updateBank','Member\EcommerceSettingController@updateBank');
	Route::get('/archive_warning_bank/{id}','Member\EcommerceSettingController@archive_warning_bank');
	Route::post('/archivedbank','Member\EcommerceSettingController@archivedbank');
	Route::get('/restore_warning_bank/{id}','Member\EcommerceSettingController@restore_warning_bank');
	Route::post('/restorebank','Member\EcommerceSettingController@restorebank');
	
	Route::any('/create_remittance','Member\EcommerceSettingController@create_remittance');
	Route::post('/insertremittance','Member\EcommerceSettingController@insertremittance');
	Route::get('/loadRemittancedata/{id}','Member\EcommerceSettingController@loadRemittancedata');
	Route::post('/updateremittance','Member\EcommerceSettingController@updateremittance');
	Route::get('/archive_warning_remittance/{id}','Member\EcommerceSettingController@archive_warning_remittance');
	Route::post('/archiveremittance','Member\EcommerceSettingController@archiveremittance');
	Route::get('/restore_warning_remittance/{id}','Member\EcommerceSettingController@restore_warning_remittance');
	Route::post('/restoreremittance','Member\EcommerceSettingController@restoreremittance');
	
	Route::post('/paypalsetting/updatepaypal','Member\EcommerceSettingController@updatepaypal');
	Route::post('/banksetting/settingupdate','Member\EcommerceSettingController@settingupdate');
});

//ecommerce setting end


Route::group(array('prefix' => '/member/report'), function()
{
	Route::get('','Member\ReportsController@index');
	
	/* SALE */
	Route::get('/sale/month','Member\ReportsController@monthlysale');
	Route::get('/sale/product_variant','Member\ReportsController@variantProduct');
	Route::get('/sale/product','Member\ReportsController@saleProduct');
	Route::get('/sale/customer','Member\ReportsController@saleCustomer');
	Route::get('/sale/customerOverTime','Member\ReportsController@customerOverTime');
	Route::post('/sale/ajax/monthlysale','Member\ReportsController@monthlysaleAjax');
	Route::post('/sale/ajax/by/{name}','Member\ReportsController@saleByAjax');
	Route::post('/sale/customerOverTime/ajax','Member\ReportsController@customerOTajax');
	Route::get('/sale/pdf/{name}/{start}/{end}','Member\ReportsController@pdfreport');
});
//reports end

/* Customer */
Route::get('/member/customer','Customer\CustomerController@index');
Route::get('/member/customer/list','Member\CustomerController@index');
Route::any('/member/customer/modalcreatecustomer','Member\CustomerController@modalcreatecustomer');
Route::post('/member/customer/insertcustomer','Member\CustomerController@insertcustomer');
Route::post('/member/customer/editcustomer','Member\CustomerController@editcustomer');
Route::post('/member/customer/updatecustomer','Member\CustomerController@updatecustomer');
Route::post('/member/customer/createpaymentmethod','Member\CustomerController@createpaymentmethod');
Route::post('/member/customer/createterms','Member\CustomerController@createterms');
Route::post('/member/customer/createcustomer','Member\CustomerController@createcustomer');
Route::post('/member/customer/uploadcustomerfile','Member\CustomerController@uploadcustomerfile');
Route::post('/member/customer/removefilecustomer','Member\CustomerController@removefilecustomer');
Route::any('/member/customer/customeredit/{id}','Member\CustomerController@customeredit');
Route::post('/member/customer/updatecustomermain','Member\CustomerController@updatecustomermain');
Route::get('/member/customer/downloadfile/{id}','Member\CustomerController@downloadfile');
Route::any('/member/customer/loadcustomer','Member\CustomerController@loadcustomer');
Route::post('/member/customer/inactivecustomer','Member\CustomerController@inactivecustomer');
Route::get('/member/customer/details/{id}','Member\CustomerController@view_customer_details');


/* API v1*/
Route::group(array('prefix' => 'api/{auth}/{store}'), function()
{
	Route::get('products', 'ApiController@products');
	Route::get('products/{id}', 'ApiController@product_id');
	Route::get('products/{id}/variants', 'ApiController@products_id_variants');
	Route::get('products/{id}/related', 'ApiController@products_id_related');
	Route::get('variants', 'ApiController@variants');
	Route::get('category', 'ApiController@category');
	Route::get('filter/products/{column}/{value}', 'ApiController@filter_products');

	Route::post('user/create','ApiController@create_user');
	Route::post('user/login','ApiController@login_user');
	Route::post('user/info','ApiController@user_info');
	Route::post('user/getShoppingHistory','ApiController@getShoppingHistory');
	Route::post('user/SpecificHistory','ApiController@SpecificHistory');
	Route::post('user/update/{id}','ApiController@user_update_id');
	
	Route::get('country','ApiController@country');
	Route::post('payment','ApiController@payment');
	Route::get('contact','ApiController@contact');
	Route::get('location','ApiController@location');
	Route::get('about','ApiController@about');
	Route::get('shipping','ApiController@shipping');
	Route::get('paymentsetting','ApiController@paymentsetting');
});

Route::group(['middleware' => ['web']], function () {

    Route::get('payPremium', ['as'=>'payPremium','uses'=>'PaypalController@payPremium']);

    Route::post('getCheckout', ['as'=>'getCheckout','uses'=>'PaypalController@getCheckout']);

    Route::get('getDone', ['as'=>'getDone','uses'=>'PaypalController@getDone']);

    Route::get('getCancel', ['as'=>'getCancel','uses'=>'PaypalController@getCancel']);

});

Route::get('/testing','Member\MLM_CodeController@tester');

/* ImageController */
Route::post('image/image_upload','Member\ImageController@upload_image');
Route::get('image/load_media_library', 'Member\ImageController@load_media_library');

/* Load Ajax Data */
Route::get('/member/accounting/load_coa','Member\ChartOfAccountController@load_coa');
Route::get('/member/customer/load_customer','Member\CustomerController@load_customer');
Route::get('/member/item/load_item','Member\ItemController@load_item');
Route::get('/member/item/load_item_category','Member\ItemController@load_item_category');
Route::get('/member/ecommerce/load_product_category','Member\EcommerceProductController@load_product_category');
Route::get('/member/item/load_um','Member\UnitOfMeasurementController@load_um');
Route::get('/member/item/load_one_um/{id}','Member\UnitOfMeasurementController@load_one_um');
Route::get('/member/item/load_category','Member\Manage_Category_Controller@load_category');
Route::get('/member/item/manufacturer/load_manufacturer','Member\ManufacturerController@load_manufacturer');
Route::get('/member/maintenance/load_payment_method','Member\MaintenancePaymentMethodController@load_payment_method');
Route::get('/member/maintenance/load_payment_gateway/{id}','Member\OnlinePaymentMethodController@load_payment_gateway');

/* SettingsController */
Route::get('/member/settings/{key}', 'Member\SettingsController@index');
Route::post('/member/settings/verify/add', 'Member\SettingsController@verify');
Route::get('/member/settings/get/{key}', 'Member\SettingsController@get_settings');
Route::get('/member/settings/setup/initial', 'Member\SettingsController@initial_setup');
/* End SettingsController */

/* USER / UTILITIES*/
Route::controller('/member/utilities', 'Member\UtilitiesController');
/* End */
/* ECOMMERCE PRODUCT */
Route::controller('/member/ecommerce/product', 'Member\EcommerceProductController');
/* End */
/* VENDOR */
Route::controller('/member/vendor', 'Member\VendorController');
/* End */
/* ONLINE PAYMENT METHOD */
Route::controller('/member/maintenance/online_payment', 'Member\OnlinePaymentMethodController');
/* End */


Route::controller('/tester','TesterController');

// test lang load
Route::any("/member/load_position","Member\EmployeePositionController@load_position");


/* PAYROLL START */


// Route::group(array('prefix' => '/member/payroll'), function()
// {

// 	/* COMPANY START */
// 	Route::any('/company_list','Member\PayrollController@company_list');
// 	Route::any('/company_list/modal_create_company','Member\PayrollController@modal_create_company');
// 	Route::any('/company_list/upload_company_logo','Member\PayrollController@upload_company_logo');
// 	Route::any('/company_list/modal_save_company','Member\PayrollController@modal_save_company');
// 	Route::any('/company_list/view_company_modal/{id}','Member\PayrollController@view_company_modal');
// 	Route::any('/company_list/edit_company_modal/{id}','Member\PayrollController@edit_company_modal');
// 	Route::any('/company_list/reload_company','Member\PayrollController@reload_company');
// 	Route::any('/company_list/archived_company','Member\PayrollController@archived_company');
// 	Route::any('/company_list/update_company','Member\PayrollController@update_company');
// 	/* COMPANY END */


// 	/* EMPLOYEE START */
// 	Route::any('/employee_list','Member\PayrollController@employee_list');
// 	Route::any('/employee_list/modal_create_employee','Member\PayrollController@modal_create_employee');

// 	/* EMPLOYEE END */

// 	Route::any('/payroll_configuration','Member\PayrollController@payroll_configuration');

// 	Route::any('/employee_timesheet','Member\PayrollTimesheetController@index');


// 	/* DEPARTMENT START */
// 	Route::any('/departmentlist','Member\PayrollController@department_list');
// 	Route::any('/departmentlist/department_modal_create','Member\PayrollController@department_modal_create');
// 	Route::any('/departmentlist/department_save','Member\PayrollController@department_save');
// 	Route::any('/departmentlist/archived_department','Member\PayrollController@archived_department');
// 	Route::any('/departmentlist/department_reload','Member\PayrollController@department_reload');
// 	Route::any('/departmentlist/modal_view_department/{id}','Member\PayrollController@modal_view_department');
// 	Route::any('/departmentlist/modal_edit_department/{id}','Member\PayrollController@modal_edit_department');
// 	Route::any('/departmentlist/modal_update_department','Member\PayrollController@modal_update_department');
// 	/* DEPARTMENT END */

// 	/* JOB TITLE START */
// 	Route::any("/jobtitlelist","Member\PayrollController@jobtitle_list");
// 	Route::any("/jobtitlelist/modal_create_jobtitle","Member\PayrollController@modal_create_jobtitle");
// 	Route::any("/jobtitlelist/modal_save_jobtitle","Member\PayrollController@modal_save_jobtitle");
// 	Route::any("/jobtitlelist/reload_tbl_jobtitle","Member\PayrollController@reload_tbl_jobtitle");
// 	Route::any("/jobtitlelist/modal_view_jobtitle/{id}","Member\PayrollController@modal_view_jobtitle");
// 	Route::any("/jobtitlelist/modal_edit_jobtitle/{id}","Member\PayrollController@modal_edit_jobtitle");
// 	Route::any("/jobtitlelist/archived_jobtitle","Member\PayrollController@archived_jobtitle");
// 	Route::any("/jobtitlelist/modal_update_jobtitle","Member\PayrollController@modal_update_jobtitle");
// 	/* JOB TITLE END */
// });

include_once('routes_config/routes_payroll.php');

/* PAYROLL END */