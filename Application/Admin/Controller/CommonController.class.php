<?php 
 namespace Admin\Controller;
 use Think\Controller;
 Class CommonController extends Controller{
 	public function __construct(){
 		parent::__construct();	
 		if (!session('?admin_info')) {
 			$this->redirect('Admin/Login/login');
 		}
 		$this->getauth();
 		$this->checkauth();
 	}
 	//菜单栏显示
 	public function getauth(){
 		$role_id=session('admin_info.admin_role');
 		
 		if ($role_id==1) {
 			$top=M('auth')->where('pid=0 and shows=0')->select();
 			$second=M('auth')->where('pid>0 and shows=0')->select();
 		}else{
	 		$auth_id=M('role')->field('auth_id')->where("id=$role_id")->find();

	 		$top=M('auth')->where("id in ({$auth_id['auth_id']}) and pid=0 and shows=0")->select();
	 	
	 		$second=M('auth')->where("id in ({$auth_id['auth_id']}) and pid>0 and shows=0")->select();

		}
		   
			session('top',$top);
			session('second',$second);
	 	}
	 	//权限检测
	 	public function checkauth(){
	 		$role_id=session('admin_info.admin_role');
	 		$contro=CONTROLLER_NAME;

	 		$action=ACTION_NAME;
	 		
	 		$a=$contro."-".$action;

	 		if ($role_id==1) {
	 			return true;
	 		}
	 		if ($a=="Index-index" || $a=="We-index") {
	 			 return true;
	 		}
	 		$auth=M('role')->field('auth')->where("id=$role_id")->find();
	 		
	 		$auth=explode(',',$auth['auth']);
	 		if (!in_array($a,$auth)) {
	 			$this->error('没有此页面的权限',U('Admin/Index/index'));
	 		}
	 	}

 }