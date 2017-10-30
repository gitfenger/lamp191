<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    //GET    /photo               index       photo.index
    public function index()
    {
        $navs = Nav::orderBy('nav_order','asc')->get();
//        dd($links);
        return view('admin.navs.index',['data'=>$navs]);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $nav = Nav::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $re = $nav->update();
        if($re){
            $data =[
                'status'=>0,
                'msg'=>'导航排序更新成功',
            ];
        }else{
            $data =[
                'status'=>1,
                'msg'=>'导航排序更新失败',
            ];
        }
        return $data;
    }

    //创建网站导航 GET    /photo/create        create      photo.create
    public function create()
    {
        return view('admin.navs.add');
    }

    // 保存网站导航 POST   /photo               store       photo.store
    public function store(){
        $input = Input::except('_token');
        $rules =[
            'nav_name' => 'required',
        ];
        $message=[
            'nav_name.required' =>'导航名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Nav::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //GET    /photo/{photo}/edit  edit        photo.edit
    public function edit($id)
    {
        $field = Nav::find($id);
        return view('admin.navs.edit',compact('field'));
    }

    //       PUT/PATCH   /photo/{photo}  update      photo.update
    public function update($nav_id)
    {
        $input = Input::except('_token','_method');
        $re = Nav::where('nav_id',$nav_id)->update($input);
        if($re){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','导航更新失败，请稍后重试');
        }
    }
    //DELETE  /photo/{photo}      destory     photo.destory
    public function destroy($nav_id)
    {
        $re = Nav::where('nav_id',$nav_id)->delete();

        if($re){
            $data =[
                'status' => 0,
                'msg' => '网站导航删除成功',
            ];
        }else{
            $data =[
                'status' => 1,
                'msg' => '网站导航删除失败，请稍后再试',
            ];
        }
        return $data;
    }
}
