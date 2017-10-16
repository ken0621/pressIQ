<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Models\Tbl_transaction_list;
use Crypt;
use Carbon\Carbon;
class ShopManualCheckout extends Shop
{
    public function index()
    {
        $transaction_list_id 	= Crypt::decrypt(request("tid"));
        $data["transaction"] 	= $transaction_list = Tbl_transaction_list::where("transaction_list_id", $transaction_list_id)->first();

        return view("member2.manual_checkout", $data);
    }
}