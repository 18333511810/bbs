<?php 
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class ArticleController extends CommonController{
	public function lis(){
		$model=D("Article");
		$data=$model->alias('a')->limit($page->firstRow.','.$page->listRows)->field('a.id,a.titile,a.cate_id,a.content,u.name,a.createtime,a.pv')->join('left join bbs_user as u on a.user_id=u.id')->select();
		$zs=" ................";
		foreach ($data as &$v) {
			$v['content']=mb_substr($v['content'],0,10,'utf-8').$zs;	
		}
		//开始分页 
		$count=$model->count();//总条数
		// $page=new page($count,3);//实例化分页类 传入总记录数和每页显示的记录数
		// $show= $page->show();// 分页显示输出

		$this->assign('page',$count);// 赋值分页输出
		$this->assign('data',$data);
		$this->display('article-list');
	}
	public function add(){
	    if(IS_POST){
				$data=I('post.');
				$data['createtime']=date('Y-m-d H:i:s');
				$arr=[
					'user_id'=>(int)$data['user_id'],
					'titile'=>$data['title'],
					'content'=>$data['content'],
					'createtime'=>$data['createtime'],
					'cate_id'=>(int)$data['cate_id'],
					'uptime'=>date('Y-m-d H:i:s'),
					'pic'=>$data['pic']			
				];
				$res=D('article')->add($arr);
			if($res){
				$return=[
					'code'=>10000,
					'msg'=>'添加成功'
				];
				$this->ajaxReturn($return);
			}else{
				$return=[
					'code'=>10001,
					'msg'=>'添加失败'
				];
			}
				$this->ajaxReturn($return);
		}else{
				$user=D('User')->field('id,name')->select();
				$type=D('forumtype')->field('id,name')->select();
				$this->assign('user',$user);
				$this->assign('type',$type);
				$this->display('article-add');
		}
	}
	public function edit(){
		if (IS_POST) {
			$data=I('post.');
			$data['uptime']=date('Y-m-d H:i:s');
			$res=M('article')->where(['id'=>$data['id']])->save($data);
			if ($res) {
				$return=[
					'code'=>10000,
					'msg'=>'添加成功'
				];
				$this->ajaxReturn($return);
			}else{
				$return=[
					'code'=>10001,
					'msg'=>'添加失败'
				];
				$this->ajaxReturn($return);
			}

		}else{
			$id=I('get.id');
			$art=M('article')->where("id=$id")->find();
			$type=M('forumtype')->select();
			$user=M('user')->select();
			$this->assign('art',$art);
			$this->assign('type',$type);
			$this->assign('user',$user);
			$this->display('article-edit');
		}	
	}
	public function del(){
		$id=I('post.id');
		$res=M('article')->where("id=$id")->delete();
		if ($res) {
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
	public function upload(){
		if (!empty($_FILES)) {
			$id=I('get.img')?I('get.img'):0;
		  if ($id==0) {
			$res=D('article')->upload_sheave();
			if ($res) {
				$return=[
					'code'=>10000,
					'pic'=>substr($res, 1)
				];
				$this->ajaxReturn($return);
			}
			$return=[
					'code'=>10001
				];
			$this->ajaxReturn($return);
			}else{

			$res=D('article')->upload_sheave($id);
			if ($res) {
				$res=substr($res, 1);
				$return=[
					'code'=>0,
					'msg'=>'成功',
					'data'=>['src'=>"$res"],
				];
				$this->ajaxReturn($return);
			}
			$return=[
					'code'=>10001
				];
			$this->ajaxReturn($return);
		}

		}else{
			$return=[
					'code'=>10002
				];
			$this->ajaxReturn($return);

		}


	}

}