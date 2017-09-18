<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/13 0013
 * Time: 21:36
 * 测试试卷
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      test_list();
					  break;			  
	   	case "add_test":
                      add_test();
					  break;
		case "do_add_test":
                      do_add_test();
					  break;
	   	case "mod_test":
                      mod_test();
					  break;
		case "do_mod_test":
                      do_mod_test();
					  break;
		case "del_test":
                      del_test();
					  break;
	   	case "del_sel_test":
                      del_sel_test();
					  break;

}

function get_con()
{
	global $smarty;
	$con = 'WHERE is_delete = 0';
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
function test_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 

	$order 	 	 = 'ORDER BY t.testid DESC';
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT t.*, c.name AS catname FROM test AS t LEFT JOIN test_category AS c ON t.catid = c.id {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);

	$sql 		= "SELECT COUNT(t.testid) FROM test AS t {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

	foreach($arr as $key=>$val){
		$sql 		= "SELECT * FROM test_answer WHERE testid = '{$val['testid']}' ORDER BY id ASC";
		$answer 		= $db->get_all($sql);
		$arr[$key]['answer'] = $answer;
	}

	$smarty->assign('test_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);

	
	//题目分类
	$smarty->assign('test_category', get_test_category());
	
    $smarty->assign('page_title', '题目列表');
	$smarty->display('test/test_list.htm');
}

/*------------------------------------------------------ */
//-- 添加题目
/*------------------------------------------------------ */	
function add_test()
{
	global $smarty;
	
	//题目分类
	$smarty->assign('test_category',  get_test_category());

	$smarty->assign('action', 'do_add_test');
	$smarty->assign('page_title', '添加题目');
	$smarty->display('test/test.htm');
}

/*------------------------------------------------------ */
//-- 添加题目
/*------------------------------------------------------ */	
function do_add_test()
{
	global $db;
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
		$answer = $_POST['choice'];
		$A = $answer['A'];
		$B = $answer['B'];
		if(!$A || !$B){
			check_null('', 			'判断题选项');
		}
		$correct = $answer['correct'];
		check_null($correct, 			'判断题正确答案');

	}

	//插入题目表
	$sql = "INSERT INTO test (catid,title,type,correct, add_time_format) VALUES ('{$catid}', '{$title}', '{$type}', '{$correct}', '{$now_time}')";
	$db->query($sql);

	//插入题目答案表
	$testid = $db->link_id->insert_id;
	unset($answer['correct']);
	foreach($answer as $key=>$val){
		$sql = "INSERT INTO test_answer (testid,name,number,add_time_format) VALUES ('{$testid}', '{$val}', '{$key}','{$now_time}')";
		$db->query($sql);
	}
	
	$aid  = $_SESSION['admin_id'];
	$text = '添加题目，添加题目ID：' . $testid;
	operate_log($aid, 'test', 1, $text);
	
	$url_to = "test.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改题目
/*------------------------------------------------------ */	
function mod_test()
{
	global $db, $smarty;
	
	$testid  = irequest('testid');
	$sql = "SELECT * FROM test WHERE testid = '{$testid}'";
	$row = $db->get_row($sql);
	$smarty->assign('test', $row);

	$sql = "SELECT * FROM test_answer WHERE testid = '{$testid}'";
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
	$smarty->assign('test_category',  get_test_category());
	
	$smarty->assign('action', 'do_mod_test');
	$smarty->assign('page_title', '修改题目');
	$smarty->display('test/test.htm');
}

/*------------------------------------------------------ */
//-- 修改题目
/*------------------------------------------------------ */	
function do_mod_test()
{
	global $db;
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

	$testid = irequest('testid');
	//修改题目表
	$update_col = "catid = '{$catid}', title = '{$title}', type = '{$type}', correct = '{$correct}'";
	$sql = "UPDATE test SET {$update_col} WHERE testid = '{$testid}'";
	$db->query($sql);

	//修改题目时，答案做新数据，重新插入题目答案表
	$sql = "DELETE FROM test_answer WHERE testid = '{$testid}'";
	$db->query($sql);
	unset($answer['correct']);
	foreach($answer as $key=>$val){
		$sql = "INSERT INTO test_answer (testid,name,number,add_time_format) VALUES ('{$testid}', '{$val}', '{$key}','{$now_time}')";
		$db->query($sql);
	}

	
	$aid  = $_SESSION['admin_id'];
	$text = '修改题目，修改题目ID：' . $testid;
	operate_log($aid, 'test', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "test.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除题目
/*------------------------------------------------------ */	
function del_test()
{
	global $db;
	
	$testid  = irequest('testid');

	$update_col = "is_delete = '1'";
	$sql = "UPDATE test SET {$update_col} WHERE testid = '{$testid}'";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '删除题目，删除题目ID：' . $testid;
	operate_log($aid, 'test', 3, $text);
	$now_page = irequest('now_page');
	$url_to = "test.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除题目
/*------------------------------------------------------ */	
function del_sel_test()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
		

	$sql = "SELECT * FROM test WHERE testid IN ({$id})";
	$test_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($test_all as $key=>$val){
		$sql = "UPDATE test SET {$update_col} WHERE testid = '{$val['testid']}'";
		$db->query($sql);
	}
	

	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除题目，批量删除题目ID：' . $id;
	operate_log($aid, 'test', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "test.php?action=list&page={$now_page}";
	href_locate($url_to);	
}


/*------------------------------------------------------ */
//-- 题目分类
/*------------------------------------------------------ */
function get_test_category()
{
	global $db;
	
	$sql = "SELECT id, name FROM test_category ORDER BY id DESC";
	$res = $db->get_all($sql);
	
	return $res;
}