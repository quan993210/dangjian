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
    case "latest_news":
        latest_news();
        break;
}

function news_list(){
    global $db;
    $adminid  = $_POST["adminid"];
    if(isset($_POST['catid']) && !empty($_POST['catid'])&& !empty($_POST['adminid']) ) {
        $catid = intval(trim($_POST['catid']));
        //排序字段
        $order 	 	 = 'ORDER BY listorder DESC, id DESC';
        //列表信息
        $now_page 	= intval($_POST['page']);
        $now_page 	= $now_page == 0 ? 1 : $now_page;
        $page_size 	= 9;
        $start    	= ($now_page - 1) * $page_size;

        $sql = "SELECT * FROM news WHERE catid =$catid and is_delete =0 and adminid='{$adminid}'{$order} LIMIT {$start}, {$page_size}";
        $news['list'] = $db->get_all($sql);
        $sql 		= "SELECT COUNT(catid) FROM news WHERE catid =$catid and is_delete =0 and adminid='{$adminid}'";
        $news['total'] 		= $db->get_one($sql);
        showapisuccess($news);
    }else{
        showapierror('参数错误！');
    }
}

function news_detail(){
    global $db;
    $adminid  = $_POST["adminid"];
    if(isset($_POST['id']) && !empty($_POST['id']) && !empty($_POST['adminid']) ) {
        $id = intval(trim($_POST['id']));
        $sql = "SELECT * FROM news WHERE id =$id and adminid='{$adminid}'";
        $news = $db->get_row($sql);
        if($_POST['userid']){
            $sql = "SELECT * FROM vote_data WHERE userid ='{$_POST['userid']}' and voteid='{$news['voteid']}' and adminid='{$adminid}'";
            $vote_data = $db->get_row($sql);
            if($vote_data){
                $news['is_vote'] = 1;
            }else{
                $news['is_vote'] = 0;
            }
        }
        showapisuccess($news);
    }else{
        showapierror('参数错误！');
    }
}

function view_news(){
    global $db;
    $adminid  = $_POST["adminid"];
    $userid = $_POST['userid'];
    $newsid = $_POST['newsid'];
    $last_update_timet = time();
    $sql = "SELECT * FROM view_news WHERE userid = '{$userid}' and newsid = '{$newsid}' and adminid='{$adminid}'";
    $view_news = $db->get_row($sql);
    if(is_array($view_news) && $view_news){
        $viewcout = $view_news['viewcout'] + 1;
        $sql = "UPDATE view_news SET viewcout = '{$viewcout}',last_update_timet = '{$last_update_timet}' WHERE userid = '{$userid}' and newsid = '{$newsid}'";
        $db->query($sql);
    }else{
        $sql = "INSERT INTO view_news (userid, newsid, viewcout, last_update_timet,adminid) VALUES ('{$userid}', '{$newsid}', 1, '{$last_update_timet}','{$adminid}')";
        $db->query($sql);
    }

    $sql = "SELECT * FROM news WHERE id = '{$newsid}' and adminid='{$adminid}'";
    $news = $db->get_row($sql);
    $news_viewcout = $news['viewcout'] + 1;
    $sql = "UPDATE news SET viewcout = '{$news_viewcout}' WHERE id = '{$newsid}'";
    $db->query($sql);

    showapisuccess();
}


function latest_news(){
    global $db;
    $adminid  = $_POST["adminid"];
    $order 	 	 = 'ORDER BY id DESC';
    if(isset($_POST['catid']) && !empty($_POST['catid']) ) {
        $catid = intval(trim($_POST['catid']));
        $sql = "SELECT * FROM news WHERE catid =$catid and is_delete =0 and adminid='{$adminid}' and adminid='{$adminid}'{$order} LIMIT 10";
        $news = $db->get_all($sql);
        showapisuccess($news);
    }else{
        $sql = "SELECT * FROM news WHERE  is_delete =0  and adminid='{$adminid}' {$order} LIMIT 10";
        $news = $db->get_all($sql);
        showapisuccess($news);
    }
}



