<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $sql = "--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `iso` char(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`iso`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`iso`, `name`) VALUES
('KRW', '(South) Korean Won'),
('AFA', 'Afghanistan Afghani'),
('ALL', 'Albanian Lek'),
('DZD', 'Algerian Dinar'),
('ADP', 'Andorran Peseta'),
('AOK', 'Angolan Kwanza'),
('ARS', 'Argentine Peso'),
('AMD', 'Armenian Dram'),
('AWG', 'Aruban Florin'),
('AUD', 'Australian Dollar'),
('BSD', 'Bahamian Dollar'),
('BHD', 'Bahraini Dinar'),
('BDT', 'Bangladeshi Taka'),
('BBD', 'Barbados Dollar'),
('BZD', 'Belize Dollar'),
('BMD', 'Bermudian Dollar'),
('BTN', 'Bhutan Ngultrum'),
('BOB', 'Bolivian Boliviano'),
('BWP', 'Botswanian Pula'),
('BRL', 'Brazilian Real'),
('GBP', 'British Pound'),
('BND', 'Brunei Dollar'),
('BGN', 'Bulgarian Lev'),
('BUK', 'Burma Kyat'),
('BIF', 'Burundi Franc'),
('CAD', 'Canadian Dollar'),
('CVE', 'Cape Verde Escudo'),
('KYD', 'Cayman Islands Dollar'),
('CLP', 'Chilean Peso'),
('CLF', 'Chilean Unidades de Fomento'),
('COP', 'Colombian Peso'),
('XOF', 'Communauté Financière Africaine BCEAO - Francs'),
('XAF', 'Communauté Financière Africaine BEAC, Francs'),
('KMF', 'Comoros Franc'),
('XPF', 'Comptoirs Français du Pacifique Francs'),
('CRC', 'Costa Rican Colon'),
('CUP', 'Cuban Peso'),
('CYP', 'Cyprus Pound'),
('CZK', 'Czech Republic Koruna'),
('DKK', 'Danish Krone'),
('YDD', 'Democratic Yemeni Dinar'),
('DOP', 'Dominican Peso'),
('XCD', 'East Caribbean Dollar'),
('TPE', 'East Timor Escudo'),
('ECS', 'Ecuador Sucre'),
('EGP', 'Egyptian Pound'),
('SVC', 'El Salvador Colon'),
('EEK', 'Estonian Kroon (EEK)'),
('ETB', 'Ethiopian Birr'),
('EUR', 'Euro'),
('FKP', 'Falkland Islands Pound'),
('FJD', 'Fiji Dollar'),
('GMD', 'Gambian Dalasi'),
('GHC', 'Ghanaian Cedi'),
('GIP', 'Gibraltar Pound'),
('XAU', 'Gold, Ounces'),
('GTQ', 'Guatemalan Quetzal'),
('GNF', 'Guinea Franc'),
('GWP', 'Guinea-Bissau Peso'),
('GYD', 'Guyanan Dollar'),
('HTG', 'Haitian Gourde'),
('HNL', 'Honduran Lempira'),
('HKD', 'Hong Kong Dollar'),
('HUF', 'Hungarian Forint'),
('INR', 'Indian Rupee'),
('IDR', 'Indonesian Rupiah'),
('XDR', 'International Monetary Fund (IMF) Special Drawing Rights'),
('IRR', 'Iranian Rial'),
('IQD', 'Iraqi Dinar'),
('IEP', 'Irish Punt'),
('ILS', 'Israeli Shekel'),
('JMD', 'Jamaican Dollar'),
('JPY', 'Japanese Yen'),
('JOD', 'Jordanian Dinar'),
('KHR', 'Kampuchean (Cambodian) Riel'),
('KES', 'Kenyan Schilling'),
('KWD', 'Kuwaiti Dinar'),
('LAK', 'Lao Kip'),
('LBP', 'Lebanese Pound'),
('LSL', 'Lesotho Loti'),
('LRD', 'Liberian Dollar'),
('LYD', 'Libyan Dinar'),
('MOP', 'Macau Pataca'),
('MGF', 'Malagasy Franc'),
('MWK', 'Malawi Kwacha'),
('MYR', 'Malaysian Ringgit'),
('MVR', 'Maldive Rufiyaa'),
('MTL', 'Maltese Lira'),
('MRO', 'Mauritanian Ouguiya'),
('MUR', 'Mauritius Rupee'),
('MXP', 'Mexican Peso'),
('MNT', 'Mongolian Tugrik'),
('MAD', 'Moroccan Dirham'),
('MZM', 'Mozambique Metical'),
('NAD', 'Namibian Dollar'),
('NPR', 'Nepalese Rupee'),
('ANG', 'Netherlands Antillian Guilder'),
('YUD', 'New Yugoslavia Dinar'),
('NZD', 'New Zealand Dollar'),
('NIO', 'Nicaraguan Cordoba'),
('NGN', 'Nigerian Naira'),
('KPW', 'North Korean Won'),
('NOK', 'Norwegian Kroner'),
('OMR', 'Omani Rial'),
('PKR', 'Pakistan Rupee'),
('XPD', 'Palladium Ounces'),
('PAB', 'Panamanian Balboa'),
('PGK', 'Papua New Guinea Kina'),
('PYG', 'Paraguay Guarani'),
('PEN', 'Peruvian Nuevo Sol'),
('PHP', 'Philippine Peso'),
('XPT', 'Platinum, Ounces'),
('PLN', 'Polish Zloty'),
('QAR', 'Qatari Rial'),
('RON', 'Romanian Leu'),
('RUB', 'Russian Ruble'),
('RWF', 'Rwanda Franc'),
('WST', 'Samoan Tala'),
('STD', 'Sao Tome and Principe Dobra'),
('SAR', 'Saudi Arabian Riyal'),
('SCR', 'Seychelles Rupee'),
('SLL', 'Sierra Leone Leone'),
('XAG', 'Silver, Ounces'),
('SGD', 'Singapore Dollar'),
('SKK', 'Slovak Koruna'),
('SBD', 'Solomon Islands Dollar'),
('SOS', 'Somali Schilling'),
('ZAR', 'South African Rand'),
('LKR', 'Sri Lanka Rupee'),
('SHP', 'St. Helena Pound'),
('SDP', 'Sudanese Pound'),
('SRG', 'Suriname Guilder'),
('SZL', 'Swaziland Lilangeni'),
('SEK', 'Swedish Krona'),
('CHF', 'Swiss Franc'),
('SYP', 'Syrian Potmd'),
('TWD', 'Taiwan Dollar'),
('TZS', 'Tanzanian Schilling'),
('THB', 'Thai Baht'),
('TOP', 'Tongan Paanga'),
('TTD', 'Trinidad and Tobago Dollar'),
('TND', 'Tunisian Dinar'),
('TRY', 'Turkish Lira'),
('UGX', 'Uganda Shilling'),
('AED', 'United Arab Emirates Dirham'),
('UYU', 'Uruguayan Peso'),
('USD', 'US Dollar'),
('VUV', 'Vanuatu Vatu'),
('VEF', 'Venezualan Bolivar'),
('VND', 'Vietnamese Dong'),
('YER', 'Yemeni Rial'),
('CNY', 'Yuan (Chinese) Renminbi'),
('ZRZ', 'Zaire Zaire'),
('ZMK', 'Zambian Kwacha'),
('ZWD', 'Zimbabwe Dollar');";
        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
