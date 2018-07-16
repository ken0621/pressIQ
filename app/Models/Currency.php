<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	protected $table = 'currency';
	protected $primaryKey = "iso";
    public $timestamps = false;
}