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

}

function get_con()
{
	global $smarty;
	$adminid  = $_SESSION["admin_id"];
	$con = "WHERE t.is_delete = 0 and t.adminid='{$adminid}'";
	//题目分类
	$cid = irequest('cid');
	$smarty->assign('cid', $cid);
	if (!empty($cid))
	{
		$con .=" and t.catid = '{$cid}'";
	}
	
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= " AND t.title like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 题目列表
/*------------------------------------------------------ */	
function timu_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 

	$order 	 	 = 'ORDER BY t.timuid DESC';
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT t.*, c.name AS catname FROM timu AS t LEFT JOIN timu_category AS c ON t.catid = c.id {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);

	$sql 		= "SELECT COUNT(t.timuid) FROM timu AS t {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

	foreach($arr as $key=>$val){
		$sql 		= "SELECT * FROM timu_answer WHERE timuid = '{$val['timuid']}' ORDER BY id ASC";
		$answer 		= $db->get_all($sql);
		$arr[$key]['answer'] = $answer;
	}

	$smarty->assign('timu_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);

	
	//题目分类
	$smarty->assign('timu_category', get_timu_category());
	
    $smarty->assign('page_title', '题目列表');
	$smarty->display('timu/timu_list.htm');
}

/*------------------------------------------------------ */
//-- 添加题目
/*------------------------------------------------------ */	
function add_timu()
{
	global $smarty;
	
	//题目分类
	$smarty->assign('timu_category',  get_timu_category());

	$smarty->assign('action', 'do_add_timu');
	$smarty->assign('page_title', '添加题目');
	$smarty->display('timu/timu.htm');
}

/*------------------------------------------------------ */
//-- 添加题目
/*------------------------------------------------------ */	
function do_add_timu()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$title    = crequest('title');
	$catid      = crequest('catid');
	$type	  = irequest('type');
	$now_time = now_time();

	check_null($catid, 			'题目分类');
	check_null($title, 			'题目标题');
	check_null($type, 			'题目类型');
	if($type == 1){  //选择题
		$answer = $_POST['choice'];
		$A = $answer['A'];
		$B = $answer['B'];
		$C = $answer['C'];
		$D = $answer['D'];
		if(!$A || !$B  || !$C  ||  !$D){
			check_null('', 			'选择题选项');
		}
		$correct = $answer['correct'];
		check_null($correct, 			'选择题正确答案');



	}else{
		$answer = $_POST['judge'];
		$A = $answer['A'];
		$B = $answer['B'];
		if(!$A || !$B){
			check_null('', 			'判断题选项');
		}
		$correct = $answer['correct'];
		check_null($correct, 			'判断题正确答案');

	}

	//插入题目表
	$sql = "INSERT INTO timu (catid,title,type,correct, add_time_format,adminid) VALUES ('{$catid}', '{$title}', '{$type}', '{$correct}', '{$now_time}','{$adminid}')";
	$db->query($sql);

	//插入题目答案表
	$timuid = $db->link_id->insert_id;
	unset($answer['correct']);
	foreach($answer as $key=>$val){
		$sql = "INSERT INTO timu_answer (timuid,name,number,add_time_format,adminid) VALUES ('{$timuid}', '{$val}', '{$key}','{$now_time}','{$adminid}')";
		$db->query($sql);
	}
	
	$aid  = $_SESSION['admin_id'];
	$text = '添加题目，添加题目ID：' . $timuid;
	operate_log($aid, 'timu', 1, $text);
	
	$url_to = "timu.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改题目
/*------------------------------------------------------ */	
function mod_timu()
{
	global $db, $smarty;
	
	$timuid  = irequest('timuid');
	$sql = "SELECT * FROM timu WHERE timuid = '{$timuid}'";
	$row = $db->get_row($sql);
	$smarty->assign('timu', $row);

	$sql = "SELECT * FROM timu_answer WHERE timuid = '{$timuid}'";
	$data = $db->get_all($sql);
	foreach($data as $key=>$val){
		$answer[$val['number']] = $val;
	}
	if($row['type'] == 1){
		$smarty->assign('choice', $answer);
	}else{
		$smarty->assign('judge', $answer);
	}

	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);
    
	//题目分类
	$smarty->assign('timu_category',  get_timu_category());
	
	$smarty->assign('action', 'do_mod_timu');
	$smarty->assign('page_title', '修改题目');
	$smarty->display('timu/timu.htm');
}

/*------------------------------------------------------ */
//-- 修改题目
/*------------------------------------------------------ */	
function do_mod_timu()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$title    = crequest('title');
	$catid      = crequest('catid');
	$type	  = irequest('type');
	$now_time = now_time();

	check_null($catid, 			'题目分类');
	check_null($title, 			'题目标题');
	check_null($type, 			'题目类型');
	if($type == 1){  //选择题
		$answer = $_POST['choice'];
		$A = $answer['A'];
		$B = $answer['B'];
		$C = $answer['C'];
		$D = $answer['D'];
		if(!$A || !$B  || !$C  ||  !$D){
			check_null('', 			'选择题选项');
		}
		$correct = $answer['correct'];
		check_null($correct, 			'选择题正确答案');



	}else{
		$answer = $_POST['judge'];
		$A = $answer['A'];
		$B = $answer['B'];
		if(!$A || !$B){
			check_null('', 			'判断题选项');
		}
		$correct = $answer['correct'];
		check_null($correct, 			'判断题正确答案');

	}

	$timuid = irequest('timuid');
	//修改题目表
	$update_col = "catid = '{$catid}', title = '{$title}', type = '{$type}', correct = '{$correct}'";
	$sql = "UPDATE timu SET {$update_col} WHERE timuid = '{$timuid}'";
	$db->query($sql);

	//修改题目时，答案做新数据，重新插入题目答案表
	$sql = "DELETE FROM timu_answer WHERE timuid = '{$timuid}'";
	$db->query($sql);
	unset($answer['correct']);
	foreach($answer as $key=>$val){
		$sql = "INSERT INTO timu_answer (timuid,name,number,add_time_format,adminid) VALUES ('{$timuid}', '{$val}', '{$key}','{$now_time}','{$adminid}')";
		$db->query($sql);
	}

	
	$aid  = $_SESSION['admin_id'];
	$text = '修改题目，修改题目ID：' . $timuid;
	operate_log($aid, 'timu', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "timu.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除题目
/*------------------------------------------------------ */	
function del_timu()
{
	global $db;
	
	$timuid  = irequest('timuid');

	$update_col = "is_delete = '1'";
	$sql = "UPDATE timu SET {$update_col} WHERE timuid = '{$timuid}'";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '删除题目，删除题目ID：' . $timuid;
	operate_log($aid, 'timu', 3, $text);
	$now_page = irequest('now_page');
	$url_to = "timu.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除题目
/*------------------------------------------------------ */	
function del_sel_timu()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
		

	$sql = "SELECT * FROM timu WHERE timuid IN ({$id})";
	$timu_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($timu_all as $key=>$val){
		$sql = "UPDATE timu SET {$update_col} WHERE timuid = '{$val['timuid']}'";
		$db->query($sql);
	}
	

	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除题目，批量删除题目ID：' . $id;
	operate_log($aid, 'timu', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "timu.php?action=list&page={$now_page}";
	href_locate($url_to);	
}


/*------------------------------------------------------ */
//-- 题目分类
/*------------------------------------------------------ */
function get_timu_category()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$sql = "SELECT id, name FROM timu_category where adminid='{$adminid}' ORDER BY id DESC";
	$res = $db->get_all($sql);
	
	return $res;
}