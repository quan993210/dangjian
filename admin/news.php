<?php
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      news_list();
					  break;			  
	   	case "add_news":
                      add_news();
					  break;
		case "do_add_news":
                      do_add_news();
					  break;
	   	case "mod_news":
                      mod_news();
					  break;
		case "do_mod_news":
                      do_mod_news();
					  break;
		case "del_news":
                      del_news();
					  break;
	   	case "del_sel_news":
                      del_sel_news();
					  break;				  					  	
	   	case "del_one_img":
                      del_one_img();
					  break;
		case "upload_batch_photo":
                      upload_batch_photo();
					  break;
		case "checkChild":
			checkChild();
			break;

}

function get_con()
{
	global $smarty;
	$con = "WHERE a.is_delete=0";
	//内容分类
	$catid = irequest('catid');
	$smarty->assign('catid', $catid);
	if (!empty($catid))
	{
		$con .=" AND a.catid = '{$catid}' ";
	}
	
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= " AND a.title like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 内容列表
/*------------------------------------------------------ */	
function news_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 
	
	//排序字段
	$order 	 	 = 'ORDER BY a.listorder DESC';
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT a.*, c.catname AS catname FROM news AS a LEFT JOIN news_category AS c ON a.catid = c.catid {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(a.id) FROM news AS a {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('news_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	//表信息
	$tbl = array('tbl' => 'news', 'col1' => 'title', 'col2' => 'is_top');			
	$smarty->assign('tbl', $tbl);
	
	//内容分类
	$smarty->assign('news_category', get_news_category());
	
    $smarty->assign('page_title', '内容列表');
	$smarty->display('news/news_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加内容
/*------------------------------------------------------ */	
function add_news()
{
	global $smarty;
	//内容分类
	$smarty->assign('news_category',  get_news_category());
	
	if (!empty($_SESSION['news_pic_path']))
	{
		$news['cover'] = $_SESSION['news_pic_path'];
	}
	
	$smarty->assign('news', $news);
	$smarty->assign('action', 'do_add_news');
	$smarty->assign('page_title', '添加内容');
	$smarty->display('news/news.htm');
}

/*------------------------------------------------------ */
//-- 添加内容
/*------------------------------------------------------ */	
function do_add_news()
{
	global $db;

	$catid	  = irequest('catid');
	$title    = crequest('title');
	$brief    = crequest('brief');
	$release_time	  = crequest('release_time');
	$content  = $_REQUEST['content'];
	$pic_path = crequest('pic_path');
	$video_url	  = crequest('video_url');
	$audio_url	  = crequest('audio_url');
	$listorder= irequest('listorder');
	$add_time	= time();
	$add_time_format	= now_time();

	check_null($catid, 			'分类');
	check_null($title, 			'标题');
	check_null($pic_path, 			'图片');
	check_null($content, 			'内容');

	$sql = "INSERT INTO news (catid,cover,title, brief,release_time, content, video_url, audio_url, add_time, add_time_format, listorder) VALUES('{$catid}','{$pic_path}','{$title}', '{$brief}', '{$release_time}','{$content}', '{$video_url}', '{$audio_url}', '{$add_time}', '{$add_time_format}', '{$listorder}')";
	$db->query($sql);
	
	unset($_SESSION['news_pic_path']);
	
	$aid  = $_SESSION['admin_id'];
	$text = '添加内容，添加内容ID：' . $db->link_id->insert_id;
	operate_log($aid, 'news', 1, $text);
	
	$url_to = "news.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改内容
/*------------------------------------------------------ */	
function mod_news()
{
	global $db, $smarty;
	
	$id  = irequest('id');
	$sql = "SELECT * FROM news WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	$smarty->assign('news', $row);
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
    
	//内容分类
	$smarty->assign('news_category',  get_news_category());
	
	$smarty->assign('action', 'do_mod_news');
	$smarty->assign('page_title', '修改内容');
	$smarty->display('news/news.htm');
}

/*------------------------------------------------------ */
//-- 修改内容
/*------------------------------------------------------ */	
function do_mod_news()
{
	global $db;

	$catid	  = irequest('catid');
	$title    = crequest('title');
	$brief    = crequest('brief');
	$release_time	  = crequest('release_time');
	$content  = $_REQUEST['content'];
	$pic_path = crequest('pic_path');
	$video_url	  = crequest('video_url');
	$audio_url	  = crequest('audio_url');
	$listorder= irequest('listorder');
	$add_time	= time();
	$add_time_format	= now_time();

	check_null($title, 			'内容标题');
	
	$id = irequest('id');
	$update_col = "title = '{$title}', brief = '{$brief}', release_time='{$release_time}',content = '{$content}', cover = '{$pic_path}', catid = '{$catid}', video_url = '{$video_url}', audio_url = '{$audio_url}', listorder = '{$listorder}', add_time = '{$add_time}', add_time_format = '{$add_time_format}'";
	$sql = "UPDATE news SET {$update_col} WHERE id='{$id}'";
	$db->query($sql);
	
	unset($_SESSION['news_pic_path']);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改内容，修改内容ID：' . $id;
	operate_log($aid, 'news', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除内容
/*------------------------------------------------------ */	
function del_news()
{
	global $db;
	
	$id  = irequest('id');
	/*$sql = "SELECT cover FROM news WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	del_img($row['cover']);*/
	
	/*$sql = "DELETE FROM news WHERE id = '{$id}'";
	$db->query($sql);*/

	$update_col = "is_delete = '1'";
	$sql = "UPDATE news SET {$update_col} WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除内容，删除内容ID：' . $id;
	operate_log($aid, 'news', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除内容
/*------------------------------------------------------ */	
function del_sel_news()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
		
	/*$sql = "SELECT cover FROM news WHERE id IN ({$id})";
	$imgs_all = $db->get_all($sql);
	for ($i = 0; $i < count($imgs_all); $i++)
	{
		$cover = $imgs_all[$i]['cover'];
		del_img($cover);
	}*/

	$sql = "SELECT * FROM news WHERE id IN ({$id})";
	$news_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($news_all as $key=>$val){
		$sql = "UPDATE news SET {$update_col} WHERE id = '{$val['id']}'";
		$db->query($sql);
	}
	
/*	$sql = "DELETE FROM news WHERE id IN ({$id})";
	$db->query($sql);*/
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除内容，批量删除内容ID：' . $id;
	operate_log($aid, 'news', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 删除内容图片
/*------------------------------------------------------ */	
function del_one_img()
{
	$img_name = crequest('img_name');
	//del_img($img_name);
	
	$id = irequest('id');
	$now_page = irequest('now_page');
	
	global $db;
	$replace_img = $img_name . '|';
	$sql = "UPDATE news SET imgs = replace(imgs, '{$replace_img}', '') WHERE id = '{$id}'";
	$db->query($sql);
	
	$url_to = "news.php?action=mod_news&id={$id}&now_page=$now_page";
	href_locate($url_to, '删除成功');	
}

/*------------------------------------------------------ */
//-- 内容分类
/*------------------------------------------------------ */
function get_news_category()
{
	global $db;
	
	$sql = "SELECT catid, catname FROM news_category WHERE pid = 0 ORDER BY listorder";
	$res = $db->get_all($sql);
	$num = count($res);
	
	for ($i = 0; $i < $num; $i++)
	{
		$catid  = $res[$i]['catid'];
		$sql = "SELECT catid, catname FROM news_category WHERE pid = {$catid} ORDER BY listorder";
		$res[$i]['sub'] = $db->get_all($sql);
	}
	
	return $res;
}

/*------------------------------------------------------ */
//-- 检查分类是否存在子分类
/*------------------------------------------------------ */
function checkChild()
{
	global $db;
	$catid  = irequest('catid');
	$sql = "SELECT catid, catname FROM news_category WHERE pid = {$catid} ORDER BY listorder";
	$res = $db->get_all($sql);
	if(is_array($res) && $res){
		echo json_encode(1);
	}else{
		echo json_encode(0);
	}
	exit;
}
