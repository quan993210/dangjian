<?php
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
session_start();

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      product_list();
					  break;	  			  
	   	case "add_product":
                      add_product();
					  break;
		case "do_add_product":
                      do_add_product();
					  break;			  
	   	case "mod_product":
                      mod_product();
					  break;				  
	   	case "do_mod_product":
                      do_mod_product();
					  break;
		case "del_product":
                      del_product();
					  break;
	   	case "del_sel_product":
                      del_sel_product();
					  break;				  					  	
		case "cat_list":
                      cat_list();
					  break;	  			  
	   	case "add_cat":
                      add_cat();
					  break;
		case "do_add_cat":
                      do_add_cat();
					  break;	
		case "del_cat":
                      del_cat();
					  break;
	   	case "del_sel_cat":
                      del_sel_cat();
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
		$con .= $con == '' ? " WHERE p.cid = '{$cid}' " : " AND p.cid = '{$cid}' ";
	}
	
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= $con == '' ? " WHERE p.name like '%{$keyword}%' " : " AND p.name like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 案例列表
/*------------------------------------------------------ */	
function product_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 
	
	//排序字段
	$order 	 	= 'ORDER BY p.order_num DESC, p.add_time DESC';        
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 30;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT p.*, c.name AS cat_name FROM product AS p LEFT JOIN product_category AS c ON p.cid = c.id {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(p.id) FROM product AS p {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('product_list'   ,   $arr);
	$smarty->assign('pageshow'    ,   $page->show(6));
	$smarty->assign('now_page'    ,   $page->now_page);
	
	//表信息
	$tbl = array('tbl' => 'product', 'col1' => 'name', 'col5' => 'is_index', 'col6' => 'is_pub');			
	$smarty->assign('tbl', $tbl);
	
	//案例分类
	$smarty->assign('product_category', get_product_category());
	
    $smarty->assign('page_title', '案例列表');
	$smarty->display('product/product_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加案例
/*------------------------------------------------------ */	
function add_product()
{
	global $smarty;
	
	if (!empty($_SESSION['case_pic_img']))
	{
		$product['pic'] = $_SESSION['case_pic_img'];
	}
	
	if (!empty($_SESSION['case_logo_img']))
	{
		$product['logo'] = $_SESSION['case_logo_img'];
	}
	
	if (!empty($_SESSION['case_qrcode_img']))
	{
		$product['qrcode'] = $_SESSION['case_qrcode_img'];
	}
	
	$smarty->assign('product', $product);
	
	//案例分类
	$smarty->assign('product_category', get_product_category());
	
	$smarty->assign('action', 'do_add_product');
	$smarty->assign('page_title', '添加案例');
	$smarty->display('product/product.htm');
}

/*------------------------------------------------------ */
//-- 添加案例
/*------------------------------------------------------ */	
function do_add_product()
{
	global $db, $smarty;
	
    $cid    	= irequest('cid');
	$name    	= crequest('name');
	$brief    	= crequest('brief');
	$trade    	= crequest('trade');
	$bg_color   = crequest('bg_color');
	$is_index 	= irequest('is_index');
	$is_apple 	= irequest('is_apple');
	$is_android = irequest('is_android');
	
	$apple_down_url   = crequest('apple_down_url');
	$android_down_url = crequest('android_down_url');
	
	$pic_path 	= crequest('pic_path');
	$logo_path 	= crequest('logo_path');
	$qrcode_path= crequest('qrcode_path');
	$pics 	    = crequest('pics_path');
	$now_time	= now_time();
	$order_num 	= irequest('order_num');
	$is_pub 	= irequest('is_pub');

	//check_null($cid    	,   '案例分类');
	check_null($name  	,   '案例名称');
	//check_null($content ,   '案例描述');	

	$sql = "INSERT INTO product (cid, name, brief, trade, bg_color, add_time, is_index, is_apple, is_android, pic, logo, qrcode, pics, order_num, is_pub, apple_down_url, android_down_url) VALUES ('{$cid}', '{$name}', '{$brief}', '{$trade}', '{$bg_color}', '{$now_time}', '{$is_index}', '{$is_apple}', '{$is_android}', '{$pic_path}', '{$logo_path}', '{$qrcode_path}', '{$pics}', '{$order_num}', '{$is_pub}', '{$apple_down_url}', '{$android_down_url}')";
	$db->query($sql);
	
	unset($_SESSION['case_pic_img']);
	unset($_SESSION['case_logo_img']);
	unset($_SESSION['case_qrcode_img']);
	unset($_SESSION['case_pics_img']);
	
	$aid  = $_SESSION['admin_id'];
	$text = '添加案例，添加案例ID：' . $db->insert_id();
	operate_log($aid, 'product', 1, $text);

	$url_to = "product.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改案例
/*------------------------------------------------------ */	
function mod_product()
{
	global $db, $smarty;
	
	//分类
	$id = irequest('id');
	$sql = "SELECT * FROM " . PREFIX . "product WHERE id = '{$id}'";
	$product = $db->get_row($sql);
	$smarty->assign('product', $product);
    $smarty->assign('url_path', URL_PATH);
	//案例分类
	$smarty->assign('product_category', get_product_category());
	
	$smarty->assign('pic_list', explode('|', $product['pics']));
	
	$smarty->assign('now_page', irequest('now_page'));
	$smarty->assign('action', 'do_mod_product');
	$smarty->assign('page_title', '修改案例');
    $smarty->display('product/product.htm');	
}

/*------------------------------------------------------ */
//-- 修改案例
/*------------------------------------------------------ */	
function do_mod_product()
{
	global $db;
	
    $id 	  	= irequest('id');
	$name    	= crequest('name');
	$brief    	= crequest('brief');
	$trade    	= crequest('trade');
	$bg_color   = crequest('bg_color');
	$is_index 	= irequest('is_index');
	$is_apple 	= irequest('is_apple');
	$is_android = irequest('is_android');
	
	$apple_down_url   = crequest('apple_down_url');
	$android_down_url = crequest('android_down_url');
	
	$pic_path 	= crequest('pic_path');
	$logo_path 	= crequest('logo_path');
	$qrcode_path= crequest('qrcode_path');
	$pics 	    = crequest('pics_path');
	$order_num 	= irequest('order_num');
	$is_pub 	= irequest('is_pub');
		
	check_null($name  	,   '案例名称');
		
	$sql = "UPDATE product SET "
		 . "name = '{$name}', "
		 . "brief = '{$brief}', "
		 . "trade = '{$trade}', "
		 . "bg_color = '{$bg_color}', "
		 . "is_index = '{$is_index}', "
		 . "is_apple = '{$is_apple}', "
		 . "is_android = '{$is_android}', "
		 . "pic = '{$pic_path}', "
		 . "logo = '{$logo_path}', "
		 . "qrcode = '{$qrcode_path}', "
		 . "pics = '{$pics}', "
		 . "order_num = '{$order_num}', "
		 . "apple_down_url = '{$apple_down_url}', "
		 . "android_down_url = '{$android_down_url}', "
		 . "is_pub = '{$is_pub}' "
		 . "WHERE id = '{$id}'";
	$db->query($sql);
	
	unset($_SESSION['case_pic_img']);
	unset($_SESSION['case_logo_img']);
	unset($_SESSION['case_qrcode_img']);
	unset($_SESSION['case_pics_img']);
	
	$aid  = $_SESSION['admin_id'];
	$text = '修改案例，修改案例ID：' . $id;
	operate_log($aid, 'product', 2, $text);

	$now_page = irequest('now_page');
	$url_to = "product.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');		
}

/*------------------------------------------------------ */
//-- 删除案例
/*------------------------------------------------------ */	
function del_product()
{
	global $db;
	
	$id = irequest('id');
	$sql = "SELECT pic, logo, qrcode, pics FROM product WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	del_img($row['pic']);
	del_img($row['logo']);
	del_img($row['qrcode']);
	
	$pic_arr = explode('|', $row['pics']);
	foreach ($pic_arr as $val)
	{
		del_img($val);
	}
	
	$sql = "DELETE FROM product WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除案例，删除案例ID：' . $id;
	operate_log($aid, 'product', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "product.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除案例
/*------------------------------------------------------ */	
function del_sel_product()
{
	global $db;
	
	$id = crequest('checkboxes');
	if (empty($id))alert_back('请选中需要删除的选项');
	
	$sql = "SELECT pic, logo, qrcode, pics FROM product WHERE id IN ({$id})";
	$imgs_all = $db->get_all($sql);
	for ($i = 0; $i < count($imgs_all); $i++)
	{
		del_img($imgs_all[$i]['pic']);
		del_img($imgs_all[$i]['logo']);
		del_img($imgs_all[$i]['qrcode']);
		
		unset($pic_arr);
		$pic_arr = explode('|', $imgs_all[$i]['pics']);
		foreach ($pic_arr as $val)
		{
			del_img($val);
		}
	}
	
	$sql = "DELETE FROM product WHERE id IN ({$id})";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除案例，批量删除案例ID：' . $id;
	operate_log($aid, 'product', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "product.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

function upload_file($file)
{
	//$file = $_FILES['file_source'];
	$pos = strrpos($file['name'], '.');
    $file_type = substr($file['name'], $pos);		
	$file_name = date('YmdHis' . rand(111111, 999999)) . $file_type;
    move_uploaded_file($file["tmp_name"], '../upload/product/' . $file_name);
    
	return $file_name;
}

/*------------------------------------------------------ */
//-- 删除案例图片
/*------------------------------------------------------ */	
function del_one_img()
{
	$pic_path = crequest('pic_path');
	del_img($pic_path);
	
	$id = irequest('id');
	if (!empty($id))
	{
		global $db;
		$replace_img = $pic_path . '|';
		$sql = "UPDATE product SET pics = replace(pics, '{$replace_img}', '') WHERE id = '{$id}'";
		$db->query($sql);
	}
	
	echo '1';
}
?>
