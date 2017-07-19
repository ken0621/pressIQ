<?php

use Illuminate\Database\Seeder;

class tbl_payroll_tax_default extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_payroll_tax_default')->truncate();
        $statement  = "INSERT INTO `tbl_payroll_tax_default` (`payroll_tax_default_id`, `payroll_tax_status_id`, `tax_category`, `tax_first_range`, `tax_second_range`, `tax_third_range`, `tax_fourth_range`, `tax_fifth_range`, `taxt_sixth_range`, `tax_seventh_range`) VALUES
			(1,	1,	'Excemption',	0.00,	1.65,	8.25,	28.05,	74.26,	165.02,	412.54),
			(2,	1,	'Status',	5.00,	10.00,	15.00,	20.00,	25.00,	30.00,	32.00),
			(3,	1,	'Z',	0.00,	33.00,	99.00,	231.00,	462.00,	825.00,	1650.00),
			(4,	1,	'S/ME',	165.00,	198.00,	264.00,	396.00,	627.00,	990.00,	1815.00),
			(5,	1,	'S1/ME1',	248.00,	281.00,	347.00,	479.00,	710.00,	1073.00,	1898.00),
			(6,	1,	'S2/ME2',	330.00,	363.00,	429.00,	561.00,	792.00,	1155.00,	1980.00),
			(7,	1,	'S3/ME3',	413.00,	446.00,	512.00,	644.00,	875.00,	1238.00,	2063.00),
			(8,	1,	'S4/ME4',	495.00,	528.00,	594.00,	726.00,	957.00,	1320.00,	2145.00),
			(9,	2,	'Excemption',	0.00,	9.62,	48.08,	163.46,	432.69,	961.54,	2403.85),
			(10,	2,	'Status',	5.00,	10.00,	15.00,	20.00,	25.00,	30.00,	32.00),
			(11,	2,	'Z',	0.00,	192.00,	577.00,	1346.00,	2692.00,	4808.00,	9615.00),
			(12,	2,	'S/ME',	962.00,	1154.00,	1538.00,	2308.00,	3654.00,	5769.00,	10577.00),
			(13,	2,	'S1/ME1',	1442.00,	1635.00,	2019.00,	2788.00,	4135.00,	6250.00,	11058.00),
			(14,	2,	'S2/ME2',	1923.00,	2115.00,	2500.00,	3269.00,	4615.00,	6731.00,	11538.00),
			(15,	2,	'S3/ME3',	2404.00,	2596.00,	2981.00,	3750.00,	5096.00,	7212.00,	12019.00),
			(16,	2,	'S4/ME4',	2885.00,	3077.00,	3462.00,	4231.00,	5577.00,	7692.00,	12500.00),
			(17,	3,	'Excemption',	0.00,	20.83,	104.17,	354.17,	937.50,	2083.33,	5208.33),
			(18,	3,	'Status',	5.00,	10.00,	15.00,	20.00,	25.00,	30.00,	32.00),
			(19,	3,	'Z',	0.00,	417.00,	1250.00,	2917.00,	5833.00,	10417.00,	20833.00),
			(20,	3,	'S/ME',	2083.00,	2500.00,	3333.00,	5000.00,	7917.00,	12500.00,	22917.00),
			(21,	3,	'S1/ME1',	3125.00,	3542.00,	4375.00,	6042.00,	8958.00,	13542.00,	23958.00),
			(22,	3,	'S2/ME2',	4167.00,	4583.00,	5417.00,	7083.00,	10000.00,	14583.00,	25000.00),
			(23,	3,	'S3/ME3',	5208.00,	5625.00,	6458.00,	8125.00,	11042.00,	15625.00,	26046.00),
			(24,	3,	'S4/ME4',	6250.00,	6667.00,	7500.00,	9167.00,	12083.00,	16667.00,	27083.00),
			(25,	4,	'Excemption',	0.00,	41.67,	208.33,	708.33,	1875.00,	4166.67,	10416.67),
			(26,	4,	'Status',	5.00,	10.00,	15.00,	20.00,	25.00,	30.00,	32.00),
			(27,	4,	'Z',	0.00,	833.00,	2500.00,	5833.00,	11667.00,	20833.00,	41667.00),
			(28,	4,	'S/ME',	4167.00,	5000.00,	6667.00,	10000.00,	15833.00,	25000.00,	45833.00),
			(29,	4,	'S1/ME1',	6250.00,	7083.00,	8750.00,	12083.00,	17917.00,	27083.00,	47917.00),
			(30,	4,	'S2/ME2',	8333.00,	9167.00,	10833.00,	14167.00,	20000.00,	29167.00,	50000.00),
			(31,	4,	'S3/ME3',	10417.00,	11250.00,	12917.00,	16250.00,	22083.00,	31250.00,	52083.00),
			(32,	4,	'S4/ME4',	12500.00,	13333.00,	15000.00,	18333.00,	24167.00,	33333.00,	54167.00);";

		DB::statement($statement);
    }
}
