<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/12 0012
 * Time: 21:18
 * 会议
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'sign' : $action;

switch ($action)
{
    case "sign":
        sign();
        break;
    case "my_metting":
        my_metting();
        break;
    case "get_metting":
        get_metting();
        break;
}

function get_metting(){
    global $db;
    if(isset($_POST['mettingid']) && !empty($_POST['mettingid']) ) {
        $mettingid = intval(trim($_POST['mettingid']));
        $sql = "SELECT * FROM metting WHERE id =$mettingid and is_delete =0 ORDER BY id DESC";
        $metting = $db->get_row($sql);
        showapisuccess($metting);
    }else{
        $sql = "SELECT * FROM metting WHERE is_delete =0 ORDER BY testid DESC";
        $metting = $db->get_all($sql);
        showapisuccess($metting);
    }
}

function my_metting(){
    global $db;
    if(isset($_POST['userid']) && !empty($_POST['userid']) ) {
        $userid = intval(trim($_POST['userid']));
        $sql = "SELECT a.*,b.title FROM metting_sign as a LEFT JOIN metting as b on b.id=a.mettingid WHERE a.userid ='{$userid}'";
        $metting = $db->get_all($sql);
        foreach($metting as $key=>$val){
            if($val['lng'] && $val['lat']){
                $url = "http://api.map.baidu.com/geocoder/v2/?location=".$val['lat'].",".$val['lng']."&output=json&pois=1&ak=kk5HwsY5iPbyrRvfnzXekNxAYRuCEh9m";
                $addr = json_decode(https_request($url),true);
                $metting[$key]['address'] = $addr['result']['formatted_address'];
            }
        }
        showapisuccess($metting);
    }else{
        showapierror('参数错误！');
    }
}

function sign(){
    global $db;
    $userid = $_GET['userid'];
    $mettingid = $_GET['mettingid'];
    $lng = $_GET['lng'];
    $lat = $_GET['lat'];
    if(!$userid || !$mettingid){
        showapierror('缺少签到参数,签到失败');
    }
    $sql = "SELECT * FROM member WHERE userid=$userid";
    $member = $db->get_row($sql);
    $sign_time = date('Y-m-d H:i:s',time());
    $sql = "SELECT * FROM metting_sign WHERE userid = '{$userid}' and mettingid = '{$mettingid}'";
    $metting = $db->get_row($sql);
    if(is_array($metting) && $metting){

    }else{
        $sql = "INSERT INTO metting_sign (mettingid,userid,username, sign_time,lng,lat) VALUES ('{$mettingid}','{$userid}','{$member['name']}', '{$sign_time}', '{$lng}', '{$lat}')";
        $db->query($sql);
    }
    $sql = "SELECT * FROM metting_sign WHERE userid = '{$userid}' and mettingid = '{$mettingid}'";
    $metting = $db->get_row($sql);
    showapisuccess($metting,'签到成功');
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