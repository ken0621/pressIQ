<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Response;
use Excel;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Globals\Payroll;
use PDF2;
use App\Globals\Payroll2;
use DateTime;

use App\Models\Tbl_payroll_employee_basic;

use App\Http\Controllers\Member\PayrollDeductionController;


use App\Models\Tbl_payroll_deduction_v2;
use App\Models\Tbl_payroll_deduction_employee_v2;
use App\Models\Tbl_payroll_deduction_payment_v2;
use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_period;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employment_status;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_register_column;


use App\Models\Tbl_payroll_leave_temp;
use App\Models\Tbl_payroll_leave_schedule;
use App\Models\Tbl_payroll_leave_employee;

use App\Globals\AuditTrail;



class PayrollReportController extends Member
{
	public function shop_id()
	{
		return $this->user_info->shop_id;
	}
	public function government_forms()
	{ 
		$data["page"] = "Monthly Government Forms";
		$data["_month_period"] = Payroll2::get_number_of_period_per_month($this->shop_id(), 2017);
		return view("member.payrollreport.government_forms", $data);
	}
	public function government_forms_hdmf($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

		return view("member.payrollreport.government_forms_hdmf", $data);
	}
	public function government_forms_sss($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		// dd($contri_info);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();
		// dd($contri_info);
		return view("member.payrollreport.government_forms_sss", $data);
	}
	public function government_forms_philhealth($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

		return view("member.payrollreport.government_forms_philhealth", $data);
	}

	public function government_forms_hdmf_iframe($month,$company_id)
	{ 
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;

			$format["title"] = "A4";
			$format["format"] = "A4";
			$format["default_font"] = "sans-serif";
			// $format["margin_top"] = "0";
			// $format["margin_bottom"] = "0";
			// $format["margin_left"] = "0";
			// $format["margin_right"] = "0";

			$pdf = PDF2::loadView('member.payrollreport.government_forms_hdmf_pdf', $data, [], $format);
			return $pdf->stream('document.pdf');
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			
			$format["title"] = $data['company']->payroll_company_name;
			$format["format"] = "A4";
			$format["default_font"] = "sans-serif";
			$pdf = PDF2::loadView('member.payrollreport.government_forms_hdmf_pdf', $data, [], $format);
			return $pdf->stream('document.pdf');
		}
	}

	public function government_forms_hdmf_filter()
	{
		if (Request::input("company_id") > 0) 
		{
			$company_id =	Request::input("company_id");
        	$month      =	Request::input('month');
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			
			if($contri_info["_employee_contribution"]==null or $contri_info["_employee_contribution"]==0)
			{
				return "<center><font size='20'><br><br>No Employee Records<br><br><br><br></font></center>";
			}
			else
			{
				return view("member.payrollreport.government_forms_hdmf_filter", $data);
			}
		}
		else
		{
            $month      =	Request::input('month');
            $company_id =	Request::input("company_id");
            $data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id,$month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data['company_id1'] = $company_id;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();
           return view("member.payrollreport.government_forms_hdmf_filter", $data);
		}
	}

	public function government_forms_sss_filter()
	{
		$company_id =	Request::input("company_id");
		$month      =	Request::input('month');
		if (Request::input("company_id") > 0) {
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			if($contri_info["_employee_contribution"]==null or $contri_info["_employee_contribution"]==0)
			{
				return "<center><font size='20'><br><br>No Employee Records<br><br><br><br></font></center>";
			}
			else
			{
				return view("member.payrollreport.government_forms_sss_filter", $data);
			}
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			return view("member.payrollreport.government_forms_sss_filter", $data);
		}
	}
	public function government_forms_philhealth_filter()
	{
		$company_id =	Request::input("company_id");
		$month      =	Request::input('month');
		if ($company_id != null && $month != null) {
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			
			if($contri_info["_employee_contribution"]==null or $contri_info["_employee_contribution"]==0)
			{
				return "<center><font size='20'><br><br>No Employee Records<br><br><br><br></font></center>";
			}
			else
			{
				return view("member.payrollreport.government_forms_philhealth_filter", $data);
			}
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			return view("member.payrollreport.government_forms_philhealth_filter", $data);
		}
	}
    public function government_forms_hdmf_export_excel($month,$company_id)
	{
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();


			AuditTrail::record_logs("DOWNLOAD","HDMF REPORT",$this->shop_id(),"","");
            // dd(count($contri_info["_employee_contribution"]));
			Excel::create("Government Forms HDMF",function($excel) use ($data)

			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_hdmf_export_excel',$data);
				});
			})->download('xls');        
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			AuditTrail::record_logs("DOWNLOAD","HDMF REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms HDMF".$data['company']->payroll_company_name,function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_hdmf_export_excel',$data);
				});
			})->download('xls');
		}
 			
	}
	public function government_forms_sss_export_excel($month,$company_id)
	{
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			// AuditTrail::record_logs("DOWNLOAD","SSS REPORT",$this->shop_id(),"","");
			
			Excel::create("Government Forms SSS",function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_sss_export_excel',$data);
				});
			})->download('xls');
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			AuditTrail::record_logs("DOWNLOAD","SSS REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms SSS-".$data['company']->payroll_company_name,function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_sss_export_excel',$data);
				});
			})->download('xls');
		}
 			
	}
	public function government_forms_philhealth_export_excel($month,$company_id)
	{
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();
			AuditTrail::record_logs("DOWNLOAD","PHILHEALTH REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms PHILHEALTH",function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_philhealth_export_excel',$data);
				});
			})->download('xls');
		}
		else
		{
			$data["page"] = "Monthly Government Forms";


			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] 		 = $month;
			$data["month_name"]  = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] 	 	 = $year;
			$data['company'] 	 = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			AuditTrail::record_logs("DOWNLOAD","PHILHEALTH REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms PHILHEALTH".$data['company']->payroll_company_name,function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_philhealth_export_excel',$data);
				});
			})->download('xls');
		}
 			
	}



	/*START LOAN SUMMARY*/
	public function loan_summary()
	{
		$data["page"] = "Loan Summary";
		$data["_loan_data"] = PayrollDeductionController::get_deduction($this->shop_id());
		$data["_company"] = Payroll::company_heirarchy(Self::shop_id());//Tbl_payroll_company::where("shop_id", Self::shop_id())->where('payroll_parent_company_id', 0)->get();
		$data['totals']	= $this->get_totals_loan_summary($data);
		// dd($data['$totals']);
		return view("member.payrollreport.loan_summary", $data);
	}

	public function table_loan_summary($deduction_type='',$company=0)
	{
		$data["page"] = "Loan Summary";
		$deduction_type = str_replace("_"," ",$deduction_type);
		$data["_loan_data"] = PayrollDeductionController::get_deduction_by_type($this->shop_id(),$deduction_type);
		if($company == 0)
		{
			$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();
		}
		else
		{
			$data['company']	= Tbl_payroll_company::selcompanybyid($company)->get();
		}
		
		$data['totals']	= $this->get_totals_loan_summary($data);

		return view("member.payrollreport.loan_summary_table", $data);
	}

	public function table_company_loan_summary()
	{
		$data['company_id'] = Request::input('company_id');
		$data['_loan_data'] = Tbl_payroll_deduction_payment_v2::getallinfo($this->shop_id(),$data['company_id'],0)->get();

		if($data['company_id'] == 0)
		{
			$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();
		}
		else
		{
			$data['company']	= Tbl_payroll_company::selcompanybyid($data['company_id'])->get();
		}

		$data['totals']	= $this->get_totals_loan_summary($data);

		return view('member.payrollreport.table_company_loan_summary',$data);
	}

	public function modal_loan_summary($employee_id = 0,$payroll_deduction_id = 0)
	{
		$data["employee_id"]   			= $employee_id;
		$data["payroll_deduction_id"]   = $payroll_deduction_id;
		$data["_loan_data"]    			= PayrollDeductionController::get_deduction_payment(0,$employee_id,$payroll_deduction_id);
		$data["employee_info"] 			= Tbl_payroll_employee_basic::where("payroll_employee_id",$employee_id)->first();
		return view("member.payroll.modal.modal_loan_summary", $data);
	}

	public function loan_summary_report_excel($company = 0, $deduction_type='')
	{

		$data["_loan_data"] = PayrollDeductionController::get_deduction($this->shop_id());
		$data["_company"] = Payroll::company_heirarchy(Self::shop_id());
		$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();

		if($company != 0 && $deduction_type == 'noval')
		{
			$data['_loan_data'] = Tbl_payroll_deduction_payment_v2::getallinfo($this->shop_id(),$company,0)->get();	
			$data['company']	= Tbl_payroll_company::selcompanybyid($company)->get();
		}	
		else if($deduction_type != 'noval')
		{
			$deduction_type = str_replace("_"," ",$deduction_type);
			$data["_loan_data"] = PayrollDeductionController::get_deduction_by_type($this->shop_id(),$deduction_type);
			if($company == 0)
			{
				$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();
			}
			else
			{
				$data['company']	= Tbl_payroll_company::selcompanybyid($company)->get();
			}
		}
		$data['totals']	= $this->get_totals_loan_summary($data);

          Excel::create("Loan Summary Reports",function($excel) use ($data)
          {
               $excel->sheet('clients',function($sheet) use ($data)
               {
                    $sheet->loadView('member.payrollreport.loan_summary_export_excel',$data);
               });
          })->download('xls');
	}

	public function get_totals_loan_summary($data)
	{
		$temp['loan_total'] 		        	 	  = 0;
		$temp['total_total_payment']        		  = 0;
		$temp['total_remaining_balance']    		  = 0;
		$temp['payroll_employee_company_id'] 		  = -1;

		$lastvalue['loan_total'] 		        	 	  = 0;
		$lastvalue['total_total_payment']        		  = 0;
		$lastvalue['total_remaining_balance']    		  = 0;

		$totals = array();
		foreach($data['_loan_data'] as $key => $loan_data)
		{	
			if($temp['payroll_employee_company_id'] == -1)
			{
				$temp['payroll_employee_company_id']      = $loan_data['payroll_employee_company_id'];
				$lastvalue['loan_total']          		 += $loan_data['payroll_deduction_amount'];
				$lastvalue['total_total_payment'] 		 += $loan_data['total_payment'];
				$lastvalue['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];
			}

			if($temp['payroll_employee_company_id'] == $loan_data['payroll_employee_company_id'])
			{
				$temp['loan_total']          		 += $loan_data['payroll_deduction_amount'];
				$temp['total_total_payment'] 		 += $loan_data['total_payment'];
				$temp['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];

				if($temp['loan_total'] > $lastvalue['loan_total'])
				{
					array_pop($totals);
				}

			}
			else
			{
						$temp['loan_total'] 		        	 	  = 0;
						$temp['total_total_payment']        		  = 0;
						$temp['total_remaining_balance']    		  = 0;

						$lastvalue['loan_total'] 		        	 	  = 0;
						$lastvalue['total_total_payment']        		  = 0;
						$lastvalue['total_remaining_balance']    		  = 0;

						$temp['loan_total']          		 += $loan_data['payroll_deduction_amount'];
						$temp['total_total_payment'] 		 += $loan_data['total_payment'];
						$temp['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];

						$lastvalue['loan_total']          		 += $loan_data['payroll_deduction_amount'];
						$lastvalue['total_total_payment'] 		 += $loan_data['total_payment'];
						$lastvalue['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];

			}
			$temp['payroll_employee_company_id']  = $loan_data['payroll_employee_company_id'];
			array_push($totals,$temp);
		}
		
		$data['totals']	= $totals;

		return $data;
	}

	public function export_loan_summary_report_to_excel($employee_id = 0,$payroll_deduction_id = 0 )
	{
		if (Request::input('employee_id')!='') 
		{
			$employee_id = Request::input('employee_id');
			$payroll_deduction_id = Request::input('payroll_deduction_id');
		}
		$data["loan_deduction"]         = Tbl_payroll_deduction_v2::where('payroll_deduction_id',$payroll_deduction_id)->first();
		$data["_loan_data"]    			= PayrollDeductionController::get_deduction_payment(0,$employee_id,$payroll_deduction_id);
		$data["employee_info"] 			= Tbl_payroll_employee_basic::where("payroll_employee_id",$employee_id)->first();
		// dd($data);
		AuditTrail::record_logs("DOWNLOAD","LOAN SUMMARY REPORT",$this->shop_id(),"","");
		Excel::create($data['employee_info']->payroll_employee_display_name,function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.loan_summary_report',$data);
			});
		})->download('xls');
	}
	/*END LOAN SUMMARY*/


	/*START PAYROLL REGISTER REPORT*/

	public function payroll_register_report()
	{
		 // dd($this->shop_id());
		 $data["_company"] = Tbl_payroll_company::where("shop_id", $this->shop_id())->where('payroll_parent_company_id', 0)->get();
	    
	     $data['_period'] = Tbl_payroll_period::sel($this->shop_id())
	                                              ->where('payroll_parent_company_id', 0)
	                                              ->where('tbl_payroll_period_company.payroll_period_status','!=','pending')
	                                              ->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_id','=','tbl_payroll_period.payroll_period_id')
	                                              ->join('tbl_payroll_company', 'tbl_payroll_company.payroll_company_id','=', 'tbl_payroll_period_company.payroll_company_id')
	                                              ->orderBy('tbl_payroll_period.payroll_period_start','asc')
	                                              ->get();
	     
		return view("member.payrollreport.payroll_register_report", $data);
	}

	public function modal_create_register_report($period_company_id)
	{

	}

	public function payroll_register_report_period($period_company_id)
	{
		$data["period_company_id"]  = $period_company_id; 
		$data["company"] 			= Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();

		$data["period_info"] 		= $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));
		
		$data['filtering_company']	= $period_company_id;
		$data['_company']           = Payroll::company_heirarchy(Self::shop_id());

		return view('member.payrollreport.payroll_register_report_period',$data);
	}

	public function payroll_register_report_table()
	{
		$payroll_company_id = request::input('payroll_company_id');
		$period_company_id  = request::input('period_company_id');

		$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();

		if ($payroll_company_id != 0) 
		{
			$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->where('employee_company_id',$payroll_company_id)->basic()->get();
			if (count($data["_employee"]) == 0 )
			{
				$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basicfilter($payroll_company_id)->get();
			}
		}

		$data = Payroll2::get_total_payroll_register($data);
		// dd($data);
		$data['columns'] = Tbl_payroll_register_column::select('*')->where('shop_id',Self::shop_id())->get();

		return view('member.payrollreport.payroll_register_report_table', $data);
	}

	public function modal_filter_register_columns($period_company_id)
	{
			$data['period_company_id'] = $period_company_id;
			$data['columns'] = Tbl_payroll_register_column::select('*')->where('shop_id',Self::shop_id())->get();
			if(count($data['columns']) == 0)
			{
				$insert['name']							= 1;			
				$insert['gross_basic_pay']				= 1;
				$insert['absent']						= 1;
				$insert['late']							= 1;
				$insert['undertime']					= 1;
				$insert['basic_pay']					= 1;
				$insert['cola']							= 1;
				$insert['overtime_pay']					= 1;
				$insert['night_differential_pay']		= 1;
				$insert['regular_holiday_pay']			= 1;
				$insert['special_holiday_pay']			= 1;
				$insert['restday_pay']					= 1;
				$insert['leave_pay']					= 1;
				$insert['allowance']					= 1;
				$insert['bonus']						= 1;
				$insert['commision']					= 1;
				$insert['incentives']					= 1;
				$insert['additions']					= 1;
				$insert['de_minimis_benefit']			= 1;
				$insert['others']						= 1;
				$insert['gross_pay']					= 1;
				$insert['deductions']					= 1;
				$insert['cash_bond']					= 1;
				$insert['cash_advance']					= 1;
				$insert['other_loan']					= 1;
				$insert['sss_loan']						= 1;
				$insert['sss_ee']						= 1;
				$insert['hdmf_loan']					= 1;
				$insert['hdmf_ee']						= 1;
				$insert['phic_ee']						= 1;
				$insert['with_holding_tax']				= 1;
				$insert['total_deduction']				= 1;
				$insert['take_home_pay']				= 1;
				$insert['sss_er']						= 1;
				$insert['sss_ec']						= 1;
				$insert['hdmf_er']						= 1;
				$insert['phic_er']						= 1;
				$insert['month_13_and_other']			= 1;
				$insert['rendered_days']				= 1;
				$insert['shop_id']						= Self::shop_id();
				Tbl_payroll_register_column::insert($insert);
			}

			$data['columnn'] = Tbl_payroll_register_column::select('*')->where('shop_id',Self::shop_id())->get();
			return view('member.payrollreport.modal_filter_register_columns',$data);
	}

	public function save_payroll_register_selected_columns()
	{		
			$update['name']							= 0;			
			$update['gross_basic_pay']				= 0;
			$update['absent']						= 0;
			$update['late']							= 0;
			$update['undertime']					= 0;
			$update['basic_pay']					= 0;
			$update['rendered_days']				= 0;
			$update['cola']							= 0;
			$update['overtime_pay']					= 0;
			$update['night_differential_pay']		= 0;
			$update['regular_holiday_pay']			= 0;
			$update['special_holiday_pay']			= 0;
			$update['restday_pay']					= 0;
			$update['leave_pay']					= 0;
			$update['allowance']					= 0;
			$update['bonus']						= 0;
			$update['commision']					= 0;
			$update['incentives']					= 0;
			$update['additions']					= 0;
			$update['month_13_and_other']			= 0;
			$update['de_minimis_benefit']			= 0;
			$update['others']						= 0;
			$update['gross_pay']					= 0;
			$update['deductions']					= 0;
			$update['cash_bond']					= 0;
			$update['cash_advance']					= 0;
			$update['other_loan']					= 0;
			$update['sss_loan']						= 0;
			$update['sss_ee']						= 0;
			$update['hdmf_loan']					= 0;
			$update['hdmf_ee']						= 0;
			$update['phic_ee']						= 0;
			$update['with_holding_tax']				= 0;
			$update['total_deduction']				= 0;
			$update['take_home_pay']				= 0;
			$update['sss_er']						= 0;
			$update['sss_ec']						= 0;
			$update['hdmf_er']						= 0;
			$update['phic_er']						= 0;


			if(!empty(request::input('name')))
			{
				$update['name'] = request::input('name');
			}
			if(!empty(request::input('gross_basic_pay')))
			{
				$update['gross_basic_pay'] = request::input('gross_basic_pay');
			}
			if(!empty(request::input('absent')))
			{
				$update['absent'] = request::input('absent');
			}	
			if(!empty(request::input('late')))
			{
				$update['late'] = request::input('late');
			}
			if(!empty(request::input('undertime')))
			{
				$update['undertime'] = request::input('undertime');
			}
			if(!empty(request::input('basic_pay')))
			{
				$update['basic_pay'] = request::input('basic_pay');
			}
			if(!empty(request::input('rendered_days')))
			{
				$update['rendered_days'] = request::input('rendered_days');
			}
			if(!empty(request::input('cola')))
			{
				$update['cola'] = request::input('cola');
			}
			if(!empty(request::input('overtime_pay')))
			{
				$update['overtime_pay'] = request::input('overtime_pay');
			}
			if(!empty(request::input('night_differential_pay')))
			{
				$update['night_differential_pay'] = request::input('night_differential_pay');
			}	
			if(!empty(request::input('regular_holiday_pay')))
			{
				$update['regular_holiday_pay'] = request::input('regular_holiday_pay');
			}
			if(!empty(request::input('special_holiday_pay')))
			{
				$update['special_holiday_pay'] = request::input('special_holiday_pay');
			}
			if(!empty(request::input('restday_pay')))
			{
				$update['restday_pay'] = request::input('restday_pay');
			}
			if(!empty(request::input('leave_pay')))
			{
				$update['leave_pay'] = request::input('leave_pay');
			}
			if(!empty(request::input('allowance')))
			{
				$update['allowance'] = request::input('allowance');
			}
			if(!empty(request::input('bonus')))
			{
				$update['bonus'] = request::input('bonus');
			}		
			if(!empty(request::input('commision')))
			{
				$update['commision'] = request::input('commision');
			}
			if(!empty(request::input('incentives')))
			{
				$update['incentives'] = request::input('incentives');
			}
			if(!empty(request::input('additions')))
			{
				$update['additions'] = request::input('additions');
			}
			if(!empty(request::input('month_13_and_other')))
			{
				$update['month_13_and_other'] = request::input('month_13_and_other');
			}
			if(!empty(request::input('de_minimis_benefit')))
			{
				$update['de_minimis_benefit'] = request::input('de_minimis_benefit');
			}	
			if(!empty(request::input('others')))
			{
				$update['others'] = request::input('others');
			}
			if(!empty(request::input('gross_pay')))
			{
				$update['gross_pay'] = request::input('gross_pay');
			}
			if(!empty(request::input('deductions')))
			{
				$update['deductions'] = request::input('deductions');
			}	
			if(!empty(request::input('cash_bond')))
			{
				$update['cash_bond'] = request::input('cash_bond');
			}
			if(!empty(request::input('cash_advance')))
			{
				$update['cash_advance'] = request::input('cash_advance');
			}	
			if(!empty(request::input('other_loan')))
			{
				$update['other_loan'] = request::input('other_loan');
			}
			if(!empty(request::input('sss_loan')))
			{
				$update['sss_loan'] = request::input('sss_loan');
			}
			if(!empty(request::input('sss_ee')))
			{
				$update['sss_ee'] = request::input('sss_ee');
			}
			if(!empty(request::input('hdmf_loan')))
			{
				$update['hdmf_loan'] = request::input('hdmf_loan');
			}																							
			if(!empty(request::input('hdmf_ee')))
			{
				$update['hdmf_ee'] = request::input('hdmf_ee');
			}
			if(!empty(request::input('phic_ee')))
			{
				$update['phic_ee'] = request::input('phic_ee');
			}
			if(!empty(request::input('with_holding_tax')))
			{
				$update['with_holding_tax'] = request::input('with_holding_tax');
			}
			if(!empty(request::input('total_deduction')))
			{
				$update['total_deduction'] = request::input('total_deduction');
			}
			if(!empty(request::input('take_home_pay')))
			{
				$update['take_home_pay'] = request::input('take_home_pay');
			}
			if(!empty(request::input('sss_er')))
			{
				$update['sss_er'] = request::input('sss_er');
			}
			if(!empty(request::input('sss_ec')))
			{
				$update['sss_ec'] = request::input('sss_ec');
			}
			if(!empty(request::input('hdmf_er')))
			{
				$update['hdmf_er'] = request::input('hdmf_er');
			}
			if(!empty(request::input('phic_er')))
			{
				$update['phic_er'] = request::input('phic_er');
			}

	        Tbl_payroll_register_column::where('shop_id',Self::shop_id())->update($update);
  		
	  		$response['call_function'] = 'reload';
			$response['status'] = 'success';

			return $response;
	}

	public function payroll_register_report_export_excel($period_company_id, $payroll_company_id)
	{
        $data["company"] 			= Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] 			= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data["period_info"] 		= $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));

		if ($payroll_company_id != 0) 
		{
			$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->where('employee_company_id',$payroll_company_id)->basic()->get();
			if (count($data["_employee"]) == 0 )
			{
				$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basicfilter($payroll_company_id)->get();
			}
		}

		$data = Payroll2::get_total_payroll_register($data);

     	Excel::create($data["company"]->payroll_company_name, function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.payroll_register_report_export_excel',$data);
			});
		})->download('xls');
    }

	/*END PAYROLL REGISTER REPORT*/

	public function employee_summary_report()
	{
		$active_status[0]    = 1;
	    $active_status[1]    = 2;
	    $active_status[2]    = 3;
	    $active_status[3]    = 4;
	    $active_status[4]    = 5;
	    $active_status[5]    = 6;
	    $active_status[7]    = 7;

		$data['_active']	 = Tbl_payroll_employee_contract::employeefilter(0,0,0,date('Y-m-d'), Self::shop_id(), $active_status)->orderBy('tbl_payroll_employee_basic.payroll_employee_last_name')->get();

		//dd($data['salary'][0]->payroll_employee_salary_monthly);
		foreach ($data['_active'] as $key => $active)
		{
			$data['_active'][$key]->monthly_salary    = Tbl_payroll_employee_salary::selemployee($active->payroll_employee_id)->value('payroll_employee_salary_monthly');
			$data['_active'][$key]->daily_salary    = Tbl_payroll_employee_salary::selemployee($active->payroll_employee_id)->value('payroll_employee_salary_daily');
			//dd($data['_active'][$key]->payroll_employee_salary_monthly);
		}
		$data['_company']    = Payroll::company_heirarchy(Self::shop_id());

		return view('member.payrollreport.payroll_employee_summary_report', $data);
	}

}