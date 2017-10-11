<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Globals\Cart;
use App\Models\Tbl_item;
use App\Models\Tbl_category;
use App\Globals\Category;
use App\Globals\Ecom_Product;
use App\Globals\Cards;
use App\Globals\Ec_brand;
use App\Globals\Payment;
use Jenssegers\Agent\Agent;


class ShopHomeController extends Shop
{
    public function index()
    {
        $data["page"]      = "Home";
        $data["_product"] = Ecom_Product::getAllProduct($this->shop_info->shop_id);

        /* Intogadgets Exclusive */
        if ($this->shop_info->shop_theme == "intogadgets") 
        {
        	$data["_brand"] = Ec_brand::getAllBrands($this->shop_info->shop_id);
        }

        /* Philtech Exclusive */
        if ($this->shop_info->shop_theme == "philtech") 
        {
            $data["_categories"] = Ecom_Product::getAllCategory($this->shop_info->shop_id);
        }


        $view = "home";

        $agent = new Agent();

        if($agent->isMobile())
        {
            $new_view = "mobile." . $view;
            
            if(view()->exists($new_view))
            {
                $view = $new_view;
            }
        }
     	
        return view($view, $data);
    }
}