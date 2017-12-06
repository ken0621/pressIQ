<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBrownEzProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_brown_ez_program', function (Blueprint $table)
        {
            $table->increments("ez_program_id");
            $table->integer("record_program_log_id")->unsigned();
            $table->integer("shop_program_id")->unsigned();
            $table->double("paid_price")->default(0);
            $table->double("cd_price")->default(0);
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
