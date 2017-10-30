<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Model\User;

class IndexController extends Controller
{
    //
    public function index()
    {
//        echo 111;
        return  view('admin.index');
    }
    public function info()
    {
//        echo 111;
        return  view('admin.info');
    }

    public function pass()
    {

        if($input = Input::all()){
            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];
            $message=[
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码必须在6-20位之间',
                'password.confirmed'=>'新密码和确认密码不一致',

            ];
            $validator = \Validator::make($input,$rules,$message);
            if($validator->passes()){
//                echo 'yes';
                 $user =  User::first();
                 $_password = \Crypt::decrypt($user->pass);
                // dd($_password);
                 if($input['password_o'] == $_password){
                   //  dd(2222);
                    $user->pass = \Crypt::encrypt($input['password']);
                    $user->update();
                     return back()->with('errors','密码修改成功');
                    //echo 111;
                 }else{
                     return back()->with('errors','原密码错误');
                 }
            }else{

//                dd($validator->errors()->all());
//                echo 'no';
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }
    }

}
