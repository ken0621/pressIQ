<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_period extends Model
{
    protected $table = 'tbl_payroll_period';
	protected $primaryKey = "payroll_period_id";
    // public $timestamps = false;

    /* COLUMN NAME REFERENCE */ 

	// [PRIMARY KEY] 	payroll_period_id
	// [INTEGER] 		shop_id
	// [DATE] 			payroll_period_start
	// [DATE] 			payroll_period_end
	// [VARCHAR] 		payroll_period_category
	// [TINY INTEGER] 	payroll_period_archived
	// [VARCHAR]		payroll_period_status [DEFAULT {pending}]

	public function scopesel($query, $shop_id = 0, $payroll_period_archived = 0)
	{
		return $query->where('tbl_payroll_period.shop_id', $shop_id)->where('payroll_period_archived', $payroll_period_archived);
	}

	public function scopecheck($query, $_param = array())
	{
		foreach($_param as $key => $param)
		{
			$query->where($key, $param);
		}
		return $query;
	}
	public function scopeJoinCompany($query)
	{
		$query->join("tbl_payroll_period_company", "tbl_payroll_period_company.payroll_period_id", "=", "tbl_payroll_period.payroll_period_id");
		return $query;
	}
	public function scopeGetContributions($query, $shop_id, $month, $year)
	{
		$query->where('month_contribution', $month);
		$query->where('year_contribution', $year);
		$query->where('tbl_payroll_period.shop_id', $shop_id);
		$query->orderBy('tbl_payroll_employee_basic.payroll_employee_id','asc');
		$query->join("tbl_payroll_period_company", "tbl_payroll_period_company.payroll_period_id", "=", "tbl_payroll_period.payroll_period_id");
		$query->join("tbl_payroll_time_keeping_approved", "tbl_payroll_time_keeping_approved.payroll_period_company_id", "=", "tbl_payroll_period_company.payroll_period_company_id");
		$query->join("tbl_payroll_employee_basic", "tbl_payroll_employee_basic.payroll_employee_id", "=", "tbl_payroll_time_keeping_approved.employee_id");
		
		return $query;
	}
	public function scopeGetContributions_employee($query,$shop_id,$month,$year,$employeeid = 0)
	{
		$query->where('month_contribution', $month);
		$query->where('year_contribution', $year);
		$query->where('tbl_payroll_period.shop_id', $shop_id);
		$query->where('tbl_payroll_employee_basic.payroll_employee_id', $employeeid);
		$query->join("tbl_payroll_period_company", "tbl_payroll_period_company.payroll_period_id", "=", "tbl_payroll_period.payroll_period_id");
		$query->join("tbl_payroll_time_keeping_approved", "tbl_payroll_time_keeping_approved.payroll_period_company_id", "=", "tbl_payroll_period_company.payroll_period_company_id");
		$query->join("tbl_payroll_employee_basic", "tbl_payroll_employee_basic.payroll_employee_id", "=", "tbl_payroll_time_keeping_approved.employee_id");
		
		return $query;
	}
	public function scopeGetContributions_filter($query, $shop_id, $month, $year,$company_id,$branch_id)
	{
		$query->where('month_contribution', $month);
		$query->where('year_contribution', $year);
		$query->where('tbl_payroll_period.shop_id', $shop_id);
		$query->orderBy('tbl_payroll_employee_basic.payroll_employee_id','asc');
		$query->join("tbl_payroll_period_company", "tbl_payroll_period_company.payroll_period_id", "=", "tbl_payroll_period.payroll_period_id");
		$query->join("tbl_payroll_time_keeping_approved", "tbl_payroll_time_keeping_approved.payroll_period_company_id", "=", "tbl_payroll_period_company.payroll_period_company_id");
		$query->join("tbl_payroll_employee_basic", "tbl_payroll_employee_basic.payroll_employee_id", "=", "tbl_payroll_time_keeping_approved.employee_id");
		
		if($branch_id != 0)
		{
			$query->where("tbl_payroll_employee_basic.branch_location_id", $branch_id);
		}

		if($company_id != 0)
		{
			$query->where("tbl_payroll_employee_basic.payroll_employee_company_id", $company_id);
		}

		return $query;
	}

	public function scopeGetEmployeeAllPeriodRecords($query, $employee_id, $month, $branch, $company)
	{
		$query->join("tbl_payroll_period_company","tbl_payroll_period_company.payroll_period_id","=","tbl_payroll_period.payroll_period_id")
		->join("tbl_payroll_time_keeping_approved","tbl_payroll_time_keeping_approved.payroll_period_company_id","=","tbl_payroll_period_company.payroll_period_company_id")
		->join("tbl_payroll_employee_basic","tbl_payroll_employee_basic.payroll_employee_id","=","tbl_payroll_time_keeping_approved.employee_id")
		->join("tbl_payroll_company","tbl_payroll_company.payroll_company_id","=","tbl_payroll_period_company.payroll_company_id");

		if ($employee_id != 0) 
		{
			$query->where("tbl_payroll_employee_basic.payroll_employee_id",$employee_id);
		}

		if($month != 'none')
		{
			$query->where("month_contribution",$month);
		}

		if($branch != 0)
		{
			$query->where("tbl_payroll_employee_basic.branch_location_id", $branch);
		}

		if($company != 0)
		{
			$query->where("tbl_payroll_employee_basic.payroll_employee_company_id", $company);
		}
		
		return $query;
	}   

	public function scopeGetFirstPeriod($query,$company,$year,$month)
	{
		$query->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_id','=','tbl_payroll_period.payroll_period_id')
	          ->join('tbl_payroll_company', 'tbl_payroll_company.payroll_company_id','=', 'tbl_payroll_period_company.payroll_company_id')
	            ->where('tbl_payroll_period_company.payroll_period_status','!=','pending')
	            ->where('tbl_payroll_period_company.payroll_company_id',$company)
	            ->where('year_contribution',$year)
	            ->where('period_count','first_period')
	            ->where('month_contribution',$month);

	    return $query;
	}

	public function scopeGetLastPeriod($query,$company,$year,$month)
	{
		$query->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_id','=','tbl_payroll_period.payroll_period_id')
	         ->join('tbl_payroll_company', 'tbl_payroll_company.payroll_company_id','=', 'tbl_payroll_period_company.payroll_company_id')
	          ->where('tbl_payroll_period_company.payroll_period_status','!=','pending')
              ->where('year_contribution',$year)
              ->where('tbl_payroll_period_company.payroll_company_id',$company)
              ->where('period_count','last_period')
              ->where('month_contribution',$month);

              return $query;
	}                                  
}
