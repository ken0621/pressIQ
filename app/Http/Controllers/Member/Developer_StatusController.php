<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

class Developer_StatusController extends Member
{
	public function index()
	{
		return view('member.developer.developer_status');
	}
}