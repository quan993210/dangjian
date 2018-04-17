<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2018/1/9 0009
 * Time: 22:32
 * 投票
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
    case "list":
        vote_list();
        break;
    case "add_vote":
        add_vote();
        break;
    case "do_add_vote":
        do_add_vote();
        break;
    case "mod_vote":
        mod_vote();
        break;
    case "do_mod_vote":
        do_mod_vote();
        break;
    case "del_vote":
        del_vote();
        break;
    case "del_sel_vote":
        del_sel_vote();
        break;

}

function get_con()
{
    global $smarty;
    $adminid  = $_SESSION["admin_id"];
    $con = "WHERE is_delete = 0 and adminid='{$adminid}'";

    //关键字
    $keyword = crequest('keyword');
    $smarty->assign('keyword', $keyword);
    if (!empty($keyword)) {
        $con .= " AND title like '%{$keyword}%' ";
    }
    return $con;
}

/*------------------------------------------------------ */
//-- 投票列表
/*------------------------------------------------------ */
function vote_list()
{
    global $db, $smarty;

    //搜索条件
    $con 		= get_con();

    $order 	 	 = 'ORDER BY id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM vote {$con} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);

    $sql 		= "SELECT COUNT(id) FROM vote {$con}";
    $total 		= $db->get_one($sql);
    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    foreach($arr as $key=>$val){
        if($val['end_time'] < time()){
            $arr[$key]['status'] = "已结束";
        }else{
            $arr[$key]['status'] = "进行中";
        }
        $sql 		= "SELECT sum(num) FROM vote_option WHERE vote_id = '{$val['id']}'";
        $arr[$key]['num'] 		= $db->get_one($sql);
    }

    $smarty->assign('vote_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);

    $smarty->assign('page_title', '投票列表');
    $smarty->display('vote/vote_list.htm');
}

/*------------------------------------------------------ */
//-- 添加投票
/*------------------------------------------------------ */
function add_vote()
{
    global $smarty;
    $smarty->assign('action', 'do_add_vote');
    $smarty->assign('page_title', '添加投票');
    $smarty->display('vote/vote.htm');
}

/*------------------------------------------------------ */
//-- 添加投票
/*------------------------------------------------------ */
function do_add_vote()
{
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $vote = $_POST['vote'];
    $vote['end_time'] =  strtotime($vote['end_time']);
    $vote['add_time'] = time();
    $vote['add_time_format'] =  now_time();
    $vote['adminid'] = $adminid;
    check_null($vote['title'], 			'投票标题');
    check_null($vote['end_time'], 			'投票标题');
    check_null($vote['type'], 			'投票类型');

    $option = $_POST['option'];
    if(!$option){
        check_null("", 			'选项');
    }

    $voteid = $db->insert('vote',$vote);
    foreach($option as $val){
        $data['vote_id'] = $voteid;
        $data['options'] = $val;
        $data['adminid'] = $adminid;
        $db->insert('vote_option',$data);
    }

    $aid  = $_SESSION['admin_id'];
    $text = '添加投票，添加投票ID：' . $voteid;
    operate_log($aid, 'vote', 1, $text);

    $url_to = "vote.php?action=list";
    url_locate($url_to, '添加成功');
}

/*------------------------------------------------------ */
//-- 修改投票
/*------------------------------------------------------ */
function mod_vote()
{
    global $db, $smarty;

    $voteid  = irequest('voteid');
    $sql = "SELECT * FROM vote WHERE id = '{$voteid}'";
    $row = $db->get_row($sql);
    $row['endtime'] = date('Y-h-m H:i:s',$row['end_time']);
    $smarty->assign('vote', $row);

    $sql = "SELECT * FROM vote_option WHERE vote_id = '{$voteid}'";
    $data = $db->get_all($sql);

    $smarty->assign('vote_option', $data);
    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('page_title', '投票详情');
    $smarty->display('vote/vote_detail.htm');
}

/*------------------------------------------------------ */
//-- 修改投票
/*------------------------------------------------------ */
function do_mod_vote()
{
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $title    = crequest('title');
    $catid      = crequest('catid');
    $type	  = irequest('type');
    $now_time = now_time();

    check_null($catid, 			'投票分类');
    check_null($title, 			'投票标题');
    check_null($type, 			'投票类型');
    if($type == 1){  //选择题
        $answer = $_POST['choice'];
        $A = $answer['A'];
        $B = $answer['B'];
        $C = $answer['C'];
        $D = $answer['D'];
        if(!$A || !$B  || !$C  ||  !$D){
            check_null('', 			'选择题选项');
        }
        $correct = $answer['correct'];
        check_null($correct, 			'选择题正确答案');



    }else{
        $answer = $_POST['judge'];
        $A = $answer['A'];
        $B = $answer['B'];
        if(!$A || !$B){
            check_null('', 			'判断题选项');
        }
        $correct = $answer['correct'];
        check_null($correct, 			'判断题正确答案');

    }

    $voteid = irequest('voteid');
    //修改投票表
    $update_col = "catid = '{$catid}', title = '{$title}', type = '{$type}', correct = '{$correct}'";
    $sql = "UPDATE vote SET {$update_col} WHERE voteid = '{$voteid}'";
    $db->query($sql);

    //修改投票时，答案做新数据，重新插入投票答案表
    $sql = "DELETE FROM vote_answer WHERE voteid = '{$voteid}'";
    $db->query($sql);
    unset($answer['correct']);
    foreach($answer as $key=>$val){
        $sql = "INSERT INTO vote_answer (voteid,name,number,add_time_format,adminid) VALUES ('{$voteid}', '{$val}', '{$key}','{$now_time}','{$adminid}')";
        $db->query($sql);
    }


    $aid  = $_SESSION['admin_id'];
    $text = '修改投票，修改投票ID：' . $voteid;
    operate_log($aid, 'vote', 2, $text);

    $now_page = irequest('now_page');
    $url_to = "vote.php?action=list&page={$now_page}";
    url_locate($url_to, '修改成功');
}

/*------------------------------------------------------ */
//-- 删除投票
/*------------------------------------------------------ */
function del_vote()
{
    global $db;

    $voteid  = irequest('voteid');

    $update_col = "is_delete = '1'";
    $sql = "UPDATE vote SET {$update_col} WHERE id = '{$voteid}'";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '删除投票，删除投票ID：' . $voteid;
    operate_log($aid, 'vote', 3, $text);
    $now_page = irequest('now_page');
    $url_to = "vote.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除投票
/*------------------------------------------------------ */
function del_sel_vote()
{
    global $db;
    $id = crequest('checkboxes');

    if ($id == '')
        alert_back('请选中需要删除的选项');


    $sql = "SELECT * FROM vote WHERE id IN ({$id})";
    $vote_all = $db->get_all($sql);
    $update_col = "is_delete = '1'";
    foreach($vote_all as $key=>$val){
        $sql = "UPDATE vote SET {$update_col} WHERE id = '{$val['id']}'";
        $db->query($sql);
    }



    $aid  = $_SESSION['admin_id'];
    $text = '批量删除投票，批量删除投票ID：' . $id;
    operate_log($aid, 'vote', 4, $text);

    $now_page = irequest('now_page');
    $url_to = "vote.php?action=list&page={$now_page}";
    href_locate($url_to);
}
