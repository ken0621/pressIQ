<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Tbl_position;
use App\Models\Tbl_brown_lesson;
use App\Models\Tbl_brown_lesson_chapter;
use Carbon\Carbon;
use Validator;
use File;
use Session;
use Input; 

 
class ManageLessonController extends Member
{
    public function index()
    {
        $data["page"] = "Lessons";
        return view('member.page.lesson', $data);
    }

    public function lesson_table()
    {

      $data['_lesson'] = Tbl_brown_lesson::orderByRaw('date_created DESC')->get();
      return view('member.page.lesson_table',$data);

    }

    public function lesson_add()
    {
       return view('member.page.lesson_add'); 
    }   

    public function lesson_add_submit(Request $request)
    {
        $path_prefix = 'http://digimaweb.solutions/public/uploadthirdparty/';
        $path ="";
        if($request->hasFile('lesson_case_study'))
        {
            $path = Storage::putFile('file', $request->file('lesson_case_study'));
        }   
        $data["lesson_name"]                      = $request->lesson_name;
        $data["lesson_overview"]                  = $request->lesson_overview;
        $data["lesson_exam_items"]                = $request->lesson_number_exam;
        $data["date_created"]                     = Carbon::now();
        $response                                 = "success";
        if($path!="")
        {
            $data["lesson_case_study"]            =$path_prefix.$path;
        }
        Tbl_brown_lesson::insert($data); 
        return Redirect::back()->with('response',$response);
    }

    public function lesson_delete()
    {
        $id = request('id');
        $delete = Tbl_brown_lesson::where('lesson_id', '=', $id)->delete();
        if($delete)
        {
            return "success";
        }
        else
        {
            return 'error';
        }
    }

    public function chapter($lesson_id)
    {
        $data['_chapter']      = Tbl_brown_lesson_chapter::where('lesson_id',$lesson_id)
                                 ->orderByRaw('date_created DESC')
                                 ->get();

        Session::put('lesson_id',$lesson_id);
        return view('member.page.chapter',$data); 
    }   

    public function chapter_add()
    {
        return view('member.page.chapter_add'); 
    }

    public function chapter_add_submit(Request $request)
    {

        $path_prefix = 'http://digimaweb.solutions/public/uploadthirdparty/';
        $path ="";
        if($request->hasFile('chapter_video'))
        {
            $path = Storage::putFile('file', $request->file('chapter_video'));
        }
        $data["chapter_name"]           = $request->chapter_name;
        $data["chapter_overview"]       = $request->chapter_overview; 
        $data["date_created"]           = Carbon::now();
        $data["lesson_id"]              = Session("lesson_id");
        if($path!="")
        {
            $data["chapter_video"]            =$path_prefix.$path;
        }

        Tbl_brown_lesson_chapter::insert($data); 
        return Redirect::back();
    }

    public function chapter_delete()
    {
        $id = request('id');
        $delete = Tbl_brown_lesson_chapter::where('chaper_id', '=', $id)->delete();
        if($delete)
        {
            return "success";
        }
        else
        {
            return 'error';
        }
       
    }
}

