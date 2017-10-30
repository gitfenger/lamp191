@extends('layout.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo;  <a href="{{url('admin/links')}}">全部友情链接</a>
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors) > 0)
                <div class="'mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增链接</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-plus"></i>全部链接</a>

            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/links/'.$field->link_id)}}" method="post">
            <table class="add_tab">
                <tbody>
                {{method_field('PUT')}}
                {{csrf_field()}}
                <tr>
                    <th>链接名称：</th>
                    <td>
                        <input type="text" name="link_name" value="{{$field->link_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>链接名称不能为空</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>url：</th>
                    <td>
                        <input type="text" class="lg" name="link_url" value="{{$field->link_url}}">
                    </td>
                </tr>
                <tr>
                    <th>链接标题：</th>
                    <td>
                        <input type="text" class="lg" name="link_title" value="{{$field->link_title}}">
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" class="sm" name="link_order" value="{{$field->link_order}}">
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection