<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Redirect;
use Session;
use Excel;
use DB;

use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_rdo;
use App\Models\Tbl_payroll_department;
use App\Models\Tbl_payroll_jobtitle;
use App\Models\Tbl_payroll_employment_status;
use App\Models\Tbl_payroll_civil_status;
use App\Models\Tbl_country;
use App\Models\Tbl_payroll_requirements;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_employee_requirements;
use App\Models\Tbl_payroll_tax_status;
use App\Models\Tbl_payroll_tax_reference;
use App\Models\Tbl_payroll_tax_period;
use App\Models\Tbl_payroll_tax_default;
use App\Models\Tbl_payroll_sss_default;
use App\Models\Tbl_payroll_sss;
use App\Models\Tbl_payroll_philhealth_default;
use App\Models\Tbl_payroll_philhealth;
use App\Models\Tbl_payroll_pagibig_default;
use App\Models\Tbl_payroll_pagibig;
use App\Models\Tbl_payroll_deduction_type;
use App\Models\Tbl_payroll_deduction;
use App\Models\Tbl_payroll_deduction_employee;
use App\Models\Tbl_payroll_deduction_payment;
use App\Models\Tbl_payroll_allowance;
use App\Models\Tbl_payroll_employee_allowance;
use App\Models\Tbl_payroll_leave_temp;
use App\Models\Tbl_payroll_leave_employee;
use App\Models\Tbl_payroll_holiday;
use App\Models\Tbl_payroll_holiday_default;
use App\Models\Tbl_payroll_holiday_company;
use App\Models\Tbl_payroll_overtime_rate;
use App\Models\Tbl_payroll_over_time_rate_default;
use App\Models\Tbl_payroll_group;
use App\Models\Tbl_payroll_group_rest_day;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_record;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_period;
use App\Models\Tbl_payroll_bank_convertion;
use App\Models\Tbl_payroll_employee_dependent;
use App\Models\Tbl_payroll_employee_search;
use App\Models\Tbl_payroll_adjustment;
use App\Models\Tbl_payroll_allowance_record;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_payroll_entity;
use App\Models\Tbl_payroll_journal_tag;
use App\Models\Tbl_payroll_journal_tag_entity;
use App\Models\Tbl_payroll_journal_tag_employee;
use App\Models\Tbl_payroll_leave_schedule;
use App\Models\Tbl_payroll_paper_sizes;

use App\Globals\Payroll;
use App\Globals\PayrollJournalEntries;
use App\Globals\Utilities;

class PayrollController extends Member
{

	/*Set data per page for pagination*/
	protected $paginate_count = 10;

	public function shop_id()
	{
		return $shop_id = $this->user_info->user_shop;
	}

	/* EMPLOYEE START */

    public function employee_list()
	{	
		$active_status[0] 	 = 1;
		$active_status[1] 	 = 2;
		$active_status[2] 	 = 3;
		$active_status[3] 	 = 4;
		$active_status[4] 	 = 5;
		$active_status[5] 	 = 6;
		$active_status[7] 	 = 7;

		$separated_status[0] = 8;
		$separated_status[1] = 9;

		$data['_active']					= Tbl_payroll_employee_contract::employeefilter(0,0,0,date('Y-m-d'), Self::shop_id())->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->paginate($this->paginate_count);

		$data['_separated']					= Tbl_payroll_employee_contract::employeefilter(0,0,0,date('Y-m-d'), Self::shop_id(), $separated_status)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->paginate($this->paginate_count);

		// $data['_company']					= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->paginate($this->paginate_count);

          $data['_company']                       = Payroll::company_heirarchy(Self::shop_id());
		// dd($data['_company']);
		$data['_status_active']				= Tbl_payroll_employment_status::whereIn('payroll_employment_status_id', $active_status)->orderBy('employment_status')->paginate($this->paginate_count);

		
		$data['_status_separated']			= Tbl_payroll_employment_status::whereIn('payroll_employment_status_id', $separated_status)->orderBy('employment_status')->paginate($this->paginate_count);
		return view('member.payroll.employeelist', $data);
	}   


	/* IMPORT EMPLOYEE DATA FROM EXCEL  START*/
	public function modal_import_employee()
	{
		return view('member.payroll.modal.modal_import_employee');
	}

	public function get_201_template()
	{
          $excels['number_of_rows'] = Request::input('number_of_rows');

          $excels['data'] = ['Company','Employee Number','Title Name','First Name','Middle Name','Last Name','Suffix Name','ATM/Account Number','Gender (M/F)','Birthdate','Civil Status','Street','City/Town','State/Province','Country','Zip Code', 'Contact','Email Address','Tax Status','Monthly Salary','Daily Rate' ,'Taxable Salary','SSS Salary','HDMF Salary','PHIC Salary','Minimum Wage (Y/N)','Department','Position','Start Date','Employment Status','SSS Number','Philhealth Number','Pagibig Number','TIN','BioData/Resume(Y/N)','Police Clearance(Y/N)','NBI(Y/N)','Health Certificate(Y/N)','School Credentials(Y/N)','Valid ID(Y/N)','Dependent Full Name(1)','Dependent Relationship(1)','Dependent Birthdate(1)','Dependent Full Name(2)','Dependent Relationship(2)','Dependent Birthdate(2)','Dependent Full Name(3)','Dependent Relationship(3)','Dependent Birthdate(3)','Dependent Full Name(4)','Dependent Relationship(4)','Dependent Birthdate(4)','Remarks'];

          Excel::create('201 Template', function($excel) use ($excels) {

               $excel->sheet('template', function($sheet) use ($excels) {

                $data = $excels['data'];
                $number_of_rows = $excels['number_of_rows'];
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->freezeFirstRow();

                for($row = 1, $rowcell = 2; $row <= $number_of_rows; $row++, $rowcell++)
                {

                    /* COMPANY/CLIENT ROW */
                    $client_cell = $sheet->getCell('A'.$rowcell)->getDataValidation();
                    $client_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $client_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $client_cell->setAllowBlank(false);
                    $client_cell->setShowInputMessage(true);
                    $client_cell->setShowErrorMessage(true);
                    $client_cell->setShowDropDown(true);
                    $client_cell->setErrorTitle('Input error');
                    $client_cell->setError('Value is not in list.');
                    $client_cell->setFormula1('client');


                    /* GENDER ROW */
                    $gender_cell = $sheet->getCell('I'.$rowcell)->getDataValidation();
                    $gender_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $gender_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $gender_cell->setAllowBlank(false);
                    $gender_cell->setShowInputMessage(true);
                    $gender_cell->setShowErrorMessage(true);
                    $gender_cell->setShowDropDown(true);
                    $gender_cell->setErrorTitle('Input error');
                    $gender_cell->setError('Value is not in list.');
                    $gender_cell->setFormula1('gender');


                    /* CIVIL STATUS ROW */
                    $civil_status_cell = $sheet->getCell('K'.$rowcell)->getDataValidation();
                    $civil_status_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $civil_status_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $civil_status_cell->setAllowBlank(false);
                    $civil_status_cell->setShowInputMessage(true);
                    $civil_status_cell->setShowErrorMessage(true);
                    $civil_status_cell->setShowDropDown(true);
                    $civil_status_cell->setErrorTitle('Input error');
                    $civil_status_cell->setError('Value is not in list.');
                    $civil_status_cell->setFormula1('civilstatus');

                    /* CIVIL STATUS ROW */
                    $civil_status_cell = $sheet->getCell('O'.$rowcell)->getDataValidation();
                    $civil_status_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $civil_status_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $civil_status_cell->setAllowBlank(false);
                    $civil_status_cell->setShowInputMessage(true);
                    $civil_status_cell->setShowErrorMessage(true);
                    $civil_status_cell->setShowDropDown(true);
                    $civil_status_cell->setErrorTitle('Input error');
                    $civil_status_cell->setError('Value is not in list.');
                    $civil_status_cell->setFormula1('country');


                    /* TAXT STATUS ROW */
                    $tax_status_cell = $sheet->getCell('S'.$rowcell)->getDataValidation();
                    $tax_status_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $tax_status_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $tax_status_cell->setAllowBlank(false);
                    $tax_status_cell->setShowInputMessage(true);
                    $tax_status_cell->setShowErrorMessage(true);
                    $tax_status_cell->setShowDropDown(true);
                    $tax_status_cell->setErrorTitle('Input error');
                    $tax_status_cell->setError('Value is not in list.');
                    $tax_status_cell->setFormula1('taxstatus');


                    /* MINIMUM WAGE ROW */
                    $minimum_wage_cell = $sheet->getCell('Z'.$rowcell)->getDataValidation();
                    $minimum_wage_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $minimum_wage_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $minimum_wage_cell->setAllowBlank(false);
                    $minimum_wage_cell->setShowInputMessage(true);
                    $minimum_wage_cell->setShowErrorMessage(true);
                    $minimum_wage_cell->setShowDropDown(true);
                    $minimum_wage_cell->setErrorTitle('Input error');
                    $minimum_wage_cell->setError('Value is not in list.');
                    $minimum_wage_cell->setFormula1('yesno');


                    /* DEPARTMENT ROW */
                    $department_cell = $sheet->getCell('AA'.$rowcell)->getDataValidation();
                    $department_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $department_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $department_cell->setAllowBlank(false);
                    $department_cell->setShowInputMessage(true);
                    $department_cell->setShowErrorMessage(true);
                    $department_cell->setShowDropDown(true);
                    $department_cell->setErrorTitle('Input error');
                    $department_cell->setError('Value is not in list.');
                    $department_cell->setFormula1('department');

                    /* POSITION ROW */
                    $position_cell = $sheet->getCell('AB'.$rowcell)->getDataValidation();
                    $position_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $position_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $position_cell->setAllowBlank(false);
                    $position_cell->setShowInputMessage(true);
                    $position_cell->setShowErrorMessage(true);
                    $position_cell->setShowDropDown(true);
                    $position_cell->setErrorTitle('Input error');
                    $position_cell->setError('Value is not in list.');
                    $position_cell->setFormula1('position');


                    /* EMPLOYMENT STATUS ROW */
                    $employement_status_cell = $sheet->getCell('AD'.$rowcell)->getDataValidation();
                    $employement_status_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $employement_status_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $employement_status_cell->setAllowBlank(false);
                    $employement_status_cell->setShowInputMessage(true);
                    $employement_status_cell->setShowErrorMessage(true);
                    $employement_status_cell->setShowDropDown(true);
                    $employement_status_cell->setErrorTitle('Input error');
                    $employement_status_cell->setError('Value is not in list.');
                    $employement_status_cell->setFormula1('status');


                    /* NBI ROW */
                    $nbiyesno_cell = $sheet->getCell('AI'.$rowcell)->getDataValidation();
                    $nbiyesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $nbiyesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $nbiyesno_cell->setAllowBlank(false);
                    $nbiyesno_cell->setShowInputMessage(true);
                    $nbiyesno_cell->setShowErrorMessage(true);
                    $nbiyesno_cell->setShowDropDown(true);
                    $nbiyesno_cell->setErrorTitle('Input error');
                    $nbiyesno_cell->setError('Value is not in list.');
                    $nbiyesno_cell->setFormula1('yesno');


                    /* HEALTH CERTIFICATE ROW */
                    $healthcert_yesno_cell = $sheet->getCell('AJ'.$rowcell)->getDataValidation();
                    $healthcert_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $healthcert_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $healthcert_yesno_cell->setAllowBlank(false);
                    $healthcert_yesno_cell->setShowInputMessage(true);
                    $healthcert_yesno_cell->setShowErrorMessage(true);
                    $healthcert_yesno_cell->setShowDropDown(true);
                    $healthcert_yesno_cell->setErrorTitle('Input error');
                    $healthcert_yesno_cell->setError('Value is not in list.');
                    $healthcert_yesno_cell->setFormula1('yesno');


                    /* BIODATA ROW */
                    $boidata_yesno_cell = $sheet->getCell('AK'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('yesno');

                     /* BIODATA ROW */
                    $boidata_yesno_cell = $sheet->getCell('AL'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('yesno');

                     /* BIODATA ROW */
                    $boidata_yesno_cell = $sheet->getCell('AM'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('yesno');

                     /* BIODATA ROW */
                    $boidata_yesno_cell = $sheet->getCell('AN'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('yesno');

                    /* DEPENDENT RELATIONSHIP 1 */
                    $boidata_yesno_cell = $sheet->getCell('AP'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('relotionship');

                    /* DEPENDENT RELATIONSHIP 2 */
                    $boidata_yesno_cell = $sheet->getCell('AS'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('relotionship');

                    /* DEPENDENT RELATIONSHIP 3 */
                    $boidata_yesno_cell = $sheet->getCell('AV'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('relotionship');

                    /* DEPENDENT RELATIONSHIP 4 */
                    $boidata_yesno_cell = $sheet->getCell('AY'.$rowcell)->getDataValidation();
                    $boidata_yesno_cell->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $boidata_yesno_cell->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $boidata_yesno_cell->setAllowBlank(false);
                    $boidata_yesno_cell->setShowInputMessage(true);
                    $boidata_yesno_cell->setShowErrorMessage(true);
                    $boidata_yesno_cell->setShowDropDown(true);
                    $boidata_yesno_cell->setErrorTitle('Input error');
                    $boidata_yesno_cell->setError('Value is not in list.');
                    $boidata_yesno_cell->setFormula1('relotionship');
                }

               });

            /* DATA VALIDATION (REFERENCE FOR DROPDOWN LIST) */
            $excel->sheet('reference', function($sheet) {

                $_company 		= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('payroll_company_name')->get();

                $_status 		= Tbl_payroll_employment_status::get();
                $_department  	= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
                $_position 		= Tbl_payroll_jobtitle::sel(Self::shop_id())->orderBy('payroll_jobtitle_name')->get();

                $_country 		= Tbl_country::get();

                /* COMPANY/CLIENT REFERENCES */
                $sheet->SetCellValue("A1", "Client");
                $client_number = 2;
                foreach($_company as $company)
                {
                    $sheet->SetCellValue("A".$client_number, $company->payroll_company_name);
                    $client_number++;
                }
                $client_number--;

                /* EMPLOYMENT STATUS REFERENCES */
                $sheet->SetCellValue("B1", "Employment Status");
                $emp_status_number = 2;
                foreach($_status as $status)
                {
                    $sheet->SetCellValue("B".$emp_status_number, $status->employment_status);
                    $emp_status_number++;
                }
                $emp_status_number--;

                /* DEPARTMENT REFERENCE */
                $sheet->SetCellValue("G1", "Department");
                $department_number = 2;
                foreach($_department as $department)
                {
                    $sheet->SetCellValue("G".$department_number, $department->payroll_department_name);
                    $department_number++;
                }
                $department_number--;

                /* POSITION/JOB TITLE REFERENCE */
                $sheet->SetCellValue("H1", "Position");
                $position_number = 2;
                foreach($_position as $position)
                {
                    $sheet->SetCellValue("H".$position_number, $position->payroll_jobtitle_name);
                    $position_number++;
                }
                $position_number--;


                $sheet->SetCellValue('J1','Country');
                $country_number = 2;
                foreach($_country as $country)
                {
                	$sheet->SetCellValue("J".$country_number, $country->country_name);
                	$country_number++;
                }
                $country_number--;

                /* GENDER REFERENCE */
                $sheet->SetCellValue("C1", "Gender");
                $sheet->SetCellValue("C2", "male");
                $sheet->SetCellValue("C3", "female");

                /* YES OR NO REFERENCE */
                $sheet->SetCellValue("D1", "Yes or No");
                $sheet->SetCellValue("D2", "Y");
                $sheet->SetCellValue("D3", "N");

                /* TAX STATUS REFERENCE */
                $sheet->SetCellValue("E1", "Tax Status");
                $sheet->SetCellValue("E2", "Z");
                $sheet->SetCellValue("E3", "S/ME");
                $sheet->SetCellValue("E4", "S1/ME1");
                $sheet->SetCellValue("E5", "S2/ME2");
                $sheet->SetCellValue("E6", "S3/ME3");
                $sheet->SetCellValue("E7", "S4/ME4");

                /* CIVIL STATUS REFERENCE */
                $sheet->SetCellValue("F1", "Civil Status");
                $sheet->SetCellValue("F2", "Single");
                $sheet->SetCellValue("F3", "Married");
                $sheet->SetCellValue("F4", "Divorced");
                $sheet->SetCellValue("F5", "Separated");
                $sheet->SetCellValue("F6", "Widowed");

                /* RELATIONSHIP */
                $sheet->SetCellValue("I1", "Relationship");
                $sheet->SetCellValue("I2", "Father");
                $sheet->SetCellValue("I3", "Mother");
                $sheet->SetCellValue("I4", "Spouse");
                $sheet->SetCellValue("I5", "Child");


                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'client', $sheet, 'A2:A'.$client_number
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'status', $sheet, 'B2:B'.$emp_status_number
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'gender', $sheet, 'C2:C3'
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'yesno', $sheet, 'D2:D3'
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'taxstatus', $sheet, 'E2:E7'
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'civilstatus', $sheet, 'F2:F6'
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'department', $sheet, 'G2:G'.$department_number
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'position', $sheet, 'H2:H'.$position_number
                    )
                );

                $sheet->_parent->addNamedRange(
                    new \PHPExcel_NamedRange(
                    'relotionship', $sheet, 'I2:I5'
                    )
                );

               	$sheet->_parent->addNamedRange(
               		new \PHPExcel_NamedRange(
                    'country', $sheet, 'J2:J'.$country_number
                    )
               	);


            });


        })->download('xlsx');
	}

	public function import_201_template()
	{
		$file = Request::file('file');
		$_data = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->all();
		$first = $_data[0]; 
          // dd($_data);
		/* check index exist */
		
		if(isset($first['company']) && isset($first['first_name']) && isset($first['department']) && isset($first['start_date']))
		{	
			$count = 0;
			foreach($_data as $data)
			{
				$count_employee = Tbl_payroll_employee_basic::where('payroll_employee_company_id',Self::getid($data['company'], 'company'))
												   ->where('payroll_employee_first_name',Self::nullableToString($data['first_name']))
												   ->where('payroll_employee_middle_name', Self::nullableToString($data['middle_name']))
												   ->where('payroll_employee_last_name',Self::nullableToString($data['last_name']))
												   ->count();
				// dd($count_employee);
				if($count_employee == 0)
				{
					/* EMPLOYEE BASIC INSERT START */
                         $insert['shop_id']                                = Self::shop_id();
                         $insert['payroll_employee_company_id']       = Self::getid($data['company'], 'company');
                         $insert['payroll_employee_title_name']       = Self::nullableToString($data['title_name']);
                         $insert['payroll_employee_first_name']       = Self::nullableToString($data['first_name']);
                         $insert['payroll_employee_middle_name']      = Self::nullableToString($data['middle_name']);
                         $insert['payroll_employee_last_name']        = Self::nullableToString($data['last_name']);
                         $insert['payroll_employee_suffix_name']      = Self::nullableToString($data['suffix_name']);
                         $insert['payroll_employee_display_name']     = Self::nullableToString($data['title_name']).' '.Self::nullableToString($data['first_name']).' '.Self::nullableToString($data['middle_name']).' '.Self::nullableToString($data['last_name']).' '.Self::nullableToString($data['suffix_name']);

                         $insert['payroll_employee_contact']          = Self::nullableToString($data['contact']);
                         $insert['payroll_employee_email']            = Self::nullableToString($data['email_address']);
                         $insert['payroll_employee_birthdate']        = Self::nullableToString($data['birthdate']);
                         $insert['payroll_employee_gender']                = Self::nullableToString($data['gender_mf']);
                         $insert['payroll_employee_number']                = Self::nullableToString($data['employee_number']);
                         $insert['payroll_employee_atm_number']       = Self::nullableToString($data['atmaccount_number']);
                         $insert['payroll_employee_street']                = Self::nullableToString($data['street']);
                         $insert['payroll_employee_city']             = Self::nullableToString($data['citytown']);
                         $insert['payroll_employee_state']            = Self::nullableToString($data['stateprovince']);
                         $insert['payroll_employee_zipcode']          = Self::nullableToString($data['zip_code']);
                         $insert['payroll_employee_country']          = Self::getid($data['country'], 'country');
                         $insert['payroll_employee_tax_status']       = Self::nullableToString($data['tax_status']);
                         $insert['payroll_employee_tin']              = Self::nullableToString($data['tin']);
                         $insert['payroll_employee_sss']              = Self::nullableToString($data['sss_number']);
                         $insert['payroll_employee_pagibig']          = Self::nullableToString($data['pagibig_number']);
                         $insert['payroll_employee_philhealth']       = Self::nullableToString($data['philhealth_number']);
                         $insert['payroll_employee_remarks']          = Self::nullableToString($data['remarks']);


                         if(Self::getid($data['company'], 'company') != null && Self::checkemployee_exist($insert) == 0)
                         {
                              
                              // dd($insert);

                              $payroll_employee_id = Tbl_payroll_employee_basic::insertGetId($insert);
                              /* EMPLOYEE BASIC INSERT END */

                              /*   EMPLOYEE CONTRACT START */
                              $insert_contract['payroll_employee_id']                          = $payroll_employee_id;
                              $insert_contract['payroll_department_id']                        = Self::getid($data['department'],'department');
                              $insert_contract['payroll_jobtitle_id']                          = Self::getid($data['position'],'jobtitle');
                              $insert_contract['payroll_employee_contract_date_hired']    = Self::nullableToString($data['start_date']);
                              $insert_contract['payroll_employee_contract_status']        = Self::getid($data['employment_status'],'employment_status');

                              Tbl_payroll_employee_contract::insert($insert_contract);

                              /*   EMPLOYEE CONTRACT END */


                              /* EMPLOYEE SALARY START */
                              $insert_salary['payroll_employee_id']                            = $payroll_employee_id;
                              $insert_salary['payroll_employee_salary_effective_date']    = Self::nullableToString($data['start_date']);
                              $insert_salary['payroll_employee_salary_minimum_wage']           = Self::yesNotoInt($data['minimum_wage_yn']);
                              $insert_salary['payroll_employee_salary_monthly']                = Self::nullableToString($data['monthly_salary'],'int');
                              $insert_salary['payroll_employee_salary_daily']             = Self::nullableToString($data['daily_rate'],'int');
                              $insert_salary['payroll_employee_salary_taxable']                = Self::nullableToString($data['taxable_salary'],'int');
                              $insert_salary['payroll_employee_salary_sss']                    = Self::nullableToString($data['sss_salary'],'int');
                              $insert_salary['payroll_employee_salary_pagibig']                = Self::nullableToString($data['hdmf_salary'],'int');
                              $insert_salary['payroll_employee_salary_philhealth']        = Self::nullableToString($data['phic_salary'],'int');

                              Tbl_payroll_employee_salary::insert($insert_salary);
                              /* EMPLOYEE SALARY END */

                              /* EMPLOYEE  REQUIREMENTS START*/
               
                              $insert_requirement['payroll_employee_id']        = $payroll_employee_id;
                              $insert_requirement['has_resume']                 = Self::yesNotoInt($data['biodataresumeyn'],'int');
                              $insert_requirement['has_police_clearance']  = Self::yesNotoInt($data['police_clearanceyn'],'int');
                              $insert_requirement['has_nbi']                         = Self::yesNotoInt($data['nbiyn'],'int');
                              $insert_requirement['has_health_certificate']     = Self::yesNotoInt($data['health_certificateyn'],'int');
                              $insert_requirement['has_school_credentials']     = Self::yesNotoInt($data['school_credentialsyn'],'int');
                              $insert_requirement['has_valid_id']               = Self::yesNotoInt($data['valid_idyn'],'int');

                              Tbl_payroll_employee_requirements::insert($insert_requirement);
                              /* EMPLOYEE  REQUIREMENTS END*/


                              /* EMPLOYEE DEPENDENT START */
                              $insert_dependent = array();
                              $temp = '';
                              for($i = 1; $i <= 4; $i++)
                              {
                                   if($data['dependent_full_name'.$i] != null || $data['dependent_full_name'.$i] != "")
                                   {
                                        $temp['payroll_employee_id']            = $payroll_employee_id;
                                        $temp['payroll_dependent_name']         = Self::nullableToString($data['dependent_full_name'.$i]);
                                        $temp['payroll_dependent_relationship'] = Self::nullableToString($data['dependent_relationship'.$i]);
                                        $temp['payroll_dependent_birthdate']    = Self::nullableToString($data['dependent_birthdate'.$i]);
                                        array_push($insert_dependent, $temp);
                                   }
                              }
                              
                              if(!empty($insert_dependent))
                              {
                                   Tbl_payroll_employee_dependent::insert($insert_dependent);
                              }
                              
                              $count++;
                         }
					
					/* EMPLOYEE DEPENDENT END */
				}
				
			}	

			$message = '<center><b><span class="color-green">'.$count.' Employee/s has been inserted.</span></b></center>';
			$return['status'] = 'success';
			if($count == 0)
			{
				$message = '<center><b><span class="color-gray">There is nothing to insert</span></b></center>';
				$return['status'] = 'none';
			}
			$return['message'] = $message;


			return $return;
		}
		else
		{
			$return['status'] 	= 'error';
			$return['message'] 	= '<center><b><span class="color-red">Wrong file Format</span></b></center>';
			return $return;
		}
	}

	public function getid($str_name = '', $str_param = '')
	{
		$id = 0;

		switch ($str_param) {
			case 'country':
				$id = Tbl_country::where('country_name', $str_name)->pluck('country_id');
				return $id;
				break;

			case 'company':
				$id = Tbl_payroll_company::where('payroll_company_name', $str_name)->where('shop_id', Self::shop_id())->pluck('payroll_company_id');
				return $id;

				break;

			case 'department':
				$id = Tbl_payroll_department::where('payroll_department_name', $str_name)->where('shop_id', Self::shop_id())->pluck('payroll_department_id');
				return $id;
				break;

			case 'jobtitle':
				$id = Tbl_payroll_jobtitle::where('payroll_jobtitle_name', $str_name)->where('shop_id', Self::shop_id())->pluck('payroll_jobtitle_id');
				return $id;
				break;

			case 'employment_status':
				$id = Tbl_payroll_employment_status::where('employment_status', $str_name)->pluck('payroll_employment_status_id');
				return $id;
				break;
			
			default:
				$id = 0;
				return $id;
				break;
		}
	}

     public function checkemployee_exist($data = array())
     {
          $check['payroll_employee_company_id'] = $data['payroll_employee_company_id'];
          $check['payroll_employee_title_name'] = $data['payroll_employee_title_name'];
          $check['payroll_employee_first_name'] = $data['payroll_employee_first_name'];
          $check['payroll_employee_middle_name'] = $data['payroll_employee_middle_name'];
          $check['payroll_employee_last_name'] = $data['payroll_employee_last_name'];
          $check['payroll_employee_suffix_name'] = $data['payroll_employee_suffix_name'];
          $check['payroll_employee_number'] = $data['payroll_employee_number'];
          
          return Tbl_payroll_employee_basic::checkexist($check)->count();
     }

	public function nullableToString($data = null, $output = 'string')
	{

		if($data == null && $output == 'string')
		{
			$data = '';
		}
		else if($data == null && $output == 'int')
		{
			$data = 0;
		}

		return $data;
	}

	public function yesNotoInt($stryn = 'Y')
	{
		$int = 0;
		$stryn = strtoupper($stryn);
		if($stryn == 'Y' || $stryn == 'YES' || $stryn == 'TRUE')
		{
			$int = 1;
		}
		return $int;
	}

	/* IMPORT EMPLOYEE DATA FROM EXCEL END */

	public function modal_create_employee()
	{
		// $data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

          $data['_company']  = Payroll::company_heirarchy(Self::shop_id());

		$data['employement_status'] = Tbl_payroll_employment_status::get();
		$data['tax_status'] = Tbl_payroll_tax_status::get();
		$data['civil_status'] = Tbl_payroll_civil_status::get();
		$data['_country'] = Tbl_country::orderBy('country_name')->get();
		$data['_department'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['_group'] = Tbl_payroll_group::sel(Self::shop_id())->orderBy('payroll_group_code')->get();
		$data['_allowance'] = Tbl_payroll_allowance::sel(Self::shop_id())->orderBy('payroll_allowance_name')->get();
		$data['_deduction'] = Tbl_payroll_deduction::seldeduction(Self::shop_id())->orderBy('payroll_deduction_name')->get();
		$data['_leave'] = Tbl_payroll_leave_temp::sel(Self::shop_id())->orderBy('payroll_leave_temp_name')->get();
          $data['_journal_tag'] = Tbl_payroll_journal_tag::gettag(Self::shop_id())->orderBy('tbl_chart_of_account.account_name')->get();

		return view("member.payroll.modal.modal_create_employee", $data);
	}


	public function employee_updload_requirements()
	{
		$file = Request::file('file');
		// dd($file);

		$requirement_original_name 	= $file->getClientOriginalName();
		$requirement_extension_name   = $file->getClientOriginalExtension();
		$requirement_mime_type		= $file->getMimeType();

		$requirement_new_name 		= value(function() use ($file){
          $filename = str_random(10). date('ymdhis') . '.' . $file->getClientOriginalExtension();
          return strtolower($filename);
        });

        $path = '/assets/payroll/employee_requirements';
        if (!file_exists($path)) {
		    mkdir($path, 0777, true);
		}
        $upload_success = $file->move(public_path($path), $requirement_new_name);

        $data = array();
        $status = 'error';
        if($upload_success)
        {

        	$insert['shop_id'] 								= Self::shop_id();
        	$insert['payroll_requirements_path']	 		= $path.'/'.$requirement_new_name;
        	$insert['payroll_requirements_original_name'] 	= $requirement_original_name;
        	$insert['payroll_requirements_extension_name'] 	= $requirement_extension_name;
        	$insert['payroll_requirements_mime_type'] 		= $requirement_mime_type;
        	$insert['payroll_requirements_date_upload'] 	= Carbon::now();

        	$payroll_requirements_id = Tbl_payroll_requirements::insertGetId($insert);

        	$data['path'] 					= $path.'/'.$requirement_new_name;
	        $data['original_name'] 			= $requirement_original_name;
	        $data['extension'] 				= $requirement_extension_name;
	        $data['mime_type'] 				= $requirement_mime_type;
	        $data['payroll_requirements_id'] = $payroll_requirements_id;
	        $status = 'success';
        }
        

        $return['status'] = $status;
        $return['data']	   = $data;

        return json_encode($return);
	}


	public function remove_employee_requirement()
	{
		$payroll_requirements_id = Request::input("content");
		$path = Tbl_payroll_requirements::where('payroll_requirements_id',$payroll_requirements_id)->pluck('payroll_requirements_path');
		Tbl_payroll_requirements::where('payroll_requirements_id',$payroll_requirements_id)->delete();
	}

	public function modal_employee_save()
	{
		/* employee basic info */
		$insert['shop_id']							= Self::shop_id();
		$insert['payroll_employee_title_name'] 		= Request::input('payroll_employee_title_name');
		$insert['payroll_employee_first_name'] 		= Request::input('payroll_employee_first_name');
		$insert['payroll_employee_middle_name'] 	= Request::input('payroll_employee_middle_name');
		$insert['payroll_employee_last_name'] 		= Request::input('payroll_employee_last_name');
		$insert['payroll_employee_suffix_name'] 	= Request::input('payroll_employee_suffix_name');
		$insert['payroll_employee_number'] 			= Request::input('payroll_employee_number');
		$insert['payroll_employee_atm_number'] 		= Request::input('payroll_employee_atm_number');
		$insert['payroll_employee_company_id'] 		= Request::input('payroll_employee_company_id');
		$insert['payroll_employee_contact'] 		= Request::input('payroll_employee_contact');
		$insert['payroll_employee_email'] 			= Request::input('payroll_employee_email');
		$insert['payroll_employee_display_name'] 	= Request::input('payroll_employee_display_name');
		$insert['payroll_employee_gender'] 			= Request::input('payroll_employee_gender');
		$insert['payroll_employee_birthdate'] 		= date('Y-m-d',strtotime(Request::input('payroll_employee_birthdate')));
		$insert['payroll_employee_street'] 			= Request::input('payroll_employee_street');
		$insert['payroll_employee_city'] 			= Request::input('payroll_employee_city');
		$insert['payroll_employee_state'] 			= Request::input('payroll_employee_state');
		$insert['payroll_employee_zipcode'] 		= Request::input('payroll_employee_zipcode');
		$insert['payroll_employee_country'] 		= Request::input('payroll_employee_country');
		$insert['payroll_employee_tax_status'] 		= Request::input('payroll_employee_tax_status');
		$insert['payroll_employee_tin'] 			= Request::input('payroll_employee_tin');
		$insert['payroll_employee_sss'] 			= Request::input('payroll_employee_sss');
		$insert['payroll_employee_philhealth'] 		= Request::input('payroll_employee_philhealth');
		$insert['payroll_employee_pagibig'] 		= Request::input('payroll_employee_pagibig');
		$insert['payroll_employee_remarks'] 		= Request::input('payroll_employee_remarks');

		$payroll_employee_id = Tbl_payroll_employee_basic::insertGetId($insert);


		/* employee contract */
		$insert_contract['payroll_employee_id']						= $payroll_employee_id;
		$insert_contract['payroll_department_id'] 					= Request::input("payroll_department_id");
		$insert_contract['payroll_jobtitle_id'] 					= Request::input("payroll_jobtitle_id");
		$insert_contract['payroll_employee_contract_date_hired'] 	= Request::input("payroll_employee_contract_date_hired");
		$insert_contract['payroll_employee_contract_date_end'] 		= Request::input("payroll_employee_contract_date_end");
		$insert_contract['payroll_employee_contract_status'] 		= Request::input("payroll_employee_contract_status");
		$insert_contract['payroll_group_id'] 						= Request::input("payroll_group_id");

		Tbl_payroll_employee_contract::insert($insert_contract);


		/* employee salary details */
		$insert_salary['payroll_employee_id'] 						= $payroll_employee_id;
		$insert_salary['payroll_employee_salary_effective_date'] 	= date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_hired')));
		$payroll_employee_salary_minimum_wage = 0;
		if(Request::has('payroll_employee_salary_minimum_wage'))
		{
			$payroll_employee_salary_minimum_wage 					= Request::input('payroll_employee_salary_minimum_wage');
		}


		$insert_salary['payroll_employee_salary_minimum_wage'] 		= $payroll_employee_salary_minimum_wage;
		$insert_salary['payroll_employee_salary_monthly'] 			= Request::input('payroll_employee_salary_monthly');
		$insert_salary['payroll_employee_salary_daily'] 			= Request::input('payroll_employee_salary_daily');
		$insert_salary['payroll_employee_salary_taxable'] 			= Request::input('payroll_employee_salary_taxable');
		$insert_salary['payroll_employee_salary_sss'] 				= Request::input('payroll_employee_salary_sss');
		$insert_salary['payroll_employee_salary_pagibig'] 			= Request::input('payroll_employee_salary_pagibig');
		$insert_salary['payroll_employee_salary_philhealth'] 		= Request::input('payroll_employee_salary_philhealth');
		$insert_salary['payroll_employee_salary_cola']				= Request::input('payroll_employee_salary_cola');

		Tbl_payroll_employee_salary::insert($insert_salary);


		
		$has_resume = 0;
		if(Request::has('has_resume'))
		{
			$has_resume = Request::input('has_resume');
		}

		$has_police_clearance = 0;
		if(Request::has('has_police_clearance'))
		{
			$has_police_clearance = Request::input('has_police_clearance');
		}

		$has_nbi = 0;
		if(Request::has('has_nbi'))
		{
			$has_nbi = Request::input('has_nbi');
		}

		$has_health_certificate = 0;
		if(Request::has('has_health_certificate'))
		{
			$has_health_certificate = Request::input('has_health_certificate');
		}

		$has_school_credentials = 0;
		if(Request::has('has_school_credentials'))
		{
			$has_school_credentials = Request::input('has_school_credentials');
		}

		$has_valid_id = 0;
		if(Request::has('has_valid_id'))
		{
			$has_valid_id = Request::input('has_valid_id');
		}

		$insert_requirements['payroll_employee_id']					= $payroll_employee_id;
		$insert_requirements['has_resume'] 							= $has_resume;
		$insert_requirements['resume_requirements_id'] 				= Request::input('resume_requirements_id');
		$insert_requirements['has_police_clearance'] 				= $has_police_clearance;
		$insert_requirements['police_clearance_requirements_id'] 	= Request::input('police_clearance_requirements_id');
		$insert_requirements['has_nbi'] 							= $has_nbi;
		$insert_requirements['nbi_payroll_requirements_id'] 		= Request::input('nbi_payroll_requirements_id');
		$insert_requirements['has_health_certificate'] 				= $has_health_certificate;
		$insert_requirements['health_certificate_requirements_id'] 	= Request::input('health_certificate_requirements_id');
		$insert_requirements['has_school_credentials'] 				= $has_school_credentials;
		$insert_requirements['school_credentials_requirements_id'] 	= Request::input('school_credentials_requirements_id');
		$insert_requirements['has_valid_id'] 						= $has_valid_id;
		$insert_requirements['valid_id_requirements_id'] 			= Request::input('valid_id_requirements_id');
		Tbl_payroll_employee_requirements::insert($insert_requirements);


		$payroll_dependent_name 		= Request::input('payroll_dependent_name');
		$payroll_dependent_birthdate 	= Request::input('payroll_dependent_birthdate');
		$payroll_dependent_relationship = Request::input('payroll_dependent_relationship');


		$insert_dependent = array();

		$temp = "";
		foreach($payroll_dependent_name as $key => $dependent)
		{
			if($dependent != "")
			{
				$temp['payroll_employee_id']			= $payroll_employee_id;
				$temp['payroll_dependent_name'] 		= $dependent;

				$birthdate = '';
				if($payroll_dependent_birthdate[$key] != '')
				{	
					$birthdate 							= date('Y-m-d',strtotime($payroll_dependent_birthdate[$key]));
				}

				$temp['payroll_dependent_birthdate'] 	= $birthdate;
				$temp['payroll_dependent_relationship'] = $payroll_dependent_relationship[$key];

				array_push($insert_dependent, $temp);
			}
		}

		Tbl_payroll_employee_dependent::insert($insert_dependent);


		/* INSERT ALLOWANCES */
		$_allowance = array();
		if(Request::has('allowance'))
		{
			$_allowance = Request::input('allowance');
		}

		$insert_allowance = array();
		$temp = "";
		foreach ($_allowance as $allowance) {
			$temp['payroll_allowance_id']	= $allowance;
			$temp['payroll_employee_id'] 	= $payroll_employee_id;
			array_push($insert_allowance, $temp);
		}
		if(!empty($insert_allowance))
		{
			Tbl_payroll_employee_allowance::insert($insert_allowance);
		}
		

		/* INSERT LEAVES */
		$_leave = array();
		if(Request::has('leave'))
		{
			$_leave = Request::input('leave');
		}

		$insert_leave = array();
		$temp = '';
		foreach($_leave as $leave)
		{
			$temp['payroll_leave_temp_id'] 	= $leave;
			$temp['payroll_employee_id'] 	= $payroll_employee_id;
			array_push($insert_leave, $temp);
		}

		if(!empty($insert_leave))
		{
			Tbl_payroll_leave_employee::insert($insert_leave);
		}

		/* INSERT DEDUCTION */
		$_deduction = array();
		if(Request::has('deduction'))
		{
			$_deduction = Request::input('deduction');
		}
		$insert_deduction = array();
		$temp = '';
		foreach($_deduction as $deduction)
		{
			$temp['payroll_deduction_id']   = $deduction;
			$temp['payroll_employee_id']    = $payroll_employee_id;
			array_push($insert_deduction, $temp);
		}
		if(!empty($insert_deduction))
		{
			Tbl_payroll_deduction_employee::insert($insert_deduction);
		}


          /* INSERT JOURNAL TAGS */
          if(Request::has('journal_tag'))
          {

               $insert_journal = array();
               foreach(Request::input('journal_tag') as $tag){
                    $temp_journal['payroll_employee_id']    = $payroll_employee_id;
                    $temp_journal['payroll_journal_tag_id'] = $tag;
                    array_push($insert_journal, $temp_journal);
               }

               if(!empty($insert_journal))
               {
                    Tbl_payroll_journal_tag_employee::insert($insert_journal);
               }
          }


		$return['data'] = '';
		$return['status'] = 'success';
		$return['function_name'] = 'employeelist.reload_employee_list';

		return json_encode($return);

	}

	public function modal_employee_view($id)
	{

		// $data['_company'] 			= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

          $data['_company']  = Payroll::company_heirarchy(Self::shop_id());

		$data['employement_status']   = Tbl_payroll_employment_status::get();
		$data['tax_status'] 		= Tbl_payroll_tax_status::get();
		$data['civil_status'] 		= Tbl_payroll_civil_status::get();
		$data['_country'] 			= Tbl_country::orderBy('country_name')->get();
		$data['_department'] 		= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['_jobtitle']			= Tbl_payroll_jobtitle::sel(Self::shop_id())->orderBy('payroll_jobtitle_name')->get();

		$data['employee'] 			= Tbl_payroll_employee_basic::where('payroll_employee_id',$id)->first();
		$data['contract'] 			= Tbl_payroll_employee_contract::selemployee($id)->first();

		$data['salary']				= Tbl_payroll_employee_salary::selemployee($id)->first();
		$data['requirement']		= Tbl_payroll_employee_requirements::selrequirements($id)->first();
		$data['_group']               = Tbl_payroll_group::sel(Self::shop_id())->orderBy('payroll_group_code')->get();
		$data['dependent']			= Tbl_payroll_employee_dependent::where('payroll_employee_id', $id)->get();

          $data['_allowance']           = Self::check_if_allowance_selected($id);
          $data['_deduction']           = Self::check_if_deduction_selected($id);
          $data['_leave']               = Self::check_if_leave_selected($id);

          $_journal_tag                 = Tbl_payroll_journal_tag::gettag(Self::shop_id())->orderBy('tbl_chart_of_account.account_name')->get()->toArray();

          $data['_journal_tag']         = array();
          foreach($_journal_tag as $tag)
          {
               $count_tag = Tbl_payroll_journal_tag_employee::checkdata($id, $tag['payroll_journal_tag_id'])->count(); 
               $tag['status'] = '';
               if($count_tag == 1)
               {
                    $tag['status'] = 'checked';
               }

               array_push($data['_journal_tag'], $tag);
          }

          // dd($data);
		return view("member.payroll.modal.modal_view_employee", $data);
	}

     public function check_if_allowance_selected($employee_id = 0)
     {
          $data = array();
          $_allowance = Tbl_payroll_allowance::sel(Self::shop_id())->orderBy('payroll_allowance_name')->get()->toArray();
          foreach($_allowance as $allowance)
          {
               $allowance['status_checked'] = '';
               $check = Tbl_payroll_employee_allowance::checkallowance($employee_id, $allowance['payroll_allowance_id'])->count();
               if($check == 1)
               {
                    $allowance['status_checked'] = 'checked';
               }
               array_push($data, $allowance);

          }
          return $data;
     }

     public function check_if_deduction_selected($employee_id = 0)
     {
          $data = array();
          $_deduction = Tbl_payroll_deduction::seldeduction(Self::shop_id())->orderBy('payroll_deduction_name')->get()->toArray();
          foreach($_deduction as $deduction)
          {
               $deduction['status_checked'] = '';
               $check = Tbl_payroll_deduction_employee::checkdeduction($employee_id, $deduction['payroll_deduction_id'])->count();
               if($check == 1)
               {
                    $deduction['status_checked'] = 'checked';
               }
               array_push($data, $deduction);
          }
          return $data;
     }

     public function check_if_leave_selected($employee_id = 0)
     {
          $data = array();
          $_leave = Tbl_payroll_leave_temp::sel(Self::shop_id())->orderBy('payroll_leave_temp_name')->get()->toArray();
          foreach($_leave as $leave)
          {
               $leave['status_checked'] = '';
               $check = Tbl_payroll_leave_employee::checkleave($employee_id, $leave['payroll_leave_temp_id'])->count();
               if($check == 1)
               {
                    $leave['status_checked'] = 'checked';
               }
               array_push($data, $leave);
          }
          // dd($data);
          return $data;
     }

	public function modal_view_contract_list($id)
	{
		$data['_active'] 		= Tbl_payroll_employee_contract::contractlist($id)->get();
		$data['_archived'] 		= Tbl_payroll_employee_contract::contractlist($id, 1)->get();
		$data['employee_id'] 	= $id;
		return view('member.payroll.modal.modal_view_contract_list', $data);
	}

	public function modal_edit_contract($employee_id ,$id)
	{
		$data['employee_id'] 		= $employee_id;
		$data['contract'] 			= Tbl_payroll_employee_contract::where('payroll_employee_contract_id',$id)->first();
		$data['employement_status'] = Tbl_payroll_employment_status::get();
		$data['_department'] 		= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['_jobtitle']			= Tbl_payroll_jobtitle::sel(Self::shop_id())->orderBy('payroll_jobtitle_name')->get();

		$data['_group'] 			= Tbl_payroll_group::sel(Self::shop_id())->orderBy('payroll_group_code')->get();

		return view('member.payroll.modal.modal_edit_contract', $data);
	}

	public function modal_update_contract()
	{
		$payroll_employee_contract_id 					= Request::input('payroll_employee_contract_id');
		$update['payroll_department_id'] 				= Request::input('payroll_department_id');
		$update['payroll_jobtitle_id'] 					= Request::input('payroll_jobtitle_id');
		$update['payroll_employee_contract_date_hired'] = date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_hired')));
		$payroll_employee_contract_date_end				= '';
		if(Request::input('payroll_employee_contract_date_end') != '')
		{
			$payroll_employee_contract_date_end 	= date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_end')));
		}

		$update['payroll_employee_contract_date_end'] 	= $payroll_employee_contract_date_end;
		$update['payroll_group_id'] 					= Request::input('payroll_group_id');
		$update['payroll_employee_contract_status'] 	= Request::input('payroll_employee_contract_status');

		Tbl_payroll_employee_contract::where('payroll_employee_contract_id', $payroll_employee_contract_id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'employeelist.reload_contract_list';
		return json_encode($return);
	}

	public function modal_archive_contract($archived, $payroll_employee_contract_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$data['title'] 		= 'Do you really want to '.$statement.' this contract?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/employee_list/archive_contract';
		$data['id'] 		= $payroll_employee_contract_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archive_contract()
	{
		$update['payroll_employee_contract_archived'] 	= Request::input('archived');
		$id 									= Request::input('id');
		Tbl_payroll_employee_contract::where('payroll_employee_contract_id',$id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'employeelist.reload_contract_list';
		return json_encode($return);
	}

	public function modal_create_contract($id)
	{
		$data['employee_id'] 		= $id;
		$data['employement_status'] = Tbl_payroll_employment_status::get();
		$data['_department'] 		= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['_group'] 			= Tbl_payroll_group::sel(Self::shop_id())->orderBy('payroll_group_code')->get();
		return view('member.payroll.modal.modal_create_contract',$data);
	}

	public function modal_save_contract()
	{
		$insert['payroll_employee_id'] 					= Request::input('payroll_employee_id');
		$insert['payroll_department_id'] 				= Request::input('payroll_department_id');
		$insert['payroll_jobtitle_id'] 					= Request::input('payroll_jobtitle_id');
		$insert['payroll_employee_contract_date_hired'] = date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_hired')));
		$insert['payroll_employee_contract_date_end'] 	= date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_end')));
		$insert['payroll_group_id'] 					= Request::input('payroll_group_id');
		$insert['payroll_employee_contract_status'] 	= Request::input('payroll_employee_contract_status');
		Tbl_payroll_employee_contract::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}


	public function modal_salary_list($id)
	{	
		$data['_active'] = Tbl_payroll_employee_salary::salaylist($id)->get();
		$data['_archived'] = Tbl_payroll_employee_salary::salaylist($id, 1)->get();
		return view('member.payroll.modal.modal_salary_list', $data);
	}

	public function modal_create_salary_adjustment($id)
	{
		$data['employee_id'] = $id;
		return view('member.payroll.modal.modal_create_salary', $data);
	}

	public function modal_edit_salary_adjustment($id)
	{
		$data['salary'] = Tbl_payroll_employee_salary::where('payroll_employee_salary_id',$id)->first();
		return view('member.payroll.modal.modal_edit_salary', $data);
	}

	public function modal_update_salary()
	{
		$payroll_employee_salary_id						= Request::input('payroll_employee_salary_id');
		$update['payroll_employee_salary_monthly'] 		= Request::input('payroll_employee_salary_monthly');
		$update['payroll_employee_salary_daily'] 		= Request::input('payroll_employee_salary_daily');
		$update['payroll_employee_salary_taxable'] 		= Request::input('payroll_employee_salary_taxable');
		$update['payroll_employee_salary_sss'] 			= Request::input('payroll_employee_salary_sss');
		$update['payroll_employee_salary_philhealth'] 	= Request::input('payroll_employee_salary_philhealth');
		$update['payroll_employee_salary_pagibig'] 		= Request::input('payroll_employee_salary_pagibig');
		$update['payroll_employee_salary_cola'] 		= Request::input('payroll_employee_salary_cola');
		
		$payroll_employee_salary_effective_date			= '';
		if(Request::input('payroll_employee_salary_effective_date') != '')
		{
			 $payroll_employee_salary_effective_date = date('Y-m-d',strtotime(Request::input('payroll_employee_salary_effective_date')));
		}
		
		$payroll_employee_salary_minimum_wage 			= 0;
		if(Request::has('payroll_employee_salary_minimum_wage'))
		{
			$payroll_employee_salary_minimum_wage 		= Request::has('payroll_employee_salary_minimum_wage');
		}
		$update['payroll_employee_salary_minimum_wage'] = $payroll_employee_salary_minimum_wage;
		$update['payroll_employee_salary_effective_date'] = $payroll_employee_salary_effective_date;

		Tbl_payroll_employee_salary::where('payroll_employee_salary_id',$payroll_employee_salary_id)->update($update);

		$return['function_name'] = 'employeelist.reload_salary_list';
		$return['status'] = 'success';
		return json_encode($return);
	}

	public function modal_archived_salary($archived, $id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$data['title'] 		= 'Do you really want to '.$statement.' this salary?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/employee_list/archived_salary';
		$data['id'] 		= $id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_salary()
	{
		$update['payroll_employee_salary_archived'] = Request::input('archived');
		$id 										= Request::input('id');
		Tbl_payroll_employee_salary::where('payroll_employee_salary_id',$id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'employeelist.reload_salary_list';
		return json_encode($return);
	}

	public function modal_save_salary()
	{
		$insert['payroll_employee_id'] 					= Request::input('payroll_employee_id');
		$insert['payroll_employee_salary_monthly'] 		= Request::input('payroll_employee_salary_monthly');
		$insert['payroll_employee_salary_daily'] 		= Request::input('payroll_employee_salary_daily');
		$insert['payroll_employee_salary_taxable'] 		= Request::input('payroll_employee_salary_taxable');
		$insert['payroll_employee_salary_sss'] 			= Request::input('payroll_employee_salary_sss');
		$insert['payroll_employee_salary_philhealth'] 	= Request::input('payroll_employee_salary_philhealth');
		$insert['payroll_employee_salary_pagibig'] 		= Request::input('payroll_employee_salary_pagibig');

		$payroll_employee_salary_minimum_wage = 0;
		if(Request::has('payroll_employee_salary_minimum_wage'))
		{
			$payroll_employee_salary_minimum_wage = Request::input('payroll_employee_salary_minimum_wage');
		}

		$insert['payroll_employee_salary_minimum_wage'] = $payroll_employee_salary_minimum_wage;
		$insert['payroll_employee_salary_effective_date'] = date('Y-m-d',strtotime(Request::input('payroll_employee_salary_effective_date')));
		$insert['payroll_employee_salary_cola']			= Request::input('payroll_employee_salary_cola');
		Tbl_payroll_employee_salary::insert($insert);
		$return['status'] = 'success';
		
		return json_encode($return);
	}

	public function modal_employee_update()
	{
		$payroll_employee_id 							= Request::input('payroll_employee_id');
		$update_basic['payroll_employee_title_name'] 	= Request::input('payroll_employee_title_name');
		$update_basic['payroll_employee_first_name'] 	= Request::input('payroll_employee_first_name');
		$update_basic['payroll_employee_middle_name'] 	= Request::input('payroll_employee_middle_name');
		$update_basic['payroll_employee_last_name'] 	= Request::input('payroll_employee_last_name');
		$update_basic['payroll_employee_suffix_name'] 	= Request::input('payroll_employee_suffix_name');
		$update_basic['payroll_employee_number'] 		= Request::input('payroll_employee_number');
		$update_basic['payroll_employee_atm_number'] 	= Request::input('payroll_employee_atm_number');
		$update_basic['payroll_employee_company_id'] 	= Request::input('payroll_employee_company_id');
		$update_basic['payroll_employee_contact'] 		= Request::input('payroll_employee_contact');
		$update_basic['payroll_employee_email'] 		= Request::input('payroll_employee_email');
		$update_basic['payroll_employee_display_name'] 	= Request::input('payroll_employee_display_name');
		$update_basic['payroll_employee_gender'] 		= Request::input('payroll_employee_gender');
		$update_basic['payroll_employee_street'] 		= Request::input('payroll_employee_street');
		$update_basic['payroll_employee_city'] 			= Request::input('payroll_employee_city');
		$update_basic['payroll_employee_state'] 		= Request::input('payroll_employee_state');
		$update_basic['payroll_employee_zipcode'] 		= Request::input('payroll_employee_zipcode');
		$update_basic['payroll_employee_country'] 		= Request::input('payroll_employee_country');
		$update_basic['payroll_employee_tax_status'] 	= Request::input('payroll_employee_tax_status');
		$update_basic['payroll_employee_tin'] 			= Request::input('payroll_employee_tin');
		$update_basic['payroll_employee_sss'] 			= Request::input('payroll_employee_sss');
		$update_basic['payroll_employee_philhealth'] 	= Request::input('payroll_employee_philhealth');
		$update_basic['payroll_employee_pagibig'] 		= Request::input('payroll_employee_pagibig');
		$update_basic['payroll_employee_remarks']		= Request::input('payroll_employee_remarks');

		Tbl_payroll_employee_basic::where('payroll_employee_id',$payroll_employee_id)->update($update_basic);


		$payroll_dependent_name 		= Request::input('payroll_dependent_name');
		$payroll_dependent_birthdate 	= Request::input('payroll_dependent_birthdate');
		$payroll_dependent_relationship = Request::input('payroll_dependent_relationship');

		/* dependent insert */
		Tbl_payroll_employee_dependent::where('payroll_employee_id', $payroll_employee_id)->delete();

		$insert_dependent = array();

		$temp = "";
		foreach($payroll_dependent_name as $key => $dependent)
		{
			if($dependent != "")
			{
				$temp['payroll_employee_id']			= $payroll_employee_id;
				$temp['payroll_dependent_name'] 		= $dependent;

				$birthdate = '';
				if($payroll_dependent_birthdate[$key] != '')
				{	
					$birthdate 							= date('Y-m-d',strtotime($payroll_dependent_birthdate[$key]));
				}
				
				$temp['payroll_dependent_birthdate'] 	= $birthdate;
				$temp['payroll_dependent_relationship'] = $payroll_dependent_relationship[$key];

				array_push($insert_dependent, $temp);
			}
		}

		Tbl_payroll_employee_dependent::insert($insert_dependent);

          Tbl_payroll_journal_tag_employee::where('payroll_employee_id' ,$payroll_employee_id)->delete();

          /* INSERT JOURNAL TAGS */
          if(Request::has('journal_tag'))
          {

               $insert_journal = array();
               foreach(Request::input('journal_tag') as $tag){
                    $temp_journal['payroll_employee_id']    = $payroll_employee_id;
                    $temp_journal['payroll_journal_tag_id'] = $tag;
                    array_push($insert_journal, $temp_journal);
               }

               if(!empty($insert_journal))
               {
                    Tbl_payroll_journal_tag_employee::insert($insert_journal);
               }
          }

		// Self::update_tbl_search();
		$return['function_name'] = 'employeelist.reload_employee_list';
		$return['status'] = 'success';
		return json_encode($return);
	}

	/* PREDICTIVE TEXT SEARCH*/
	public function search_employee_ahead()
	{
		$query = Request::input('query');
		$status = Request::input("status");
		// dd($status);
		$_return = Tbl_payroll_employee_search::search($query, $status)
											 ->select('tbl_payroll_employee_basic.payroll_employee_display_name as employee')
											 ->orderBy("tbl_payroll_employee_basic.payroll_employee_first_name")
											 ->groupBy('tbl_payroll_employee_basic.payroll_employee_id')
											 ->get();
		$data = array();
		foreach($_return as $return)
		{
			array_push($data, $return->employee);
		}

		return json_encode($data);
		// return $_return->toJson();
	}

	public function search_employee()
	{
		$trigger 			= Request::input('trigger');
		$employee_search 	= Request::input('employee_search');
		$data['_active'] = Tbl_payroll_employee_search::search($employee_search, $trigger)
											 ->orderBy("tbl_payroll_employee_basic.payroll_employee_first_name")
											 ->groupBy('tbl_payroll_employee_basic.payroll_employee_id')
											 ->get();

		return view('member.payroll.reload.employee_list_reload', $data);
	}

	public function update_tbl_search()
	{
		Tbl_payroll_employee_search::truncate();
		$_emp = tbl_payroll_employee_basic::get();

		$insert = array();
		foreach($_emp as $emp)
		{
			$temp['payroll_search_employee_id'] = $emp->payroll_employee_id;
			$temp['body']	=	$emp->payroll_employee_title_name.' '.$emp->payroll_employee_first_name.' '.$emp->payroll_employee_middle_name.' '.$emp->payroll_employee_last_name.' '.$emp->payroll_employee_suffix_name.' '.$emp->payroll_employee_display_name.' '.$emp->payroll_employee_email;
			array_push($insert, $temp);
		}
		if(!empty($insert))
		{
			Tbl_payroll_employee_search::insert($insert);
		}
	}

	public function reload_employee_list()
	{
		$company_id = 0;
		$employement_status = 0;
		if(Request::has('company_id'))
		{
			$company_id = Request::input('company_id');
		}
		if(Request::has('employement_status'))
		{
			$employement_status = Request::input('employement_status');
		}
		$parameter['date'] 					= date('Y-m-d');
		$parameter['company_id'] 			= $company_id;
		$parameter['employement_status'] 	= $employement_status;
		$parameter['shop_id'] 				= Self::shop_id();
		$data['_active'] = Tbl_payroll_employee_basic::selemployee($parameter)->get();

		return view('member.payroll.reload.employee_list_reload', $data);
	}

	/* EMPLOYEE END */

	public function payroll_configuration()
	{

          $_access = Self::payroll_configuration_page();

          $link = array();

          foreach($_access as $access)
          {
               if(Utilities::checkAccess('payroll-configuration',$access['access_name']) == 1)
               {
                    array_push($link, $access);
               }
          }

          $data['_link'] = $link;
		return view('member.payroll.payrollconfiguration', $data);
	}

     /* payroll configuration access page */
     public function payroll_configuration_page()
     {

          $data[0]['access_name'] = 'Department';
          $data[0]['link']        = '/member/payroll/departmentlist';

          $data[1]['access_name'] = 'Job Title';
          $data[1]['link']        = '/member/payroll/jobtitlelist';

          $data[2]['access_name'] = 'Holiday';
          $data[2]['link']        = '/member/payroll/holiday';

          $data[3]['access_name'] = 'Allowances';
          $data[3]['link']        = '/member/payroll/allowance';

          $data[4]['access_name'] = 'Deductions';
          $data[4]['link']        = '/member/payroll/deduction';

          $data[5]['access_name'] = 'Leave';
          $data[5]['link']        = '/member/payroll/leave';

          $data[6]['access_name'] = 'Payroll Group';
          $data[6]['link']        = '/member/payroll/payroll_group';

          $data[7]['access_name'] = 'Journal Tags';
          $data[7]['link']        = '/member/payroll/payroll_jouarnal';

          $data[8]['access_name'] = 'Payslip';
          $data[8]['link']        = '/member/payroll/custom_payslip';

          $data[9]['access_name'] = 'Tax Period';
          $data[9]['link']        = '/member/payroll/tax_period';

          $data[10]['access_name'] = 'Tax Table';
          $data[10]['link']        = '/member/payroll/tax_table_list';

          $data[11]['access_name'] = 'SSS Table';
          $data[11]['link']        = '/member/payroll/sss_table_list';

          $data[12]['access_name'] = 'Philhealth Table';
          $data[12]['link']        = '/member/payroll/philhealth_table_list';

          $data[13]['access_name'] = 'Pagibig/HDMF';
          $data[13]['link']        = '/member/payroll/pagibig_formula';

          return $data;
     }


	/* COMPANY START */

	public function company_list()
	{
		$data['_active'] = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_company::selcompany(Self::shop_id(),1)->orderBy('tbl_payroll_company.payroll_company_name')->paginate($this->paginate_count);

		return view('member.payroll.companylist', $data);
	}

	public function modal_create_company()
	{
		$company_logo = '';
		if(Session::has('company_logo'))
		{
			$company_logo = Session::get('company_logo');
		}
		$data['company_logo'] = $company_logo;
		$data['_rdo'] = Tbl_payroll_rdo::orderBy('rdo_code')->get();
		$data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->where('payroll_parent_company_id',0)->orderBy('tbl_payroll_company.payroll_company_name')->get();
		$data['_bank'] = Tbl_payroll_bank_convertion::get();
		return view('member.payroll.modal.modal_create_company', $data);
	}

	public function upload_company_logo()
	{
		$file = Request::file('file');
        $ImagName = value(function() use ($file){
            $filename = str_random(10). date('ymdhis') . '.' . $file->getClientOriginalExtension();
            return strtolower($filename);
        });
        $path = '/assets/payroll/company_logo';
        if (!file_exists($path)) {
		    mkdir($path, 0777, true);
		}
        $file->move(public_path($path), $ImagName);

        $session_logo = 'company_logo';
        if(Request::input('action') == 'update')
        {
        	$session_logo = 'company_logo_update';
        }

        Session::put($session_logo,$path.'/'.$ImagName);

        return $path.'/'.$ImagName;
	}

	public function modal_save_company()
	{
		$insert['payroll_company_name'] 				= Request::input('payroll_company_name');
		$insert['payroll_company_code'] 				= Request::input('payroll_company_code');
		$insert['payroll_company_rdo'] 					= Request::input('payroll_company_rdo');
		$insert['payroll_company_address'] 				= Request::input('payroll_company_address');
		$insert['payroll_company_contact'] 				= Request::input('payroll_company_contact');
		$insert['payroll_company_email'] 				= Request::input('payroll_company_email');
		$insert['payroll_company_nature_of_business'] 	= Request::input('payroll_company_nature_of_business');
		$insert['payroll_company_date_started'] 		= Request::input('payroll_company_date_started');
		$insert['payroll_company_tin'] 					= Request::input('payroll_company_tin');
		$insert['payroll_company_sss'] 					= Request::input('payroll_company_sss');
		$insert['payroll_company_philhealth'] 			= Request::input('payroll_company_philhealth');
		$insert['payroll_company_pagibig'] 				= Request::input('payroll_company_pagibig');
		$insert['shop_id']								= Self::shop_id();
		$insert['payroll_parent_company_id']			= Request::input('payroll_parent_company_id');
		$insert['payroll_company_bank']					= Request::input('payroll_company_bank');

		$logo = '/assets/images/no-logo.png';
		if(Session::has('company_logo'))
		{
			$logo = Session::get('company_logo');
		}
		$insert['payroll_company_logo'] = $logo;
		Tbl_payroll_company::insert($insert);
		Session::forget('company_logo');

		$return['function_name'] = 'companylist.save_company';
		$return['status'] = 'success';
		$return['data'] = '';

		return json_encode($return);
	}

	public function view_company_modal($id)
	{
		return Self::modal_company_operation($id);
	}

	public function edit_company_modal($id)
	{
		return Self::modal_company_operation($id, 'edit');
	}

	public function modal_company_operation($company_id = 0, $action = 'view')
	{
		$data['company'] = Tbl_payroll_company::where('payroll_company_id', $company_id)->first();
		$data['_rdo'] = Tbl_payroll_rdo::orderBy('rdo_code')->get();
		$data['action'] = $action;
		Session::put('company_logo_update', $data['company']->payroll_company_logo);
		$data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->where('payroll_parent_company_id',0)->orderBy('tbl_payroll_company.payroll_company_name')->get();
		$data['_bank'] = Tbl_payroll_bank_convertion::get();
		return view('member.payroll.modal.modal_view_company', $data);
	}

	public function update_company()
	{
		$payroll_company_id 							= Request::input('payroll_company_id');
		$update['payroll_company_name'] 				= Request::input('payroll_company_name');
		$update['payroll_company_code'] 				= Request::input('payroll_company_code');
		$update['payroll_company_rdo'] 					= Request::input('payroll_company_rdo');
		$update['payroll_company_address'] 				= Request::input('payroll_company_address');
		$update['payroll_company_contact'] 				= Request::input('payroll_company_contact');
		$update['payroll_company_email'] 				= Request::input('payroll_company_email');
		$update['payroll_company_nature_of_business'] 	= Request::input('payroll_company_nature_of_business');
		$update['payroll_company_date_started'] 		= Request::input('payroll_company_date_started');
		$update['payroll_company_tin'] 					= Request::input('payroll_company_tin');
		$update['payroll_company_sss'] 					= Request::input('payroll_company_sss');
		$update['payroll_company_philhealth'] 			= Request::input('payroll_company_philhealth');
		$update['payroll_company_pagibig'] 				= Request::input('payroll_company_pagibig');
		$update['payroll_parent_company_id']			= Request::input('payroll_parent_company_id');
		$update['payroll_company_bank']					= Request::input('payroll_company_bank');
		$logo = '/assets/images/no-logo.png';
		if(Session::has('company_logo_update'))
		{
			$logo = Session::get('company_logo_update');
			Session::forget('company_logo_update');
		}
		$update['payroll_company_logo'] 				= $logo;
		Tbl_payroll_company::where('payroll_company_id', $payroll_company_id)->update($update);

		$return['function_name'] = 'companylist.save_company';
		$return['status'] = 'success';
		$return['data'] = '';

		return json_encode($return);
	}

	public function reload_company()
	{
		$archived = Request::input('archived');
		$data['_active'] = Tbl_payroll_company::selcompany(Self::shop_id(), $archived)->orderBy('tbl_payroll_company.payroll_company_name')->get();
		return view('member.payroll.reload.companylist_reload',$data);
	}

	public function archived_company()
	{
		$archived 	= Request::input('archived');
		$id			= Request::input('id');
		$update['payroll_company_archived'] = $archived;
		Tbl_payroll_company::where('payroll_company_id', $id)->update($update);
		$return['function_name'] = 'companylist.save_company';
		$return['status'] = 'success';
		$return['data'] = '';

		return json_encode($return);
	}

	public function modal_archived_company($archived, $id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 		= Tbl_payroll_company::where('payroll_company_id', $id)->pluck('payroll_company_name');
		$data['title'] 	= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/company_list/archived_company';
		$data['id'] 		= $id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	/* COMPANY END */


	/* DEPARTMENT START */
	public function department_list()
	{
		$data['_active'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_department::sel(Self::shop_id(), 1)->orderBy('payroll_department_name')->paginate($this->paginate_count);
		return view('member.payroll.side_container.departmentlist', $data);
	}

	public function department_modal_create()
	{
		return view('member.payroll.modal.modal_create_department');
	}


	public function department_save()
	{
		$insert['payroll_department_name'] = Request::input('payroll_department_name');
		$insert['shop_id']				   = Self::shop_id();
		$id = Tbl_payroll_department::insertGetId($insert);

		$data['_data'] 		= array();
		$data['selected'] 	= $id;

		$_department = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		foreach($_department as $deparmtent)
		{
			$temp['id']		= $deparmtent->payroll_department_id;
			$temp['name']	= $deparmtent->payroll_department_name;
			$temp['attr']	= '';
			array_push($data['_data'], $temp);
		}

		$view = view('member.payroll.misc.misc_option', $data)->render();

		$return['view']				= $view;
		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.relaod_tbl_department';
		return json_encode($return);
	}

	public function department_reload()
	{
		$archived = Request::input('archived');
		$data['_active'] = Tbl_payroll_department::sel(Self::shop_id(), $archived)->orderBy('payroll_department_name')->get();
 		return view('member.payroll.reload.departmentlist_reload', $data);
	}

	public function archived_department()
	{
		$id = Request::input('id');
		$update['payroll_department_archived'] = Request::input('archived');
		Tbl_payroll_department::where('payroll_department_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_departmentlist';
		return json_encode($return);

	}

	public function modal_archived_department($archived, $department_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_department::where('payroll_department_id', $department_id)->pluck('payroll_department_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/departmentlist/archived_department';
		$data['id'] 		= $department_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}


	public function modal_view_department($id)
	{
		return Self::modal_department_operation($id);
	}

	public function modal_edit_department($id)
	{
		$action = 'edit';
		return Self::modal_department_operation($id, $action);
	}

	public function modal_department_operation($payroll_department_id = 0, $action = 'view')
	{
		$data['deparmtent'] = Tbl_payroll_department::where('payroll_department_id', $payroll_department_id)->first();
		$data['action'] = $action;
		return view('member.payroll.modal.modal_view_department',$data);
	}


	public function modal_update_department()
	{
		
		$payroll_department_id = Request::input('payroll_department_id');
		$payroll_department_name = Request::input('payroll_department_name');

		$update['payroll_department_name'] = $payroll_department_name;
		Tbl_payroll_department::where('payroll_department_id', $payroll_department_id)->update($update);
		
		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.relaod_tbl_department';
		return json_encode($return);
	}

	/* DEPARTMENT END */


	/* JOB TITLE START*/

	public function jobtitle_list()
	{
		$data['_active'] = Tbl_payroll_jobtitle::sel(Self::shop_id())->orderBy('payroll_jobtitle_name')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_jobtitle::sel(Self::shop_id(), 1)->orderBy('payroll_jobtitle_name')->paginate($this->paginate_count);
		return view('member.payroll.side_container.jobtitlelist', $data);
	}

	public function modal_create_jobtitle()
	{
		$selected = 0;
		if(Request::has('selected'))
		{
			$selected = Request::input('selected');
		}
		$data['_department'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['selected'] = $selected;
		return view('member.payroll.modal.modal_create_jobtitle', $data);
	}

	public function modal_save_jobtitle()
	{
		$insert['payroll_jobtitle_department_id'] 	= Request::input('payroll_jobtitle_department_id');
		$insert['payroll_jobtitle_name'] 			= Request::input('payroll_jobtitle_name');
		$insert['shop_id']							= Self::shop_id();
		$id = Tbl_payroll_jobtitle::insertGetId($insert);

		$data['_data'] 		= array();
		$data['selected'] 	= $id;
		$_jobtitle = Tbl_payroll_jobtitle::sel(Self::shop_id())->where('payroll_jobtitle_department_id',Request::input('payroll_jobtitle_department_id'))->orderBy('payroll_jobtitle_name')->get();
		foreach($_jobtitle as $job_title)
		{
			$temp['id'] = $job_title->payroll_jobtitle_id;
			$temp['name'] = $job_title->payroll_jobtitle_name;
			$temp['attr'] = '';
			array_push($data['_data'], $temp);
		}
		$view = view('member.payroll.misc.misc_option', $data)->render();

		$return['view']				= $view;
		$return['status'] 			= 'success';
		$return['data']	   			= $id;
		$return['function_name'] 	= 'payrollconfiguration.reload_jobtitlelist';
		return json_encode($return);
	}


	public function archived_jobtitle()
	{
		$id = Request::input('id');
		$update['payroll_jobtitle_archived'] = Request::input('archived');
		Tbl_payroll_jobtitle::where('payroll_jobtitle_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_tbl_jobtitle';
		return json_encode($return);

	}

	public function modal_archived_jobtitle($archived, $jobtitle_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_jobtitle::where('payroll_jobtitle_id', $jobtitle_id)->pluck('payroll_jobtitle_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/jobtitlelist/archived_jobtitle';
		$data['id'] 		= $jobtitle_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}
	
	public function reload_tbl_jobtitle()
	{
		$archived = Request::input('archived');
		$data['_active'] = Tbl_payroll_jobtitle::sel(Self::shop_id(), $archived)->orderBy('payroll_jobtitle_name')->get();
		return view('member.payroll.reload.jobtitlelist_reload',$data);
	}

	public function modal_view_jobtitle($id)
	{

		return Self::moda_view_jobtitle_operation($id);
	}

	public function modal_edit_jobtitle($id)
	{
		return Self::moda_view_jobtitle_operation($id, 'edit');
	}

	public function moda_view_jobtitle_operation($payroll_jobtitle_id = 0, $action = "view")
	{
		$data['position'] = Tbl_payroll_jobtitle::where('payroll_jobtitle_id', $payroll_jobtitle_id)->first();
		$data['_department'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['action'] = $action;
		return view('member.payroll.modal.modal_view_jobtitlelist',$data);
	}

	public function modal_update_jobtitle()
	{
		$payroll_jobtitle_id 						= Request::input('payroll_jobtitle_id');
		$update['payroll_jobtitle_department_id'] 	= Request::input('payroll_jobtitle_department_id');
		$update['payroll_jobtitle_name'] 			= Request::input('payroll_jobtitle_name');
		Tbl_payroll_jobtitle::where('payroll_jobtitle_id', $payroll_jobtitle_id)->update($update);

		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.reload_tbl_jobtitle';
		return json_encode($return);
	}

	/* GET JOB TITLE BY DEPARTMENT */
	public function get_job_title_by_department()
	{
		$payroll_department_id = Request::input('payroll_department_id');
		// dd($payroll_department_id);
		$job_title = Tbl_payroll_jobtitle::where('payroll_jobtitle_department_id',$payroll_department_id)->where('payroll_jobtitle_archived',0)->where('shop_id', Self::shop_id())->get();

		return json_encode($job_title);
	}

	/* JOB TITLE END*/


     /* TAX PERIOD START */
     public function tax_period()
     {
          $data['_period'] = Tbl_payroll_tax_period::where('shop_id', Self::shop_id())->get();
          return view('member.payroll.side_container.tax_period', $data);
     }

     public function taxt_perid_change()
     {
          $update['is_use']        = Request::input('is_use');
          $payroll_tax_period_id   = Request::input('payroll_tax_period_id');
          Tbl_payroll_tax_period::where('payroll_tax_period_id',$payroll_tax_period_id)->update($update);
     }
     /* TAX PERIOD END */

	/* TAX TABLE START */
	public function tax_table_list()
	{
		$data['_period'] = Payroll::tax_break(Self::shop_id());
		// dd($data);
		return view('member.payroll.side_container.tax', $data);
	}

	public function tax_table_save()
	{
		$payroll_tax_status_id 	= Request::input('payroll_tax_status_id');
		$tax_category 			= Request::input('tax_category');
		$tax_first_range 		= Request::input('tax_first_range');
		$tax_second_range 		= Request::input('tax_second_range');
		$tax_third_range 		= Request::input('tax_third_range');
		$tax_fourth_range 		= Request::input('tax_fourth_range');
		$tax_fifth_range 		= Request::input('tax_fifth_range');
		$taxt_sixth_range 		= Request::input('taxt_sixth_range');
		$tax_seventh_range 		= Request::input('tax_seventh_range');

		Tbl_payroll_tax_reference::where('shop_id', Self::shop_id())->where('payroll_tax_status_id',$payroll_tax_status_id)->delete();
		$insert = array();
		foreach($tax_category as $key => $category)
		{
			$insert[$key]['shop_id']				= Self::shop_id();
			$insert[$key]['payroll_tax_status_id'] 	= $payroll_tax_status_id;
			$insert[$key]['tax_category'] 			= $category;
			$insert[$key]['tax_first_range'] 		= $tax_first_range[$key];
			$insert[$key]['tax_second_range'] 		= $tax_second_range[$key];
			$insert[$key]['tax_third_range'] 		= $tax_third_range[$key];
			$insert[$key]['tax_fourth_range'] 		= $tax_fourth_range[$key];
			$insert[$key]['tax_fifth_range'] 		= $tax_fifth_range[$key];
			$insert[$key]['taxt_sixth_range'] 		= $taxt_sixth_range[$key];
			$insert[$key]['tax_seventh_range'] 		= $tax_seventh_range[$key];
		}

		Tbl_payroll_tax_reference::insert($insert);

		$return['status'] = 'success';
		$return['function_name'] = '';
		return json_encode($return);

	}


	/* FOR DEVELOPERS USE ONLY */
	public function tax_table_save_default()
	{
		$payroll_tax_status_id 	= Request::input('payroll_tax_status_id');
		$tax_category 			= Request::input('tax_category');
		$tax_first_range 		= Request::input('tax_first_range');
		$tax_second_range	 	= Request::input('tax_second_range');
		$tax_third_range 		= Request::input('tax_third_range');
		$tax_fourth_range 		= Request::input('tax_fourth_range');
		$tax_fifth_range 		= Request::input('tax_fifth_range');
		$taxt_sixth_range 		= Request::input('taxt_sixth_range');
		$tax_seventh_range 		= Request::input('tax_seventh_range');
		Tbl_payroll_tax_default::where('payroll_tax_status_id',$payroll_tax_status_id)->delete();
		$insert = array();
		foreach($tax_category as $key => $category)
		{
			$insert[$key]['payroll_tax_status_id'] 	= $payroll_tax_status_id;
			$insert[$key]['tax_category'] 			= $category;
			$insert[$key]['tax_first_range'] 		= $tax_first_range[$key];
			$insert[$key]['tax_second_range'] 		= $tax_second_range[$key];
			$insert[$key]['tax_third_range'] 		= $tax_third_range[$key];
			$insert[$key]['tax_fourth_range'] 		= $tax_fourth_range[$key];
			$insert[$key]['tax_fifth_range'] 		= $tax_fifth_range[$key];
			$insert[$key]['taxt_sixth_range'] 		= $taxt_sixth_range[$key];
			$insert[$key]['tax_seventh_range'] 		= $tax_seventh_range[$key];
		}

		Tbl_payroll_tax_default::insert($insert);

		$return['status'] = 'success';
		$return['function_name'] = '';
		return json_encode($return);
	}
	/* TAX TABLE END */


	/* SSS TABLE START */
	public function sss_table_list()
	{
		$data['_sss'] = Tbl_payroll_sss::where('shop_id', Self::shop_id())->orderBy('payroll_sss_min')->get();
		return view('member.payroll.side_container.ssslist', $data);
	}

	public function sss_table_save()
	{
		$payroll_sss_min 			= Request::input('payroll_sss_min');
		$payroll_sss_max 			= Request::input('payroll_sss_max');
		$payroll_sss_monthly_salary = Request::input('payroll_sss_monthly_salary');
		$payroll_sss_er 			= Request::input('payroll_sss_er');
		$payroll_sss_ee 			= Request::input('payroll_sss_ee');
		$payroll_sss_total 			= Request::input('payroll_sss_total');
		$payroll_sss_eec 			= Request::input('payroll_sss_eec');

		Tbl_payroll_sss::where('shop_id', Self::shop_id())->delete();
		$insert = array();
		foreach($payroll_sss_min as $key => $sss_min)
		{
			if($sss_min != '' && $sss_min != null)
			{	
				$insert[$key]['shop_id'] 					= Self::shop_id();
				$insert[$key]['payroll_sss_min'] 			= $sss_min;
				$insert[$key]['payroll_sss_max'] 			= $payroll_sss_max[$key];
				$insert[$key]['payroll_sss_monthly_salary'] = $payroll_sss_monthly_salary[$key];
				$insert[$key]['payroll_sss_er'] 			= $payroll_sss_er[$key];
				$insert[$key]['payroll_sss_ee'] 			= $payroll_sss_ee[$key];
				$insert[$key]['payroll_sss_total'] 			= $payroll_sss_total[$key];
				$insert[$key]['payroll_sss_eec'] 			= $payroll_sss_eec[$key];
			}
		}
		Tbl_payroll_sss::insert($insert);
		$return['status'] = 'success';
		return json_encode($return);
	}



	/* SSS DEFAULT VALUE [DEVELOPER] */
	public function sss_table_save_default()
	{
		$payroll_sss_min 			= Request::input('payroll_sss_min');
		$payroll_sss_max 			= Request::input('payroll_sss_max');
		$payroll_sss_monthly_salary = Request::input('payroll_sss_monthly_salary');
		$payroll_sss_er 			= Request::input('payroll_sss_er');
		$payroll_sss_ee 			= Request::input('payroll_sss_ee');
		$payroll_sss_total 			= Request::input('payroll_sss_total');
		$payroll_sss_eec 			= Request::input('payroll_sss_eec');

		Tbl_payroll_sss_default::truncate();
		$insert = array();
		foreach($payroll_sss_min as $key => $sss_min)
		{
			$insert[$key]['payroll_sss_min'] = $sss_min;
			$insert[$key]['payroll_sss_max'] = $payroll_sss_max[$key];
			$insert[$key]['payroll_sss_monthly_salary'] = $payroll_sss_monthly_salary[$key];
			$insert[$key]['payroll_sss_er'] = $payroll_sss_er[$key];
			$insert[$key]['payroll_sss_ee'] = $payroll_sss_ee[$key];
			$insert[$key]['payroll_sss_total'] = $payroll_sss_total[$key];
			$insert[$key]['payroll_sss_eec'] = $payroll_sss_eec[$key];
		}
		Tbl_payroll_sss_default::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);

	}
	/* SSS TABLE END */


	/* PHILHEALTH TABLE START */
	public function philhealth_table_list()
	{
		$data['_philhealth'] = Tbl_payroll_philhealth::where('shop_id', Self::shop_id())->orderBy('payroll_philhealth_min')->get();
		return view('member.payroll.side_container.philhealthlist', $data); 
	}

	public function philhealth_table_save()
	{
		$payroll_philhealth_min 		= Request::input('payroll_philhealth_min');
		$payroll_philhealth_max 		= Request::input('payroll_philhealth_max');
		$payroll_philhealth_base 		= Request::input('payroll_philhealth_base');
		$payroll_philhealth_premium 	= Request::input('payroll_philhealth_premium');
		$payroll_philhealth_ee_share 	= Request::input('payroll_philhealth_ee_share');
		$payroll_philhealth_er_share 	= Request::input('payroll_philhealth_er_share');
		Tbl_payroll_philhealth::where('shop_id', Self::shop_id())->delete();
		$insert = array();
		foreach($payroll_philhealth_min as $key => $min)
		{
			if($min != "" && $min != null)
			{
				$insert[$key]['shop_id']						= Self::shop_id();
				$insert[$key]['payroll_philhealth_min'] 		= $min;
				$insert[$key]['payroll_philhealth_max'] 		= $payroll_philhealth_max[$key];
				$insert[$key]['payroll_philhealth_base'] 		= $payroll_philhealth_base[$key];
				$insert[$key]['payroll_philhealth_premium'] 	= $payroll_philhealth_premium[$key];
				$insert[$key]['payroll_philhealth_ee_share'] 	= $payroll_philhealth_ee_share[$key];
				$insert[$key]['payroll_philhealth_er_share'] 	= $payroll_philhealth_er_share[$key];
			}
			
		}
		Tbl_payroll_philhealth::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}


	/* PHILHEALTH DEFAULT VALUE [DEVELOPER] */
	public function philhealth_table_save_default()
	{
		$payroll_philhealth_min 		= Request::input('payroll_philhealth_min');
		$payroll_philhealth_max 		= Request::input('payroll_philhealth_max');
		$payroll_philhealth_base 		= Request::input('payroll_philhealth_base');
		$payroll_philhealth_premium 	= Request::input('payroll_philhealth_premium');
		$payroll_philhealth_ee_share 	= Request::input('payroll_philhealth_ee_share');
		$payroll_philhealth_er_share 	= Request::input('payroll_philhealth_er_share');

		Tbl_payroll_philhealth_default::truncate();
		$insert = array();
		foreach($payroll_philhealth_min as $key => $min)
		{
			if($min != "" && $min != null)
			{
				$insert[$key]['payroll_philhealth_min'] 		= $min;
				$insert[$key]['payroll_philhealth_max'] 		= $payroll_philhealth_max[$key];
				$insert[$key]['payroll_philhealth_base'] 		= $payroll_philhealth_base[$key];
				$insert[$key]['payroll_philhealth_premium'] 	= $payroll_philhealth_premium[$key];
				$insert[$key]['payroll_philhealth_ee_share'] 	= $payroll_philhealth_ee_share[$key];
				$insert[$key]['payroll_philhealth_er_share'] 	= $payroll_philhealth_er_share[$key];
			}
			
		}
		Tbl_payroll_philhealth_default::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}


	/* PHILHEALTH TABLE END */
	public function pagibig_formula()
	{
		$data['pagibig'] = Tbl_payroll_pagibig::where('shop_id', Self::shop_id())->first();
		return view('member.payroll.side_container.pagibig', $data);
	}

	public function pagibig_formula_save()
	{
		Tbl_payroll_pagibig::where('shop_id', Self::shop_id())->delete();

		$insert['payroll_pagibig_percent']  = Request::input('payroll_pagibig_percent');
		$insert['shop_id']					= Self::shop_id();
		Tbl_payroll_pagibig::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}



	/* PAGIBIG DEFAULT VALUE [DEVELOPER] */
	public function pagibig_formula_save_default()
	{
		Tbl_payroll_pagibig_default::truncate();
		$insert['payroll_pagibig_percent'] = Request::input('payroll_pagibig_percent');
		Tbl_payroll_pagibig_default::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}
	/* PAGIBIG TABLE START */


	/* DEDUCTION START */
	public function deduction()
	{
		$data['_active'] = Tbl_payroll_deduction::seldeduction(Self::shop_id())->orderBy('tbl_payroll_deduction.payroll_deduction_category','tbl_payroll_deduction.payroll_deduction_name')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_deduction::seldeduction(Self::shop_id(), 1)->orderBy('tbl_payroll_deduction.payroll_deduction_category','tbl_payroll_deduction.payroll_deduction_name')->paginate($this->paginate_count);
		return view('member.payroll.side_container.deduction', $data);
	}

	public function modal_create_deduction()
	{
		$array = array();
		Session::put('employee_deduction_tag',$array);
		return view('member.payroll.modal.modal_create_deduction');
	}

	public function modal_create_deduction_type($type)
	{
		$type 				= str_replace('_', ' ', $type);
		$data['_active'] 	= Tbl_payroll_deduction_type::seltype(Self::shop_id(),$type)->get();
		$data['_archived'] 	= Tbl_payroll_deduction_type::seltype(Self::shop_id(),$type, 1)->get();
		$data['type'] 		= $type;
		return view('member.payroll.modal.modal_deduction_type',$data);
	}

	public function modal_save_deduction_type()
	{
		$insert['payroll_deduction_category'] 	= Request::input('payroll_deduction_category');
		$insert['payroll_deduction_type_name'] 	= Request::input('payroll_deduction_type_name');
		$insert['shop_id'] 						= Self::shop_id();
		$id = Tbl_payroll_deduction_type::insertGetId($insert);

		$type = Request::input('payroll_deduction_category');

		$_data = Tbl_payroll_deduction_type::seltype(Self::shop_id(),$type)->get();
		$html = '<option value="">Select Type</option>';
		foreach($_data as $data)
		{
			$html .= '<option value="'.$data->payroll_deduction_type_id.'" ';
			if($data->payroll_deduction_type_id == $id)
			{
				$html .= 'selected="selected"';
			}
			$html.= '>'.$data->payroll_deduction_type_name.'</option>';
		}
		return $html;
	}

	public function reload_deduction_type()
	{
		$payroll_deduction_category = Request::input('payroll_deduction_category');
		$archived 					= Request::input('archived');
		$data['_active'] 			= Tbl_payroll_deduction_type::seltype(Self::shop_id(),$payroll_deduction_category, $archived)->get();
		return view('member.payroll.reload.deduction_list_reload',$data);
	}

	public function update_deduction_type()
	{
		$value 		= Request::input('value');
		$content 	= Request::input('content');
		
		$update['payroll_deduction_type_name'] = $value;
		Tbl_payroll_deduction_type::where('payroll_deduction_type_id',$content)->update($update);

	}

	public function archive_deduction_type()
	{
		$content = Request::input('content');
		$update['payroll_deduction_archived'] = Request::input('archived');
		Tbl_payroll_deduction_type::where('payroll_deduction_type_id',$content)->update($update);
	}

	public function ajax_deduction_type()
	{
		$category = Request::input('category');
		$data = Tbl_payroll_deduction_type::seltype(Self::shop_id(),$category)->get();
		return json_encode($data);
	}

	public function modal_deduction_tag_employee($deduction_id)
	{
		$data['_company'] 		= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

		$data['_department'] 	= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();

		$data['deduction_id']	=	$deduction_id;
		$data['action']			= 	'/member/payroll/deduction/set_employee_deduction_tag';

		return view('member.payroll.modal.modal_deduction_tag_employee', $data);
	}

	public function modal_save_deduction()
	{
		$insert['shop_id'] 						= Self::shop_id();
		$insert['payroll_deduction_name'] 		= Request::input('payroll_deduction_name');
		$insert['payroll_deduction_amount'] 	= Request::input('payroll_deduction_amount');
		$insert['payroll_monthly_amortization'] = Request::input('payroll_monthly_amortization');
		$insert['payroll_periodal_deduction'] 	= Request::input('payroll_periodal_deduction');
		$insert['payroll_deduction_date_filed'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_filed')));
		$insert['payroll_deduction_date_start'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_start')));
		$insert['payroll_deduction_date_end']	= date('Y-m-d', strtotime(Request::input('payroll_deduction_date_end')));
		$insert['payroll_deduction_period'] 	= Request::input('payroll_deduction_period');
		$insert['payroll_deduction_category'] 	= Request::input('payroll_deduction_category');
		$insert['payroll_deduction_type'] 		= Request::input('payroll_deduction_type');
		$insert['payroll_deduction_remarks'] 	= Request::input('payroll_deduction_remarks');

		$deduction_id = Tbl_payroll_deduction::insertGetId($insert);

		if(Session::has('employee_deduction_tag'))
		{
			$employee_tag = Session::get('employee_deduction_tag');
			$insert_employee = '';
			foreach($employee_tag as $key => $tag)
			{
				$insert_employee[$key]['payroll_deduction_id']  	= $deduction_id;
				$insert_employee[$key]['payroll_employee_id']		= $tag;
			}
			if($insert_employee != '')
			{
				Tbl_payroll_deduction_employee::insert($insert_employee);
			}
		}

		$return['stataus'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_deduction';
		return json_encode($return);

	}

	public function ajax_deduction_tag_employee()
	{
		$company 	= Request::input('company');
		$department = Request::input('department');
		$jobtitle 	= Request::input('jobtitle');


		$emp = Tbl_payroll_employee_contract::employeefilter($company, $department, $jobtitle, date('Y-m-d'), Self::shop_id())->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->groupBy('tbl_payroll_employee_basic.payroll_employee_id')->get();
		// dd($emp);
		return json_encode($emp);
	}

	public function set_employee_deduction_tag()
	{
		$employee_tag = Request::input('employee_tag');
		$deduction_id = Request::input('deduction_id');
		// dd($deduction_id);
		$array = array();
		if(Session::has('employee_deduction_tag'))
		{
			$array = Session::get('employee_deduction_tag');
		}
		// dd($array);

		$insert_tag = array();

		foreach($employee_tag as $tag)
		{
			if(!in_array($tag, $array) && $deduction_id == 0)
			{
				array_push($array, $tag);
			}
			$count = Tbl_payroll_deduction_employee::where('payroll_deduction_id',$deduction_id)->where('payroll_employee_id', $tag)->count();

			if($count == 0)
			{
				$insert['payroll_deduction_id'] 	= $deduction_id;
				$insert['payroll_employee_id']		= $tag;
				array_push($insert_tag, $insert);
			}
			
		}
		// dd($insert_tag);
		if($deduction_id != 0 && $insert_tag != '')
		{
			Tbl_payroll_deduction_employee::insert($insert_tag);
		}
		else
		{
			Session::put('employee_deduction_tag', $array);
		}
		

		$return['status'] = 'success';
		$return['function_name'] = 'modal_create_deduction.load_tagged_employee';
		return json_encode($return);
	}

	public function get_employee_deduction_tag()
	{	
		$employee = [0 => 0];
		if(Session::has('employee_deduction_tag'))
		{
			$employee = Session::get('employee_deduction_tag');
		}
		$emp = Tbl_payroll_employee_basic::whereIn('payroll_employee_id',$employee)->get();

		$data['new_record'] = $emp;
		return json_encode($data);
	}

	public function remove_from_tag_session()
	{
		$content = Request::input('content');
		$array 	 = Session::get('employee_deduction_tag');
		if(($key = array_search($content, $array)) !== false) {
		    unset($array[$key]);
		}
		Session::put('employee_deduction_tag', $array);
	}

	public function reload_deduction_employee_tag()
	{
		$payroll_deduction_id = Request::input('payroll_deduction_id');
		$data['emp'] = Payroll::getbalance(Self::shop_id(), $payroll_deduction_id);
		return view('member.payroll.reload.deduction_employee_tag_reload', $data);
	}


	public function modal_edit_deduction($id)
	{
		$data['deduction'] = Tbl_payroll_deduction::where('payroll_deduction_id',$id)->first();
		$data['_type'] = Tbl_payroll_deduction_type::where('shop_id', Self::shop_id())->where('payroll_deduction_archived', 0)->orderBy('payroll_deduction_type_name')->get();
		$data['emp'] = Payroll::getbalance(Self::shop_id(), $id);
		// dd($data['_emp']);
		return view('member.payroll.modal.modal_edit_deduction', $data);
	}

	public function archive_deduction($archived, $id)
	{
		
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_deduction::where('payroll_deduction_id', $id)->pluck('payroll_deduction_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/deduction/archived_deduction_action';
		$data['id'] 		= $id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_deduction_action()
	{
		$update['payroll_deduction_archived'] 	= Request::input('archived');
		$id 									= Request::input('id');
		Tbl_payroll_deduction::where('payroll_deduction_id',$id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_deduction';
		return json_encode($return);
	}


	public function modal_update_deduction()
	{
		$payroll_deduction_id 			 		= Request::input('payroll_deduction_id');
		$update['payroll_deduction_name'] 		= Request::input('payroll_deduction_name');
		$update['payroll_deduction_amount'] 	= Request::input('payroll_deduction_amount');
		$update['payroll_monthly_amortization'] = Request::input('payroll_monthly_amortization');
		$update['payroll_periodal_deduction'] 	= Request::input('payroll_periodal_deduction');
		$update['payroll_deduction_date_filed'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_filed')));
		$update['payroll_deduction_date_start'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_start')));
		$update['payroll_deduction_date_end']	= date('Y-m-d', strtotime(Request::input('payroll_deduction_date_end')));
		$update['payroll_deduction_period'] 	= Request::input('payroll_deduction_period');
		$update['payroll_deduction_category'] 	= Request::input('payroll_deduction_category');
		$update['payroll_deduction_type'] 		= Request::input('payroll_deduction_type');
		$update['payroll_deduction_remarks'] 	= Request::input('payroll_deduction_remarks');

		Tbl_payroll_deduction::where('payroll_deduction_id',$payroll_deduction_id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_deduction';
		return json_encode($return);
	}

	public function deduction_employee_tag($archive, $payroll_deduction_employee_id)
	{
		$statement = 'cancel';
		if($archive == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_deduction_employee::getemployee($payroll_deduction_employee_id)->pluck('payroll_employee_display_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/deduction/deduction_employee_tag_archive';
		$data['id'] 		= $payroll_deduction_employee_id;
		$data['archived'] 	= $archive;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function deduction_employee_tag_archive()
	{
		$id = Request::input('id');
		$update['payroll_deduction_employee_archived'] = Request::input('archived');

		Tbl_payroll_deduction_employee::where('payroll_deduction_employee_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_deduction.reload_tag_employee';
		return json_encode($return);
	}

	/* DEDUCTION END */


	/* HOLIDAY START */
	public function holiday()
	{

		$data['_active'] = Tbl_payroll_holiday::getholiday(Self::shop_id())->orderBy('payroll_holiday_date','desc')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_holiday::getholiday(Self::shop_id(), 1)->orderBy('payroll_holiday_date','desc')->paginate($this->paginate_count);
		/*Temporary holiday default*/ 
		$data['_default'] = Tbl_payroll_holiday_default::orderBy('payroll_holiday_date','desc')->paginate($this->paginate_count);
		return view('member.payroll.side_container.holiday',$data);

	}

	public function modal_create_holiday()
	{
		$data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('payroll_company_name')->get();
		return view('member.payroll.modal.modal_create_holiday', $data);
	}

	public function modal_save_holiday()
	{
		
		$insert['shop_id']					= Self::shop_id();
		$insert['payroll_holiday_name'] 	= Request::input('payroll_holiday_name');
		$insert['payroll_holiday_date'] 	= date('Y-m-d',strtotime(Request::input('payroll_holiday_date')));
		$insert['payroll_holiday_category'] = Request::input('payroll_holiday_category');

		$holiday_id = Tbl_payroll_holiday::insertGetId($insert);

		$_company 							= Request::input('company');

		$insert_company = array();

		foreach($_company as $company)
		{

			$temp['payroll_company_id'] = $company;
			$temp['payroll_holiday_id'] = $holiday_id;
			array_push($insert_company, $temp);
		}

		if(!empty($insert_company))
		{
			Tbl_payroll_holiday_company::insert($insert_company);
		}

		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_holiday';
		return json_encode($return);
	}

	public function archive_holiday($archive, $id)
	{
		$statement = 'archive';
		if($archive == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_holiday::where('payroll_holiday_id', $id)->pluck('payroll_holiday_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/holiday/archive_holiday_action';
		$data['id'] 		= $id;
		$data['archived'] 	= $archive;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archive_holiday_action()
	{
		$id = Request::input('id');
		$update['payroll_holiday_archived'] = Request::input('archived');
		Tbl_payroll_holiday::where('payroll_holiday_id', $id)->update($update);


		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_holiday';
		return json_encode($return);
	}

	public function modal_edit_holiday($id)
	{
		// $data['']
		$_company = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('payroll_company_name')->get();
		$company_check = array();
		foreach($_company as $company)
		{
			$count = Tbl_payroll_holiday_company::company($company->payroll_company_id, $id)->count();
			$status = '';
			if($count != 0)
			{
				$status = 'checked';
			}
			$temp['payroll_company_id'] 	= $company->payroll_company_id;
			$temp['payroll_company_name'] 	= $company->payroll_company_name;
			$temp['status']					= $status;
			array_push($company_check, $temp);
		}

		$data['_company'] = $company_check;
		$data['holiday'] = Tbl_payroll_holiday::where('payroll_holiday_id',$id)->first();
		return view('member.payroll.modal.modal_edit_holiday', $data);
	}

	public function modal_update_holiday()
	{
		$payroll_holiday_id 				= Request::input('payroll_holiday_id');
		$update['payroll_holiday_name'] 	= Request::input('payroll_holiday_name');
		$update['payroll_holiday_date'] 	= date('Y-m-d',strtotime(Request::input('payroll_holiday_date')));
		$update['payroll_holiday_category'] = Request::input('payroll_holiday_category');
		$_company 							= Request::input('company');

		Tbl_payroll_holiday::where('payroll_holiday_id',$payroll_holiday_id)->update($update);

		Tbl_payroll_holiday_company::where('payroll_holiday_id',$payroll_holiday_id)->delete();

		$insert_company = array();
		foreach($_company as $company)
		{
			$temp['payroll_company_id'] = $company;
			$temp['payroll_holiday_id'] = $payroll_holiday_id;
			array_push($insert_company, $temp);
		}
		if(!empty($insert_company))
		{
			Tbl_payroll_holiday_company::insert($insert_company);
		}

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_holiday';
		return json_encode($return);

	}

	/* HOLIDAY END */

	/* ALLOWANCE START */
	public function allowance()
	{		
		$data['_active'] = Tbl_payroll_allowance::sel(Self::shop_id())->orderBy('payroll_allowance_name')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_allowance::sel(Self::shop_id(), 1)->orderBy('payroll_allowance_name')->paginate($this->paginate_count);
		return view('member.payroll.side_container.allowance', $data);
	}

	public function modal_create_allowance()
	{
		Session::put('allowance_employee_tag', array());
		return view('member.payroll.modal.modal_create_allowance');
	}

	public function modal_allowance_tag_employee($allowance_id)
	{
		$data['_company'] 		= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

		$data['_department'] 	= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();

		$data['deduction_id']	=	$allowance_id;
		$data['action']			= 	'/member/payroll/allowance/set_employee_allowance_tag';

		return view('member.payroll.modal.modal_deduction_tag_employee', $data);
	}

	public function set_employee_allowance_tag()
	{
		$allowance_id = Request::input('deduction_id');
		$employee_tag = Request::input('employee_tag');

		$array = array();
		if(Session::has('allowance_employee_tag'))
		{
			$array = Session::get('allowance_employee_tag');
		}

		$insert_tag = array();

		foreach($employee_tag as $tag)
		{
			array_push($array, $tag);
			if($allowance_id != 0)
			{
				$count = Tbl_payroll_employee_allowance::where('payroll_allowance_id', $allowance_id)->where('payroll_employee_id',$tag)->count();
				if($count == 0)
				{
					$insert['payroll_allowance_id'] = $allowance_id;
					$insert['payroll_employee_id']	= $tag;
					array_push($insert_tag, $insert);
				}
			}
		}

		if($allowance_id != 0 && !empty($insert_tag))
		{
			Tbl_payroll_employee_allowance::insert($insert_tag);
		}
		Session::put('allowance_employee_tag',$array);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_allowance.load_employee_tag';
		return json_encode($return);
	}

	public function get_employee_allowance_tag()
	{
		$employee = [0 => 0];
		if(Session::has('allowance_employee_tag'))
		{
			$employee = Session::get('allowance_employee_tag');
		}
		$emp = Tbl_payroll_employee_basic::whereIn('payroll_employee_id',$employee)->get();

		$data['new_record'] = $emp;
		return json_encode($data);
	}


	public function remove_allowance_tabe_employee()
	{
		$content = Request::input('content');
		$array 	 = Session::get('allowance_employee_tag');
		if(($key = array_search($content, $array)) !== false) {
		    unset($array[$key]);
		}
		Session::put('allowance_employee_tag',$array);
	}


	public function modal_save_allowances()
	{
		$insert['payroll_allowance_name'] 		= Request::input('payroll_allowance_name');
		$insert['payroll_allowance_amount'] 	= Request::input('payroll_allowance_amount');
		$insert['payroll_allowance_category'] 	= Request::input('payroll_allowance_category');
          $insert['payroll_allowance_add_period'] = Request::input('payroll_allowance_add_period');
		$insert['shop_id']						= Self::shop_id();
		$allowance_id = Tbl_payroll_allowance::insertGetId($insert);

		$insert_employee = array();
		if(Session::has('allowance_employee_tag'))
		{
			foreach(Session::get('allowance_employee_tag') as $tag)
			{	
				$temp['payroll_allowance_id'] 	= $allowance_id;
				$temp['payroll_employee_id']	= $tag;
				array_push($insert_employee, $temp);
			}
			if(!empty($insert_employee))
			{
				Tbl_payroll_employee_allowance::insert($insert_employee);
			}
		}

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_allowance';
		return json_encode($return);
	}

	public function modal_archived_allwance($archived, $allowance_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_allowance::where('payroll_allowance_id', $allowance_id)->pluck('payroll_allowance_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/allowance/archived_allowance';
		$data['id'] 		= $allowance_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_allowance()
	{
		$id = Request::input('id');
		$update['payroll_allowance_archived'] = Request::input('archived');
		Tbl_payroll_allowance::where('payroll_allowance_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_allowance';
		return json_encode($return);
	}

	public function modal_edit_allowance($id)
	{
		$data['allowance'] = Tbl_payroll_allowance::where('payroll_allowance_id', $id)->first();
		$data['_active'] = Tbl_payroll_employee_allowance::getperallowance($id)->get();
		$data['_archived'] = Tbl_payroll_employee_allowance::getperallowance($id , 1)->get();
		// dd($data);
		return view('member.payroll.modal.modal_edit_allowance', $data);
	}

	public function modal_archived_llowance_employee($archived, $id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$_query 			= Tbl_payroll_employee_allowance::employee($id)->first();
		// dd($_query);
		$file_name 			= $_query->payroll_employee_title_name.' '.$_query->payroll_employee_first_name.' '.$_query->payroll_employee_middle_name.' '.$_query->payroll_employee_last_name.' '.$_query->payroll_employee_suffix_name;
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/allowance/archived_allowance_employee';
		$data['id'] 		= $id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_allowance_employee()
	{
		$id = Request::input('id');
		$update['payroll_employee_allowance_archived'] = Request::input('archived');
		Tbl_payroll_employee_allowance::where('payroll_employee_allowance_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_allowance.load_emoloyee_tag';
		return json_encode($return);
	}

	public function update_allowance()
	{
		$payroll_allowance_id 				= Request::input('payroll_allowance_id');
		$update['payroll_allowance_name'] 		= Request::input('payroll_allowance_name');
		$update['payroll_allowance_amount'] 	= Request::input('payroll_allowance_amount');
		$update['payroll_allowance_category'] 	= Request::input('payroll_allowance_category');
		$update['payroll_allowance_add_period'] = Request::input('payroll_allowance_add_period');

		Tbl_payroll_allowance::where('payroll_allowance_id', $payroll_allowance_id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_allowance';
		return json_encode($return);
	}

	public function reload_allowance_employee()
	{
		$payroll_allowance_id = Request::input('payroll_allowance_id');
		$data['_active'] = Tbl_payroll_employee_allowance::getperallowance($payroll_allowance_id)->get();
		$data['_archived'] = Tbl_payroll_employee_allowance::getperallowance($payroll_allowance_id , 1)->get();
		return view('member.payroll.reload.allowance_employee_reload', $data);
	}

	/* ALLOWANCE END */

	/* LEAVE START */
	public function leave()
	{
		$data['_active'] = Tbl_payroll_leave_temp::sel(Self::shop_id())->orderBy('payroll_leave_temp_name')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_leave_temp::sel(Self::shop_id(), 1)->orderBy('payroll_leave_temp_name')->paginate($this->paginate_count);
		/*return view('member.payroll.side_container.leave', $data);*/
		return view('member.payroll.side_container.leave', $data)->with('data', $data);
	}

	/*Function to view modal to create leave_temp*/
	public function modal_create_leave_temp()
	{
		Session::put('leave_tag_employee', array());
		return view('member.payroll.modal.modal_create_leave_temp');
	}

	public function modal_leave_tag_employee($leave_temp_id)
	{
		$data['_company'] 		= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

		$data['_department'] 	= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();

		$data['deduction_id']	=	$leave_temp_id;
		$data['action']			= 	'/member/payroll/leave/set_leave_tag_employee';
		return view('member.payroll.modal.modal_deduction_tag_employee', $data);
	}

	public function set_leave_tag_employee()
	{
		$leave_temp_id = Request::input('deduction_id');
		$employee_tag = Request::input('employee_tag');

		$array = array();
		if(Session::has('leave_tag_employee'))
		{
			$array = Session::get('leave_tag_employee');
		}

		$insert_tag = array();

		if(isset($employee_tag)){
			foreach($employee_tag as $tag)
			{
				array_push($array, $tag);
				if($leave_temp_id != 0)
				{
					$count = Tbl_payroll_leave_employee::where('payroll_leave_temp_id', $leave_temp_id)->where('payroll_employee_id',$tag)->count();
					if($count == 0)
					{
						$insert['payroll_leave_temp_id'] = $leave_temp_id;
						$insert['payroll_employee_id']	= $tag;
						array_push($insert_tag, $insert);
					}
				}
			}	
		}
			

		if($leave_temp_id != 0 && !empty($insert_tag))
		{
			Tbl_payroll_leave_employee::insert($insert_tag);
		}
		Session::put('leave_tag_employee',$array);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_leave_temp.load_employee_tag';
		return json_encode($return);
	}

	public function get_leave_tag_employee()
	{
		$employee = [0 => 0];
		if(Session::has('leave_tag_employee'))
		{
			$employee = Session::get('leave_tag_employee');
		}
		$emp = Tbl_payroll_employee_basic::whereIn('payroll_employee_id',$employee)->get();

		$data['new_record'] = $emp;
		return json_encode($data);
	}


	public function remove_leave_tag_employee()
	{
		$content = Request::input('content');
		$array 	 = Session::get('leave_tag_employee');
		if(($key = array_search($content, $array)) !== false) {
		    unset($array[$key]);
		}
		Session::put('leave_tag_employee',$array);
	}

	public function modal_save_leave_temp()
	{
		$insert['payroll_leave_temp_name'] 				= Request::input('payroll_leave_temp_name');
		$insert['payroll_leave_temp_days_cap'] 			= Request::input('payroll_leave_temp_days_cap');
		$insert['payroll_leave_temp_with_pay'] 			= Request::input('payroll_leave_temp_with_pay');
		$insert['payroll_leave_temp_is_cummulative']	= Request::input('payroll_leave_temp_is_cummulative');
		$insert['shop_id']								= Self::shop_id();
		$leave_temp_id = Tbl_payroll_leave_temp::insertGetId($insert);

		$insert_employee = array();
		if(Session::has('leave_tag_employee'))
		{
			foreach(Session::get('leave_tag_employee') as $tag)
			{	
				$temp['payroll_leave_temp_id'] 	= $leave_temp_id;
				$temp['payroll_employee_id']	= $tag;
				array_push($insert_employee, $temp);
			}
			if(!empty($insert_employee))
			{
				Tbl_payroll_leave_employee::insert($insert_employee);
			}
		}

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_leave_temp';
		return json_encode($return);
	}

	public function modal_archived_leave_temp($archived, $leave_temp_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_leave_temp::where('payroll_leave_temp_id', $leave_temp_id)->pluck('payroll_leave_temp_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/leave/archived_leave_temp';
		$data['id'] 		= $leave_temp_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_leave_temp()
	{
		$id = Request::input('id');
		$update['payroll_leave_temp_archived'] = Request::input('archived');
		Tbl_payroll_leave_temp::where('payroll_leave_temp_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_leave_temp';
		return json_encode($return);

	}

	public function modal_edit_leave_temp($id)
	{
		$data['leave_temp'] = Tbl_payroll_leave_temp::where('payroll_leave_temp_id', $id)->first();
		$data['_active'] = Tbl_payroll_leave_employee::getperleave($id)->get();
		$data['_archived'] = Tbl_payroll_leave_employee::getperleave($id , 1)->get();
		// dd($data);
		return view('member.payroll.modal.modal_edit_leave_temp', $data);
	}

	public function update_leave_temp()
	{
		$payroll_leave_temp_id 					= Request::input('payroll_leave_temp_id');
		$update['payroll_leave_temp_name'] 		= Request::input('payroll_leave_temp_name');
		$update['payroll_leave_temp_days_cap'] 	= Request::input('payroll_leave_temp_days_cap');
		$update['payroll_leave_temp_with_pay'] 	= Request::input('payroll_leave_temp_with_pay');
		$update['payroll_leave_temp_is_cummulative'] 	= Request::input('payroll_leave_temp_is_cummulative');
		Tbl_payroll_leave_temp::where('payroll_leave_temp_id', $payroll_leave_temp_id)->update($update);
		
		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_leave_temp';
		return json_encode($return);
	}

	public function modal_archived_leave_employee($archived, $id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$_query 			= Tbl_payroll_leave_employee::employee($id)->first();
		// dd($_query);
		$file_name 			= $_query->payroll_employee_title_name.' '.$_query->payroll_employee_first_name.' '.$_query->payroll_employee_middle_name.' '.$_query->payroll_employee_last_name.' '.$_query->payroll_employee_suffix_name;
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/leave/archived_leave_employee';
		$data['id'] 		= $id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);


	}

	public function archived_leave_employee()
	{
		$id = Request::input('id');
		$update['payroll_leave_employee_is_archived'] = Request::input('archived');
		Tbl_payroll_leave_employee::where('payroll_leave_employee_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_leave_temp.load_employee_tag';
		return json_encode($return);
	}

	public function reload_leave_employee()
	{
		$payroll_leave_temp_id = Request::input('payroll_leave_temp_id');
		$data['_active'] = Tbl_payroll_leave_employee::getperleave($payroll_leave_temp_id)->get();
		$data['_archived'] = Tbl_payroll_leave_employee::getperleave($payroll_leave_temp_id , 1)->get();
		return view('member.payroll.reload.leave_employee_reload', $data);
	}

	/* LEAVE END */


	/* PAYROLL GROUP START */
	public function payroll_group()
	{
		// Tbl_payroll_overtime_rate
		$data['_active'] = Tbl_payroll_group::sel(Self::shop_id())->orderBy('payroll_group_code')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_group::sel(Self::shop_id(), 1)->orderBy('payroll_group_code')->paginate($this->paginate_count);
		return view('member.payroll.side_container.payroll_group', $data);
	}

	public function modal_create_payroll_group()
	{
		$data['_overtime_rate']  = Tbl_payroll_over_time_rate_default::get();
		$data['_day'] 			= Payroll::restday_checked(); 
          $data['_period']         = Tbl_payroll_tax_period::check(Self::shop_id())->get();
		return view('member.payroll.modal.modal_create_payroll_group', $data);
	}

	public function modal_save_payroll_group()
	{
		
		$insert['shop_id']								= Self::shop_id();
		$insert['payroll_group_code'] 					= Request::input('payroll_group_code');
		$insert['payroll_group_salary_computation'] 	= Request::input('payroll_group_salary_computation');
		$insert['payroll_group_period'] 				= Request::input('payroll_group_period');
		$insert['payroll_group_13month_basis'] 			= Request::input('payroll_group_13month_basis');
		
		if( Request::has('payroll_group_deduct_before_absences'))
		{
			$insert['payroll_group_deduct_before_absences'] = Request::input('payroll_group_deduct_before_absences');
		}

          $payroll_group_before_tax                         = 0;
          if(Request::has("payroll_group_before_tax"))
          {
               $payroll_group_before_tax = Request::input('payroll_group_before_tax');
          }
		
          $insert['payroll_group_before_tax']               = $payroll_group_before_tax;
		$insert['payroll_group_tax'] 					= Request::input('payroll_group_tax');
		$insert['payroll_group_sss'] 					= Request::input('payroll_group_sss');
		$insert['payroll_group_philhealth'] 			= Request::input('payroll_group_philhealth');
		$insert['payroll_group_pagibig'] 				= Request::input('payroll_group_pagibig');
		$insert['payroll_group_agency'] 				= Request::input('payroll_group_agency');
		$insert['payroll_group_target_hour'] 			= Request::input('payroll_group_target_hour');
		$insert['payroll_group_grace_time'] 			= Request::input('payroll_group_grace_time');
		$insert['payroll_group_agency_fee'] 			= Request::input('payroll_group_agency_fee');
		$insert['payroll_late_category'] 				= Request::input('payroll_late_category');
		$insert['payroll_late_interval'] 				= Request::input('payroll_late_interval');
		$insert['payroll_late_parameter'] 				= Request::input('payroll_late_parameter');
		$insert['payroll_late_deduction'] 				= Request::input('payroll_late_deduction');
		if(Request::has('payroll_group_is_flexi_break'))
		{
			$insert['payroll_group_is_flexi_break'] 	= Request::input('payroll_group_is_flexi_break');
		}
		$insert['payroll_group_break_start'] 			= date('H:i:s',strtotime(Request::input('payroll_group_break_start')));
		$insert['payroll_group_break_end'] 				= date('H:i:s',strtotime(Request::input('payroll_group_break_end')));
		$insert['payroll_group_flexi_break'] 			= Request::input('payroll_group_flexi_break');
		
		if(Request::has('payroll_group_is_flexi_time'))
		{
			$insert['payroll_group_is_flexi_time'] 		= Request::input('payroll_group_is_flexi_time');
		}
		
		$insert['payroll_group_working_day_month'] 		= Request::input('payroll_group_working_day_month');

          $payroll_group_target_hour_parameter              = 'Daily';

		if(Request::has('payroll_group_target_hour_parameter'))
		{
			$payroll_group_target_hour_parameter 	= Request::input('payroll_group_target_hour_parameter');
		}
          $insert['payroll_group_target_hour_parameter']    = $payroll_group_target_hour_parameter;
		$insert['payroll_group_target_hour'] 			= Request::input('payroll_group_target_hour');
		$insert['payroll_group_start'] 				= date('H:i:s',strtotime(Request::input('payroll_group_start')));
		$insert['payroll_group_end'] 					= date('H:i:s',strtotime(Request::input('payroll_group_end')));

		// dd($insert);
		/* INSERT PAYROLL GROUP AND GET ID */ 
		$group_id = Tbl_payroll_group::insertGetId($insert);

		$insert_rate = array();
		foreach(Request::input("payroll_overtime_name") as $key => $overtime)
		{
			$temp['payroll_group_id']				= $group_id;
			$temp['payroll_overtime_name'] 			= Request::input("payroll_overtime_name")[$key];
			$temp['payroll_overtime_regular'] 		= Request::input("payroll_overtime_regular")[$key];
			$temp['payroll_overtime_overtime'] 		= Request::input("payroll_overtime_overtime")[$key];
			$temp['payroll_overtime_nigth_diff'] 	= Request::input("payroll_overtime_nigth_diff")[$key];
			$temp['payroll_overtime_rest_day'] 		= Request::input("payroll_overtime_rest_day")[$key];
			$temp['payroll_overtime_rest_overtime'] 	= Request::input("payroll_overtime_rest_overtime")[$key];
			$temp['payroll_overtime_rest_night'] 	= Request::input("payroll_overtime_rest_night")[$key];

			array_push($insert_rate, $temp);
		}
		
		// dd($insert_rate);
		/* INSERT PAYROLL OVERTIME NIGHT DIFFERENTIALS REST DAY HOLIDAY */
		Tbl_payroll_overtime_rate::insert($insert_rate);



		$_restday 										= array();
		$_extraday 										= array();
		if(Request::has('restday'))
		{
			$_restday 									= Request::input('restday');
		}

		if(Request::has('extraday'))
		{
			$_extraday									= Request::input('extraday');
		}	
		
		
		$insert_rest_day = array();
		$temp = "";
		foreach($_restday as $restday)
		{
			$temp['payroll_group_id']					= $group_id;
			$temp['payroll_group_rest_day']				= $restday;
			$temp['payroll_group_rest_day_category']	= 'rest day';

			array_push($insert_rest_day, $temp);
		}

		$insert_extra_day = array();
		foreach($_extraday as $extra)
		{
			$temp['payroll_group_id']					= $group_id;
			$temp['payroll_group_rest_day']				= $extra;
			$temp['payroll_group_rest_day_category']	= 'extra day';

			array_push($insert_extra_day, $temp);
		}

		if(!empty($insert_rest_day))
		{
			Tbl_payroll_group_rest_day::insert($insert_rest_day);
		}

		if(!empty($insert_extra_day))
		{
			Tbl_payroll_group_rest_day::insert($insert_extra_day);
		}


		$data['_data'] 		= array();
		$data['selected'] 	= $group_id;
		$_group = Tbl_payroll_group::sel(Self::shop_id())->orderBy('payroll_group_code')->get();
		foreach($_group as $group)
		{
			$temp['id']		= $group->payroll_group_id;
			$temp['name']	= $group->payroll_group_code;
			$temp['attr']	= '';
			array_push($data['_data'], $temp);
		}

		$view = view('member.payroll.misc.misc_option', $data)->render();

		$return['view']				= $view;
		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_payroll_group';
		return json_encode($return);
	}

	public function modal_edit_payroll_group($id)
	{
		$data['group'] 			= Tbl_payroll_group::where('payroll_group_id',$id)->first();
		$data['_overtime_rate'] = Tbl_payroll_overtime_rate::where('payroll_group_id',$id)->get();
		$data['_day'] 			= Payroll::restday_checked($id); 
          $data['_period']         = Tbl_payroll_tax_period::check(Self::shop_id())->get();
		return view('member.payroll.modal.modal_edit_payroll_group',$data);
	}

	public function modal_update_payroll_group()
	{
		$payroll_group_id = Request::input("payroll_group_id");

		$update['payroll_group_code'] 					= Request::input('payroll_group_code');
		$update['payroll_group_salary_computation'] 	= Request::input('payroll_group_salary_computation');
		$update['payroll_group_period'] 				= Request::input('payroll_group_period');
		$update['payroll_group_13month_basis'] 			= Request::input('payroll_group_13month_basis');

		$update['payroll_group_grace_time'] 			= Request::input('payroll_group_grace_time');
		// $update['payroll_group_break']					= Request::input('payroll_group_break');
		$update['payroll_group_agency_fee'] 			= Request::input('payroll_group_agency_fee');
		
		$payroll_group_deduct_before_absences 			= 0;
		if( Request::has('payroll_group_deduct_before_absences'))
		{
			$payroll_group_deduct_before_absences		= Request::input('payroll_group_deduct_before_absences');
		}

          $payroll_group_before_tax                         = 0;
          if(Request::has('payroll_group_before_tax'))
          {
               $payroll_group_before_tax = Request::has('payroll_group_before_tax');
          }

          $update['payroll_group_before_tax']               = $payroll_group_before_tax;
		$update['payroll_group_deduct_before_absences']   = $payroll_group_deduct_before_absences;
		$update['payroll_group_tax'] 					= Request::input('payroll_group_tax');
		$update['payroll_group_sss'] 					= Request::input('payroll_group_sss');
		$update['payroll_group_philhealth'] 			= Request::input('payroll_group_philhealth');
		$update['payroll_group_pagibig'] 				= Request::input('payroll_group_pagibig');
		$update['payroll_group_agency'] 				= Request::input('payroll_group_agency');
		$update['payroll_group_agency_fee'] 			= Request::input('payroll_group_agency_fee');

		$payroll_group_is_flexi_break 					= 0;
		if(Request::has('payroll_group_is_flexi_break'))
		{
			$payroll_group_is_flexi_break 				= Request::input('payroll_group_is_flexi_break');
		}
		$update['payroll_group_is_flexi_break'] 		= $payroll_group_is_flexi_break;
		$update['payroll_group_flexi_break'] 			= Request::input('payroll_group_flexi_break');
		$update['payroll_late_category'] 				= Request::input('payroll_late_category');
		$update['payroll_late_interval'] 				= Request::input('payroll_late_interval');
		$update['payroll_late_parameter'] 				= Request::input('payroll_late_parameter');
		$update['payroll_late_deduction'] 				= Request::input('payroll_late_deduction');
		
		$payroll_group_is_flexi_time					= 0;
		if(Request::has('payroll_group_is_flexi_time'))
		{
			$payroll_group_is_flexi_time				= Request::input('payroll_group_is_flexi_time');	
		}

		$update['payroll_group_is_flexi_time'] 			= $payroll_group_is_flexi_time;
		$update['payroll_group_working_day_month'] 		= Request::input('payroll_group_working_day_month');

		$payroll_group_is_flexi_break = 0;
		if(Request::has('payroll_group_is_flexi_break'))
		{
			$payroll_group_is_flexi_break		= Request::input('payroll_group_is_flexi_break');

		}
		$update['payroll_group_break_start'] 			= date('H:i:s', strtotime(Request::input('payroll_group_break_start')));
		$update['payroll_group_break_end'] 				= date('H:i:s', strtotime(Request::input('payroll_group_break_end')));
		$update['payroll_group_flexi_break']			= Request::input('payroll_group_flexi_break');
		$update['payroll_group_is_flexi_break']			= $payroll_group_is_flexi_break;

          $payroll_group_target_hour_parameter              = 'Daily';
          if(Request::has('payroll_group_target_hour_parameter'))
          {    
               $payroll_group_target_hour_parameter         = Request::input('payroll_group_target_hour_parameter');
          }
		$update['payroll_group_target_hour_parameter'] 	= $payroll_group_target_hour_parameter;
		$update['payroll_group_target_hour'] 			= Request::input('payroll_group_target_hour');
		$update['payroll_group_start'] 					= date('H:i:s',strtotime(Request::input('payroll_group_start')));
		$update['payroll_group_end'] 					= date('H:i:s',strtotime(Request::input('payroll_group_end')));

		/* UPDATE PAYROLL GROUP*/ 
		Tbl_payroll_group::where('payroll_group_id',$payroll_group_id)->update($update);
		Tbl_payroll_overtime_rate::where('payroll_group_id',$payroll_group_id)->delete();
		$insert_rate = array();
		foreach(Request::input("payroll_overtime_name") as $key => $overtime)
		{
			$temp['payroll_group_id']				= $payroll_group_id;
			$temp['payroll_overtime_name'] 			= Request::input("payroll_overtime_name")[$key];
			$temp['payroll_overtime_regular'] 		= Request::input("payroll_overtime_regular")[$key];
			$temp['payroll_overtime_overtime'] 		= Request::input("payroll_overtime_overtime")[$key];
			$temp['payroll_overtime_nigth_diff'] 	= Request::input("payroll_overtime_nigth_diff")[$key];
			$temp['payroll_overtime_rest_day'] 		= Request::input("payroll_overtime_rest_day")[$key];
			$temp['payroll_overtime_rest_overtime'] 	= Request::input("payroll_overtime_rest_overtime")[$key];
			$temp['payroll_overtime_rest_night'] 	= Request::input("payroll_overtime_rest_night")[$key];

			array_push($insert_rate, $temp);
		}
		
		/* INSERT PAYROLL OVERTIME NIGHT DIFFERENTIALS REST DAY HOLIDAY */
		Tbl_payroll_overtime_rate::insert($insert_rate);

		$_restday 										= array();
		$_extraday 										= array();
		if(Request::has('restday'))
		{
			$_restday 									= Request::input('restday');
		}

		if(Request::has('extraday'))
		{
			$_extraday									= Request::input('extraday');
		}	
		
		Tbl_payroll_group_rest_day::where('payroll_group_id',$payroll_group_id)->delete();
		$insert_rest_day = array();
		$temp = "";
		foreach($_restday as $restday)
		{
			$temp['payroll_group_id']					= $payroll_group_id;
			$temp['payroll_group_rest_day']				= $restday;
			$temp['payroll_group_rest_day_category']	= 'rest day';

			array_push($insert_rest_day, $temp);
		}

		$insert_extra_day = array();
		foreach($_extraday as $extra)
		{
			$temp['payroll_group_id']					= $payroll_group_id;
			$temp['payroll_group_rest_day']				= $extra;
			$temp['payroll_group_rest_day_category']	= 'extra day';

			array_push($insert_extra_day, $temp);
		}

		if(!empty($insert_rest_day))
		{
			Tbl_payroll_group_rest_day::insert($insert_rest_day);
		}

		if(!empty($insert_extra_day))
		{
			Tbl_payroll_group_rest_day::insert($insert_extra_day);
		}


		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_payroll_group';
		return json_encode($return);
	}


	public function confirm_archived_payroll_group($archived, $payroll_group_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_group::where('payroll_group_id',$payroll_group_id)->pluck('payroll_group_code');
		$data['title'] 		= 'Do you really want to '.$statement.' Payroll Group '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/payroll_group/archived_payroll_group';
		$data['id'] 		= $payroll_group_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_payroll_group()
	{
		$payroll_group_id = Request::input('id');
		$update['payroll_group_archived'] = Request::input('archived');
		Tbl_payroll_group::where('payroll_group_id',$payroll_group_id)->update($update);

		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_payroll_group';
		return json_encode($return);
	}

	/* PAYROLL GROUP END */


     /* PAYROLL JOURNAL START */
     public function payroll_jouarnal()
     {
          $data['_tag'] = Tbl_payroll_journal_tag::gettag(Self::shop_id())->orderBy('tbl_chart_of_account.account_name')->get();
          return view('member.payroll.side_container.journal', $data);
     }

     public function modal_create_journal_tag()
     {
          /* account_type_id = 13 = Expense */

          $account_type_id = [1,3,8,13];

          $data['_expense'] = Tbl_chart_of_account::getbytype(Self::shop_id(), $account_type_id)->orderBy('account_name')->get();

          $data['_entity']  = collect(Tbl_payroll_entity::orderBy('entity_name')->get()->toArray())->groupBy('entity_category');
          
          return view('member.payroll.modal.modal_create_journal_tag', $data);
     }

     public function create_journal_tag()
     {    
          // Tbl_payroll_journal_tag
          // Tbl_payroll_journal_tag_entity
          // Tbl_payroll_journal_tag_employee
          $insert_tag['account_id']     = Request::input('account_id');
          $insert_tag['shop_id']        = Self::shop_id();

          $payroll_journal_tag_id = Tbl_payroll_journal_tag::insertGetId($insert_tag);

          $insert_entity = array();

          if(Request::has('entity'))
          {
               foreach(Request::input('entity') as $entity)
               {
                    $temp['payroll_journal_tag_id'] = $payroll_journal_tag_id;
                    $temp['payroll_entity_id']      = $entity;

                    array_push($insert_entity, $temp);
               }
          }

          if(!empty($insert_entity))
          {
               Tbl_payroll_journal_tag_entity::insert($insert_entity);
          }    


          $return['status'] = 'success';
          $return['function_name'] = 'payrollconfiguration.reload_journal_tags';

          return collect($return)->toJson();
          
     }   

     public function modal_edit_journal_tag($id)
     {

          $data['tag'] = Tbl_payroll_journal_tag::where('payroll_journal_tag_id', $id)->first();

          $account_type_id = [1,3,8,13];

          $data['_expense'] = Tbl_chart_of_account::getbytype(Self::shop_id(), $account_type_id)->orderBy('account_name')->get();

          $data['_entity'] = array();
          $_entity  = collect(Tbl_payroll_entity::orderBy('entity_name')->get()->toArray())->groupBy('entity_category');

          foreach($_entity as $key => $entity_data)
          {
               $data['_entity'][$key] = array();
               foreach($entity_data as $entity)
               {
                    $count = Tbl_payroll_journal_tag_entity::checkentity($id, $entity['payroll_entity_id'])->count();

                    $entity['status'] = '';
                    if($count == 1)
                    {
                         $entity['status'] = 'checked';
                    }
                    array_push($data['_entity'][$key], $entity);
               }
          }
          // dd($data['_entity']);

          return view('member.payroll.modal.modal_edit_journal_tag', $data);
     } 

     public function modal_confimr_del_journal_tag($id)
     {

          $data['title']      = 'Do you really want to remove this tag?';
          $data['html']       = '';
          $data['action']     = '/member/payroll/payroll_jouarnal/del_journal_tag';
          $data['id']         = $id;
          $data['archived']   = 1;

          return view('member.modal.modal_confirm_archived', $data);
     }

     public function del_journal_tag()
     {
          $id = Request::input('id');
          Tbl_payroll_journal_tag::where('payroll_journal_tag_id',$id)->delete();
          $return['status'] = 'success';
          $return['function_name'] = 'payrollconfiguration.reload_journal_tags';

          return collect($return)->toJson();
     }

     public function update_payroll_journal_tag()
     {
          $payroll_journal_tag_id = Request::input('payroll_journal_tag_id');
          $update['account_id'] = Request::input('account_id');
          Tbl_payroll_journal_tag::where('payroll_journal_tag_id', $payroll_journal_tag_id)->update($update);

          Tbl_payroll_journal_tag_entity::where('payroll_journal_tag_id', $payroll_journal_tag_id)->delete();

          $insert_entity = array();

          if(Request::has('entity'))
          {
               foreach(Request::input('entity') as $entity)
               {
                    $temp['payroll_journal_tag_id'] = $payroll_journal_tag_id;
                    $temp['payroll_entity_id']      = $entity;

                    array_push($insert_entity, $temp);
               }
          }

          if(!empty($insert_entity))
          {
               Tbl_payroll_journal_tag_entity::insert($insert_entity);
          }    


          $return['status'] = 'success';
          $return['function_name'] = 'payrollconfiguration.reload_journal_tags';

          return collect($return)->toJson();
     }

     public function relaod_payroll_journal_sel()
     {
          $id = Request::input('id');
          $_expense = Tbl_chart_of_account::getbytype(Self::shop_id(), 13)->orderBy('account_name')->get()->toArray();

          $html = '';
          foreach($_expense as $expense)
          {
               $status = '';
               if($expense['account_id'] == $id)
               {
                    $status = 'selected="selected"';
               }
               $html.='<option value="'.$expense['account_id'].'" '.$status.'>'.$expense['account_number'].' . '.$expense['account_name'].'</option>';
          }
          return $html;
     }

     /* PAYROLL JOUARNAL END */ 


     /* PAYROLL CUSTOM PAYSLIP START */

     public function custom_payslip()
     {
          return view('member.payroll.side_container.custom_payslip');
     }

     public function modal_create_payslip()
     {
          $data['_paper'] = Tbl_payroll_paper_sizes::getpaper(Self::shop_id())->orderBy('paper_size_name')->get();
          return view('member.payroll.modal.modal_create_payslip', $data);
     }

     public function modal_create_paper_size()
     {
          $data['_paper'] = Tbl_payroll_paper_sizes::getpaper(Self::shop_id())->orderBy('paper_size_name')->get();
          return view('member.payroll.modal.modal_create_paper_size', $data);
     }

     /* PAYROLL CUSTOM PAYSLIP END */


	/* PAYROLL PERIOD START*/
	public function payroll_period_list()
	{	
		$data['_active'] = Tbl_payroll_period::sel(Self::shop_id())->orderBy('payroll_period_start','desc')->paginate($this->paginate_count);
		$data['_archived'] = Tbl_payroll_period::sel(Self::shop_id(), 1)->orderBy('payroll_period_start','desc')->paginate($this->paginate_count);
		return view('member.payroll.payroll_period_list', $data);
	}

	public function modal_create_payroll_period()
	{
		$data['_tax'] = Tbl_payroll_tax_period::check(Self::shop_id())->get();
		return view('member.payroll.modal.modal_create_payroll_period', $data);
	}
	public function modal_save_payroll_period()
	{
		$insert['shop_id'] 					= Self::shop_id();
		$insert['payroll_period_start'] 	     = date('Y-m-d',strtotime(Request::input('payroll_period_start')));
		$insert['payroll_period_end'] 		= date('Y-m-d',strtotime(Request::input('payroll_period_end')));
		$insert['payroll_period_category'] 	= Request::input('payroll_period_category');

          $count = Tbl_payroll_period::check($insert)->count();

          if($count == 0)
          {

               $payroll_period_id = Tbl_payroll_period::insertGetId($insert);

               $insert_company = array();

               $_company = Tbl_payroll_company::selcompany(Self::shop_id())->get();

               foreach($_company as $key => $company)
               {
                    $insert_company[$key]['payroll_period_id']        = $payroll_period_id;
                    $insert_company[$key]['payroll_company_id']  = $company->payroll_company_id;
                    $insert_company[$key]['payroll_period_status']    = 'pending';
               }

               if(!empty($insert_company))
               {
                    Tbl_payroll_period_company::insert($insert_company);
               }

          }
		
		$return['status'] = 'success';
		$return['function_name'] = 'payroll_period_list.reload_list';
		return json_encode($return);
	}

	public function modal_archive_period($archived, $payroll_period_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$_query 			= Tbl_payroll_period::where('payroll_period_id',$payroll_period_id)->first();
		// dd($_query);
		$file_name 			= date('M d, Y', strtotime($_query->payroll_period_start)).' to '.date('M d, Y', strtotime($_query->payroll_period_end));
		$data['title'] 		= 'Do you really want to '.$statement.' payroll period of '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/payroll_period_list/archive_period';
		$data['id'] 		= $payroll_period_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archive_period()
	{
		$payroll_period_id = Request::input('id');
		$update['payroll_period_archived'] = Request::input('archived');
		Tbl_payroll_period::where('payroll_period_id',$payroll_period_id)->update($update);

		$return['status'] = 'success';
		$return['function_name'] = 'payroll_period_list.reload_list';
		return json_encode($return);
	}

	public function modal_edit_period($payroll_period_id)
	{
		$data['period'] = Tbl_payroll_period::where('payroll_period_id',$payroll_period_id)->first();
		$data['_tax'] = Tbl_payroll_tax_period::check(Self::shop_id())->get();
		return view('member.payroll.modal.modal_edit_period', $data);
	}

	public function modal_update_period()
	{
		$payroll_period_id 			 		= Request::input("payroll_period_id");
		$update['payroll_period_category'] 	= Request::input("payroll_period_category");
		$update['payroll_period_start'] 	= date('Y-m-d',strtotime(Request::input("payroll_period_start")));
		$update['payroll_period_end'] 		= date('Y-m-d',strtotime(Request::input("payroll_period_end")));
		Tbl_payroll_period::where('payroll_period_id',$payroll_period_id)->update($update);

		$insert_company = array();

		$_company = Tbl_payroll_company::selcompany(Self::shop_id())->get();

		foreach($_company as $key => $company)
		{
			$count = Tbl_payroll_period_company::where('payroll_company_id',$company->payroll_company_id)->where('payroll_period_id', $payroll_period_id)->count();
			if($count == 0)
			{
				$temp_insert['payroll_period_id'] 		= $payroll_period_id;
				$temp_insert['payroll_company_id'] 		= $company->payroll_company_id;
				$temp_insert['payroll_period_status'] 	= 'pending';
				array_push($insert_company, $temp_insert);
			}	
			
		}
		// dd($insert_company);
		if(!empty($insert_company))
		{
			Tbl_payroll_period_company::insert($insert_company);
		}

		$return['status'] = 'success';
		$return['function_name'] = 'payroll_period_list.reload_list';
		return json_encode($return);
	}
	/* PAYROLL PERIOD END */

	/*HOLIDAY DEFAULT START*/
	public function modal_create_holiday_default()
	{
		/*$data = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('payroll_company_name')->get();*/
		return view('member.payroll.modal.modal_create_holiday_default');
	}

	public function modal_save_holiday_default()
	{		
		$insert['payroll_holiday_name'] 	= Request::input('payroll_holiday_name');
		$insert['payroll_holiday_date'] 	= date('Y-m-d',strtotime(Request::input('payroll_holiday_date')));
		$insert['payroll_holiday_category'] = Request::input('payroll_holiday_category');

		Tbl_payroll_holiday_default::insert($insert);

		$date_inserted = $insert['payroll_holiday_date'];
		$data['_active'] = Tbl_payroll_holiday::where('payroll_holiday_date', $date_inserted)->first();

		if (!$data['_active']) 
		{	
			$insert['shop_id']	= Self::shop_id();
		 	Tbl_payroll_holiday::insert($insert);		 	
		} 

		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_holiday';
		return json_encode($return);
	}

	public function modal_edit_holiday_default($id)
	{	
		$data['_active'] = Tbl_payroll_holiday_default::where('payroll_holiday_default_id', $id)->first();
		return view('member.payroll.modal.modal_edit_holiday_default', $data);
	}

	public function update_holiday_default()
	{
		$payroll_holiday_default_id 			= Request::input('payroll_holiday_default_id');
		$update['payroll_holiday_name'] 		= Request::input('payroll_holiday_name');
		$update['payroll_holiday_date'] 		= date('Y-m-d',strtotime(Request::input('payroll_holiday_date')));
		$update['payroll_holiday_category'] 	= Request::input('payroll_holiday_category');		
		Tbl_payroll_holiday_default::where('payroll_holiday_default_id', $payroll_holiday_default_id)->update($update);
		
		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_holiday';
		return json_encode($return);
	}
	
	/*HOLIDAY DEFAULT END*/


     /* CALENDAR LEAVE START */
     public function leave_schedule()
     {
          $data['_upcoming'] = Self::leave_schedule_break();

          $data['_used'] = Self::leave_schedule_break('<');

          return view('member.payroll.leave_schedule', $data);
     }

     public function leave_schedule_break($param = '>=')
     {
          $_leave = collect(Tbl_payroll_leave_schedule::getlist(Self::shop_id(), date('Y-m-d'), $param)->orderBy('payroll_schedule_leave','desc')->get()->toArray())->groupBy('payroll_schedule_leave');
          return $_leave;
     }

     public function modal_create_leave_schedule()
     {
          $data['_leave'] = Tbl_payroll_leave_temp::sel(self::shop_id())->orderBy('payroll_leave_temp_name')->get();
          // dd($data);
          return view('member.payroll.modal.modal_create_leave_schedule', $data);
     }

     public function leave_schedule_tag_employee($id)
     {
          $data['_company']        = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();
          $data['_department']     = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
          $data['leave_id']        =    $id;
          $data['action']          =    '/member/payroll/leave_schedule/session_tag_leave';

          Session::put('employee_leave_tag', array());

          return view('member.payroll.modal.modal_schedule_employee_leave', $data);
     }

     public function ajax_shecdule_leave_tag_employee()
     {
          $company       = Request::input('company');
          $department    = Request::input('department');
          $jobtitle      = Request::input('jobtitle');
          $leave_id      = Request::input("leave_id");

          // dd($leave_id);
          $emp = Tbl_payroll_employee_contract::employeefilter($company, $department, $jobtitle, date('Y-m-d'), Self::shop_id())
                    ->join('tbl_payroll_leave_employee','tbl_payroll_leave_employee.payroll_employee_id','=','tbl_payroll_employee_contract.payroll_employee_id')
                    ->join('tbl_payroll_leave_temp','tbl_payroll_leave_temp.payroll_leave_temp_id','=','tbl_payroll_leave_employee.payroll_leave_temp_id')
                    ->leftjoin('tbl_payroll_leave_schedule','tbl_payroll_leave_schedule.payroll_leave_employee_id','=','tbl_payroll_leave_employee.payroll_leave_employee_id')
                    ->where('tbl_payroll_leave_employee.payroll_leave_temp_id',$leave_id)
                    ->where('tbl_payroll_leave_employee.payroll_leave_employee_is_archived', 0)

                    ->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')
                    ->groupBy('tbl_payroll_employee_basic.payroll_employee_id')
                    ->select(DB::raw('*, tbl_payroll_leave_employee.payroll_leave_employee_id as leave_employee_id, (tbl_payroll_leave_temp.payroll_leave_temp_days_cap - (select count(tbl_payroll_leave_schedule.payroll_leave_employee_id) from tbl_payroll_leave_schedule where (tbl_payroll_leave_schedule.payroll_schedule_leave  BETWEEN "'.date('Y').'-01-01" and "'.date('Y').'-12-31") and tbl_payroll_leave_schedule.payroll_leave_employee_id = leave_employee_id)) as available_count, tbl_payroll_leave_employee.payroll_leave_employee_id as payroll_leave_employee_id_2'))
                    ->get();

          return json_encode($emp);
     }

     public function session_tag_leave()
     {
          // Tbl_payroll_leave_schedule
          $employee_tag = array();

          if(Session::has('employee_leave_tag'))
          {
               $employee_tag = Session::get('employee_leave_tag');
          }

          foreach(Request::input('employee_tag') as $tag)
          {
               if(!in_array($tag, $employee_tag))
               {
                    array_push($employee_tag, $tag);
               }
          }
          Session::put('employee_leave_tag', $employee_tag);

          $data['status'] = 'success';
          $data['function_name'] = 'employee_tag_schedule_leave.load_tagged_employee';

          return collect($data)->toJson();
     }


     public function get_session_leave_tag()
     {
          $employee = [0 => 0];
          if(Session::has('employee_leave_tag'))
          {
               $employee = Session::get('employee_leave_tag');
          }

          $emp = Tbl_payroll_employee_basic::whereIn('payroll_employee_id',$employee)->get();
          $data['new_record'] = $emp;

          return json_encode($data);
     }


     public function save_schedule_leave_tag()
     {
          // Tbl_payroll_leave_schedule
          $payroll_schedule_leave = Request::input('payroll_schedule_leave');
          if(Request::has('employee_tag'))
          {
               $insert = array();

               foreach(Request::input('employee_tag') as $tag)
               {
                    $temp['payroll_leave_employee_id']    = $tag;
                    $temp['payroll_schedule_leave']       = datepicker_input($payroll_schedule_leave);
                    $temp['shop_id']                      = Self::shop_id();

                    array_push($insert, $temp);
               }
               if(!empty($insert))
               {
                    Tbl_payroll_leave_schedule::insert($insert);
               }
          }    

          $data['stataus']         = 'success';
          $data['function_name']   = '';

          return collect($data)->toJson();
     }

     public function delete_confirm_schedule_leave($id)
     {
          // $leave              = Tbl_payroll_leave_schedule::specific($id)->first();
          $data['title']      = 'Do you really want to remove this schedule';
          $data['action']     = '/member/payroll/leave_schedule/delete_schedule_leave';
          $data['id']         = $id;
          $data['html']       = '';

          return view('member.modal.modal_confirm_archived', $data);
     }

     public function delete_schedule_leave()
     {
          $id = Request::input('id');
          Tbl_payroll_leave_schedule::where('payroll_leave_schedule_id', $id)->delete();

          $data['status'] = 'success';
          $data['function_name'] = '';

          return collect($data)->toJson();
     }

     public function unset_session_leave_tag()
     {
          $content = Request::input('content');
          $array     = Session::get('employee_leave_tag');
          if(($key = array_search($content, $array)) !== false) {
              unset($array[$key]);
          }
          Session::put('employee_leave_tag', $array);
     }

     /* CALDENDAR LEAVE END */


     /* PAYROLL TIME KEEPING START */
     public function time_keeping()
     {
          $data['_period'] = Tbl_payroll_period::sel(Self::shop_id())->where('payroll_period_status','!=','pending')->orderBy('payroll_period_category')->orderBy('payroll_period_start','desc')->get();
          return view('member.payroll.payroll_timekeeping', $data);
     }

     public function modal_generate_period()
     {

          $data['_period'] = Tbl_payroll_period::sel(Self::shop_id())->where('payroll_period_status','pending')->orderBy('payroll_period_start','desc')->paginate(20);
          // dd($data);
          return view('member.payroll.modal.modal_generate_period', $data);
     }

     public function generate_period()
     {
          if(Request::has('payroll_period_id'))
          {
               $_payroll_period_id = Request::input('payroll_period_id');
               foreach($_payroll_period_id as $payroll_period_id)
               {
                    $update['payroll_period_status'] = 'generated';
                    Tbl_payroll_period::where('payroll_period_id',$payroll_period_id)->update($update);
               }
          }

          $return['message']       = 'success';
          $return['function_name'] = 'payroll_timekeeping.reload_timekeeping';
          return json_encode($return);
     }

     public function company_period($id)
     {
          $param['payroll_period_id']   = $id;
          $param['shop_id']             = Self::shop_id();
          $count = Tbl_payroll_period::check($param)->count();
          if($count == 0)
          {
               return Redirect::to('/member/payroll/time_keeping')->send();
          }
          $data['_company']   = Self::company_badge($id);
          $data['period']     = Tbl_payroll_period::where('payroll_period_id', $id)->first();

          return view('member.payroll.payroll_timekeeping_company',$data);
     }

     public function company_badge($id)
     {
          $return = array();
          $_data = Tbl_payroll_period_company::selperiod($id)->orderBy('tbl_payroll_company.payroll_company_name')->select('tbl_payroll_period_company.*','tbl_payroll_company.payroll_company_name')->get();
          foreach($_data as $data)
          {
               $temp['payroll_period_company_id'] = $data->payroll_period_company_id;
               $temp['payroll_company_name']      = $data->payroll_company_name;
               $temp['payroll_period_status']     = $data->payroll_period_status;
               $badge                             = 'custom-badge-default';
               if($data->payroll_period_status == 'ready')
               {
                    $badge = 'custom-badge-primary';
               }
               else if($data->payroll_period_status == 'processed' || $data->payroll_period_status == 'posted' || $data->payroll_period_status == 'registered')
               {
                    $badge = 'custom-badge-warning';
               }
               else if($data->payroll_period_status == 'approved')
               {
                    $badge = 'custom-badge-success';
               }
               $temp['badge'] = $badge;
               array_push($return, $temp);
          }
          return $return;
     }

     public function no_records()
     {
          return  view('member.payroll.misc.no_records');
     }


     public function mark_ready_company()
     {
          $content = Request::input("content");
          $update['payroll_period_status'] = 'ready';
          // dd($content);
          Tbl_payroll_period_company::where('payroll_period_company_id',$content)->update($update);
          return 'success';
     }
     // public function 

     /* PAYROLL TIME KEEPING END */



     /* PAYROLL PROCESS START */
     public function payroll_process()
     {
          $data['_period'] = Payroll::process_compute(Self::shop_id(), 'processed');
          // dd($data);
          return view('member.payroll.payroll_process', $data);
     }

     public function modal_create_process()
     {
          $data['_period'] = Tbl_payroll_tax_period::check(Self::shop_id())->get();
          return view('member.payroll.modal.modal_create_payroll_process',$data);
     }

     public function ajax_load_payroll_period()
     {
          $tax = Request::input('tax');
          $data = Tbl_payroll_period_company::getperiod(Self::shop_id(), $tax)
                                             ->select(DB::raw("DATE_FORMAT(tbl_payroll_period.payroll_period_start, '%b %d, %y') as start,DATE_FORMAT(tbl_payroll_period.payroll_period_end, '%b %d, %y') as end, tbl_payroll_period.payroll_period_id"))
                                             ->orderBy('tbl_payroll_period.payroll_period_start')
                                             ->get();

          return $data->toJson();
     }

     public function ajax_payroll_company_period()
     {
          $period = Request::input('period');
          $data = Tbl_payroll_period_company::selperiod($period)
                                             ->where('tbl_payroll_period_company.payroll_period_status','ready')
                                             ->orderBy('tbl_payroll_company.payroll_company_name')
                                             ->groupBy('tbl_payroll_company.payroll_company_id')
                                             ->get()
                                             ->toJson();
          return $data;
     }

     public function process_payroll()
     {
          if(Request::has('company_period'))
          {
               $company_period = Request::input('company_period');
               foreach($company_period as $period)
               {
                    $update['payroll_period_status'] = 'processed';
                    Tbl_payroll_period_company::where('payroll_period_company_id', $period)->update($update);
               }
          }

          $return['status']        = 'success';
          $return['function_name'] = 'reload_page';
          return json_encode($return);
          
     }

     /* PAYROLL COMPUTATION BREAKDOWN */
     public function payroll_compute_brk_unsaved($employee_id, $payroll_period_company_id)
     {
          $period = Tbl_payroll_period_company::sel($payroll_period_company_id)->first();

          $process = Payroll::compute_per_employee($employee_id, $period->payroll_period_start, $period->payroll_period_end, Self::shop_id(), $period->payroll_period_category, $payroll_period_company_id);

          $data['emp'] = Tbl_payroll_employee_basic::where('payroll_employee_id',$employee_id)->first();

          $data['_breakdown'] = Self::breakdown_uncompute($process);
          $data['payroll_period_company_id'] = $payroll_period_company_id;
          $data['status'] = 'process';
          // dd($data);
          return view('member.payroll.modal.modal_view_payroll_computation_unsaved',$data);

     }

     public function breakdown_uncompute($process = array(), $status = 'processed')
     {
          // dd($process);
          $data = array();

          $computation   = array();
          $time          = array();
          $day           = array();

          $salary        = array();
          $government    = array();
          $deduction     = array();

          
          /* RATE DECLARATION */
          $temp = '';
          $temp['name']       = '<b>Rate</b>';
          $temp['amount']     = '';
          $temp['sub']        = array();
          array_push($salary, $temp);

          $temp = '';
          $temp['name']       = 'Monthly Rate';
          $temp['amount']     = number_format($process['salary_monthly'], 2);
          $temp['sub']        = array();
          array_push($salary, $temp);

          $temp = '';
          $temp['name']       = 'Daily Rate';
          $temp['amount']     = number_format($process['salary_daily'], 2);
          $temp['sub']        = array();
          array_push($salary, $temp);
          
          /* ALL POSITIVE */

          $temp = '';
          if($process['total_gross'] > 0)
          {    
               $temp['name']       = '<b>Salary</b>';
               $temp['amount']     = '';
               $temp['sub']        = array();
               array_push($salary, $temp);
          }    

          $temp = '';
          if($process['regular_salary'] > 0)
          {    
               $temp['name']       = 'Basic Salary';
               $temp['amount']     = number_format($process['regular_salary'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }    


          $regular_overtime = $process['regular_reg_overtime'] + $process['extra_reg_overtime'] + $process['rest_day_reg_overtime'] + $process['rest_day_sh_reg_overtime'] + $process['rest_day_rh_reg_overtime'] + $process['rh_reg_overtime'] + $process['sh_reg_overtime'];

          $temp = '';
          if($regular_overtime > 0)
          {    
               $temp['name']       = 'Regular OT';
               $temp['amount']     = number_format($regular_overtime, 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }

          $early_overtime = $process['regular_early_overtime'] + $process['extra_early_overtime'] + $process['rest_day_early_overtime'] + $process['rest_day_sh_early_overtime'] + $process['rest_day_rh_early_overtime'] + $process['rh_early_overtime'] + $process['sh_early_overtime'];

          $temp = '';
          if($early_overtime > 0)
          {    
               $temp['name']       = 'Early OT';
               $temp['amount']     = number_format($early_overtime, 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }

          $night_differentials = $process['regular_night_diff'] + $process['extra_night_diff'] + $process['rest_day_night_diff'] + $process['rest_day_sh_night_diff'] + $process['rest_day_rh_night_diff'] + $process['rh_night_diff'] + $process['sh_night_diff'];

          $temp = '';
          if($night_differentials > 0)
          {    
               $temp['name']       = 'Early OT';
               $temp['amount']     = number_format($night_differentials, 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }

          $temp = '';
          if($process['extra_salary'] > 0)
          {    
               $temp['name']       = 'Extra Day';
               $temp['amount']     = number_format($process['extra_salary'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }   

          $temp = '';
          if($process['rest_day_salary'] > 0)
          {    
               $temp['name']       = 'Rest Day';
               $temp['amount']     = number_format($process['rest_day_salary'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }   

          $temp = '';
          if($process['rest_day_sh'] > 0)
          {    
               $temp['name']       = 'Rest Day + Special Holiday';
               $temp['amount']     = number_format($process['rest_day_sh'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }    

          $temp = '';
          if($process['rest_day_rh'] > 0)
          {    
               $temp['name']       = 'Rest Day + Regular Holiday';
               $temp['amount']     = number_format($process['rest_day_rh'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }   

          $temp = '';
          if($process['rh_salary'] > 0)
          {    
               $temp['name']       = 'Regular Holiday';
               $temp['amount']     = number_format($process['rh_salary'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }   

          $temp = '';
          if($process['sh_salary'] > 0)
          {    
               $temp['name']       = 'Special Holiday';
               $temp['amount']     = number_format($process['sh_salary'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }    

          $temp = '';
          if($process['13_month'] > 0)
          {    
               $temp['name']       = '13 month Pay';
               $temp['amount']     = number_format($process['13_month'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }   

          $temp = '';
          if($process['payroll_cola'] > 0)
          {    
               $temp['name']       = 'COLA';
               $temp['amount']     = number_format($process['payroll_cola'], 2);
               $temp['sub']        = array();
               array_push($salary, $temp);
          }   

          $temp = '';
          $total_allowance = $process['adjustment']['total_allowance'] + $process['total_allowance'];

          if($total_allowance > 0)
          {    
               $temp['name']       = '<b>Allowance</b>';
               $temp['amount']     = '';
               $temp['sub']        = array();
               foreach($process['allowance'] as $allowance)
               {
                    $temp_sub['name'] = $allowance['payroll_allowance_name'];
                    $temp_sub['amount'] = number_format($allowance['payroll_allowance_amount'], 2);
                    array_push($temp['sub'], $temp_sub);
               }

               foreach($process['adjustment']['allowance'] as $allowances)
               {
                    $temp_sub['name'] = $allowances->payroll_adjustment_name;
                    if($status == 'processed')
                    {
                         $temp_sub['name'].=Self::btn_adjustment($allowances->payroll_adjustment_id);
                    }
                    $temp_sub['amount'] = number_format($allowances->payroll_adjustment_amount, 2);
                    array_push($temp['sub'], $temp_sub);
               }

               array_push($salary, $temp);
          }  



          $temp = '';
          if($process['adjustment']['total_bonus'] > 0)
          {    
               $temp['name']       = '<b>Bonus</b>';
               $temp['amount']     = '';
               $temp['sub']        = array();
               foreach($process['adjustment']['bonus'] as $bonus)
               {
                    $temp_sub['name'] = $bonus->payroll_adjustment_name;
                    if($status == 'processed')
                    {
                         $temp_sub['name'].=Self::btn_adjustment($bonus->payroll_adjustment_id);
                    }
                    $temp_sub['amount'] = number_format($bonus->payroll_adjustment_amount, 2);
                    array_push($temp['sub'], $temp_sub);
               }
               array_push($salary, $temp);
          }  

          $temp = '';
          if($process['adjustment']['total_incentives'] > 0)
          {    
               $temp['name']       = '<b>Incentives</b>';
               $temp['amount']     = '';
               $temp['sub']        = array();
               foreach($process['adjustment']['incentives'] as $incentives)
               {
                    $temp_sub['name'] = $incentives->payroll_adjustment_name;
                    if($status == 'processed')
                    {
                         $temp_sub['name'].=Self::btn_adjustment($incentives->payroll_adjustment_id);
                    }
                    $temp_sub['amount'] = number_format($incentives->payroll_adjustment_amount, 2);
                    array_push($temp['sub'], $temp_sub);
               }
               array_push($salary, $temp);
          }  

          $temp = '';
          if($process['adjustment']['total_commission'] > 0)
          {    
               $temp['name']       = '<b>Commission</b>';
               $temp['amount']     = '';
               $temp['sub']        = array();
               foreach($process['adjustment']['commission'] as $commission)
               {
                    $temp_sub['name'] = $commission->payroll_adjustment_name;
                    if($status == 'processed')
                    {
                         $temp_sub['name'].=Self::btn_adjustment($commission->payroll_adjustment_id);
                    }
                    $temp_sub['amount'] = number_format($commission->payroll_adjustment_amount, 2);
                    array_push($temp['sub'], $temp_sub);
               }
               array_push($salary, $temp);
          }  


           $temp = '';
          if($process['total_gross'] > 0)
          {    
               $temp['name']       = '<b>Gross</b>';
               $temp['amount']     = '<b>'.number_format($process['total_gross'], 2).'</b>';
               $temp['sub']        = array();
               array_push($salary, $temp);
          }  



          /* ALL GOVERMENT */
          $total_contribution = $process['tax_contribution'] + $process['sss_contribution_ee'] + $process['pagibig_contribution'] + $process['philhealth_contribution_ee'];

          $temp = '';
          if($total_contribution > 0)
          {    
               $temp['name']       = '<b>Goverment Contribution</b>';
               $temp['amount']     = '';
               $temp['sub']        = array();
               array_push($government, $temp);
          }  

          $temp = '';
          if($process['sss_contribution_ee'] > 0)
          {    
               $temp['name']       = 'SSS';
               $temp['amount']     = number_format($process['sss_contribution_ee'], 2);
               $temp['sub']        = array();
               array_push($government, $temp);
          }  


          $temp = '';
          if($process['philhealth_contribution_ee'] > 0)
          {    
               $temp['name']       = 'Philhealth';
               $temp['amount']     = number_format($process['philhealth_contribution_ee'], 2);
               $temp['sub']        = array();
               array_push($government, $temp);
          }  

          $temp = '';
          if($process['pagibig_contribution'] > 0)
          {    
               $temp['name']       = 'PAGIBIG';
               $temp['amount']     = number_format($process['pagibig_contribution'], 2);
               $temp['sub']        = array();
               array_push($government, $temp);
          }  


          $temp = '';
          if($process['tax_contribution'] > 0)
          {    
               $temp['name']       = 'Tax';
               $temp['amount']     = number_format($process['tax_contribution'], 2);
               $temp['sub']        = array();
               array_push($government, $temp);
          }  

          $temp = '';
          if($total_contribution > 0)
          {    
               $temp['name']       = '<b>Total Contribution</b>';
               $temp['amount']     = '<b>'.number_format($total_contribution, 2).'</b>';
               $temp['sub']        = array();
               array_push($government, $temp);
          }  


          // deduction
          /* OTHER DEDUCTIONS */
          $total_deduction = collect($process['deduction'])->sum('payroll_periodal_deduction') + $process['late_deduction'] + $process['adjustment']['total_deductions'];

          $temp = '';
          if($total_deduction > 0)
          {    
               $temp['name']       = '<b>Deduction</b>';
               $temp['amount']     = '';
               $temp['sub']        = array();
               array_push($deduction, $temp);
          }  

          $temp = '';
          if($process['late_deduction'] > 0)
          {    
               $temp['name']       = 'Late';
               $temp['amount']     = number_format($process['late_deduction'], 2);
               $temp['sub']        = array();
               array_push($deduction, $temp);
          }  

          $temp = '';
          if($process['under_time'] > 0)
          {    
               $temp['name']       = 'Under Time';
               $temp['amount']     = number_format($process['under_time'], 2);
               $temp['sub']        = array();
               array_push($deduction, $temp);
          }  

          $temp = '';
          if($process['adjustment']['total_deductions'] > 0)
          {    
               foreach($process['adjustment']['deductions'] as $deductions) 
               {
                    $temp['name']       = $deductions->payroll_adjustment_name;
                    if($status == 'processed')
                    {
                         $temp_sub['name'].=Self::btn_adjustment($deductions->payroll_adjustment_id);
                    }
                    $temp['amount']     = number_format($deductions->payroll_adjustment_amount, 2);

                    $temp['sub']        = array();
                    array_push($deduction, $temp);
               }    

               
          }  

          $temp = '';
          if(!empty($process['deduction']))
          {    
               $_collect = collect($process['deduction'])->groupBy('deduction_category');

               foreach($_collect as $collect)
               {
                    $_deduction = collect($collect)->sortBy('deduction_name');

                    $temp['name']       = '<b>'.$_deduction[0]['deduction_category'].'</b>';
                    $temp['amount']     = '';
                    $temp['sub']        = array();
                    
                    foreach($_deduction as $deductionlist)
                    {
                         $temp_sub['name']       = $deductionlist['deduction_name'];
                         $temp_sub['amount']     = number_format($deductionlist['payroll_periodal_deduction'], 2);
    
                         array_push($temp['sub'], $temp_sub);
                    }

                    array_push($deduction, $temp);
               }

               
          }  

          
          // dd($total_deduction);

          $temp = '';
          if($total_deduction > 0)
          {    
               $temp['name']       = '<b>Total Deduction</b>';
               $temp['amount']     = '<b>'.number_format($total_deduction, 2).'</b>';
               $temp['sub']        = array();
               array_push($deduction, $temp);
          }  

          $total_net = array();
          $temp = '';
          if($process['total_net'] > 0)
          {    
               $temp['name']       = '<b>Net Salary</b>';
               $temp['amount']     = '<b>'.number_format($process['total_net'], 2).'</b>';
               $temp['sub']        = array();
               array_push($total_net, $temp);
          }  

          array_push($computation, $salary);
          array_push($computation, $government);
          array_push($computation, $deduction);
          array_push($computation, $total_net);

          /* TIME */
          $temp = '';
          $temp['name']     = 'Regular Hours';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['regular_hours']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Regular Overtime';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['late_overtime']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Early Overtime';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['early_overtime']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Night Differential Hour';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['night_differential']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Rest Day Hour';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['rest_day_hours']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Extra Day Hour';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['extra_day_hours']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Special Holiday Hour';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['special_holiday_hours']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Regular Holiday Hour';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['regular_holiday_hours']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = '';
          $temp['time']     = '';
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Total Late';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['late_hours']));
          array_push($time, $temp);
          $temp = '';
          $temp['name']     = 'Total Under Time';
          $temp['time']     = Payroll::if_zero_time(Payroll::float_time($process['under_time_hours']));
          array_push($time, $temp);

          $temp = '';
          $temp['name']     = '';
          $temp['time']     = '';
          array_push($time, $temp);

          $temp = '';
          $temp['name']     = 'Total Hour';
          $temp['time']     = '<b>'.Payroll::if_zero_time(Payroll::float_time($process['total_hours'])).'</b>';
          array_push($time, $temp);


          /* DAY */
          $temp = '';
          $temp['name']    = 'Regular Days';
          $temp['day']     = Payroll::if_zero($process['total_regular_days']);
          array_push($day, $temp);

          $temp = '';
          $temp['name']    = 'Rest Days';
          $temp['day']     = Payroll::if_zero($process['total_rest_days']);
          array_push($day, $temp);

          $temp = '';
          $temp['name']    = 'Extra Days';
          $temp['day']     = Payroll::if_zero($process['total_extra_days']);
          array_push($day, $temp);

          $temp = '';
          $temp['name']    = 'Special Holidays';
          $temp['day']     = Payroll::if_zero($process['total_sh']);
          array_push($day, $temp);

          $temp = '';
          $temp['name']     = 'Regular Holidays';
          $temp['day']     = Payroll::if_zero($process['total_rh']);
          array_push($day, $temp);

          $temp = '';
          $temp['name']    = 'Total Working Days';
          $temp['day']     = '<b>'.Payroll::if_zero($process['total_worked_days']).'</b>';
          array_push($day, $temp);


          $data['computation'] = $computation;
          $data['time']        = $time;
          $data['day']         = $day;
          return $data;
     }

     public function btn_adjustment($adjustment_id = 0)
     {
          $btn = '<button class="btn btn-xs btn-custom-red popup pull-right" size="sm" link="/member/payroll/payroll_process/confirm_remove_adjustment/'.$adjustment_id.'" type="button"><i class="fa fa-times"></i></button>';
          return $btn;
     }

     public function confirm_remove_adjustment($adjustment_id)
     {
          $adjustment = Tbl_payroll_adjustment::where('payroll_adjustment_id', $adjustment_id)->first();

          $data['title']      = 'Do you really want to remove '.$adjustment->payroll_adjustment_name;
          $data['action']     = '/member/payroll/payroll_process/remove_adjustment';
          $data['id']         = $adjustment->payroll_adjustment_id;
          $data['html']       = '<input type="hidden" value="'.$adjustment->payroll_employee_id.'" name="payroll_employee_id"><input type="hidden" value="'.$adjustment->payroll_period_company_id.'" name="payroll_period_company_id">';

          return view('member.modal.modal_confirm_archived', $data);
     }

     public function remove_adjustment()
     {
          $id                           = Request::input('id');
          $payroll_employee_id          = Request::input('payroll_employee_id');
          $payroll_period_company_id    = Request::input('payroll_period_company_id');

          $data['status']                    = 'success';
          $data['payroll_employee_id']       = $payroll_employee_id;
          $data['payroll_period_company_id'] = $payroll_period_company_id;
          $data['function_name']             = 'reload_break_down';
          // dd($data);

          Tbl_payroll_adjustment::where('payroll_adjustment_id', $id)->delete();
          return json_encode($data);

     }


     public function confirm_action_payroll($action,$id)
     {
          $period = Tbl_payroll_period_company::sel($id)->first();

          // dd($period);
          $statement = '';
          $link = '/member/payroll/payroll_process/action_payroll';
          switch ($action) {
               case 'registered':
                   $statement = 'register';
                    break;

               case 'pending':
                   $statement = 'unprocess';
                    break;

               case 'unregister':
                   $statement = 'unregister';
                   $action    = 'processed';
                    break;

               case 'posted':
                   $statement = 'post';
                    break;

               case 'unpost':
                   $statement = 'unpost';
                   $action    = 'registered';
                    break; 

               case 'approved':
                   $statement = 'approve';
                   $link = '/member/payroll/payroll_approved_view/approve_payroll';
                    break;   

               default:
                    $statement = '';
                    break;
          }

        
          $data['title']      = 'Do you really want to <span class="color-red">'.$statement.'</span> '.$period->payroll_company_name.' ('.date('M d Y', strtotime($period->payroll_period_start)).' to '.date('M d Y', strtotime($period->payroll_period_end)).')';
          $data['action']     = $link;
          $data['id']         = $period->payroll_period_company_id;
          $data['html']       = '<input type="hidden" value="'.$action.'" name="payroll_action">';

          return view('member.modal.modal_confirm_archived', $data);
     }

     

     public function action_payroll()
     {
          $id = Request::input('id');
          $payroll_action = Request::input('payroll_action');
          $update['payroll_period_status'] = $payroll_action;
          Tbl_payroll_period_company::where('payroll_period_company_id', $id)->update($update);

          $data['status'] = 'success';
          $data['function_name'] = 'reload_page';
          return json_encode($data);
     }

     /* PAYROLL PROCESS END */


     public function payroll_summary()
     {
          // dd(Request::input());
          $data['date_start'] = date('m/d/Y', strtotime('first day of this month'));
          $data['date_end']   = date('m/d/Y', strtotime('last day of this month'));

          if(Request::input())
          {
               $data['date_start'] = Request::input('start');
               $data['date_end']   = Request::input('end');
          }
          
          $data['_record'] = PayrollJournalEntries::payroll_summary($data['date_start'], $data['date_end']);

          // dd(collect($record)->toArray());

          return view('member.payroll.payroll_journal_entries', $data);
     }


     /* PAYROLL REGISTERED START */
     public function payroll_register()
     {
          // breakdown_uncompute
          $data['_period'] = Payroll::process_compute(Self::shop_id(), 'registered');
          return view('member.payroll.payroll_register', $data);
     }

     public function breakdown_uncompute_static($employee_id, $payroll_period_company_id)
     {
          $period = Tbl_payroll_period_company::sel($payroll_period_company_id)->first();

          $process = Payroll::compute_per_employee($employee_id, $period->payroll_period_start, $period->payroll_period_end, Self::shop_id(), $period->payroll_period_category, $payroll_period_company_id);

          $data['emp'] = Tbl_payroll_employee_basic::where('payroll_employee_id',$employee_id)->first();

          $data['_breakdown'] = Self::breakdown_uncompute($process,'registered');
          $data['payroll_period_company_id'] = $payroll_period_company_id;
          $data['status'] = 'register';
          // dd($data);
          return view('member.payroll.modal.modal_view_payroll_computation_unsaved',$data);
     }
     /* PAYROLL REGISTERED END */


     /* PAYROLL POSTED START */
     public function payroll_post()
     {
          $data['_period'] = Payroll::process_compute(Self::shop_id(), 'posted');
          return view('member.payroll.payroll_post', $data);
     }
     /* PAYROLL POSTED END */


     /* PAYROLL ADJUSTMENT START */
     public function modal_create_payroll_adjustment($payroll_employee_id, $payroll_period_company_id)
     {
          $data['payroll_employee_id']  = $payroll_employee_id;
          $data['company_period']       = $payroll_period_company_id;
          return view('member.payroll.modal.modal_create_adjustment', $data);
     }

     public function create_payroll_adjustment()
     {
          // Tbl_payroll_adjustment
          $insert['payroll_employee_id']          = Request::input('payroll_employee_id');
          $insert['payroll_period_company_id']    = Request::input('company_period');
          $insert['payroll_adjustment_name']      = Request::input('payroll_adjustment_name');
          $insert['payroll_adjustment_amount']    = Request::input('payroll_adjustment_amount');
          $insert['payroll_adjustment_category']  = Request::input('payroll_adjustment_category');

          Tbl_payroll_adjustment::insert($insert);

          $data['status']                         = 'success';
          $data['payroll_employee_id']            = Request::input('payroll_employee_id');
          $data['payroll_period_company_id']      = Request::input('company_period');
          $data['function_name']                  = 'reload_break_down';

          return json_encode($data);
     }
     /* PAYROLL ADJUSTMENT END */


     /* PAYROLL APPROVED START */
     public function payroll_approved_view()
     {
          $data['_period'] = array();
          $_period = Tbl_payroll_period_company::period(Self::shop_id(), 'approved')->select('tbl_payroll_period.*')->distinct('payroll_period_id')->get();

          foreach($_period as $period)
          {
               $temp['period'] = $period;
               $temp['_company'] = Tbl_payroll_period_company::selperiod($period->payroll_period_id)
                                                            ->where('tbl_payroll_period_company.payroll_period_status','approved')
                                                            ->orderBy('tbl_payroll_company.payroll_company_name')
                                                            ->get();
               array_push($data['_period'], $temp);
          }

          // dd($data);
          
          return view('member.payroll.payroll_approved', $data);
     }

     public function approve_payroll()
     {
          $id       = Request::input('id');
          $period   = Tbl_payroll_period_company::getcompanyperiod($id)->first();
          $_data    = Payroll::company_period($period, Self::shop_id());

          foreach($_data['_list'] as $key => $data)
          {
               // dd($data);
               $payroll_record_id = Tbl_payroll_record::insertGetId(Self::filter_insert_record($data['compute']));

               $insert_deduction = array();
               $insert_allowance = array();
               foreach($data['compute']['allowance'] as $allowance)
               {
                    $temp_allowance['payroll_record_id']                   = $payroll_record_id;
                    $temp_allowance['payroll_employee_id']                 = $data['payroll_employee_id'];
                    $temp_allowance['payroll_allowance_id']                = $allowance['payroll_allowance_id'];
                    $temp_allowance['payroll_record_allowance_amount']     = $allowance['payroll_allowance_amount'];
                    $temp_allowance['payroll_allowance_name']              = $allowance['payroll_allowance_name'];
                    array_push($insert_allowance, $temp_allowance);
               }

               foreach($data['compute']['deduction'] as $deduction)
               {
                    $temp_deduction['payroll_deduction_id']      = $deduction['payroll_deduction_id'];
                    $temp_deduction['payroll_employee_id']       = $data['payroll_employee_id'];
                    $temp_deduction['payroll_record_id']         = $payroll_record_id;
                    $temp_deduction['payroll_payment_amount']    = $deduction['payroll_periodal_deduction'];
                    $temp_deduction['deduction_name']            = $deduction['deduction_name'];
                    $temp_deduction['deduction_category']        = $deduction['deduction_category'];
                    array_push($insert_deduction, $temp_deduction);
               }

               if(!empty($insert_allowance))
               {
                    Tbl_payroll_allowance_record::insert($insert_allowance);
               }

               if(!empty($insert_deduction))
               {
                    Tbl_payroll_deduction_payment::insert($insert_deduction);
               }
               
          }

          $update['payroll_period_status'] = 'approved';
          Tbl_payroll_period_company::where('payroll_period_company_id', $id)->update($update);

          $return['status']        = 'success';
          $return['function_name'] = 'reload_page';

          return json_encode($return);

     }

     public function filter_insert_record($data = array())
     {
          // dd($data);
          $temp['shop_id']                        = Self::shop_id();
          $temp['payroll_employee_id']            = $data['payroll_employee_id'];
          $temp['payroll_period_company_id']      = $data['payroll_period_company_id'];
          $temp['salary_monthly']                 = $data['salary_monthly'];
          $temp['salary_daily']                   = $data['salary_daily'];
          $temp['regular_salary']                 = $data['regular_salary'];
          $temp['regular_early_overtime']         = $data['regular_early_overtime'];
          $temp['regular_reg_overtime']           = $data['regular_reg_overtime'];
          $temp['regular_night_diff']             = $data['regular_night_diff'];
          $temp['extra_salary']                   = $data['extra_salary'];
          $temp['extra_early_overtime']           = $data['extra_early_overtime'];
          $temp['extra_reg_overtime']             = $data['extra_reg_overtime'];
          $temp['extra_night_diff']               = $data['extra_night_diff'];
          $temp['rest_day_salary']                = $data['rest_day_salary'];
          $temp['rest_day_early_overtime']        = $data['rest_day_early_overtime'];
          $temp['rest_day_reg_overtime']          = $data['rest_day_reg_overtime'];
          $temp['rest_day_night_diff']            = $data['rest_day_night_diff'];
          $temp['rest_day_sh']                    = $data['rest_day_sh'];
          $temp['rest_day_sh_early_overtime']     = $data['rest_day_sh_early_overtime'];
          $temp['rest_day_sh_reg_overtime']       = $data['rest_day_sh_reg_overtime'];
          $temp['rest_day_sh_night_diff']         = $data['rest_day_sh_night_diff'];
          $temp['rest_day_rh']                    = $data['rest_day_rh'];
          $temp['rest_day_rh_early_overtime']     = $data['rest_day_rh_early_overtime'];
          $temp['rest_day_rh_reg_overtime']       = $data['rest_day_rh_reg_overtime'];
          $temp['rest_day_rh_night_diff']         = $data['rest_day_rh_night_diff'];
          $temp['rh_salary']                      = $data['rh_salary'];
          $temp['rh_early_overtime']              = $data['rh_early_overtime'];
          $temp['rh_reg_overtime']                = $data['rh_reg_overtime'];
          $temp['rh_night_diff']                  = $data['rh_night_diff'];
          $temp['sh_salary']                      = $data['sh_salary'];
          $temp['sh_early_overtime']              = $data['sh_early_overtime'];
          $temp['sh_reg_overtime']                = $data['sh_reg_overtime'];
          $temp['sh_night_diff']                  = $data['sh_night_diff'];
          $temp['13_month']                       = $data['13_month'];
          $temp['13_month_computed']              = $data['13_month_computed'];
          $temp['minimum_wage']                   = $data['minimum_wage'];
          $temp['tax_status']                     = $data['tax_status'];
          $temp['salary_taxable']                 = $data['salary_taxable'];
          $temp['salary_sss']                     = $data['salary_sss'];
          $temp['salary_pagibig']                 = $data['salary_pagibig'];
          $temp['salary_philhealth']              = $data['salary_philhealth'];
          $temp['tax_contribution']               = $data['tax_contribution'];
          $temp['sss_contribution_ee']            = $data['sss_contribution_ee'];
          $temp['sss_contribution_er']            = $data['sss_contribution_er'];
          $temp['sss_contribution_ec']            = $data['sss_contribution_ec'];
          $temp['philhealth_contribution_ee']     = $data['philhealth_contribution_ee'];
          $temp['philhealth_contribution_er']     = $data['philhealth_contribution_er'];
          $temp['pagibig_contribution']           = $data['pagibig_contribution'];
          $temp['late_deduction']                 = $data['late_deduction'];
          $temp['under_time']                     = $data['under_time'];
          $temp['agency_deduction']               = $data['agency_deduction'];
          $temp['payroll_cola']                   = $data['payroll_cola'];
          $temp['regular_hours']                  = $data['regular_hours'];
          $temp['late_overtime']                  = $data['late_overtime'];
          $temp['early_overtime']                 = $data['early_overtime'];
          $temp['late_hours']                     = $data['under_time_hours'];
          $temp['under_time_hours']               = $data['under_time_hours'];
          $temp['rest_day_hours']                 = $data['rest_day_hours'];
          $temp['extra_day_hours']                = $data['extra_day_hours'];
          $temp['total_hours']                    = $data['total_hours'];
          $temp['night_differential']             = $data['night_differential'];
          $temp['special_holiday_hours']          = $data['special_holiday_hours'];
          $temp['regular_holiday_hours']          = $data['regular_holiday_hours'];
          $temp['total_regular_days']             = $data['total_regular_days'];
          $temp['total_rest_days']                = $data['total_rest_days'];
          $temp['total_extra_days']               = $data['total_extra_days'];
          $temp['total_rh']                       = $data['total_rh'];
          $temp['total_sh']                       = $data['total_sh'];
          $temp['total_worked_days']              = $data['total_worked_days'];


          return $temp;
     }

     public function payroll_approved_company($id)
     {
          $check = Tbl_payroll_period_company::sel($id)
                                             ->where('tbl_payroll_period.shop_id',Self::shop_id())
                                             ->where('tbl_payroll_period_company.payroll_period_status','approved')
                                             ->count();
          if($check == 0)
          {
               return Redirect::to('/member/payroll/payroll_approved_view')->send();
          }

          $data['period']          = Tbl_payroll_period_company::sel($id)->first();
          $data['_record']         = array();
          $data['total_gross']     = 0;
          $data['total_deduction'] = 0;
          $data['total_net']       = 0;

          $_record = Tbl_payroll_record::getcompanyrecord($id)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->get();
          foreach($_record as $record)
          {
               $compute = Payroll::getrecord_breakdown($record);
               array_push($data['_record'], $compute);
               // dd($record);
               $data['total_gross']     += $compute['total_gross'];
               $data['total_deduction'] += $compute['total_deduction'];
               $data['total_net']       += $compute['total_net'];
          }
          
          // dd($data);
          return view('member.payroll.payroll_approved_company', $data);
     }

     public function payroll_record_by_id($id)
     {
          $record = Tbl_payroll_record::getrecord($id)->first();
          // dd($record);
          $compute = Payroll::getrecord_breakdown($record);

          $data['emp'] = Tbl_payroll_employee_basic::where('payroll_employee_id',$record->payroll_employee_id)->first();

          $data['_breakdown'] = Self::breakdown_uncompute($compute,'approved');
          $data['payroll_period_company_id'] = $record->payroll_period_company_id;
          $data['status'] = 'approved';
          // dd($data);
          return view('member.payroll.modal.modal_view_payroll_computation_unsaved',$data);
     }
     /* PAYRLL APPROVED END */

     public function modal_payroll_notes($payroll_period_company_id)
     {
          
          return view('member.payroll.modal.modal_payroll_notes');
     }

}
