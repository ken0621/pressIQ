<?php
namespace App\Globals;


use DB;
use App\Globals\Report;
class Report
{
	public static function sales_report($filter = 'accounting_sales_report')
	{
		// $data['full_name'] = 'Name';
		// $data['jline_amount'] = 'Amount';
		if($filter == 'accounting_sales_report')
		{
			$data['je_remarks'] = 'Remarks';
			$data['je_reference_module'] = 'Reference Module';
			$data['je_entry_date'] = 'Date Created';
			$data['account_name'] = 'Type';
			$data['je_entry_date'] = 'Date';
			$data['account_number'] = 'Num';
			$data['account_name'] = 'Account Name';
			$data['full_name'] = 'Name';
			$data['item_name'] = 'Item';
			$data['z_um'] = 'U/M';
			$data['jline_amount'] = 'Amount';
			// $data[''] = 'Amount Balance';
			return $data;
		}
		else if($filter == 'accounting_sales_report_item')
		{
			$data['je_remarks'] = 'Remarks';
			$data['je_reference_module'] = 'Reference Module';
			$data['je_entry_date'] = 'Date Created';
			$data['account_name'] = 'Type';
			$data['je_entry_date'] = 'Date';
			$data['account_number'] = 'Num';
			$data['account_name'] = 'Account Name';
			$data['full_name'] = 'Name';
			$data['item_name'] = 'Item';
			$data['z_um'] = 'U/M';
			$data['jline_amount'] = 'Amount';
			return $data;
		}
	}	
	public static function sales_report_item()
	{
		$data['je_remarks'] = 'Remarks';
		$data['je_reference_module'] = 'Reference Module';
		$data['je_entry_date'] = 'Date Created';
		$data['account_name'] = 'Type';
		$data['je_entry_date'] = 'Date';
		$data['account_number'] = 'Num';
		$data['account_name'] = 'Account Name';
		$data['full_name'] = 'Name';
		$data['item_name'] = 'Item';
		$data['z_um'] = 'U/M';
		$data['jline_amount'] = 'Amount';
		return $data;
	}


	/**
	 * Get the range of report by selected period 
	 *
	 * @param  string  	$period 	 ( Please see "case" below)
	 * @param  string  	$date  		 $date["start_date"], $date["end_date"], $date["days"] | nullable depends on requirements
	 * @return array    			 [start_date] , [end_date]; 
	 * @author BKA	
	 */
	public static function checkDatePeriod($period, $date = nul)
	{
		switch($period)
		{
			case 'all':
				$data["start_date"] = "1000-01-01";
				$data["end_date"]	= "9999-12-30";
				break;
			case 'custom':
				$data["start_date"] = datepicker_input($date["start"]);
				$data["end_date"]	= datepicker_input($date["end"]);
				break;
			case 'today':
				$data["start_date"] = datepicker_input("today");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'this_week':
				$data["start_date"] = datepicker_input("previous sunday");
				$data["end_date"]	= datepicker_input("this week saturday");
				break;
			case 'this_week_to_date':
				$data["start_date"] = datepicker_input("-1 week sunday");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'last_week':
				$data["start_date"] = datepicker_input("-2 week sunday");
				$data["end_date"]	= datepicker_input("-1 week saturday");
				break;
			case 'last_week_to_date':
				$data["start_date"] = datepicker_input("-2 week sunday");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'this_month':
				$data["start_date"] = datepicker_input("first day of this month");
				$data["end_date"]	= datepicker_input("last day of this month");
				break;
			case 'this_month_to_date':
				$data["start_date"] = datepicker_input("first day of this month");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'last_month':
				$data["start_date"] = datepicker_input("first day of previous month");
				$data["end_date"]	= datepicker_input("last day of previous month");
				break;
			case 'last_month_to_date':
				$data["start_date"] = datepicker_input("first day of previous month");
				$data["end_date"]	= datepicker_input("today");
				break;
			case 'this_quarter':
				$offset 			= (date('n')%3)-1;
				$data["start_date"]	= datepicker_input("first day of -$offset month midnight");
				$offset		 		= 3-(date('n')%3);
				$data["end_date"] 	= datepicker_input("last day of +$offset month midnight");
				break;
			case 'this_quarter_to_date':
				$offset 			= (date('n')%3)-1;
				$data["start_date"]	= datepicker_input("first day of -$offset month midnight");
				$data["end_date"] 	= datepicker_input("today");
				break;
			case 'this_year':
				$data["start_date"] = datepicker_input("first day of January");
				$data["end_date"]	= datepicker_input("last day of December");
				break;
			case 'days_ago':
				$data["start_date"] = datepicker_input("-".$date["days"] ." days");
				$data["end_date"]	= datepicker_input("today");
				break;
		}
		return $data;
	}
}