<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_audit_trail extends Model
{
	protected $table = 'tbl_audit_trail';
	protected $primaryKey = "audit_trail_id";
    public $timestamps = true;

    public function scopeUser($query)
    {
    	 return $query->join('tbl_user', 'tbl_user.user_id', '=', 'tbl_audit_trail.user_id');
    }
}
