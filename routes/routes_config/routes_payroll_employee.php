<?php

Route::any('/employee_login', 'Login\EmployeeLoginController@employee_login');
Route::any('/employee_logout', 'Login\EmployeeLoginController@employee_logout');

Route::any('employee', 'Member\PayrollEmployee\EmployeeController@employee');

Route::any('employee_profile', 'Member\PayrollEmployee\EmployeeController@employee_profile');
Route::any('edit_employee_profile', 'Member\PayrollEmployee\EmployeeController@edit_employee_profile');
Route::any('update_employee_profile', 'Member\PayrollEmployee\EmployeeController@update_employee_profile');

Route::any('employee_leave_management', 'Member\PayrollEmployee\EmployeeController@employee_leave_management');
Route::any('employee_leave_application', 'Member\PayrollEmployee\EmployeeController@employee_leave_application');
Route::any('employee_summary_of_leave', 'Member\PayrollEmployee\EmployeeController@employee_summary_of_leave');
Route::any('employee_official_business', 'Member\PayrollEmployee\EmployeeController@employee_official_business');
Route::any('company_details', 'Member\PayrollEmployee\EmployeeController@company_details');
Route::any('authorized_access_leave', 'Member\PayrollEmployee\EmployeeController@authorized_access_leave');


/*Start overtime request and management*/
Route::any('employee_overtime_management', 'Member\PayrollEmployee\EmployeeController@employee_overtime_management');
Route::any('employee_overtime_management_table', 'Member\PayrollEmployee\EmployeeController@employee_overtime_management_table');
Route::any('employee_overtime_application', 'Member\PayrollEmployee\EmployeeController@employee_overtime_application');
Route::any('employee_overtime_view_shift', 'Member\PayrollEmployee\EmployeeController@employee_overtime_view_shift');
Route::any('/get_group_approver_list', 'Member\PayrollEmployee\EmployeeController@get_group_approver_list');
Route::any('employee_request_overtime_save', 'Member\PayrollEmployee\EmployeeController@employee_request_overtime_save');
Route::any('employee_request_overtime_view/{request_id}', 'Member\PayrollEmployee\EmployeeController@employee_request_overtime_view');
Route::any('employee_request_overtime_cancel/{request_id}', 'Member\PayrollEmployee\EmployeeController@employee_request_overtime_cancel');

Route::any('authorized_access_over_time', 'Member\PayrollEmployee\EmployeeController@authorized_access_over_time');
Route::any('authorized_access_over_time/view_overtime_request/{request_id}', 'Member\PayrollEmployee\EmployeeController@view_overtime_request');
Route::any('authorized_access_over_time/approve_overtime_request/{request_id}', 'Member\PayrollEmployee\EmployeeController@approve_overtime_request');
Route::any('authorized_access_over_time/reject_overtime_request/{request_id}', 'Member\PayrollEmployee\EmployeeController@reject_overtime_request');
/*End overtime request and management*/
Route::any('authorized_access_official_business', 'Member\PayrollEmployee\EmployeeController@authorized_access_official_business');


Route::any('authorized_access_approver', 'Member\PayrollEmployee\EmployeeController@authorized_access_approver');

/*Start Request for Payment*/
Route::any('/request_for_payment', 'Member\PayrollEmployee\RequestForPaymentController@index');
/*End Request for Payment*/

Route::any('employee_official_business_management', 'Member\PayrollEmployee\EmployeeController@employee_official_business_management');
Route::any('employee_time_keeping', 'Member\PayrollEmployee\EmployeeController@employee_time_keeping');


Route::any('create_employee_leave', 'Member\PayrollEmployee\EmployeeController@create_employee_leave');
Route::any('create_employee_overtime', 'Member\PayrollEmployee\EmployeeController@create_employee_overtime');
Route::any('create_employee_official_business', 'Member\PayrollEmployee\EmployeeController@create_employee_official_business');
Route::any('create_employee_approver', 'Member\PayrollEmployee\EmployeeController@create_employee_approver');


Route::any('employee_payslip_pdf/{payroll_period_id}','Member\PayrollEmployee\EmployeeController@employee_payslip_pdf');
Route::any('employee_timesheet/{payroll_period_id}','Member\PayrollEmployee\EmployeeController@employee_timesheet');
Route::any('employee_timesheet_pdf/{payroll_period_id}','Member\PayrollEmployee\EmployeeController@employee_timesheet_pdf');



Route::any('sample', 'Member\PayrollEmployee\EmployeeController@sample');
Route::any('updated_layout', 'Member\PayrollEmployee\EmployeeController@updated_layout');
