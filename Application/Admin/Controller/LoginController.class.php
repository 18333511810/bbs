<?php 
namespace Admin\Controller;
use Think\Controller;
 class LoginController extends Controller{
	//后台登录页
	public function login(){
		//一个方法处理两个逻辑
		if(IS_POST){
			//post 请求  表单提交
			//接收参数
			$username =I('post.username');
			$password =I('post.password');
			//验证码
			$code =I('post.code');
			//参数检测
			if(empty($username)||empty($password)){
				$this ->error('参数不全');
			}
			//根据用户名查询bbs_admin表
			$info =D('admin') ->where(['admin_name'=>$username])->find();
			//如果查询到用户，则比对密码
			if($info && $info['admin_pass'] == encrypt_password($password)){
				//用户名存在且密码一致，登陆成功
				//设置登录标识
				session('admin_info',$info);
				$this ->success('登录成功',U('Admin/Index/index'));
			}else{
				//登录失败
				$this ->error('用户名或密码错误');
			}
		}else{
			//页面展示
			//如果已登录 可以直接跳转到后台首页
			//如果已登录 也可以自动退出重新打开登录页面
			if(session('?admin_info')){
				session('admin_info','');
			}
			$this ->display();
		}
	}
}



