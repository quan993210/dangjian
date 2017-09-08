<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/7 0007
 * Time: 21:23
 * 党费
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'my_dangfei' : $action;

switch ($action)
{
    case "my_dangfei":
        my_dangfei();
        break;
    case "create_order":
        create_order();
        break;
    case "pay_notify":
        pay_notify();
        break;
}

function my_dangfei(){
    global $db;
    if(isset($_POST['mobile']) && !empty($_POST['mobile']) ) {
        $mobile = trim($_POST['mobile']);
        $sql = "SELECT a.*,b.title FROM dangfei_data as a LEFT JOIN dangfei as b on a.dangfeiid=b.id WHERE a.mobile =$mobile ORDER BY id DESC";
        $news = $db->get_all($sql);
        showapisuccess($news);
    }else{
        showapierror('参数错误！');
    }
}

function create_order(){
    global $db;
    if(!empty($_POST['dangfeiid']) && !empty($_POST['dangfei_data_id']) && !empty($_POST['userid']) && !empty($_POST['name']) && !empty($_POST['cost'])){
        $dangfeiid = $_POST['dangfeiid'];
        $dangfei_data_id = $_POST['dangfei_data_id'];
        $userid = $_POST['userid'];

        $sql = "SELECT * FROM `order` WHERE dangfeiid='{$dangfeiid}' and dangfei_data_id='{$dangfei_data_id}' and userid='{$userid}'";
        $order = $db->get_row($sql);
        if(is_array($order) && $order){
            showapisuccess($order);
        }else{
            $name = $_POST['name'];
            $cost = $_POST['cost'];
            $ordersn = date('Ymd').substr(microtime(), 2,3).rand(1000,9999);
            $add_time = time();
            $add_time_format = now_time();
            $status = 1;
            $sql = "INSERT INTO `order` (dangfeiid,dangfei_data_id,userid, name, cost, ordersn,add_time,add_time_format,status) VALUES ('{$dangfeiid}','{$dangfei_data_id}','{$userid}', '{$name}', '{$cost}', '{$ordersn}', '{$add_time}', '{$add_time_format}','{$status}')";
            $db->query($sql);
            $sql = "SELECT * FROM `order` WHERE ordersn='{$ordersn}'";
            $order = $db->get_row($sql);
            showapisuccess($order);
        }

    }else{
        showapierror('参数错误！');
    }
}

function pay_notify(){
    global $db;
    if(!empty($_POST['channel']) && !empty($_POST['pay_time_fromat']) && !empty($_POST['ordersn'])){
        $channel = $_POST['channel'];
        $pay_time_fromat = $_POST['pay_time_fromat'];
        $pay_time = strtotime($pay_time_fromat);
        $ordersn = $_POST['ordersn'];
        $status = 2;
        $sql = "UPDATE `order` SET channel = '{$channel}',pay_time = '{$pay_time}',pay_time_fromat = '{$pay_time_fromat}',status = '{$status}' WHERE  ordersn=$ordersn";
        $db->query($sql);
        $sql = "SELECT * FROM  `order` WHERE ordersn=$ordersn";
        $order = $db->get_row($sql);

        $sql = "UPDATE dangfei_data SET status = '{$status}' WHERE id='{$order['dangfei_data_id']}'";
        $db->query($sql);
        showapisuccess($order);
    }else{
        showapierror('参数错误！');
    }
}
