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
	Route::any('/company_list/modal_archived_company/{archived}/{id}','Member\PayrollController@modal_archived_company');
	/* COMPANY END */

	/* EMPLOYEE START */
	Route::any('/employee_list','Member\PayrollController@employee_list');

	/* import from excel start */
	Route::any('/employee_list/modal_import_employee','Member\PayrollController@modal_import_employee');
	Route::any('/employee_list/modal_import_employee/get_201_template','Member\PayrollController@get_201_template');
	Route::any('/employee_list/modal_import_employee/import_201_template','Member\PayrollController@import_201_template');
	/* import from excel end */
	Route::any('/employee_list/modal_create_employee','Member\PayrollController@modal_create_employee');
	Route::any('/employee_list/employee_updload_requirements','Member\PayrollController@employee_updload_requirements');
	Route::any('/employee_list/remove_employee_requirement','Member\PayrollController@remove_employee_requirement');
	Route::any('/employee_list/modal_employee_save','Member\PayrollController@modal_employee_save');
	Route::any('/employee_list/modal_employee_view/{id}','Member\PayrollController@modal_employee_view');
	Route::any('/employee_list/modal_view_contract_list/{id}','Member\PayrollController@modal_view_contract_list');
	Route::any('/employee_list/modal_create_contract/{id}','Member\PayrollController@modal_create_contract');
	Route::any('/employee_list/modal_save_contract','Member\PayrollController@modal_save_contract');
	Route::any('/employee_list/modal_edit_contract/{employee_id}/{id}','Member\PayrollController@modal_edit_contract');
	Route::any('/employee_list/modal_update_contract','Member\PayrollController@modal_update_contract');
	Route::any('/employee_list/modal_archive_contract/{archived}/{id}','Member\PayrollController@modal_archive_contract');
	Route::any('/employee_list/modal_salary_list/{id}','Member\PayrollController@modal_salary_list');
	Route::any('/employee_list/modal_edit_salary_adjustment/{id}','Member\PayrollController@modal_edit_salary_adjustment');
	Route::any('/employee_list/modal_update_salary','Member\PayrollController@modal_update_salary');
	Route::any('/employee_list/modal_archived_salary/{archived}/{id}','Member\PayrollController@modal_archived_salary');
	Route::any('/employee_list/archived_salary','Member\PayrollController@archived_salary');
	Route::any('/employee_list/archive_contract','Member\PayrollController@archive_contract');
	Route::any('/employee_list/modal_create_salary_adjustment/{id}','Member\PayrollController@modal_create_salary_adjustment');
	Route::any('/employee_list/modal_save_salary','Member\PayrollController@modal_save_salary');
	Route::any('/employee_list/modal_employee_update','Member\PayrollController@modal_employee_update');
	Route::any('/employee_list/reload_employee_list','Member\PayrollController@reload_employee_list');
	/* EMPLOYEE SEARCH */
	Route::any('/employee_list/search_employee_ahead','Member\PayrollController@search_employee_ahead');
	Route::any('/employee_list/search_employee','Member\PayrollController@search_employee');

	/* EMPLOYEE END */
	Route::any('/payroll_configuration','Member\PayrollController@payroll_configuration');

	
	/* TIMESHEET START */
	Route::any('/employee_timesheet','Member\PayrollTimeSheetController@index');
	Route::any('/company_timesheet/{id}','Member\PayrollTimeSheetController@company_timesheet');

	Route::any('/employee_timesheet/timesheet/{id}/{period_id}','Member\PayrollTimeSheetController@timesheet');
	Route::any('/employee_timesheet/json_process_time','Member\PayrollTimeSheetController@json_process_time');
	Route::any('/employee_timesheet/json_process_time_single/{date}/{employee_id}','Member\PayrollTimeSheetController@json_process_time_single');
	Route::any('/employee_timesheet/adjustment_form','Member\PayrollTimeSheetController@adjustment_form');
	Route::post('/employee_timesheet/adjustment_form_approve','Member\PayrollTimeSheetController@adjustment_form_approve');
	Route::any('/employee_timesheet/show_holiday/{id}/{date}','Member\PayrollTimeSheetController@show_holiday');
	Route::any('/timesheet/mark_ready_company','Member\PayrollController@mark_ready_company');
	Route::any('/timesheet/show_summary/{summary}/{period_id}','Member\PayrollTimeSheetController@show_summary');
	/* TIMESHEET END */

	/* DEPARTMENT START */
	Route::any('/departmentlist','Member\PayrollController@department_list');
	Route::any('/departmentlist/department_modal_create','Member\PayrollController@department_modal_create');
	Route::any('/departmentlist/department_save','Member\PayrollController@department_save');
	Route::any('/departmentlist/modal_archived_department/{archived}/{department_id}',"Member\PayrollController@modal_archived_department");
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
	Route::any("/jobtitlelist/modal_view_jobtitle/{id}","Member\PayrollController@modal_view_jobtitle");
	Route::any("/jobtitlelist/modal_update_jobtitle","Member\PayrollController@modal_update_jobtitle");
	Route::any("/jobtitlelist/modal_edit_jobtitle/{id}","Member\PayrollController@modal_edit_jobtitle");
	Route::any("/jobtitlelist/modal_save_jobtitle","Member\PayrollController@modal_save_jobtitle");
	Route::any('/jobtitlelist/modal_archived_jobtitle/{archived}/{jobtitle_id}',"Member\PayrollController@modal_archived_jobtitle");
	Route::any('/jobtitlelist/archived_jobtitle','Member\PayrollController@archived_jobtitle');
	/* JOB TITLE END */


	/* TAX PERIOD START */
	Route::any('/tax_period',"Member\PayrollController@tax_period");
	Route::any('/tax_period/taxt_perid_change',"Member\PayrollController@taxt_perid_change");
	/* TAX PERIOD END */

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
	Route::any('/deduction/archive_deduction_type',"Member\PayrollController@archive_deduction_type");
	Route::any('/deduction/ajax_deduction_type',"Member\PayrollController@ajax_deduction_type");
	Route::any('/deduction/modal_deduction_tag_employee/{id}',"Member\PayrollController@modal_deduction_tag_employee");
	Route::any('/deduction/ajax_deduction_tag_employee',"Member\PayrollController@ajax_deduction_tag_employee");
	Route::any('/deduction/set_employee_deduction_tag',"Member\PayrollController@set_employee_deduction_tag");
	Route::any('/deduction/get_employee_deduction_tag',"Member\PayrollController@get_employee_deduction_tag");
	Route::any('/deduction/remove_from_tag_session',"Member\PayrollController@remove_from_tag_session");
	Route::any('/deduction/modal_save_deduction',"Member\PayrollController@modal_save_deduction");
	Route::any('/deduction/modal_edit_deduction/{id}',"Member\PayrollController@modal_edit_deduction");
	Route::any('/deduction/archive_deduction/{archived}/{id}',"Member\PayrollController@archive_deduction");
	Route::any('/deduction/archived_deduction_action',"Member\PayrollController@archived_deduction_action");
	Route::any('/deduction/modal_update_deduction',"Member\PayrollController@modal_update_deduction");
	Route::any('/deduction/reload_deduction_employee_tag',"Member\PayrollController@reload_deduction_employee_tag");
	Route::any('/deduction/deduction_employee_tag/{archived}/{payroll_deduction_employee_id}',"Member\PayrollController@deduction_employee_tag");
	Route::any('/deduction/deduction_employee_tag_archive',"Member\PayrollController@deduction_employee_tag_archive");
	/* DEDUCTION END */


	/* HOLIDAY START */
	Route::any('/holiday',"Member\PayrollController@holiday");
	Route::any('/holiday/modal_create_holiday',"Member\PayrollController@modal_create_holiday");
	Route::any('/holiday/modal_save_holiday',"Member\PayrollController@modal_save_holiday");
	Route::any('/holiday/archive_holiday/{archived}/{id}',"Member\PayrollController@archive_holiday");
	Route::any('/holiday/archive_holiday_action',"Member\PayrollController@archive_holiday_action");
	Route::any('/holiday/modal_edit_holiday/{id}',"Member\PayrollController@modal_edit_holiday");
	Route::any('/holiday/modal_update_holiday',"Member\PayrollController@modal_update_holiday");
	/* HOLIDAY END */

	/* ALLOWANCE START */
	Route::any('/allowance',"Member\PayrollController@allowance");
	Route::any('/allowance/modal_create_allowance',"Member\PayrollController@modal_create_allowance");
	Route::any('/allowance/modal_allowance_tag_employee/{allowance_id}',"Member\PayrollController@modal_allowance_tag_employee");
	Route::any('/allowance/set_employee_allowance_tag',"Member\PayrollController@set_employee_allowance_tag");
	Route::any('/allowance/get_employee_allowance_tag',"Member\PayrollController@get_employee_allowance_tag");
	Route::any('/allowance/remove_allowance_tabe_employee',"Member\PayrollController@remove_allowance_tabe_employee");
	Route::any('/allowance/modal_save_allowances',"Member\PayrollController@modal_save_allowances");
	Route::any('/allowance/modal_archived_allwance/{archived}/{allowance_id}',"Member\PayrollController@modal_archived_allwance");
	Route::any('/allowance/archived_allowance',"Member\PayrollController@archived_allowance");
	Route::any('/allowance/modal_edit_allowance/{id}',"Member\PayrollController@modal_edit_allowance");
	Route::any('/allowance/modal_archived_llowance_employee/{archived}/{id}',"Member\PayrollController@modal_archived_llowance_employee");
	Route::any('/allowance/reload_allowance_employee',"Member\PayrollController@reload_allowance_employee");
	Route::any('/allowance/archived_allowance_employee',"Member\PayrollController@archived_allowance_employee");
	Route::any('/allowance/update_allowance',"Member\PayrollController@update_allowance");
	/* ALLOWANCE END */

	/* LEAVE START */
	Route::any('/leave',"Member\PayrollController@leave");
	/*Link to Modal Create leave_temp*/
	Route::any('/leave/modal_create_leave_temp',"Member\PayrollController@modal_create_leave_temp");
	/*Another Modal for tagging employee*/
	Route::any('/leave/modal_leave_tag_employee/{leave_temp_id}',"Member\PayrollController@modal_leave_tag_employee");
	Route::any('/leave/set_leave_employee_tag',"Member\PayrollController@set_leave_employee_tag");
	Route::any('/leave/get_leave_tag_employee',"Member\PayrollController@get_leave_tag_employee");
	Route::any('/leave/remove_leave_tag_employee',"Member\PayrollController@remove_leave_tag_employee");
	Route::any('/leave/modal_save_leave_temp',"Member\PayrollController@modal_save_leave_temp");
	Route::any('/leave/modal_archived_leave_temp/{archived}/{leave_temp_id}',"Member\PayrollController@modal_archived_leave_temp");
	Route::any('/leave/archived_leave_temp',"Member\PayrollController@archived_leave_temp");
	
	Route::any('/leave/reload_leave_employee',"Member\PayrollController@reload_leave_employee");

	Route::any('/leave/modal_edit_leave_temp/{id}',"Member\PayrollController@modal_edit_leave_temp");
	Route::any('/leave/set_leave_tag_employee',"Member\PayrollController@set_leave_tag_employee");

	Route::any('/leave/archived_leave_employee',"Member\PayrollController@archived_leave_employee");

	Route::any('/leave/modal_archived_leave_employee/{archived}/{id}',"Member\PayrollController@modal_archived_leave_employee");
	/*Update leave temp*/
	Route::any('/leave/update_leave_temp',"Member\PayrollController@update_leave_temp");
	/* LEAVE END */


	/* PAYROLL GROUP START */
	Route::any('/payroll_group',"Member\PayrollController@payroll_group");
	Route::any('/payroll_group/modal_create_payroll_group',"Member\PayrollController@modal_create_payroll_group");
	Route::any('/payroll_group/modal_save_payroll_group',"Member\PayrollController@modal_save_payroll_group");
	Route::any('/payroll_group/modal_edit_payroll_group/{id}',"Member\PayrollController@modal_edit_payroll_group");
	Route::any('/payroll_group/modal_update_payroll_group',"Member\PayrollController@modal_update_payroll_group");
	Route::any('/payroll_group/confirm_archived_payroll_group/{archived}/{group_id}',"Member\PayrollController@confirm_archived_payroll_group");
	Route::any('/payroll_group/archived_payroll_group',"Member\PayrollController@archived_payroll_group");
	/* PAYROLL GROUP END */

	/* PAYROLL JOURNAL SETTINGS START */
	Route::any('/payroll_jouarnal',"Member\PayrollController@payroll_jouarnal");
	Route::any('/payroll_jouarnal/modal_create_journal_tag',"Member\PayrollController@modal_create_journal_tag");
	Route::any('/payroll_jouarnal/create_journal_tag',"Member\PayrollController@create_journal_tag");
	Route::any('/payroll_jouarnal/modal_edit_journal_tag/{id}',"Member\PayrollController@modal_edit_journal_tag");
	Route::any('/payroll_jouarnal/modal_confimr_del_journal_tag/{id}',"Member\PayrollController@modal_confimr_del_journal_tag");
	Route::any('/payroll_jouarnal/update_payroll_journal_tag',"Member\PayrollController@update_payroll_journal_tag");
	Route::any('/payroll_jouarnal/del_journal_tag',"Member\PayrollController@del_journal_tag");
	Route::any('/payroll_jouarnal/relaod_payroll_journal_sel',"Member\PayrollController@relaod_payroll_journal_sel");
	/* PAYROLL JOURNAL SETTINGS END */


	/* PAYROLL CUSTOM PAYSLIP START */
	Route::any('/custom_payslip',"Member\PayrollController@custom_payslip");
	Route::any('/custom_payslip/modal_create_payslip',"Member\PayrollController@modal_create_payslip");
	Route::any('/custom_payslip/modal_create_paper_size',"Member\PayrollController@modal_create_paper_size");
	Route::any('/custom_payslip/modal_save_paper_size',"Member\PayrollController@modal_save_paper_size");
	Route::any('/custom_payslip/save_custom_payslip',"Member\PayrollController@save_custom_payslip");
	Route::any('/custom_payslip/custom_payslip_show/{id}',"Member\PayrollController@custom_payslip_show");
	Route::any('/custom_payslip/custom_payslip_show_archived/{id}',"Member\PayrollController@custom_payslip_show_archived");
	Route::any('/custom_payslip/modal_edit_payslip/{id}',"Member\PayrollController@modal_edit_payslip");
	Route::any('/custom_payslip/modal_archive_payslip/{archived}/{id}',"Member\PayrollController@modal_archive_payslip");
	Route::any('/custom_payslip/archive_payslip',"Member\PayrollController@archive_payslip");
	Route::any('/custom_payslip/modal_update_payslip',"Member\PayrollController@modal_update_payslip");
	Route::any('/custom_payslip/payslip_use_change',"Member\PayrollController@payslip_use_change");
	
	/* PAYROLL CUSTOM PAYSLIP END */

	/* PAYROLL PERIOD START */
	Route::any('/payroll_period_list','Member\PayrollController@payroll_period_list');
	Route::any('/payroll_period_list/modal_create_payroll_period','Member\PayrollController@modal_create_payroll_period');
	Route::any('/payroll_period_list/modal_save_payroll_period','Member\PayrollController@modal_save_payroll_period');
	Route::any('/payroll_period_list/modal_archive_period/{archived}/{id}','Member\PayrollController@modal_archive_period');
	Route::any('/payroll_period_list/archive_period','Member\PayrollController@archive_period');
	Route::any('/payroll_period_list/modal_edit_period/{id}','Member\PayrollController@modal_edit_period');
	Route::any('/payroll_period_list/modal_update_period','Member\PayrollController@modal_update_period');
	/* PAYROLL PERIOD END */

	/* HOLIDAY DEFAULT START */
	Route::any('/holiday_default/modal_create_holiday_default',"Member\PayrollController@modal_create_holiday_default");
	Route::any('/holiday_default/modal_save_holiday_default',"Member\PayrollController@modal_save_holiday_default");	

	Route::any('/holiday_default/modal_edit_holiday_default/{id}',"Member\PayrollController@modal_edit_holiday_default");
	Route::any('/holiday_default/update_holiday_default',"Member\PayrollController@update_holiday_default");
	/* HOLIDAY END */



	/* BIO METRICS IMPORT START */
	Route::any('/import_bio/modal_biometrics','Member\Payroll_BioImportController@modal_biometrics');

		
	/* dmsph start */
	Route::any('/import_bio/import_global','Member\Payroll_BioImportController@import_global');
	Route::any('/import_bio/template_global','Member\Payroll_BioImportController@template_global');
	/* dmsph end */

	/* BIO METRICS IMPORT END */

	/* CALENDAR LEAVE START */
	Route::any('/leave_schedule','Member\PayrollController@leave_schedule');	
	Route::any('/leave_schedule/modal_create_leave_schedule','Member\PayrollController@modal_create_leave_schedule');	
	Route::any('/leave_schedule/leave_schedule_tag_employee/{id}','Member\PayrollController@leave_schedule_tag_employee');
	Route::any('/leave_schedule/ajax_shecdule_leave_tag_employee','Member\PayrollController@ajax_shecdule_leave_tag_employee');	
	Route::any('/leave_schedule/session_tag_leave','Member\PayrollController@session_tag_leave');	
	Route::any('/leave_schedule/get_session_leave_tag','Member\PayrollController@get_session_leave_tag');
	Route::any('/leave_schedule/unset_session_leave_tag','Member\PayrollController@unset_session_leave_tag')
	;
	Route::any('/leave_schedule/save_schedule_leave_tag','Member\PayrollController@save_schedule_leave_tag')
	;
	Route::any('/leave_schedule/delete_confirm_schedule_leave/{id}','Member\PayrollController@delete_confirm_schedule_leave')
	;
	Route::any('/leave_schedule/delete_schedule_leave','Member\PayrollController@delete_schedule_leave')
	;
	/* CALDENDAR LEAVE END */


	/* PAYORLL TIME KEEPING START */
	Route::any('/time_keeping','Member\PayrollController@time_keeping');
	Route::any('/time_keeping/modal_generate_period','Member\PayrollController@modal_generate_period');
	Route::any('/time_keeping/generate_period','Member\PayrollController@generate_period');
	Route::any('/time_keeping/company_period/{id}','Member\PayrollController@company_period');
	/* PAYROLL TIME KEEPING END */


	/* NO RECORDS FOUND */
	Route::any('/no_records','Member\PayrollController@no_records');



	/* PAYROLL PROCESS START */
	Route::any('/payroll_process','Member\PayrollController@payroll_process');
	Route::any('/payroll_process/modal_create_process','Member\PayrollController@modal_create_process');
	Route::any('/payroll_process/ajax_load_payroll_period','Member\PayrollController@ajax_load_payroll_period');
	Route::any('/payroll_process/ajax_payroll_company_period','Member\PayrollController@ajax_payroll_company_period');
	Route::any('/payroll_process/process_payroll','Member\PayrollController@process_payroll');
	Route::any('/payroll_process/payroll_compute_brk_unsaved/{employee_id}/{period_company_id}','Member\PayrollController@payroll_compute_brk_unsaved');

	Route::any('/payroll_process/payroll_explain_computation/{employee_id}/{period_company_id}','Member\PayrollController@payroll_explain_computation');
	
	Route::any('/payroll_process/modal_create_payroll_adjustment/{payroll_employee_id}/{payroll_period_company_id}','Member\PayrollController@modal_create_payroll_adjustment');
	Route::any('/payroll_process/create_payroll_adjustment','Member\PayrollController@create_payroll_adjustment');
	Route::any('/payroll_process/confirm_remove_adjustment/{id}','Member\PayrollController@confirm_remove_adjustment');
	Route::any('/payroll_process/remove_adjustment','Member\PayrollController@remove_adjustment');
	Route::any('/payroll_process/confirm_action_payroll/{action}/{id}','Member\PayrollController@confirm_action_payroll');
	Route::any('/payroll_process/action_payroll','Member\PayrollController@action_payroll');
	Route::any('/payroll_process/confirm_cancel_payroll/{action}/{id}','Member\PayrollController@confirm_cancel_payroll');

	Route::any('/payroll_process/modal_13_month/{id}/{period_id}','Member\PayrollController@modal_13_month');
	Route::any('/payroll_process/modal_unused_leave/{id}/{period_id}','Member\PayrollController@modal_unused_leave');
	Route::any('/payroll_process/modal_submit_13_month','Member\PayrollController@modal_submit_13_month');
	/* PAYROLL PROCESS END */


	/* PAYROLL SUMMARY JOURNAL ENTRIES */
	Route::get('/journal_entry','Member\PayrollController@journal_entry');

	/* END */

	/* PAYROLL REGISTER START */
	Route::any('/payroll_register','Member\PayrollController@payroll_register');
	Route::any('/payroll_register/breakdown_uncompute_static/{employee_id}/{period_company_id}','Member\PayrollController@breakdown_uncompute_static');
	/* PAYROLL REGISTER END */


	/* PAYROLL POSTED START */
	Route::any('/payroll_post','Member\PayrollController@payroll_post');
	/* PAYROLL POSTED END */

	/* PAYROLL APPROVED START */
	Route::any('/payroll_approved_view','Member\PayrollController@payroll_approved_view');
	Route::any('/payroll_approved_view/approve_payroll','Member\PayrollController@approve_payroll');
	Route::any('/payroll_approved_view/payroll_approved_company/{id}','Member\PayrollController@payroll_approved_company');
	Route::any('/payroll_approved_view/payroll_record_by_id/{id}','Member\PayrollController@payroll_record_by_id');
	Route::any('/payroll_approved_view/genereate_payslip/{id}','Member\PayrollController@genereate_payslip');
	/* PAYROLLL APPROVED END */

	/* PAYROLL NOTES  START*/
	Route::any('/modal_payroll_notes/{id}','Member\PayrollController@modal_payroll_notes');
	/* PAYROLL NOTES END */

	/* PAYROLL REPORTS START */
	Route::any('/payroll_reports','Member\PayrollController@payroll_reports');
	Route::any('/payroll_reports/modal_create_reports','Member\PayrollController@modal_create_reports');
	Route::any('/payroll_reports/save_custom_reports','Member\PayrollController@save_custom_reports');
	Route::any('/payroll_reports/modal_archive_reports/{archived}/{id}','Member\PayrollController@modal_archive_reports');
	Route::any('/payroll_reports/archive_report','Member\PayrollController@archive_report');
	Route::any('/payroll_reports/modal_edit_reports/{id}','Member\PayrollController@modal_edit_payroll_reports');
	Route::any('/payroll_reports/update_payroll_reports','Member\PayrollController@update_payroll_reports');
	Route::any('/payroll_reports/view_report/{id}','Member\PayrollController@view_report');
	Route::any('/payroll_reports/download_excel_report','Member\PayrollController@download_excel_report');
	Route::any('/payroll_reports/date_change_report','Member\PayrollController@date_change_report');
	/* PAYROLL REPORTS END */


	/* GENERATE BANK UPLOAD START */
	Route::any('/generate_bank','Member\PayrollController@generate_bank');
	Route::any('/modal_generate_bank/{id}','Member\PayrollController@modal_generate_bank');
	/* GENERATE BANK UPLOAD END */
});	 
