<?php

use Illuminate\Database\Seeder;

class tbl_payroll_entity extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('tbl_payroll_entity')->truncate();

        $statment = "INSERT INTO `tbl_payroll_entity` (`payroll_entity_id`, `entity_name`, `entity_category`) VALUES
        (1, '13 Month Pay', 'basic'),
        (2, 'Basic Salary Pay', 'basic'),
        (3, 'Early Over Time Pay',  'basic'),
        (4, 'Extra Day Pay',    'basic'),
        (5, 'Leave With Pay',   'basic'),
        (6, 'Night Differential Pay',   'basic'),
        (7, 'Regular Holiday Pay',  'basic'),
        (8, 'Regular Over Time Pay',    'basic'),
        (9, 'Rest Day Pay', 'basic'),
        (10, 'COLA', 'basic'),
        (11,    'Special Holiday Pay',  'basic'),
        (12,    'Allowance Pay',    'deminimis'),
        (13,    'Bonus Pay',    'deminimis'),
        (14,    'Commission Pay',   'deminimis'),
        (15,    'Incentive Pay',    'deminimis'),
        (16,    'Pagibig',  'goverment'),
        (17,    'Philhealth EE',    'goverment'),
        (18,    'Philhealth ER',    'goverment'),
        (19,    'SSS EC',   'goverment'),
        (20,    'SSS EE',   'goverment'),
        (21,    'SSS ER',   'goverment'),
        (22,    'Tax',  'goverment'),
        (23,    'Cash Advance',  'deductions'),
        (24,    'Cash Bond',    'deductions'),
        (25,    'Loans',    'deductions'),
        (26,    'Other Deduction',   'deductions'),
        (27,    'Late',   'deductions'),
        (28,    'Absent',   'deductions'),
        (29,    'Under Time',   'deductions'),
        (30,    'Net Salary',   'net');";

        DB::statement($statment);

    }
}
