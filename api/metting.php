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
        $sql = "SELECT * FROM metting WHERE id =$mettingid ORDER BY id DESC";
        $metting = $db->get_row($sql);
        showapisuccess($metting);
    }else{
        $sql = "SELECT * FROM metting WHERE 1=1";
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
        showapisuccess($metting);
    }else{
        showapierror('参数错误！');
    }
}

function sign(){
    global $db;
    $userid = $_GET['userid'];
    $mettingid = $_GET['mettingid'];
    if(!$userid || !$mettingid){
        showapierror('缺少签到参数,签到失败');
    }
    $sql = "SELECT * FROM member WHERE userid=$userid";
    $member = $db->get_row($sql);
    $sign_time = date('Y-m-d H:i:s',time());
    $sql = "SELECT * FROM metting_sign WHERE userid = '{$userid}' and id = '{$mettingid}'";
    $metting = $db->get_row($sql);
    if(is_array($metting) && $metting){

    }else{
        $sql = "INSERT INTO metting_sign (mettingid,userid,username, sign_time) VALUES ('{$mettingid}','{$userid}','{$member['name']}', '{$sign_time}')";
        $db->query($sql);
    }
    showapisuccess(array(),'签到成功');
}