<?php

namespace App\Providers;

use App\Http\Model\Article;
use App\Http\Model\Nav;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //点击量最高的6篇文章
//        $hot = Article::orderBy('art_view','desc')->take(5)->get();
//        //最新发布的8篇文章
//        $new = Article::orderBy('art_time','desc')->take(8)->get();
//
//        //所有的导航栏目
//        $navs = Nav::all();
//
//        view()->share('navs', $navs);
//        view()->share('hot', $hot);
//        view()->share('new', $new);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
