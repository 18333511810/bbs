<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <title>
            阳光成单系统
        </title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/Public/Admin/css/x-admin.css" media="all">
    </head>
    
    <body>
        <div class="x-body">
            <form class="layui-form" enctype="multipart/form-data" id='fm'>
            
                <div class="layui-form-item">
                    <label for="link" class="layui-form-label">
                        <span class="x-red">*</span>轮播图
                    </label>
                    <div class="layui-input-inline">
                      <div class="site-demo-upbar">
                        <input type="file" name="file" class="layui-upload-file" id="test">
                      </div>
                    </div> 
                </div>

                <div class="layui-form-item">
                    <label  class="layui-form-label">缩略图
                    </label>
                    <img id="LAY_demo_upload" width="400" src="">
                </div>
                <div class="layui-form-item">
                    <label  class="layui-form-label">
                    </label>
                    （由于服务器资源有限，所以此处每次给你返回的是同一张图片)
                </div>
                
                <div class="layui-form-item">
                    <label for="desc" class="layui-form-label">
                        <span class="x-red">*</span>描述
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="desc" name="desc" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <button  class="layui-btn" lay-filter="add" lay-submit="">
                        增加
                    </button>
                </div>
            </form>
        </div>
        <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/x-layui.js" charset="utf-8">
        </script>
         <script src="/Public/Admin/js/jquery-1.8.3.js" charset="utf-8"></script>
        <script>
            layui.use(['form','layer','upload'], function(){
            $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer;


              //图片上传接口
              layui.upload({
                url: '/index.php/Admin/Banner/add' //上传接口
                ,success: function(res){ //上传成功后的回调
                    if (res.code==10000) {
                         $('#LAY_demo_upload').attr('src',res.thum);
                         $('#LAY_demo_upload').attr('imid',res.id);
                    }
                 }
              });
            

              //监听提交
              form.on('submit(add)', function(data){
                var id=$('#LAY_demo_upload').attr('imid');
                var description=$('#desc').val();
                var re={'id':id,'description':description};
                $.ajax({
                    'url':'/index.php/Admin/Banner/add',
                    'type':'post',
                    'data':re,
                    'datatype':'json',
                    'success':function(response){
                        if (response.code==10000) {
                              //发异步，把数据提交给php
                                layer.alert("增加成功", {icon: 6},function () {
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.location.href = '/index.php/Admin/Banner/lis';
                                    //关闭当前frame
                                    parent.layer.close(index);
                                });
                            }else{
                                    //发异步，把数据提交给php
                                layer.alert("增加失败", {icon: 6},function () {
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    //关闭当前frame
                                    parent.layer.close(index);
                                });
                            }
                    }
                })
                return false;
              });
              
              
            });
        </script>
        
    </body>

</html>