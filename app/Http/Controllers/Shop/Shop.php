<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_shop;
use App\Models\Tbl_content;
use App\Models\Tbl_ec_product;
use App\Models\Tbl_country;
use App\Models\Tbl_customer;
use App\Globals\Ecom_Product;
use App\Globals\Cart;
use App\Globals\Settings;
use Session;

class Shop extends Controller
{
	public $shop_info;
    public $shop_theme;
    public $shop_theme_color;


    public static $customer_info;
    public static $slot_now;

    public static $lead;

    public function __construct()
    {
    	$domain = get_domain();
        
    	$check_domain = Tbl_shop::where("shop_domain", $domain)->first();
        // dd(Session::get('mlm_member'));
        if(Session::get('mlm_member') != null)
        {
            $session = Session::get('mlm_member');

            Self::$customer_info = $session['customer_info'];
            if($session['slot_now'])
            {
                Self::$slot_now = $session['slot_now'];
            }
        }
        else
        {
            Self::$customer_info = null;
            Self::$slot_now = null;
        }
        if(hasSubdomain())
        {
			$url = $_SERVER['HTTP_HOST'];
			$host = explode('.', $url);
			$subdomains = array_slice($host, 0, count($host) - 2 );
			$subdomain = $subdomains[0];
        	$this->shop_info = $shop_info = Tbl_shop::where("shop_key", $subdomain)->first();

            if(!$this->shop_info)
            {
                $check_domain = Tbl_customer::where('mlm_username', $subdomain)->first();
                $lead_e = $check_domain;
                if($lead_e)
                {
                    $shop_id = $lead_e->shop_id;    
                    $this->shop_info = $shop_info = Tbl_shop::where("shop_id", $shop_id)->first();
                    Self::$lead = $lead_e;
                }
                else
                {
                    die("Page not found.");
                }
            }
        }
        elseif($check_domain)
        {
        	$this->shop_info = $check_domain;
        }
        else
        {
        	die("Page not found.");
        }
        $this->shop_theme = $this->shop_info->shop_theme;
        $this->shop_theme_color = $this->shop_info->shop_theme_color;

        $shop_theme_info = $string = file_get_contents("../public/themes/" . $this->shop_info->shop_theme . "/page.json");
        $shop_theme_info = json_decode($string);
        foreach ($shop_theme_info as $key => $value) 
        {
            foreach ($value as $keys => $values) 
            {
                $get = Tbl_content::where("key", $keys)->where("type", $values->type)->where("shop_id", $this->shop_info->shop_id)->first();

                if ($get) 
                {
                    $shop_theme_info->$key->$keys->type = $get->type;
                    $shop_theme_info->$key->$keys->default = $get->value;
                }
            }
        }

        $this->shop_theme_info = $shop_theme_info;
      
        $company_info = collect(Tbl_content::where("shop_id", $this->shop_info->shop_id)->get())->keyBy('key');
        $product_category = Ecom_Product::getAllCategory($this->shop_info->shop_id);
        $global_cart = Cart::get_cart($this->shop_info->shop_id);
        $country = Tbl_country::get();

        /* Set Email Configuration */
        Settings::set_mail_setting($this->shop_info->shop_id);
        
        View::share("slot_now", Self::$slot_now);
        View::share("customer_info", Self::$customer_info);
        View::addLocation(base_path() . '/public/themes/' . $this->shop_theme . '/views/');
        View::share("shop_info", $this->shop_info);
        View::share("shop_theme", $this->shop_info->shop_theme);
        View::share("shop_theme_color", $this->shop_info->shop_theme_color);
        View::share("shop_theme_info", $shop_theme_info);
        View::share("company_info", $company_info);
        View::share("shop_id", $this->shop_info->shop_id);
        View::share("_categories", $product_category);
        View::share("global_cart", $global_cart);
        View::share("country", $country);
    }
    public function file($theme, $type, $filename)
    {
        echo require_once(base_path("resources/views/themes/" . $theme . "/" . $type . "/" . $filename));
    }
}