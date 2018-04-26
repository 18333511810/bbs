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
              <a><cite>管理员列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <form class="layui-form x-center" action="" style="width:80%">
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
                      <input type="text" name="username"  placeholder="请输入登录名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:80px">
                        <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                    </div>
                  </div>
                </div> 
            </form>
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="admin_add('添加用户','/index.php/Admin/Admin/add','600','500')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?php echo ($count); ?> 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="" value="0"  id='checkall'>
                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            登录名
                        </th>
                        <th>
                            手机
                        </th>
                        <th>
                            邮箱
                        </th>
                        <th>
                            角色
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
                <?php if(is_array($data)): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tbody>
                    <tr>
                        <td>
                            <input type="checkbox" value="0" name="check" onclick="check_1(this)" admin_id="<?php echo ($v['id']); ?>">
                        </td>
                        <td>
                            <?php echo ($v['id']); ?>
                        </td>
                        <td>
                            <?php echo ($v['admin_name']); ?>
                        </td>
                        <td >
                            <?php echo ($v['admin_phone']); ?>
                        </td>
                        <td >
                            <?php echo ($v['admin_mail']); ?>
                        </td>
                        <td >
                            <?php echo ($v['role_name']); ?>
                        </td>
                        <td>
                            <?php echo ($v['create_time']); ?>
                        </td>
                         
                        <td class="td-status">
                        <?php if($v["admin_state"] == 0 ): ?><span class="layui-btn layui-btn-normal layui-btn-mini">
                           已启用                          
                            </span>
                           <?php else: ?>
                           <span class="layui-btn layui-btn-disabled layui-btn-mini">已停用</span><?php endif; ?> 
                        </td>
                        <td class="td-manage">
                        <?php if($v["admin_state"] == 0 ): ?><a style="text-decoration:none" onclick="admin_stop(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="停用">
                                <i class="layui-icon">&#xe601;</i></a>
                         <?php else: ?>
                        <a style="text-decoration:none" onClick="admin_start(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="启用"><i class="layui-icon">&#xe62f;</i></a><?php endif; ?> 
                           
                            <a title="编辑" href="javascript:;" onclick="admin_edit('编辑','/index.php/Admin/Admin/edit/id/<?php echo ($v['id']); ?>','4','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="admin_del(this,'<?php echo ($v["id"]); ?>')" 
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

            //批量删除提交
             function delAll () {
                layer.confirm('确认要删除吗？',function(index){
                    //  var inp=$("input[checked='checked']").attr('admin_id');
                    // console.log(inp)
                    var data='';
                    $("input[checked='checked'][name='check']").each(function(){
                        data+=','+$(this).attr('admin_id');
                    })
                     data=data.substr(1);
                     $.ajax({
                    'url':'/index.php/Admin/Admin/delAll',
                    'type':'post',
                    'data': {'id':data},
                    'datatype':'json',
                    'success':function(response){
                        if (response.code==10000) {
                             layer.msg('删除成功', {icon: 1});
                             $("input[checked='checked'][name='check']").closest('tbody').remove();
                         }else{
                            layer.msg('删除失败', {icon: 1});
                        }
                   } 
               });

                  //捉到所有被选中的，发异步进行删除
                   
                });
             }
             /*添加*/
            function admin_add(title,url,w,h){
                x_admin_show(title,url,w,h);
            }

             /*停用*/
            function admin_stop(obj,id){
                window.$obj=obj;
                layer.confirm('确认要停用吗？',function(index){
                    console.log(id);
                var url='/index.php/Admin/Admin/admin_state';
                   ajax_1(url,id);
                    
                });
            }

            /*启用*/
            function admin_start(obj,id){
                 window.$obj_0=obj;
                layer.confirm('确认要启用吗？',function(index){
                   var url='/index.php/Admin/Admin/admin_state';
                   ajax_1(url,id);
                    //发异步把用户状态进行更改
                    
                });
            }
            //编辑
            function admin_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h); 
            }
            /*删除*/
            function admin_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                //ajax删除
                $.ajax({
                'url':'/index.php/Admin/Admin/admin_del',
                'type':'post',
                'data': {'id':id},
                'datatype':'json',
                'success':function(response){
                    if(response.code==10000){
                     //发异步删除数据
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                 }else{
                     layer.msg('删除失败!',{icon:1,time:1000});
                 }
                }
              });
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
                    $(window.$obj).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-disabled layui-btn-mini">已停用</span>');
                    $(window.$obj).remove();
                    layer.msg('已停用!',{icon: 5,time:1000});
                }else{
                $(window.$obj_0).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="admin_stop(this,'+id+')" href="javascript:;" title="停用"><i class="layui-icon">&#xe601;</i></a>');
                $(window.$obj_0).parents("tr").find(".td-status").html('<span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>');
                $(window.$obj_0).remove();
                layer.msg('已启用!',{icon: 6,time:1000});
                }
               }else{
                   layer.msg('修改失败',{icon: 6,time:1000}); 
               }
            }
            })   
               
        }
        //全选
      $('#checkall').on('click',function(){
        var val=$('#checkall').val();
            if (val==0) {
                $("input[name='check']").attr('checked',true);    
                $('#checkall').val('1');
            }else{
                $("input[name='check']").attr('checked',false);
                $('#checkall').val('0');
            }
    
      });
      function check_1(this_){
            var val=$(this_).val();
            if (val==0) {
                $(this_).attr('checked',true);
                $(this_).val('1');
                if($("input[checked='checked']").length==$("input[name='check']").length){
                   $('#checkall').attr('checked',true);
                   $('#checkall').val('1');
                }
            }else{
                $(this_).attr('checked',false);
                $(this_).val('0');
                 if($("input[checked='checked']").length-1!=$("input[name='check']").length){
                    $('#checkall').attr('checked',false);
                    $('#checkall').val('0');
                }
            }
      }



            </script>
            
    </body>
</html>