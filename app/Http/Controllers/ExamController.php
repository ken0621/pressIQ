<?php
namespace App\Http\Controllers;

class ExamController extends Controller
{
    public function getIndex()
    {
    	$data["page"] = "Exam";
        return view('exam.exam', $data);
    }
    public function getRegister()
    {
    	$data["page"] = "Exam";
        return view('exam.exam_register', $data);
    }
}