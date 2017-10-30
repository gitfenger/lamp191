<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    //首页
    public function index()
    {
        //点击量最高的6篇文章（站长推荐）
        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        //图文列表5篇（带分页）
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $links = Link::orderBy('link_order','asc')->get();

        return view('home.index',compact('pics','data','links'));
    }

    //分类页
    public function cate($cate_id)
    {
        //根据传过来的一级类的ID查询出此一级类下所有的二级类

//        dd($data);
        //查看次数自增
        Category::where('id',$cate_id)->increment('view');

        //当前分类的子分类
        $submenu = Category::where('pid',$cate_id)->get();
        //声明一个数组存放二级类
        $subitems = [];
        foreach ($submenu as $k=>$v){
            $subitems[] = $v->id;
        }
//        dd($subitems);

        //图文列表4篇 （带分页）
        $data = Article::whereIn('cate_id',$subitems)->orderBy('art_time','desc')->paginate(4);
//        dd($data);

        $field = Category::find($cate_id);
//        dd($field);
        return view('home.list',compact('field','data','submenu'));
    }

    public function article($art_id)
    {
//        echo $art_id;
        $field = Article::Join('category','article.cate_id','=','category.id')->where('art_id',$art_id)->first();
        //查看次数自增
//        Article::find($art_id)->increment('art_view');
        Article::where('art_id',$art_id)->increment('art_view');
        //上一篇文章
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        //下一篇
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
//        dd( $article['next']);
        //六篇相似的文章
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
//        dd($data);
        return view('home.new',compact('field','article','data'));
    }

}
