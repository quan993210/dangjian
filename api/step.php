<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2018/3/3 0003
 * Time: 16:51
 */

set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'add' : $action;
$adminid  = $_POST["adminid"];
$sql = "SELECT * FROM admin WHERE id = '{$adminid}'";
$res = $db->get_row($sql);
define('APPID',$res['appid']);
define('MCH_ID',$res['mch_id']);
define('WX_KEY',$res['wx_key']);
define('APPSECRET',$res['appsecret']);

switch ($action)
{
    case "step":
        step();
        break;
    case "add_step":
        add_step();
        break;
    case "get_step":
        get_step();
        break;
}

function step(){
    $encryptedData=$_POST['encryptedData'];
    $iv = $_POST['iv'];
    $code = $_POST['code'];
    $sessionKey = wxCode($code);
  //  $sessionKey = 'I5aZNQ+0RT23CcPDFdllPg==';

    if (empty($sessionKey)){
        showapierror('sessionKey缺失');
    }
    if (empty($encryptedData)){
        showapierror('encryptedData缺失');
    }
    if (empty($iv)){
        showapierror('iv缺失');
    }

    require(ROOT_PATH . 'inc/weixin/wxBizDataCrypt.php');
    $pc = new WXBizDataCrypt(APPID, $sessionKey);
    $errCode = $pc->decryptData($encryptedData, $iv, $data );

    if ($errCode == 0) {
        echo $data;
        exit;
    } else {
        showapierror($errCode);
    }

}


function add_step(){
    global $db;
    if(!empty($_POST['userid'])&& !empty($_POST['adminid'])&& !empty($_POST['stepInfoList']) ) {
//        $stepInfoList = '[
//       {
//            "timestamp": 1445866601,
//            "step": 100
//        },
//        {
//            "timestamp": 1445866602,
//            "step": 100
//        }
//    ]';
//        $userid = 1;
//        $adminid = 1;
        $userid = $_POST['userid'] ? $_POST['userid'] : showapierror('用户id不存在！');
        $stepInfoList = $_POST['stepInfoList'];
        $adminid = $_POST['adminid'];
        $stepInfoList = json_decode($stepInfoList,true);

        foreach($stepInfoList as $key=>$val){
            $timestamp = date('Y-m-d',$val['timestamp']);
            $timestamp = strtotime($timestamp);
            $time= date('Y-m-d',time());
            $time = strtotime($time);
            $info = array();
            $info['userid'] = $userid;
            $info['step'] = $val['step'];
            $info['timestamp'] = $timestamp;
            $info['adminid'] = $adminid;
            $info['add_time']	= time();
            $info['add_time_format']	= now_time();
            $sql = "SELECT * FROM step WHERE timestamp = '{$timestamp}' and userid = '{$userid}'";
            $step = $db->get_row($sql);
            if($step){
                $db->update('step',$info,"id={$step['id']}");
            }else{
                $db->insert('step',$info);
            }
        }


        $sql 		= "SELECT * FROM step WHERE timestamp = '{$time}' and adminid = $adminid ORDER BY step DESC ";
        $arr 		= $db->get_all($sql);

        showapisuccess($arr);
    }else{
        showapierror('参数错误！');
    }


}

function get_step(){
    global $db;
    if(!empty($_POST['adminid']) ) {
        $time= date("Y-m-d",strtotime("-1 day"));
        $time = strtotime($time);
        $adminid  = $_POST["adminid"];
        $sql 		= "SELECT * FROM step WHERE timestamp = '{$time}' and adminid = $adminid ORDER BY step DESC ";
        $arr 		= $db->get_all($sql);
        foreach($arr as $key=>$val){
            $sql 		= "SELECT * FROM member WHERE userid = '{$val['userid']}'";
            $user 		= $db->get_row($sql);
            $arr[$key]['avatar'] = $user['avatar'];
            $arr[$key]['username'] = $user['name'];
        }
        showapisuccess($arr);
    }else{
        showapierror('参数错误！');
    }
}


function wxCode($code){
    if (empty($code)){
        showapierror(-1,'code缺失');
    }

    //拼装url
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".APPID."&secret=".APPSECRET."&js_code=".$code."&grant_type=authorization_code ";

    $data = https_request($url);

    $result = json_decode($data,true);
    /* print_r($result);
    $result =array(
        'session_key' => '0DNVAurXvrRETr/iYreT3w==',
        'expires_in' => '7200',
        'openid' => 'oEvcj0TtmllEYWaqDVl94QUkQcbE'
    );*/


    if (!array_key_exists('errcode',$result)){
        $session_key = $result['session_key'];

        return $session_key;
    }else{
        //error log
        return false;
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


