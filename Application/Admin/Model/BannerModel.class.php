<?php
namespace Admin\Model;
use Think\Model;
class BannerModel extends Model{
	//关联数据表
	protected $trueTableName='bbs_sheave';

	public function upload_sheave(){
		$upPath='./Public/Admin/sheaveup/';
		$config=[
			'maxSize'=>10*1024*1024, //0不限制 
			'exts'=>array('jpg','png','gif','jpeg'),
			'rootPath'=>$upPath
		];
		$upload=new \Think\Upload($config);
		$res=$upload->uploadOne($_FILES['file']);
		if (!$res) {
			$this->error=$upload->getError();
			return false;
		}else{
			
			$sheaveup=$upPath.$res['savepath'].$res['savename'];

			//生成200*77.41大小的缩略图
			$image=new \Think\Image();
			$image->open($sheaveup);
			$image->thumb(200,77);
			$small_img=$upPath.$res['savepath'].'small_'.$res['savename'];
			$image->save($small_img);

			//生成1519.2*460大小的剪切图
			$image=new \Think\Image();
			$image->open($sheaveup);
			$image->crop($image->width(),$image->height(),0,0,1519,460);
			$big_img=$upPath.$res['savepath'].'big_'.$res['savename'];
			$image->save($big_img);

			$arr=[];
			$arr['sheave_pic']=substr($big_img, 1);
			$arr['thumbnail']=substr($small_img, 1);
			$res=M('sheave')->add($arr);

			$arr['sheave_pic']=$big_img;
			$arr['thumbnail']=$small_img;
			$arr['id']=$res;
			return $arr;
		}
	}
	public function upload_edit(){
		$upPath='./Public/Admin/sheaveup/';
		$config=[
			'maxSize'=>10*1024*1024, //0不限制 
			'exts'=>array('jpg','png','gif','jpeg'),
			'rootPath'=>$upPath
		];
		$upload=new \Think\Upload($config);
		$res=$upload->uploadOne($_FILES['file']);
		if (!$res) {
			$this->error=$upload->getError();
			return false;
		}else{
			
			$sheaveup=$upPath.$res['savepath'].$res['savename'];

			//生成200*77.41大小的缩略图
			$image=new \Think\Image();
			$image->open($sheaveup);
			$image->thumb(200,77);
			$small_img=$upPath.$res['savepath'].'small_'.$res['savename'];
			$image->save($small_img);

			//生成1519.2*460大小的剪切图
			$image=new \Think\Image();
			$image->open($sheaveup);
			$image->crop($image->width(),$image->height(),0,0,1519,460);
			$big_img=$upPath.$res['savepath'].'big_'.$res['savename'];
			$image->save($big_img);

			$arr=[];
			$arr['sheave_pic']=substr($big_img, 1);
			$arr['thumbnail']=substr($small_img, 1);

			return $arr;
		}
	}
	
}