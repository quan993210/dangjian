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
    case "view_news":
        view_news();
        break;
}

function news_list(){
    global $db;
    if(isset($_POST['catid']) && !empty($_POST['catid']) ) {
        $catid = intval(trim($_POST['catid']));
        $sql = "SELECT * FROM news WHERE catid =$catid ORDER BY listorder ASC, id DESC";
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

function view_news(){
    global $db;
    $userid = $_POST['userid'];
    $newsid = $_POST['newsid'];
    $last_update_timet = time();
    $sql = "SELECT * FROM view_news WHERE userid = '{$userid}' and newsid = '{$newsid}'";
    $view_news = $db->get_row($sql);
    if(is_array($view_news) && $view_news){
        $viewcunt = $view_news['viewcunt'] + 1;
        $sql = "UPDATE view_news SET viewcunt = '{$viewcunt}',last_update_timet = '{$last_update_timet}' WHERE userid = '{$userid}' and newsid = '{$newsid}'";
        $db->query($sql);
    }else{
        $sql = "INSERT INTO view_news (userid, newsid, viewcunt, last_update_timet) VALUES ('{$userid}', '{$newsid}', 1, '{$last_update_timet}')";
        $db->query($sql);
    }
    showapisuccess();
}


