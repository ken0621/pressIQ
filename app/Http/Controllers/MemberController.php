<?php
namespace App\Http\Controllers;
use Request;
use App\Models\Tbl_mlm_slot;
use App\Globals\Pdf_global;
use PDF;
use App;
use Carbon\Carbon;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_country;
use App\Models\Tbl_shop;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership;
use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_membership_package_has;
use Validator;
use Session;
use Redirect;
use App\Globals\Mlm_member;
use App\Globals\Item;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_gc;
use App\Globals\Dragonpay\RequestPayment;
class MemberController extends Controller
{
    public static $shop_id;
    public static $lead;

    protected $_merchantid = 'MYPHONE' ;
    protected $_merchantkey = 'Ez9MiNqWBS2BHuO' ;

    public function __construct()
    {   
        $domain = Request::url();
        $check_expole = explode('//', $domain);
        if(count($check_expole) == 2 )
        {
            $check_expole_2 = explode('.', $check_expole[1]);
            $key = $check_expole_2[0];
            $check_domain = Tbl_shop::where('shop_key', $key)->first();
            $lead_e = null;
            if($check_domain == null)
            {
                $check_domain = Tbl_customer::where('mlm_username', $key)->first();
                $lead_e = $check_domain;
            }
            
        }
        if($check_domain != null)
        {
             Self::$shop_id = $check_domain->shop_id;
             if($lead_e != null)
             {
                Self::$lead = $lead_e;
             }
             else
             {
                Self::$lead = null;
             }
        }
        else
        {
            $domain = Request::url();
            $check_expole = explode('.', $domain);
            if(isset($check_expole[2]))
            {
                $check_expole_2 = explode('/', $check_expole[2]);
                if(isset($check_expole_2[0]))
                {
                    $shop_domain = $check_expole[1] . '.' . $check_expole_2[0];
                    $shop = Tbl_shop::where('shop_domain', $shop_domain)->first();
                    if($shop != null)
                    {
                        Self::$shop_id = $shop->shop_id;
                    }

                }
            }
            else
            {
                if(isset($check_expole[1]))
                {

                    $check_expole_2 = explode('/', $check_expole[1]);
                    if(isset($check_expole_2[0]))
                    {
                        $check_expole_slash = explode('//', $check_expole[0]);
                        if(count($check_expole_slash) >= 2)
                        {
                          $check_expole[0] = $check_expole_slash[1];  
                        }
                        $shop_domain = $check_expole[0] . '.' . $check_expole_2[0];
                        $shop = Tbl_shop::where('shop_domain', $shop_domain)->first();
                        if($shop != null)
                        {
                            Self::$shop_id = $shop->shop_id;
                        }
                    }   
                }
            }
        }
    }

	public function index()
	{
		echo "hello world";
	}
    public function register()
    {
        $data['country'] = Tbl_country::get();
        return view("mlm.register.register", $data);
    }
    public function register_post()
    {
        // return json_encode($_POST);
        $info['company'] = Request::input('company');
        $info['country'] = Request::input('country');
        $info['email'] = Request::input('email');
        $info['first_name'] = Request::input('first_name');
        $info['last_name'] = Request::input('last_name');
        $info['password'] = Request::input('password');
        $info['password_confirm'] = Request::input('password_confirm');
        $info['tin_number'] = Request::input('tin_number');
        $info['username'] = Request::input('username');
        $info['sponsor'] = Request::input('sponsor');
        $info['customer_phone'] = Request::input('contact_number');
        $info['customer_mobile'] = Request::input('contact_number');
        $rules['first_name'] = 'required';
        $rules['last_name'] = 'required';
        $rules['password'] = 'required|min:6';
        $rules['password_confirm'] = 'required|min:6';
        $rules['email'] = 'required';
        if(!isset($_POST['terms']))
        {
            $data['status'] = 'warning';
            $data['message'][0] = 'Terms and Agreement is required';
            return $data;
        }
         $validator = Validator::make($info, $rules);
         if ($validator->passes()) 
         {
            $count_email = Tbl_customer::where('email', $info['email'])->count();
            if($count_email == 0)
            {
                $count_username = Tbl_customer::where('mlm_username', $info['username'])->count();
                if($count_username == 0)
                {
                    if($info['sponsor'] != null)
                    {
                        $count_slot = Tbl_mlm_slot::where('slot_nick_name', $info['sponsor'])->count();
                        if($count_slot == 0)
                        {
                            $data['status'] = 'warning';
                            $data['message'][0] = 'Sponsor does not exist';
                            return $data;
                        }
                    }

                    if($info['password'] == $info['password_confirm'])
                    {
                        Session::put('mlm_register_step_1', $info);
                        $data['status'] = 'success';
                        $data['message'][0] = 'Sucess!';
                        $data['link'] = '/member/register/package';
                    }
                    else
                    {
                        $data['status'] = 'warning';
                        $data['message'][0] = "password did not match.";
                    }
                }
                else
                {
                    $data['status'] = 'warning';
                    $data['message'][0] = 'Username already used.';
                }
            }
            else
            {
                $data['status'] = 'warning';
                $data['message'][0] = 'Email already used.';
            }
         }
         else
         {
            $data['status'] = "warning";
            $data['message'] = $validator->messages();
         }
         return json_encode($data);
    }

    public function payment()
    {
        $register_session = Session::get('mlm_register_step_1');
        if($register_session == null)
        {
            return Redirect::to('/member/register');
        }
        // return $register_session;
        $register_session_2 = Session::get('mlm_register_step_2');
        if($register_session_2 == null)
        {
            return Redirect::to('/member/register/package');
        }

        $register_session_3 = Session::get('mlm_register_step_3');
        if($register_session_3 == null)
        {
            return Redirect::to('/member/register/shipping');
        }

        $membership_id = $register_session_2['membership'];
        $package_id = $register_session_2['package'];



        $data['membership_packages'] = Tbl_membership_package::where('membership_id', $membership_id)
        ->where('membership_package_id', $package_id)
        ->where('membership_package_archive', 0)->get();
        foreach($data['membership_packages'] as $key => $value)
        {
            $data['product_count'][$key] = Tbl_membership_package_has::where('membership_package_id', $package_id)->get();
            $data['item_bundle'][$key] = Tbl_membership_package_has::where('membership_package_id', $package_id)->get();
            foreach($data['item_bundle'][$key] as $key2 => $value2)
            {
                $data['item_bundle'][$key][$key2]->item_list = Item::get_item_bundle($value2->item_id);
            }
        }

        return view("mlm.register.payment", $data);
    }
    public function payment_post()
    {
        // return $_POST;
        $info['payment_type'] = Request::input('payment_type');
        $info['membership_pin'] = Request::input('membership_pin');
        $info['membership_code'] = Request::input('membership_code');

        // $s['first_name'] = Request::input('first_name');
        // $s['last_name'] = Request::input('last_name');
        // $s['contact_info'] = Request::input('contact_info');
        // $s['contact_other'] = Request::input('contact_other');
        // $s['shipping_address'] = Request::input('shipping_address');

        // $rules['first_name'] = 'required';
        // $rules['last_name'] = 'required';
        // $rules['contact_info'] = 'required';
        // $rules['contact_other'] = 'required';
        // $rules['shipping_address'] = 'required';
        // $validator = Validator::make($s, $rules);
        // if (!$validator->passes()) 
        //  {
        //     $data['status'] = "warning";
        //     $data['message'] = $validator->messages();
        //     return json_encode($data);
        //  }
        $s = Session::get('mlm_register_step_3');

        if($info['payment_type'] != null)
        {
            if($info['payment_type'] == 'membership_code')
            {
                if($info['membership_pin'] != null && $info['membership_code'] != null)
                {
                    $count_code = Tbl_membership_code::where('membership_code_id', $info['membership_pin'])
                    ->where('membership_activation_code', $info['membership_code'])->count();
                    if($count_code >= 1)
                    {
                        $code = Tbl_membership_code::where('membership_code_id', $info['membership_pin'])
                        ->where('membership_activation_code', $info['membership_code'])->package()->membership()->first();
                        if($code->used == 0)
                        {
                            $shop_id = Self::$shop_id;
                            if($shop_id == null)
                            {
                                $shop_id = 5;
                            }
                            $register_session = Session::get('mlm_register_step_1');
                            $register_session_2 = Session::get('mlm_register_step_2');
                            $ship = $s;
                            $code_info = $code;
                            $code = $info;
                            Mlm_member::register_slot_membership_code($shop_id, $register_session, $register_session_2, $ship, $code, $code_info);
                            Session::forget('mlm_register_step_1');
                            Session::forget('mlm_register_step_2');
                            Session::forget('mlm_register_step_3');

                            $data['status'] = 'success';
                            $data['message'][0] = 'Membership Code Already Used.';
                            $data['link'] = '/mlm';
                        }
                        else
                        {
                            $data['status'] = 'warning';
                            $data['message'][0] = 'Membership Code Already Used.';
                        }
                        
                    }
                    else
                    {
                        $data['status'] = 'warning';
                        $data['message'][0] = 'Invalid Membership Code/Pin.';
                    }
                }
                else
                {
                    $data['status'] = 'warning';
                    $data['message'][0] = 'Invalid Membership Code/Pin.';
                } 
            }
            elseif($info['payment_type'] == 'dragonpay')
            {
                $this->post_dragonpay();
            }
            else
            {
                $shop_id = Self::$shop_id;
                $register_session = Session::get('mlm_register_step_1');
                $customer_id = Mlm_member::register_slot_insert_customer($shop_id, $register_session);
                

                $register_session_2 = Session::get('mlm_register_step_2');
                // dd();
                $slot_sponsor = Tbl_mlm_slot::where('slot_nick_name', $register_session['sponsor'])->first();
                $insert['slot_no'] = Mlm_plan::set_slot_no($shop_id, null);
                $insert['shop_id'] = $shop_id;
                $insert['slot_owner'] = $customer_id;
                $insert['slot_created_date'] = Carbon::now();
                $insert['slot_membership'] = $register_session_2['membership'];
                $insert['slot_status'] = 'PS';
                $insert['slot_sponsor'] = $slot_sponsor->slot_id;
                
                $id = Tbl_mlm_slot::insertGetId($insert);
                $a = Mlm_compute::entry($id);

                $c = Mlm_gc::slot_gc($id);
                $data['status'] = 'success';
                $data['message'][0] = 'Membership Code Already Used.';
                $data['link'] = '/mlm';

                Session::forget('mlm_register_step_1');
                Session::forget('mlm_register_step_2');
                Session::forget('mlm_register_step_3');

                Mlm_member::add_to_session_edit($shop_id, $customer_id, $id);
                // $data['status'] = 'warning';
                // $data['message'][0] = 'The chosen payment facility is under maintenance.';
            }
        }
        else
        {
            $data['status'] = 'warning';
            $data['message'][0] = 'Invalid Payment Type';
        }
        return json_encode($data);
    }

    public function post_dragonpay()
    {
        $info = Session::get('mlm_register_step_1');
        $shop_id = Self::$shop_id;
        Session::put('shop_id_session', $shop_id);
        $requestpayment = new RequestPayment($this->_merchantkey);

        $this->_data = array(
            'merchantid'    => $requestpayment->setMerchantId($this->_merchantid),
            'txnid'         => $requestpayment->setTxnId(Self::$shop_id . time()),
            'amount'        => $requestpayment->setAmount(10),
            'ccy'           => $requestpayment->setCcy('PHP'),
            'description'   => $requestpayment->setDescription('Test'),
            'email'         => $requestpayment->setEmail($info['email']),
            'digest'        => $requestpayment->getdigest(),
        );

        RequestPayment::make($this->_merchantkey, $this->_data);
        die("Please do not refresh the page and wait while we are processing your payment. This can take a few minutes.");
    }


    public function package()
    {
        $register_session = Session::get('mlm_register_step_1');
        if($register_session == null)
        {
            return Redirect::to('/member/register');
        }

        $data['membership'] = Tbl_membership::where('shop_id', Self::$shop_id)->where('membership_archive', 0)->get();
        $data['package'] = [];

        foreach($data['membership'] as $key => $value)
        {
            $data['package'][$key] = Tbl_membership_package::where('membership_id', $value->membership_id)->where('membership_package_archive', 0)->get();
        }
        return view("mlm.register.package", $data);
    }
    public function package_post()
    {
        $info['membership'] = Request::input('membership');
        $info['package'] = Request::input('package');
        if($info['membership'] != null)
        {
            if(isset($info['package'][$info['membership']]))
            {
                $d['membership'] = $info['membership'];
                $d['package'] = $info['package'][$info['membership']];
                Session::put('mlm_register_step_2', $d);
                $data['status'] = 'success';
                $data['message'][0] = 'Sucess!';
                $data['link'] = '/member/register/shipping';
            }
            else
            {
                $data['status'] = 'warning';
                $data['message'][0] = 'Email already used.';
            }
        }
        else
        {
            $data['status'] = 'warning';
            $data['message'][0] = 'Invalid Membership';
        }
        return json_encode($data);
    }

    public function shipping()
    {
        $register_session = Session::get('mlm_register_step_1');
        if($register_session == null)
        {
            return Redirect::to('/member/register');
        }
        // return $register_session;
        $register_session_2 = Session::get('mlm_register_step_2');
        if($register_session_2 == null)
        {
            return Redirect::to('/member/register/package');
        }

        return view("mlm.register.shipping");
    }

    public function shipping_post()
    {
        $s['first_name'] = Request::input('first_name');
        $s['last_name'] = Request::input('last_name');
        $s['contact_info'] = Request::input('contact_info');
        $s['contact_other'] = Request::input('contact_other');
        $s['shipping_address'] = Request::input('shipping_address');

        $rules['first_name'] = 'required';
        $rules['last_name'] = 'required';
        $rules['contact_info'] = 'required';
        $rules['contact_other'] = 'required';
        $rules['shipping_address'] = 'required';
        $validator = Validator::make($s, $rules);
        if (!$validator->passes()) 
         {
            $data['status'] = "warning";
            $data['message'] = $validator->messages();
            return json_encode($data);
         }
         else
         {
            Session::put('mlm_register_step_3', $s);
            $data['status'] = 'success';
            $data['message'][0] = 'Sucess!';
            $data['link'] = '/member/register/payment';

            return json_encode($data);
         }
    }
























    public function barcode( $filepath="", $text="0", $size="20", $orientation="horizontal", $code_type="code128", $print=false, $SizeFactor=1 ) 
    {
        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ( $X = 1; $X <= strlen($text); $X++ ) {
                $activeKey = substr( $text, ($X-1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum=($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211214" . $code_string . "2331112";
        } elseif ( strtolower($code_type) == "code128a" ) {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ( $X = 1; $X <= strlen($text); $X++ ) {
                $activeKey = substr( $text, ($X-1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum=($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211412" . $code_string . "2331112";
        } elseif ( strtolower($code_type) == "code39" ) {
            $code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
                $code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
            }

            $code_string = "1211212111" . $code_string . "121121211";
        } elseif ( strtolower($code_type) == "code25" ) {
            $code_array1 = array("1","2","3","4","5","6","7","8","9","0");
            $code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

            for ( $X = 1; $X <= strlen($text); $X++ ) {
                for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
                    if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
                        $temp[$X] = $code_array2[$Y];
                }
            }

            for ( $X=1; $X<=strlen($text); $X+=2 ) {
                if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
                    $temp1 = explode( "-", $temp[$X] );
                    $temp2 = explode( "-", $temp[($X + 1)] );
                    for ( $Y = 0; $Y < count($temp1); $Y++ )
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }

            $code_string = "1111" . $code_string . "311";
        } elseif ( strtolower($code_type) == "codabar" ) {
            $code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
            $code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
                for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
                    if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }

        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }
        
        for ( $i=1; $i <= strlen($code_string); $i++ ){
            $code_length = $code_length + (integer)(substr($code_string,($i-1),1));
            }

        if ( strtolower($orientation) == "horizontal" ) {
            $img_width = $code_length*$SizeFactor;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length*$SizeFactor;
        }

        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate ($image, 0, 0, 0);
        $white = imagecolorallocate ($image, 255, 255, 255);

        imagefill( $image, 0, 0, $white );
        if ( $print ) {
            imagestring($image, 5, 31, $img_height, $text, $black );
        }

        $location = 10;
        for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
            $cur_size = $location + ( substr($code_string, ($position-1), 1) );
            if ( strtolower($orientation) == "horizontal" )
                imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
            else
                imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
            $location = $cur_size;
        }
        
        // Draw barcode to the screen or save in a file
        if ( $filepath=="" ) {
            header ('Content-type: image/png');
            imagepng($image);
            imagedestroy($image);
        } else {
            imagepng($image,$filepath);
            imagedestroy($image);       
        }
    }

	public function barcodes()
	{
        /*
         *  Author  David S. Tufts
         *  Company davidscotttufts.com
         *    
         *  Date:   05/25/2003
         *  Usage:  <img src="/barcode.php?text=testing" alt="testing" />
         */

        // For demonstration purposes, get pararameters that are passed in through $_GET or set to the default value
        $filepath = (isset($_GET["filepath"])?$_GET["filepath"]:"");
        $text = (isset($_GET["text"])?$_GET["text"]:"0");
        $size = (isset($_GET["size"])?$_GET["size"]:"20");
        $orientation = (isset($_GET["orientation"])?$_GET["orientation"]:"horizontal");
        $code_type = (isset($_GET["codetype"])?$_GET["codetype"]:"code128");
        $print = (isset($_GET["print"])&&$_GET["print"]=='true'?true:false);
        $sizefactor = (isset($_GET["sizefactor"])?$_GET["sizefactor"]:"1");

        // This function call can be copied into your project and can be made from anywhere in your code
        $this->barcode( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
	}
    public function all_slot()
    {
        $all_slot = Tbl_mlm_slot::membership()->customer()->get();
        $card = null;
        foreach($all_slot as $key => $value)
        {
            if($value->membership_name == 'V.I.P Silver')
            {
                $color = 'silver';
            }
            else if($value->membership_name == 'V.I.P Gold')
            {
                $color = 'gold';
            }
            else if($value->membership_name == 'V.I.P Platinum ')
            {
                $color = 'red';
            }
            else
            {
                $color = 'discount';
            }
            $name = name_format_from_customer_info($value);
            $membership_code = $value->slot_no;
            $card .= $this->card_all($color, $name,  $membership_code);
            // $pdf = App::make('snappy.pdf.wrapper');
            // $pdf->loadHTML($card);
            // return $pdf->inline();
            // $card = $this->
        }
        // 
        if(Request::input('pdf') == 'true')
        {
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($card);
            return $pdf->inline();
            return Pdf_global::show_pdf($card);
        }
        else
        {
            return $card;
        }
        
    }
    public function card_all($color, $name,  $membership_code)
    {
        $data['color'] = $color;
        $data['name'] = $name;
        $data['membership_code'] = $membership_code;

        return view("card", $data);
    }
    public function card()
    {
        $data['color'] = Request::input("color");
        $data['name'] = Request::input("name");
        $data['membership_code'] = Request::input("membership_code");

        return view("card", $data);
    }
}