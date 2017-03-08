<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_journal_entry extends Model
{
	protected $table = 'tbl_journal_entry';
	protected $primaryKey = "je_id";
    public $timestamps = false;

    public function scopeLine($query)
    {
    	return $query->leftjoin("tbl_journal_entry_line","jline_je_id","=","je_id");
    }
}