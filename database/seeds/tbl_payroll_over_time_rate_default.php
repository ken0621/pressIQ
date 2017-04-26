<?php

use Illuminate\Database\Seeder;

class tbl_payroll_over_time_rate_default extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_payroll_over_time_rate_default')->truncate();

        $statement = "INSERT INTO `tbl_payroll_over_time_rate_default` (`payroll_over_time_rate_default_id`, `payroll_overtime_name`, `payroll_overtime_regular`, `payroll_overtime_overtime`, `payroll_overtime_nigth_diff`, `payroll_overtime_rest_day`, `payroll_overtime_rest_overtime`, `payroll_overtime_rest_night`) VALUES
			(1,	'Regular',	0.00,	0.25,	0.10,	0.30,	0.69,	0.10),
			(2,	'Legal Holiday',	1.00,	1.60,	0.10,	1.60,	2.38,	0.10),
			(3,	'Special Holiday',	0.30,	0.69,	0.10,	0.50,	0.95,	0.10);";

        DB::statement($statement);
    }
}
