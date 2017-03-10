<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call(tbl_delivery_method::class);
        $this->call(tbl_payrll_rdo::class);
        $this->call(tbl_payroll_employement_status::class);
        $this->call(tbl_payroll_civil_status::class);
        $this->call(tbl_payroll_tax_status::class);

        Model::reguard();
    }
}
