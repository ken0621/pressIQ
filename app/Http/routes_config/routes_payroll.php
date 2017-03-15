<?php
Route::group(array('prefix' => '/member/payroll'), function()
{

	/* COMPANY START */
	Route::any('/company_list','Member\PayrollController@company_list');
	Route::any('/company_list/modal_create_company','Member\PayrollController@modal_create_company');
	Route::any('/company_list/upload_company_logo','Member\PayrollController@upload_company_logo');
	Route::any('/company_list/modal_save_company','Member\PayrollController@modal_save_company');
	Route::any('/company_list/view_company_modal/{id}','Member\PayrollController@view_company_modal');
	Route::any('/company_list/edit_company_modal/{id}','Member\PayrollController@edit_company_modal');
	Route::any('/company_list/reload_company','Member\PayrollController@reload_company');
	Route::any('/company_list/archived_company','Member\PayrollController@archived_company');
	Route::any('/company_list/update_company','Member\PayrollController@update_company');
	/* COMPANY END */

	/* EMPLOYEE START */
	Route::any('/employee_list','Member\PayrollController@employee_list');
	Route::any('/employee_list/modal_create_employee','Member\PayrollController@modal_create_employee');
	Route::any('/employee_list/employee_updload_requirements','Member\PayrollController@employee_updload_requirements');
	Route::any('/employee_list/remove_employee_requirement','Member\PayrollController@remove_employee_requirement');
	Route::any('/employee_list/modal_employee_save','Member\PayrollController@modal_employee_save');
	Route::any('/employee_list/modal_employee_view/{id}','Member\PayrollController@modal_employee_view');
	Route::any('/employee_list/modal_view_contract_list/{id}','Member\PayrollController@modal_view_contract_list');
	Route::any('/employee_list/modal_create_contract/{id}','Member\PayrollController@modal_create_contract');
	Route::any('/employee_list/modal_save_contract','Member\PayrollController@modal_save_contract');
	Route::any('/employee_list/modal_salary_list/{id}','Member\PayrollController@modal_salary_list');
	Route::any('/employee_list/modal_create_salary_adjustment/{id}','Member\PayrollController@modal_create_salary_adjustment');
	Route::any('/employee_list/modal_save_salary','Member\PayrollController@modal_save_salary');
	Route::any('/employee_list/modal_employee_update','Member\PayrollController@modal_employee_update');
	Route::any('/employee_list/reload_employee_list','Member\PayrollController@reload_employee_list');

	/* EMPLOYEE END */
	Route::any('/payroll_configuration','Member\PayrollController@payroll_configuration');

	Route::any('/employee_timesheet','Member\PayrollTimesheetController@index');


	/* DEPARTMENT START */
	Route::any('/departmentlist','Member\PayrollController@department_list');
	Route::any('/departmentlist/department_modal_create','Member\PayrollController@department_modal_create');
	Route::any('/departmentlist/department_save','Member\PayrollController@department_save');
	Route::any('/departmentlist/archived_department','Member\PayrollController@archived_department');
	Route::any('/departmentlist/department_reload','Member\PayrollController@department_reload');
	Route::any('/departmentlist/modal_view_department/{id}','Member\PayrollController@modal_view_department');
	Route::any('/departmentlist/modal_edit_department/{id}','Member\PayrollController@modal_edit_department');
	Route::any('/departmentlist/modal_update_department','Member\PayrollController@modal_update_department');
	/* DEPARTMENT END */

	/* JOB TITLE START */
	Route::any("/jobtitlelist","Member\PayrollController@jobtitle_list");
	Route::any("/jobtitlelist/modal_create_jobtitle","Member\PayrollController@modal_create_jobtitle");
	Route::any("/jobtitlelist/modal_save_department","Member\PayrollController@modal_save_department");
	Route::any("/jobtitlelist/reload_tbl_jobtitle","Member\PayrollController@reload_tbl_jobtitle");
	Route::any("/jobtitlelist/get_job_title_by_department","Member\PayrollController@get_job_title_by_department");
	Route::any("/jobtitlelist/modal_edit_jobtitle/{id}","Member\PayrollController@modal_edit_jobtitle");
	Route::any("/jobtitlelist/modal_save_jobtitle","Member\PayrollController@modal_save_jobtitle");
	/* JOB TITLE END */


	/* TAX TABLE START */
	Route::any('/tax_table_list',"Member\PayrollController@tax_table_list");
	Route::any('/tax_table_list/tax_table_save',"Member\PayrollController@tax_table_save");

	/* saving default data for developer */
	Route::any('/tax_table_list/tax_table_save_default',"Member\PayrollController@tax_table_save_default");
	
	/* TAX TABLE END */

	/* SSS TABLE START */
	Route::any('/sss_table_list',"Member\PayrollController@sss_table_list");
	Route::any('/sss_table_list/sss_table_save',"Member\PayrollController@sss_table_save");

	/* saving default data for developer */
	Route::any('/sss_table_list/sss_table_save_default',"Member\PayrollController@sss_table_save_default");
	/* SSS TABLE END */

	/* PHILHEALTH TABLE START */
	Route::any('/philhealth_table_list',"Member\PayrollController@philhealth_table_list");
	Route::any('/philhealth_table_list/philhealth_table_save',"Member\PayrollController@philhealth_table_save");
	/* saving default data for developer */
	Route::any('/philhealth_table_list/philhealth_table_save_default',"Member\PayrollController@philhealth_table_save_default");
	/* PHILHEALTH TABLE END */


	/* PAGIBIG START */
	Route::any('/pagibig_formula',"Member\PayrollController@pagibig_formula");
	Route::any('/pagibig_formula/pagibig_formula_save',"Member\PayrollController@pagibig_formula_save");

	/* saving default data for developer */
	Route::any('/pagibig_formula/pagibig_formula_save_default',"Member\PayrollController@pagibig_formula_save_default");
	/* PAGIBIG END */


	/* DEDUCTION START */
	Route::any('/deduction',"Member\PayrollController@deduction");
	Route::any('/deduction/modal_create_deduction',"Member\PayrollController@modal_create_deduction");
	Route::any('/deduction/modal_create_deduction_type/{type}',"Member\PayrollController@modal_create_deduction_type");
	Route::any('/deduction/modal_save_deduction_type',"Member\PayrollController@modal_save_deduction_type");
	Route::any('/deduction/update_deduction_type',"Member\PayrollController@update_deduction_type");
	Route::any('/deduction/reload_deduction_type',"Member\PayrollController@reload_deduction_type");
	/* DEDUCTION END */


	/* HOLIDAY START */
	Route::any('/holiday',"Member\PayrollController@holiday");
	/* HOLIDAY END */

	/* ALLOWANCE START */
	Route::any('/allowance',"Member\PayrollController@allowance");
	/* ALLOWANCE END */

	/* LEAVE START */
	Route::any('/leave',"Member\PayrollController@leave");
	/* LEAVE END */
});