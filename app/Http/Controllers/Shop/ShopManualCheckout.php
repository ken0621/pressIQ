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
        $transaction_list_id    = Crypt::decrypt(request("tid"));
        $transaction_list       = Tbl_transaction_list::where("transaction_list_id", $transaction_list_id)->first();

        dd($transaction_list);
    }
}