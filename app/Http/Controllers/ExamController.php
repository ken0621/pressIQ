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

    public function postRegister()
    {
        $return["status"] = "success";
        $return["title"] = "Creation Failed";
        $return["message"] = "First Name is required.";
        $return["load_page"] = "/exam/test";
        echo json_encode($return);
    }
    public function getTest()
    {
        $data["page"] = "Exam";
        return view('exam.exam_test', $data);
    }
}