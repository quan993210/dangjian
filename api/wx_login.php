<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/1 0001
 * Time: 21:21
 * 小程序微信登录
 */

set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

if(isset($_GET['code']) && !empty($_GET['code']) && isset($_GET['mobile']) && !empty($_GET['mobile'])) {
    $mobile = addslashes(trim($_POST['mobile']));
    $sql = "SELECT * FROM member WHERE mobile = '{$mobile}'";
    $member = $db->get_row($sql);
    if($member){
        $code = $_GET['code'];
        $access_token = getOpenId($code);
        $userInfo = getUserInfo($access_token);
        if ($userInfo && !empty($userInfo) && isset($userInfo['openid']) && !empty($userInfo['openid'])) {
            $sql = "SELECT * FROM member WHERE openid = '{$userInfo['openid']}'";
            $member = $db->get_row($sql);
            if($member && !empty($member) && isset($member['openid']) && !empty($member['openid'])){
                $nickname    	= $userInfo['nickname'];
                $avatar    	= $userInfo['headimgurl'];
                $sql = "UPDATE member SET nickname = '{$nickname}',avatar = '{$headimgurl}',unionid = '{$unionid}' WHERE openid = '{$member['openid']}'";
                $db->query($sql);
                $sql = "SELECT * FROM member WHERE mobile=$mobile";
                $member = $db->get_row($sql);
                exit(json_encode(array('status'=>1,'member'=>$member)));
            }else{
                $nickname    	= $userInfo['nickname'];
                $openid    	= $userInfo['openid'];
                $avatar    	= $userInfo['headimgurl'];
                $unionid    	= $userInfo['unionid'];
                $sql = "UPDATE member SET  openid = '{$openid}', nickname = '{$nickname}',unionid = '{$unionid}',avatar = '{$headimgurl}' WHERE openid = '{$member['openid']}'";
                $db->query($sql);
                $sql = "SELECT * FROM member WHERE mobile=$mobile";
                $member = $db->get_row($sql);
                exit(json_encode(array('status'=>1,'member'=>$member)));
            }
            href_locate('#');
        }else{
            exit(json_encode(array('status'=>0,'msg'=>'参数错误')));
        }
    }else{
        exit(json_encode(array('status'=>0,'msg'=>'该用户不存在')));
    }

} else {
    exit(json_encode(array('status'=>0,'msg'=>'参数不对')));
}


/**
 * @explain
 * 用于获取用户openid
 **/
function getOpenId($code){
    $APPID = APPID;
    $APPSECRET = APPSECRET;
    $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $APPID . "&secret=" . $APPSECRET . "&code=" . $code . "&grant_type=authorization_code";
    $access_token_json = https_request($access_token_url);
    $access_token_array = json_decode($access_token_json, TRUE);
    return $access_token_array;
}


/**
 * @explain
 * 通过code获取用户openid以及用户的微信号信息
 * @return
 * @remark
 * 获取到用户的openid之后可以判断用户是否有数据，可以直接跳过获取access_token,也可以继续获取access_token
 * access_token每日获取次数是有限制的，access_token有时间限制，可以存储到数据库7200s. 7200s后access_token失效
 **/
function getUserInfo($access_token){
    $APPID = APPID;
    $APPSECRET = APPSECRET;
    $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token['access_token'] ."&openid=" . $access_token['openid']."&lang=zh_CN";
    $userinfo_json = https_request($userinfo_url);
    $userinfo_array = json_decode($userinfo_json, TRUE);
    return $userinfo_array;
}


/**
 * @explain
 * 发送http请求，并返回数据
 **/
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}


