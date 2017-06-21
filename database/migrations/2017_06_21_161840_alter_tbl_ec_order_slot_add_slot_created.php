<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblEcOrderSlotAddSlotCreated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_ec_order_slot', function (Blueprint $table) {
            $table->integer('order_slot_id_c')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_ec_order_slot', function (Blueprint $table) {
            //
        });
    }
}
