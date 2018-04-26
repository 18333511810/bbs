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
            <form class="layui-form">
             <div class="layui-form-item">
                    <label for="level-name" class="layui-form-label">
                        <span class="x-red">*</span>用户
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="level-name" name="level-name" required="" lay-verify="required"
                        autocomplete="off"  class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="level-name" class="layui-form-label">
                        <span class="x-red">*</span>事件
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="level-event" name="level-name" required="" lay-verify="required"
                        autocomplete="off"  class="layui-input">
                    </div>
                </div>
 				<div class="layui-form-item">
                    <label for="level-kiss" class="layui-form-label">
                        <span class="x-red">*</span>详细
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="level-detail" name="level-kiss" required=""  lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="level-kiss" class="layui-form-label">
                        <span class="x-red">*</span>积分
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="level-score" name="level-kiss" required=""  lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <button  class="layui-btn" lay-filter="save" lay-submit="">
                        保存
                    </button>
                </div>
            </form>
        </div>
        <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/x-layui.js" charset="utf-8">
        </script>
        <script>
            layui.use(['form','layer'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer;
            
              //监听提交
              form.on('submit(save)', function(data){
                 var data={
                        'user_id':$('#level-name').val(),
                        'incident':$('#level-event').val(),
                        'detail':$('#level-detail').val(),
                        'score':$('#level-score').val()
                    }
                console.log(data);
                $.ajax({
                        'url':'/index.php/Admin/User/kissadd',
                        'type':'post',
                        'data':data,
                        'dataType':'json',
                        'success':function(response){
                            if (response.code==10000) {
                                layer.alert("修改成功", {icon: 6},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                            }else{
                                layer.alert("修改失败", {icon: 6},function () {
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    //关闭当前frame
                                    parent.layer.close(index);
                                });

                            }
                        }
                    });



                //发异步，把数据提交给php
                // layer.alert("修改成功", {icon: 6},function () {
                //     // 获得frame索引
                //     var index = parent.layer.getFrameIndex(window.name);
                //     //关闭当前frame
                //     parent.layer.close(index);
                // });
                return false;
              });
              
              
            });




                // $(':submit').click(function(){
                //     var data={
                //         'user_id':$('#user_id').val(),
                //         'incident':$('incident').val(),
                //         'detail':$('detail').val()
                //     }
                //     console.log(data);
                //     $.ajax({
                //         'url':'/index.php/Admin/User/add',
                //         'type':'post',
                //         'data':data,
                //         'dataType':'json',
                //         'success':function(response){
                //             if(response.code == 10000){
                //                 layer.alert("修改成功", {icon: 6},function () {
                //                     var index = parent.layer.getFrameIndex(window.name);
                //                     parent.layer.close(index);
                //                 });
                //             }
                //         }
                //     });
                // });




            
        </script>
        
    </body>

</html>