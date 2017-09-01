<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/8/31 0031
 * Time: 19:45
 * 短信发送
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

if(isset($_GET['mobile']) && !empty($_GET['mobile'])) {
    $mobile = $_GET['mobile'];
} else {
   // exit('参数不对');
    exit(json_encode(array('status'=>0,'msg'=>'参数不对')));
}

$sql = "SELECT * FROM member WHERE mobile=$mobile";
$member = $db->get_row($sql);
if(!$member){
    exit(json_encode(array('status'=>0,'msg'=>'改手机号不存在系统之中')));
}

/*$posttime = strtotime(date('Y-m-d 00:00:00'));
$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";

$sql 		= "SELECT COUNT(id) FROM log_sms WHERE {$where}";
$total 		= $db->get_one($sql);
if($total > 10) {
    exit('当日发送短信数量超过限制 10 条');//当日发送短信数量超过限制 5 条
}*/

/*$posttime = time()-1800;
if($member['code_time'] > $posttime) {
    $code = $member['code'];
} else {*/
    $code = random(6);//唯一吗，用于扩展验证
/*}*/
$msg = "锦路智慧党建，验证码为$code,30分钟内有效。";
$url = "http://oa.jxglkf.com.cn:88/sms/sendsms.php?mobs=".$mobile."&msg=".$msg;
print_r(22222);
$res=httpGet($url); //发送短信
print_r(1111);
print_r($res);
exit;
$add_time	= time();
$add_time_format	= now_time();
if(!empty($res)){//如果发送成功,添加到数据库
    $sql = "INSERT INTO log_sms (mobile,code, type, content, status, add_time, add_time_format) VALUES ('{$mobile}','{$code}', 1,  '{$msg}', 1, '{$add_time}', '{$add_time_format}')";
    $db->query($sql);
    $sql = "UPDATE member SET code = '{$code}',code_time = '{$add_time}' WHERE mobile = '{$mobile}'";
    $db->query($sql);
} else {
    $sql = "INSERT INTO log_sms (mobile,code, type, content, status, add_time, add_time_format) VALUES ('{$mobile}','{$code}', 1,  '{$msg}', 0, '{$add_time}', '{$add_time_format}')";
    $db->query($sql);
}
 //$data = array('status'=>0,'msg'=>'短信发送成功');
//echo $res ? array('status'=>0,'msg'=>'短信发送成功') : array('status'=>0,'msg'=>'短信发送成功');
echo $res;
exit;