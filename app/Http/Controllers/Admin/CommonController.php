<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //
    public function upload()
    {
//        $input = Input::file('file_upload');
//        $input = Input::all();
//        dd($input);
//        dd($_POST['imgPath']);
        $file = Input::file('file_upload');

        if($file->isValid()){
            $entension = $file->getClientOriginalExtension();//上传文件的后缀名
            $newName = date('YmdHis').mt_rand(1000,9999).'.'.$entension;
            $path = $file->move(base_path().'/uploads',$newName);
            $filepath = 'uploads/'.$newName;
            return  $filepath;
        }
    }
}
