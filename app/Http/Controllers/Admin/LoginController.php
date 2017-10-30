<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
require_once 'resources/org/code/Code.class.php';

use App\SMS\M3Result;
//use App\TempPhone;
use App\SMS\SendTemplateSMS;

use App\resources\org\code\Code;



class LoginController extends Controller
{
    //
    public function login()
    {
//        echo 11222;
//       $pdo =  DB::connection()->getPdo();
//       dd($pdo);
//       $users = DB::table('user')->get();
//       dd($users);
        return view('admin.login');
    }

    public function code()
    {
//        $code = new Code();
//        $code->make();

    }
    //退出登录
    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    public function getcode()
    {
        $code = new \Code();
        echo $code->get();
    }


    public function sendSMS(Request $request,$type){

        $m3_result = new M3Result();

        $sendTemplateSMS = new SendTemplateSMS();
        $code = '';
        $charset = '1234567890';
        $_len = strlen($charset)-1;
        for($i=0;$i<6;++$i){
            $code .= $charset[mt_rand(0,$_len)];
        }

        $m3_result = $sendTemplateSMS->sendTemplateSMS('13718426719',array($code,60),$type);

        return $m3_result->toJson();
    }

    public function dologin()
    {

        if($input = Input::all()){
            $code = new Code;
            $_code = $code->get();
            if(strtoupper($input['code']) != $_code){
                return back()->with('msg','验证码错误');
            }
            $user = User::first();
            if($user->name != $input['name'] || Crypt::decrypt($user->pass) != $input['pass']){
                return back()->with('msg','用户名或密码错误');
            }
            session(['user'=>$user]);
            //dd(session('user')->id);
            return redirect('admin/index');
        }else{
            return view('admin.login');
        }
    }

    public function crypt()
    {
        $str = "123456";
        echo Crypt::encrypt($str);
        echo "<br>";
        $str_p = "eyJpdiI6ImZDdlwvVFJqU2kyYkR0eWJnSmkwMXFRPT0iLCJ2YWx1ZSI6ImJXWU5lT2dkd0lESUlCZ0FrenFPOHc9PSIsIm1hYyI6ImExNWRhMjFiMmY0ZDcxMjBkMjZkNDkxOTI1ZTE1MGY1OTFkNjJjOTJjYWQxMDc5NmIzM2FkMzE4NTI5YWMxZDEifQ";
        echo Crypt::decrypt($str_p);
    }
}
