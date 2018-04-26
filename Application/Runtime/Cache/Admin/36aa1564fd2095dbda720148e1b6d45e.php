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
        <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>会员管理</cite></a>
              <a><cite>权限规则</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <form class="layui-form x-center" action="" style="width:70%">
                <div class="layui-form-pane" style="margin-top: 15px;">
                  <div class="layui-form-item">
                  <div class="layui-input-inline" style="width:120px;text-align: left">
                        <select name="fid">
                            <option value="0">顶级分类</option>
                            <?php if(is_array($rule)): $i = 0; $__LIST__ = $rule;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["auth_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="contro"  placeholder="控制器" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                      <input type="text" name="method"  placeholder="方法" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                      <input type="text" name="authname"  placeholder="权限名称" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:80px">
                        <button class="layui-btn"  lay-submit="" lay-filter="*"><i class="layui-icon">&#xe608;</i>添加</button>
                    </div>
                  </div>
                </div> 
            </form>
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><span class="x-right" style="line-height:40px">共有数据：<?php echo ($count); ?> 条</span></xblock>
            <table class="layui-table" id='example'>
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="" value="">
                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            权限名字
                        </th>
                        <th>
                           权限控制器
                        </th>
                        <th>
                           权限方法
                        </th>
                        <td>
                            是否展示
                        </td>
                        <th>
                            操作
                        </th>
                    </tr>
                </thead>
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tbody id="x-link">
                    <tr>
                        <td>
                            <input type="checkbox" value="1" name="">
                        </td>
                        <td>
                            <?php echo ($v["id"]); ?>
                        </td>
                        <td>
                            <?php echo (str_repeat("&emsp;&nbsp;",$v["level"])); echo ($v['level']+1); ?>.<?php echo ($v["auth_name"]); ?>
                        </td>
                        <td>
                            <?php echo ($v["contro"]); ?>
                        </td>
                        <td>
                            <?php echo ($v["method"]); ?>
                        </td>
                       
                         <td class="td-status"> 
                         <?php if( $v["shows"] == 0 ): ?><span class="layui-btn layui-btn-normal layui-btn-mini">
                           显示                          
                            </span>
                                 <?php else: ?>
                        <span class="layui-btn layui-btn-disabled layui-btn-mini">不显示</span><?php endif; ?>
                        </td>
                        <td class="td-manage">
                         <?php if( $v["shows"] == 0 ): ?><a style="text-decoration:none" onclick="admin_stop(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="不显示">
                                <i class="layui-icon">&#xe601;</i></a>
                         <?php else: ?>
                        <a style="text-decoration:none" onClick="admin_start(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="显示"><i class="layui-icon">&#xe62f;</i></a><?php endif; ?> 
                            <a title="编辑" href="javascript:;" onclick="rule_edit('编辑','/index.php/Admin/Admin/rule_edit/id/<?php echo ($v["id"]); ?>','4','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="rule_del(this,'<?php echo ($v["id"]); ?>')" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>

            <div id="page"></div>
        </div>
        <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8"></script>
        <script src="/Public/Admin/js/x-layui.js" charset="utf-8"></script>
        <script src="/Public/Admin/js/jquery-1.8.1.min.js" charset="utf-8"></script>
        <!-- <script src="/Public/Admin/js\datatables\1.10.0/jquery.dataTables.min.js" charset="utf-8"></script> -->
        <script>
            layui.use(['element','laypage','layer','form'], function(){
                $ = layui.jquery;//jquery
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层
              form = layui.form();//弹出层

              //监听提交
              form.on('submit(*)', function(data){
                var contro=$("input[name='contro']").val();
                var method=$("input[name='method']").val();
                var auth_name=$("input[name='authname']").val();
                var top_id=$(".layui-this").attr('lay-value');

                var data1={'contro':contro,'method':method,'auth_name':auth_name,'pid':top_id};

                 $.ajax({
                'url':'/index.php/Admin/Admin/rule',
                'type':'post',
                'data': data1,
                'datatype':'json',
                'success':function(response){
                    if (response.code==10000) {
                        layer.alert("增加成功", {icon: 6});
                    $('#x-link').prepend('<tr><td><input type="checkbox"value="1"name=""></td><td>'+response.id+'</td><td>'+auth_name+'</td><td>'+contro+'</td><td>'+method+'</td><td>展示</td><td class="td-manage"><a title="编辑"href="javascript:;"onclick="rule_edit(\'编辑\',\'/index.php/Admin/Admin/rule_edit\',\'4\',\'\',\'510\')"class="ml-5"style="text-decoration:none"><i class="layui-icon">&#xe642;</i></a> <a title="删除"href="javascript:;"onclick="rule_del(this,'+response.id+')"style="text-decoration:none"><i class="layui-icon">&#xe640;</i></a></td></tr>');
                    }else{
                         layer.alert("增加失败", {icon: 6});
                    }
                }
         });
                return false;
    });
})

              //以上模块根据需要引入
        /*不显示*/
        function admin_stop(obj,id){
            window.$obj=obj;
            layer.confirm('确认要停用吗？',function(index){
                console.log(id);
            var url='/index.php/Admin/Admin/rule_state';
               ajax_1(url,id);
                
            });
        }
        /*显示*/
        function admin_start(obj,id){
            window.$obj_0=obj;
            layer.confirm('确认要启用吗？',function(index){
               var url='/index.php/Admin/Admin/rule_state';
               ajax_1(url,id);
                //发异步把用户状态进行更改 
            });
        }

            //ajax状态修改
            function ajax_1(url,id){
             $.ajax({
                'url':url,
                'type':'post',
                'data': {'id':id},
                'datatype':'json',
                'success':function(response){
                   if (response.code==10000) {
                        if (response.state==1) {
                            //发异步把用户状态进行更改
                        $(window.$obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="admin_start(this,'+id+')" href="javascript:;" title="启用"><i class="layui-icon">&#xe62f;</i></a>');
                        $(window.$obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-disabled layui-btn-mini">不显示</span>');
                        $(window.$obj).remove();
                        layer.msg('不显示!',{icon: 5,time:1000});
                    }else{
                        $(window.$obj_0).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="admin_stop(this,'+id+')" href="javascript:;" title="停用"><i class="layui-icon">&#xe601;</i></a>');
                        $(window.$obj_0).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-normal layui-btn-mini">显示</span>');
                        $(window.$obj_0).remove();
                        layer.msg('显示!',{icon: 6,time:1000});
                        }
                   }else{
                       layer.msg('修改失败',{icon: 6,time:1000}); 
                    }
                 }
              })                
          }
            //批量删除提交
             function delAll () {
                layer.confirm('确认要删除吗？',function(index){
                    //捉到所有被选中的，发异步进行删除
                    layer.msg('删除成功', {icon: 1});
                });
             }
            
            

            //-编辑
            function rule_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h); 
            }
            
            /*删除*/
            function rule_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                    if (index) {
                        $.ajax({
                        'url':'/index.php/Admin/Admin/rule_del',
                        'type':'post',
                        'data': {'id':id},
                        'datatype':'json',
                        'success':function(response){
                                if (response.code==10000) {
                                    $(obj).parents("tr").remove();
                                    layer.msg('已删除!',{icon:1,time:1000});
                                }else{
                                     layer.msg('删除失败',{icon:1,time:1000});
                                }
                        }
                      });

                    }
                 
                });
            }

            </script>
            
    </body>
</html>