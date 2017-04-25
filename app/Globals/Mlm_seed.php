<?php
namespace App\Globals;
use Session;
use DB;
use Carbon\Carbon;
use App\Models\Tbl_email_content;
use App\Globals\Mlm_seed;
class Mlm_seed
{   
   public static function seed($shop_id)
   {
       # code...
        Mlm_seed::seed_email($shop_id);
   } 
   public static function seed_email($shop_id)
   {
        $email[0]['email_content_key'] =    'success_register';  
        $email[0]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully completed your registration made under the name [name_of_registrant] with TIN [tin_of_registrant] . Your Username is [user_name] .</p>';
        $email[0]['email_content_subject'] = 'Successful Registration';

        $email[1]['email_content_key'] =    'membership_code_purchase';
        $email[1]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully purchased [membership_count] Membership Package. Your Membership Code is/are:</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">[membership_code]</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>';
        $email[1]['email_content_subject'] ='Membership Code Purchase';  

        $email[2]['email_content_key'] =    'discount_card_purchase';
        $email[2]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully purchased a [membership_name]&nbsp;from [sponsor] Please read important details below:</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Date Issued:&nbsp;[date_issued]</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Date of Expiry: [date_expiry]</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>';
        $email[2]['email_content_subject'] = 'Discount Card Purchase';

        $email[3]['email_content_key'] =    'e_wallet_transfer';
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
</div>';
        $email[3]['email_content_subject'] = 'E-wallet Transfer';

        $email[4]['email_content_key'] =    'merchant_registration';
        $email[4]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully registered as a Merchant under the company name [business_name]&nbsp;with Mr./Ms. [name_of_merchant]&nbsp; as your representative. Your Username is [username].</p>';
        $email[4]['email_content_subject'] = 'Merchant Registration'; 

        $email[5]['email_content_key'] =    'merchant_product_registration';
        $email[5]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully registered your product through the Merchant Module System. Please be advised that processing time is 1-3 working days before your products/services get uploaded to the website. This is to ensure that the company&rsquo;s set standards are being followed at all times.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">These are the list of all the registered product:</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">[products]&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p>&nbsp;</p>';
        $email[5]['email_content_subject'] = 'Product Registration';

        $email[6]['email_content_key'] =    'e_wallet_refill';
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
<p class="MsoNormal" style="margin-bottom: .0001pt;">&nbsp;</p>';
        $email[6]['email_content_subject'] = 'E-wallet Refill';

        $email[7]['email_content_key'] =    'inquire_current_points';
        $email[7]['email_content'] = '<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Greetings!</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">Your current available points are [current_points] . Please be reminded that points may only be redeemed thru items and cannot be converted to cash.</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p>&nbsp;</p>';
        $email[7]['email_content_subject'] =  'Inquire Current Points';

        $email[8]['email_content_key'] =    'redeem_points';
        $email[8]['email_content'] = '<p>&nbsp;<span style="text-align: justify;">Greetings!</span></p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">You have successfully redeemed <u>[points]</u>. You may claim your <u>[item_redeem]</u>&nbsp;&nbsp;</p>
<p class="MsoNormal" style="margin-bottom: .0001pt; text-align: justify;">&nbsp;</p>';
        $email[8]['email_content_subject'] = 'Redeem Points';


        $count_email = Tbl_email_content::where('shop_id', $shop_id)->count();
        if($count_email < count($email))
        {
            foreach($email as $key => $value)
            {
                $count_e = Tbl_email_content::where('shop_id', $shop_id)
                ->where('email_content_key', $value['email_content_key'])
                ->count();
                if($count_e == 0)
                {
                    $insert['email_content_key'] = $value['email_content_key'];
                    $insert['email_content'] = $value['email_content'];
                    $insert['email_content_subject'] = $value['email_content_subject'];
                    $insert['date_created'] = Carbon::now();
                    $insert['archived'] = 0;
                    $insert['shop_id'] = $shop_id;

                    Tbl_email_content::insert($insert);
                }
            }
        }
   }
}