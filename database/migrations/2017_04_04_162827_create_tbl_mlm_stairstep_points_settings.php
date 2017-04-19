<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMlmStairstepPointsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_mlm_stairstep_points_settings', function (Blueprint $table) 
        {
            $table->integer('stairstep_points_level');
            $table->double('stairstep_points_amount');
            $table->tinyInteger('stairstep_points_percentage');
            $table->integer('shop_id')->unsigned();
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
