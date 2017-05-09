<?php
namespace App\Globals;


use DB;
use App\Globals\Report;
class Report
{
	public static function sales_report()
	{
		// tbl_journal_entry
		$data['je_reference_module'] = 'Reference Module';
		$data['je_entry_date'] = 'Date Created';
		$data['je_remarks'] = 'Remarks';
		$data['full_name'] = 'Name';
		$data['jline_amount'] = 'Amount';

		// $data['account_name'] = 'Type';
		// $data['je_entry_date'] = 'Date';
		// $data['account_number'] = 'Num';
		// $data['full_name'] = 'Name';
		// $data['item_name'] = 'Item';
		// $data[''] = 'Qty';
		// $data[''] = 'U/M';
		// $data[''] = 'Sales Price';
		// $data[''] = 'Amount Balance';
		return $data;
	}	
}