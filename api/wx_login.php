<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/1 0001
 * Time: 21:21
 * 绑定微信用户接口
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();
global $db;
$adminid  = $_POST["adminid"];
$sql = "SELECT * FROM admin WHERE id = '{$adminid}'";
$res = $db->get_row($sql);
define('APPID',$res['appid']);
define('MCH_ID',$res['mch_id']);
define('WX_KEY',$res['wx_key']);
define('APPSECRET',$res['appsecret']);
$action = crequest("action");
$action = $action == '' ? 'bind_user' : $action;

switch ($action)
{
    case "get_openid":
        get_openid();
        break;
    case "bind_user":
        bind_user();
        break;
    case "login_openid":
        login_openid();
        break;
}

function get_openid(){
    global $db;
    if(isset($_POST['code']) && !empty($_POST['code'])) {
        $code = $_POST['code'];
        $encryptedData = $_POST['encryptedData'];
        $iv = $_POST['iv'];
        $session_key = wxCode($code);
        $userInfo = decryptData($session_key,$encryptedData,$iv);
        if ($userInfo && !empty($userInfo) && isset($userInfo['openId']) && !empty($userInfo['openId'])) {
                showapisuccess($userInfo);
        }else{
            showapierror('参数错误！');
        }
    } else {
        showapierror('参数错误！');
    }
}

function bind_user(){
    global $db;
    $adminid  = $_POST["adminid"];
    if(isset($_POST['code']) && !empty($_POST['code']) && isset($_POST['mobile']) && !empty($_POST['mobile']) && !empty($_POST['adminid'])) {
        $mobile = addslashes(trim($_POST['mobile']));
        $sql = "SELECT * FROM member WHERE mobile = '{$mobile}' and adminid='{$adminid}'";
        $member = $db->get_row($sql);
        if($member){
            $code = $_POST['code'];
            $encryptedData = $_POST['encryptedData'];
            $iv = $_POST['iv'];
            $session_key = wxCode($code);
            $userInfo = decryptData($session_key,$encryptedData,$iv);
            if ($userInfo && !empty($userInfo) && isset($userInfo['openId']) && !empty($userInfo['openId'])) {
                $sql = "SELECT * FROM member WHERE openid = '{$userInfo['openId']}' and adminid='{$adminid}' and mobile = '{$mobile}'";
                $member = $db->get_row($sql);
                if($member['mobile'] == $mobile &&  $member && isset($member['openid']) && !empty($member['openid'])){
                   /* $nickname    	= $userInfo['nickname'];
                    $avatar    	= $userInfo['headimgurl'];
                    $unionid    	= $userInfo['unionid'];
                    $sql = "UPDATE member SET nickname = '{$nickname}',avatar = '{$avatar}',unionid = '{$unionid}' WHERE openid = '{$member['openid']}'";
                    $db->query($sql);
                    $sql = "SELECT * FROM member WHERE mobile=$mobile";
                    $member = $db->get_row($sql);*/
                    showapisuccess($member);
                }else{
                    $nickname    	= $userInfo['nickName'];
                    $openid    	= $userInfo['openId'];
                    $avatar    	= $userInfo['avatarUrl'];
                    $unionid    	= $userInfo['unionid'];
                    $sql = "UPDATE member SET  openid = '{$openid}', nickname = '{$nickname}',unionid = '{$unionid}',avatar = '{$avatar}' WHERE mobile = '{$mobile}' and adminid='{$adminid}'";
                    $db->query($sql);
                    //print_r($sql);
                    $sql = "SELECT * FROM member WHERE mobile=$mobile and adminid='{$adminid}' and mobile = '{$mobile}'";
                    $member = $db->get_row($sql);
                    showapisuccess($member);
                }
            }else{
                showapierror('参数错误！');
            }
        }else{
            showapierror('用户不存在！');
        }

    } else {
        showapierror('参数错误！');
    }
}

function login_openid(){
    global $db;
    if(isset($_POST['openid']) && !empty($_POST['openid'])&& !empty($_POST['adminid'])) {
        $openid = $_POST['openid'];
        $adminid  = $_POST["adminid"];
        $mobile = $_POST['mobile'];
        $sql = "SELECT * FROM member WHERE openid = '{$openid}' and adminid='{$adminid}' and mobile = '{$mobile}'";
        $member = $db->get_row($sql);
        showapisuccess($member);

    }else{
        showapierror('参数错误！');
    }
}


/**
 * 微信登录对接接口
 */
function wxCode($code){

    if (empty($code)){
        showapierror(-1,'code缺失');
        die;
    }

    //拼装url
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".APPID."&secret=".APPSECRET."&js_code=".$code."&grant_type=authorization_code ";


    $data = https_request($url);

    $result = json_decode($data,true);
    //print_r($result);
 /*  $result =array(
       'session_key' => '8+3ilMDOpip8YBnU8kbDng==',
       'expires_in' => '7200',
       'openid' => 'ooSUB0TD6ulAqWndUiiSaBV_JHw8'
   );*/


    if (!array_key_exists('errcode',$result)){
        $session_key = $result['session_key'];

        return $session_key;
    }else{
        //error log
        showapierror('错误代码'.$result['errmsg'].$result['errcode']);
    }

}

/**
 * 解密encryptedData
 * @param $sessionKey
 * @param $encryptedData
 * @param $iv
 */
function decryptData($sessionKey,$encryptedData,$iv){
    if (empty($sessionKey)){
        showapierror('sessionKey缺失');
        die;
    }
    if (empty($encryptedData)){
        showapierror('encryptedData缺失');
        die;
    }
    if (empty($iv)){
        showapierror('iv缺失');
        die;
    }
    require(ROOT_PATH . 'inc/weixin/wxBizDataCrypt.php');
    $pc = new WXBizDataCrypt(APPID, $sessionKey);
    $errCode = $pc->decryptData($encryptedData, $iv, $data );
 ;

    if ($errCode == 0) {
       // var_dump($data);
        //成功
        return json_decode($data,true);
    } else {
//        print($errCode . "\n");
        showapierror($errCode);
    }
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


