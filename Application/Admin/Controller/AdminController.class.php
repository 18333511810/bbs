<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends CommonController{
	public function lis(){
		//管理员表与角色表连表查询数据
		$data=D('admin')->alias('a')->join('left join bbs_role as r  on a.admin_role=r.id')->field('a.*,r.role_name')->select();
		$count=D('admin')->count();
		$this->assign('count',$count);
		
		$this->assign('data',$data);
		// dump($data);
		$this->display('admin-list');

	}

	public function add(){
		// echo 1;die();
		if(IS_POST){
			$data=I('post.');
			//判空
			if (empty($data["adminname"])||empty($data["adminpass"])||empty($data["adminphone"])||empty($data["adminemail"])||empty($data["adminroleid"])) {
				$return=array(
				'code'=>10001,
				'msg'=>'数据为空'
				);
				$this->ajaxReturn($return);
			}
			//判断用户名是否重复
			$repeat=D('admin')->where(['admin_name'=>$data['adminname']])->find();
			if ($repeat!=null) {
				$return=array(
				'code'=>10001,
				'msg'=>'账号重复'
				);
				$this->ajaxReturn($return);
			}
			$data['adminpass']=encrypt_password($data['adminpass']);
			$data['create_time']=date('Y-m-d H:i:s');
			$data['login_ip']=ip2long($_SERVER['REMOTE_ADDR']);
			$admin=D('admin');
			$admin->create($data);
			$res=$admin->add();
			if ($res) {
				$return=array(
				'code'=>10000,
				'msg'=>'插入成功'
				);
				$this->ajaxReturn($return);
			}else{
				$return=array(
				'code'=>10001,
				'msg'=>'插入失败'
				);
				$this->ajaxReturn($return);
			}
					
		}else{
			$data=M('role')->select();
			$this->assign('data',$data);
			$this->display('admin-add');
		}
		
	}
	public function edit(){
		if (IS_POST) {
			$data=I('post.');
			if (empty($data["adminname"])||empty($data["adminpass"])||empty($data["adminphone"])||empty($data["adminemail"])||empty($data["adminroleid"])) {
				$return=array(
				'code'=>10001,
				'msg'=>'数据为空'
				);
				$this->ajaxReturn($return);
			}
			$data['adminpass']=encrypt_password($data['adminpass']);
			$admin=D('admin');
			$admin->create($data);
			$res=$admin->save();
			if ($res) {
				$return=array(
				'code'=>10000,
				'msg'=>'插入成功'
				);
				$this->ajaxReturn($return);
			}else{
				$return=array(
				'code'=>10001,
				'msg'=>'插入失败'
				);
				$this->ajaxReturn($return);
			}
		}else{
			$id=I('get.id');
			$data=D('admin')->find(['id'=>$id]);
			$role=M('role')->select();
			$this->assign('role',$role);
			$this->assign('data',$data);
			$this->display('admin-edit');	
		}
			
	}
	public function role(){
		$data=D('role')->select();
		$this->assign('data',$data);
		$this->display('admin-role');

	}
	public function role_del(){
		$id=I('post.id');
		if (empty($id)) {
			$return=array(
				'code'=>10001,
				'msg'=>'数据为空'
			);
		   $this->ajaxReturn($return);
		}
		$res=D('role')->where(['id'=>$id])->delete();
		if ($res) {
			$return=array(
				'code'=>10000,
				'msg'=>'删除成功'
			);
		   $this->ajaxReturn($return);
		}else{
			$return=array(
				'code'=>10001,
				'msg'=>'删除失败'
			);
		   $this->ajaxReturn($return);
		}

	}
	public function rule(){
		if(IS_POST){
			$data=I('post.');

			$res=D('auth')->add($data);
			if ($res) {
				$retuen=[
				'id'=>$res,
				'code'=>'10000',
				'msg'=>'添加成功'

				];
				$this->ajaxReturn($retuen);
			}else{
				$retuen=[
				'code'=>'10001',
				'msg'=>'添加失败'

				];
				$this->ajaxReturn($retuen);
			}
		}
		$data=D('auth')->select();
		$count=D('auth')->count();
		$rule=D('auth')->where('pid=0')->select();
		$data=getTree($data);
		
		$this->assign('count',$count);
		$this->assign('rule',$rule);
		$this->assign('data',$data);
		$this->display('admin-rule');

	}
	public function role_edit(){
		if (IS_POST) {
			$data=I('post.');
			$res=D('role')->save($data);
			if(res){
				$retuen =[
				'code'=>'10000',
				'msg'=>'修改成功'
			];
			$this->ajaxReturn($retuen);
			}else{
				$retuen =[
				'code'=>'10001',
				'msg'=>'修改失败'
			];
			$this->ajaxReturn($retuen);
			}



		}else{
			$id=I('get.id');
			$data=D('auth')->where(['pid'=>0])->select();
			$data1=D('auth')->where('pid > 0')->select();
			$role=D('role')->where("id=$id")->find();
			$this->assign('role',$role['auth_id']);
			$this->assign('role_name',$role['role_name']);
			$this->assign('id',$role['id']);
			$this->assign('data',$data);
			$this->assign('data1',$data1);
			$this->display('role-edit');
			
		}
	}
	public function role_add(){
		if (IS_POST) {
		$data=I('post.');
		if (empty($data['role_name'])||empty($data['auth_id'])||empty($data['auth'])) {
			$retuen =[
				'code'=>'10001',
				'msg'=>'数据为空'
			];
			$this->ajaxReturn($retuen);
		}
		$res=D('role')->add($data);
		if ($res) {
			$retuen =[
				'code'=>'10000',
				'msg'=>'插入成功'
			];
			$this->ajaxReturn($retuen);
		}else{
			$retuen =[
				'code'=>'10001',
				'msg'=>'插入失败'
			];
			$this->ajaxReturn($retuen);
		}

		}else{
			$data=D('auth')->where(['pid'=>0])->select();
			$data1=D('auth')->where('pid > 0')->select();
			
			$this->assign('data',$data);
			$this->assign('data1',$data1);
			$this->display('role-add');
		}
		
	}
	//更改管理员状态
	public function admin_state(){
		$id=I('post.id');
		if (empty($id)) {
			$retuen =[
				'code'=>'10001',
				'msg'=>'id为空'
			];
			$this->ajaxReturn($retuen);
		}	
			
		$res=D('admin')->where(['id'=>$id])->find();
		
		if ($res==null) {
			$retuen =[
				'code'=>'10001',
				'msg'=>'管理员不存在'
			];
			$this->ajaxReturn($retuen);
		}
		if ($res['admin_state']==0) {
			$data=D('admin')->where(['id'=>$id])->setField('admin_state','1');
			$state='1';
		}else{
			$data=D('admin')->where(['id'=>$id])->setField('admin_state','0');
			$state='0';
		}
		if ($data!=0) {
			$retuen =[
				'code'=>'10000',
				'state'=>$state,
				'msg'=>'修改成功'
			];
			$this->ajaxReturn($retuen);
		}else{
			$retuen =[
				'code'=>'10001',
				'msg'=>'修改失败'
			];
			$this->ajaxReturn($retuen);
		}
		
	}
	//更改权限显示状态
	public function rule_state(){
		$id=I('post.id');
		if (empty($id)) {
			$retuen =[
				'code'=>'10001',
				'msg'=>'id为空'
			];
			$this->ajaxReturn($retuen);
		}	
			
		$res=D('auth')->where(['id'=>$id])->find();
		
		if ($res==null) {
			$retuen =[
				'code'=>'10001',
				'msg'=>'权限不存在'
			];
			$this->ajaxReturn($retuen);
		}
		if ($res['shows']==0) {
			$data=D('auth')->where(['id'=>$id])->setField('shows','1');
			$state='1';
		}else{
			$data=D('auth')->where(['id'=>$id])->setField('shows','0');
			$state='0';
		}
		if ($data!=0) {
			$retuen =[
				'code'=>'10000',
				'state'=>$state,
				'msg'=>'修改成功'
			];
			$this->ajaxReturn($retuen);
		}else{
			$retuen =[
				'code'=>'10001',
				'msg'=>'修改失败'
			];
			$this->ajaxReturn($retuen);
		}
		
	}

	public function admin_del(){
		$id=I('post.id');
		if (empty($id)) {
			$retuen=[
			'code'=>'10001',
			'msg'=>'id为空'

			];
			$this->ajaxReturn($retuen);
		}
		$res=D('admin')->where(['id'=>$id])->find();
		if ($res==null) {
			$retuen=[
			'code'=>'10001',
			'msg'=>'不存在用户'

			];
			$this->ajaxReturn($retuen);
		}
		$data=D('admin')->where(['id'=>$id])->delete();
		if ($data) {
			$retuen=[
			'code'=>'10000',
			'msg'=>'删除成功'

			];
			$this->ajaxReturn($retuen);
		}else{
			$retuen=[
			'code'=>'10001',
			'msg'=>'删除失败'

			];
			$this->ajaxReturn($retuen);
		}

	}
	public function delAll(){
		$id=I('post.id');
		if (empty($id)) {
			$retuen=[
			'code'=>'10001',
			'msg'=>'id为空'

			];
			$this->ajaxReturn($retuen);
		}
		$res=D('admin')->delete($id);
		if ($res!=false && $res!=0) {
			$retuen=[
			'code'=>'10000',
			'msg'=>'删除成功'

			];
			$this->ajaxReturn($retuen);
		}else{
			$retuen=[
			'code'=>'10001',
			'msg'=>'删除失败'

			];
			$this->ajaxReturn($retuen);
		}

	}
	public function rule_edit(){
		if (IS_POST) {
			$data=I('post.');
			$res=M('auth')->where(["id"=>$data['id']])->save($data);
			if ($res) {
				$retuen=[
				'code'=>'10000',
				'msg'=>'修改成功'

				];
				$this->ajaxReturn($retuen);
			}else{
				$retuen=[
				'code'=>'10000',
				'msg'=>'修改失败'

				];
				$this->ajaxReturn($retuen);
			}


		}else{
			$id=I('get.id');
			$data=M('auth')->where("id=$id")->find();
			$this->assign('data',$data);
			$this->display('link-edit');
		}
		
	}
	public function rule_del(){
		$id=I('post.id');
		$res=M('auth')->where("pid=$id")->find();
		if ($res) {
			$retuen=[
			'code'=>'10001',
			'msg'=>'顶级权限不能删除'

			];
			$this->ajaxReturn($retuen);
			die;
		}
		$res=M('auth')->where(['id'=>$id])->delete();
		if ($res) {
			$retuen=[
			'code'=>'10000',
			'msg'=>'删除成功'

			];
			$this->ajaxReturn($retuen);
		}else{
			$retuen=[
			'code'=>'10001',
			'msg'=>'删除失败'

			];
			$this->ajaxReturn($retuen);
		}
	}


}