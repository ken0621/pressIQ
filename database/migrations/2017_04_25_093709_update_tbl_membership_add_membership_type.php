<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMembershipAddMembershipType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_membership', function (Blueprint $table) 
        {
            if(!schema::hasColumn('tbl_membership','membership_type'))
            {
                $table->integer('membership_type')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_membership', function (Blueprint $table) {
            //
        });
    }
}
