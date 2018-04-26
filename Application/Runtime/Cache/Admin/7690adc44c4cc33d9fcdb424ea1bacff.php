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
              <a><cite>轮播列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="banner_add('添加用户','/index.php/Admin/Banner/add','600','500')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：88 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="" value="">
                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            缩略图
                        </th>
                        <th>
                            描述
                        </th>
                        <th>
                            显示状态
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                </thead>
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tbody id="x-img">
                    <tr>
                        <td>
                            <input type="checkbox" value="1" name="">
                        </td>
                        <td>
                            <?php echo ($v["id"]); ?>
                        </td>
                        <td>
                            <img  src="<?php echo ($v["thumbnail"]); ?>" width="200" alt=""> 点击图片试试
                        </td>
                        <td >
                            <?php echo ($v["description"]); ?>
                        </td>
                        <td class="td-status">
                            <?php if( $v["show_pic"] == 0 ): ?><span class="layui-btn layui-btn-normal layui-btn-mini">
                                已显示
                            </span>
                            <?php else: ?>
                             <span class="layui-btn layui-btn-disabled layui-btn-mini">
                                不显示
                            </span><?php endif; ?>
                        </td>
                        <td class="td-manage">
                            <?php if( $v["show_pic"] == 0 ): ?><a style="text-decoration:none" onclick="banner_stop(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="不显示">
                                <i class="layui-icon">&#xe601;</i>
                            </a>
                             <?php else: ?>
                             <a style="text-decoration:none" onClick="banner_start(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="显示"><i class="layui-icon">&#xe62f;</i></a><?php endif; ?>
                            <a title="编辑" href="javascript:;" onclick="banner_edit('编辑','/index.php/Admin/Banner/edit/id/<?php echo ($v["id"]); ?>','4','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="banner_del(this,'<?php echo ($v["id"]); ?>')" 
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
        <script src="/Public/Admin/js/jquery-1.8.3.js" charset="utf-8"></script>
        <script>
              layui.use(['laydate','element','laypage','layer'], function(){
              $ = layui.jquery;//jquery
              laydate = layui.laydate;//日期插件
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层

              //以上模块根据需要引入

                layer.ready(function(){ //为了layer.ext.js加载完毕再执行
                  layer.photos({
                    photos: '#x-img'
                    //,shift: 5 //0-6的选择，指定弹出图片动画类型，默认随机
                  });
                }); 
              
            });

            //批量删除提交
             function delAll () {
                layer.confirm('确认要删除吗？',function(index){
                    //捉到所有被选中的，发异步进行删除
                    layer.msg('删除成功', {icon: 1});
                });
             }
             /*添加*/
            function banner_add(title,url,w,h){
                x_admin_show(title,url,w,h);
            }
             /*停用*/
            function banner_stop(obj,id){
                layer.confirm('确认不显示吗？',function(index){
                    if (index) {
                        $.ajax({
                            url:'/index.php/Admin/Banner/state',
                            type:'get',
                            data:{'a1':1,'id':id},
                            'datatype':'json',
                            'success':function(response){
                                if (response.code==10000) {
                                    //发异步把用户状态进行更改
                                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="banner_start(this,'+id+')" href="javascript:;" title="显示"><i class="layui-icon">&#xe62f;</i></a>');
                                    $(obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-disabled layui-btn-mini">不显示</span>');
                                    $(obj).remove();
                                    layer.msg('不显示!',{icon: 6,time:1000});
                                }else{

                                    layer.msg('修改失败!',{icon: 5,time:1000});
                                }
                            }
                        })
                    }
                    
                });
            }

            /*启用*/
            function banner_start(obj,id){
                layer.confirm('确认要显示吗？',function(index){
                      if (index) {
                        $.ajax({
                            'url':'/index.php/Admin/Banner/state',
                            'type':'get',
                            'data':{'a1':2,'id':id},
                            'datatype':'json',
                            'success':function(response){
                                if (response.code==10000) {
                                    //发异步把用户状态进行更改
                                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="banner_stop(this,'+id+')" href="javascript:;" title="不显示"><i class="layui-icon">&#xe601;</i></a>');
                                    $(obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-normal layui-btn-mini">已显示</span>');
                                    $(obj).remove();
                                    layer.msg('已显示!',{icon: 6,time:1000});
                                }else{

                                    layer.msg('修改失败!',{icon: 5,time:1000});
                                }
                            }
                        })
                    }
                    
                   
                });
            }
            // 编辑
            function banner_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h); 
            }
            /*删除*/
            function banner_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                    if(index){
                        $.ajax({
                            url:'/index.php/Admin/Banner/del',
                            type:'post',
                            'data':{'id':id},
                            datatype:'json',
                            'success':function(response){
                                if (response.code==10000) {
                                     //发异步删除数据
                                    $(obj).parents("tr").remove();
                                    layer.msg('已删除!',{icon:1,time:1000});
                                }else{
                                      layer.msg('删除失败',{icon:5,time:1000});
                                }
                            }
                        })
                    }
                   
                });
            }
            </script>
            
    </body>
</html>