<?php
namespace App\Globals;
use Session;
use DB;
use App\Globals\Seed;
use App\Models\Tbl_user;
use App\Models\Tbl_email_content;
use App\Models\Tbl_email_template;
use Carbon\Carbon;
class Seed
{
    public static function auto_seed()
    {
        if(!DB::table("tbl_chart_account_type")->first())
        {
          Seed::seed_tbl_chart_account_type();
        }
        if(!DB::table("tbl_default_chart_account")->first())
        {
          Seed::seed_tbl_default_chart_account();
        }
        if(!DB::table("tbl_user_position")->first())
        {
          Seed::seed_tbl_user_position();
        }
        if(!DB::table("tbl_item_type")->first())
        {
          Seed::seed_tbl_item_type();
        }
        if(!DB::table("tbl_online_pymnt_method")->first())
        {
          Seed::seed_tbl_online_pymnt_method();
        }
        if(!DB::table("tbl_online_pymnt_gateway")->first())
        {
          Seed::seed_tbl_online_pymnt_gateway();
        }
        Seed::seed_email_default();
    }
    //luke
    public static function seed_email_default()
    {
        $shop_id = Seed::getShopId();
        $date_created = Carbon::now();
        $date_updated = Carbon::now();
        $email[0]['email_content_key'] = 'success_register';
        $email[0]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully completed yourPhilTECH registration made under the name [name_of_registrant] with TIN [tin_of_registrant] . Your PhilTECH Username is [user_name] .</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">To start accessing our E-commerce website, log-in with your PhilTECH Username and Password. Please click on the link provided below. If clicking the link does not seem to work, you can copy and paste the link into your browser&rsquo;s address window.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">philtechglobalinc.com/mlm</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[0]['email_content_subject'] = 'Successful Registration';
        $email[0]['shop_id'] = $shop_id;
        $email[0]['date_created'] = $date_created;
        $email[0]['date_updated'] = $date_updated;
        $email[0]['archived'] = 0;

        $email[1]['email_content_key'] = 'membership_code_purchase';
        $email[1]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully purchased a [membership_name] Membership Package. Your Membership Code is/are:</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">[membership_code]</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">As a PhilTECH VIP, you are entitled to Lifetime Privileges and Benefits exclusively designed for our VIPs. Experience shopping convenience like never before with our E-Commerce System. Enjoy Discounts and Earn Cashback + Rewards Points with every purchase on all products of the company. Just present your PhilTECH VIP Card during payment and all these exciting benefits will be yours.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit us at our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Congratulations!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[1]['email_content_subject'] = 'Membership Code Purchase';
        $email[1]['shop_id'] = $shop_id;
        $email[1]['date_created'] = $date_created;
        $email[1]['date_updated'] = $date_updated;
        $email[1]['archived'] = 0;

        $email[2]['email_content_key'] = 'discount_card_purchase';
        $email[2]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully purchased a PhilTECH [membership_name]&nbsp;from [sponsor] Please read important details below:</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Date Issued:&nbsp;[date_issued]</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Date of Expiry: [date_expiry]</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You may now enjoy a full year of Discount Privilege with every purchase on all products of the company by simply presenting your Discount Card during payment.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit us at our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Congratulations!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Sincerely,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[2]['email_content_subject'] = 'Discount Card Purchase';
        $email[2]['shop_id'] = $shop_id;
        $email[2]['date_created'] = $date_created;
        $email[2]['date_updated'] = $date_updated;
        $email[2]['archived'] = 0;

        $email[3]['email_content_key'] = 'e_wallet_transfer';
        $email[3]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Greetings!</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>&nbsp;</strong></p>
<div style="mso-element: para-border-div; border: none; border-bottom: solid windowtext 1.0pt; mso-border-bottom-alt: solid windowtext .75pt; padding: 0in 0in 1.0pt 0in;">
<p class="MsoNormal" style="margin-bottom: .0001pt; border: none; mso-border-bottom-alt: solid windowtext .75pt; padding: 0in; mso-padding-alt: 0in 0in 1.0pt 0in;"><strong>Thank you for using E-wallet money transfer. We have successfully processed your transfer request.&nbsp; Transaction details are as follows;</strong></p>
</div>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>&nbsp;</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Transaction #: [transaction_id]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Transaction Date: [transaction_date]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Amount transferred: [amount]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>E-wallet Recipient: [sponsor]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>E-wallet Transfer Fee: [fee]</strong></p>
<div style="mso-element: para-border-div; border: none; border-bottom: solid windowtext 1.0pt; mso-border-bottom-alt: solid windowtext .75pt; padding: 0in 0in 1.0pt 0in;">
<p class="MsoNormal" style="margin-bottom: .0001pt; border: none; mso-border-bottom-alt: solid windowtext .75pt; padding: 0in; mso-padding-alt: 0in 0in 1.0pt 0in;"><strong>Total Amount charged on E-wallet: [amount_plus_fee]</strong></p>
</div>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>&nbsp;</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>If there is a problem with executing your request, please call us at 0917-542-2614 (Globe Mobile) or at (062) 310-2256 (Globe Landline). You can always check your transfer status on the Account Dashboard. Just click the link below:</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>(link to account dashboard)</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>&nbsp;</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Best Regards,</strong></p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>PhilTech Admin Team</strong></p>';
        $email[3]['email_content_subject'] = 'E-wallet Transfer';
        $email[3]['shop_id'] = $shop_id;
        $email[3]['date_created'] = $date_created;
        $email[3]['date_updated'] = $date_updated;
        $email[3]['archived'] = 0;

        $email[4]['email_content_key'] = 'merchant_registration';
        $email[4]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully registered as a PhilTECH Merchant under the company name [business_name]&nbsp;with Mr./Ms. [name_of_merchant]&nbsp; as your representative. Your PhilTECH Username is [username].</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">To start registering your products and services through our Merchant Module System, log-in with your PhilTECH Username and Password. Please click on the link provided below. If clicking the link does not seem to work, you can copy and paste the link into your browser&rsquo;s address window.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">(Link to PhilTECH&rsquo;s Merchant Module System log-in page)</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[4]['email_content_subject'] = 'Merchant Registration';
        $email[4]['shop_id'] = $shop_id;
        $email[4]['date_created'] = $date_created;
        $email[4]['date_updated'] = $date_updated;
        $email[4]['archived'] = 0;


        $email[5]['email_content_key'] = 'merchant_product_registration';
        $email[5]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully registered your product through the Merchant Module System. Please be advised that processing time is 1-3 working days before your products/services get uploaded to the PhilTECH website. This is to ensure that the company&rsquo;s set standards are being followed at all times.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">These are the list of all the registered product:</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">[products]&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[5]['email_content_subject'] = 'Product Registration';
        $email[5]['shop_id'] = $shop_id;
        $email[5]['date_created'] = $date_created;
        $email[5]['date_updated'] = $date_updated;
        $email[5]['archived'] = 0;

        $email[6]['email_content_key'] = 'e_wallet_refill';
        $email[6]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt;">&nbsp;</p>
<div style="mso-element: para-border-div; border: none; border-bottom: solid windowtext 1.0pt; mso-border-bottom-alt: solid windowtext .75pt; padding: 0in 0in 1.0pt 0in;">
<p class="MsoNormal" style="margin-bottom: .0001pt; border: none; mso-border-bottom-alt: solid windowtext .75pt; padding: 0in; mso-padding-alt: 0in 0in 1.0pt 0in;">We are pleased to inform you that we have already received your payment and had successfully processed your E-wallet funds replenishment request. Transaction details are as follows;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; border: none; mso-border-bottom-alt: solid windowtext .75pt; padding: 0in; mso-padding-alt: 0in 0in 1.0pt 0in;">&nbsp;</p>
</div>
<p class="MsoNormal" style="margin-bottom: .0001pt;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Transaction #: [transaction_number]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Transaction Date: [transaction_date]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>Amount transferred: [amount]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>E-wallet Recipient: [sponsor]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;"><strong>E-wallet Transfer Fee: [fee]</strong></p>
<p class="MsoNormal" style="margin-bottom: .0001pt;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt;">You may now enjoy using your E-wallet funds for any of your purchases. To check your new E-wallet balance, simply click the link provided below;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt;">(link to e-wallet page)</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[6]['email_content_subject'] = 'E-wallet Refill';
        $email[6]['shop_id'] = $shop_id;
        $email[6]['date_created'] = $date_created;
        $email[6]['date_updated'] = $date_updated;
        $email[6]['archived'] = 0;

        $email[7]['email_content_key'] = 'inquire_current_points';
        $email[7]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Your current available points are [current_points] . Please be reminded that points may only be redeemed thru items and cannot be converted to cash.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[7]['email_content_subject'] = 'Inquire Current Points';
        $email[7]['shop_id'] = $shop_id;
        $email[7]['date_created'] = $date_created;
        $email[7]['date_updated'] = $date_updated;
        $email[7]['archived'] = 0;

        $email[8]['email_content_key'] = 'redeem_points';
        $email[8]['email_content'] = '<p>&nbsp;<span style="text-align: justify;">Greetings!</span></p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully redeemed <u>[points]</u>. You may claim your <u>[item_redeem]</u>&nbsp;at any BCO branch Nationwide. Please present your VIP Card and any valid ID when claiming.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>';
        $email[8]['email_content_subject'] = 'Redeem Points';
        $email[8]['shop_id'] = $shop_id;
        $email[8]['date_created'] = $date_created;
        $email[8]['date_updated'] = $date_updated;
        $email[8]['archived'] = 0;

        $email[9]['email_content_key'] = 'pass_word_reset';
        $email[9]['email_content'] = '<p>Greetings!</p>
<p>&nbsp; &nbsp;We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise you can reset your password using this link</p>
<p>&nbsp;[password_reset_link]<br /><br /></p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline), <a href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a> (Email), or you may visit our Main Office located at PhilTECH Bldg. (2<sup>nd</sup> Level), Gallera Road, Guiwan, Zamboanga City.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Best Regards,</p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;"><strong>The PhilTECH Admin Team</strong></p>
<p>&nbsp;</p>';
        $email[9]['email_content_subject'] = 'Password Reset';
        $email[9]['shop_id'] = $shop_id;
        $email[9]['date_created'] = $date_created;
        $email[9]['date_updated'] = $date_updated;
        $email[9]['archived'] = 0;

        foreach ($email as $key => $value) 
        {
            $count = Tbl_email_content::where('shop_id', $value['shop_id'])->where('email_content_key', $value['email_content_key'])->count();
            if($count == 0)
            {
                Tbl_email_content::insert($value);  
            }
        }
        $count_header = Tbl_email_template::where('shop_id', $shop_id)->count();
        if($count_header == 0)
        {
            $insert['shop_id'] = $shop_id;
            $insert['header_image'] = '/assets/card/images/philtech-logo-blue-2.png';
            $insert['header_txt'] = '';
            $insert['header_background_color'] = '#0080ff';
            $insert['footer_txt']= '<h2 style="text-align: center;"><span style="text-align: justify;">For inquiries, please feel free to contact us at (0917) 542-2614 (Globe Mobile), (062) 310-2256 (Globe Landline),&nbsp;</span><a style="text-align: justify;" href="mailto:philtechglobalmainoffice@gmail.com">philtechglobalmainoffice@gmail.com</a><span style="text-align: justify;">&nbsp;(Email), or you may visit our Main Office located at PhilTECH Bldg. (2</span><sup style="text-align: justify;">nd</sup><span style="text-align: justify;">&nbsp;Level), Gallera Road, Guiwan, Zamboanga City.</span></h2>';
            $insert['footer_background_color']= '#0080ff';
            $insert['footer_text_color'] ='#ffffff';
            $insert['header_text_color'] = '#ffffff';
            Tbl_email_template::insert($insert);
        }
    }
    //endluke
    public static function getShopId()
    {
      return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public static function seed_tbl_user_position()
    {

      $insert[0]['position_shop_id']  = '0';
      $insert[0]['position_name']     = 'developer';
      $insert[0]['position_rank']     = '0';

      DB::table('tbl_user_position')->insert($insert);
    }
    
    public static function seed_tbl_chart_account_type()
    {
        $insert[1]['chart_type_name']           = "Bank"; 
        $insert[1]['chart_type_description']    = '<p>Create one for each cash account, such as:<br /><br /></p>
                                                <p style="padding-left: 30px;">&bull; Petty cash</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Savings</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Checking</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;"><span style="font-size: 12.96px;">&bull; Money market</p>'; 
        $insert[1]['has_open_balance']          = "1"; 
        $insert[1]['chart_type_category']       = "";
        $insert[1]['normal_balance']            = "debit"; 
        
        $insert[2]['chart_type_name']           = "Accounts Receivable"; 
        $insert[2]['chart_type_description']    = '<p>Tracks money your customers owe you on unpaid incvoices</p>
                                                <p>&nbsp;</p>
                                                <p>Most business require only the A/R account that the system automatically creates.</p>';
        $insert[2]['has_open_balance']          = "0"; 
        $insert[2]['chart_type_category']       = "";
        $insert[2]['normal_balance']            = "debit"; 
        
        $insert[3]['chart_type_name']           = "Other Current Asset"; 
        $insert[3]['chart_type_description']    = '<p><span>Tracks the value of things that can be converted to cash or used up within one year, such as:</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Prepaid expenses</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Employee cash advances</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Inventory</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Loans from your business</p>';
        $insert[3]['has_open_balance']          = "0"; 
        $insert[3]['chart_type_category']       = "";
        $insert[3]['normal_balance']            = "debit";
        
        $insert[4]['chart_type_name']           = "Fixed Asset"; 
        $insert[4]['chart_type_description']    = '<p>Tracks the value of significant items* that have a useful life of more than one yeat, such us:<br /><br /></p>
                                                <p style="padding-left: 30px;">&bull; Buildings</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Land</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Machinery and equipment</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;"><span style="font-size: 12.96px;">&bull; Vehicles</p>
                                                <p><span style="font-size: 12.96px;"><span style="font-size: 12.96px;">*Consult your tax professional for a minimum amount.</p></br>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&nbsp;</p></br>
                                                <p style="padding-left: 30px;">&nbsp;</p>';
        $insert[4]['has_open_balance']          = "0"; 
        $insert[4]['chart_type_category']       = "";
        $insert[4]['normal_balance']            = "debit";
        
        $insert[5]['chart_type_name']           = "Other Asset"; 
        $insert[5]['chart_type_description']    = '<p>Tracks the value of things that are neither Fixed Assets nor Other Current Assets, such as:</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Goodwill</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Long-term notes receivable</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull;Security desposit paid</p>';
        $insert[5]['has_open_balance']          = "0"; 
        $insert[5]['chart_type_category']       = "";
        $insert[5]['normal_balance']            = "debit";
        
        $insert[6]['chart_type_name']           = "Accounts Payable"; 
        $insert[6]['chart_type_description']    = '<p>Tracks money your&nbsp;owe to vendors for purchase made on credit.</p></br>
                                                <p>&nbsp;</p></br>
                                                <p>Most business require only the A/P account that the system automatically creates.</p>';
        $insert[6]['has_open_balance']          = ""; 
        $insert[6]['chart_type_category']       = "";
        $insert[6]['normal_balance']            = "credit";
        
        $insert[7]['chart_type_name']           = "Credit Card"; 
        $insert[7]['chart_type_description']    = '<p>Create one for each credit card your business uses.</p>';
        $insert[7]['has_open_balance']          = "0"; 
        $insert[7]['chart_type_category']       = "";
        $insert[7]['normal_balance']            = "credit";
        
        $insert[8]['chart_type_name']           = "Other Current Liability"; 
        $insert[8]['chart_type_description']    = '<p>Tracks money your business owes and expect to pay within one year, such as:</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Sales tax</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Security deposit/retainers from customers</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Payroll taxes</p>';
        $insert[8]['has_open_balance']          = "0"; 
        $insert[8]['chart_type_category']       = "";
        $insert[8]['normal_balance']            = "credit";
        
        $insert[9]['chart_type_name']           = "Long Term Liability"; 
        $insert[9]['chart_type_description']    = '<p>Tracks money your business owes and expect to pay back over more than one year, such as:</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Mortgages</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Longtem loans</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Notes payable</p>';
        $insert[9]['has_open_balance']          = "0";
        $insert[9]['chart_type_category']       = "";
        $insert[9]['normal_balance']            = "credit";
        
        $insert[10]['chart_type_name']          = "Equity"; 
        $insert[10]['chart_type_description']   = '<p>Track money invested in, or money taken out of the business by owners or shareholders. Payroll and&nbsp;</p></br>
                                                <p>reimbursable expenses should not be included</p>';
        $insert[10]['has_open_balance']         = "0";
        $insert[10]['chart_type_category']      = "";
        $insert[10]['normal_balance']            = "credit";
        
        $insert[11]['chart_type_name']          = "Income"; 
        $insert[11]['chart_type_description']   = '<p>Categorizes money earned from normal business operations, such as:<br /><br /></p></br>
                                                <p style="padding-left: 30px;">&bull; Product sales</p></br>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Service sales</p></br>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Discount to customers</p></br>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&nbsp;</p></br>
                                                <p style="padding-left: 30px;">&nbsp;</p>';
        $insert[11]['has_open_balance']         = "0"; 
        $insert[11]['chart_type_category']      = "";
        $insert[11]['normal_balance']           = "credit";
        
        $insert[12]['chart_type_name']          = "Cost of Goods Sold"; 
        $insert[12]['chart_type_description']   = '<p>Tracks the direct costs to produce the items that your business sells, such as:</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Cost of materials</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Cost of labor</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Shipping, freight and delivery</p></br>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;"><span style="font-size: 12.96px;">&bull; Subcontractors</p>';
        $insert[12]['has_open_balance']         = "0"; 
        $insert[12]['chart_type_category']      = "";
        $insert[12]['normal_balance']           = "debit";
        
        $insert[13]['chart_type_name']          = "Expense"; 
        $insert[13]['chart_type_description']   = '<p>Categorizes money spent in the course of normal business operations, such us:<br /><br /></p>
                                                <p style="padding-left: 30px;">&bull; Advertising and promotion</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Office supplies</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&bull; Insurance</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;"><span style="font-size: 12.96px;">&bull; Legal fees</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;"><span style="font-size: 12.96px;">&bull; Charitable contributions</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;"><span style="font-size: 12.96px;">&bull; Rent</p>
                                                <p style="padding-left: 30px;"><span style="font-size: 12.96px;">&nbsp;</p>
                                                <p style="padding-left: 30px;">&nbsp;</p>';
        $insert[13]['has_open_balance']         = "0"; 
        $insert[13]['chart_type_category']      = "";
        $insert[13]['normal_balance']           = "debit";
        
        $insert[14]['chart_type_name']          = "Other Income"; 
        $insert[14]['chart_type_description']   = '<p>Categorizes the money that your business earns that is unrelated to normal business operations, such as:<br /></p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Dividend income</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; interest income</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Insurance reimbursements</p>';
        $insert[14]['has_open_balance']         = "0"; 
        $insert[14]['chart_type_category']      = "";
        $insert[14]['normal_balance']           = "credit";
        
        $insert[15]['chart_type_name']          = "Other Expense"; 
        $insert[15]['chart_type_description']   = '<p>Categorizes the money that your business spends that is unrelated to normal business operations, such as:<br /></p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Corporation taxes</p>
                                                <p style="padding-left: 30px;"><span style="white-space: pre; background-color: #f5f5f5;">&bull; Penalties and legal settlements</p>';
        $insert[15]['has_open_balance']         = "0"; 
        $insert[15]['chart_type_category']      = "";
        $insert[15]['normal_balance']           = "debit";
        
        DB::table("tbl_chart_account_type")->insert($insert);
    }
    
    public static function seed_tbl_default_chart_account()
    {
       $insert[1]['default_id']                 = ""; 
       $insert[1]['default_type_id']            = "2";    
       $insert[1]['default_number']             = "11000";
       $insert[1]['default_name']               = "Accounts Receivable";
       $insert[1]['default_description']        = "Unpaid or unapplied customer invoices and credits";            
       $insert[1]['default_parent_id']          = "";             
       $insert[1]['default_sublevel']           = "";   
       $insert[1]['default_balance']            = "";
       $insert[1]['default_open_balance']       = "";
       $insert[1]['default_open_balance_date']  = "";
       $insert[1]['is_tax_account']             = "";
       $insert[1]['account_tax_code_id']        = "";
       $insert[1]['default_for_code']           = "";

       $insert[2]['default_id']                 = ""; 
       $insert[2]['default_type_id']            = "3";    
       $insert[2]['default_number']             = "22000";
       $insert[2]['default_name']               = "Undeposited Funds";
       $insert[2]['default_description']        = "Funds received, but not yet deposited to a bank account";            
       $insert[2]['default_parent_id']          = "";             
       $insert[2]['default_sublevel']           = "";   
       $insert[2]['default_balance']            = "";
       $insert[2]['default_open_balance']       = "";
       $insert[2]['default_open_balance_date']  = "";
       $insert[2]['is_tax_account']             = "";
       $insert[2]['account_tax_code_id']        = "";
       $insert[2]['default_for_code']           = "";

       $insert[3]['default_id']                 = ""; 
       $insert[3]['default_type_id']            = "3";    
       $insert[3]['default_number']             = "12100";
       $insert[3]['default_name']               = "Inventory Asset";
       $insert[3]['default_description']        = "Costs of inventory purchased for resale";            
       $insert[3]['default_parent_id']          = "";             
       $insert[3]['default_sublevel']           = "";   
       $insert[3]['default_balance']            = "";
       $insert[3]['default_open_balance']       = "";
       $insert[3]['default_open_balance_date']  = "";
       $insert[3]['is_tax_account']             = "";
       $insert[3]['account_tax_code_id']        = "";
       $insert[3]['default_for_code']           = "";

       $insert[4]['default_id']                 = ""; 
       $insert[4]['default_type_id']            = "4";      
       $insert[4]['default_number']             = "17000";
       $insert[4]['default_name']               = "Accumulated Depreciation";
       $insert[4]['default_description']        = "Accumulated depreciation on equipment, buildings and improvements";              
       $insert[4]['default_parent_id']          = "";               
       $insert[4]['default_sublevel']           = "";   
       $insert[4]['default_balance']            = "";
       $insert[4]['default_open_balance']       = "";
       $insert[4]['default_open_balance_date']  = "";
       $insert[4]['is_tax_account']             = "";
       $insert[4]['account_tax_code_id']        = "";
       $insert[4]['default_for_code']           = "";
       
       $insert[5]['default_id']                 = ""; 
       $insert[5]['default_type_id']            = "4";      
       $insert[5]['default_number']             = "15000";
       $insert[5]['default_name']               = "Furniture and Equipment";
       $insert[5]['default_description']        = "Furniture and equipment with useful life exceeding one year";            
       $insert[5]['default_parent_id']          = "";               
       $insert[5]['default_sublevel']           = "";   
       $insert[5]['default_balance']            = "";
       $insert[5]['default_open_balance']       = "";
       $insert[5]['default_open_balance_date']  = "";
       $insert[5]['is_tax_account']             = "";
       $insert[5]['account_tax_code_id']        = "";
       $insert[5]['default_for_code']           = "";

       $insert[6]['default_id']                 = ""; 
       $insert[6]['default_type_id']            = "6";    
       $insert[6]['default_number']             = "60000";
       $insert[6]['default_name']               = "Accounts Payable";
       $insert[6]['default_description']        = "Unpaid or unapplied vendor bills or credits";            
       $insert[6]['default_parent_id']          = "";             
       $insert[6]['default_sublevel']           = "";   
       $insert[6]['default_balance']            = "";
       $insert[6]['default_open_balance']       = "";
       $insert[6]['default_open_balance_date']  = "";
       $insert[6]['is_tax_account']             = "";
       $insert[6]['account_tax_code_id']        = "";
       $insert[6]['default_for_code']           = "";
       
       $insert[7]['default_id']                 = ""; 
       $insert[7]['default_type_id']            = "8";      
       $insert[7]['default_number']             = "24000";
       $insert[7]['default_name']               = "Payroll Liabilities";
       $insert[7]['default_description']        = "Unpaid payroll liabilities. Amounts withheld or accrued, but not yet paid";              
       $insert[7]['default_parent_id']          = "";               
       $insert[7]['default_sublevel']           = "";   
       $insert[7]['default_balance']            = "";
       $insert[7]['default_open_balance']       = "";
       $insert[7]['default_open_balance_date']  = "";
       $insert[7]['is_tax_account']             = "";
       $insert[7]['account_tax_code_id']        = "";
       $insert[7]['default_for_code']           = "";
       
       $insert[8]['default_id']                 = ""; 
       $insert[8]['default_type_id']            = "10";     
       $insert[8]['default_number']             = "80100";
       $insert[8]['default_name']               = "Capital Stock";
       $insert[8]['default_description']        = "Value of corporate stock";               
       $insert[8]['default_parent_id']          = "";               
       $insert[8]['default_sublevel']           = "";   
       $insert[8]['default_balance']            = "";
       $insert[8]['default_open_balance']       = "";
       $insert[8]['default_open_balance_date']  = "";
       $insert[8]['is_tax_account']             = "";
       $insert[8]['account_tax_code_id']        = "";
       $insert[8]['default_for_code']           = "";
       
       $insert[9]['default_id']                 = ""; 
       $insert[9]['default_type_id']            = "10";     
       $insert[9]['default_number']             = "30200";
       $insert[9]['default_name']               = "Dividends Paid";
       $insert[9]['default_description']        = "Dividends to shareholders";              
       $insert[9]['default_parent_id']          = "";               
       $insert[9]['default_sublevel']           = "";   
       $insert[9]['default_balance']            = "";
       $insert[9]['default_open_balance']       = "";
       $insert[9]['default_open_balance_date']  = "";
       $insert[9]['is_tax_account']             = "";
       $insert[9]['account_tax_code_id']        = "";
       $insert[9]['default_for_code']           = "";
       
       $insert[10]['default_id']                 = ""; 
       $insert[10]['default_type_id']            = "10";    
       $insert[10]['default_number']             = "30000";
       $insert[10]['default_name']               = "Opening Balance Equity";
       $insert[10]['default_description']        = "Opening balances during setup post to this account. The balance of this account should be zero after...";               
       $insert[10]['default_parent_id']          = "";              
       $insert[10]['default_sublevel']           = "";   
       $insert[10]['default_balance']            = "";
       $insert[10]['default_open_balance']       = "";
       $insert[10]['default_open_balance_date']  = "";
       $insert[10]['is_tax_account']             = "";
       $insert[10]['account_tax_code_id']        = "";
       $insert[10]['default_for_code']           = "";
       
       $insert[11]['default_id']                 = ""; 
       $insert[11]['default_type_id']            = "11";    
       $insert[11]['default_number']             = "411900";
       $insert[11]['default_name']               = "Sales";
       $insert[11]['default_description']        = "Gross receipts from sales";             
       $insert[11]['default_parent_id']          = "";              
       $insert[11]['default_sublevel']           = "";   
       $insert[11]['default_balance']            = "";
       $insert[11]['default_open_balance']       = "";
       $insert[11]['default_open_balance_date']  = "";
       $insert[11]['is_tax_account']             = "";
       $insert[11]['account_tax_code_id']        = "";
       $insert[11]['default_for_code']           = "";
       
       $insert[12]['default_id']                 = ""; 
       $insert[12]['default_type_id']            = "11";    
       $insert[12]['default_number']             = "412900";
       $insert[12]['default_name']               = "Shipping and Delivery Income";
       $insert[12]['default_description']        = "Shipping charges charged to customers";             
       $insert[12]['default_parent_id']          = "";              
       $insert[12]['default_sublevel']           = "";   
       $insert[12]['default_balance']            = "";
       $insert[12]['default_open_balance']       = "";
       $insert[12]['default_open_balance_date']  = "";
       $insert[12]['is_tax_account']             = "";
       $insert[12]['account_tax_code_id']        = "";
       $insert[12]['default_for_code']           = "";
       
       $insert[13]['default_id']                 = ""; 
       $insert[13]['default_type_id']            = "12";    
       $insert[13]['default_number']             = "51100";
       $insert[13]['default_name']               = "Freight and Shipping Costs";
       $insert[13]['default_description']        = "Freight-in and shipping costs for delivery to customers";               
       $insert[13]['default_parent_id']          = "";              
       $insert[13]['default_sublevel']           = "";   
       $insert[13]['default_balance']            = "";
       $insert[13]['default_open_balance']       = "";
       $insert[13]['default_open_balance_date']  = "";
       $insert[13]['is_tax_account']             = "";
       $insert[13]['account_tax_code_id']        = "";
       $insert[13]['default_for_code']           = "";
       
       $insert[14]['default_id']                 = ""; 
       $insert[14]['default_type_id']            = "12";    
       $insert[14]['default_number']             = "51800";
       $insert[14]['default_name']               = "Merchant Account Fees";
       $insert[14]['default_description']        = "Credit card merchant account discount fees, transaction fees, and related costs";               
       $insert[14]['default_parent_id']          = "";              
       $insert[14]['default_sublevel']           = "";   
       $insert[14]['default_balance']            = "";
       $insert[14]['default_open_balance']       = "";
       $insert[14]['default_open_balance_date']  = "";
       $insert[14]['is_tax_account']             = "";
       $insert[14]['account_tax_code_id']        = "";
       $insert[14]['default_for_code']           = "";
       
       $insert[15]['default_id']                 = ""; 
       $insert[15]['default_type_id']            = "12";    
       $insert[15]['default_number']             = "52300";
       $insert[15]['default_name']               = "Product Samples Expense";
       $insert[15]['default_description']        = "Cost of products used as floor samples or given to customers for trial or demonstration";               
       $insert[15]['default_parent_id']          = "";              
       $insert[15]['default_sublevel']           = "";   
       $insert[15]['default_balance']            = "";
       $insert[15]['default_open_balance']       = "";
       $insert[15]['default_open_balance_date']  = "";
       $insert[15]['is_tax_account']             = "";
       $insert[15]['account_tax_code_id']        = "";
       $insert[15]['default_for_code']           = "";
       
       $insert[16]['default_id']                 = ""; 
       $insert[16]['default_type_id']            = "12";    
       $insert[16]['default_number']             = "52900";
       $insert[16]['default_name']               = "Purchases - Resale Items";
       $insert[16]['default_description']        = "Purchases of items for resale that are not tracked or counted in inventory";            
       $insert[16]['default_parent_id']          = "";              
       $insert[16]['default_sublevel']           = "";   
       $insert[16]['default_balance']            = "";
       $insert[16]['default_open_balance']       = "";
       $insert[16]['default_open_balance_date']  = "";
       $insert[16]['is_tax_account']             = "";
       $insert[16]['account_tax_code_id']        = "";
       $insert[16]['default_for_code']           = "";
       
       $insert[17]['default_id']                 = ""; 
       $insert[17]['default_type_id']            = "13";    
       $insert[17]['default_number']             = "60000";
       $insert[17]['default_name']               = "Advertising and Promotion";
       $insert[17]['default_description']        = "Advertising, marketing, graphic design, and other promotional expenses";            
       $insert[17]['default_parent_id']          = "";              
       $insert[17]['default_sublevel']           = "";   
       $insert[17]['default_balance']            = "";
       $insert[17]['default_open_balance']       = "";
       $insert[17]['default_open_balance_date']  = "";
       $insert[17]['is_tax_account']             = "";
       $insert[17]['account_tax_code_id']        = "";
       $insert[17]['default_for_code']           = "";
       
       $insert[18]['default_id']                 = ""; 
       $insert[18]['default_type_id']            = "13";    
       $insert[18]['default_number']             = "60200";
       $insert[18]['default_name']               = "Automobile Expense";
       $insert[18]['default_description']        = "Fuel, oil, repairs, and other automobile maintenance for business autos";               
       $insert[18]['default_parent_id']          = "";              
       $insert[18]['default_sublevel']           = "";   
       $insert[18]['default_balance']            = "";
       $insert[18]['default_open_balance']       = "";
       $insert[18]['default_open_balance_date']  = "";
       $insert[18]['is_tax_account']             = "";
       $insert[18]['account_tax_code_id']        = "";
       $insert[18]['default_for_code']           = "";
       
       $insert[19]['default_id']                 = ""; 
       $insert[19]['default_type_id']            = "13";    
       $insert[19]['default_number']             = "60400";
       $insert[19]['default_name']               = "Bank Service Charges";
       $insert[19]['default_description']        = "Bank account service fees, bad check charges and other bank fees";              
       $insert[19]['default_parent_id']          = "";              
       $insert[19]['default_sublevel']           = "";   
       $insert[19]['default_balance']            = "";
       $insert[19]['default_open_balance']       = "";
       $insert[19]['default_open_balance_date']  = "";
       $insert[19]['is_tax_account']             = "";
       $insert[19]['account_tax_code_id']        = "";
       $insert[19]['default_for_code']           = "";
       
       $insert[20]['default_id']                 = ""; 
       $insert[20]['default_type_id']            = "13";    
       $insert[20]['default_number']             = "61700";
       $insert[20]['default_name']               = "Computer and Internet Expenses";
       $insert[20]['default_description']        = "Computer supplies, off-the-shelf software, online fees, and other computer or internet related expen...";               
       $insert[20]['default_parent_id']          = "";              
       $insert[20]['default_sublevel']           = "";   
       $insert[20]['default_balance']            = "";
       $insert[20]['default_open_balance']       = "";
       $insert[20]['default_open_balance_date']  = "";
       $insert[20]['is_tax_account']             = "";
       $insert[20]['account_tax_code_id']        = "";
       $insert[20]['default_for_code']           = "";
       
       $insert[21]['default_id']                 = ""; 
       $insert[21]['default_type_id']            = "13";    
       $insert[21]['default_number']             = "62400";
       $insert[21]['default_name']               = "Depreciation Expense";
       $insert[21]['default_description']        = "Depreciation on equipment, buildings and improvements";             
       $insert[21]['default_parent_id']          = "";              
       $insert[21]['default_sublevel']           = "";   
       $insert[21]['default_balance']            = "";
       $insert[21]['default_open_balance']       = "";
       $insert[21]['default_open_balance_date']  = "";
       $insert[21]['is_tax_account']             = "";
       $insert[21]['account_tax_code_id']        = "";
       $insert[21]['default_for_code']           = "";
       
       $insert[22]['default_id']                 = ""; 
       $insert[22]['default_type_id']            = "13";    
       $insert[22]['default_number']             = "62500";
       $insert[22]['default_name']               = "Dues and Subscriptions";
       $insert[22]['default_description']        = "Subscriptions and membership dues for civic, service, professional, trade organizations";               
       $insert[22]['default_parent_id']          = "";              
       $insert[22]['default_sublevel']           = "";   
       $insert[22]['default_balance']            = "";
       $insert[22]['default_open_balance']       = "";
       $insert[22]['default_open_balance_date']  = "";
       $insert[22]['is_tax_account']             = "";
       $insert[22]['account_tax_code_id']        = "";
       $insert[22]['default_for_code']           = "";
       
       $insert[23]['default_id']                 = ""; 
       $insert[23]['default_type_id']            = "13";    
       $insert[23]['default_number']             = "63300";
       $insert[23]['default_name']               = "Insurance Expense";
       $insert[23]['default_description']        = "Insurance expenses";            
       $insert[23]['default_parent_id']          = "";              
       $insert[23]['default_sublevel']           = "";   
       $insert[23]['default_balance']            = "";
       $insert[23]['default_open_balance']       = "";
       $insert[23]['default_open_balance_date']  = "";
       $insert[23]['is_tax_account']             = "";
       $insert[23]['account_tax_code_id']        = "";
       $insert[23]['default_for_code']           = "";
       
       $insert[24]['default_id']                 = ""; 
       $insert[24]['default_type_id']            = "13";    
       $insert[24]['default_number']             = "63400";
       $insert[24]['default_name']               = "Interest Expense";
       $insert[24]['default_description']        = "Interest payments on business loans, credit card balances, or other business debt";             
       $insert[24]['default_parent_id']          = "";              
       $insert[24]['default_sublevel']           = "";   
       $insert[24]['default_balance']            = "";
       $insert[24]['default_open_balance']       = "";
       $insert[24]['default_open_balance_date']  = "";
       $insert[24]['is_tax_account']             = "";
       $insert[24]['account_tax_code_id']        = "";
       $insert[24]['default_for_code']           = "";
       
       $insert[25]['default_id']                 = ""; 
       $insert[25]['default_type_id']            = "13";    
       $insert[25]['default_number']             = "64300";
       $insert[25]['default_name']               = "Meals and Entertainment";
       $insert[25]['default_description']        = "Business meals and entertainment expenses, including travel-related meals (may have limited deductib...";               
       $insert[25]['default_parent_id']          = "";              
       $insert[25]['default_sublevel']           = "";   
       $insert[25]['default_balance']            = "";
       $insert[25]['default_open_balance']       = "";
       $insert[25]['default_open_balance_date']  = "";
       $insert[25]['is_tax_account']             = "";
       $insert[25]['account_tax_code_id']        = "";
       $insert[25]['default_for_code']           = "";
       
       $insert[26]['default_id']                 = ""; 
       $insert[26]['default_type_id']            = "13";    
       $insert[26]['default_number']             = "64900";
       $insert[26]['default_name']               = "Office Supplies";
       $insert[26]['default_description']        = "Office supplies expense";               
       $insert[26]['default_parent_id']          = "";              
       $insert[26]['default_sublevel']           = "";   
       $insert[26]['default_balance']            = "";
       $insert[26]['default_open_balance']       = "";
       $insert[26]['default_open_balance_date']  = "";
       $insert[26]['is_tax_account']             = "";
       $insert[26]['account_tax_code_id']        = "";
       $insert[26]['default_for_code']           = "";
       
       $insert[27]['default_id']                 = ""; 
       $insert[27]['default_type_id']            = "13";    
       $insert[27]['default_number']             = "66000";
       $insert[27]['default_name']               = "Payroll Expenses";
       $insert[27]['default_description']        = "Payroll expenses";              
       $insert[27]['default_parent_id']          = "";              
       $insert[27]['default_sublevel']           = "";   
       $insert[27]['default_balance']            = "";
       $insert[27]['default_open_balance']       = "";
       $insert[27]['default_open_balance_date']  = "";
       $insert[27]['is_tax_account']             = "";
       $insert[27]['account_tax_code_id']        = "";
       $insert[27]['default_for_code']           = "";
       
       $insert[28]['default_id']                 = ""; 
       $insert[28]['default_type_id']            = "13";    
       $insert[28]['default_number']             = "66500";
       $insert[28]['default_name']               = "Postage and Delivery";
       $insert[28]['default_description']        = "Postage, courier, and pickup and delivery services";            
       $insert[28]['default_parent_id']          = "";              
       $insert[28]['default_sublevel']           = "";   
       $insert[28]['default_balance']            = "";
       $insert[28]['default_open_balance']       = "";
       $insert[28]['default_open_balance_date']  = "";
       $insert[28]['is_tax_account']             = "";
       $insert[28]['account_tax_code_id']        = "";
       $insert[28]['default_for_code']           = "";
       
       $insert[29]['default_id']                 = ""; 
       $insert[29]['default_type_id']            = "13";    
       $insert[29]['default_number']             = "66700";
       $insert[29]['default_name']               = "Professional Fees";
       $insert[29]['default_description']        = "Payments to accounting professionals and attorneys for accounting or legal services";               
       $insert[29]['default_parent_id']          = "";              
       $insert[29]['default_sublevel']           = "";   
       $insert[29]['default_balance']            = "";
       $insert[29]['default_open_balance']       = "";
       $insert[29]['default_open_balance_date']  = "";
       $insert[29]['is_tax_account']             = "";
       $insert[29]['account_tax_code_id']        = "";
       $insert[29]['default_for_code']           = "";
       
       $insert[30]['default_id']                 = ""; 
       $insert[30]['default_type_id']            = "13";    
       $insert[30]['default_number']             = "67100";
       $insert[30]['default_name']               = "Rent Expense";
       $insert[30]['default_description']        = "Rent paid for company offices or other structures used in the business";            
       $insert[30]['default_parent_id']          = "";              
       $insert[30]['default_sublevel']           = "";   
       $insert[30]['default_balance']            = "";
       $insert[30]['default_open_balance']       = "";
       $insert[30]['default_open_balance_date']  = "";
       $insert[30]['is_tax_account']             = "";
       $insert[30]['account_tax_code_id']        = "";
       $insert[30]['default_for_code']           = "";
       
       $insert[31]['default_id']                 = ""; 
       $insert[31]['default_type_id']            = "13";    
       $insert[31]['default_number']             = "67200";
       $insert[31]['default_name']               = "Repairs and Maintenance";
       $insert[31]['default_description']        = "Incidental repairs and maintenance of business assets that do not add to the value or appreciably prolong its life";            
       $insert[31]['default_parent_id']          = "";              
       $insert[31]['default_sublevel']           = "";   
       $insert[31]['default_balance']            = "";
       $insert[31]['default_open_balance']       = "";
       $insert[31]['default_open_balance_date']  = "";
       $insert[31]['is_tax_account']             = "";
       $insert[31]['account_tax_code_id']        = "";
       $insert[31]['default_for_code']           = "";
       
       $insert[32]['default_id']                 = ""; 
       $insert[32]['default_type_id']            = "13";    
       $insert[32]['default_number']             = "8100";
       $insert[32]['default_name']               = "Telephone Expense";
       $insert[32]['default_description']        = "Telephone and long distance charges, faxing, and other fees Not equipment purchases";               
       $insert[32]['default_parent_id']          = "";              
       $insert[32]['default_sublevel']           = "";   
       $insert[32]['default_balance']            = "";
       $insert[32]['default_open_balance']       = "";
       $insert[32]['default_open_balance_date']  = "";
       $insert[32]['is_tax_account']             = "";
       $insert[32]['account_tax_code_id']        = "";
       $insert[32]['default_for_code']           = "";
       
       $insert[33]['default_id']                 = ""; 
       $insert[33]['default_type_id']            = "13";    
       $insert[33]['default_number']             = "68400";
       $insert[33]['default_name']               = "Travel Expense";
       $insert[33]['default_description']        = "Business-related travel expenses including airline tickets, taxi fares, hotel and other travel expenses";               
       $insert[33]['default_parent_id']          = "";              
       $insert[33]['default_sublevel']           = "";   
       $insert[33]['default_balance']            = "";
       $insert[33]['default_open_balance']       = "";
       $insert[33]['default_open_balance_date']  = "";
       $insert[33]['is_tax_account']             = "";
       $insert[33]['account_tax_code_id']        = "";
       $insert[33]['default_for_code']           = "";
       
       $insert[34]['default_id']                 = ""; 
       $insert[34]['default_type_id']            = "13";    
       $insert[34]['default_number']             = "68600";
       $insert[34]['default_name']               = "Utilities";
       $insert[34]['default_description']        = "Water, electricity, garbage, and other basic utilities expenses";               
       $insert[34]['default_parent_id']          = "";              
       $insert[34]['default_sublevel']           = "";   
       $insert[34]['default_balance']            = "";
       $insert[34]['default_open_balance']       = "";
       $insert[34]['default_open_balance_date']  = "";
       $insert[34]['is_tax_account']             = "";
       $insert[34]['account_tax_code_id']        = "";
       $insert[34]['default_for_code']           = "";
       
       $insert[35]['default_id']                 = ""; 
       $insert[35]['default_type_id']            = "15";    
       $insert[35]['default_number']             = "80000";
       $insert[35]['default_name']               = "Ask My Accountant";
       $insert[35]['default_description']        = "Transactions to be discussed with accountant, consultant, or tax preparer";             
       $insert[35]['default_parent_id']          = "";              
       $insert[35]['default_sublevel']           = "";   
       $insert[35]['default_balance']            = "";
       $insert[35]['default_open_balance']       = "";
       $insert[35]['default_open_balance_date']  = "";
       $insert[35]['is_tax_account']             = "";
       $insert[35]['account_tax_code_id']        = "";
       $insert[35]['default_for_code']           = "";
       
       DB::table("tbl_default_chart_account")->insert($insert);
    }

    public static function seed_tbl_item_type()
    {
      $insert[0]['item_type_id']    = 1; 
      $insert[0]['item_type_name']  = "Inventory";  
      $insert[1]['item_type_id']    = 2; 
      $insert[1]['item_type_name']  = "Non-Inventory";  
      $insert[2]['item_type_id']    = 3; 
      $insert[2]['item_type_name']  = "Service";
      $insert[3]['item_type_id']    = 4; 
      $insert[3]['item_type_name']  = "Bundle";

      DB::table('tbl_item_type')->insert($insert);
    }

    public static function seed_tbl_online_pymnt_method()
    {
        $insert[0]['method_id']         = 1; 
        $insert[0]['method_name']       = "Credit Card";
        $insert[0]['method_code_name']  = "credit-card";
        $insert[0]['method_gateway_accepted']  = "1,2,3,4,5";

        $insert[1]['method_id']         = 2; 
        $insert[1]['method_name']       = "Paypal";
        $insert[1]['method_code_name']  = "paypal"; 
        $insert[1]['method_gateway_accepted']  = "1,2,3,4,5";

        $insert[2]['method_id']         = 3; 
        $insert[2]['method_name']       = "Metro Bank";
        $insert[2]['method_code_name']  = "metrobank"; 
        $insert[2]['method_gateway_accepted']  = "1,2,3,4,5";

        $insert[3]['method_id']         = 4; 
        $insert[3]['method_name']       = "BDO";
        $insert[3]['method_code_name']  = "bdo"; 
        $insert[3]['method_gateway_accepted']  = "1,2,3,4,5";

        $insert[4]['method_id']         = 5; 
        $insert[4]['method_name']       = "BPI";
        $insert[4]['method_code_name']  = "bpi";
        $insert[4]['method_gateway_accepted']  = "1,2,3,4,5";

        DB::table('tbl_online_pymnt_method')->insert($insert);
    }

    public static function seed_tbl_online_pymnt_gateway()
    {
        $insert[0]['gateway_id']         = 1; 
        $insert[0]['gateway_name']       = "Paypal";
        $insert[0]['gateway_code_name']  = "paypal2";

        $insert[1]['gateway_id']         = 2; 
        $insert[1]['gateway_name']       = "Paymaya";
        $insert[1]['gateway_code_name']  = "paymaya"; 

        $insert[2]['gateway_id']         = 3; 
        $insert[2]['gateway_name']       = "Paynammics";
        $insert[2]['gateway_code_name']  = "paynamics"; 

        $insert[3]['gateway_id']         = 4; 
        $insert[3]['gateway_name']       = "Dragon Pay";
        $insert[3]['gateway_code_name']  = "dragonpay"; 

        $insert[4]['gateway_id']         = 5; 
        $insert[4]['gateway_name']       = "Other";
        $insert[4]['gateway_code_name']  = "other";

        DB::table('tbl_online_pymnt_gateway')->insert($insert);
    }
}


// <?php

// interface PokemonInterface {
//     public function attack();
//     public function defend();
// }

// class Pokemon implements PokemonInterface {
     
//     public function attack() {
//          echo $this->element;      
//     }
    
//     public function defend() {
        
//     }
// }

// class PokemonPikachu extends Pokemon {
//     protected $element = 'ELECTRIC';
// }

// class PokemonCharimander extends Pokemon {
//      protected $element = 'FIRE';   
// }

// class AshTraineer {
 
//     public function iChooseYou(PokemonInterface $pokemon) {
//         $pokemon->attack();
//         $pokemon->defend();
//     }
// }


// $ash = new AshTraineer();
// $pikachu = new PokemonPikachu();
// $charimander = new PokemonCharimander();
// $ash->iChooseYou($charimander);
// ?>