<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Image;
use Validator;
use Redirect;
use File;
use URL;
use DB;
use Crypt;
use Session;

/**
 * Accounting Settings Module - all settings related to accounting module
 *
 * @author Bryan Kier Aradanas
 */

class AdminController extends Super
{
	public function getIndex()
	{
		Redirect::("super_admin\index_admin");
	}
}