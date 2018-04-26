<?php 
namespace Admin\Model;
use Think\Model;
/**
* 
*/
class ArticleModel extends Model
{
	public function upload_sheave($id=0){
		if ($id==1) {
			$upPath='./Public/Admin/artimg/';
		}else{
			$upPath='./Public/Admin/picimg/';
		}
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
		}else{;
			if ($id==1) {

				$sheaveup=$upPath.$res['savepath'].$res['savename'];
				return $sheaveup;
			}else{
			$sheaveup=$upPath.$res['savepath'].$res['savename'];
			//生成200*77.41大小的缩略图
			$image=new \Think\Image();
			$image->open($sheaveup);
			$image->thumb(280,200);
			$small_img=$upPath.$res['savepath'].date('YmdHis').$res['savename'];
			$image->save($small_img);

			return $small_img;
			}
			
		}

	}

}