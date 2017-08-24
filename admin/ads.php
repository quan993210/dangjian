<?php
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      ads_list();
					  break;			  
	   	case "add_ads":
                      add_ads();
					  break;
		case "do_add_ads":
                      do_add_ads();
					  break;
	   	case "mod_ads":
                      mod_ads();
					  break;
		case "do_mod_ads":
                      do_mod_ads();
					  break;
		case "del_ads":
                      del_ads();
					  break;
	   	case "del_sel_ads":
                      del_sel_ads();
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
function ads_list()
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
	$sql 		= "SELECT f.*, c.name AS cat FROM ads AS f LEFT JOIN ads_category AS c ON f.cid = c.id {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(f.id) FROM ads AS f {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('ads_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	//表信息
	$tbl = array('tbl' => 'ads', 'col1' => 'title', 'col2' => 'is_top');			
	$smarty->assign('tbl', $tbl);
	
	//广告分类
	$smarty->assign('ads_category', get_ads_category());
	
    $smarty->assign('page_title', '广告列表');
	$smarty->display('ad/ads_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加广告
/*------------------------------------------------------ */	
function add_ads()
{
	global $smarty;
	
	//广告分类
	$smarty->assign('ads_category',  get_ads_category());
	
	$smarty->assign('type', $type);
	$smarty->assign('action', 'do_add_ads');
	$smarty->assign('page_title', '添加广告');
	$smarty->display('ad/ads.htm');
}

/*------------------------------------------------------ */
//-- 添加广告
/*------------------------------------------------------ */	
function do_add_ads()
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
		$upload_path = '/upload/ads/' . date('ym') . '/'; 
		$pic_name = @upload($pic, $upload_path);
		$pic_path = $upload_path . $pic_name;
	}
	
	$now_time = now_time();
	$sql = "INSERT INTO ads (title, cid, url, add_time, pic, order_num) VALUES ('{$title}', '{$cid}', '{$url}', '{$now_time}', '{$pic_path}', '{$order_num}')";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '添加广告，添加广告ID：' . $db->insert_id();
	operate_log($aid, 'ads', 1, $text);
	
	$url_to = "ads.php?action=list&type={$parent_id}";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改广告
/*------------------------------------------------------ */	
function mod_ads()
{
	global $db, $smarty;
	
	$id  = irequest('id');
	$sql = "SELECT * FROM ads WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	$smarty->assign('ads', $row);
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
    
	//广告分类
	$smarty->assign('ads_category',  get_ads_category());
	
	$smarty->assign('action', 'do_mod_ads');
	$smarty->assign('page_title', '修改广告');
	$smarty->display('ad/ads.htm');
}

/*------------------------------------------------------ */
//-- 修改广告
/*------------------------------------------------------ */	
function do_mod_ads()
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
		
		$upload_path = '/upload/ads/' . date('ym') . '/'; 
		$pic_name = @upload($pic, $upload_path);
		$pic_path = $upload_path . $pic_name;
	}
	
	check_null($title, 			'广告标题');
	
	$id = irequest('id');
	$update_col = "title = '{$title}', cid = '{$cid}', pic = '{$pic_path}', url = '{$url}', order_num = '{$order_num}'";
	$sql = "UPDATE ads SET {$update_col} WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改广告，修改广告ID：' . $id;
	operate_log($aid, 'ads', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "ads.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除广告
/*------------------------------------------------------ */	
function del_ads()
{
	global $db;
	
	$id  = irequest('id');
	$sql = "SELECT pic FROM ads WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	del_img($row['pic']);
	
	$sql = "DELETE FROM ads WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除广告，删除广告ID：' . $id;
	operate_log($aid, 'ads', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "ads.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除广告
/*------------------------------------------------------ */	
function del_sel_ads()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
		
	$sql = "SELECT pic FROM ads WHERE id IN ({$id})";
	$imgs_all = $db->get_all($sql);
	for ($i = 0; $i < count($imgs_all); $i++)
	{
		$pic = $imgs_all[$i]['pic'];
		del_img($pic);
	}	
	
	$sql = "DELETE FROM ads WHERE id IN ({$id})";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除广告，批量删除广告ID：' . $id;
	operate_log($aid, 'ads', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "ads.php?action=list&page={$now_page}";
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
	$sql = "UPDATE ads SET imgs = replace(imgs, '{$replace_img}', '') WHERE id = '{$id}'";
	$db->query($sql);
	
	$url_to = "ads.php?action=mod_ads&id={$id}&now_page=$now_page";
	href_locate($url_to, '删除成功');	
}

/*------------------------------------------------------ */
//-- 广告分类
/*------------------------------------------------------ */
function get_ads_category()
{
	global $db;
	
	$sql = "SELECT id, name FROM ads_category ORDER BY order_num";
	$res = $db->get_all($sql);
	
	return $res;
}