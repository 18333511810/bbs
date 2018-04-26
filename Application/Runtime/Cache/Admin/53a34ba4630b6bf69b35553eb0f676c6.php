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
              <a><cite>会员删除</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <form class="layui-form x-center" method="get" action="" style="width:80%">
                <div class="layui-form-pane" style="margin-top: 15px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label">日期范围</label>
                    <div class="layui-input-inline">
                      <input class="layui-input" placeholder="开始日" id="LAY_demorange_s">
                    </div>
                    <div class="layui-input-inline">
                      <input class="layui-input" placeholder="截止日" id="LAY_demorange_e">
                    </div>
                    <div class="layui-input-inline">
                      <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:80px">
                        <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                    </div>
                  </div>
                </div> 
            </form>
            <xblock><button class="layui-btn layui-btn-danger" onclick="recoverAll()"><i class="layui-icon">&#xe640;</i>批量恢复</button><span class="x-right" style="line-height:40px">共有数据：88 条</span></xblock>
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
                            用户名
                        </th>
                        <th>
                            性别
                        </th>
                        <th>
                            手机
                        </th>
                        <th>
                            邮箱
                        </th>
                        <th>
                            地址
                        </th>
                        <th>
                            加入时间
                        </th>
                        <th>
                            状态
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php if(is_array($user)): $k = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                        <td>
                            <input type="checkbox" value="1" name="">
                        </td>
                        <td>
                            <?php echo ($v["id"]); ?>
                        </td>
                        <td>
                            <u style="cursor:pointer" onclick="member_show('张三','member-show.html','10001','360','400')">
                             <?php echo ($v["name"]); ?>
                            </u>
                        </td>
                        <td >
                            <?php echo ($v["sex"]); ?>
                        </td>
                        <td >
                            <?php echo ($v["phone"]); ?>
                        </td>
                        <td >
                            <?php echo ($v["email"]); ?>
                        </td>
                        <td >
                            <?php echo ($v["domicile"]); ?>
                        </td>
                        <td>
                            <?php echo ($v["createtime"]); ?>
                        </td>
                        <td class="td-status">
                            <span class="layui-btn layui-btn-danger layui-btn-mini">
                                已删除
                            </span>
                        </td>
                        <td class="td-manage">
                            <a style="text-decoration:none" onclick="member_recover(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="恢复">
                                <i class="layui-icon">&#xe618;</i>
                            </a>
                            <a title="彻底删除" href="javascript:;" onclick="member_unset(this,'<?php echo ($v["id"]); ?>')" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>

            <div id="page"></div>
        </div>
        <script src="/Public/Admin/lib/layui/layui.js" charset="utf-8"></script>
        <script src="/Public/Admin/js/x-layui.js" charset="utf-8"></script>
        <script>
            layui.use(['laydate','element','laypage','layer'], function(){
                $ = layui.jquery;//jquery
              laydate = layui.laydate;//日期插件
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层

              //以上模块根据需要引入

              laypage({
                cont: 'page'
                ,pages: 100
                ,first: 1
                ,last: 100
                ,prev: '<em><</em>'
                ,next: '<em>></em>'
              }); 
              
              var start = {
                min: laydate.now()
                ,max: '2099-06-16 23:59:59'
                ,istoday: false
                ,choose: function(datas){
                  end.min = datas; //开始日选好后，重置结束日的最小日期
                  end.start = datas //将结束日的初始值设定为开始日
                }
              };
              
              var end = {
                min: laydate.now()
                ,max: '2099-06-16 23:59:59'
                ,istoday: false
                ,choose: function(datas){
                  start.max = datas; //结束日选好后，重置开始日的最大日期
                }
              };
              
              document.getElementById('LAY_demorange_s').onclick = function(){
                start.elem = this;
                laydate(start);
              }
              document.getElementById('LAY_demorange_e').onclick = function(){
                end.elem = this
                laydate(end);
              }
              
            });

            //批量恢复提交
             function recoverAll () {
                layer.confirm('确认要批量恢复吗？',function(index){
                    //捉到所有被选中的，发异步进行恢复
                    layer.msg('恢复成功', {icon: 1});
                });
             }

            /*用户-恢复*/
            function member_recover(obj,id){
                layer.confirm('确认要恢复吗？',function(index){
                    // console.log(index);
                    if(index){
                        $.ajax({
                        'url':'/index.php/Admin/User/restore',
                        'type':'get',
                        'data':{'id':id},
                        'dataType':'json',
                        'success':function(response){
                            // console.log(id);
                           if(response.code == 10000){
                              $(obj).parents("tr").remove();
                              layer.msg('已恢复!',{icon:1,time:1000});
                           }else{
                             $(obj).parents("tr").remove();
                              layer.msg('恢复失败!',{icon:1,time:1000});
                           }
                        } 
                     });
                    }                 
                });
            }
            /*用户-彻底删除*/
            function member_unset(obj,id){
                layer.confirm('彻底删除无法恢复，确认要删除数据吗？',function(index){
                    if(index){
                       $.ajax({
                        'url':'/index.php/Admin/User/thorough',
                        'type':'get',
                        'data':{'id':id},
                        'dataType':'json',
                        'success':function(response){
                            if(response.code == 10000){
                                $(obj).parents("tr").remove();
                                layer.msg('已彻底删除',{icon:1,time:1000});
                           }else{
                                 $(obj).parents("tr").remove();
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