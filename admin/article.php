<?php
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      article_list();
					  break;			  
	   	case "add_article":
                      add_article();
					  break;
		case "do_add_article":
                      do_add_article();
					  break;
	   	case "mod_article":
                      mod_article();
					  break;
		case "do_mod_article":
                      do_mod_article();
					  break;
		case "del_article":
                      del_article();
					  break;
	   	case "del_sel_article":
                      del_sel_article();
					  break;				  					  	
	   	case "del_one_img":
                      del_one_img();
					  break;
		case "upload_batch_photo":
                      upload_batch_photo();
					  break;			  
}

function get_con()
{
	global $smarty;
	
	//文章分类
	$cid = irequest('cid');
	$smarty->assign('cid', $cid);
	if (!empty($cid))
	{
		$con .= $con == '' ? " WHERE a.cid = '{$cid}' " : " AND a.cid = '{$cid}' ";
	}
	
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= $con == '' ? " WHERE a.title like '%{$keyword}%' " : " AND a.title like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 文章列表
/*------------------------------------------------------ */	
function article_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 
	
	//排序字段
	$sort_col 	 = crequest('sort_col');	
	$asc_or_desc = crequest('asc_or_desc');
	$order 	 	 = 'ORDER BY a.add_time DESC';        
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT a.*, c.name AS cat FROM article AS a LEFT JOIN article_category AS c ON a.cid = c.id {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(a.id) FROM article AS a {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('article_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	//表信息
	$tbl = array('tbl' => 'article', 'col1' => 'title', 'col2' => 'is_top');			
	$smarty->assign('tbl', $tbl);
	
	//文章分类
	$smarty->assign('article_category', get_article_category());
	
    $smarty->assign('page_title', '文章列表');
	$smarty->display('article/article_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加文章
/*------------------------------------------------------ */	
function add_article()
{
	global $smarty;
	
	$cases = get_case(1, 100);
	$smarty->assign('cases', $cases);
	
	//文章分类
	$smarty->assign('article_category',  get_article_category());
	
	if (!empty($_SESSION['article_pic_path']))
	{
		$article['pic'] = $_SESSION['article_pic_path'];
	}
	
	$smarty->assign('article', $article);
	$smarty->assign('action', 'do_add_article');
	$smarty->assign('page_title', '添加文章');
	$smarty->display('article/article.htm');
}

/*------------------------------------------------------ */
//-- 添加文章
/*------------------------------------------------------ */	
function do_add_article()
{
	global $db;
	
	$title    = crequest('title');
	$brief    = crequest('brief');
	$content  = $_REQUEST['content'];
	$author   = crequest('author');
	$source   = crequest('source');
	$is_top   = irequest('is_top');
	$cid	  = irequest('cid');
	$pic_path = crequest('pic_path');
	$pid	  = irequest('pid');
	$order_num= irequest('order_num');
	
	check_null($title, 			'文章标题');
	//check_null($content, 		'文章内容');
	
	/*$pic = $_FILES['pic'];	
	if (!empty($pic['name']))
	{
		$upload_path = '/upload/article/' . date('ym') . '/'; 
		$pic_name = @upload($pic, $upload_path);
		$pic_path = $upload_path . $pic_name;
	}*/
	
	$top_pic = $_FILES['top_pic'];	
	if (!empty($top_pic['name']))
	{
		//$top_pic_name = @upload($top_pic);
		$upload_path = '/upload/article/' . date('ym') . '/'; 
		$top_pic_name = @upload($top_pic, $upload_path);
		$top_pic_path = $upload_path . $top_pic_name;
	}
	
	$now_time = now_time();
	$sql = "INSERT INTO article (title, brief, content, cid, add_time, author, source, pic, is_top, top_pic, pid, order_num) VALUES ('{$title}', '{$brief}', '{$content}', '{$cid}', '{$now_time}', '{$author}', '{$source}', '{$pic_path}', '{$is_top}', '{$top_pic_path}', '{$pid}', '{$order_num}')";
	$db->query($sql);
	
	unset($_SESSION['article_pic_path']);
	
	$aid  = $_SESSION['admin_id'];
	$text = '添加文章，添加文章ID：' . $db->insert_id();
	operate_log($aid, 'article', 1, $text);
	
	$url_to = "article.php?action=list&type={$parent_id}";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改文章
/*------------------------------------------------------ */	
function mod_article()
{
	global $db, $smarty;
	
	$id  = irequest('id');
	$sql = "SELECT * FROM article WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	$smarty->assign('article', $row);
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
	
	$cases = get_case(1, 100);
	$smarty->assign('cases', $cases);
    
	//文章分类
	$smarty->assign('article_category',  get_article_category());
	
	$smarty->assign('action', 'do_mod_article');
	$smarty->assign('page_title', '修改文章');
	$smarty->display('article/article.htm');
}

/*------------------------------------------------------ */
//-- 修改文章
/*------------------------------------------------------ */	
function do_mod_article()
{
	global $db;
	
	$title    = crequest('title');
	$brief    = crequest('brief');
	$content  = $_REQUEST['content'];
	$author   = crequest('author');
	$source   = crequest('source');
	$is_top   = irequest('is_top');
	$cid	  = irequest('cid');
	$pic_path = crequest('pic_path');
	$pid	  = irequest('pid');
	$order_num= irequest('order_num');
	/*$pic = $_FILES['pic'];
	if (empty($pic['name']))
	{
		$pic_path = crequest('pic_name');
	}
	else
	{
		del_img(crequest('pic_name'));
		
		$upload_path = '/upload/article/' . date('ym') . '/'; 
		$pic_name = @upload($pic, $upload_path);
		$pic_path = $upload_path . $pic_name;
	}*/
	
	$top_pic = $_FILES['top_pic'];
	if (empty($top_pic['name']))
	{
		$top_pic_path = crequest('top_pic_name');
	}
	else
	{
		del_img(crequest('top_pic_name'));
		
		$upload_path = '/upload/article/' . date('ym') . '/'; 
		$top_pic_name = @upload($top_pic, $upload_path);
		$top_pic_path = $upload_path . $top_pic_name;
	}
	
	check_null($title, 			'文章标题');
	//check_null($content, 		'文章内容');
	
	$id = irequest('id');
	$update_col = "title = '{$title}', brief = '{$brief}', content = '{$content}', cid = '{$cid}', author = '{$author}', source = '{$source}', pic = '{$pic_path}', is_top = '{$is_top}', top_pic = '{$top_pic_path}', pid = '{$pid}', order_num = '{$order_num}'";
	$sql = "UPDATE article SET {$update_col} WHERE id='{$id}'";
	$db->query($sql);
	
	unset($_SESSION['article_pic_path']);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改文章，修改文章ID：' . $id;
	operate_log($aid, 'article', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "article.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除文章
/*------------------------------------------------------ */	
function del_article()
{
	global $db;
	
	$id  = irequest('id');
	$sql = "SELECT pic, top_pic FROM article WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	del_img($row['pic']);
	del_img($row['top_pic']);
	
	$sql = "DELETE FROM article WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除文章，删除文章ID：' . $id;
	operate_log($aid, 'article', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "article.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除文章
/*------------------------------------------------------ */	
function del_sel_article()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
		
	$sql = "SELECT pic, top_pic FROM article WHERE id IN ({$id})";
	$imgs_all = $db->get_all($sql);
	for ($i = 0; $i < count($imgs_all); $i++)
	{
		$pic = $imgs_all[$i]['pic'];
		$top_pic = $imgs_all[$i]['top_pic'];
		del_img($pic);
		del_img($top_pic);
	}	
	
	$sql = "DELETE FROM article WHERE id IN ({$id})";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除文章，批量删除文章ID：' . $id;
	operate_log($aid, 'article', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "article.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 删除文章图片
/*------------------------------------------------------ */	
function del_one_img()
{
	$img_name = crequest('img_name');
	//del_img($img_name);
	
	$id = irequest('id');
	$now_page = irequest('now_page');
	
	global $db;
	$replace_img = $img_name . '|';
	$sql = "UPDATE article SET imgs = replace(imgs, '{$replace_img}', '') WHERE id = '{$id}'";
	$db->query($sql);
	
	$url_to = "article.php?action=mod_article&id={$id}&now_page=$now_page";
	href_locate($url_to, '删除成功');	
}

/*------------------------------------------------------ */
//-- 文章分类
/*------------------------------------------------------ */
function get_article_category()
{
	global $db;
	
	$sql = "SELECT id, name FROM article_category WHERE parent_id = 0 ORDER BY order_num";
	$res = $db->get_all($sql);
	$num = count($res);
	
	for ($i = 0; $i < $num; $i++)
	{
		$id  = $res[$i]['id'];
		$sql = "SELECT id, name FROM article_category WHERE parent_id = {$id} ORDER BY order_num";
		$res[$i]['sub'] = $db->get_all($sql);
	}
	
	return $res;
}

