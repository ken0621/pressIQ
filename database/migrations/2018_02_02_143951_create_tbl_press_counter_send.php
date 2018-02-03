<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPressCounterSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pressiq_counter', function (Blueprint $table)
        {
            $table->increments("counter_id");
            $table->integer("user_id");
            $table->string("user_email");
            $table->string("user_news");
            $table->string("counter_send");
            $table->string("pr_from");
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
