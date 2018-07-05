<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblCommission070518544PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_commission', function (Blueprint $table) {
            $table->double("tcp_commission")->default(0)->nullable()->after("loanable_amount");
            $table->double("ndp_commission")->default(0)->nullable()->after("loanable_amount");
            $table->double("agent_rate")->default(0)->nullable()->after("agent_id");
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
