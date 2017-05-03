<?php

use Illuminate\Database\Seeder;

class tbl_online_pymnt_method extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_online_pymnt_method')->truncate();
        $statement = "INSERT INTO `tbl_online_pymnt_method` (`method_id`,`method_name`, `method_code_name`, `method_gateway_accepted`) VALUES
            (1, 'Credit Card', 'credit-card', '1,2,3,4'),
            (2, 'Paypal', 'paypal', '1,2,3,4,6'),
            (3, 'Metro Bank', 'metrobank', '1,2,3,4,5'),
            (4, 'BDO', 'bdo', '1,2,3,4,5'),
            (5, 'BPI', 'bpi', '1,2,3,4,5'),
            (6, 'E-Wallet', 'e-wallet', ''),
            (7, 'Remittance', 'remittance', '1,2,3,4,5'),
            (8, 'Ipay88', 'ipay88', '6')
            ";

        DB::statement($statement);
    }
}