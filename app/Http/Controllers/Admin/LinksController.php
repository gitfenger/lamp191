<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //GET    /photo               index       photo.index
    public function index()
    {
        $links = Link::orderBy('link_order','desc')->get();
//        dd($links);
        return view('admin.links.index',['data'=>$links]);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $link = Link::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $re = $link->update();
        if($re){
            $data =[
                'status'=>0,
                'msg'=>'友情链接排序更新成功',
            ];
        }else{
            $data =[
                'status'=>1,
                'msg'=>'友情链接排序更新失败',
            ];
        }
        return $data;
    }

    //创建友情链接 GET    /photo/create        create      photo.create
    public function create()
    {
        return view('admin.links.add');
    }

    // 保存友情链接 POST   /photo               store       photo.store
    public function store(){
        $input = Input::except('_token');
        $rules =[
            'link_name' => 'required',
        ];
        $message=[
            'link_name.required' =>'链接名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Link::create($input);
            if($re){
                return redirect('admin/links');
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
        $field = Link::find($id);
        return view('admin.links.edit',compact('field'));
    }

    //       PUT/PATCH   /photo/{photo}  update      photo.update
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        $re = Link::where('link_id',$link_id)->update($input);
        if($re){
            return redirect('admin/links');
        }else{
            return back()->with('errors','友情链接更新失败，请稍后重试');
        }
    }
    //DELETE  /photo/{photo}      destory     photo.destory
    public function destroy($link_id)
    {
        $re = Link::where('link_id',$link_id)->delete();

        if($re){
            $data =[
                'status' => 0,
                'msg' => '友情链接删除成功',
            ];
        }else{
            $data =[
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后再试',
            ];
        }
        return $data;
    }
}
