<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use App\Models\Tbl_voucher;
use App\Models\Tbl_membership_code_invoice;
use App\Models\Tbl_membership_code;
use Crypt;
use Redirect;
use DB;
use Request;
use View;
use App\Globals\abs\AbsMain;
use App\Models\Tbl_mlm_gc;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Request2;
use App\Models\Tbl_tour_wallet;
use App\Models\Tbl_vmoney_wallet_logs;
use App\Globals\Mlm_slot_log;
use Carbon\Carbon;
class MlmWalletVMoneyController extends Mlm
{
    public function index()
    {
        $data = [];
        return view('mlm.vmoney.index', $data);
    }
    
    public function transfer()
    {
        /* Set URL Sandbox or Live */
        $url = "http://test.vmoney.com/gtcvbankapp/";
        
        /* Insert Logs */
        $logs["vmoney_wallet_logs_date"] = Carbon::now();
        $logs["vmoney_wallet_logs_email"] = Request::input("vmoney_email");
        $logs["vmoney_wallet_logs_amount"] = Request::input("wallet_amount");
        $logs["shop_id"] = Self::$shop_id;
        Tbl_vmoney_wallet_logs::insert($logs);
        
        /* API */
        $check = 'initTxnPeerTransfer.sctl';
    }
}