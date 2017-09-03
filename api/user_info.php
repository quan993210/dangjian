<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/1 0001
 * Time: 21:39
 * 用户信息
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'get_user_info' : $action;

switch ($action)
{
    case "get_user_info":
        get_user_info();
        break;
    case "mod_user_info":
        mod_user_info();
        break;
    case "upload_avatar":
        upload_batch_photo();
        break;
}
function get_user_info(){
    global $db;
    if(isset($_POST['mobile']) && !empty($_POST['mobile'])) {
        $mobile = addslashes(trim($_POST['mobile']));
        $sql = "SELECT * FROM member WHERE mobile=$mobile";
        $member = $db->get_row($sql);
        exit(json_encode(array('status'=>1,'member'=>$member)));
    } else {
        //exit('参数错误')
        exit(json_encode(array('status'=>0,'msg'=>'参数不对')));
    }
}

function mod_user_info(){
    global $db;
    if(is_array($_POST) && !empty($_POST['userid'])) {
        $userid   = $_POST['userid'];
        $set = "";
        if($_POST['mobile']){
            $mobile   = $_POST['mobile'];
            $set.= "mobile = '{$mobile}'";
        }
       if($_POST['name']){
           $name   = $_POST['name'];
           $set.= ", name = '{$name}'";
       }

        if($_POST['nickname']){
            $nickname   = $_POST['nickname'];
            $set.= ", nickname = '{$nickname}'";
        }
        $sql = "UPDATE member SET  $set WHERE userid = '{$userid}'";
        $db->query($sql);
        $sql = "SELECT * FROM member WHERE userid=$userid";
        $member = $db->get_row($sql);
        exit(json_encode(array('status'=>1,'member'=>$member)));
    } else {
        //exit('参数错误')
        exit(json_encode(array('status'=>0,'msg'=>'参数不对')));
    }
}


