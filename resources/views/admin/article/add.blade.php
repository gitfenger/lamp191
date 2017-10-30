@extends('layout.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
</div>
<!--面包屑导航 结束-->
<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加文章</h3>
        @if (count($errors) > 0)
        <!-- 表单错误清单 -->
            <div class="alert alert-danger">
                <strong>哎呀！出了些问题！</strong>
                <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
            <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form id="art_form" action="{{url('admin/article')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120">分类：</th>
                <td>
                    <select name="cate_id">
                        @foreach($data as $d)
                        <option value="{{$d->id}}">{{$d->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i> 文章标题：</th>
                <td>
                    <input type="text" class="lg" name="art_title">
                </td>
            </tr>
            <tr>
                <th>编辑：</th>
                <td>
                    <input type="text" class="sm" name="art_editor">
                </td>
            </tr>
            <tr>
                <th>缩略图：</th>
                <td>
                    {{--<input type="text" size="50" name="art_thumb">--}}
                    <input type="text" size="50" name="art_thumb" id="art_thumb">
                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                    <input type="button" value="上传" />
                    <p><img id="img1" alt="上传后显示图片"  style="max-width:350px;max-height:100px;" /></p>

                    <script type="text/javascript">
                        $(function () {
                            $("#file_upload").change(function () {
                                uploadImage();
                            })
                        })

                        function uploadImage() {
//                            判断是否有选择上传文件
                            var imgPath = $("#file_upload").val();
                            if (imgPath == "") {
                                alert("请选择上传图片！");
                                return;
                            }
                            //判断上传文件的后缀名
                            var strExtension = imgPath.substr(imgPath.lastIndexOf('.') + 1);
                            if (strExtension != 'jpg' && strExtension != 'gif'
                                && strExtension != 'png' && strExtension != 'bmp') {
                                alert("请选择图片文件");
                                return;
                            }
//                            var myform = document.getElementById('art_from');
                            var formData = new FormData($('#art_form')[0]);
                            {{--formData.append('_token', '{{csrf_token()}}');--}}
//                            console.log(formData);
                            $.ajax({
                                type: "POST",
                                url: "/admin/upload",
                                data: formData,
//                                async: true,
//                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(data) {
//                                    console.log(data);
//                                    alert("上传成功");
                                    $('#img1').attr('src','/'+data);
                                    $('#art_thumb').val(data);

                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    alert("上传失败，请检查网络后重试");
                                }
                            });
                        }

                    </script>


                    {{--ajaxFileUpload();--}}
                    {{--$.post("{{url('admin/upload/')}}",{'_token':'{{csrf_token()}}'},function(data){--}}

                    {{--});--}}

                    {{--var arr = $('#file_upload').serialize();--}}
                    {{--//                                $.param(arr);--}}
                    {{--//                                console.log("表单序列化=============="+arr);--}}
                    {{--$.ajax({--}}
                    {{--url:"/admin/upload",--}}
                    {{--data:arr,--}}
                    {{--type:"post",--}}
                    {{--dataType:"json",--}}
                    {{--success:function(data){--}}
                    {{--alert("测试发送接收成功");--}}
                    {{--},--}}
                    {{--error:function(){--}}
                    {{--console.log("失败");--}}
                    {{--}--}}
                    {{--})--}}

                </td>
            </tr>
            <tr>
                <th>关键词：</th>
                <td>
                    <input type="text" class="lg" name="art_tag">
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea name="art_description"></textarea>
                </td>
            </tr>

            <tr>
                <th>文章内容：</th>
                <td>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                    <script id="editor" name="art_content" type="text/plain" style="width:860px;height:300px;"></script>
                    <script type="text/javascript">
                        var ue = UE.getEditor('editor');
                    </script>
                    <style>
                        .edui-default{line-height: 28px;}
                        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                        {overflow: hidden; height:20px;}
                        div.edui-box{overflow: hidden; height:22px;}
                    </style>
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
