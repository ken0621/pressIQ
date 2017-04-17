<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_journal_tag extends Model
{
    protected $table = 'tbl_payroll_journal_tag';
	protected $primaryKey = "payroll_journal_tag_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [INTEGER]		payroll_journal_tag_id
	// [INTEGER]		shop_id
	// [INTEGER]		account_id
	// [TINY INTEGER]	journal_tag_archived

	public function scopegettag($query, $shop_id = 0)
	{
		$query->join('tbl_chart_of_account','tbl_chart_of_account.account_id','=','tbl_payroll_journal_tag.account_id')
			 ->where('tbl_payroll_journal_tag.shop_id', $shop_id);

		return $query;
	}
}
