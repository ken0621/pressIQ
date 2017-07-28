<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblMlmSlotWalletLogAddEonUse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_mlm_slot_wallet_log', function (Blueprint $table) {
            //
            $table->string('wallet_slot_eon')->nullable();
            $table->string('wallet_slot_eon_card_no')->nullable();
            $table->string('wallet_slot_eon_account_no')->nullable();
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
