<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCommission102717121PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_commission', function (Blueprint $table) {
            $table->increments('commission_id');
            $table->integer('customer_id');
            $table->string('customer_email');
            $table->integer('agent_id');
            $table->date('date_created');
            $table->date('due_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_commission');
    }
}
