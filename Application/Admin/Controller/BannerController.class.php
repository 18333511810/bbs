<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\BannerModel;
class BannerController extends CommonController{
	public function lis(){
		$data=M('sheave')->select();
		$this->assign('data',$data);
		$this->display('banner-list');
	}
	public function add(){
		if (IS_POST) {
			$data=I('post.');
			if (!$data['description']) {
				$model=D('Banner');
				$upload_res=$model->upload_sheave();
				if (!$upload_res) {
					$error=$model->getError();
					$return=[
						'code'=>10001,
						'msg'=>'上传失败',
						'error'=>$error
					];
				$this->ajaxReturn($return);
		    }else{
		    	$upload_res['thumbnail']=substr($upload_res['thumbnail'], 1);
				$return=[
						'code'=>10000,
						'msg'=>'上传成功',
						'thum'=>$upload_res['thumbnail'],
						'id'=>$upload_res['id']
					];
				$this->ajaxReturn($return);
			}
		 }
			 $res=M('sheave')->where(['id'=>$data['id']])->save($data);
			 if($res){
			 	$return=[
					'code'=>10000,
					'msg'=>'添加成功'
				];
				$this->ajaxReturn($return);
			 }else{
			 	M('sheave')->where(['id'=>$data['id']])->delete();
			 	$return=[
					'code'=>10001,
					'msg'=>'添加失败'
				];
				$this->ajaxReturn($return);
			 }	
		}else{
		   $this->display('banner-add');
		}
		
	}
	//修改图片
	public function edit(){
		if (IS_POST) {
		$id=I('get.bid');
		$model=D('Banner');
		$upload_res=$model->upload_edit();
		if (!$upload_res) {
			$error=$model->getError();
			$return=[
				'code'=>10001,
				'msg'=>'上传失败',
				'error'=>$error
			];
		$this->ajaxReturn($return);
		}else{
			$return=[
					'code'=>10000,
					'msg'=>'上传成功',
					'thum'=>$upload_res['thumbnail'],
					'sheave_pic'=>$upload_res['sheave_pic']
				];
			$path="I:/www/bbs/";
			$data=M('sheave')->where(['id'=>$id])->find();
			$res=unlink($path.$data['sheave_pic']);
			$res1=unlink($path.$data['thumbnail']);

			$this->ajaxReturn($return);
		}
		}else{
			$id=I('get.id');
			$data=D('sheave')->where(['id'=>$id])->find();
			$this->assign('data',$data);
			$this->display('banner-edit');
		}
	}
	//修改数据库信息
	public function dbedit(){
		$data=I('post.');
		$res=M('sheave')->where(['id'=>$data['id']])->save($data);
		if ($res) {
			$return=[
				'code'=>10000
			];
		}else{
			$return=[
				'code'=>10001
			];
		}
		$this->ajaxReturn($return);
	}
	//状态修改
	public function state(){
		$data=I('get.');

		if ($data['a1']==1) {
			$res=M('Sheave')->where(['id'=>$data['id']])->setField('show_pic',1);
		}else{
			$res=M('Sheave')->where(['id'=>$data['id']])->setField('show_pic',0);
		}
		if ($res) {
			$return=[
				'code'=>10000,

			];
		}else{
			$return=[
				'code'=>10001,

			];
		}
		$this->ajaxReturn($return);
	}
	public function del(){
		$id=I('post.id');
		$path="I:/www/bbs/";
		$data=M('sheave')->where(['id'=>$id])->find();

		$res=unlink($path.$data['sheave_pic']);
		$res1=unlink($path.$data['thumbnail']);
		if ($res==1||$res1==1) {
			$res=M('sheave')->where(['id'=>$id])->delete();
			if ($res) {
				$return=[
				'code'=>10000,

				];
			}else{
				$return=[
				'code'=>10001,

				];
			}
			$this->ajaxReturn($return);
		}
	}
}