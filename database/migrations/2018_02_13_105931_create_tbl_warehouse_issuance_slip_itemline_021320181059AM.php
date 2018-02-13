<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblWarehouseIssuanceSlipItemline021320181059AM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_warehouse_issuance_slip_itemline', function (Blueprint $table) {
            $table->increments("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_warehouse_issuance_slip_itemline', function (Blueprint $table) {
            //
        });
    }
}
