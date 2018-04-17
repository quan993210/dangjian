<?php
//register_shutdown_function(function(){ var_dump(error_get_last()); });
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      news_category_list();
					  break;			  
	   	case "add_news_category":
                      add_news_category();
					  break;
		case "do_add_news_category":
                      do_add_news_category();
					  break;
	   	case "mod_news_category":
                      mod_news_category();
					  break;
		case "do_mod_news_category":
                      do_mod_news_category();
					  break;
		case "del_news_category":
                      del_news_category();
					  break;
	   	case "del_sel_news_category":
                      del_sel_news_category();
					  break;
	case "upload_batch_photo":
		upload_batch_photo();
		break;
}

function get_con()
{
	global $smarty;
	$adminid  = $_SESSION["admin_id"];
    $con = "WHERE c.is_delete= 0 and c.adminid=$adminid";
	//父级新闻分类
	$pid = irequest('pid');
	$smarty->assign('pid', $pid);
	if (!empty($pid))
	{
		$con .= " AND c.pid = '{$pid}' ";
	}
	
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= " AND c.catname like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 新闻分类列表
/*------------------------------------------------------ */	
function news_category_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 
	
	//排序字段
	$order 	 	 = 'ORDER BY c.listorder ASC, c.catid DESC';
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT c.*, c2.catname AS pname FROM news_category AS c LEFT JOIN news_category AS c2 ON c.pid = c2.catid {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(c.catid) FROM news_category AS c {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('cat_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	//顶级新闻分类
	$smarty->assign('top_news_category', get_top_news_category());
	
	//表信息
	$tbl = array('tbl' => 'news_category', 'col1' => 'name');			
	$smarty->assign('tbl', $tbl);
	
	$page_title = '新闻分类列表';
    $smarty->assign('page_title', $page_title);
	$smarty->display('news/news_category_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加新闻分类
/*------------------------------------------------------ */	
function add_news_category()
{
	global $smarty;
	
	//顶级新闻分类
	$smarty->assign('top_news_category', get_top_news_category());

	$page_title = '添加新闻分类';
    $smarty->assign('page_title', $page_title);
	
	$smarty->assign('action', 'do_add_news_category');
	$smarty->display('news/news_category.htm');
}

/*------------------------------------------------------ */
//-- 添加新闻分类
/*------------------------------------------------------ */	
function do_add_news_category()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$pid = irequest('pid');
	$catname      = crequest('catname');
	$logo      = crequest('logo_path');
	$listorder = irequest('listorder');
	$add_time	= time();
	$add_time_format	= now_time();
	check_null($catname, '新闻分类名称');
	
	$sql = "INSERT INTO news_category (pid, catname, logo,listorder, add_time, add_time_format, adminid) VALUES ('{$pid}', '{$catname}', '{$logo}', '{$listorder}', '{$add_time}', '{$add_time_format}', '{$adminid}')";
	$db->query($sql);
	$aid  = $_SESSION['admin_id'];
	$text = '添加新闻分类，添加新闻分类ID：'.$db->link_id->insert_id;
	operate_log($aid, 'news_category', 1, $text);

	$url_to = "news_category.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改新闻分类
/*------------------------------------------------------ */	
function mod_news_category()
{
	global $db, $smarty;
	
	$catid  = irequest('catid');
	$sql = "SELECT * FROM news_category WHERE catid = '{$catid}'";
	$row = $db->get_row($sql);
	$smarty->assign('cat', $row);
	
	//顶级新闻分类
	$smarty->assign('top_news_category', get_top_news_category());
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
	
	$page_title = '修改新闻分类';
    $smarty->assign('page_title', $page_title);
	$smarty->assign('action', 'do_mod_news_category');
	$smarty->display('news/news_category.htm');
}

/*------------------------------------------------------ */
//-- 修改新闻分类
/*------------------------------------------------------ */	
function do_mod_news_category()
{
	global $db;
	
    $pid = irequest('pid');
	$catname      = crequest('catname');
	$logo      = crequest('logo_path');
	$listorder = irequest('listorder');
	check_null($catname, '新闻分类名称');
	
	$catid = irequest('catid');
	$update_col = "catname = '{$catname}', pid = '{$pid}',logo = '{$logo}', listorder = '{$listorder}'";
	$sql = "UPDATE news_category SET {$update_col} WHERE catid='{$catid}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改新闻分类，修改新闻分类ID：' . $catid;
	operate_log($aid, 'news_category', 2, $text);

	$now_page = irequest('now_page');
	$url_to = "news_category.php?action=list&page=$now_page";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除新闻分类
/*------------------------------------------------------ */	
function del_news_category()
{
	global $db;
	$catid = irequest('catid');
	
	/*$sql = "DELETE FROM news_category WHERE catid = '{$catid}' OR pid = '{$catid}'";
	$db->query($sql);*/

	$update_col = "is_delete = '1'";
	$sql = "UPDATE news_category SET {$update_col} WHERE catid = '{$catid}' OR pid = '{$catid}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除新闻分类，删除新闻分类ID：' . $catid;
	operate_log($aid, 'news_category', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news_category.php?action=list&page=$now_page";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除新闻分类
/*------------------------------------------------------ */	
function del_sel_news_category()
{
	global $db;
	$catid = crequest('checkboxes');
	
	if ($catid == '')
		alert_back('请选中需要删除的选项');
	
	/*$sql = "DELETE FROM news_category WHERE catid IN ({$catid}) OR pid IN ({$catid})";
	$db->query($sql);*/

	$sql = "SELECT * FROM news_category WHERE catid IN ({$catid}) OR pid IN ({$catid})";
	$news_category_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($news_category_all as $key=>$val){
		$sql = "UPDATE news_category SET {$update_col} WHERE catid = '{$val['catid']}'";
		$db->query($sql);
	}
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除新闻分类，批量删除新闻分类ID：' . $catid;
	operate_log($aid, 'news_category', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news_category.php?action=list&page=$now_page";
	href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 一级新闻分类
/*------------------------------------------------------ */
function get_top_news_category()
{
	global $db;
	
	$sql = "SELECT catid, catname FROM news_category WHERE pid = 0 ORDER BY listorder";
	$res = $db->get_all($sql);
	
	return $res;
}

?>