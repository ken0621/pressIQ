<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_product;
use App\Globals\Ecom_Product;
use App\Models\Tbl_ec_product;
use App\Globals\Cart;

class ShopCartController extends Shop
{
    public function index()
    {
        $data["page"]  = "Product Cart";
        $data["get_cart"] = Cart::get_cart($this->shop_info->shop_id);
        // dd($data);
        // evariant_item_id
        return view("cart_modal", $data);
    }

    public function mini_cart()
    {
        $data["page"] = "Mini Product Cart";
        $data["get_cart"] = Cart::get_cart($this->shop_info->shop_id);
    
        return view("mini_cart_modal", $data);
    }

    public function add_cart()
    {
        $variant_id = Request::input("variant_id");
        $quantity = Request::input("quantity");

        $result = Cart::add_to_cart($variant_id,$quantity,$this->shop_info->shop_id);

        echo json_encode($result);
    }

    public function remove_cart()
    {
        $variant_id = Request::input("variation_id");
        $result = Cart::delete_product($variant_id, $this->shop_info->shop_id);

        echo json_encode($result);
    }

    public function update_cart()
    {
        $variant_id = Request::input("variation_id");
        $quantity = Request::input("quantity");
        $result = Cart::update_cart($variant_id, $quantity, $this->shop_info->shop_id);

        echo json_encode($result);
    }

    public function clear_cart()
    {
        $result = Cart::clear_all($this->shop_info->shop_id);

        echo json_encode($result);
    }
}