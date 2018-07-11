<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblCommission070518446PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_commission', function (Blueprint $table) {
            $table->double("total_net_commission")->default(0)->nullable()->after("total_commission");
            $table->double("ewt_amount")->default(0)->nullable()->after("total_commission");
            $table->double("ewt")->default(0)->nullable()->after("total_commission");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_commission', function (Blueprint $table) {
            //
        });
    }
}
