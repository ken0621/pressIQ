<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Paypal;


class SampleTesting extends Controller

{

	public function index($id)
	{
		$data["id"] = $id + 1;
		$data["firsname"] = "oliver";
		$data["arrays"]	= array("1","2","3");
		
		return view('sample_testing',$data);
	}
	public function inspirer()
	{
		return redirect('http://162.251.151.81/inspirers/login');
	}

	public function samp2()
	{
		echo "asdsada";
	}
	public function ncabot()
	{
		$data["page"] = "NCA BOT";
		return view('ncabot', $data);
	}
}