<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/8/31 0031
 * Time: 22:08
 * 手机号登录
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

if(isset($_POST['mobile']) && !empty($_POST['mobile']) && isset($_POST['code']) && !empty($_POST['code'])) {
    $mobile = addslashes(trim($_POST['mobile']));
    $code = addslashes(trim($_POST['code']));
} else {
    exit('参数错误');
}

$posttime = time()-600;
$sql = "SELECT * FROM member WHERE mobile=$mobile AND code =$code AND code_time > $posttime";
$member = $db->get_row($sql);
if($member){
   // setcookie("mobile",$mobile);
    echo $member;
    exit;
}else{
    echo "短信验证码错误！";
    exit;
}

