<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_pressiq_media_type extends Model
{
    protected $table = 'tbl_pressiq_media';
    protected $primaryKey = "media_id";
    public $timestamps = false;
}
