<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/3 0003
 * Time: 21:46
 * 获取内容
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'bind_user' : $action;

switch ($action)
{
    case "news_list":
        news_list();
        break;
    case "news_detail":
        news_detail();
        break;
}

function news_list(){
    global $db;
    if(isset($_POST['catid']) && !empty($_POST['catid']) ) {
        $catid = intval(trim($_POST['catid']));
        $sql = "SELECT * FROM news WHERE catid =$catid";
        $news = $db->get_all($sql);
        showapisuccess($news);
    }else{
        showapierror('参数错误！');
    }
}

function news_detail(){
    global $db;
    if(isset($_POST['id']) && !empty($_POST['id']) ) {
        $id = intval(trim($_POST['id']));
        $sql = "SELECT * FROM news WHERE id =$id";
        $news = $db->get_row($sql);
        showapisuccess($news);
    }else{
        showapierror('参数错误！');
    }
}


