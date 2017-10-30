<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //GET    /photo               index       photo.index
    public function index()
    {
        $categorys =  Category::tree();
        return view('admin.category.index',['data'=>$categorys]);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->order = $input['cate_order'];
        $re = $cate->update();
        if($re){
            $data =[
                'status'=>0,
                'msg'=>'分类排序更新成功',
            ];
        }else{
            $data =[
                'status'=>1,
                'msg'=>'分类排序更新失败',
            ];
        }
        return $data;
    }

    //创建友情链接 GET    /photo/create        create      photo.create
    public function create()
    {
        $data = Category::where('pid',0)->get();
        return view('admin.category.add',compact('data'));
    }

    // 保存友情链接 POST   /photo               store       photo.store
    public function store(){
        $input = Input::except('_token');
        $rules =[
            'name' => 'required',
        ];
        $message=[
            'name.required' =>'分类名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Category::create($input);
            if($re){
                return redirect('admin/category');
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
        $field = Category::find($id);
        $data = Category::where('pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }

    //       PUT/PATCH   /photo/{photo}  update      photo.update
    public function update($id)
    {
        $input = Input::except('_token','_method');
        $re = Category::where('id',$id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类信息更新失败，请稍后重试');
        }
    }
    //DELETE  /photo/{photo}      destory     photo.destory
    public function destroy($cate_id)
    {
       $re = Category::where('id',$cate_id)->delete();
       Category::where('pid',$cate_id)->update(['pid'=>0]);
       if($re){
           $data =[
               'status' => 0,
               'msg' => '分类删除成功',
           ];
       }else{
           $data =[
               'status' => 1,
               'msg' => '分类删除失败，请稍后再试',
           ];
       }
       return $data;
    }

}
