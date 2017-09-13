<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/5 0005
 * Time: 20:25
 * 会议
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
    case "list":
        metting_list();
        break;
    case "get_qrcode":
        get_qrcode();
        break;
    case "add_metting":
        add_metting();
        break;
    case "do_add_metting":
        do_add_metting();
        break;
    case "mod_metting":
        mod_metting();
        break;
    case "do_mod_metting":
        do_mod_metting();
        break;
    case "del_metting":
        del_metting();
        break;
    case "del_sel_metting":
        del_sel_metting();
        break;
    case "metting_data":
        metting_data();
        break;
    case "sign":
        sign();
        break;
}

function get_con()
{
    global $smarty;
    $con = "";
    //会议分类
    $keyword = crequest('keyword');
    $smarty->assign('keyword', $keyword);
    if (!empty($keyword))
    {
        $con .=" where title = '{$keyword}' ";
    }

    return $con;
}

/*------------------------------------------------------ */
//-- 会议列表
/*------------------------------------------------------ */
function metting_list()
{
    global $db, $smarty;

    //搜索条件
    $con 		= get_con();

    //排序字段
    $order 	 	 = 'ORDER BY id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM metting {$con} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);

    include "inc/plugin/phpqrcode.php";
    foreach($arr as $key=>$val){
        // 没有二维码图片的时候
        if(!is_file($_SERVER['DOCUMENT_ROOT'] . "/upload/metting/metting-".$val['id'].".jpg")){
            $value=$val['id'];
            $errorCorrectionLevel = 'L';
            $matrixPointSize = 12;
            QRcode::png($value,$_SERVER['DOCUMENT_ROOT'] . "/upload/metting/metting-".$val['id'].".jpg", $errorCorrectionLevel, $matrixPointSize);
        }

        $sql 		= "SELECT COUNT(id) FROM metting_sign WHERE mettingid='{$val['id']}'";
        $sign_sum 		= $db->get_one($sql);
        $arr[$key]['sign_sum'] = $sign_sum;
    }

    $sql 		= "SELECT COUNT(id) FROM metting {$con}";
    $total 		= $db->get_one($sql);


    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('metting_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);


    $smarty->assign('page_title', '会议列表');
    $smarty->display('metting/metting_list.htm');
}


function get_qrcode()
{
    global $db, $smarty;
    $id = irequest('id');
    $sql = "SELECT * FROM metting WHERE id = '{$id}'";
    $metting = $db->get_row($sql);
    $smarty->assign('metting', $metting);
    $smarty->display('metting/image.htm');
}


/*------------------------------------------------------ */
//-- 添加会议
/*------------------------------------------------------ */
function add_metting()
{
    global $smarty;
    $smarty->assign('action', 'do_add_metting');
    $smarty->assign('page_title', '添加会议');
    $smarty->display('metting/metting.htm');
}

/*------------------------------------------------------ */
//-- 添加会议
/*------------------------------------------------------ */
function do_add_metting()
{
    global $db;
    $title    = crequest('title');
    $start_time	  = crequest('start_time');
    $sum	  = irequest('sum');
    $add_time = time();
    $add_time_format = now_time();
    check_null($title, 			'会议标题');
    check_null($sum, 			'参加人数');
    check_null($start_time, 			'开始时间');

    $sql = "INSERT INTO metting (title,start_time, sum, add_time, add_time_format) VALUES('{$title}','{$start_time}','{$sum}', '{$add_time}', '{$add_time_format}')";
    $db->query($sql);
    $mettingid = $db->link_id->insert_id;
    $aid  = $_SESSION['admin_id'];
    $text = '添加会议，添加会议ID：' . $mettingid;
    operate_log($aid, 'metting', 1, $text);

    $url_to = "metting.php?action=list";
    url_locate($url_to, '添加成功');

}


/*------------------------------------------------------ */
//-- 修改会议
/*------------------------------------------------------ */
function mod_metting()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM metting WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    $smarty->assign('metting', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'do_mod_metting');
    $smarty->assign('page_title', '会议修改');
    $smarty->display('metting/metting.htm');
}

/*------------------------------------------------------ */
//-- 修改会议
/*------------------------------------------------------ */
function do_mod_metting()
{
    global $db;
    $title    = crequest('title');
    $start_time	  = crequest('start_time');
    $sum	  = irequest('sum');
    $add_time = time();
    $add_time_format = now_time();
    check_null($title, 			'会议标题');
    check_null($sum, 			'参加人数');
    check_null($start_time, 			'开始时间');

    $id = irequest('id');
    $update_col = "title = '{$title}', sum = '{$sum}', start_time = '{$start_time}',add_time = '{$add_time}', add_time_format = '{$add_time_format}'";
    $sql = "UPDATE metting SET {$update_col} WHERE id='{$id}'";
    $db->query($sql);
    $aid  = $_SESSION['admin_id'];
    $text = '修改会议，修改会议ID：' . $id;
    operate_log($aid, 'metting', 2, $text);

    $now_page = irequest('now_page');
    $url_to = "metting.php?action=list&page={$now_page}";
    url_locate($url_to, '修改成功');
}

/*------------------------------------------------------ */
//-- 删除会议
/*------------------------------------------------------ */
function del_metting()
{
    global $db;

    $id  = irequest('id');

    $sql = "DELETE FROM metting WHERE id = '{$id}'";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '删除会议，删除会议ID：' . $id;
    operate_log($aid, 'metting', 3, $text);

    $now_page = irequest('now_page');
    $url_to = "metting.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除会议
/*------------------------------------------------------ */
function del_sel_metting()
{
    global $db;
    $id = crequest('checkboxes');

    if ($id == '')
        alert_back('请选中需要删除的选项');


    $sql = "DELETE FROM metting WHERE id IN ({$id})";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '批量删除会议，批量删除会议ID：' . $id;
    operate_log($aid, 'metting', 4, $text);

    $now_page = irequest('now_page');
    $url_to = "metting.php?action=list&page={$now_page}";
    href_locate($url_to);
}



function metting_data(){
    global $db, $smarty;
    $mettingid = irequest('mettingid');
    //搜索条件
    $status = irequest('status');
    $smarty->assign('status', $status);
    $where =$status ? " where mettingid = '{$mettingid}' and status = '{$status}' " : " where mettingid = '{$mettingid}' ";

    //排序字段
    $order 	 	 = 'ORDER BY status ASC,id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM metting_data {$where} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);

    $sql 		= "SELECT COUNT(id) FROM metting_data {$where}";
    $total 		= $db->get_one($sql);


    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('metting_data_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);


    $smarty->assign('page_title', '会议详情列表');
    $smarty->display('metting/metting_data_list.htm');
}


/*------------------------------------------------------ */
//-- 会议列表
/*------------------------------------------------------ */
function sign()
{
    global $db, $smarty;
    $order 	 	 = 'ORDER BY id DESC';
    $mettingid = irequest('id');
    $sql 		= "SELECT * FROM metting WHERE id = '{$mettingid}'";
    $metting 		= $db->get_row($sql);
    $start_time = strtotime($metting['start_time']);
    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM metting_sign WHERE mettingid = '{$mettingid}'{$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);
    foreach($arr as $key=>$val){
        $sign_time = strtotime($val['sign_time']);
        if($sign_time < $start_time){
            $arr[$key]['status'] = "已迟到";
        }else{
            $arr[$key]['status'] = "未迟到";
        }
    }

    $sql 		= "SELECT COUNT(id) FROM metting_sign WHERE mettingid = '{$mettingid}'";
    $total 		= $db->get_one($sql);



    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
    $smarty->assign('metting'  ,   $metting);
    $smarty->assign('metting_sign'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);


    $smarty->assign('page_title', '会议详情列表');
    $smarty->display('metting/metting_sign.htm');
}



