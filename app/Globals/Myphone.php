<?php
namespace App\Globals;
use DB;
use Session;
use Redirect;
use \Exception;
use URL;

class Myphone
{
    public static function putSession()
    {
    	session_start();
    	
    	$url = URL::to('/session/put');
    	$fields = collect(Session::get('mlm_member'))->toArray();

   	    unset($_SESSION['mlm_member']);
        $_SESSION['mlm_member'] = $fields;

        session_write_close();
    }

	public static function forgetSession()
	{
		session_start();

		unset($_SESSION['mlm_member']);

		session_write_close();
	}
}