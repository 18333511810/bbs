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
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                              <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                <td top='<?php echo ($v["id"]); ?>'>
                                <?php echo ($v["auth_name"]); ?>
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                    <?php if(is_array($data1)): $i = 0; $__LIST__ = $data1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$i): $mod = ($i % 2 );++$i; if($v["id"] == $i["pid"] ): ?><input name="id[]" type="checkbox" value="<?php echo ($v["contro"]); ?>-<?php echo ($i["method"]); ?>" role_id='<?php echo ($i["id"]); ?>' class='check' > <?php echo ($i["auth_name"]); endif; endforeach; endif; else: echo "" ;endif; ?>
                                    </div>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>      
                        </tbody>
                    </table>
                </div>
                
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
              </div>
            </form>
        </div>
        <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/x-layui.js" charset="utf-8">
        </script>
        <script src="/Public/Admin/js/jquery-1.8.1.min.js" charset="utf-8"></script>
        <script>
            layui.use(['form','layer'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer;

              //监听提交
              form.on('submit(add)', function(data){
                var check=$('.layui-form-checked').prev();
                var top=$('.layui-form-checked').closest('tr').find('td');
                var auth='';
                var id='';
                var top_id='';
                check.each(function(index, el) {
                     auth+=','+$(this).val();
                });
                top.each(function(index, el){
                    if ($(this).attr('top')!=undefined) {
                        top_id+=','+$(this).attr('top');
                    }
                    
                })
                top_id=top_id.substr(1);
                check.each(function(index, el) {
                    id+=','+$(this).attr('role_id');
                }); 
                auth=auth.substr(1);
                 id=top_id+id;

                var name=$('#name').val();
               $.ajax({
                    'url':'/index.php/Admin/Admin/role_add',
                    'type':'post',
                    'data': {'auth_id':id,'auth':auth,'role_name':name},
                    'datatype':'json',
                    'success':function(response){
                        if (response.code==10000) {
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
                });
                return false;
              });
              
            });
           
        </script>
       
        
    </body>

</html>