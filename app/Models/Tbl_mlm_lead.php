<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_mlm_lead extends Model
{
	protected $table = 'tbl_mlm_lead';
	protected $primaryKey = "lead_id";
    public $timestamps = false;
}