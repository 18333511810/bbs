<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController{
	public function lis(){
		//连表展示数据
		$user = D('User')->alias('u')->field('u.id,u.del,u.name,i.sex,i.phone,u.email,i.domicile,u.createtime')->join('join bbs_info as i on u.id = i.id')->where(['del'=>'0'])->select();
		//赋值变量
		$this->assign('user',$user);
		$this->display('member-list');
	}
	public function add(){
		if(IS_POST){
			//接收数据
           $data = I('post.');
           // dump($data);die;
           //获取IP
           $ip = $_SERVER['REMOTE_ADDR'];
           //将ip转为int类型
           $data['lastip'] = ip2long($ip);
           //设置当前时间戳
           $data['createtime']=date('Y-m-d H:i:s');
      // dump($data);die;
           //将数据添加到数据表
           $arr = [];
           $arr=[
             'name'=>$data['name'],
             'userpass'=>$data['userpass'],
             'email'=>$data['email'],
             'createtime'=>$data['createtime'],
             'lastip' => $data['lastip'] 
           ];          
           $res=D('User')->add($arr);
          $arr = [
          	'id'=>$res,
             'sex' =>$data['sex'],
             'domicile'=>$data['domicile'],
             'phone'=>$data['phone']
            ];
          $res = D('Info')->add($arr);
          //判断结果
          if($res){
          	$return=[
              'code'=>10000,
              'msg'=>'添加成功' 
          	];
          }else{
          	$return=[
              'code'=>10001,
              'msg'=>'添加失败'
          	];
          	
          }
         //回调
          $this->ajaxReturn($return);         
		}else{
		//调用模板
		   $this->display('member-add');
		}
		
	}
	public function edit(){
		    if(IS_POST){
               $data= I('post.');
               // dump($data);die;
                $arr = [];
           $arr=[
           	 'id' =>$data['id'],
             'name'=>$data['name'],
             'email'=>$data['email'],
           ];          
       		$res = D('User')->save($arr);
	          $arr = [
	          	 'id'=>$data['id'],
	             'sex' =>$data['sex'],
	             'domicile'=>$data['domicile'],
	             'phone'=>$data['phone']
	            ];

	           $model= D('Info');
          	   $res = $model->save($arr);
          	   // dump($res);die;
               if($res !== false){
                  $return = [
                    'code' => '10000',
                    'msg' => '修改成功'
                  ];
               }else{
               	  $return = [
                    'code'=>'10001',
                    'msg'=>'修改失败' 
               	  ];
               }
               $this->ajaxReturn($return);
            }else{
               $id = I('get.id');
		    // dump($id);die;
		    $user = D('User')->alias('u')->field('u.id,u.del,u.name,u.userpass,i.sex,i.phone,u.email,i.domicile')->join('join bbs_info as i on u.id = i.id')->where(['u.id'=>$id])->find();
		    // dump($user);die;
		    $this->assign('user',$user);
			$this->display('member-edit');
		    }
		    
	}
	public function delete(){
		 $id = I('get.id');
            $res = D('User')->where(['id'=>$id])->setField('del','1');
            if($res){
              $return=[
                'code'=>'10000',
                'msg'=>'删除成功'
              ];
            }else{
              $return=[
                'code'=>'10001',
                'msg'=>'删除失败'
              ];	
            }
            $this->ajaxReturn($return);
		
	}
	public function password(){
			$this->display('member-password');
	}
	public function del(){
		    $user = D('User')->alias('u')->field('u.id,u.del,u.name,i.sex,i.phone,u.email,i.domicile,u.createtime')->join('join bbs_info as i on u.id=i.id')->where(['del'=>'1'])->select();;
		    $this->assign('user',$user);
			$this->display('member-del');
	}
	public function restore(){
		$id = I('get.id');
       // dump($id);die;    
		$res = D('User')->where(['id'=>$id])->setField('del','0');
		// dump($res);die;
		if($res){
           $return = [
              'code'=>'10000',
              'msg'=> '恢复成功'
           ];
		}else{
			$return = [
              'code'=>'10001',
              'msg'=>'恢复失败'
			];
		}
      $this->ajaxReturn($return);
	}
	public function thorough(){
		$id = I('get.id');
		$res = D('User')->where(['id'=>$id])->delete();
		$res = D('Info')->where(['id'=>$id])->delete();
		if($res !== false){
          $return = [
            'code'=>'10000',
            'msg'=>'删除成功'
          ];
		}else{
			$return = [
             'code'=>'10001',
             'msg'=>'删除失败'
			];
		}
		$this->ajaxReturn($return);
	}
	public function level(){
			$this->display('member-level');
	}
	public function kiss(){
			$data=D('Score')->alias('s')->field('s.id,s.user_id,s.incident,s.detail,s.score,u.name')->join('left join bbs_user as u on s.user_id = u.id')->select();
			//dump($data);
			$this->assign('data',$data);
			$this->display('member-kiss');

	}
	public function view(){
			$this->display('member-view');
	}
	public function kissadd(){
		if(IS_POST){
			$data=I('post.');
			$model=D('score');
			$arr=[
				'user_id'=>$data['user_id'],
				'incident'=>$data['incident'],
				'detail'=>$data['detail'],
				'score'=>$data['score'],
				'add_time'=>date('Y-m-d H:i:s')
			];
			// dump($arr);
			$res=$model->add($arr);
			if($res){
				$return=[
					'code'=>10000,
					'msg'=>'添加成功'
				];
				$this->ajaxReturn($return);
			}else{
				$return=003
				+[
					'code'=>10001,
					'msg'=>'添加失败'
				];
			}
			$this->ajaxReturn($return);
		}
		$this->display('kiss-add');
	}
	public function kissedit(){
			$this->display('kiss-edit');
	}
	public function kissdel(){
			$id=I('post.id');
			$model=D('Score');
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
	public function show(){
			$this->display('member-show');
	}
	public function leveladd(){
			$this->display('level-add');
	}
	public function leveledit(){
			$this->display('level-edit');
	}
}
