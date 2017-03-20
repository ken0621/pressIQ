<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblInventorySerialNumber5678 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_inventory_serial_number', function (Blueprint $table) {
            $table->renameColumn("inventory_id", "serial_inventory_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_inventory_serial_number', function (Blueprint $table) {
            //
        });
    }
}
