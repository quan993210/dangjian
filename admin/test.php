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
	   /*	case "mod_test":
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
					  break;*/

}

function get_con()
{
	global $smarty;
	$con = 'WHERE is_delete = 0';
	
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
//-- 测试列表
/*------------------------------------------------------ */	
function test_list()
{
	global $db, $smarty;
	//搜索条件
	$con 		= get_con(); 

	$order 	 	 = 'ORDER BY testid DESC';
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT * FROM test {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);

	$sql 		= "SELECT COUNT(testid) FROM test {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));


	$smarty->assign('test_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);

	
    $smarty->assign('page_title', '测试试卷列表');
	$smarty->display('test/test_list.htm');
}

/*------------------------------------------------------ */
//-- 添加测试
/*------------------------------------------------------ */	
function add_test()
{
	global $smarty;
	
	//题目分类
	$smarty->assign('test_category',  get_test_category());

	$smarty->assign('action', 'do_add_test');
	$smarty->assign('page_title', '添加测试');
	$smarty->display('test/test.htm');
}

/*------------------------------------------------------ */
//-- 添加测试
/*------------------------------------------------------ */	
function do_add_test()
{
	global $db;
	$title    = crequest('title');
	$limit_time     = crequest('limit_time');
	$limit_count	  = irequest('limit_count');
	$now_time = now_time();
	$time = time();

	check_null($title, 			'测试标题');
	check_null($limit_time, 			'测试时间');
	check_null($limit_count, 			'题目数量');

	$catids = implode(',',$_POST['catid']);
	$sql = "SELECT COUNT(id) FROM timu WHERE catid IN ({$catids})";
	$total 		= $db->get_one($sql);
	if($total < $limit_count){
		check_null($limit_count, 			'题库中题目数量不足');
	}

	$sql 		= "SELECT timuid FROM timu WHERE catid IN ({$catids})";
	$timu 		= $db->get_all($sql);
	$result = array();

	$arr_len = count($timu);
	$start = 0;
	while($start < $limit_count)
	{
		$random = rand(0, $arr_len - $start - 1);
		$result[] = $timu[$random];
		swap($timu[$random] , $timu[$arr_len - $start - 1]);
		$start += 1;
	}

	/*if(is_array($result) && $result){
		//插入测试试卷表
		$sql = "INSERT INTO test (title,limit_count,limit_time, timu_catids,add_time,add_time_format) VALUES ('{$title}', '{$limit_count}', '{$limit_time}', '{$catids}', '{$time}', '{$now_time}')";
		$db->query($sql);

		$testid = $db->link_id->insert_id;
		//插入测试题目表
		foreach($result as $key=>$val){
			$sql = "INSERT INTO test_answer (testid,name,number,add_time_format) VALUES ('{$testid}', '{$val}', '{$key}','{$now_time}')";
			$db->query($sql);

		}
	}





	
	$aid  = $_SESSION['admin_id'];
	$text = '添加测试，添加测试ID：' . $testid;
	operate_log($aid, 'test', 1, $text);*/
	
	$url_to = "test.php?action=list";
	url_locate($url_to, '添加成功');	
}


/*------------------------------------------------------ */
//-- 修改测试
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
	$smarty->assign('page_title', '修改测试');
	$smarty->display('test/test.htm');
}

/*------------------------------------------------------ */
//-- 修改测试
/*------------------------------------------------------ */	
function do_mod_test()
{
	global $db;
	$title    = crequest('title');
	$catid      = crequest('catid');
	$type	  = irequest('type');
	$now_time = now_time();

	check_null($catid, 			'题目分类');
	check_null($title, 			'测试标题');
	check_null($type, 			'测试类型');
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
	//修改测试表
	$update_col = "catid = '{$catid}', title = '{$title}', type = '{$type}', correct = '{$correct}'";
	$sql = "UPDATE test SET {$update_col} WHERE testid = '{$testid}'";
	$db->query($sql);

	//修改测试时，答案做新数据，重新插入测试答案表
	$sql = "DELETE FROM test_answer WHERE testid = '{$testid}'";
	$db->query($sql);
	unset($answer['correct']);
	foreach($answer as $key=>$val){
		$sql = "INSERT INTO test_answer (testid,name,number,add_time_format) VALUES ('{$testid}', '{$val}', '{$key}','{$now_time}')";
		$db->query($sql);
	}

	
	$aid  = $_SESSION['admin_id'];
	$text = '修改测试，修改测试ID：' . $testid;
	operate_log($aid, 'test', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "test.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除测试
/*------------------------------------------------------ */	
function del_test()
{
	global $db;
	
	$testid  = irequest('testid');

	$update_col = "is_delete = '1'";
	$sql = "UPDATE test SET {$update_col} WHERE testid = '{$testid}'";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '删除测试，删除测试ID：' . $testid;
	operate_log($aid, 'test', 3, $text);
	$now_page = irequest('now_page');
	$url_to = "test.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除测试
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
	$text = '批量删除测试，批量删除测试ID：' . $id;
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
	
	$sql = "SELECT id, name FROM timu_category ORDER BY id DESC";
	$res = $db->get_all($sql);
	
	return $res;
}

function swap(&$a, &$b)
{
	$temp = $b;
	$b = $a;
	$a = $temp;
}