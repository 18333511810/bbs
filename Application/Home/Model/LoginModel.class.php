<?php
namespace Home\Model;
use Think\Model;
class LoginModel extends Model{
	protected $tableName='user';
	protected $_map = array(
		'user' =>'username',
		'pass'=>'userpass'
		);
	protected $_validate=array(
		['username','require','用户名为空'],
		['userpass','require','密码为空'],
		['email','require','邮箱为空'],
		['email','email ','邮箱格式不正确'],
		['userpass','ypass','两次密码必须一致',0,'confirm'],

	);
	protected $_auto=array(
		array('userpass','encrypt_password',3,'function'),
		array('createtime','currenttime',1,'function'),
		array('auth','新人 ',1,'string'),
	);
}
