<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_pressiq_press_release extends Model
{
    protected $table = 'tbl_pressiq_press_release';
    protected $primaryKey = "pr_id";
    public $timestamps = false;
}
