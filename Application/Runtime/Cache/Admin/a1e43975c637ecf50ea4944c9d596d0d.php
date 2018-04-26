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
        <form action='/index.php/Admin/Article/add' method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="L_title" class="layui-form-label">
                        标题
                    </label>
                    <div class="layui-input-block">
                        <input type="text" id="L_title" name="title" required lay-verify="title"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <div class="layui-input-block">
                        <textarea id="L_content" name="content" 
                        placeholder="请输入内容" class="layui-textarea fly-editor" style="height: 260px;"></textarea>
                    </div>
                    <label for="L_content" class="layui-form-label" style="top: -2px;">
                        描述
                    </label>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">
                            所在类别
                        </label>
                        <div class="layui-input-block">
                            <select lay-verify="required" name="cid">
                                    <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">
                            用户
                        </label>
                        <div class="layui-input-block">
                            <select lay-verify="required" name="cid">
                                   <?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option id='cate_id' value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
               <div class="layui-form-item">
                    <div id='pic1'></div>
                    <input type='file' name='file' class="layui-upload-file">
                </div>

                <div class="layui-form-item">
                    <button class="layui-btn" lay-filter="add" lay-submit>
                        立即发布
                    </button>
                </div>
        </div>
        <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/x-layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/jquery-1.8.1.min.js" charset="utf-8">
        </script>
        <script>
            layui.use(['form','layer','upload','layedit'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer,
              layedit = layui.layedit;

               //
                layedit.set({
                    uploadImage: {
                        url: '/index.php/Admin/Article/upload/img/1', //接口url
                        type: 'post', //默认post
                    }
                });

              editIndex = layedit.build('L_content');
             

              //图片上传接口
              layui.upload({
                // url: './upload.json' //上传接口
                // ,success: function(res){ //上传成功后的回调
                //     console.log(res);
                //   $('#LAY_demo_upload').attr('src',res.url);
                // }
                url: '/index.php/Admin/Article/upload' //上传接口
                ,success: function(res){ //上传成功后的回调
                    if (res.code==10000) {
                        $('#pic1').html("<img src='"+res.pic+"' width='200' id='img1'></img>");
                         // $('#LAY_demo_upload').attr('src',res.pic);
                    }
                 }
              });
            

              //监听提交
              form.on('submit(add)', function(data){
                var content=layedit.getContent(editIndex);
                var user_id=$(".layui-this:last").attr('lay-value');
                var cate_id=$(".layui-this").attr('lay-value');
                var img=$('#img1').attr('src');
                var data={
                    'title':$('#L_title').val(),
                    'content':content,
                    'user_id':user_id,
                    'cate_id':cate_id,
                    'pic':img
                }
                $.ajax({
                    'url':'/index.php/Admin/Article/add',
                    'type':'post',
                    'data':data,
                    'dataType':'json',
                    'success':function(response){
                        if(response.code == 10000){
                            //发异步，把数据提交给php
                            layer.alert("增加成功", {icon: 6},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
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
<!--          <script>
            layui.use(['form','layer','layedit'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer
              ,layedit = layui.layedit;


                layedit.set({
                  uploadImage: {
                    url: "./upimg.json" //接口url
                    ,type: 'post' //默认post
                  }
                })
  
            //创建一个编辑器
            editIndex = layedit.build('L_content');
            
              

              //监听提交
              // form.on('submit(add)', function(data){
              //   console.log(data);
              //   //发异步，把数据提交给php
              //   layer.alert("增加成功", {icon: 6},function () {
              //       // 获得frame索引
              //       var index = parent.layer.getFrameIndex(window.name);
              //       //关闭当前frame
              //       parent.layer.close(index);
              //   });
              //   return false;
              // });
              
              
            });
        </script>
 -->
    </body>

</html>