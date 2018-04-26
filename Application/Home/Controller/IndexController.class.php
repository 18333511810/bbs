<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$img=D('sheave')->where('show_pic=0')->select();
    	$this->assign('img',$img);
        $this->display();
    }
    public function pubu(){
    	$this->display('pubuliu');
    }
    public function luntan(){
    	$this->display('luntan');
    }
    public function xianlu(){
    	$this->display('xianlu');
    } 
    public function jingcai(){
    	$this->display('jingcai');
    }
    public function zhuangbei(){
    	$this->display('zhuangbei');
    }  
    public function zixun(){
    	$this->display('zixun');
    } 
    public function guanyu(){
    	$this->display('guanyu');
    }

}