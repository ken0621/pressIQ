-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: c9
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `iso` char(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`iso`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES ('KRW','(South) Korean Won'),('AFA','Afghanistan Afghani'),('ALL','Albanian Lek'),('DZD','Algerian Dinar'),('ADP','Andorran Peseta'),('AOK','Angolan Kwanza'),('ARS','Argentine Peso'),('AMD','Armenian Dram'),('AWG','Aruban Florin'),('AUD','Australian Dollar'),('BSD','Bahamian Dollar'),('BHD','Bahraini Dinar'),('BDT','Bangladeshi Taka'),('BBD','Barbados Dollar'),('BZD','Belize Dollar'),('BMD','Bermudian Dollar'),('BTN','Bhutan Ngultrum'),('BOB','Bolivian Boliviano'),('BWP','Botswanian Pula'),('BRL','Brazilian Real'),('GBP','British Pound'),('BND','Brunei Dollar'),('BGN','Bulgarian Lev'),('BUK','Burma Kyat'),('BIF','Burundi Franc'),('CAD','Canadian Dollar'),('CVE','Cape Verde Escudo'),('KYD','Cayman Islands Dollar'),('CLP','Chilean Peso'),('CLF','Chilean Unidades de Fomento'),('COP','Colombian Peso'),('XOF','Communauté Financière Africaine BCEAO - Francs'),('XAF','Communauté Financière Africaine BEAC, Francs'),('KMF','Comoros Franc'),('XPF','Comptoirs Français du Pacifique Francs'),('CRC','Costa Rican Colon'),('CUP','Cuban Peso'),('CYP','Cyprus Pound'),('CZK','Czech Republic Koruna'),('DKK','Danish Krone'),('YDD','Democratic Yemeni Dinar'),('DOP','Dominican Peso'),('XCD','East Caribbean Dollar'),('TPE','East Timor Escudo'),('ECS','Ecuador Sucre'),('EGP','Egyptian Pound'),('SVC','El Salvador Colon'),('EEK','Estonian Kroon (EEK)'),('ETB','Ethiopian Birr'),('EUR','Euro'),('FKP','Falkland Islands Pound'),('FJD','Fiji Dollar'),('GMD','Gambian Dalasi'),('GHC','Ghanaian Cedi'),('GIP','Gibraltar Pound'),('XAU','Gold, Ounces'),('GTQ','Guatemalan Quetzal'),('GNF','Guinea Franc'),('GWP','Guinea-Bissau Peso'),('GYD','Guyanan Dollar'),('HTG','Haitian Gourde'),('HNL','Honduran Lempira'),('HKD','Hong Kong Dollar'),('HUF','Hungarian Forint'),('INR','Indian Rupee'),('IDR','Indonesian Rupiah'),('XDR','International Monetary Fund (IMF) Special Drawing Rights'),('IRR','Iranian Rial'),('IQD','Iraqi Dinar'),('IEP','Irish Punt'),('ILS','Israeli Shekel'),('JMD','Jamaican Dollar'),('JPY','Japanese Yen'),('JOD','Jordanian Dinar'),('KHR','Kampuchean (Cambodian) Riel'),('KES','Kenyan Schilling'),('KWD','Kuwaiti Dinar'),('LAK','Lao Kip'),('LBP','Lebanese Pound'),('LSL','Lesotho Loti'),('LRD','Liberian Dollar'),('LYD','Libyan Dinar'),('MOP','Macau Pataca'),('MGF','Malagasy Franc'),('MWK','Malawi Kwacha'),('MYR','Malaysian Ringgit'),('MVR','Maldive Rufiyaa'),('MTL','Maltese Lira'),('MRO','Mauritanian Ouguiya'),('MUR','Mauritius Rupee'),('MXP','Mexican Peso'),('MNT','Mongolian Tugrik'),('MAD','Moroccan Dirham'),('MZM','Mozambique Metical'),('NAD','Namibian Dollar'),('NPR','Nepalese Rupee'),('ANG','Netherlands Antillian Guilder'),('YUD','New Yugoslavia Dinar'),('NZD','New Zealand Dollar'),('NIO','Nicaraguan Cordoba'),('NGN','Nigerian Naira'),('KPW','North Korean Won'),('NOK','Norwegian Kroner'),('OMR','Omani Rial'),('PKR','Pakistan Rupee'),('XPD','Palladium Ounces'),('PAB','Panamanian Balboa'),('PGK','Papua New Guinea Kina'),('PYG','Paraguay Guarani'),('PEN','Peruvian Nuevo Sol'),('PHP','Philippine Peso'),('XPT','Platinum, Ounces'),('PLN','Polish Zloty'),('QAR','Qatari Rial'),('RON','Romanian Leu'),('RUB','Russian Ruble'),('RWF','Rwanda Franc'),('WST','Samoan Tala'),('STD','Sao Tome and Principe Dobra'),('SAR','Saudi Arabian Riyal'),('SCR','Seychelles Rupee'),('SLL','Sierra Leone Leone'),('XAG','Silver, Ounces'),('SGD','Singapore Dollar'),('SKK','Slovak Koruna'),('SBD','Solomon Islands Dollar'),('SOS','Somali Schilling'),('ZAR','South African Rand'),('LKR','Sri Lanka Rupee'),('SHP','St. Helena Pound'),('SDP','Sudanese Pound'),('SRG','Suriname Guilder'),('SZL','Swaziland Lilangeni'),('SEK','Swedish Krona'),('CHF','Swiss Franc'),('SYP','Syrian Potmd'),('TWD','Taiwan Dollar'),('TZS','Tanzanian Schilling'),('THB','Thai Baht'),('TOP','Tongan Paanga'),('TTD','Trinidad and Tobago Dollar'),('TND','Tunisian Dinar'),('TRY','Turkish Lira'),('UGX','Uganda Shilling'),('AED','United Arab Emirates Dirham'),('UYU','Uruguayan Peso'),('USD','US Dollar'),('VUV','Vanuatu Vatu'),('VEF','Venezualan Bolivar'),('VND','Vietnamese Dong'),('YER','Yemeni Rial'),('CNY','Yuan (Chinese) Renminbi'),('ZRZ','Zaire Zaire'),('ZMK','Zambian Kwacha'),('ZWD','Zimbabwe Dollar');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2016_09_03_014626_tbl_country',1),('2016_09_03_015814_tbl_shop',1),('2016_09_03_015829_tbl_user',1),('2016_09_08_071811_tbl_product_vendor',1),('2016_09_08_071812_tbl_product_type',1),('2016_09_08_071813_tbl_product',1),('2016_09_08_071814_tbl_image',1),('2016_09_10_111249_sessions',1),('2016_10_06_074124_create_product_variant',1),('2016_11_03_083740_create_customer',1),('2016_11_04_014838_creat_customer_search',1),('2016_11_05_032420_create_tag',1),('2016_11_07_051114_create_tbl_order',1),('2016_11_07_053035_create_tbl_order_item',1),('2016_11_12_012139_create_order_refund',1),('2016_11_12_012158_create_order_refund_item',1),('2016_11_16_071448_create_tbl_shipping_name',1),('2016_11_18_080755_create_tbl_about_us',1),('2016_11_22_094535_create_contact',1),('2016_11_23_030330_create_tbl_location',1),('2016_11_26_052714_tbl_order_update',1),('2016_11_28_091337_create_tbl_collection',1),('2016_12_05_082901_create_tbl_collection_item',1),('2016_12_06_020250_create_tbl_membership',1),('2016_12_06_021632_create_tbl_chart_account_type',1),('2016_12_06_031600_create_tbl_chart_of_account',1),('2016_12_06_063248_create_tbl_membership_package',1),('2016_12_06_063314_create_tbl_membership_package_has',1),('2016_12_07_022907_create_default_chart_account',1),('2016_12_08_081336_create_customer_other_info',1),('2016_12_08_092402_create_customer_attachment',1),('2016_12_08_094133_create_payment_method',1),('2016_12_08_094720_create_term',1),('2016_12_09_030914_create_tbl_customer_address',1),('2016_12_13_084208_create_tbl_membership_code',1),('2016_12_13_091506_create_tbl_mlm_plan',1),('2016_12_14_033615_create_tbl_membership_points',1),('2016_12_14_082818_create_tbl_e_commerce_banking',1),('2016_12_14_083559_create_tbl_e_commerce_remmittance',1),('2016_12_14_091110_update_tbl_membership_code_recreate',1),('2016_12_16_020317_create_tbl_indirect_settings',1),('2016_12_16_063041_create_tbl_stairstep_settings',1),('2016_12_17_021353_create_tbl_ecommer_setting',1),('2016_12_17_063623_create_tbl_ecommerce_paypal',1),('2016_12_19_022542_alter_tbl_order',1),('2016_12_19_081015_create_tbl_mlm_product_points',1),('2016_12_19_082821_create_tbl_unit_measurement',1),('2016_12_19_085518_update_tbl_product_and_variant_major',1),('2016_12_19_090851_create_tbl_mlm_binary_pairing',1),('2016_12_20_060727_alter_tbl_product_type_to_category',1),('2016_12_20_062525_create_tbl_service',1),('2016_12_20_082543_update_product_and_service_unit_measurement',1),('2016_12_20_083422_create_tbl_mlm_unilevel_settings',1),('2016_12_20_084402_update_tbl_shop_rev_1',1),('2016_12_20_090138_create_view_item_list',1),('2016_12_21_015647_create_tbl_delivery_method',1),('2016_12_21_031944_alter_tbl_customer_attachment',1),('2016_12_21_035214_update_tbl_mlm_indirect_setting',1),('2016_12_21_070758_update_tbl_shop_rev2',1),('2016_12_21_074303_update_tbl_membership_code_shop_id',1),('2016_12_22_013929_create_product_search',1),('2016_12_22_030518_create_table_mlm_plan_settings',1),('2016_12_22_051504_update_tbl_customer_other_info_rev2',1),('2016_12_22_075533_create_trigger_search_product',1),('2016_12_22_084219_create_trigger_update_search_product',1),('2016_12_23_034344_update_tbl_membership_code_price_and_id',1),('2016_12_23_055217_update_tbl_membership_codes_membership_type',1),('2016_12_23_080636_update_tbl_shop_rev3',1),('2016_12_23_082605_update_tbl_membership_code_date_used_created',1),('2016_12_27_055240_create_tbl_products',1),('2016_12_28_013615_create_tbl_slot',1),('2016_12_29_020410_create_tbl_tree_placement',1),('2016_12_29_021420_create_tbl_tree_sponsor',1),('2016_12_29_040355_create_tbl_item_type',1),('2016_12_29_053120_create_tbl_mlm_wallet_logs',1),('2016_12_29_055610_update_tbl_item_shop_id',1),('2016_12_29_061050_alter_tbl_mlm_slot',1),('2017_01_05_050617_update_tbl_item_3456',1),('2017_01_05_063857_update_tbl_membership_package_has_item_id',1),('2017_01_07_030608_update_tbl_item_323',1),('2017_01_07_050700_create_tbl_item_product_points',1),('2017_01_07_054355_tbl_mlm_binary_settings',1),('2017_01_07_090623_alter_tbl_mlm_slot_gc',1),('2017_01_10_012902_create_tbl_customer_invoice',1),('2017_01_10_050323_create_tbl_item_invoice',1),('2017_01_10_051844_update_tbl_invoices_total',1),('2017_01_10_092339_alter_tbl_mlm_slot_wallet_log',1),('2017_01_10_092500_alter_tbl_mlm_plan',1),('2017_01_11_063434_create_tbl_mlm_slot_wallet_type',1),('2017_01_11_084219_update_tbl_item_2530',1),('2017_01_11_085315_alter_tbl_mlm_binary_setttings_11',1),('2017_01_12_053141_create_tbl_warehouse_52530',1),('2017_01_12_054437_create_tbl_warehouse_inventory_52530',1),('2017_01_12_054910_alter_tbl_mlm_binary_setttings_1_12_2017_1',1),('2017_01_12_060642_create_tbl_warehouse_inventory_xxxx',1),('2017_01_12_085454_update_tbl_warehouse_xxxx',1),('2017_01_13_071832_update_tbl_warehouse',1),('2017_01_13_074026_update_tbl_item_repurchase',1),('2017_01_16_030958_update_tbl_item_points_upgrade',1),('2017_01_16_032027_drop_column_tbl_item',1),('2017_01_16_035147_alter_tbl_mlm_slot_add_inactibe',1),('2017_01_16_051409_update_tbl_item_code_used_on_slot',1),('2017_01_16_054425_update_tbl_warehouse_inventory_transfer',1),('2017_01_16_054912_create_tbl_inventory_slip',1),('2017_01_16_061206_update_tbl_inventory_slip_v2',1),('2017_01_16_065314_update_tbl_inventory_slip_v4',1),('2017_01_16_070615_update_tbl_inventory_slip_v5',1),('2017_01_17_022009_alter_tbl_membership_used_by_slot',1),('2017_01_17_031620_create_tbl_currency',1),('2017_01_17_055709_create_tbl_settings',1),('2017_01_17_060157_create_tbl_cart',1),('2017_01_17_065858_update_tbl_inventory_slip_v6',1),('2017_01_17_073552_alter_tbl_settings_add_shop_id',1),('2017_01_17_093218_create_tbl_coupon_code',1),('2017_01_18_055152_update_tbl_item_discount',1),('2017_01_18_063850_update_tbl_coupon_code_discount',1),('2017_01_18_082023_create_tbl_item_discount',1),('2017_01_19_030010_update_tbl_inventory_slip_v7',1),('2017_01_19_060746_create_tbl_journal_entry',1),('2017_01_20_032145_tbl_voucher_and_tbl_voucher_item',1),('2017_01_20_070939_alter_tbl_voucher',1),('2017_01_20_071313_alter_tbl_voucher_remove_total',1),('2017_01_20_085944_create_tbl_mlm_matching',1),('2017_01_23_064525_create_tbl_inventory_serial_number_v1',1),('2017_01_23_070527_alter_tbl_customer_invoice',1),('2017_01_24_020159_alter_tbl_membership_points_add_executive_bonus',1),('2017_01_24_022422_create_tbl_mlm_complan_executive_bonus',1),('2017_01_24_024933_create_tbl_post',1),('2017_01_24_025252_alter_invoice_remove_ar',1),('2017_01_24_034812_create_tbl_mlm_slot_points',1),('2017_01_24_053752_alter_tbl_journal_entry',1),('2017_01_24_062823_alter_tbl_mlm_slot_points_add_points',1),('2017_01_24_070350_create_tbl_post_category',1),('2017_01_24_071153_create_rel_post_category',1),('2017_01_25_015112_alter_tbl_post_add_image',1),('2017_01_25_055959_update_tbl_item_010517',1),('2017_01_26_030129_alter_tbl_post_category_add_shop_id',1),('2017_01_26_032047_alter_tbl_membership_points_add_leadership',1),('2017_01_26_033935_update_tbl_warehouse_010517',1),('2017_01_26_053841_create_tbl_mlm_leadership_settings',1),('2017_01_26_083729_create_table_pis_010517',1),('2017_01_26_084036_alter_tbl_mlm_slot_points_log',1),('2017_01_27_030829_modify_tbl_user_with_access',1),('2017_01_27_034235_alter_tbl_membership_points_add_direct_points',1),('2017_01_27_055557_create_tbl_mlm_indirect_points_settings',1),('2017_01_27_073928_create_tbl_unit_measurement_123456',1),('2017_01_30_022303_create_tbl_content',1),('2017_01_30_052348_update_tbl_unit_measurement_type_xxxx',1),('2017_01_30_054422_update_tbl_unit_measurement_type_00517',1),('2017_01_31_031325_update_tbl_unit_measurement_1111',1),('2017_01_31_071656_update_tbl_unit_measurement_11as11',1),('2017_01_31_073549_update_tbl_unit_measurement_multi_11as11',1),('2017_01_31_085146_create_Tbl_mlm_item_dicount',1),('2017_02_01_052655_update_tbl_mlm_unilevel_settings_add_type_c',1),('2017_02_01_071448_alter_tbl_item_code_add_slot',1),('2017_02_01_082001_alter_tbl_item_code_invoice_add_slot',1),('2017_02_01_091034_update_tbl_item_item_dropdowns',1),('2017_02_01_093223_update_tbl_truck_23456',1),('2017_02_02_014805_update_tbl_truck_23456',1),('2017_02_02_051522_update_tbl_position_2345',1),('2017_02_03_090358_alter_tbl_customer_add_mlm',1),('2017_02_03_094251_update_tbl_item_34s5d67',1),('2017_02_03_095307_update_tbl_sir_item_34s5d67',1),('2017_02_04_053525_update_tbl_sir_45r6t',1),('2017_02_04_081040_update_tbl_item_45r6t',1),('2017_02_06_012515_update_tbl_sir_3456er',1),('2017_02_06_072257_update_tbl_sir_item_3456',1),('2017_02_07_051457_update_tbl_product_item_id',1),('2017_02_07_075215_update_tbl_cust_invoice',1),('2017_02_07_092320_create_tbl_mlm_unilevel_points_settings',1),('2017_02_08_025325_create_tbl_manual_invoice_2344',1),('2017_02_08_063718_update_tbl_invoice_ewt',1),('2017_02_08_070857_update_tbl_invoice_v2',1),('2017_02_09_010544_update_tb_unit_measurement_2345trfe',1),('2017_02_09_011934_update_tbl_mlm_slot_wallet_log_add_notify',1),('2017_02_09_053608_alter_tbl_product_add_product_image',1),('2017_02_09_075907_alter_tbl_item_add_show_in_mlm',1),('2017_02_10_013502_update_tbl_customer_add_tin',1),('2017_02_10_013647_create_tbl_ecommerce_product',1),('2017_02_10_033140_create_tbl_mlm_discount_card_settings',1),('2017_02_10_060125_create_tbl_mlm_discount_cad_log',1),('2017_02_13_010637_update_tbl_sir_45t',1),('2017_02_14_032338_create_tbl_mlm_lead',1),('2017_02_15_032539_alter_foreign_key_variant_id',1),('2017_02_15_053753_alter_view_ecommerce_product',1),('2017_02_15_094033_alter_ec_variant_type',1),('2017_02_16_055459_create_tbl_mlm_encashment_settings',1),('2017_02_16_065954_create_tbl_mlm_encashment_process',1),('2017_02_16_081347_alter_tbl_mlm_wallet_log_add_process',1),('2017_02_17_021310_alter_tbl_mlm_slot_wallet_log_add_remarks',1),('2017_02_17_023226_alter_product_put_archived',1),('2017_02_17_031535_alter_tbl_post_add_shop_id',1),('2017_02_17_035932_update_tbl_position_8764',1),('2017_02_17_051828_alter_tbl_mlm_encashment_settings_add_minimum',1),('2017_02_17_082654_update_tbl_employee_81764',1),('2017_02_18_031328_update_tbl_sir_54514',1),('2017_02_18_073622_update_tbl_customer_154514',1),('2017_02_18_081648_create_tbl_temp_customer_invoice_154514',1),('2017_02_18_095200_update_tbl_manual_invoice_23456',1),('2017_02_20_071220_update_23ew24',1),('2017_02_20_074535_alter_product_nullable',1),('2017_02_20_074858_create_tbl_purchase_order',1),('2017_02_20_075232_update_tbl_manual_invoice_23ew24',1),('2017_02_21_014419_create_tbl_vendor',1),('2017_02_21_062920_update_tbl_sir_23454554343',1),('2017_02_21_082050_update_tbl_sir_item_23454554343',1),('2017_02_21_083526_update_tbl_sir_item_2345111',1),('2017_02_23_010752_alter_tbl_ec_product_name_category',1),('2017_02_23_014955_update_tbl_purchase_order_45667',1),('2017_02_23_051717_alter_tbl_mlm_discount_card_log_add_code',1),('2017_02_23_062430_update_tbl_purchase_order_1115667',1),('2017_02_23_085950_alter_tbl_item_invoice_add_discount_cart',1),('2017_02_24_020559_alter_tbl_customer_invoice_paid',1),('2017_02_24_025738_create_tbl_receive_payment',1),('2017_02_24_030659_create_tbl_mlm_slot_wallet_log_refill',2),('2017_02_24_070113_create_tbl_audit_trail_2232323',2),('2017_02_24_073101_update_tbl_audit_trail_2sasa232323',2),('2017_02_24_075621_create_tbl_mlm_slot_wallet_refill_settings',2),('2017_02_24_091308_create_tbl_ec_order',2),('2017_02_25_022212_update_tbl_audit_trail_3er5t6y',2),('2017_02_25_051248_create_tbl_item_bundle',2),('2017_02_25_052822_create_tbl_mlm_slot_wallet_transfer',2),('2017_02_25_074330_update_tbl_purchase_order_3456789',2),('2017_02_25_075216_update_tbl_ec_order_item',2),('2017_02_25_084603_update_tbl_ec_order_payment_methd',2),('2017_02_27_035221_create_tbl_credit_memo_3456789',2),('2017_02_27_064153_update_tbl_ec_order_order_status',2),('2017_02_27_074302_update_tbl_credit_memo_line_3456789',2),('2017_02_28_033352_update_tbl_collection_2345',2),('2017_02_28_093317_create_tbl_user_warehouse_access',2),('2017_03_02_012655_update_tbl_membership_package',2),('2017_03_02_015756_create_tbl_manufacturer_3456',2),('2017_03_02_034419_upadate_tbl_manufacturer_45678',2),('2017_03_02_081719_update_tbl_item_1356345',2),('2017_03_03_022105_alter_tbl_chart_account_type_normal_balance',2),('2017_03_03_024112_alter_tbl_chart_account_status',2),('2017_03_03_024216_alter_tbl_mlm_discount_card_log',2),('2017_03_03_024757_update_tbl_truck_45678',2),('2017_03_03_063259_create_tbl_email_content_34596',2),('2017_03_03_070810_create_tbl_online_payment',2),('2017_03_03_071113_update_tbl_email_content_45678',2),('2017_03_03_071634_alter_tbl_membership_code_invoice_add_name',2),('2017_03_03_091104_create_tbl_membership_code_item_has',2),('2017_03_04_051316_create_tbl_mlm_gc',2),('2017_03_04_051851_create_tbl_email_template_45678',2),('2017_03_04_052007_update_tbl_membership_package_add_gc_amount',2),('2017_03_04_075231_update_tbl_email_template_456798',2),('2017_03_04_083625_alter_tbl_online_pymt_bank_name',2),('2017_03_06_033141_update_tbl_customer_invoice_4564',2),('2017_03_06_101442_alter_tbl_online_pymnt_bank',2),('2017_03_07_040058_alter_tbl_mlm_slot_add_card_printed',2),('2017_03_07_063516_alter_tbl_mlm_slot_add_default_slot',2),('2017_03_07_070021_alter_tbl_mlm_slot_add_default_card_issued',2),('2017_03_07_073225_alter_tbl_receive_payment_shop',2),('2017_03_08_075053_create_tbl_payroll_company',2),('2017_03_08_075629_create_tbl_payroll_rdo',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rel_post_category`
--

DROP TABLE IF EXISTS `rel_post_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_post_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `post_category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rel_post_category_post_id_foreign` (`post_id`),
  KEY `rel_post_category_post_category_id_foreign` (`post_category_id`),
  CONSTRAINT `rel_post_category_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `tbl_post_category` (`post_category_id`) ON DELETE CASCADE,
  CONSTRAINT `rel_post_category_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `tbl_post` (`post_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rel_post_category`
--

LOCK TABLES `rel_post_category` WRITE;
/*!40000 ALTER TABLE `rel_post_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `rel_post_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_about_us`
--

DROP TABLE IF EXISTS `tbl_about_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_about_us` (
  `about_us_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`about_us_id`),
  KEY `tbl_about_us_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_about_us_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_about_us`
--

LOCK TABLES `tbl_about_us` WRITE;
/*!40000 ALTER TABLE `tbl_about_us` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_about_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_audit_trail`
--

DROP TABLE IF EXISTS `tbl_audit_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_audit_trail` (
  `audit_trail_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `old_data` text COLLATE utf8_unicode_ci,
  `new_data` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source_id` int(11) NOT NULL,
  `audit_shop_id` int(11) NOT NULL,
  PRIMARY KEY (`audit_trail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_audit_trail`
--

LOCK TABLES `tbl_audit_trail` WRITE;
/*!40000 ALTER TABLE `tbl_audit_trail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_audit_trail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cart`
--

DROP TABLE IF EXISTS `tbl_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cart` (
  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `unique_id_per_pc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Not Processed',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cart`
--

LOCK TABLES `tbl_cart` WRITE;
/*!40000 ALTER TABLE `tbl_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_category` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_parent_id` int(11) NOT NULL,
  `type_sub_level` tinyint(4) NOT NULL,
  `type_shop` int(10) unsigned NOT NULL,
  `type_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inventory',
  `type_date_created` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`type_id`),
  KEY `tbl_product_type_type_shop_foreign` (`type_shop`),
  CONSTRAINT `tbl_product_type_type_shop_foreign` FOREIGN KEY (`type_shop`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_category`
--

LOCK TABLES `tbl_category` WRITE;
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_chart_account_type`
--

DROP TABLE IF EXISTS `tbl_chart_account_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_chart_account_type` (
  `chart_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chart_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chart_type_description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `has_open_balance` tinyint(4) NOT NULL,
  `chart_type_category` tinyint(4) NOT NULL,
  `normal_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`chart_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_chart_account_type`
--

LOCK TABLES `tbl_chart_account_type` WRITE;
/*!40000 ALTER TABLE `tbl_chart_account_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_chart_account_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_chart_of_account`
--

DROP TABLE IF EXISTS `tbl_chart_of_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_chart_of_account` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_shop_id` int(10) unsigned NOT NULL,
  `account_type_id` int(10) unsigned NOT NULL,
  `account_number` int(11) NOT NULL,
  `account_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_parent_id` int(11) DEFAULT NULL,
  `account_sublevel` int(11) NOT NULL,
  `account_balance` double NOT NULL,
  `account_open_balance` double NOT NULL,
  `account_open_balance_date` date NOT NULL,
  `is_tax_account` tinyint(4) NOT NULL,
  `account_tax_code_id` int(11) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `account_timecreated` datetime NOT NULL,
  `account_protected` tinyint(4) NOT NULL COMMENT 'cannot be delete',
  PRIMARY KEY (`account_id`),
  KEY `tbl_chart_of_account_account_shop_id_foreign` (`account_shop_id`),
  KEY `tbl_chart_of_account_account_type_id_foreign` (`account_type_id`),
  CONSTRAINT `tbl_chart_of_account_account_shop_id_foreign` FOREIGN KEY (`account_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_chart_of_account_account_type_id_foreign` FOREIGN KEY (`account_type_id`) REFERENCES `tbl_chart_account_type` (`chart_type_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_chart_of_account`
--

LOCK TABLES `tbl_chart_of_account` WRITE;
/*!40000 ALTER TABLE `tbl_chart_of_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_chart_of_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_collection`
--

DROP TABLE IF EXISTS `tbl_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_collection` (
  `collection_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `collection_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collection_description` text COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  `collection_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`collection_id`),
  KEY `tbl_collection_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_collection_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_collection`
--

LOCK TABLES `tbl_collection` WRITE;
/*!40000 ALTER TABLE `tbl_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_collection_item`
--

DROP TABLE IF EXISTS `tbl_collection_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_collection_item` (
  `collection_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collection_id` int(10) unsigned NOT NULL,
  `ec_product_id` int(10) unsigned NOT NULL,
  `hide` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`collection_item_id`),
  KEY `tbl_collection_item_collection_id_foreign` (`collection_id`),
  KEY `tbl_collection_item_variant_id_foreign` (`ec_product_id`),
  CONSTRAINT `tbl_collection_item_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `tbl_collection` (`collection_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_collection_item`
--

LOCK TABLES `tbl_collection_item` WRITE;
/*!40000 ALTER TABLE `tbl_collection_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_collection_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contact`
--

DROP TABLE IF EXISTS `tbl_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contact` (
  `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `category` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `primary` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `tbl_contact_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_contact_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contact`
--

LOCK TABLES `tbl_contact` WRITE;
/*!40000 ALTER TABLE `tbl_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_content`
--

DROP TABLE IF EXISTS `tbl_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_content` (
  `content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`content_id`),
  KEY `tbl_content_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_content_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_content`
--

LOCK TABLES `tbl_content` WRITE;
/*!40000 ALTER TABLE `tbl_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_country`
--

DROP TABLE IF EXISTS `tbl_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_country` (
  `country_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `tbl_country_country_code_unique` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=493 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_country`
--

LOCK TABLES `tbl_country` WRITE;
/*!40000 ALTER TABLE `tbl_country` DISABLE KEYS */;
INSERT INTO `tbl_country` VALUES (247,'AF','Afghanistan'),(248,'AL','Albania'),(249,'DZ','Algeria'),(250,'DS','American Samoa'),(251,'AD','Andorra'),(252,'AO','Angola'),(253,'AI','Anguilla'),(254,'AQ','Antarctica'),(255,'AG','Antigua and Barbuda'),(256,'AR','Argentina'),(257,'AM','Armenia'),(258,'AW','Aruba'),(259,'AU','Australia'),(260,'AT','Austria'),(261,'AZ','Azerbaijan'),(262,'BS','Bahamas'),(263,'BH','Bahrain'),(264,'BD','Bangladesh'),(265,'BB','Barbados'),(266,'BY','Belarus'),(267,'BE','Belgium'),(268,'BZ','Belize'),(269,'BJ','Benin'),(270,'BM','Bermuda'),(271,'BT','Bhutan'),(272,'BO','Bolivia'),(273,'BA','Bosnia and Herzegovina'),(274,'BW','Botswana'),(275,'BV','Bouvet Island'),(276,'BR','Brazil'),(277,'IO','British Indian Ocean Territory'),(278,'BN','Brunei Darussalam'),(279,'BG','Bulgaria'),(280,'BF','Burkina Faso'),(281,'BI','Burundi'),(282,'KH','Cambodia'),(283,'CM','Cameroon'),(284,'CA','Canada'),(285,'CV','Cape Verde'),(286,'KY','Cayman Islands'),(287,'CF','Central African Republic'),(288,'TD','Chad'),(289,'CL','Chile'),(290,'CN','China'),(291,'CX','Christmas Island'),(292,'CC','Cocos (Keeling) Islands'),(293,'CO','Colombia'),(294,'KM','Comoros'),(295,'CG','Congo'),(296,'CK','Cook Islands'),(297,'CR','Costa Rica'),(298,'HR','Croatia (Hrvatska)'),(299,'CU','Cuba'),(300,'CY','Cyprus'),(301,'CZ','Czech Republic'),(302,'DK','Denmark'),(303,'DJ','Djibouti'),(304,'DM','Dominica'),(305,'DO','Dominican Republic'),(306,'TP','East Timor'),(307,'EC','Ecuador'),(308,'EG','Egypt'),(309,'SV','El Salvador'),(310,'GQ','Equatorial Guinea'),(311,'ER','Eritrea'),(312,'EE','Estonia'),(313,'ET','Ethiopia'),(314,'FK','Falkland Islands (Malvinas)'),(315,'FO','Faroe Islands'),(316,'FJ','Fiji'),(317,'FI','Finland'),(318,'FR','France'),(319,'FX','France, Metropolitan'),(320,'GF','French Guiana'),(321,'PF','French Polynesia'),(322,'TF','French Southern Territories'),(323,'GA','Gabon'),(324,'GM','Gambia'),(325,'GE','Georgia'),(326,'DE','Germany'),(327,'GH','Ghana'),(328,'GI','Gibraltar'),(329,'GK','Guernsey'),(330,'GR','Greece'),(331,'GL','Greenland'),(332,'GD','Grenada'),(333,'GP','Guadeloupe'),(334,'GU','Guam'),(335,'GT','Guatemala'),(336,'GN','Guinea'),(337,'GW','Guinea-Bissau'),(338,'GY','Guyana'),(339,'HT','Haiti'),(340,'HM','Heard and Mc Donald Islands'),(341,'HN','Honduras'),(342,'HK','Hong Kong'),(343,'HU','Hungary'),(344,'IS','Iceland'),(345,'IN','India'),(346,'IM','Isle of Man'),(347,'ID','Indonesia'),(348,'IR','Iran (Islamic Republic of)'),(349,'IQ','Iraq'),(350,'IE','Ireland'),(351,'IL','Israel'),(352,'IT','Italy'),(353,'CI','Ivory Coast'),(354,'JE','Jersey'),(355,'JM','Jamaica'),(356,'JP','Japan'),(357,'JO','Jordan'),(358,'KZ','Kazakhstan'),(359,'KE','Kenya'),(360,'KI','Kiribati'),(361,'KP','Korea, Democratic People\'s Republic of'),(362,'KR','Korea, Republic of'),(363,'XK','Kosovo'),(364,'KW','Kuwait'),(365,'KG','Kyrgyzstan'),(366,'LA','Lao People\'s Democratic Republic'),(367,'LV','Latvia'),(368,'LB','Lebanon'),(369,'LS','Lesotho'),(370,'LR','Liberia'),(371,'LY','Libyan Arab Jamahiriya'),(372,'LI','Liechtenstein'),(373,'LT','Lithuania'),(374,'LU','Luxembourg'),(375,'MO','Macau'),(376,'MK','Macedonia'),(377,'MG','Madagascar'),(378,'MW','Malawi'),(379,'MY','Malaysia'),(380,'MV','Maldives'),(381,'ML','Mali'),(382,'MT','Malta'),(383,'MH','Marshall Islands'),(384,'MQ','Martinique'),(385,'MR','Mauritania'),(386,'MU','Mauritius'),(387,'TY','Mayotte'),(388,'MX','Mexico'),(389,'FM','Micronesia, Federated States of'),(390,'MD','Moldova, Republic of'),(391,'MC','Monaco'),(392,'MN','Mongolia'),(393,'ME','Montenegro'),(394,'MS','Montserrat'),(395,'MA','Morocco'),(396,'MZ','Mozambique'),(397,'MM','Myanmar'),(398,'NA','Namibia'),(399,'NR','Nauru'),(400,'NP','Nepal'),(401,'NL','Netherlands'),(402,'AN','Netherlands Antilles'),(403,'NC','New Caledonia'),(404,'NZ','New Zealand'),(405,'NI','Nicaragua'),(406,'NE','Niger'),(407,'NG','Nigeria'),(408,'NU','Niue'),(409,'NF','Norfolk Island'),(410,'MP','Northern Mariana Islands'),(411,'NO','Norway'),(412,'OM','Oman'),(413,'PK','Pakistan'),(414,'PW','Palau'),(415,'PS','Palestine'),(416,'PA','Panama'),(417,'PG','Papua New Guinea'),(418,'PY','Paraguay'),(419,'PE','Peru'),(420,'PH','Philippines'),(421,'PN','Pitcairn'),(422,'PL','Poland'),(423,'PT','Portugal'),(424,'PR','Puerto Rico'),(425,'QA','Qatar'),(426,'RE','Reunion'),(427,'RO','Romania'),(428,'RU','Russian Federation'),(429,'RW','Rwanda'),(430,'KN','Saint Kitts and Nevis'),(431,'LC','Saint Lucia'),(432,'VC','Saint Vincent and the Grenadines'),(433,'WS','Samoa'),(434,'SM','San Marino'),(435,'ST','Sao Tome and Principe'),(436,'SA','Saudi Arabia'),(437,'SN','Senegal'),(438,'RS','Serbia'),(439,'SC','Seychelles'),(440,'SL','Sierra Leone'),(441,'SG','Singapore'),(442,'SK','Slovakia'),(443,'SI','Slovenia'),(444,'SB','Solomon Islands'),(445,'SO','Somalia'),(446,'ZA','South Africa'),(447,'GS','South Georgia South Sandwich Islands'),(448,'ES','Spain'),(449,'LK','Sri Lanka'),(450,'SH','St. Helena'),(451,'PM','St. Pierre and Miquelon'),(452,'SD','Sudan'),(453,'SR','Suriname'),(454,'SJ','Svalbard and Jan Mayen Islands'),(455,'SZ','Swaziland'),(456,'SE','Sweden'),(457,'CH','Switzerland'),(458,'SY','Syrian Arab Republic'),(459,'TW','Taiwan'),(460,'TJ','Tajikistan'),(461,'TZ','Tanzania, United Republic of'),(462,'TH','Thailand'),(463,'TG','Togo'),(464,'TK','Tokelau'),(465,'TO','Tonga'),(466,'TT','Trinidad and Tobago'),(467,'TN','Tunisia'),(468,'TR','Turkey'),(469,'TM','Turkmenistan'),(470,'TC','Turks and Caicos Islands'),(471,'TV','Tuvalu'),(472,'UG','Uganda'),(473,'UA','Ukraine'),(474,'AE','United Arab Emirates'),(475,'GB','United Kingdom'),(476,'US','United States'),(477,'UM','United States minor outlying islands'),(478,'UY','Uruguay'),(479,'UZ','Uzbekistan'),(480,'VU','Vanuatu'),(481,'VA','Vatican City State'),(482,'VE','Venezuela'),(483,'VN','Vietnam'),(484,'VG','Virgin Islands (British)'),(485,'VI','Virgin Islands (U.S.)'),(486,'WF','Wallis and Futuna Islands'),(487,'EH','Western Sahara'),(488,'YE','Yemen'),(489,'YU','Yugoslavia'),(490,'ZR','Zaire'),(491,'ZM','Zambia'),(492,'ZW','Zimbabwe');
/*!40000 ALTER TABLE `tbl_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_coupon_code`
--

DROP TABLE IF EXISTS `tbl_coupon_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_coupon_code` (
  `coupon_code_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_per_coupon` int(11) NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coupon_code_amount` double NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `used` tinyint(4) NOT NULL,
  `blocked` tinyint(4) NOT NULL,
  `coupon_discounted` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fixed',
  PRIMARY KEY (`coupon_code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_coupon_code`
--

LOCK TABLES `tbl_coupon_code` WRITE;
/*!40000 ALTER TABLE `tbl_coupon_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_coupon_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_credit_memo`
--

DROP TABLE IF EXISTS `tbl_credit_memo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_credit_memo` (
  `cm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cm_customer_id` int(11) NOT NULL,
  `cm_ar_acccount` int(11) NOT NULL,
  `cm_customer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cm_date` date NOT NULL,
  `cm_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cm_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cm_amount` double NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`cm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_credit_memo`
--

LOCK TABLES `tbl_credit_memo` WRITE;
/*!40000 ALTER TABLE `tbl_credit_memo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_credit_memo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_credit_memo_line`
--

DROP TABLE IF EXISTS `tbl_credit_memo_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_credit_memo_line` (
  `cmline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cmline_cm_id` int(10) unsigned NOT NULL,
  `cmline_service_date` datetime NOT NULL,
  `cmline_um` int(11) NOT NULL,
  `cmline_item_id` int(11) NOT NULL,
  `cmline_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cmline_qty` int(11) NOT NULL,
  `cmline_rate` double NOT NULL,
  `cmline_amount` double NOT NULL,
  PRIMARY KEY (`cmline_id`),
  KEY `tbl_credit_memo_line_cmline_cm_id_foreign` (`cmline_cm_id`),
  CONSTRAINT `tbl_credit_memo_line_cmline_cm_id_foreign` FOREIGN KEY (`cmline_cm_id`) REFERENCES `tbl_credit_memo` (`cm_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_credit_memo_line`
--

LOCK TABLES `tbl_credit_memo_line` WRITE;
/*!40000 ALTER TABLE `tbl_credit_memo_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_credit_memo_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `country_id` int(11) NOT NULL,
  `title_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suffix_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_day` date NOT NULL DEFAULT '0000-00-00',
  `profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IsWalkin` tinyint(4) NOT NULL,
  `created_date` date DEFAULT NULL,
  `archived` tinyint(4) NOT NULL,
  `ismlm` int(11) NOT NULL DEFAULT '0',
  `mlm_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tin_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`customer_id`),
  KEY `tbl_customer_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_customer_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer`
--

LOCK TABLES `tbl_customer` WRITE;
/*!40000 ALTER TABLE `tbl_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_address`
--

DROP TABLE IF EXISTS `tbl_customer_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_address` (
  `customer_address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `customer_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_zipcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_street` text COLLATE utf8_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`customer_address_id`),
  KEY `tbl_customer_address_customer_id_foreign` (`customer_id`),
  KEY `tbl_customer_address_country_id_foreign` (`country_id`),
  CONSTRAINT `tbl_customer_address_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `tbl_country` (`country_id`),
  CONSTRAINT `tbl_customer_address_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_address`
--

LOCK TABLES `tbl_customer_address` WRITE;
/*!40000 ALTER TABLE `tbl_customer_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_attachment`
--

DROP TABLE IF EXISTS `tbl_customer_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_attachment` (
  `customer_attachment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `customer_attachment_path` text COLLATE utf8_unicode_ci NOT NULL,
  `customer_attachment_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_attachment_extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`customer_attachment_id`),
  KEY `tbl_customer_attachment_customer_id_foreign` (`customer_id`),
  CONSTRAINT `tbl_customer_attachment_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_attachment`
--

LOCK TABLES `tbl_customer_attachment` WRITE;
/*!40000 ALTER TABLE `tbl_customer_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_invoice`
--

DROP TABLE IF EXISTS `tbl_customer_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_invoice` (
  `inv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `new_inv_id` int(11) NOT NULL,
  `inv_shop_id` int(11) NOT NULL,
  `inv_customer_id` int(11) NOT NULL,
  `inv_customer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_customer_billing_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_terms_id` tinyint(4) NOT NULL,
  `inv_date` date NOT NULL,
  `inv_due_date` date NOT NULL,
  `inv_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_discount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_discount_value` int(11) NOT NULL,
  `ewt` double NOT NULL,
  `taxable` tinyint(4) NOT NULL,
  `inv_subtotal_price` double NOT NULL,
  `inv_overall_price` double NOT NULL,
  `inv_payment_applied` tinyint(4) NOT NULL,
  `inv_is_paid` tinyint(4) NOT NULL,
  `inv_custom_field_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_invoice`
--

LOCK TABLES `tbl_customer_invoice` WRITE;
/*!40000 ALTER TABLE `tbl_customer_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_invoice_line`
--

DROP TABLE IF EXISTS `tbl_customer_invoice_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_invoice_line` (
  `invline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invline_inv_id` int(10) unsigned NOT NULL,
  `invline_service_date` datetime NOT NULL,
  `invline_item_id` int(11) NOT NULL,
  `invline_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invline_um` int(11) NOT NULL,
  `invline_qty` int(11) NOT NULL,
  `invline_rate` double NOT NULL,
  `taxable` tinyint(4) NOT NULL,
  `invline_discount` double NOT NULL,
  `invline_discount_remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invline_amount` double NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`invline_id`),
  KEY `tbl_customer_invoice_line_invline_inv_id_foreign` (`invline_inv_id`),
  CONSTRAINT `tbl_customer_invoice_line_invline_inv_id_foreign` FOREIGN KEY (`invline_inv_id`) REFERENCES `tbl_customer_invoice` (`inv_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_invoice_line`
--

LOCK TABLES `tbl_customer_invoice_line` WRITE;
/*!40000 ALTER TABLE `tbl_customer_invoice_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_invoice_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_other_info`
--

DROP TABLE IF EXISTS `tbl_customer_other_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_other_info` (
  `customer_other_info_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_other_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customer_print_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `IsSubCustomer` tinyint(4) NOT NULL,
  `customer_parent` int(11) NOT NULL DEFAULT '0',
  `customer_billing` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_tax_resale_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_payment_method` int(11) NOT NULL DEFAULT '0',
  `customer_delivery_method` int(11) NOT NULL DEFAULT '0',
  `customer_terms` int(11) NOT NULL DEFAULT '0',
  `customer_opening_balance` double(18,2) NOT NULL DEFAULT '0.00',
  `customer_balance_date` date NOT NULL DEFAULT '0000-00-00',
  `customer_notes` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_other_info_id`),
  KEY `tbl_customer_other_info_customer_id_foreign` (`customer_id`),
  CONSTRAINT `tbl_customer_other_info_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_other_info`
--

LOCK TABLES `tbl_customer_other_info` WRITE;
/*!40000 ALTER TABLE `tbl_customer_other_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_other_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_search`
--

DROP TABLE IF EXISTS `tbl_customer_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search` (`body`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_search`
--

LOCK TABLES `tbl_customer_search` WRITE;
/*!40000 ALTER TABLE `tbl_customer_search` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer_search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_default_chart_account`
--

DROP TABLE IF EXISTS `tbl_default_chart_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_default_chart_account` (
  `default_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `default_type_id` int(11) NOT NULL,
  `default_number` int(11) NOT NULL,
  `default_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_parent_id` int(11) NOT NULL,
  `default_sublevel` int(11) NOT NULL,
  `default_balance` double NOT NULL,
  `default_open_balance` double NOT NULL,
  `default_open_balance_date` date NOT NULL,
  `is_tax_account` tinyint(4) NOT NULL,
  `account_tax_code_id` int(11) NOT NULL,
  `default_for_code` tinyint(4) NOT NULL,
  `account_protected` tinyint(4) NOT NULL COMMENT 'cannot be delete',
  PRIMARY KEY (`default_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_default_chart_account`
--

LOCK TABLES `tbl_default_chart_account` WRITE;
/*!40000 ALTER TABLE `tbl_default_chart_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_default_chart_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_delivery_method`
--

DROP TABLE IF EXISTS `tbl_delivery_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_delivery_method` (
  `delivery_method_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `delivery_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`delivery_method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_delivery_method`
--

LOCK TABLES `tbl_delivery_method` WRITE;
/*!40000 ALTER TABLE `tbl_delivery_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_delivery_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ec_order`
--

DROP TABLE IF EXISTS `tbl_ec_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ec_order` (
  `ec_order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `customer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `invoice_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `statement_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` double NOT NULL,
  `ewt` double NOT NULL,
  `discount_amount_from_product` double NOT NULL,
  `discount_amount` double NOT NULL,
  `discount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_coupon_amount` double NOT NULL,
  `discount_coupon_type` double NOT NULL,
  `total` double NOT NULL,
  `tax` tinyint(4) NOT NULL,
  `coupon_id` int(10) unsigned DEFAULT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `payment_method_id` int(10) unsigned NOT NULL,
  `order_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Unpaid',
  PRIMARY KEY (`ec_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ec_order`
--

LOCK TABLES `tbl_ec_order` WRITE;
/*!40000 ALTER TABLE `tbl_ec_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ec_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ec_order_item`
--

DROP TABLE IF EXISTS `tbl_ec_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ec_order_item` (
  `ec_order_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` double NOT NULL,
  `discount_amount` double NOT NULL,
  `discount_type` double NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_date` datetime NOT NULL,
  `tax` tinyint(4) NOT NULL,
  `ec_order_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ec_order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ec_order_item`
--

LOCK TABLES `tbl_ec_order_item` WRITE;
/*!40000 ALTER TABLE `tbl_ec_order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ec_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ec_product`
--

DROP TABLE IF EXISTS `tbl_ec_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ec_product` (
  `eprod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eprod_shop_id` int(11) NOT NULL,
  `eprod_category_id` int(10) unsigned DEFAULT NULL,
  `eprod_is_single` int(11) NOT NULL,
  `eprod_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`eprod_id`),
  KEY `tbl_ec_product_eprod_category_id_foreign` (`eprod_category_id`),
  CONSTRAINT `tbl_ec_product_eprod_category_id_foreign` FOREIGN KEY (`eprod_category_id`) REFERENCES `tbl_category` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ec_product`
--

LOCK TABLES `tbl_ec_product` WRITE;
/*!40000 ALTER TABLE `tbl_ec_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ec_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ec_variant`
--

DROP TABLE IF EXISTS `tbl_ec_variant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ec_variant` (
  `evariant_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `evariant_prod_id` int(10) unsigned NOT NULL,
  `evariant_item_id` int(11) NOT NULL,
  `evariant_item_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `evariant_description` longtext COLLATE utf8_unicode_ci,
  `evariant_price` double NOT NULL,
  `date_created` datetime NOT NULL,
  `date_visible` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`evariant_id`),
  KEY `tbl_ec_variant_evariant_prod_id_foreign` (`evariant_prod_id`),
  CONSTRAINT `tbl_ec_variant_evariant_prod_id_foreign` FOREIGN KEY (`evariant_prod_id`) REFERENCES `tbl_ec_product` (`eprod_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ec_variant`
--

LOCK TABLES `tbl_ec_variant` WRITE;
/*!40000 ALTER TABLE `tbl_ec_variant` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ec_variant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ec_variant_image`
--

DROP TABLE IF EXISTS `tbl_ec_variant_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ec_variant_image` (
  `eimg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eimg_variant_id` int(11) NOT NULL,
  `eimg_image_id` int(11) NOT NULL,
  PRIMARY KEY (`eimg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ec_variant_image`
--

LOCK TABLES `tbl_ec_variant_image` WRITE;
/*!40000 ALTER TABLE `tbl_ec_variant_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ec_variant_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ecommerce_banking`
--

DROP TABLE IF EXISTS `tbl_ecommerce_banking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ecommerce_banking` (
  `ecommerce_banking_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `ecommerce_banking_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ecommerce_banking_account_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ecommerce_banking_account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`ecommerce_banking_id`),
  KEY `tbl_ecommerce_banking_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_ecommerce_banking_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ecommerce_banking`
--

LOCK TABLES `tbl_ecommerce_banking` WRITE;
/*!40000 ALTER TABLE `tbl_ecommerce_banking` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ecommerce_banking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ecommerce_paypal`
--

DROP TABLE IF EXISTS `tbl_ecommerce_paypal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ecommerce_paypal` (
  `ecommerce_paypal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `ecommerce_setting_id` int(11) NOT NULL,
  `paypal_clientid` text COLLATE utf8_unicode_ci NOT NULL,
  `paypal_secret` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ecommerce_paypal_id`),
  KEY `tbl_ecommerce_paypal_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_ecommerce_paypal_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ecommerce_paypal`
--

LOCK TABLES `tbl_ecommerce_paypal` WRITE;
/*!40000 ALTER TABLE `tbl_ecommerce_paypal` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ecommerce_paypal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ecommerce_remittance`
--

DROP TABLE IF EXISTS `tbl_ecommerce_remittance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ecommerce_remittance` (
  `ecommerce_remittance_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `ecommerce_remittance_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ecommerce_remittance_full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ecommerce_remittance_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ecommerce_remittance_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`ecommerce_remittance_id`),
  KEY `tbl_ecommerce_remittance_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_ecommerce_remittance_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ecommerce_remittance`
--

LOCK TABLES `tbl_ecommerce_remittance` WRITE;
/*!40000 ALTER TABLE `tbl_ecommerce_remittance` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ecommerce_remittance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ecommerce_setting`
--

DROP TABLE IF EXISTS `tbl_ecommerce_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ecommerce_setting` (
  `ecommerce_setting_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `ecommerce_setting_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ecommerce_setting_enable` tinyint(4) NOT NULL,
  `ecommerce_setting_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ecommerce_setting_date` datetime NOT NULL,
  PRIMARY KEY (`ecommerce_setting_id`),
  KEY `tbl_ecommerce_setting_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_ecommerce_setting_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ecommerce_setting`
--

LOCK TABLES `tbl_ecommerce_setting` WRITE;
/*!40000 ALTER TABLE `tbl_ecommerce_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ecommerce_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_email_content`
--

DROP TABLE IF EXISTS `tbl_email_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_email_content` (
  `email_content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_content_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_content` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `email_content_subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`email_content_id`),
  KEY `tbl_email_content_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_email_content_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_email_content`
--

LOCK TABLES `tbl_email_content` WRITE;
/*!40000 ALTER TABLE `tbl_email_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_email_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_email_template`
--

DROP TABLE IF EXISTS `tbl_email_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_email_template` (
  `email_template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `header_image` text COLLATE utf8_unicode_ci NOT NULL,
  `header_txt` text COLLATE utf8_unicode_ci NOT NULL,
  `header_image_alignment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `header_background_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `footer_txt` text COLLATE utf8_unicode_ci NOT NULL,
  `footer_image_alignment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `footer_background_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `footer_text_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `header_text_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`email_template_id`),
  KEY `tbl_email_template_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_email_template_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_email_template`
--

LOCK TABLES `tbl_email_template` WRITE;
/*!40000 ALTER TABLE `tbl_email_template` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_email_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_employee`
--

DROP TABLE IF EXISTS `tbl_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_employee` (
  `employee_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `warehouse_id` int(10) unsigned NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `b_day` date NOT NULL,
  `position_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`employee_id`),
  KEY `tbl_employee_warehouse_id_foreign` (`warehouse_id`),
  KEY `tbl_employee_shop_id_foreign` (`shop_id`),
  KEY `tbl_employee_position_id_foreign` (`position_id`),
  CONSTRAINT `tbl_employee_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `tbl_position` (`position_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_employee_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_employee`
--

LOCK TABLES `tbl_employee` WRITE;
/*!40000 ALTER TABLE `tbl_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_image`
--

DROP TABLE IF EXISTS `tbl_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_image` (
  `image_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_shop` int(10) unsigned NOT NULL,
  `image_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'product',
  `image_reason_id` int(11) NOT NULL,
  `image_date_created` datetime NOT NULL,
  PRIMARY KEY (`image_id`),
  UNIQUE KEY `tbl_image_image_path_unique` (`image_path`),
  UNIQUE KEY `tbl_image_image_key_unique` (`image_key`),
  KEY `tbl_image_image_shop_foreign` (`image_shop`),
  CONSTRAINT `tbl_image_image_shop_foreign` FOREIGN KEY (`image_shop`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_image`
--

LOCK TABLES `tbl_image` WRITE;
/*!40000 ALTER TABLE `tbl_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_inventory_serial_number`
--

DROP TABLE IF EXISTS `tbl_inventory_serial_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_inventory_serial_number` (
  `serial_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inventory_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `serial_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serial_created` datetime NOT NULL,
  `item_count` int(11) NOT NULL,
  `item_consumed` tinyint(4) NOT NULL,
  PRIMARY KEY (`serial_id`),
  KEY `tbl_inventory_serial_number_inventory_id_foreign` (`inventory_id`),
  KEY `tbl_inventory_serial_number_item_id_foreign` (`item_id`),
  CONSTRAINT `tbl_inventory_serial_number_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `tbl_warehouse_inventory` (`inventory_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_inventory_serial_number_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_inventory_serial_number`
--

LOCK TABLES `tbl_inventory_serial_number` WRITE;
/*!40000 ALTER TABLE `tbl_inventory_serial_number` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_inventory_serial_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_inventory_slip`
--

DROP TABLE IF EXISTS `tbl_inventory_slip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_inventory_slip` (
  `inventory_slip_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inventory_slip_id_sibling` int(11) NOT NULL DEFAULT '0',
  `inventory_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `inventory_remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `inventory_slip_date` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `inventory_slip_shop_id` int(11) NOT NULL,
  `inventory_slip_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inventroy_source_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inventory_source_id` int(11) NOT NULL,
  `inventory_source_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inventory_slip_consume_refill` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inventory_slip_consume_cause` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inventory_slip_consumer_id` int(11) NOT NULL,
  PRIMARY KEY (`inventory_slip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_inventory_slip`
--

LOCK TABLES `tbl_inventory_slip` WRITE;
/*!40000 ALTER TABLE `tbl_inventory_slip` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_inventory_slip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item`
--

DROP TABLE IF EXISTS `tbl_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_sales_information` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_purchasing_information` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_reorder_point` int(11) NOT NULL,
  `item_price` double NOT NULL,
  `item_cost` double NOT NULL,
  `item_sale_to_customer` tinyint(4) NOT NULL,
  `item_purchase_from_supplier` tinyint(4) NOT NULL,
  `item_type_id` int(10) unsigned NOT NULL,
  `item_category_id` int(10) unsigned NOT NULL,
  `item_asset_account_id` int(10) unsigned DEFAULT NULL,
  `item_income_account_id` int(10) unsigned DEFAULT NULL,
  `item_expense_account_id` int(10) unsigned DEFAULT NULL,
  `item_date_tracked` datetime DEFAULT NULL,
  `item_date_created` datetime NOT NULL,
  `item_date_archived` datetime DEFAULT NULL,
  `archived` tinyint(4) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `item_barcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `has_serial_number` tinyint(4) NOT NULL DEFAULT '0',
  `item_measurement_id` int(10) unsigned DEFAULT NULL,
  `item_manufacturer_id` int(10) unsigned DEFAULT NULL,
  `packing_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_show_in_mlm` int(11) NOT NULL DEFAULT '0',
  `promo_price` double NOT NULL,
  `start_promo_date` date NOT NULL,
  `end_promo_date` date NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item`
--

LOCK TABLES `tbl_item` WRITE;
/*!40000 ALTER TABLE `tbl_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_bundle`
--

DROP TABLE IF EXISTS `tbl_item_bundle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_item_bundle` (
  `bundle_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bundle_bundle_id` int(10) unsigned NOT NULL,
  `bundle_item_id` int(10) unsigned NOT NULL,
  `bundle_um_id` int(10) unsigned NOT NULL,
  `bundle_qty` double(8,2) NOT NULL,
  `bundle_display_components` double(8,2) NOT NULL,
  PRIMARY KEY (`bundle_id`),
  KEY `tbl_item_bundle_bundle_bundle_id_foreign` (`bundle_bundle_id`),
  KEY `tbl_item_bundle_bundle_item_id_foreign` (`bundle_item_id`),
  CONSTRAINT `tbl_item_bundle_bundle_bundle_id_foreign` FOREIGN KEY (`bundle_bundle_id`) REFERENCES `tbl_item` (`item_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_item_bundle_bundle_item_id_foreign` FOREIGN KEY (`bundle_item_id`) REFERENCES `tbl_item` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_bundle`
--

LOCK TABLES `tbl_item_bundle` WRITE;
/*!40000 ALTER TABLE `tbl_item_bundle` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_item_bundle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_code`
--

DROP TABLE IF EXISTS `tbl_item_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_item_code` (
  `item_code_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_activation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `slot_id` int(10) unsigned DEFAULT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_code_invoice_id` int(10) unsigned NOT NULL,
  `used` tinyint(4) NOT NULL,
  `blocked` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `item_code_pin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_code_price` double NOT NULL,
  `date_used` datetime NOT NULL,
  `item_code_price_total` double NOT NULL,
  `used_on_slot` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`item_code_id`),
  KEY `tbl_item_code_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_item_code_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_code`
--

LOCK TABLES `tbl_item_code` WRITE;
/*!40000 ALTER TABLE `tbl_item_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_item_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_code_invoice`
--

DROP TABLE IF EXISTS `tbl_item_code_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_item_code_invoice` (
  `item_code_invoice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_code_invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_code_customer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_code_paid` tinyint(4) NOT NULL,
  `item_code_product_issued` tinyint(4) NOT NULL,
  `item_code_message_on_invoice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_code_statement_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `slot_id` int(10) unsigned DEFAULT NULL,
  `item_code_date_created` datetime NOT NULL,
  `item_subtotal` double NOT NULL,
  `item_discount` double NOT NULL,
  `item_total` double NOT NULL,
  `item_discount_percentage` double NOT NULL,
  `discount_card_log_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`item_code_invoice_id`),
  KEY `tbl_item_code_invoice_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_item_code_invoice_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_code_invoice`
--

LOCK TABLES `tbl_item_code_invoice` WRITE;
/*!40000 ALTER TABLE `tbl_item_code_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_item_code_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_discount`
--

DROP TABLE IF EXISTS `tbl_item_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_item_discount` (
  `item_discount_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `item_discount_value` double NOT NULL,
  `item_discount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fixed',
  `item_discount_remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_discount_date_start` datetime NOT NULL,
  `item_discount_date_end` datetime NOT NULL,
  PRIMARY KEY (`item_discount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_discount`
--

LOCK TABLES `tbl_item_discount` WRITE;
/*!40000 ALTER TABLE `tbl_item_discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_item_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_type`
--

DROP TABLE IF EXISTS `tbl_item_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_item_type` (
  `item_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_type`
--

LOCK TABLES `tbl_item_type` WRITE;
/*!40000 ALTER TABLE `tbl_item_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_item_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_journal_entry`
--

DROP TABLE IF EXISTS `tbl_journal_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_journal_entry` (
  `je_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `je_shop_id` int(10) unsigned NOT NULL,
  `je_reference_module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `je_reference_id` int(11) NOT NULL,
  `je_entry_date` datetime NOT NULL,
  `je_remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`je_id`),
  KEY `tbl_journal_entry_je_shop_id_foreign` (`je_shop_id`),
  CONSTRAINT `tbl_journal_entry_je_shop_id_foreign` FOREIGN KEY (`je_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_journal_entry`
--

LOCK TABLES `tbl_journal_entry` WRITE;
/*!40000 ALTER TABLE `tbl_journal_entry` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_journal_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_journal_entry_line`
--

DROP TABLE IF EXISTS `tbl_journal_entry_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_journal_entry_line` (
  `jline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jline_je_id` int(10) unsigned NOT NULL,
  `jline_name_id` int(11) NOT NULL,
  `jline_item_id` int(10) unsigned NOT NULL,
  `jline_account_id` int(10) unsigned NOT NULL,
  `jline_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jline_amount` double NOT NULL,
  `jline_description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`jline_id`),
  KEY `tbl_journal_entry_line_jline_je_id_foreign` (`jline_je_id`),
  KEY `tbl_journal_entry_line_jline_account_id_foreign` (`jline_account_id`),
  CONSTRAINT `tbl_journal_entry_line_jline_account_id_foreign` FOREIGN KEY (`jline_account_id`) REFERENCES `tbl_chart_of_account` (`account_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_journal_entry_line_jline_je_id_foreign` FOREIGN KEY (`jline_je_id`) REFERENCES `tbl_journal_entry` (`je_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_journal_entry_line`
--

LOCK TABLES `tbl_journal_entry_line` WRITE;
/*!40000 ALTER TABLE `tbl_journal_entry_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_journal_entry_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_location`
--

DROP TABLE IF EXISTS `tbl_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_location` (
  `location_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `location` text COLLATE utf8_unicode_ci NOT NULL,
  `primary` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `tbl_location_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_location_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_location`
--

LOCK TABLES `tbl_location` WRITE;
/*!40000 ALTER TABLE `tbl_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_manual_invoice`
--

DROP TABLE IF EXISTS `tbl_manual_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_manual_invoice` (
  `manual_invoice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sir_id` int(10) unsigned NOT NULL,
  `inv_id` int(10) unsigned NOT NULL,
  `manual_invoice_date` datetime NOT NULL,
  `is_sync` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`manual_invoice_id`),
  KEY `tbl_manual_invoice_sir_id_foreign` (`sir_id`),
  KEY `tbl_manual_invoice_inv_id_foreign` (`inv_id`),
  CONSTRAINT `tbl_manual_invoice_sir_id_foreign` FOREIGN KEY (`sir_id`) REFERENCES `tbl_sir` (`sir_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_manual_invoice`
--

LOCK TABLES `tbl_manual_invoice` WRITE;
/*!40000 ALTER TABLE `tbl_manual_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_manual_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_manufacturer`
--

DROP TABLE IF EXISTS `tbl_manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_manufacturer` (
  `manufacturer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manufacturer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `manufacturer_shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`manufacturer_id`),
  KEY `tbl_manufacturer_manufacturer_shop_id_foreign` (`manufacturer_shop_id`),
  CONSTRAINT `tbl_manufacturer_manufacturer_shop_id_foreign` FOREIGN KEY (`manufacturer_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_manufacturer`
--

LOCK TABLES `tbl_manufacturer` WRITE;
/*!40000 ALTER TABLE `tbl_manufacturer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_manufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_membership`
--

DROP TABLE IF EXISTS `tbl_membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_membership` (
  `membership_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `membership_price` double NOT NULL DEFAULT '0',
  `membership_archive` tinyint(4) NOT NULL,
  `membership_date_created` datetime NOT NULL,
  PRIMARY KEY (`membership_id`),
  KEY `tbl_membership_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_membership_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_membership`
--

LOCK TABLES `tbl_membership` WRITE;
/*!40000 ALTER TABLE `tbl_membership` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_membership_code`
--

DROP TABLE IF EXISTS `tbl_membership_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_membership_code` (
  `membership_code_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_activation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `membership_package_id` int(10) unsigned NOT NULL,
  `membership_code_invoice_id` int(10) unsigned NOT NULL,
  `used` tinyint(4) NOT NULL,
  `blocked` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `membership_code_pin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_price` double NOT NULL,
  `membership_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PS',
  `date_used` datetime NOT NULL,
  `membership_code_price_total` double NOT NULL,
  `slot_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`membership_code_id`),
  KEY `tbl_membership_code_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_membership_code_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_membership_code`
--

LOCK TABLES `tbl_membership_code` WRITE;
/*!40000 ALTER TABLE `tbl_membership_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_membership_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_membership_code_invoice`
--

DROP TABLE IF EXISTS `tbl_membership_code_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_membership_code_invoice` (
  `membership_code_invoice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_code_invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_customer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_paid` tinyint(4) NOT NULL,
  `membership_code_product_issued` tinyint(4) NOT NULL,
  `membership_code_message_on_invoice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_statement_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `membership_code_date_created` datetime NOT NULL,
  `membership_subtotal` double NOT NULL,
  `membership_discount` double NOT NULL,
  `membership_total` double NOT NULL,
  `membership_discount_percentage` double NOT NULL,
  `membership_code_invoice_f_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_invoice_m_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_invoice_l_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`membership_code_invoice_id`),
  KEY `tbl_membership_code_invoice_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_membership_code_invoice_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_membership_code_invoice`
--

LOCK TABLES `tbl_membership_code_invoice` WRITE;
/*!40000 ALTER TABLE `tbl_membership_code_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_membership_code_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_membership_code_item_has`
--

DROP TABLE IF EXISTS `tbl_membership_code_item_has`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_membership_code_item_has` (
  `membership_code_item_has_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_code_invoice_id` int(10) unsigned NOT NULL,
  `membership_code_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `membership_code_item_has_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_item_has_quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_code_item_has_price` double NOT NULL,
  PRIMARY KEY (`membership_code_item_has_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_membership_code_item_has`
--

LOCK TABLES `tbl_membership_code_item_has` WRITE;
/*!40000 ALTER TABLE `tbl_membership_code_item_has` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_membership_code_item_has` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_membership_package`
--

DROP TABLE IF EXISTS `tbl_membership_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_membership_package` (
  `membership_package_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NOT NULL,
  `membership_package_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_package_archive` tinyint(4) NOT NULL,
  `membership_package_created` datetime NOT NULL,
  `membership_package_weight` double NOT NULL,
  `membership_package_weight_unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membership_package_size_w` double NOT NULL,
  `membership_package_size_h` double NOT NULL,
  `membership_package_size_l` double NOT NULL,
  `membership_package_size_unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_bundle_id` int(11) NOT NULL,
  `membership_package_is_gc` int(11) NOT NULL,
  `membership_package_gc_amount` double NOT NULL,
  PRIMARY KEY (`membership_package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_membership_package`
--

LOCK TABLES `tbl_membership_package` WRITE;
/*!40000 ALTER TABLE `tbl_membership_package` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_membership_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_membership_package_has`
--

DROP TABLE IF EXISTS `tbl_membership_package_has`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_membership_package_has` (
  `membership_package_has_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_package_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `membership_package_has_archive` tinyint(4) NOT NULL,
  `membership_package_has_quantity` int(11) NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`membership_package_has_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_membership_package_has`
--

LOCK TABLES `tbl_membership_package_has` WRITE;
/*!40000 ALTER TABLE `tbl_membership_package_has` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_membership_package_has` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_membership_points`
--

DROP TABLE IF EXISTS `tbl_membership_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_membership_points` (
  `membership_points_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NOT NULL,
  `membership_points_binary` text COLLATE utf8_unicode_ci NOT NULL,
  `membership_points_binary_max_pair` text COLLATE utf8_unicode_ci NOT NULL,
  `membership_points_direct` text COLLATE utf8_unicode_ci NOT NULL,
  `membership_points_executive` double NOT NULL DEFAULT '0',
  `membership_points_leadership` double NOT NULL DEFAULT '0',
  `membership_points_direct_not_bonus` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`membership_points_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_membership_points`
--

LOCK TABLES `tbl_membership_points` WRITE;
/*!40000 ALTER TABLE `tbl_membership_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_membership_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_binary_pairing`
--

DROP TABLE IF EXISTS `tbl_mlm_binary_pairing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_binary_pairing` (
  `pairing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pairing_point_left` double NOT NULL,
  `pairing_point_right` double NOT NULL,
  `pairing_bonus` double NOT NULL,
  `membership_id` int(10) unsigned NOT NULL,
  `pairing_archive` int(11) NOT NULL,
  PRIMARY KEY (`pairing_id`),
  KEY `tbl_mlm_binary_pairing_membership_id_foreign` (`membership_id`),
  CONSTRAINT `tbl_mlm_binary_pairing_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `tbl_membership` (`membership_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_binary_pairing`
--

LOCK TABLES `tbl_mlm_binary_pairing` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_binary_pairing` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_binary_pairing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_binary_setttings`
--

DROP TABLE IF EXISTS `tbl_mlm_binary_setttings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_binary_setttings` (
  `binary_setttings` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `binary_settings_gc_enable` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `binary_settings_gc_every_pair` int(11) NOT NULL DEFAULT '0',
  `binary_settings_gc_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Fifth Pair GC',
  `binary_settings_gc_amount` double NOT NULL DEFAULT '0',
  `binary_settings_no_of_cycle` int(11) NOT NULL DEFAULT '1',
  `binary_settings_time_of_cycle` time NOT NULL,
  `binary_settings_strong_leg` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'strong_leg',
  `binary_settings_max_tree_level` int(11) NOT NULL DEFAULT '999',
  `binary_settings_placement` int(11) NOT NULL DEFAULT '0',
  `binary_settings_auto_placement` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'left_to_right',
  PRIMARY KEY (`binary_setttings`),
  KEY `tbl_mlm_binary_setttings_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_mlm_binary_setttings_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_binary_setttings`
--

LOCK TABLES `tbl_mlm_binary_setttings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_binary_setttings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_binary_setttings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_complan_executive_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_complan_executive_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_complan_executive_settings` (
  `executive_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `membership_id` double unsigned NOT NULL,
  `executive_settings_required_points` double NOT NULL,
  `executive_settings_bonus` double NOT NULL,
  PRIMARY KEY (`executive_settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_complan_executive_settings`
--

LOCK TABLES `tbl_mlm_complan_executive_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_complan_executive_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_complan_executive_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_discount_card_log`
--

DROP TABLE IF EXISTS `tbl_mlm_discount_card_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_discount_card_log` (
  `discount_card_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discount_card_log_date_created` datetime NOT NULL,
  `discount_card_log_date_used` datetime DEFAULT NULL,
  `discount_card_slot_sponsor` int(11) NOT NULL,
  `discount_card_customer_sponsor` int(11) NOT NULL,
  `discount_card_membership` int(11) NOT NULL,
  `discount_card_customer_holder` int(11) DEFAULT NULL,
  `discount_card_log_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount_card_log_is_expired` int(11) NOT NULL,
  `discount_card_log_date_expired` datetime DEFAULT NULL,
  PRIMARY KEY (`discount_card_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_discount_card_log`
--

LOCK TABLES `tbl_mlm_discount_card_log` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_discount_card_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_discount_card_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_discount_card_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_discount_card_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_discount_card_settings` (
  `discount_card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discount_card_count_membership` int(11) NOT NULL DEFAULT '0',
  `discount_card_membership` int(11) DEFAULT NULL,
  `discount_card_archive` int(11) NOT NULL DEFAULT '0',
  `membership_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`discount_card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_discount_card_settings`
--

LOCK TABLES `tbl_mlm_discount_card_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_discount_card_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_discount_card_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_encashment_process`
--

DROP TABLE IF EXISTS `tbl_mlm_encashment_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_encashment_process` (
  `encashment_process` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `enchasment_process_from` datetime NOT NULL,
  `enchasment_process_to` datetime NOT NULL,
  `enchasment_process_executed` datetime NOT NULL,
  `enchasment_process_tax` double NOT NULL,
  `enchasment_process_tax_type` int(11) NOT NULL,
  `enchasment_process_p_fee` double NOT NULL,
  `enchasment_process_p_fee_type` int(11) NOT NULL,
  `encashment_process_sum` int(11) NOT NULL,
  `enchasment_process_minimum` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`encashment_process`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_encashment_process`
--

LOCK TABLES `tbl_mlm_encashment_process` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_encashment_process` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_encashment_process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_encashment_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_encashment_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_encashment_settings` (
  `enchasment_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `enchasment_settings_auto` int(11) NOT NULL,
  `enchasment_settings_tax` double NOT NULL,
  `enchasment_settings_tax_type` int(11) NOT NULL,
  `enchasment_settings_p_fee` double NOT NULL,
  `enchasment_settings_p_fee_type` int(11) NOT NULL,
  `enchasment_settings_minimum` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`enchasment_settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_encashment_settings`
--

LOCK TABLES `tbl_mlm_encashment_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_encashment_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_encashment_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_gc`
--

DROP TABLE IF EXISTS `tbl_mlm_gc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_gc` (
  `mlm_gc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mlm_gc_tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mlm_gc_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mlm_gc_amount` double NOT NULL,
  `mlm_gc_member` int(11) NOT NULL,
  `mlm_gc_slot` int(11) NOT NULL,
  `mlm_gc_date` datetime NOT NULL,
  `mlm_gc_used` int(11) NOT NULL DEFAULT '0',
  `mlm_gc_used_date` datetime NOT NULL,
  PRIMARY KEY (`mlm_gc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_gc`
--

LOCK TABLES `tbl_mlm_gc` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_gc` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_gc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_indirect_points_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_indirect_points_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_indirect_points_settings` (
  `indirect_points_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `indirect_points_level` int(11) NOT NULL,
  `indirect_points_value` double NOT NULL DEFAULT '0',
  `membership_id` int(10) unsigned NOT NULL,
  `indirect_points_archive` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`indirect_points_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_indirect_points_settings`
--

LOCK TABLES `tbl_mlm_indirect_points_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_indirect_points_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_indirect_points_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_indirect_setting`
--

DROP TABLE IF EXISTS `tbl_mlm_indirect_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_indirect_setting` (
  `indirect_seting_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `indirect_seting_level` int(10) unsigned NOT NULL,
  `indirect_seting_value` double NOT NULL,
  `indirect_seting_percent` tinyint(4) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `indirect_setting_archive` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`indirect_seting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_indirect_setting`
--

LOCK TABLES `tbl_mlm_indirect_setting` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_indirect_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_indirect_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_item_discount`
--

DROP TABLE IF EXISTS `tbl_mlm_item_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_item_discount` (
  `item_discount_d` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_discount_price` double NOT NULL DEFAULT '0',
  `item_discount_percentage` double NOT NULL DEFAULT '0',
  `membership_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`item_discount_d`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_item_discount`
--

LOCK TABLES `tbl_mlm_item_discount` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_item_discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_item_discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_item_points`
--

DROP TABLE IF EXISTS `tbl_mlm_item_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_item_points` (
  `item_points_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_points_stairstep` double NOT NULL,
  `item_points_unilevel` double NOT NULL,
  `item_points_binary` double NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`item_points_id`),
  KEY `tbl_mlm_item_points_item_id_foreign` (`item_id`),
  CONSTRAINT `tbl_mlm_item_points_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_item_points`
--

LOCK TABLES `tbl_mlm_item_points` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_item_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_item_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_lead`
--

DROP TABLE IF EXISTS `tbl_mlm_lead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_lead` (
  `lead_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lead_join_date` datetime NOT NULL,
  `lead_customer_id_sponsor` int(11) NOT NULL,
  `lead_customer_id_lead` int(11) NOT NULL,
  `lead_slot_id_sponsor` int(11) NOT NULL,
  `lead_sponsor_membership_code` int(11) NOT NULL,
  `lead_slot_id_lead` int(11) NOT NULL,
  `lead_used` int(11) NOT NULL DEFAULT '0',
  `lead_used_date` datetime DEFAULT NULL,
  PRIMARY KEY (`lead_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_lead`
--

LOCK TABLES `tbl_mlm_lead` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_lead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_lead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_leadership_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_leadership_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_leadership_settings` (
  `leadership_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `leadership_settings_start` double NOT NULL,
  `leadership_settings_end` double NOT NULL,
  `leadership_settings_earnings` double NOT NULL,
  `leadership_settings_required_points` double NOT NULL,
  `membership_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`leadership_settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_leadership_settings`
--

LOCK TABLES `tbl_mlm_leadership_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_leadership_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_leadership_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_matching`
--

DROP TABLE IF EXISTS `tbl_mlm_matching`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_matching` (
  `matching_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `matching_settings_start` double NOT NULL,
  `matching_settings_end` double NOT NULL,
  `matching_settings_earnings` double NOT NULL,
  `membership_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`matching_settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_matching`
--

LOCK TABLES `tbl_mlm_matching` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_matching` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_matching` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_matching_log`
--

DROP TABLE IF EXISTS `tbl_mlm_matching_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_matching_log` (
  `matching_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `matching_log_membership_1` int(11) NOT NULL,
  `matching_log_membership_2` int(11) NOT NULL,
  `matching_log_level_1` int(11) NOT NULL,
  `matching_log_level_2` int(11) NOT NULL,
  `matching_log_slot_1` int(11) NOT NULL,
  `matching_log_slot_2` int(11) NOT NULL,
  `matching_log_earner` int(11) NOT NULL,
  `matching_log_earning` int(11) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`matching_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_matching_log`
--

LOCK TABLES `tbl_mlm_matching_log` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_matching_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_matching_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_plan`
--

DROP TABLE IF EXISTS `tbl_mlm_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_plan` (
  `marketing_plan_code_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `marketing_plan_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marketing_plan_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marketing_plan_trigger` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marketing_plan_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marketing_plan_enable` tinyint(4) NOT NULL,
  `marketing_plan_release_schedule` tinyint(4) NOT NULL,
  `marketing_plan_release_monthly` int(11) NOT NULL,
  `marketing_plan_release_weekly` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marketing_plan_release_time` time NOT NULL,
  `marketing_plan_release_schedule_date` datetime NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `marketing_plan_enable_encash` int(11) NOT NULL DEFAULT '0',
  `marketing_plan_enable_product_repurchase` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`marketing_plan_code_id`),
  KEY `tbl_mlm_plan_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_mlm_plan_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_plan`
--

LOCK TABLES `tbl_mlm_plan` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_plan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_plan_setting`
--

DROP TABLE IF EXISTS `tbl_mlm_plan_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_plan_setting` (
  `plan_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `plan_settings_enable_mlm` tinyint(4) NOT NULL DEFAULT '0',
  `plan_settings_enable_replicated` tinyint(4) NOT NULL DEFAULT '0',
  `plan_settings_slot_id_format` tinyint(4) NOT NULL DEFAULT '0',
  `plan_settings_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `plan_settings_prefix_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plan_settings_id`),
  KEY `tbl_mlm_plan_setting_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_mlm_plan_setting_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_plan_setting`
--

LOCK TABLES `tbl_mlm_plan_setting` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_plan_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_plan_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_product_points`
--

DROP TABLE IF EXISTS `tbl_mlm_product_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_product_points` (
  `product_points_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_points_stairstep` double NOT NULL,
  `product_points_unilevel` double NOT NULL,
  `product_points_binary` double NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `variant_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_points_id`),
  KEY `tbl_mlm_product_points_product_id_foreign` (`product_id`),
  KEY `tbl_mlm_product_points_variant_id_foreign` (`variant_id`),
  CONSTRAINT `tbl_mlm_product_points_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`),
  CONSTRAINT `tbl_mlm_product_points_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `tbl_variant` (`variant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_product_points`
--

LOCK TABLES `tbl_mlm_product_points` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_product_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_product_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_slot`
--

DROP TABLE IF EXISTS `tbl_mlm_slot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_slot` (
  `slot_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slot_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `shop_id` int(10) unsigned DEFAULT NULL,
  `slot_owner` int(10) unsigned DEFAULT NULL,
  `slot_membership` int(10) unsigned DEFAULT NULL,
  `slot_sponsor` int(10) unsigned DEFAULT NULL,
  `slot_created_date` datetime NOT NULL,
  `slot_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `slot_rank` int(11) NOT NULL DEFAULT '0',
  `slot_placement` int(10) unsigned DEFAULT '0',
  `slot_position` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'left',
  `slot_binary_left` int(11) NOT NULL DEFAULT '0',
  `slot_binary_right` int(11) NOT NULL DEFAULT '0',
  `slot_wallet_all` int(11) NOT NULL DEFAULT '0',
  `slot_wallet_withdraw` int(11) NOT NULL DEFAULT '0',
  `slot_wallet_current` int(11) NOT NULL DEFAULT '0',
  `slot_pairs_per_day_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `slot_pairs_current` double NOT NULL DEFAULT '0',
  `slot_pairs_gc` double NOT NULL DEFAULT '0',
  `slot_personal_points` double NOT NULL,
  `slot_group_points` double NOT NULL,
  `slot_upgrade_points` double NOT NULL,
  `slot_active` tinyint(4) NOT NULL DEFAULT '0',
  `slot_card_printed` int(11) NOT NULL DEFAULT '0',
  `slot_nick_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slot_defaul` int(11) NOT NULL DEFAULT '0',
  `slot_card_issued` datetime NOT NULL,
  PRIMARY KEY (`slot_id`),
  KEY `tbl_mlm_slot_shop_id_foreign` (`shop_id`),
  KEY `tbl_mlm_slot_slot_owner_foreign` (`slot_owner`),
  KEY `tbl_mlm_slot_slot_membership_foreign` (`slot_membership`),
  KEY `tbl_mlm_slot_slot_sponsor_foreign` (`slot_sponsor`),
  CONSTRAINT `tbl_mlm_slot_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`),
  CONSTRAINT `tbl_mlm_slot_slot_membership_foreign` FOREIGN KEY (`slot_membership`) REFERENCES `tbl_membership` (`membership_id`),
  CONSTRAINT `tbl_mlm_slot_slot_owner_foreign` FOREIGN KEY (`slot_owner`) REFERENCES `tbl_customer` (`customer_id`),
  CONSTRAINT `tbl_mlm_slot_slot_sponsor_foreign` FOREIGN KEY (`slot_sponsor`) REFERENCES `tbl_mlm_slot` (`slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_slot`
--

LOCK TABLES `tbl_mlm_slot` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_slot` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_slot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_slot_points_log`
--

DROP TABLE IF EXISTS `tbl_mlm_slot_points_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_slot_points_log` (
  `points_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `points_log_complan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `points_log_level` int(11) NOT NULL DEFAULT '0',
  `points_log_slot` int(11) NOT NULL,
  `points_log_Sponsor` int(11) NOT NULL,
  `points_log_date_claimed` datetime NOT NULL,
  `points_log_converted` int(11) NOT NULL DEFAULT '0',
  `points_log_converted_date` datetime NOT NULL,
  `points_log_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `points_log_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `points_log_points` double NOT NULL DEFAULT '0',
  `points_log_leve_start` int(11) NOT NULL DEFAULT '0',
  `points_log_leve_end` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`points_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_slot_points_log`
--

LOCK TABLES `tbl_mlm_slot_points_log` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_slot_points_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_slot_points_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_slot_wallet_log`
--

DROP TABLE IF EXISTS `tbl_mlm_slot_wallet_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_slot_wallet_log` (
  `wallet_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `wallet_log_slot` int(10) unsigned DEFAULT NULL,
  `wallet_log_slot_sponsor` int(10) unsigned DEFAULT NULL,
  `wallet_log_date_created` datetime NOT NULL,
  `wallet_log_details` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No Details Available',
  `wallet_log_amount` double NOT NULL DEFAULT '0',
  `wallet_log_plan` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No Plan',
  `wallet_log_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n_ready',
  `wallet_log_claimbale_on` datetime NOT NULL,
  `wallet_log_enable_cash` int(11) NOT NULL DEFAULT '0',
  `wallet_log_product_repurchase` int(11) NOT NULL DEFAULT '0',
  `wallet_log_notified` int(11) NOT NULL DEFAULT '0',
  `encashment_process` int(10) unsigned DEFAULT NULL,
  `encashment_process_type` int(10) unsigned NOT NULL,
  `wallet_log_remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `encashment_process_taxed` double unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wallet_log_id`),
  KEY `tbl_mlm_slot_wallet_log_shop_id_foreign` (`shop_id`),
  KEY `tbl_mlm_slot_wallet_log_wallet_log_slot_foreign` (`wallet_log_slot`),
  KEY `tbl_mlm_slot_wallet_log_wallet_log_slot_sponsor_foreign` (`wallet_log_slot_sponsor`),
  CONSTRAINT `tbl_mlm_slot_wallet_log_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`),
  CONSTRAINT `tbl_mlm_slot_wallet_log_wallet_log_slot_foreign` FOREIGN KEY (`wallet_log_slot`) REFERENCES `tbl_mlm_slot` (`slot_id`),
  CONSTRAINT `tbl_mlm_slot_wallet_log_wallet_log_slot_sponsor_foreign` FOREIGN KEY (`wallet_log_slot_sponsor`) REFERENCES `tbl_mlm_slot` (`slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_slot_wallet_log`
--

LOCK TABLES `tbl_mlm_slot_wallet_log` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_slot_wallet_log_refill`
--

DROP TABLE IF EXISTS `tbl_mlm_slot_wallet_log_refill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_slot_wallet_log_refill` (
  `wallet_log_refill_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_log_refill_date` datetime NOT NULL,
  `wallet_log_refill_date_approved` datetime DEFAULT NULL,
  `wallet_log_refill_amount` double NOT NULL DEFAULT '0',
  `wallet_log_refill_amount_paid` double NOT NULL DEFAULT '0',
  `wallet_log_refill_processing_fee` double NOT NULL DEFAULT '0',
  `wallet_log_refill_approved` int(11) NOT NULL DEFAULT '0',
  `wallet_log_refill_remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wallet_log_refill_remarks_admin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wallet_log_refill_attachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `slot_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wallet_log_refill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_slot_wallet_log_refill`
--

LOCK TABLES `tbl_mlm_slot_wallet_log_refill` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log_refill` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log_refill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_slot_wallet_log_refill_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_slot_wallet_log_refill_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_slot_wallet_log_refill_settings` (
  `wallet_log_refill_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_log_refill_settings_processings_fee` double NOT NULL,
  `wallet_log_refill_settings_processings_max_request` int(11) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `wallet_log_refill_settings_transfer_processing_fee` double NOT NULL,
  PRIMARY KEY (`wallet_log_refill_settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_slot_wallet_log_refill_settings`
--

LOCK TABLES `tbl_mlm_slot_wallet_log_refill_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log_refill_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log_refill_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_slot_wallet_log_transfer`
--

DROP TABLE IF EXISTS `tbl_mlm_slot_wallet_log_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_slot_wallet_log_transfer` (
  `wallet_log_transfer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_log_transfer_amount` double NOT NULL,
  `wallet_log_transfer_fee` double NOT NULL,
  `wallet_log_transfer_slot_trans` int(11) NOT NULL,
  `wallet_log_transfer_slot_recieve` int(11) NOT NULL,
  `wallet_log_transfer_date` datetime NOT NULL,
  `wallet_log_transfer_remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `wallet_log_transfer_remarks_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wallet_log_transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_slot_wallet_log_transfer`
--

LOCK TABLES `tbl_mlm_slot_wallet_log_transfer` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_log_transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_slot_wallet_type`
--

DROP TABLE IF EXISTS `tbl_mlm_slot_wallet_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_slot_wallet_type` (
  `wallet_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_type_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'cash',
  `wallet_type_enable_encash` tinyint(4) NOT NULL DEFAULT '0',
  `wallet_type_enable_product_repurchase` tinyint(4) NOT NULL DEFAULT '0',
  `wallet_type_other` tinyint(4) NOT NULL DEFAULT '0',
  `wallet_type_archive` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wallet_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_slot_wallet_type`
--

LOCK TABLES `tbl_mlm_slot_wallet_type` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_slot_wallet_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_stairstep_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_stairstep_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_stairstep_settings` (
  `stairstep_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stairstep_level` int(11) NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `stairstep_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stairstep_required_pv` double NOT NULL,
  `stairstep_required_gv` double NOT NULL,
  `stairstep_bonus` double NOT NULL,
  PRIMARY KEY (`stairstep_id`),
  KEY `tbl_mlm_stairstep_settings_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_mlm_stairstep_settings_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_stairstep_settings`
--

LOCK TABLES `tbl_mlm_stairstep_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_stairstep_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_stairstep_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_unilevel_points_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_unilevel_points_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_unilevel_points_settings` (
  `unilevel_points_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unilevel_points_level` int(11) NOT NULL DEFAULT '0',
  `unilevel_points_amount` double NOT NULL DEFAULT '0',
  `unilevel_points_percentage` tinyint(4) NOT NULL DEFAULT '0',
  `unilevel_points_archive` int(11) NOT NULL DEFAULT '0',
  `membership_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`unilevel_points_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_unilevel_points_settings`
--

LOCK TABLES `tbl_mlm_unilevel_points_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_unilevel_points_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_unilevel_points_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mlm_unilevel_settings`
--

DROP TABLE IF EXISTS `tbl_mlm_unilevel_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mlm_unilevel_settings` (
  `unilevel_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unilevel_settings_level` double NOT NULL DEFAULT '0',
  `unilevel_settings_amount` double NOT NULL DEFAULT '0',
  `unilevel_settings_percent` tinyint(4) NOT NULL DEFAULT '0',
  `membership_id` int(10) unsigned NOT NULL,
  `unilevel_settings_archive` int(11) NOT NULL,
  `unilevel_settings_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`unilevel_settings_id`),
  KEY `tbl_mlm_unilevel_settings_membership_id_foreign` (`membership_id`),
  CONSTRAINT `tbl_mlm_unilevel_settings_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `tbl_membership` (`membership_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mlm_unilevel_settings`
--

LOCK TABLES `tbl_mlm_unilevel_settings` WRITE;
/*!40000 ALTER TABLE `tbl_mlm_unilevel_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mlm_unilevel_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_online_pymnt_api`
--

DROP TABLE IF EXISTS `tbl_online_pymnt_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_online_pymnt_api` (
  `api_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `api_shop_id` int(10) unsigned NOT NULL,
  `api_gateway_id` int(10) unsigned NOT NULL,
  `api_client_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `api_secret_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`api_id`),
  KEY `tbl_online_pymnt_api_api_shop_id_foreign` (`api_shop_id`),
  KEY `tbl_online_pymnt_api_api_gateway_id_foreign` (`api_gateway_id`),
  CONSTRAINT `tbl_online_pymnt_api_api_gateway_id_foreign` FOREIGN KEY (`api_gateway_id`) REFERENCES `tbl_online_pymnt_gateway` (`gateway_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_online_pymnt_api_api_shop_id_foreign` FOREIGN KEY (`api_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_online_pymnt_api`
--

LOCK TABLES `tbl_online_pymnt_api` WRITE;
/*!40000 ALTER TABLE `tbl_online_pymnt_api` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_online_pymnt_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_online_pymnt_gateway`
--

DROP TABLE IF EXISTS `tbl_online_pymnt_gateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_online_pymnt_gateway` (
  `gateway_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gateway_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gateway_code_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`gateway_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_online_pymnt_gateway`
--

LOCK TABLES `tbl_online_pymnt_gateway` WRITE;
/*!40000 ALTER TABLE `tbl_online_pymnt_gateway` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_online_pymnt_gateway` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_online_pymnt_link`
--

DROP TABLE IF EXISTS `tbl_online_pymnt_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_online_pymnt_link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_shop_id` int(10) unsigned NOT NULL,
  `link_method_id` int(10) unsigned NOT NULL,
  `link_reference_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_reference_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_img_id` int(11) NOT NULL,
  `link_is_enabled` tinyint(4) NOT NULL,
  `link_date_created` datetime NOT NULL,
  PRIMARY KEY (`link_id`),
  KEY `tbl_online_pymnt_link_link_shop_id_foreign` (`link_shop_id`),
  KEY `tbl_online_pymnt_link_link_method_id_foreign` (`link_method_id`),
  CONSTRAINT `tbl_online_pymnt_link_link_method_id_foreign` FOREIGN KEY (`link_method_id`) REFERENCES `tbl_online_pymnt_method` (`method_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_online_pymnt_link_link_shop_id_foreign` FOREIGN KEY (`link_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_online_pymnt_link`
--

LOCK TABLES `tbl_online_pymnt_link` WRITE;
/*!40000 ALTER TABLE `tbl_online_pymnt_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_online_pymnt_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_online_pymnt_method`
--

DROP TABLE IF EXISTS `tbl_online_pymnt_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_online_pymnt_method` (
  `method_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method_code_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method_gateway_accepted` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'array([0],[1],[2])',
  PRIMARY KEY (`method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_online_pymnt_method`
--

LOCK TABLES `tbl_online_pymnt_method` WRITE;
/*!40000 ALTER TABLE `tbl_online_pymnt_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_online_pymnt_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_online_pymnt_other`
--

DROP TABLE IF EXISTS `tbl_online_pymnt_other`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_online_pymnt_other` (
  `other_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `other_shop_id` int(10) unsigned NOT NULL,
  `other_gateway_id` int(10) unsigned NOT NULL,
  `other_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`other_id`),
  KEY `tbl_online_pymnt_other_other_shop_id_foreign` (`other_shop_id`),
  KEY `tbl_online_pymnt_other_other_gateway_id_foreign` (`other_gateway_id`),
  CONSTRAINT `tbl_online_pymnt_other_other_gateway_id_foreign` FOREIGN KEY (`other_gateway_id`) REFERENCES `tbl_online_pymnt_gateway` (`gateway_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_online_pymnt_other_other_shop_id_foreign` FOREIGN KEY (`other_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_online_pymnt_other`
--

LOCK TABLES `tbl_online_pymnt_other` WRITE;
/*!40000 ALTER TABLE `tbl_online_pymnt_other` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_online_pymnt_other` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_option_name`
--

DROP TABLE IF EXISTS `tbl_option_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_option_name` (
  `option_name_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`option_name_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_option_name`
--

LOCK TABLES `tbl_option_name` WRITE;
/*!40000 ALTER TABLE `tbl_option_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_option_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_option_value`
--

DROP TABLE IF EXISTS `tbl_option_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_option_value` (
  `option_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`option_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_option_value`
--

LOCK TABLES `tbl_option_value` WRITE;
/*!40000 ALTER TABLE `tbl_option_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_option_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order`
--

DROP TABLE IF EXISTS `tbl_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order` (
  `tbl_order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `discount` double(18,2) NOT NULL,
  `discount_var` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `discount_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IsfreeShipping` tinyint(4) NOT NULL,
  `shipping_name` int(11) NOT NULL,
  `shipping_amount` double(18,2) NOT NULL,
  `isTaxExempt` tinyint(4) NOT NULL,
  `hasTax` tinyint(4) NOT NULL,
  `tax_percentage` double NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `payment_stat` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IsReserve` tinyint(4) NOT NULL,
  `reserve_date` datetime NOT NULL,
  `craeted_date` datetime NOT NULL,
  `status` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `fulfillment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proof_of_payment` text COLLATE utf8_unicode_ci NOT NULL,
  `date_approve_order` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  PRIMARY KEY (`tbl_order_id`),
  KEY `tbl_order_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_order_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order`
--

LOCK TABLES `tbl_order` WRITE;
/*!40000 ALTER TABLE `tbl_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_item`
--

DROP TABLE IF EXISTS `tbl_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_item` (
  `tbl_order_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tbl_order_id` int(10) unsigned NOT NULL,
  `variant_id` int(10) unsigned NOT NULL,
  `item_amount` double(18,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` double(18,2) NOT NULL,
  `discount_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_var` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `IsCustom` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `refunded` tinyint(4) NOT NULL,
  PRIMARY KEY (`tbl_order_item_id`),
  KEY `tbl_order_item_tbl_order_id_foreign` (`tbl_order_id`),
  KEY `tbl_order_item_variant_id_foreign` (`variant_id`),
  CONSTRAINT `tbl_order_item_tbl_order_id_foreign` FOREIGN KEY (`tbl_order_id`) REFERENCES `tbl_order` (`tbl_order_id`),
  CONSTRAINT `tbl_order_item_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `tbl_variant` (`variant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_item`
--

LOCK TABLES `tbl_order_item` WRITE;
/*!40000 ALTER TABLE `tbl_order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_refund`
--

DROP TABLE IF EXISTS `tbl_order_refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_refund` (
  `tbl_order_refund_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tbl_order_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `refund_reason` text COLLATE utf8_unicode_ci NOT NULL,
  `refund_date` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`tbl_order_refund_id`),
  KEY `tbl_order_refund_tbl_order_id_foreign` (`tbl_order_id`),
  KEY `tbl_order_refund_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_order_refund_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`),
  CONSTRAINT `tbl_order_refund_tbl_order_id_foreign` FOREIGN KEY (`tbl_order_id`) REFERENCES `tbl_order` (`tbl_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_refund`
--

LOCK TABLES `tbl_order_refund` WRITE;
/*!40000 ALTER TABLE `tbl_order_refund` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_refund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order_refund_item`
--

DROP TABLE IF EXISTS `tbl_order_refund_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order_refund_item` (
  `tbl_order_refund_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tbl_order_id` int(11) NOT NULL,
  `tbl_order_refund_id` int(10) unsigned NOT NULL,
  `tbl_order_item_id` int(10) unsigned NOT NULL,
  `item_amount` double(18,2) NOT NULL,
  `refund_quantity` int(11) NOT NULL,
  PRIMARY KEY (`tbl_order_refund_item_id`),
  KEY `tbl_order_refund_item_tbl_order_refund_id_foreign` (`tbl_order_refund_id`),
  KEY `tbl_order_refund_item_tbl_order_item_id_foreign` (`tbl_order_item_id`),
  CONSTRAINT `tbl_order_refund_item_tbl_order_item_id_foreign` FOREIGN KEY (`tbl_order_item_id`) REFERENCES `tbl_order_item` (`tbl_order_item_id`),
  CONSTRAINT `tbl_order_refund_item_tbl_order_refund_id_foreign` FOREIGN KEY (`tbl_order_refund_id`) REFERENCES `tbl_order_refund` (`tbl_order_refund_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order_refund_item`
--

LOCK TABLES `tbl_order_refund_item` WRITE;
/*!40000 ALTER TABLE `tbl_order_refund_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_refund_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_payment_method`
--

DROP TABLE IF EXISTS `tbl_payment_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_payment_method` (
  `payment_method_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `payment_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`payment_method_id`),
  KEY `tbl_payment_method_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_payment_method_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_payment_method`
--

LOCK TABLES `tbl_payment_method` WRITE;
/*!40000 ALTER TABLE `tbl_payment_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_payment_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_payroll_company`
--

DROP TABLE IF EXISTS `tbl_payroll_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_payroll_company` (
  `payroll_company_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payroll_parent_company_id` int(11) NOT NULL DEFAULT '0',
  `payroll_company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_address` text COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_nature_of_business` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_rdo` int(11) NOT NULL DEFAULT '0',
  `payroll_company_date_started` date NOT NULL,
  `payroll_company_tin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_sss` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_philhealth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_pagibig` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payroll_company_archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`payroll_company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_payroll_company`
--

LOCK TABLES `tbl_payroll_company` WRITE;
/*!40000 ALTER TABLE `tbl_payroll_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_payroll_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_payroll_rdo`
--

DROP TABLE IF EXISTS `tbl_payroll_rdo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_payroll_rdo` (
  `payroll_rdo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rdo_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rdo_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`payroll_rdo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_payroll_rdo`
--

LOCK TABLES `tbl_payroll_rdo` WRITE;
/*!40000 ALTER TABLE `tbl_payroll_rdo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_payroll_rdo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_position`
--

DROP TABLE IF EXISTS `tbl_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_position` (
  `position_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `daily_rate` decimal(8,2) NOT NULL,
  `position_created` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `position_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position_shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`position_id`),
  KEY `tbl_position_position_shop_id_foreign` (`position_shop_id`),
  CONSTRAINT `tbl_position_position_shop_id_foreign` FOREIGN KEY (`position_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_position`
--

LOCK TABLES `tbl_position` WRITE;
/*!40000 ALTER TABLE `tbl_position` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_post`
--

DROP TABLE IF EXISTS `tbl_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_post` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` int(10) unsigned NOT NULL,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `comment_count` int(11) NOT NULL,
  `post_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post',
  `post_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `tbl_post_post_author_foreign` (`post_author`),
  KEY `tbl_post_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_post_post_author_foreign` FOREIGN KEY (`post_author`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_post_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_post`
--

LOCK TABLES `tbl_post` WRITE;
/*!40000 ALTER TABLE `tbl_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_post_category`
--

DROP TABLE IF EXISTS `tbl_post_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_post_category` (
  `post_category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_category_id`),
  KEY `tbl_post_category_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_post_category_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_post_category`
--

LOCK TABLES `tbl_post_category` WRITE;
/*!40000 ALTER TABLE `tbl_post_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_post_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_shop` int(10) unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_parent_id` int(11) NOT NULL,
  `product_sub_level` tinyint(4) NOT NULL,
  `product_description` text COLLATE utf8_unicode_ci NOT NULL,
  `product_income_account` int(10) unsigned NOT NULL,
  `product_purchase_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_cogs_exp_account` int(10) unsigned NOT NULL,
  `product_pref_vendor_id` int(11) NOT NULL,
  `product_asset_account` int(10) unsigned NOT NULL,
  `product_sale_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_main` tinyint(4) NOT NULL DEFAULT '1',
  `product_has_variations` tinyint(4) NOT NULL DEFAULT '0',
  `product_type` int(10) unsigned NOT NULL,
  `product_vendor` int(10) unsigned NOT NULL,
  `product_search_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `product_date_created` datetime NOT NULL,
  `product_date_visible` datetime NOT NULL,
  `popularity` int(11) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `product_um_id` int(11) NOT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `product_image` blob,
  PRIMARY KEY (`product_id`),
  KEY `tbl_product_product_shop_foreign` (`product_shop`),
  KEY `tbl_product_product_vendor_foreign` (`product_vendor`),
  KEY `tbl_product_product_type_foreign` (`product_type`),
  KEY `tbl_product_item_id_foreign` (`item_id`),
  CONSTRAINT `tbl_product_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`item_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_product_product_shop_foreign` FOREIGN KEY (`product_shop`) REFERENCES `tbl_shop` (`shop_id`),
  CONSTRAINT `tbl_product_product_type_foreign` FOREIGN KEY (`product_type`) REFERENCES `tbl_category` (`type_id`),
  CONSTRAINT `tbl_product_product_vendor_foreign` FOREIGN KEY (`product_vendor`) REFERENCES `tbl_product_vendor` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product`
--

LOCK TABLES `tbl_product` WRITE;
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_search`
--

DROP TABLE IF EXISTS `tbl_product_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_search` (
  `product_search_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `variant_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_search_id`),
  FULLTEXT KEY `search` (`body`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_search`
--

LOCK TABLES `tbl_product_search` WRITE;
/*!40000 ALTER TABLE `tbl_product_search` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product_vendor`
--

DROP TABLE IF EXISTS `tbl_product_vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product_vendor` (
  `vendor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vendor_shop` int(10) unsigned NOT NULL,
  `vendor_date_created` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`vendor_id`),
  KEY `tbl_product_vendor_vendor_shop_foreign` (`vendor_shop`),
  CONSTRAINT `tbl_product_vendor_vendor_shop_foreign` FOREIGN KEY (`vendor_shop`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product_vendor`
--

LOCK TABLES `tbl_product_vendor` WRITE;
/*!40000 ALTER TABLE `tbl_product_vendor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_purchase_order`
--

DROP TABLE IF EXISTS `tbl_purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_purchase_order` (
  `po_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `po_shop_id` int(11) NOT NULL,
  `po_vendor_id` int(11) NOT NULL,
  `po_ap_account` int(11) NOT NULL,
  `po_billing_address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `po_terms_id` tinyint(4) NOT NULL,
  `po_date` date NOT NULL,
  `po_due_date` date NOT NULL,
  `po_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `po_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `po_discount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `po_discount_value` int(11) NOT NULL,
  `ewt` int(11) NOT NULL,
  `taxable` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  `po_subtotal_price` double NOT NULL,
  `po_overall_price` double NOT NULL,
  `po_custom_field_id` int(11) NOT NULL,
  `po_vendor_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_purchase_order`
--

LOCK TABLES `tbl_purchase_order` WRITE;
/*!40000 ALTER TABLE `tbl_purchase_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_purchase_order_line`
--

DROP TABLE IF EXISTS `tbl_purchase_order_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_purchase_order_line` (
  `poline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poline_po_id` int(10) unsigned NOT NULL,
  `poline_service_date` datetime NOT NULL,
  `poline_item_id` int(11) NOT NULL,
  `poline_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poline_qty` int(11) NOT NULL,
  `poline_rate` double NOT NULL,
  `taxable` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  `poline_um` int(11) NOT NULL,
  `poline_amount` double NOT NULL,
  `poline_discount_remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poline_discount` double NOT NULL,
  PRIMARY KEY (`poline_id`),
  KEY `tbl_purchase_order_line_poline_po_id_foreign` (`poline_po_id`),
  CONSTRAINT `tbl_purchase_order_line_poline_po_id_foreign` FOREIGN KEY (`poline_po_id`) REFERENCES `tbl_purchase_order` (`po_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_purchase_order_line`
--

LOCK TABLES `tbl_purchase_order_line` WRITE;
/*!40000 ALTER TABLE `tbl_purchase_order_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_purchase_order_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_receive_payment`
--

DROP TABLE IF EXISTS `tbl_receive_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_receive_payment` (
  `rp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rp_shop_id` int(11) NOT NULL,
  `rp_customer_id` int(11) NOT NULL,
  `rp_ar_account` int(11) NOT NULL,
  `rp_date` date NOT NULL,
  `rp_total_amount` double(8,2) NOT NULL,
  `rp_payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rp_memo` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`rp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_receive_payment`
--

LOCK TABLES `tbl_receive_payment` WRITE;
/*!40000 ALTER TABLE `tbl_receive_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_receive_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_receive_payment_line`
--

DROP TABLE IF EXISTS `tbl_receive_payment_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_receive_payment_line` (
  `rpline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rpline_rp_id` int(10) unsigned NOT NULL,
  `rpline_txn_type` int(11) NOT NULL,
  `rpline_txn_id` int(11) NOT NULL,
  `rpline_amount` double(8,2) NOT NULL,
  PRIMARY KEY (`rpline_id`),
  KEY `tbl_receive_payment_line_rpline_rp_id_foreign` (`rpline_rp_id`),
  CONSTRAINT `tbl_receive_payment_line_rpline_rp_id_foreign` FOREIGN KEY (`rpline_rp_id`) REFERENCES `tbl_receive_payment` (`rp_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_receive_payment_line`
--

LOCK TABLES `tbl_receive_payment_line` WRITE;
/*!40000 ALTER TABLE `tbl_receive_payment_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_receive_payment_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_service`
--

DROP TABLE IF EXISTS `tbl_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_service` (
  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_shop` int(10) unsigned NOT NULL,
  `service_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_parent_id` int(11) NOT NULL,
  `service_sublevel` tinyint(4) NOT NULL,
  `service_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_income_account` int(11) NOT NULL,
  `service_purchase_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_purchase_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_expense_account` int(11) NOT NULL,
  `service_pref_vendor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_type` int(10) unsigned NOT NULL,
  `service_search_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_date_created` datetime NOT NULL,
  `service_date_visible` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `service_um_id` int(11) NOT NULL,
  PRIMARY KEY (`service_id`),
  KEY `tbl_service_service_shop_foreign` (`service_shop`),
  KEY `tbl_service_service_type_foreign` (`service_type`),
  CONSTRAINT `tbl_service_service_shop_foreign` FOREIGN KEY (`service_shop`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_service_service_type_foreign` FOREIGN KEY (`service_type`) REFERENCES `tbl_category` (`type_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_service`
--

LOCK TABLES `tbl_service` WRITE;
/*!40000 ALTER TABLE `tbl_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_settings`
--

DROP TABLE IF EXISTS `tbl_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_settings` (
  `settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `settings_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `settings_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `settings_setup_done` tinyint(4) NOT NULL DEFAULT '0',
  `shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_settings`
--

LOCK TABLES `tbl_settings` WRITE;
/*!40000 ALTER TABLE `tbl_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_shipping`
--

DROP TABLE IF EXISTS `tbl_shipping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_shipping` (
  `shipping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `shipping_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_fee` double(18,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `measurement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` double NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`shipping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_shipping`
--

LOCK TABLES `tbl_shipping` WRITE;
/*!40000 ALTER TABLE `tbl_shipping` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_shipping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_shop`
--

DROP TABLE IF EXISTS `tbl_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_shop` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_date_created` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `shop_date_expiration` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `shop_last_active_date` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `shop_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'trial',
  `shop_country` int(10) unsigned NOT NULL,
  `shop_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_street_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `shop_domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unset_yet',
  `shop_theme` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `shop_theme_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'gray',
  PRIMARY KEY (`shop_id`),
  UNIQUE KEY `tbl_shop_shop_key_unique` (`shop_key`),
  KEY `tbl_shop_shop_country_foreign` (`shop_country`),
  CONSTRAINT `tbl_shop_shop_country_foreign` FOREIGN KEY (`shop_country`) REFERENCES `tbl_country` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_shop`
--

LOCK TABLES `tbl_shop` WRITE;
/*!40000 ALTER TABLE `tbl_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sir`
--

DROP TABLE IF EXISTS `tbl_sir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sir` (
  `sir_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `truck_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `sales_agent_id` int(10) unsigned NOT NULL,
  `created_at` date NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `sir_status` tinyint(4) NOT NULL,
  `is_sync` tinyint(4) NOT NULL DEFAULT '0',
  `ilr_status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sir_id`),
  KEY `tbl_sir_truck_id_foreign` (`truck_id`),
  KEY `tbl_sir_shop_id_foreign` (`shop_id`),
  KEY `tbl_sir_sales_agent_id_foreign` (`sales_agent_id`),
  CONSTRAINT `tbl_sir_sales_agent_id_foreign` FOREIGN KEY (`sales_agent_id`) REFERENCES `tbl_employee` (`employee_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_sir_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_sir_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `tbl_truck` (`truck_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sir`
--

LOCK TABLES `tbl_sir` WRITE;
/*!40000 ALTER TABLE `tbl_sir` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sir_item`
--

DROP TABLE IF EXISTS `tbl_sir_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sir_item` (
  `sir_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sir_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_qty` int(11) NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `related_um_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `um_qty` int(11) NOT NULL,
  `sold_qty` int(11) NOT NULL,
  `remaining_qty` int(11) NOT NULL,
  `physical_count` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `loss_amount` decimal(8,2) NOT NULL,
  `sir_item_price` double NOT NULL,
  `is_updated` tinyint(4) NOT NULL DEFAULT '0',
  `infos` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`sir_item_id`),
  KEY `tbl_sir_item_sir_id_foreign` (`sir_id`),
  KEY `tbl_sir_item_item_id_foreign` (`item_id`),
  CONSTRAINT `tbl_sir_item_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`item_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_sir_item_sir_id_foreign` FOREIGN KEY (`sir_id`) REFERENCES `tbl_sir` (`sir_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sir_item`
--

LOCK TABLES `tbl_sir_item` WRITE;
/*!40000 ALTER TABLE `tbl_sir_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sir_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sub_warehouse`
--

DROP TABLE IF EXISTS `tbl_sub_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sub_warehouse` (
  `sub_warehouse_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_reorder_point` int(11) NOT NULL,
  PRIMARY KEY (`sub_warehouse_item_id`),
  KEY `tbl_sub_warehouse_warehouse_id_foreign` (`warehouse_id`),
  KEY `tbl_sub_warehouse_item_id_foreign` (`item_id`),
  CONSTRAINT `tbl_sub_warehouse_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`item_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_sub_warehouse_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`warehouse_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sub_warehouse`
--

LOCK TABLES `tbl_sub_warehouse` WRITE;
/*!40000 ALTER TABLE `tbl_sub_warehouse` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sub_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tags`
--

DROP TABLE IF EXISTS `tbl_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tags` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `tags_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`tag_id`),
  KEY `tbl_tags_product_id_foreign` (`product_id`),
  CONSTRAINT `tbl_tags_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tags`
--

LOCK TABLES `tbl_tags` WRITE;
/*!40000 ALTER TABLE `tbl_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_temp_customer_invoice`
--

DROP TABLE IF EXISTS `tbl_temp_customer_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_temp_customer_invoice` (
  `inv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inv_shop_id` int(11) NOT NULL,
  `inv_customer_id` int(11) NOT NULL,
  `inv_customer_email` int(11) NOT NULL,
  `inv_customer_billing_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_terms_id` tinyint(4) NOT NULL,
  `inv_date` date NOT NULL,
  `inv_due_date` date NOT NULL,
  `inv_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_discount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv_discount_value` int(11) NOT NULL,
  `ewt` double NOT NULL,
  `taxable` tinyint(4) NOT NULL,
  `inv_subtotal_price` double NOT NULL,
  `inv_overall_price` double NOT NULL,
  `inv_custom_field_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_sync` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_temp_customer_invoice`
--

LOCK TABLES `tbl_temp_customer_invoice` WRITE;
/*!40000 ALTER TABLE `tbl_temp_customer_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_temp_customer_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_temp_customer_invoice_line`
--

DROP TABLE IF EXISTS `tbl_temp_customer_invoice_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_temp_customer_invoice_line` (
  `invline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invline_inv_id` int(10) unsigned NOT NULL,
  `invline_service_date` datetime NOT NULL,
  `invline_item_id` int(11) NOT NULL,
  `invline_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invline_um` int(11) NOT NULL,
  `invline_qty` int(11) NOT NULL,
  `invline_discount` double NOT NULL,
  `invline_discount_remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invline_rate` double NOT NULL,
  `invline_amount` double NOT NULL,
  `taxable` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`invline_id`),
  KEY `tbl_temp_customer_invoice_line_invline_inv_id_foreign` (`invline_inv_id`),
  CONSTRAINT `tbl_temp_customer_invoice_line_invline_inv_id_foreign` FOREIGN KEY (`invline_inv_id`) REFERENCES `tbl_temp_customer_invoice` (`inv_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_temp_customer_invoice_line`
--

LOCK TABLES `tbl_temp_customer_invoice_line` WRITE;
/*!40000 ALTER TABLE `tbl_temp_customer_invoice_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_temp_customer_invoice_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_term`
--

DROP TABLE IF EXISTS `tbl_term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_term` (
  `term_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned NOT NULL,
  `term_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `term_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `term_day` int(11) NOT NULL,
  `term_day_of_month` int(11) NOT NULL,
  `term_day_due_date` int(11) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`term_id`),
  KEY `tbl_term_shop_id_foreign` (`shop_id`),
  CONSTRAINT `tbl_term_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_term`
--

LOCK TABLES `tbl_term` WRITE;
/*!40000 ALTER TABLE `tbl_term` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_term` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tree_placement`
--

DROP TABLE IF EXISTS `tbl_tree_placement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tree_placement` (
  `placement_tree_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `placement_tree_parent_id` int(10) unsigned DEFAULT NULL,
  `placement_tree_child_id` int(10) unsigned DEFAULT NULL,
  `placement_tree_level` int(11) NOT NULL DEFAULT '0',
  `placement_tree_position` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'left',
  PRIMARY KEY (`placement_tree_id`),
  KEY `tbl_tree_placement_shop_id_foreign` (`shop_id`),
  KEY `tbl_tree_placement_placement_tree_parent_id_foreign` (`placement_tree_parent_id`),
  KEY `tbl_tree_placement_placement_tree_child_id_foreign` (`placement_tree_child_id`),
  CONSTRAINT `tbl_tree_placement_placement_tree_child_id_foreign` FOREIGN KEY (`placement_tree_child_id`) REFERENCES `tbl_mlm_slot` (`slot_id`),
  CONSTRAINT `tbl_tree_placement_placement_tree_parent_id_foreign` FOREIGN KEY (`placement_tree_parent_id`) REFERENCES `tbl_mlm_slot` (`slot_id`),
  CONSTRAINT `tbl_tree_placement_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tree_placement`
--

LOCK TABLES `tbl_tree_placement` WRITE;
/*!40000 ALTER TABLE `tbl_tree_placement` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_tree_placement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tree_sponsor`
--

DROP TABLE IF EXISTS `tbl_tree_sponsor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tree_sponsor` (
  `sponsor_tree_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) unsigned DEFAULT NULL,
  `sponsor_tree_parent_id` int(10) unsigned DEFAULT NULL,
  `sponsor_tree_child_id` int(10) unsigned DEFAULT NULL,
  `sponsor_tree_level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sponsor_tree_id`),
  KEY `tbl_tree_sponsor_shop_id_foreign` (`shop_id`),
  KEY `tbl_tree_sponsor_sponsor_tree_parent_id_foreign` (`sponsor_tree_parent_id`),
  KEY `tbl_tree_sponsor_sponsor_tree_child_id_foreign` (`sponsor_tree_child_id`),
  CONSTRAINT `tbl_tree_sponsor_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shop` (`shop_id`),
  CONSTRAINT `tbl_tree_sponsor_sponsor_tree_child_id_foreign` FOREIGN KEY (`sponsor_tree_child_id`) REFERENCES `tbl_mlm_slot` (`slot_id`),
  CONSTRAINT `tbl_tree_sponsor_sponsor_tree_parent_id_foreign` FOREIGN KEY (`sponsor_tree_parent_id`) REFERENCES `tbl_mlm_slot` (`slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tree_sponsor`
--

LOCK TABLES `tbl_tree_sponsor` WRITE;
/*!40000 ALTER TABLE `tbl_tree_sponsor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_tree_sponsor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_truck`
--

DROP TABLE IF EXISTS `tbl_truck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_truck` (
  `truck_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plate_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `warehouse_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `truck_model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `truck_kilogram` decimal(8,2) NOT NULL,
  `truck_shop_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`truck_id`),
  KEY `tbl_truck_warehouse_id_foreign` (`warehouse_id`),
  KEY `tbl_truck_truck_shop_id_foreign` (`truck_shop_id`),
  CONSTRAINT `tbl_truck_truck_shop_id_foreign` FOREIGN KEY (`truck_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_truck_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`warehouse_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_truck`
--

LOCK TABLES `tbl_truck` WRITE;
/*!40000 ALTER TABLE `tbl_truck` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_truck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_unit_measurement`
--

DROP TABLE IF EXISTS `tbl_unit_measurement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_unit_measurement` (
  `um_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `um_shop` int(10) unsigned NOT NULL,
  `um_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_multi` tinyint(4) NOT NULL,
  `um_date_created` datetime NOT NULL,
  `um_archived` tinyint(4) NOT NULL,
  `um_type` int(10) unsigned NOT NULL,
  PRIMARY KEY (`um_id`),
  KEY `tbl_unit_measurement_um_shop_foreign` (`um_shop`),
  KEY `tbl_unit_measurement_um_type_foreign` (`um_type`),
  CONSTRAINT `tbl_unit_measurement_um_shop_foreign` FOREIGN KEY (`um_shop`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_unit_measurement`
--

LOCK TABLES `tbl_unit_measurement` WRITE;
/*!40000 ALTER TABLE `tbl_unit_measurement` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_unit_measurement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_unit_measurement_multi`
--

DROP TABLE IF EXISTS `tbl_unit_measurement_multi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_unit_measurement_multi` (
  `multi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `multi_um_id` int(10) unsigned NOT NULL,
  `multi_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `multi_conversion_ratio` double NOT NULL,
  `multi_sequence` tinyint(4) NOT NULL,
  `unit_qty` int(11) NOT NULL,
  `multi_abbrev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_base` tinyint(4) NOT NULL,
  PRIMARY KEY (`multi_id`),
  KEY `tbl_unit_measurement_multi_multi_um_id_foreign` (`multi_um_id`),
  CONSTRAINT `tbl_unit_measurement_multi_multi_um_id_foreign` FOREIGN KEY (`multi_um_id`) REFERENCES `tbl_unit_measurement` (`um_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_unit_measurement_multi`
--

LOCK TABLES `tbl_unit_measurement_multi` WRITE;
/*!40000 ALTER TABLE `tbl_unit_measurement_multi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_unit_measurement_multi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_unit_measurement_type`
--

DROP TABLE IF EXISTS `tbl_unit_measurement_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_unit_measurement_type` (
  `um_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `um_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `um_type_abbrev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `um_type_parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`um_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_unit_measurement_type`
--

LOCK TABLES `tbl_unit_measurement_type` WRITE;
/*!40000 ALTER TABLE `tbl_unit_measurement_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_unit_measurement_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_level` int(11) NOT NULL,
  `user_first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` text COLLATE utf8_unicode_ci NOT NULL,
  `user_date_created` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `user_last_active_date` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `user_shop` int(10) unsigned NOT NULL,
  `IsWalkin` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `tbl_user_user_shop_foreign` (`user_shop`),
  CONSTRAINT `tbl_user_user_shop_foreign` FOREIGN KEY (`user_shop`) REFERENCES `tbl_shop` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_access`
--

DROP TABLE IF EXISTS `tbl_user_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_access` (
  `access_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_position_id` int(11) NOT NULL,
  `access_page_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access_permission` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_access`
--

LOCK TABLES `tbl_user_access` WRITE;
/*!40000 ALTER TABLE `tbl_user_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_position`
--

DROP TABLE IF EXISTS `tbl_user_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_position` (
  `position_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position_shop_id` int(11) NOT NULL,
  `position_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position_rank` int(11) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_position`
--

LOCK TABLES `tbl_user_position` WRITE;
/*!40000 ALTER TABLE `tbl_user_position` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_warehouse_access`
--

DROP TABLE IF EXISTS `tbl_user_warehouse_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_warehouse_access` (
  `user_id` int(10) unsigned NOT NULL,
  `warehouse_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_warehouse_access`
--

LOCK TABLES `tbl_user_warehouse_access` WRITE;
/*!40000 ALTER TABLE `tbl_user_warehouse_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user_warehouse_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_variant`
--

DROP TABLE IF EXISTS `tbl_variant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_variant` (
  `variant_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `variant_product_id` int(10) unsigned NOT NULL,
  `variant_single` tinyint(3) unsigned NOT NULL,
  `variant_price` double(18,2) NOT NULL DEFAULT '0.00',
  `variant_purchase_price` double NOT NULL,
  `variant_compare_price` double(18,2) NOT NULL DEFAULT '0.00',
  `variant_charge_taxes` tinyint(4) NOT NULL,
  `variant_sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `variant_barcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `variant_track_inventory` tinyint(4) NOT NULL,
  `variant_allow_oos_purchase` tinyint(4) NOT NULL,
  `variant_inventory_count` int(11) NOT NULL,
  `variant_inventory_date` datetime NOT NULL,
  `variant_weight` double NOT NULL,
  `variant_weight_lbl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `variant_require_shipping` tinyint(4) NOT NULL,
  `popularity` int(11) NOT NULL,
  `variant_fulfillment_service` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `variant_reorder_min` int(11) NOT NULL,
  `variant_reorder_max` int(11) NOT NULL,
  `variant_main_image` int(10) unsigned NOT NULL,
  `variant_date_created` datetime NOT NULL,
  `variant_date_visible` datetime NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`variant_id`),
  KEY `tbl_variant_variant_product_id_foreign` (`variant_product_id`),
  CONSTRAINT `tbl_variant_variant_product_id_foreign` FOREIGN KEY (`variant_product_id`) REFERENCES `tbl_product` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_variant`
--

LOCK TABLES `tbl_variant` WRITE;
/*!40000 ALTER TABLE `tbl_variant` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_variant` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trigger_product_search after insert on tbl_variant
                    for each row
                    begin
                     insert into tbl_product_search (variant_id, body) values (new.variant_id, (select group_concat(product_name, ' ',  variant_name, ' ',variant_sku, ' ', variant_barcode) as product from view_product_variant where variant_id = new.variant_id));
                    end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger trigger_product_search_update after update on tbl_variant
                    for each row
                    begin
                     update tbl_product_search set body = (select group_concat(product_name, ' ',  variant_name, ' ',variant_sku, ' ', variant_barcode) as product from view_product_variant where variant_id = new.variant_id) where variant_id = new.variant_id;
                    end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbl_variant_name`
--

DROP TABLE IF EXISTS `tbl_variant_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_variant_name` (
  `variant_name_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `variant_name_order` int(10) unsigned NOT NULL,
  `variant_id` int(10) unsigned NOT NULL,
  `option_name_id` int(10) unsigned NOT NULL,
  `option_value_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`variant_name_id`),
  KEY `tbl_variant_name_option_name_id_foreign` (`option_name_id`),
  KEY `tbl_variant_name_option_value_id_foreign` (`option_value_id`),
  KEY `tbl_variant_name_variant_id_foreign` (`variant_id`),
  CONSTRAINT `tbl_variant_name_option_name_id_foreign` FOREIGN KEY (`option_name_id`) REFERENCES `tbl_option_name` (`option_name_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_variant_name_option_value_id_foreign` FOREIGN KEY (`option_value_id`) REFERENCES `tbl_option_value` (`option_value_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_variant_name_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `tbl_ec_variant` (`evariant_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_variant_name`
--

LOCK TABLES `tbl_variant_name` WRITE;
/*!40000 ALTER TABLE `tbl_variant_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_variant_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_vendor`
--

DROP TABLE IF EXISTS `tbl_vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_vendor` (
  `vendor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_shop_id` int(10) unsigned NOT NULL,
  `vendor_title_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vendor_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vendor_middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vendor_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vendor_suffix_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vendor_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vendor_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` date NOT NULL,
  `archived` tinyint(4) NOT NULL,
  PRIMARY KEY (`vendor_id`),
  KEY `tbl_vendor_vendor_shop_id_foreign` (`vendor_shop_id`),
  CONSTRAINT `tbl_vendor_vendor_shop_id_foreign` FOREIGN KEY (`vendor_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vendor`
--

LOCK TABLES `tbl_vendor` WRITE;
/*!40000 ALTER TABLE `tbl_vendor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_vendor_address`
--

DROP TABLE IF EXISTS `tbl_vendor_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_vendor_address` (
  `ven_addr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ven_addr_vendor_id` int(10) unsigned NOT NULL,
  `ven_billing_country_id` int(10) unsigned DEFAULT NULL,
  `ven_billing_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_billing_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_billing_zipcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_billing_street` text COLLATE utf8_unicode_ci,
  `ven_shipping_country_id` int(10) unsigned DEFAULT NULL,
  `ven_shipping_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_shipping_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_shipping_zipcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_shipping_street` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ven_addr_id`),
  KEY `tbl_vendor_address_ven_addr_vendor_id_foreign` (`ven_addr_vendor_id`),
  KEY `tbl_vendor_address_ven_billing_country_id_foreign` (`ven_billing_country_id`),
  KEY `tbl_vendor_address_ven_shipping_country_id_foreign` (`ven_shipping_country_id`),
  CONSTRAINT `tbl_vendor_address_ven_addr_vendor_id_foreign` FOREIGN KEY (`ven_addr_vendor_id`) REFERENCES `tbl_vendor` (`vendor_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_vendor_address_ven_billing_country_id_foreign` FOREIGN KEY (`ven_billing_country_id`) REFERENCES `tbl_country` (`country_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_vendor_address_ven_shipping_country_id_foreign` FOREIGN KEY (`ven_shipping_country_id`) REFERENCES `tbl_country` (`country_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vendor_address`
--

LOCK TABLES `tbl_vendor_address` WRITE;
/*!40000 ALTER TABLE `tbl_vendor_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_vendor_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_vendor_other_info`
--

DROP TABLE IF EXISTS `tbl_vendor_other_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_vendor_other_info` (
  `ven_info_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ven_info_vendor_id` int(10) unsigned NOT NULL,
  `ven_info_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_other_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_print_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_billing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_tax_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ven_info_payment_method` int(11) DEFAULT NULL,
  `ven_info_delivery_method` int(11) DEFAULT NULL,
  `ven_info_terms` int(11) DEFAULT NULL,
  `ven_info_opening_balance` double(18,2) DEFAULT NULL,
  `ven_info_balance_date` date DEFAULT NULL,
  PRIMARY KEY (`ven_info_id`),
  KEY `tbl_vendor_other_info_ven_info_vendor_id_foreign` (`ven_info_vendor_id`),
  CONSTRAINT `tbl_vendor_other_info_ven_info_vendor_id_foreign` FOREIGN KEY (`ven_info_vendor_id`) REFERENCES `tbl_vendor` (`vendor_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vendor_other_info`
--

LOCK TABLES `tbl_vendor_other_info` WRITE;
/*!40000 ALTER TABLE `tbl_vendor_other_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_vendor_other_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_voucher`
--

DROP TABLE IF EXISTS `tbl_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_voucher` (
  `voucher_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `voucher_code_type` int(11) NOT NULL DEFAULT '0',
  `voucher_invoice_membership_id` int(11) DEFAULT NULL,
  `voucher_invoice_product_id` int(11) DEFAULT NULL,
  `voucher_slot` int(11) DEFAULT NULL,
  `voucher_customer` int(11) NOT NULL,
  `voucher_claim_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`voucher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_voucher`
--

LOCK TABLES `tbl_voucher` WRITE;
/*!40000 ALTER TABLE `tbl_voucher` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_voucher_item`
--

DROP TABLE IF EXISTS `tbl_voucher_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_voucher_item` (
  `voucher_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `voucher_item_quantity` double NOT NULL,
  PRIMARY KEY (`voucher_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_voucher_item`
--

LOCK TABLES `tbl_voucher_item` WRITE;
/*!40000 ALTER TABLE `tbl_voucher_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_voucher_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_warehouse`
--

DROP TABLE IF EXISTS `tbl_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_warehouse` (
  `warehouse_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `warehouse_shop_id` int(10) unsigned NOT NULL,
  `warehouse_created` datetime NOT NULL,
  `warehouse_last_transfer` datetime NOT NULL,
  `main_warehouse` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(4) NOT NULL DEFAULT '0',
  `warehouse_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`warehouse_id`),
  KEY `tbl_warehouse_warehouse_shop_id_foreign` (`warehouse_shop_id`),
  CONSTRAINT `tbl_warehouse_warehouse_shop_id_foreign` FOREIGN KEY (`warehouse_shop_id`) REFERENCES `tbl_shop` (`shop_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_warehouse`
--

LOCK TABLES `tbl_warehouse` WRITE;
/*!40000 ALTER TABLE `tbl_warehouse` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_warehouse_inventory`
--

DROP TABLE IF EXISTS `tbl_warehouse_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_warehouse_inventory` (
  `inventory_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inventory_item_id` int(10) unsigned NOT NULL,
  `warehouse_id` int(10) unsigned NOT NULL,
  `inventory_created` datetime NOT NULL,
  `inventory_count` int(11) NOT NULL,
  `inventory_slip_id` int(11) NOT NULL,
  PRIMARY KEY (`inventory_id`),
  KEY `tbl_warehouse_inventory_inventory_item_id_foreign` (`inventory_item_id`),
  KEY `tbl_warehouse_inventory_warehouse_id_foreign` (`warehouse_id`),
  CONSTRAINT `tbl_warehouse_inventory_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `tbl_item` (`item_id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_warehouse_inventory_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`warehouse_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_warehouse_inventory`
--

LOCK TABLES `tbl_warehouse_inventory` WRITE;
/*!40000 ALTER TABLE `tbl_warehouse_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_warehouse_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `view_product_variant`
--

DROP TABLE IF EXISTS `view_product_variant`;
/*!50001 DROP VIEW IF EXISTS `view_product_variant`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_product_variant` (
  `eprod_id` tinyint NOT NULL,
  `evariant_id` tinyint NOT NULL,
  `variant_name` tinyint NOT NULL,
  `evariant_item_id` tinyint NOT NULL,
  `evariant_item_label` tinyint NOT NULL,
  `evariant_description` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_variant_option`
--

DROP TABLE IF EXISTS `view_variant_option`;
/*!50001 DROP VIEW IF EXISTS `view_variant_option`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_variant_option` (
  `eprod_id` tinyint NOT NULL,
  `option_name` tinyint NOT NULL,
  `alias` tinyint NOT NULL,
  `variant_value` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_product_variant`
--

/*!50001 DROP TABLE IF EXISTS `view_product_variant`*/;
/*!50001 DROP VIEW IF EXISTS `view_product_variant`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_product_variant` AS select `product`.`eprod_id` AS `eprod_id`,`variant`.`evariant_id` AS `evariant_id`,group_concat(`op_value`.`option_value` order by `var_name`.`variant_name_order` ASC separator ' • ') AS `variant_name`,`variant`.`evariant_item_id` AS `evariant_item_id`,`variant`.`evariant_item_label` AS `evariant_item_label`,`variant`.`evariant_description` AS `evariant_description` from ((((`tbl_ec_product` `product` join `tbl_ec_variant` `variant` on((`product`.`eprod_id` = `variant`.`evariant_prod_id`))) left join `tbl_variant_name` `var_name` on((`variant`.`evariant_id` = `var_name`.`variant_id`))) left join `tbl_option_name` `op_name` on((`var_name`.`option_name_id` = `op_name`.`option_name_id`))) left join `tbl_option_value` `op_value` on((`var_name`.`option_value_id` = `op_value`.`option_value_id`))) group by `variant`.`evariant_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_variant_option`
--

/*!50001 DROP TABLE IF EXISTS `view_variant_option`*/;
/*!50001 DROP VIEW IF EXISTS `view_variant_option`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_variant_option` AS select `product`.`eprod_id` AS `eprod_id`,`op_name`.`option_name` AS `option_name`,concat(`product`.`eprod_id`,'-',`op_name`.`option_name`) AS `alias`,group_concat(distinct `op_value`.`option_value` order by `var_name`.`variant_name_order` ASC separator ',') AS `variant_value` from ((((`tbl_ec_product` `product` join `tbl_ec_variant` `variant` on((`product`.`eprod_id` = `variant`.`evariant_prod_id`))) join `tbl_variant_name` `var_name` on((`variant`.`evariant_id` = `var_name`.`variant_id`))) join `tbl_option_name` `op_name` on((`var_name`.`option_name_id` = `op_name`.`option_name_id`))) join `tbl_option_value` `op_value` on((`var_name`.`option_value_id` = `op_value`.`option_value_id`))) group by concat(`product`.`eprod_id`,'-',`op_name`.`option_name`) order by `var_name`.`variant_name_order` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-12  9:46:51
