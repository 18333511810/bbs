<?php
namespace Admin\Controller;
use Think\Controller;
class CommentController extends CommonController{
	public function lis(){
		$this->display('comment-list');
	}
	public function feedback(){
		$this->display('feedback-edit');
	}

}