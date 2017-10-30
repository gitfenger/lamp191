<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    //
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(2);
       return view('admin.article.index',compact('data'));
    }

    // admin/article/create 添加文章
    public function create()
    {

        $data =  Category::tree();
//        dd( $data);
        return view('admin.article.add',compact('data'));
    }

    // post admin/category   category.store
    public function store(Request $request)
    {

        $input = Input::except(['_token','file_upload']);
        $input['art_time'] = time();
        $input['art_thumb'] =  $this->postFileupload($request);
//        dd($input);
        $rules = [
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'文章名称不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $re = Article::create($input);
            if($re){
                $data = Article::orderBy('art_id','desc')->paginate(2);
                return redirect('admin/article')->with('data',$data);

            }else{
                return back()->with('errors','数据填充失败，请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    public function postFileupload($input){
        //判断请求中是否包含name=file的上传文件
        if(!$input->hasFile('file_upload')){
            exit('上传文件为空！');
        }
        $file = $input->file('file_upload');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = 'test/'.$newFileName;
        $bytes = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        if(!Storage::exists($savePath)){
            exit('保存文件失败！');
        }
        return $savePath;
//        header("Content-Type: ".Storage::mimeType($savePath));
//        echo Storage::get($savePath);
    }

    public function edit($art_id)
    {
        $field = Article::where('art_id',$art_id)->first();
//        dd($field);
        $data = Category::tree();
        return view('admin.article.edit',compact('field','data'));
    }

    //        admin/category/{category}
    public function update($id)
    {
//        $input = Input::all();
//        dd($input);
        $input = Input::except('_token','_method');
        $re = Article::where('art_id',$id)->update($input);
        if(false){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章更新失败，请稍后重试');
        }
        //dd($re);
    }

    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            $data =[
                'status' => 0,
                'msg' => '文章删除成功',
            ];
        }else{
            $data =[
                'status' => 1,
                'msg' => '文章删除失败，请稍后再试',
            ];
        }
        return $data;
    }

    public function test()
    {
        return view('admin.article.test');
    }

}
