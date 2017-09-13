<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/13 0013
 * Time: 21:36
 * 题目
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      timu_list();
					  break;			  
	   	case "add_timu":
                      add_timu();
					  break;
		case "do_add_timu":
                      do_add_timu();
					  break;
	   	case "mod_timu":
                      mod_timu();
					  break;
		case "do_mod_timu":
                      do_mod_timu();
					  break;
		case "del_timu":
                      del_timu();
					  break;
	   	case "del_sel_timu":
                      del_sel_timu();
					  break;				  					  	
	   	case "del_one_img":
                      del_one_img();
					  break;
}

function get_con()
{
	global $smarty;
	
	//广告分类
	$cid = irequest('cid');
	$smarty->assign('cid', $cid);
	if (!empty($cid))
	{
		$con .= $con == '' ? " WHERE f.cid = '{$cid}' " : " AND f.cid = '{$cid}' ";
	}
	
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= $con == '' ? " WHERE f.title like '%{$keyword}%' " : " AND f.title like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 广告列表
/*------------------------------------------------------ */	
function timu_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 
	
	//排序字段
	$sort_col 	 = crequest('sort_col');	
	$asc_or_desc = crequest('asc_or_desc');
	$order 	 	 = 'ORDER BY f.add_time DESC';        
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT f.*, c.name AS cat FROM timu AS f LEFT JOIN timu_category AS c ON f.cid = c.id {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(f.id) FROM timu AS f {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('timu_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	//表信息
	$tbl = array('tbl' => 'timu', 'col1' => 'title', 'col2' => 'is_top');			
	$smarty->assign('tbl', $tbl);
	
	//广告分类
	$smarty->assign('timu_category', get_timu_category());
	
    $smarty->assign('page_title', '广告列表');
	$smarty->display('ad/timu_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加广告
/*------------------------------------------------------ */	
function add_timu()
{
	global $smarty;
	
	//广告分类
	$smarty->assign('timu_category',  get_timu_category());
	
	$smarty->assign('type', $type);
	$smarty->assign('action', 'do_add_timu');
	$smarty->assign('page_title', '添加广告');
	$smarty->display('ad/timu.htm');
}

/*------------------------------------------------------ */
//-- 添加广告
/*------------------------------------------------------ */	
function do_add_timu()
{
	global $db;
	
	$title    = crequest('title');
	$url      = crequest('url');
	$pic 	  = $_FILES['pic'];
	$cid	  = irequest('cid');
	$order_num= irequest('order_num');
	
	check_null($title, 			'广告标题');
	//check_null($pic['name'], 	'上传图片');
	
	if (!empty($pic['name']))
	{
		$upload_path = '/upload/timu/' . date('ym') . '/'; 
		$pic_name = @upload($pic, $upload_path);
		$pic_path = $upload_path . $pic_name;
	}
	
	$now_time = now_time();
	$sql = "INSERT INTO timu (title, cid, url, add_time, pic, order_num) VALUES ('{$title}', '{$cid}', '{$url}', '{$now_time}', '{$pic_path}', '{$order_num}')";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '添加广告，添加广告ID：' . $db->insert_id();
	operate_log($aid, 'timu', 1, $text);
	
	$url_to = "timu.php?action=list&type={$parent_id}";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改广告
/*------------------------------------------------------ */	
function mod_timu()
{
	global $db, $smarty;
	
	$id  = irequest('id');
	$sql = "SELECT * FROM timu WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	$smarty->assign('timu', $row);
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
    
	//广告分类
	$smarty->assign('timu_category',  get_timu_category());
	
	$smarty->assign('action', 'do_mod_timu');
	$smarty->assign('page_title', '修改广告');
	$smarty->display('ad/timu.htm');
}

/*------------------------------------------------------ */
//-- 修改广告
/*------------------------------------------------------ */	
function do_mod_timu()
{
	global $db;
	
	$title    = crequest('title');
	$cid	  = irequest('cid');
	$url      = crequest('url');
	$order_num= irequest('order_num');
	
	$pic = $_FILES['pic'];
	if (empty($pic['name']))
	{
		$pic_path = crequest('pic_name');
	}
	else
	{
		del_img(crequest('pic_name'));
		
		$upload_path = '/upload/timu/' . date('ym') . '/'; 
		$pic_name = @upload($pic, $upload_path);
		$pic_path = $upload_path . $pic_name;
	}
	
	check_null($title, 			'广告标题');
	
	$id = irequest('id');
	$update_col = "title = '{$title}', cid = '{$cid}', pic = '{$pic_path}', url = '{$url}', order_num = '{$order_num}'";
	$sql = "UPDATE timu SET {$update_col} WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改广告，修改广告ID：' . $id;
	operate_log($aid, 'timu', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "timu.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除广告
/*------------------------------------------------------ */	
function del_timu()
{
	global $db;
	
	$id  = irequest('id');
	$sql = "SELECT pic FROM timu WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	del_img($row['pic']);
	
	$sql = "DELETE FROM timu WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除广告，删除广告ID：' . $id;
	operate_log($aid, 'timu', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "timu.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除广告
/*------------------------------------------------------ */	
function del_sel_timu()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
		
	$sql = "SELECT pic FROM timu WHERE id IN ({$id})";
	$imgs_all = $db->get_all($sql);
	for ($i = 0; $i < count($imgs_all); $i++)
	{
		$pic = $imgs_all[$i]['pic'];
		del_img($pic);
	}	
	
	$sql = "DELETE FROM timu WHERE id IN ({$id})";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除广告，批量删除广告ID：' . $id;
	operate_log($aid, 'timu', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "timu.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 删除广告图片
/*------------------------------------------------------ */	
function del_one_img()
{
	$img_name = crequest('img_name');
	//del_img($img_name);
	
	$id = irequest('id');
	$now_page = irequest('now_page');
	
	global $db;
	$replace_img = $img_name . '|';
	$sql = "UPDATE timu SET imgs = replace(imgs, '{$replace_img}', '') WHERE id = '{$id}'";
	$db->query($sql);
	
	$url_to = "timu.php?action=mod_timu&id={$id}&now_page=$now_page";
	href_locate($url_to, '删除成功');	
}

/*------------------------------------------------------ */
//-- 广告分类
/*------------------------------------------------------ */
function get_timu_category()
{
	global $db;
	
	$sql = "SELECT id, name FROM timu_category ORDER BY order_num";
	$res = $db->get_all($sql);
	
	return $res;
}