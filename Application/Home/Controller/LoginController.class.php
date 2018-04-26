<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller{
	function login(){
		$data=I('post.');
		if (empty($data['username'])) {
			$return=[
				'msg'=>'用户名为空',
				'code'=>10001
			];
			$this->ajaxReturn($return);
		}elseif(empty($data['pass'])){
			$return=[
				'msg'=>'密码为空',
				'code'=>10001
			];
			$this->ajaxReturn($return);
		}elseif (empty($data['code'])) {
			$return=[
				'msg'=>'验证码为空',
				'code'=>10001
			];
			$this->ajaxReturn($return);
		}
			$verify=new \Think\Verify();
			$check=$verify->check($data['code']);
			if(!$check){
				$return=[
				'msg'=>'验证码不正确',
				'code'=>10002
			];
			$this->ajaxReturn($return);
			}

			$model=M('user');
			$res=$model->where(['name'=>$data['username']])->find();
		if (!$res) {
			$res=$model->where(['email'=>$data['username']])->find();
			if (!$res) {
				$return=[
				'msg'=>'用户名不存在',
				'code'=>10001
				];
				$this->ajaxReturn($return);
			}
		}
	

	
		if ($res['userpass'] == encrypt_password($data['pass'])) {
			$return=[
				'msg'=>'登录成功',
				'code'=>10000,
				'username'=>$res['name']
				];
			session('user_info',$res);
			$this->ajaxReturn($return);	
		}else{
			$return=[
				'msg'=>'登录失败',
				'code'=>10001
				];
			$this->ajaxReturn($return);	
		}

	}
	function Lout(){
		if(session('?user_info')){
			session('user_info',null);
			//$this->success('退出成功',U('Home/Index/index'));
	 		$url= $_SERVER['HTTP_REFERER'];
	 		//根据用户的referer值，退出后还是跳转原页面
	 		if(!empty($url)){
	 			header('location:'.$url);
	 		}else{
	 			header('location:http://www.bbs.com/index.php/Home/Index/index');
	 		}
		}else{
			$this->error('退出失败');
		}
	}
	function captcha(){
		$conf=['length'=>4];
		//实例化verify类
		$verify=new \Think\Verify($conf);
		//调用entry方法生成并输出验证码
		$verify->entry();
	}
	function zhuce(){
		if (IS_POST) {
			$data=I('post.');
			$data['createip']=ip2long($_SERVER['REMOTE_ADDR']);
			$user=D('Login')->create();
			if (!$user) {
				$error=$user->getError();
				$return=[
					'code'=>'10001',
					'msg'=>$error
				];
				$this->ajaxReturn($return);
			}
			$res=$user->add();
			if ($res) {
				$user_info=$user->where(['id'=>$res])->find();
				session('user_info',$user_info);
				$return=[
					'code'=>'10000',
					'msg'=>'注册成功',
					'username'=>$user_info['name']
				];
				
			}else{
				$return=[
					'code'=>'10001',
					'msg'=>'注册失败'
				];
			}
			$this->ajaxReturn($return);
		}else{
			$this->display('register/register');
		}
		
	}
	
	public function digui(){
		// $arr=[1,2,3,4,2,2];
		// var_dump(qc($arr));
		 // echo $this->a;
		 echo $a=count(567)+count(null)+count(false);
 	}
}