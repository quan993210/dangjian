<?php

set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
	require("inc/lib_common.php");
	
	//搜索条件
	$search_cat = irequest('search_cat');
	$keyword 	= crequest('keyword');
	
	switch ($search_cat)
	{
		case 1:
				$con = "WHERE nick_name LIKE '%{$keyword}%'";
				break;
		case 2:
				$con = "WHERE reg_ip LIKE '%{$keyword}%'";
				break;
		default:
				$search_cat = 0;
				$keyword = '';
				break;		
	}
	
	$smarty->assign('search_cat' ,   $search_cat);
	$smarty->assign('keyword'    ,   $keyword);
	  
	//排序字段
	$sort_col 	 = crequest('sort_col');	
	$asc_or_desc = crequest('asc_or_desc');
	$order 		 = set_order($sort_col, $asc_or_desc, $smarty);        
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 30;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT * FROM " . PREFIX . "member {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(id) FROM ".PREFIX."member {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('member_list',$arr);
	$smarty->assign('pageshow',$page->show(6));
	$smarty->assign('now_page',$page->now_page);
	
	//表信息
	$tbl = array('tbl' => 'member', 'col1' => 'truename', 'col2' => 'mobile', 'col3' => 'email', 'col4' => 'address', 'col5' => 'zipcode', 'col6' => 'reg_ip', 'col7' => 'reg_time', 'col8' => 'is_enable');			
	$smarty->assign('tbl',$tbl);
	
	$smarty->assign('page_title', '会员列表');	
    $smarty->display('member/member.htm');
    
?>