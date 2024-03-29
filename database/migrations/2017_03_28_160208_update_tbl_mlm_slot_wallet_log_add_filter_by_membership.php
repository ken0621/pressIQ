<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMlmSlotWalletLogAddFilterByMembership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_mlm_slot_wallet_log', function (Blueprint $table) {
            $table->integer('wallet_log_membership_filter')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_mlm_slot_wallet_log', function (Blueprint $table) {
            //
        });
    }
}
