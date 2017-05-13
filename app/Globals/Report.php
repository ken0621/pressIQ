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
}