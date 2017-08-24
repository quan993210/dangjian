<?php
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      product_category_list();
					  break;			  
	   	case "add_product_category":
                      add_product_category();
					  break;
		case "do_add_product_category":
                      do_add_product_category();
					  break;
	   	case "mod_product_category":
                      mod_product_category();
					  break;
		case "do_mod_product_category":
                      do_mod_product_category();
					  break;
		case "del_product_category":
                      del_product_category();
					  break;
	   	case "del_sel_product_category":
                      del_sel_product_category();
					  break;				  					  	
}

function get_con()
{
	global $smarty;
	
	//父级产品分类
	$parent_id = irequest('parent_id');
	$smarty->assign('parent_id', $parent_id);
	if (!empty($parent_id))
	{
		$con .= $con == '' ? " WHERE c.parent_id = '{$parent_id}' " : " AND c.parent_id = '{$parent_id}' ";
	}
	
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= $con == '' ? " WHERE c.name like '%{$keyword}%' " : " AND c.name like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 产品分类列表
/*------------------------------------------------------ */	
function product_category_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 
	
	//排序字段
	$sort_col 	 = crequest('sort_col');	
	$asc_or_desc = crequest('asc_or_desc');
	$order 	 	 = 'ORDER BY c.order_num ASC, c.id DESC';        
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT c.*, c2.name AS parent FROM product_category AS c LEFT JOIN product_category AS c2 ON c.parent_id = c2.id {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(c.id) FROM product_category AS c {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('cat_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	//顶级产品分类
	$smarty->assign('top_product_category', get_top_product_category());
	
	//表信息
	$tbl = array('tbl' => 'product_category', 'col1' => 'name');			
	$smarty->assign('tbl', $tbl);
	
	$page_title = '产品分类列表';
    $smarty->assign('page_title', $page_title);
	$smarty->display('product/product_category_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加产品分类
/*------------------------------------------------------ */	
function add_product_category()
{
	global $smarty;
	
	//顶级产品分类
	$smarty->assign('top_product_category', get_top_product_category());
	
	$page_title = '添加产品分类';
    $smarty->assign('page_title', $page_title);
	
	$smarty->assign('action', 'do_add_product_category');
	$smarty->display('product/product_category.htm');
}

/*------------------------------------------------------ */
//-- 添加产品分类
/*------------------------------------------------------ */	
function do_add_product_category()
{
	global $db;
	
	$parent_id = irequest('parent_id');
	$name      = crequest('name');
	$order_num = irequest('order_num');
	check_null($name, '产品分类名称');
	
	$sql = "INSERT INTO product_category (parent_id, name, order_num) VALUES ('{$parent_id}', '{$name}', '{$order_num}')";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '添加产品分类，添加产品分类ID：' . $db->insert_id();
	operate_log($aid, 'product_category', 1, $text);
	
	$url_to = "product_category.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改产品分类
/*------------------------------------------------------ */	
function mod_product_category()
{
	global $db, $smarty;
	
	$id  = irequest('id');
	$sql = "SELECT * FROM product_category WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	$smarty->assign('cat', $row);
	
	//顶级产品分类
	$smarty->assign('top_product_category', get_top_product_category());
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
	
	$page_title = '修改产品分类';
    $smarty->assign('page_title', $page_title);
	$smarty->assign('action', 'do_mod_product_category');
	$smarty->display('product/product_category.htm');
}

/*------------------------------------------------------ */
//-- 修改产品分类
/*------------------------------------------------------ */	
function do_mod_product_category()
{
	global $db;
	
    $parent_id = irequest('parent_id');
	$name      = crequest('name');
	$order_num = irequest('order_num');
	check_null($name, '产品分类名称');
	
	$id = irequest('id');
	$update_col = "name = '{$name}', parent_id = '{$parent_id}', order_num = '{$order_num}'";
	$sql = "UPDATE product_category SET {$update_col} WHERE id='{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改产品分类，修改产品分类ID：' . $id;
	operate_log($aid, 'product_category', 2, $text);

	$now_page = irequest('now_page');
	$url_to = "product_category.php?action=list&page=$now_page";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除产品分类
/*------------------------------------------------------ */	
function del_product_category()
{
	global $db;
	$id = irequest('id');
	
	$sql = "DELETE FROM product_category WHERE id = '{$id}' OR parent_id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除产品分类，删除产品分类ID：' . $id;
	operate_log($aid, 'product_category', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "product_category.php?action=list&page=$now_page";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除产品分类
/*------------------------------------------------------ */	
function del_sel_product_category()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
	
	$sql = "DELETE FROM product_category WHERE id IN ({$id}) OR parent_id IN ({$id})";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除产品分类，批量删除产品分类ID：' . $id;
	operate_log($aid, 'product_category', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "product_category.php?action=list&page=$now_page";
	href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 一级产品分类
/*------------------------------------------------------ */
function get_top_product_category()
{
	global $db;
	
	$sql = "SELECT id, name FROM product_category WHERE parent_id = 0 ORDER BY order_num";
	$res = $db->get_all($sql);
	
	return $res;
}

?>