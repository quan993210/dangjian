<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/13 0013
 * Time: 21:36
 * 题目分类
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      timu_category_list();
					  break;			  
	   	case "add_timu_category":
                      add_timu_category();
					  break;
		case "do_add_timu_category":
                      do_add_timu_category();
					  break;
	   	case "mod_timu_category":
                      mod_timu_category();
					  break;
		case "do_mod_timu_category":
                      do_mod_timu_category();
					  break;
		case "del_timu_category":
                      del_timu_category();
					  break;
	   	case "del_sel_timu_category":
                      del_sel_timu_category();
					  break;
	case "upload_batch_photo":
		upload_batch_photo();
		break;
}

function get_con()
{
	global $smarty;
	$adminid  = $_SESSION["admin_id"];

	$con ="where adminid = '{$adminid}' ";
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= " and name like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 题目分类列表
/*------------------------------------------------------ */	
function timu_category_list()
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
	$sql 		= "SELECT *  FROM timu_category {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);

	foreach($arr as $key=>$val){
		$sql 		= "SELECT COUNT(timuid) FROM timu WHERE catid = '{$val['id']}'";
		$sum 		= $db->get_one($sql);
		$arr[$key]['sum'] = $sum;
	}
	
	$sql 		= "SELECT COUNT(id) FROM timu_category {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('cat_list',   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	
	$page_title = '题目分类列表';
    $smarty->assign('page_title', $page_title);
	$smarty->display('timu/timu_category_list.htm');
}

/*------------------------------------------------------ */
//-- 添加题目分类
/*------------------------------------------------------ */	
function add_timu_category()
{
	global $smarty;
	

	
	$page_title = '添加题目分类';
    $smarty->assign('page_title', $page_title);
	
	$smarty->assign('action', 'do_add_timu_category');
	$smarty->display('timu/timu_category.htm');
}

/*------------------------------------------------------ */
//-- 添加题目分类
/*------------------------------------------------------ */	
function do_add_timu_category()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$name      = crequest('name');
	$logo      = crequest('logo_path');
	$add_time	= time();
	$add_time_format	= now_time();
	check_null($name, '题目分类名称');
	
	$sql = "INSERT INTO timu_category (name,logo, add_time, add_time_format,adminid) VALUES ('{$name}', '{$logo}', '{$add_time}', '{$add_time_format}','{$adminid}')";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '添加题目分类，添加题目分类ID：' . $db->link_id->insert_id;
	operate_log($aid, 'timu_category', 1, $text);
	
	$url_to = "timu_category.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改题目分类
/*------------------------------------------------------ */	
function mod_timu_category()
{
	global $db, $smarty;
	
	$id  = irequest('id');
	$sql = "SELECT * FROM timu_category WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	$smarty->assign('cat', $row);
	
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
	
	$page_title = '修改题目分类';
    $smarty->assign('page_title', $page_title);
	$smarty->assign('action', 'do_mod_timu_category');
	$smarty->display('timu/timu_category.htm');
}

/*------------------------------------------------------ */
//-- 修改题目分类
/*------------------------------------------------------ */	
function do_mod_timu_category()
{
	global $db;

	$name      = crequest('name');
	$logo      = crequest('logo_path');
	$add_time	= time();
	$add_time_format	= now_time();
	check_null($name, '题目分类名称');

	$id = irequest('id');
	$update_col = "name = '{$name}', logo = '{$logo}'";
	$sql = "UPDATE timu_category SET {$update_col} WHERE id='{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改题目分类，修改题目分类ID：' . $id;
	operate_log($aid, 'timu_category', 2, $text);

	$now_page = irequest('now_page');
	$url_to = "timu_category.php?action=list&page=$now_page";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除题目分类
/*------------------------------------------------------ */	
function del_timu_category()
{
	global $db;
	$id = irequest('id');
	
	$sql = "DELETE FROM timu_category WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除题目分类，删除题目分类ID：' . $id;
	operate_log($aid, 'timu_category', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "timu_category.php?action=list&page=$now_page";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除题目分类
/*------------------------------------------------------ */	
function del_sel_timu_category()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
	
	$sql = "DELETE FROM timu_category WHERE id IN ({$id})";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除题目分类，批量删除题目分类ID：' . $id;
	operate_log($aid, 'timu_category', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "timu_category.php?action=list&page=$now_page";
	href_locate($url_to);
}



?>