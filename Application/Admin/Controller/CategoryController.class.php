<?php 
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends CommonController{
	public function category(){
		$data=D('forumtype')->select();
		$data=getTree($data);
		$this->assign('data',$data);
		$this->display();
	}
	public function edit(){
		if (IS_POST) {
			$data=I('post.');
			$res=M('forumtype')->where(['id'=>$data['id']])->save($data);
		  if ($res) {
				$return=[
				'code'=>10000,
				'msg'=>'修改成功',
			];
			$this->ajaxReturn($return); 
			}else{
					$return=[
				'code'=>10000,
				'msg'=>'修改失败',
			];
			$this->ajaxReturn($return); 
		  }

		}else{
			$id=I('get.id');
			$data=M('forumtype')->where("id=$id")->find();
			//顶级不让修改分类
			if ($data['pid']!=0) {
				$top=M('forumtype')->where("pid=0")->select();		
			}else{
				$top=[['id'=>0,'name'=>$data['name']]];
			}
				$this->assign('top',$top);
				$this->assign('data',$data);
				$this->display('cate-edit');
		}
		
	}
	public function add(){
		$data=I('post.');
		$res=M('forumtype')->add($data);
		if ($res) {
			$a=M('forumtype')->where("id=$res")->find();
			$return=[
				'code'=>10000,
				'msg'=>'增加成功',
				'name'=>$a['name'],
				'id'=>$a['id']
			];
			$this->ajaxReturn($return); 
		}else{
			$return=[
				'code'=>10001,
				'msg'=>'增加失败'
			];
			$this->ajaxReturn($return); 
		}
	}
	public function del(){
		$id=I('post.id');
		$model=D('forumtype');
		$res=$model->where("pid=$id")->find();
		if ($res) {
			$return=[
			'code'=>10001,
			'msg'=>'顶级权限'
			];
			$this->ajaxReturn($return);
		}
		$res=$model->where(['id'=>$id])->delete();
		if($res){
			$return=[
			'code'=>10000,
			'msg'=>'删除成功'
			];
			$this->ajaxReturn($return);
		}else{
			$return=[
			'code'=>10001,
			'msg'=>'删除失败'
			];
			$this->ajaxReturn($return);
		}
	}
}