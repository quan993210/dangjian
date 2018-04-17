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
    $adminid  = $_POST["adminid"];
    if(isset($_POST['mettingid']) && !empty($_POST['mettingid'])  && !empty($_POST['adminid']) ) {
        $mettingid = intval(trim($_POST['mettingid']));
        $sql = "SELECT * FROM metting WHERE id =$mettingid and is_delete =0 and adminid='{$adminid}' ORDER BY id DESC";
        $metting = $db->get_row($sql);
        showapisuccess($metting);
    }else{
        $sql = "SELECT * FROM metting WHERE is_delete =0 and adminid='{$adminid}' ORDER BY testid DESC";
        $metting = $db->get_all($sql);
        showapisuccess($metting);
    }
}

function my_metting(){
    global $db;
    if(isset($_POST['userid']) && !empty($_POST['userid'])&& !empty($_POST['adminid']) ) {
        $userid = intval(trim($_POST['userid']));
        $adminid  = $_POST["adminid"];
        $sql = "SELECT a.*,b.title FROM metting_sign as a LEFT JOIN metting as b on b.id=a.mettingid WHERE a.userid ='{$userid}' and a.adminid='{$adminid}'";
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
    $adminid  = $_GET["adminid"];
    if(!$userid || !$mettingid){
        showapierror('缺少签到参数,签到失败');
    }
    $sql = "SELECT * FROM member WHERE userid=$userid and adminid='{$adminid}'";
    $member = $db->get_row($sql);

    $sql = "SELECT * FROM metting WHERE id=$mettingid and adminid='{$adminid}'";
    $metting = $db->get_row($sql);

    if($metting['flg'] == 1){
        if($metting['grade'] != $member['grade'] ||$metting['rank_title'] != $member['rank_title'] || $metting['identity'] != $member['identity'] || $metting['position'] != $member['position'] || $metting['is_party_affairs'] != $member['is_party_affairs'] || $metting['is_discipline'] != $member['is_discipline'] ||$metting['is_prepare'] != $member['is_prepare'] ||$metting['is_retire'] != $member['is_retire'] ){
            showapierror('不是会议指定人群，签到失败');
        }
    }

    $sign_time = date('Y-m-d H:i:s',time());
    $sql = "SELECT * FROM metting_sign WHERE userid = '{$userid}' and mettingid = '{$mettingid}' and adminid='{$adminid}'";
    $metting = $db->get_row($sql);


    if(is_array($metting) && $metting){

    }else{
        $sql = "INSERT INTO metting_sign (mettingid,userid,username, sign_time,lng,lat,adminid) VALUES ('{$mettingid}','{$userid}','{$member['name']}', '{$sign_time}', '{$lng}', '{$lat}','{$adminid}')";
        $db->query($sql);
    }
    $sql = "SELECT * FROM metting_sign WHERE userid = '{$userid}' and mettingid = '{$mettingid}' and adminid='{$adminid}'";
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