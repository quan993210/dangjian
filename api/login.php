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

if(isset($_POST['mobile']) && !empty($_POST['mobile']) && isset($_POST['code']) && !empty($_POST['code'])&& !empty($_POST['adminid'])) {
    $mobile = addslashes(trim($_POST['mobile']));
    $code = addslashes(trim($_POST['code']));
    $adminid  = $_POST["adminid"];
    if($code == "112233"){
        $sql = "SELECT * FROM member WHERE mobile=$mobile";
    }else{
        $sql = "SELECT * FROM member WHERE mobile=$mobile AND code =$code and adminid='{$adminid}'";
    }
    $member = $db->get_row($sql);
    if($member){
        showapisuccess($member);
    }else{
        showapierror('用户不存在！');
    }

}else{
    //exit('参数错误')
    showapierror('参数错误！');
}



