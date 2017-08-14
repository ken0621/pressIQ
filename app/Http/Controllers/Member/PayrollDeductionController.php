<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Redirect;
use Session;
use Excel;
use DB;
use Response;
use PDF;
use stdClass;

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
use App\Models\Tbl_payroll_payslip;
use App\Models\Tbl_payroll_reports;
use App\Models\Tbl_payroll_reports_column;
use App\Models\Tbl_payroll_13_month_compute;
use App\Models\Tbl_payroll_13_month_virtual;
use App\Models\Tbl_payroll_process_leave;
use App\Models\Tbl_payroll_shift;
use App\Models\Tbl_payroll_shift_template;
use App\Models\Tbl_payroll_shift_code;
use App\Models\Tbl_payroll_employee_shift;
use App\Models\Tbl_payroll_employee_schedule;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_branch_location;

use App\Models\Tbl_payroll_allowance_v2;
use App\Models\Tbl_payroll_employee_allowance_v2;

use App\Globals\Payroll;
use App\Globals\PayrollJournalEntries;
use App\Globals\Utilities;
use DateTime;
use App\Models\Tbl_payroll_shift_day;
use App\Models\Tbl_payroll_shift_time;

use App\Globals\Accounting;

use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_time_keeping_approved_breakdown;
use App\Models\Tbl_payroll_time_keeping_approved_performance;

class PayrollDeductionController extends Member
{

     /*Set data per page for pagination*/
     protected $paginate_count = 10;

     public function shop_id($return = 'shop_id')
     {
          switch ($return) {
               case 'shop_id':
                    return $shop_id = $this->user_info->user_shop;
                    break;

               case 'user_id':
                    return $shop_id = $this->user_info->user_id;
                    break;
               
               default:
                    # code...
                    break;
          }

     }

    
    public function index()
    {
       $data['_active'] = Tbl_payroll_deduction::where('shop_id',Self::shop_id())
                              ->where('payroll_deduction_archived', 0)
                              ->orderBy('tbl_payroll_deduction.payroll_deduction_category','tbl_payroll_deduction.payroll_deduction_name')
                              ->paginate($this->paginate_count);
       $data['_archived'] = Tbl_payroll_deduction::where('shop_id',Self::shop_id())
                              ->where('payroll_deduction_archived', 1)
                              ->orderBy('tbl_payroll_deduction.payroll_deduction_category','tbl_payroll_deduction.payroll_deduction_name')
                              ->paginate($this->paginate_count);
        return view('member.payroll.side_container.deductionv2', $data);
    }
   

}
