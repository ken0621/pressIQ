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
        Schema::create('tbl_stairstep_distribute_slot', function (Blueprint $table) 
        {
            $table->increments('stairstep_distributed_slot_id');
            $table->integer('slot_id')->unsigned();
            $table->integer('stairstep_distribute_id')->unsigned();
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
