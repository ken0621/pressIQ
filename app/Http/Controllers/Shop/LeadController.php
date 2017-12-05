<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use View;

class LeadController extends Shop
{
    public function ref($slot_no, $product_id = null)
    {
        $this->middleware(function ($request, $next)
        {  
            View::share("replicated", "x");
            return $next($request);
        });

      
        $slot = Tbl_mlm_slot::where("slot_no", urldecode($slot_no))->where("shop_id", $this->shop_info->shop_id)->first();

        if(!$slot)
        {
        	abort(404);
        }
        else
        {
	       	$store["lead_sponsor"] = $slot_no;
	        session($store);
	        $data["page"] = "Replicated";

            if(view()->exists("replicated"))
            {
                if ($product_id) 
                {
                    return app('App\Http\Controllers\Shop\ShopProductContent2Controller')->index($product_id);
                }
                else
                {
                    return view('replicated', $data);
                }
            }
            else
            {
            	return redirect("/");
            }
        }
    }

    public function ref_product($slot_no, $product_id)
    {
        return $this->ref($slot_no, $product_id);
    }
}