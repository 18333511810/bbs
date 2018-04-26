<?php 
//密码加密函数
function encrypt_password($password){
	//加严
	$mi ='dfnghffsfgggkjlkeoiuiasdvnkl';
	return md5( md5($password) . $mi);
}

#递归方法实现权限无限极分类
function getTree($list,$pid=0,$level=0) {
    static $tree = array();
    foreach($list as $row) {
        if($row['pid']==$pid) {
            $row['level'] = $level;
            $tree[] = $row;
            getTree($list, $row['id'], $level + 1);
        }
    }
    return $tree;
}
//时间函数
function currenttime(){
    return date('Y:m:d H:i:s');
}
//递归 实现100累加
function dg($a=1){
    if ($a<=100) {
       return $c=dg($a+1)+$a;
    }
}
//递归 实现100阶乘
function dg1($a=1){
    if ($a<=10) {
       return $c= $a * dg1($a+1) ;
    }
  
}
//去重函数
function qc($arr){
    $len=count($arr);
    for ($i=0; $i <$len ; $i++) { 
       for ($j=$i; $j <$len-$i ; $j++) { 
          if ($arr[$i]==$arr[$j]) {
               array_splice($arr,$arr[$j],1);
            }      
        }  
        
    }
    return $arr;
}





