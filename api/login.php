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
    $sql = "SELECT * FROM member WHERE mobile=$mobile AND code =$code";
    $member = $db->get_row($sql);
    if(is_array($member) && $member){
        exit(json_encode(array('status'=>1,'member'=>$member)));
    }else{
        exit(json_encode(array('status'=>0,'msg'=>'短信验证码错误')));
    }
}else{
    //exit('参数错误')
    exit(json_encode(array('status'=>0,'msg'=>'参数不对')));
}



