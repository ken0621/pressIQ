<?php

function page_list()
{
    $path = '/member/';

    $page = "dashboard";
    $nav[$page]['name']        = "Dashboard";
    $nav[$page]['segment']      = $page;
    $nav[$page]['icon']         = "home";
    $nav[$page]['url']          = $path;
    $nav[$page]['user_settings'] = [];
    $nav[$page]['status']       = "Working 100% - Not Tested Yet";
    $nav[$page]['developer']    = ">";
    
    /* TRANSACTION */
    // $page = "transaction_list";  
    // $nav[$page]['name'] = "Transaction";
    // $nav[$page]['segment'] = $page;
    // $nav[$page]['icon'] = "refresh";
    /* -- TRANSACTION => CREATE INVOICE */
    // $code = "transaction-invoice-list";
    // $nav[$page]['submenu'][$code]['label'] = "Customer Invoice";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = "$path" . "customer" . "/invoice_list";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Refer to Customer -> Create Invoices";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    // /* -- TRANSACTION => RECEIVE PAYMENT */
    // $code = "transaction-receive-payment";
    // $nav[$page]['submenu'][$code]['label'] = "Receive Payment";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . "customer" . "/receive_payment";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Refer to Customer -> Receive Payment";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    // /* -- TRANSACTION => CREATE SALES RECEIPT */
    // $code = "transaction-sales-receipt";
    // $nav[$page]['submenu'][$code]['label'] = "Create Sales Receipt";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . "customer" . "/sales_receipt";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Refer to Customer -> Sales Receipt";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    // /* -- TRANSACTION => CREDIT MEMO */
    // $code = "transaction-credit-memo-list";
    // $nav[$page]['submenu'][$code]['label'] = "Credit Memo";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . "customer" . "/credit_memo/list";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Refer to Customer -> Credit Memo";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    // $code = "transaction-product-repurchase";
    // $nav[$page]['submenu'][$code]['label'] = "Product Repurchase";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = "/member/customer/product_repurchase";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    // $nav[$page]['submenu'][$code]['developer'] = "Erwin Guevara";

    /* E-COMMERCE */
    $page = "ecommerce";  
    $nav[$page]['name'] = "E-Commerce";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "shopping-cart";
    $nav[$page]['type']     = "menu";
    
    /* -- E-COMMERCE => PRODUCT ORDERS */
    $code = "ecommerce-product-order";
    $nav[$page]['submenu'][$code]['label'] = "Product Orders";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/product_order";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "90% Working";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Erwin Guevara</span>";    

    /* -- E-COMMERCE => WEBSITE ORDERS */
    // $code = "ecommerce-order-list";
    // $nav[$page]['submenu'][$code]['label'] = "Website Orders";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/order";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "90% Working";
    // $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Jimar Zape</span>";

    /* -- PRODUCTS => PRODUCT LIST */
    $code = "product-list";
    $nav[$page]['submenu'][$code]['label'] = "Product List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/product/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add','edit'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- PRODUCTS => PRODUCT COLLECTION */
    $code = "product-collection";
    $nav[$page]['submenu'][$code]['label'] = "Collection";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/product/collection/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- PRODUCTS => PRODUCT CODE */
    $code = "product-wishlist";
    $nav[$page]['submenu'][$code]['label'] = "Wishlist";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/wishlist/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Edward Guevarra</span>";

    /* -- PRODUCTS => PRODUCT CODE */
    $code = "product-coupon";
    $nav[$page]['submenu'][$code]['label'] = "Coupon Code";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/coupon/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- PRODUCTS => PRODUCT SHIPMENT STATUS */
    $code = "product-trackings";
    $nav[$page]['submenu'][$code]['label'] = "Trackings";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/trackings";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";


    
    /* -- E-COMMERCE => SHIPPING */
    // $code = "ecommerce-shipping";
    // $nav[$page]['submenu'][$code]['label'] = "Shipping";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/shipping";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Working - Need Revision - Add Product Dimension";
    // $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Jimar Zape</span>";
    
    /* -- E-COMMERCE => SETTING */
    // $code = "ecommerce-settings";
    // $nav[$page]['submenu'][$code]['label'] = "Payment Settings";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/settings";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Working 90%";
    // $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Jimar Zape</span>";
    
    /* MLM */
    $page = "mlm";  
    $nav[$page]['name'] = "Loyalty Reward System";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "braille";
    $nav[$page]['type']     = "menu";
    
    /* -- MLM => MEMBERSHIP */
    $code = "mlm-membership";
    $nav[$page]['submenu'][$code]['label'] = "Membership";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/membership";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','create_new_membership','edit_membership', 'delete_membership'];
    $nav[$page]['submenu'][$code]['status'] = "Working 100% - Not Tested Yet";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Luke Glenn Jordan</span>";

    /* -- MLM => MEMBERSHIP CODES */
    $code = "mlm-membership-codes";
    $nav[$page]['submenu'][$code]['label'] = "Membership Codes";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/code";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page', 'view_receipt', 'sell_codes'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Luke Glenn Jordan</span>";

    /* -- MLM => MEMBERSHIP CODES */
    $code = "mlm-membership-claim-voucher";
    $nav[$page]['submenu'][$code]['label'] = "Claim Voucher";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/claim_voucher";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page', 'claim'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Erwin Guevarra</span>";

    /* -- MLM => SLOTS */
    $code = "mlm-slots";
    $nav[$page]['submenu'][$code]['label'] = "Customer Slots";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/slot";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Luke Glenn Jordan</span>";
    
    /* -- MLM => MARKETING PLAN */
    $code = "mlm-plan";
    $nav[$page]['submenu'][$code]['label'] = "Marketing Plan";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/plan";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page', 'configure_plan'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (50%)";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Luke Glenn Jordan</span>";
    
    $code = "mlm-product-points";
    $nav[$page]['submenu'][$code]['label'] = "Product Points";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/product";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Luke Glenn Jordan";   

    $code = "mlm-product-discount";
    $nav[$page]['submenu'][$code]['label'] = "Product Discount";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/product/discount";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Luke Glenn Jordan";   

    $code = "mlm-product-code";
    $nav[$page]['submenu'][$code]['label'] = "Product Code";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/product_code";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page', 'product_code_reciept', 'product_code_sell_codes'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Erwin Guevara";

    $code = "mlm-wallet-refill";
    $nav[$page]['submenu'][$code]['label'] = "E-Wallet";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/wallet";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page', 'wallet_refill', 'wallet_adjust', 'wallet_transfer'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Luke Glenn Jordan";

    $code = "mlm-wallet-encashment";
    $nav[$page]['submenu'][$code]['label'] = "Encashment";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/encashment";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Luke Glenn Jordan";

    $code = "mlm-report";
    $nav[$page]['submenu'][$code]['label'] = "Report";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/report";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Luke Glenn Jordan";

    $code = "mlm-slot-card";
    $nav[$page]['submenu'][$code]['label'] = "Slot Cards";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/card";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Luke Glenn Jordan";

    $code = "mlm-stairstep-compute";
    $nav[$page]['submenu'][$code]['label'] = "Distribute Stairstep";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/stairstep_compute";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Erwin Guevarra";


    $code = "mlm-complan-setup";
    $nav[$page]['submenu'][$code]['label'] = "Other Settings";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/complan_setup";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    $nav[$page]['submenu'][$code]['developer'] = "Erwin Guevarra";
    // $code = "mlm-product-repurchase-points";
    // $nav[$page]['submenu'][$code]['label'] = "Product Repurchase";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/product/repurchase/points";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Layout (0%)";
    // $nav[$page]['submenu'][$code]['developer'] = "Erwin Guevara";
    
    /* ACCOUNTING*/
    $page = "accounting"; 
    $nav[$page]['name'] = "Accounting";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "money";
    $nav[$page]['type']     = "menu";
   
    /* -- ACCOUNTING => SALES */
    // $code = "accounting-sales";
    // $nav[$page]['submenu'][$code]['label'] = "Sales";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/chart_of_account";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
   
    /* -- ACCOUNTING => EXPENSES */
    // $code = "accounting-expenses";
    // $nav[$page]['submenu'][$code]['label'] = "Expenses";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/chart_of_account";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";   

    /* -- ACCOUNTING => JOURNAL ENTRY */
    $code = "accounting-journal";
    $nav[$page]['submenu'][$code]['label'] = "Journal Entry";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/journal/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>"; 
    
    /* -- ACCOUNTING => CHART OF ACCOUNTS */
    $code = "accounting-settings";
    $nav[$page]['submenu'][$code]['label'] = "Chart of Accounts";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/chart_of_account";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Working 100% - Not Tested Yet";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- ACCOUNTING => SETTINGS */
    // $code = "accounting-chart-of-accounts";
    // $nav[$page]['submenu'][$code]['label'] = "Settings";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/settings";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No Progress Yett";
    // $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- ACCOUNTING => IMPORT */
    $code = "accounting-import-list";
    $nav[$page]['submenu'][$code]['label'] = "Import";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/import/coa";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Working";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* PAYROLL */
    $page = "payroll";  
    $nav[$page]['name'] = "Payroll";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "calculator";
    $nav[$page]['type']     = "menu";

    /* -- EMPLOYEE POSITION=> LIST  */
    $code = "employee-list";
    $nav[$page]['submenu'][$code]['label'] = "Employee List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/employee_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";



    /* PAYROLL TIME KEEPING */
    $code = "payroll-timekeeping";
    $nav[$page]['submenu'][$code]['label'] = "Time Keeping";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/time_keeping";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";
    


    // /* PAYROLL SUMMARY */
    // $code = "payroll-summary";
    // $nav[$page]['submenu'][$code]['label'] = "Payroll Summary";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_summary";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- EMPLOYEE=> LIST  */
    $code = "company-list";
    $nav[$page]['submenu'][$code]['label'] = "Company List";

    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/company_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";




    // /* PAYROLL SUMMARY */
    // $code = "payroll-summary";
    // $nav[$page]['submenu'][$code]['label'] = "Payroll Summary";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_summary";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- EMPLOYEE=> LIST  */
    $code = "company-list";
    $nav[$page]['submenu'][$code]['label'] = "Company List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/company_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";

    /* -- EMPLOYEE POSITION=> LIST  */
    $code = "employee-list";
    $nav[$page]['submenu'][$code]['label'] = "Employee List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/employee_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";

    /* -- PAYROLL PERIOD => LIST  */
    $code = "payroll-period";
    $nav[$page]['submenu'][$code]['label'] = "Payroll Period";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_period_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";

    /* -- PAYROLL PERIOD => LIST  */
    // $code = "payroll-shift-group";
    // $nav[$page]['submenu'][$code]['label'] = "Shifting Group";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/shift_group";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";

    /* PAYROLL CONFIGURATION [SETTTINGS] */
    $code = "payroll-configuration";
    $nav[$page]['submenu'][$code]['label'] = "Payroll Configuration";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_configuration";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','Branch_Location','Department','Job_Title','Holiday','Holiday_Default','Allowances','Deductions','Leave','Payroll_Group', 'Shift_Template','Journal_Tags','Payslip','Tax_Period','Tax_Table','SSS_Table','Philhealth_Table','Pagibig/HDMF'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";
    
    /* -- EMPLOYEE TIMESHEET=> LIST  */
    // $code = "employee-timesheet";
    // $nav[$page]['submenu'][$code]['label'] = "Employee Timesheet";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/employee_timesheet";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "Guillermo Tabligan";

    /* PAYROLL CALENDAR LEAVE */
    $code = "payroll-calendar-leave";
    $nav[$page]['submenu'][$code]['label'] = "Leave Scheduling";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/leave_schedule";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";




    /* PAYROLL PROCESS */
    $code = "payroll-process";
    $nav[$page]['submenu'][$code]['label'] = "Payroll Processing";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_process";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";

    /* PAYROLL REGISTER */
    $code = "payroll-register";
    $nav[$page]['submenu'][$code]['label'] = "Payroll Registered";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_register";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";

    /* PAYROLL POST */
    $code = "payroll-post";
    $nav[$page]['submenu'][$code]['label'] = "Payroll Posted";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_post";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";


    /* PAYROLL APPROVED */
    $code = "payroll-approved";
    $nav[$page]['submenu'][$code]['label'] = "Payroll Approved";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_approved_view";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";

    /* PAYROLL REPORTS */
    $code = "payroll-reports";
    $nav[$page]['submenu'][$code]['label'] = "Payroll Reports";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payroll_reports";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "Jimar Zape";


    /* PRODUCT */
    // $page = "product";  
    // $nav[$page]['name'] = "Products & Services";
    // $nav[$page]['segment'] = $page;
    // $nav[$page]['icon'] = "list-alt";

    /* -- PRODUCTS => INVENTORY */
    // $code = "product-inventory";
    // $nav[$page]['submenu'][$code]['label'] = "Product Inventory";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/inventory";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Working 100% - Not Tested Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";
   
    /* -- PRODUCTS => SERVICE LIST */
    // $code = "product-service";
    // $nav[$page]['submenu'][$code]['label'] = "Service List";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/service_list";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
   
    /* -- PRODUCTS => INVENTORY */
    // $code = "product-collection";
    // $nav[$page]['submenu'][$code]['label'] = "Collections";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/collection";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    /* -- PRODUCTS => INVENTORY */
    // $code = "product-bundle";
    // $nav[$page]['submenu'][$code]['label'] = "Bundles";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page . "/collection";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    /* ITEM  ERWIN */
    $page = "item";  
    $nav[$page]['name'] = "Items";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "cart-plus";
    $nav[$page]['type']     = "menu";
    
    /* -- ITEM => ITEM LIST  */
    $code = "item-list";
    $nav[$page]['submenu'][$code]['label'] = "Item List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Erwin</span>";

    /* -- ITEM => ITEM CATEGORIES  */
    $code = "item-categories";
    $nav[$page]['submenu'][$code]['label'] = "Category";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/category";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";


     /* -- ITEM => UNIT OF MEASUREMENTS  */
    $code = "item-pis-unit-measurement";
    $nav[$page]['submenu'][$code]['label'] = "Unit of Measurements (P.I.S)";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/pis_unit_of_measurement";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

     /* -- ITEM => UNIT OF MEASUREMENTS  */
    $code = "item-unit-measurement";
    $nav[$page]['submenu'][$code]['label'] = "Unit of Measurements";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/unit_of_measurement";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

      /* -- ITEM => UNIT OF MEASUREMENTS TYPES */
    $code = "item-um-type";
    $nav[$page]['submenu'][$code]['label'] = "U/M Types";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/um_type";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- ITEM => WAREHOUSE  */
    $code = "item-warehouse";
    $nav[$page]['submenu'][$code]['label'] = "Warehouse";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/warehouse";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add','edit','transfer','refill','adjust','add-serial','archived','restore'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- ITEM => INVENTORY LOGS  */
    $code = "item-inventory-log";
    $nav[$page]['submenu'][$code]['label'] = "Inventory Logs";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/inventory_log";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- ITEM => WAREHOUSE  */
    $code = "item-manufacturer";
    $nav[$page]['submenu'][$code]['label'] = "Manufacturer";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/manufacturer";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- ITEM => IMPORT  */
    $code = "item-import";
    $nav[$page]['submenu'][$code]['label'] = "Import";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/import/item";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Still developing";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";
    

    /* VENDORS */
    $page = "vendor";  
    $nav[$page]['name'] = "Vendors";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "user-secret";
    $nav[$page]['type']     = "menu";
    
    /* -- VENDORS => LIST  */
    $code = "vendor-list";
    $nav[$page]['submenu'][$code]['label'] = "Vendor List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add','edit'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";
    
    /* -- VENDORS => PURCHASE ORDER  */
    $code = "vendor-purchase-order";
    $nav[$page]['submenu'][$code]['label'] = "Purchase Order <span class='blink-ctr ctr-span hidden po-count pull-right'></span>";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/purchase_order/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    /* -- VENDORS => RECEIVE INVENTORY  */
    $code = "vendor-receive-inventory";
    $nav[$page]['submenu'][$code]['label'] = "Receive Inventory";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/receive_inventory/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    /* -- VENDORS => PAY BILLS  */
    $code = "vendor-bill";
    $nav[$page]['submenu'][$code]['label'] = "Receive Inventory w/ Bill";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/bill_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- VENDORS => PAY BILLS  */
    $code = "vendor-pay-bills";
    $nav[$page]['submenu'][$code]['label'] = "Pay Bills <span class='blink-ctr ctr-span hidden bill-count pull-right'></span>";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/paybill/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- VENDORS => CHECK  */
    $code = "vendor-check";
    $nav[$page]['submenu'][$code]['label'] = "Write Check";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/write_check/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    /* -- VENDORS => BAD ORDERS  */
    $code = "vendor-debit-memo";
    $nav[$page]['submenu'][$code]['label'] = "Debit Memo";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/debit_memo/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- VENDORS => IMPORT  */
    $code = "vendor-import-list";
    $nav[$page]['submenu'][$code]['label'] = "Import";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . "/vendors" . "/import/vendor";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* CUSTOMERS */
    $page = "customer";  
    $nav[$page]['name'] = "Customers";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "group";
    $nav[$page]['type']     = "menu";
    
    /* -- CUSTOMERS => CUSTOMER LIST  */
    $code = "customer-list";
    $nav[$page]['submenu'][$code]['label'] = "Customer List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add','edit'];
    $nav[$page]['submenu'][$code]['status'] = "Working 90% - Need Search and Edit Customer Information";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Jimar Zape</span>";
    
    /* -- CUSTOMERS => CREATE ESTIMATE  */
    $code = "customer-estimate";
    $nav[$page]['submenu'][$code]['label'] = "Create Estimate";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/estimate_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Arcylen Gutierrez</span>";

    /* -- CUSTOMERS => CREATE SALES ORDER  */
    $code = "customer-sales-order";
    $nav[$page]['submenu'][$code]['label'] = "Sales Order";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/sales_order_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Arcylen Gutierrez</span>";

    /* -- CUSTOMERS => CUSTOMER INVOICE  */
    $code = "customer-invoice";
    $nav[$page]['submenu'][$code]['label'] = "Create Invoice <span class='blink-ctr ctr-span hidden inv-count pull-right'></span>";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/invoice_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Done";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";
    
    /* -- CUSTOMERS => CUSTOMER RECEIVE PAYMENT  */
    $code = "customer-receive-payment";
    $nav[$page]['submenu'][$code]['label'] = "Receive Payment";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/receive_payment";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Done";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";
    
    /* -- CUSTOMERS => CUSTOMER RECEIVE PAYMENT  */
    $code = "customer-sales-receipt";
    $nav[$page]['submenu'][$code]['label'] = "Sales Receipt";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/sales_receipt/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- CUSTOMERS => CREDIT MEMO */
    $code = "customer-credit-memo-list";
    $nav[$page]['submenu'][$code]['label'] = "Credit Memo";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . "customer" . "/credit_memo/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Refer to Customer -> Credit Memo";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- CUSTOMERS => IMPORT */
    $code = "customer-import-list";
    $nav[$page]['submenu'][$code]['label'] = "Import";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . "customer" . "/import/customer";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    
        /* PURCHASING INVENTORY SYSTEM */
    $page = "pis";
    $nav[$page]['name']     = "PIS";
    $nav[$page]['segment']  = $page;
    $nav[$page]['icon']     = "truck";
    $nav[$page]['type']     = "menu";

        $segment = "submenu-sales-delivery";
        $nav[$page]['submenu'][$segment]['name']   = "Sales & Delivery";
        $nav[$page]['submenu'][$segment]['segment']= $segment;
        $nav[$page]['submenu'][$segment]['type']   = "submenu";

             /* -- PIS => SIR */
            $code = "pis-lof";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Load Out Form <span class='blink-ctr ctr-span hidden lof-count pull-right'></span>";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
            $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/lof";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page','edit','add','archived','open-sir','sync'];
            $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "No Progress Yet";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "No Developer Yet";

             /* -- PIS ['submenu'][$segment]=> SIR */
            $code = "pis-sir";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Stock Issuance Report <span class='blink-ctr ctr-span hidden sir-count pull-right'></span>";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
            $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/sir";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page','edit','add','archived','open-sir','sync'];
            $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "No Progress Yet";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "No Developer Yet";

             /* -- PIS ['submenu'][$segment]=> ILR */
            $code = "pis-ilr";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Incoming Load Report <span class='blink-ctr ctr-span hidden ilr-count pull-right'></span>";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
            $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/ilr";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page','processed-ilr'];
            $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "No Progress Yet";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "No Developer Yet";

    // /* -- PIS => Manual Invoicing */
    // $code = "pis-manual-invoicing";
    // $nav[$page]['submenu'][$code]['label'] = "Manual Invoicing";
    // $nav[$page]['submenu'][$code]['code'] = $code;
    // $nav[$page]['submenu'][$code]['url'] = $path . $page ."/manual_invoice";
    // $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    // $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    // $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

        $segment = "submenu-cashier";
        $nav[$page]['submenu'][$segment]['name']   = "Cashier";
        $nav[$page]['submenu'][$segment]['segment']= $segment;
        $nav[$page]['submenu'][$segment]['type']   = "submenu";

            $code = "agent-collectiong";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Collection <span class='blink-ctr ctr-span hidden col-count pull-right'></span>";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
            $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . "cashier/collection";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
            $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "No Progress Yet";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "No Developer Yet";

            $code = "pis-agent";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Agent List";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
            $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . "cashier/agent_list";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page','add','edit','archived'];
            $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "No progress Yet";  
            $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "No Developer Yet";

            $code = "pis-sales-liquidation";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Sales Liquidation";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
            $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path ."cashier/sales_liquidation";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
            $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "No progress Yet";
            $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- PIS => SIR */
    $code = "tablet-sir";
    $nav[$page]['submenu'][$code]['label'] = "Login Tablet";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = "/tablet";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','create-invoice'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";


    /* REPORTS  */
    $page = "report"; 
    $nav[$page]['name']     = "Reports";
    $nav[$page]['segment']  = $page;
    $nav[$page]['icon']     = "area-chart";
    $nav[$page]['type']     = "menu";


    /* -- REPORT => ECOMMERCE SUBMENU */
    $segment = "submenu-ecommerce";
    $nav[$page]['submenu'][$segment]['name']   = "Ecommerce";
    $nav[$page]['submenu'][$segment]['segment']= $segment;
    $nav[$page]['submenu'][$segment]['type']   = "submenu";

        /* -- REPORT => PRODUCTS  */
        $code = "report-product-sales";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label']       = "Product Sales";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code']        = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url']         = $path . $page . "/sale/product";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status']      = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer']   = "Everyone";

        /* -- REPORT => MONTHLY PRODUCT  */
        $code = "report-product-sales-monthly";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label']       = "Product Sales Monthly";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code']        = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url']         = $path . $page . "/sale/month";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status']      = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer']   = "Everyone";

        /* -- REPORT => PRODUCTS VARIANT  */
        $code = "report-product-variant-sales";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label']        = "Product Variant Sales";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code']         = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url']          = $path . $page . "/sale/product_variant";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status']        = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer']     = "Everyone";

        // $segment2 = "submenu-SampleSubMenu2";
        // $nav[$page]['submenu'][$segment]['submenu'][$segment2]['name']   = "SampleSubMenu2";
        // $nav[$page]['submenu'][$segment]['submenu'][$segment2]['segment']= $segment2;
        // $nav[$page]['submenu'][$segment]['submenu'][$segment2]['type']   = "submenu";

        //     $segment3 = "submenu-SampleSubMenu3";
        //     $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['name']   = "SampleSubMenu3";
        //     $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['segment']= $segment3;
        //     $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['type']   = "submenu";

        //         $code = "report-sasafsdfsdf";
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['label']        = "SamplePage1";
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['code']         = $code;
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['url']          = '';
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['user_settings'] = ['access_page'];
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['status']        = "Developing";
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['developer']     = "Everyone";

        //         $code = "reportdfgdfgf";
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['label']        = "SamplePage2";
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['code']         = $code;
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['url']          = '';
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['user_settings'] = ['access_page'];
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['status']        = "Developing";
        //         $nav[$page]['submenu'][$segment]['submenu'][$segment2]['submenu'][$segment3]['submenu'][$code]['developer']     = "Everyone";

    /* -- REPORT => ACCOUNTING SUBMENU */
    $segment = "submenu-accounting";
    $nav[$page]['submenu'][$segment]['name']   = "Accounting"; 
    $nav[$page]['submenu'][$segment]['segment']= $segment;
    $nav[$page]['submenu'][$segment]['type']   = "submenu";

        /* -- Accounting => Sales Report  */
        $code = "report-sales-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Sales By Customer";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/sale";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Everyone";

        $code = "report-sales-item-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Sales By Item";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/sale/item";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Everyone";

        $code = "report-sales-item-warehouse";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Sales By Warehouse";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/sale_by_warehouse";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Luke Glenn Jordan";

        $code = "report-profit-and-loss-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Profit and Loss";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/profit_loss";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Everyone";


        $code = "report-general-ledger-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "General Ledger";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/general/ledger";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Everyone";

        $code = "report-customer-list-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Customer List";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/customer_list";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Bryan Kier Aradanas";

        $code = "report-vendor-list-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Vendor List";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/vendor_list";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Bryan Kier Aradanas";

        $code = "report-item-list-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Item List";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/item_list";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Bryan Kier Aradanas";

        $code = "report-account-list-account";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['label'] = "Account List";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['code'] = $code;
        $nav[$page]['submenu'][$segment]['submenu'][$code]['url'] = $path . $page . "/accounting/account_list";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['user_settings'] = ['access_page'];
        $nav[$page]['submenu'][$segment]['submenu'][$code]['status'] = "Developing";
        $nav[$page]['submenu'][$segment]['submenu'][$code]['developer'] = "Bryan Kier Aradanas";

    /* -- REPORT => AGENT TRANSACTIONS */
    $code = "report-agent-transaction";
    $nav[$page]['submenu'][$code]['label'] = "Agent Profit & Loss";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/agent/profit_loss";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Developing";
    $nav[$page]['submenu'][$code]['developer'] = "ARCY";

    
    /* MANAGE CONTENT  */
    $page = "page"; 
    $nav[$page]['name'] = "Manage Pages";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "star";
    $nav[$page]['type']     = "menu";
    
    /* -- MANAGE CONTENT => PAGE INFORMATION */
    $code = "page-theme";
    $nav[$page]['submenu'][$code]['label'] = "Themes";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/themes";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page', 'activate_theme'];
    $nav[$page]['submenu'][$code]['status'] = "Layout Only";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Guillermo Tabligan</span>";

    $code = "page-post";
    $nav[$page]['submenu'][$code]['label'] = "Posts";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/post";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add_post', 'edit_post', 'archive_post'];
    $nav[$page]['submenu'][$code]['status'] = "Working 100%";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Edward Guevarra</span>";
    
    $code = "page-list";
    $nav[$page]['submenu'][$code]['label'] = "Page Information";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/content";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Guillermo Tabligan</span>";
    
    /* -- MANAGE CONTENT => CONTACT INFORMATION */
    $code = "page-contact";
    $nav[$page]['submenu'][$code]['label'] = "Contact Information";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/contact";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- MANAGE CONTENT => STORE INFORMATION */
    $code = "page-store-information";
    $nav[$page]['submenu'][$code]['label'] = "Store Information";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/store_information";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* UTILITIES  */
    $page = "utilities"; 
    $nav[$page]['name'] = "Utilities";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "gear";
    $nav[$page]['type']     = "menu";

    /* -- UTILITIES => AdminN ACCOUNTS */
    $code = "utilities-admin-accounts";
    $nav[$page]['submenu'][$code]['label'] = "Admin Accounts";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/admin-list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add','edit'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    /* -- UTILITIES => ADMIN POSITIONS */
    $code = "utilities-admin-positions";
    $nav[$page]['submenu'][$code]['label'] = "Admin Positions";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/position";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add/edit'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";
    
    /* -- UTILITIES => AUDIT TRAIL */
    $code = "utilities-audit";
    $nav[$page]['submenu'][$code]['label'] = "Audit Trail";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/audit";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";
    
    /* -- UTILITIES =>  */
    $code = "utilities-client-list";
    $nav[$page]['submenu'][$code]['label'] = "Owner's Information Settings";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/client_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','update_password'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* Maintenance */
    $page = "maintenance";  
    $nav[$page]['name'] = "Maintenance";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "trello";
    $nav[$page]['type']     = "menu";

    /* -- MAINTENACE => Payment Method */
    $code = "maintenance-payment-method";
    $nav[$page]['submenu'][$code]['label'] = "Payment Method"; 
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/payment_method";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- MAINTENACE => Payment Method */
    $code = "maintenance-online-payment-method";
    $nav[$page]['submenu'][$code]['label'] = "Online Payment Method"; 
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/online_payment";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    $code = "maintenance-email-content";
    $nav[$page]['submenu'][$code]['label'] = "Email Content"; 
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/email_content";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    $code = "maintenance-email-header-footer";
    $nav[$page]['submenu'][$code]['label'] = "Email Header & Footer"; 
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/email_header_footer";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* -- MAINTENACE => Sms Settings */
    $code = "maintenance-sms-content";
    $nav[$page]['submenu'][$code]['label'] = "SMS"; 
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/sms";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    $code = "maintenance-terms";
    $nav[$page]['submenu'][$code]['label'] = "Terms"; 
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/terms/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    $code = "maintenance-location";
    $nav[$page]['submenu'][$code]['label'] = "Location"; 
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/location/list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Bryan Kier Aradanas</span>";

    /* -- EMPLOYEE POSITION=> LIST  */
    $code = "pis-agent-position";
    $nav[$page]['submenu'][$code]['label'] = "Agent Position";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . "/utilities/agent_position";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add','edit','archived'];
    $nav[$page]['submenu'][$code]['status'] = "No progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

     /* -- PIS => TRUCK */
    $code = "pis-truck";
    $nav[$page]['submenu'][$code]['label'] = "Truck List";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . "/utilities/truck_list";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page','add','edit','archived'];
    $nav[$page]['submenu'][$code]['status'] = "No Progress Yet";
    $nav[$page]['submenu'][$code]['developer'] = "No Developer Yet";

    /* DEVELOPERS  */
    $page = "developer"; 
    $nav[$page]['name'] = "Developers";
    $nav[$page]['segment'] = $page;
    $nav[$page]['icon'] = "diamond";
    $nav[$page]['type']     = "menu";

    /* -- DEVELOPERS => PAGE STATUS */
    $code = "developer-page-status";
    $nav[$page]['submenu'][$code]['label'] = "Page Status";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/status";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "<span style='color: green'>(DONE)</span> You are looking at this page now.";
    $nav[$page]['submenu'][$code]['developer'] = "<span style='color: green'>Guillermo Tabligan</span>";   

     /* -- DEVELOPERS => REMATRIX */
    $code = "developer-rematrix";
    $nav[$page]['submenu'][$code]['label'] = "Rematrix";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/rematrix";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Developing";
    $nav[$page]['submenu'][$code]['developer'] = "Erwin Guevarra";

     /* -- DEVELOPERS => DOCUMENTATION */
    $code = "developer-auto-entry";
    $nav[$page]['submenu'][$code]['label'] = "Auto Entry";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/auto_entry";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Developing";
    $nav[$page]['submenu'][$code]['developer'] = "Everyone";
    
    $code = "developer-simulate";
    $nav[$page]['submenu'][$code]['label'] = "Simulate";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/simulate";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Developing";
    $nav[$page]['submenu'][$code]['developer'] = "Erwin Guevarra";

     /* -- DEVELOPERS => DOCUMENTATION */
    $code = "developer-documentation";
    $nav[$page]['submenu'][$code]['label'] = "Code Documentation";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/documentation";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Developing";
    $nav[$page]['submenu'][$code]['developer'] = "Everyone";

    $code = "developer-reset-slot";
    $nav[$page]['submenu'][$code]['label'] = "Reset Slot";
    $nav[$page]['submenu'][$code]['code'] = $code;
    $nav[$page]['submenu'][$code]['url'] = $path . $page . "/reset_slot";
    $nav[$page]['submenu'][$code]['user_settings'] = ['access_page'];
    $nav[$page]['submenu'][$code]['status'] = "Developing";
    $nav[$page]['submenu'][$code]['developer'] = "Luke Glenn Jordan";
    
    return $nav;
}
//dd(page_list());
?>