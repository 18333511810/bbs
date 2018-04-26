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
    <form class="layui-form" method="post">
           <input type="hidden" name="id" id="id" value='<?php echo ($user["id"]); ?>'> 
     <div class="layui-form-item">
      <label for="L_username" class="layui-form-label"> <span class="x-red">*</span>用户名 </label>
      <div class="layui-input-inline">
        <input type="text" id="name" name="name" value="<?php echo ($user["name"]); ?>" required lay-verify="nikename"
                        autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label for="L_repass" class="layui-form-label"> <span class="x-red">*</span>性别 </label>
       <div class="layui-inline">
          <input type="radio" name="sex" value='男'<?php if( $user["sex"] == 男 ): ?>checked='checked'<?php endif; ?> 
           title="男">
          <input type="radio" name="sex" value='女'<?php if( $user["sex"] == 女 ): ?>checked='checked'<?php endif; ?>title="女">               
          <input type="radio" name="sex" value='保密'<?php if( $user["sex"] == 保密 ): ?>checked='checked'<?php endif; ?> title="保密">               
    </div>
    <div class="layui-form-item">
      <label for="L_repass" class="layui-form-label"> <span class="x-red">*</span>手机 </label>
      <div class="layui-input-inline">
        <input type="text" id="phone" name="phone" value="<?php echo ($user["phone"]); ?>" required lay-verify="repass"
                        autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label for="L_email" class="layui-form-label"> <span class="x-red">*</span>邮箱 </label>
      <div class="layui-input-inline">
        <input type="text" id="email" name="email" value="<?php echo ($user["email"]); ?>" required lay-verify="email"
                        autocomplete="off" class="layui-input" value="">
      </div>
      <div class="layui-form-mid layui-word-aux"> <span class="x-red">*</span>必填 </div>
    </div>
    <div class="layui-form-item">
      <label for="L_repass" class="layui-form-label"> <span class="x-red">*</span>地址 </label>
      <div class="layui-input-inline">
        <input type="text" id="domicile" name="domicile" value="<?php echo ($user["domicile"]); ?>" required lay-verify="repass"
                        autocomplete="off" class="layui-input">
      </div>
    </div>
    
    <div class="layui-form-item">
      <label for="L_repass" class="layui-form-label"> </label>
      <input type="submit" class="layui-btn" lay-filter="add" lay-submit="" value="编辑">
      <!-- <button  class="layui-btn" lay-filter="add" lay-submit=""> 增加 </button> -->
    </div>
  </form>
</div>
            </form>
        </div>
        <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/x-layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/jquery-1.8.1.min.js"></script>
        <script>

            

            layui.use(['form','layer'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer;
            
              //自定义验证规则
              form.verify({
                nikename: function(value){
                  if(value.length < 5){
                    return '昵称至少得5个字符啊';
                  }
                }
                ,pass: [/(.+){6,12}$/, '密码必须6到12位']
                ,repass: function(value){
                    if($('#L_pass').val()!=$('#L_repass').val()){
                        return '两次密码不一致';
                    }
                }
              });
                        
              //监听提交
              form.on('submit(add)', function(data){
                var data ={
                    'id':$('#id').val(),
                   'name':$('#name').val(),
                   'sex':$('input:radio:checked').val(),
                   'phone':$('#phone').val(),
                   'email':$('#email').val(),
                   'domicile':$('#domicile').val() 
                }
                console.log(data);
                $.ajax({
                    'url':'/index.php/Admin/User/edit',
                    'type':'post',
                    'data':data,
                    'dataType':'json',
                    'success':function(response){
                        if(response.code == 10000){
                             layer.alert("修改成功", {icon: 6},function () {
                             // 获得frame索引
                             var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                             parent.layer.close(index);
                             parent.location.href = '/index.php/Admin/User/lis';
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
                return false;
              });
              
              
            });
        </script>
        
    </body>

</html>