
<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/8/4 0004
 * Time: 20:49
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
	case "list":
		member_list();
		break;
	case "add_member":
		add_member();
		break;
	case "do_add_member":
		do_add_member();
		break;
	case "mod_member":
		mod_member();
		break;
	case "do_mod_member":
		do_mod_member();
		break;
	case "del_member":
		del_member();
		break;
	case "del_sel_member":
		del_sel_member();
		break;
}



function member_list()
{
	global $db, $smarty;
	$adminid  = $_SESSION["admin_id"];
	//搜索条件

	$con= "WHERE is_delete = '0'";
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con.= " AND (name like '%{$keyword}%' or nickname like '%{$keyword}%' or mobile like '%{$keyword}%')";
	}
	$identity = crequest('identity');
	$smarty->assign('identitys', $identity);
	if (!empty($identity))
	{
		$con.= " AND identity = '{$identity}'";
	}

	$position = crequest('position');
	$smarty->assign('positions', $position);
	if (!empty($position))
	{
		$con.= " AND position = '{$position}'";
	}

	$grade = crequest('grade');
	$smarty->assign('grades', $grade);
	if (!empty($grade))
	{
		$con.= " AND grade = '{$grade}'";
	}
	$rank_title = crequest('rank_title');
	$smarty->assign('rank_titles', $rank_title);
	if (!empty($rank_title))
	{
		$con.= " AND rank_title = '{$rank_title}'";
	}

	$is_party_affairs = crequest('is_party_affairs');
	$smarty->assign('is_party_affairs', $is_party_affairs);
	if (!empty($is_party_affairs))
	{
		$con.= " AND is_party_affairs = '{$is_party_affairs}'";
	}

	$is_discipline = crequest('is_discipline');
	$smarty->assign('is_discipline', $is_discipline);
	if (!empty($is_discipline))
	{
		$con.= " AND is_discipline = '{$is_discipline}'";
	}

	$is_prepare = crequest('is_prepare');
	$smarty->assign('is_prepare', $is_prepare);
	if (!empty($is_prepare))
	{
		$con.= " AND is_prepare = '{$is_prepare}'";
	}

	$is_retire = crequest('is_retire');
	$smarty->assign('is_retire', $is_retire);
	if (!empty($is_retire))
	{
		$con.= " AND is_retire = '{$is_retire}'";
	}


	$order 	 	= 'ORDER BY userid DESC';

	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;
	$page_size 	= 30;
	$start    	= ($now_page - 1) * $page_size;
	$sql 		= "SELECT * FROM member {$con} {$order} LIMIT {$start},{$page_size}";
	$arr 		= $db->get_all($sql);

	$sql 		= "SELECT COUNT(userid) FROM ".PREFIX."member {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

	$smarty->assign('member_list',$arr);
	$smarty->assign('pageshow',$page->show(6));
	$smarty->assign('now_page',$page->now_page);
	$smarty->assign('info', get_member_info());
	$smarty->assign('page_title', '用户列表');
	$smarty->display('member/member_list.htm');
}


function add_member()
{
	global $smarty;
	$smarty->assign('info', get_member_info());
	$smarty->assign('action', 'do_add_member');
	$smarty->assign('page_title', '添加用户');
	$smarty->display('member/member.htm');
}


function do_add_member()
{
	global $db, $smarty;
	$adminid  = $_SESSION["admin_id"];
	$info = $_POST['member'];
	$info['adminid'] = $adminid;


	$info['add_time']	= time();
	$info['add_time_format']	= now_time();

	check_null($info['name']  	,   '用户名');
	check_null($info['mobile']  	,   '手机号');
	$sql = "SELECT * FROM member WHERE mobile = '{$info['mobile']}'";
	$member = $db->get_row($sql);
	if($member){
		$info['is_delete'] = '0';
		$db->update('member',$info,"userid = {$member['userid']}");
	}else{
		$id = $db->insert('member',$info);
	}
	$url_to = "member.php?action=list";
	url_locate($url_to, '添加成功');
}


function mod_member()
{
	global $db, $smarty;

	$userid = irequest('userid');
	$sql = "SELECT * FROM member WHERE userid = '{$userid}'";
	$member = $db->get_row($sql);
	$smarty->assign('member', $member);
	$smarty->assign('url_path', URL_PATH);
	$smarty->assign('info', get_member_info());
	$smarty->assign('now_page', irequest('now_page'));
	$smarty->assign('action', 'do_mod_member');
	$smarty->assign('page_title', '修改用户');
	$smarty->display('member/member.htm');
}


function do_mod_member()
{
	global $db;
	$info = $_POST['member'];

	check_null($info['name']  	,   '用户名');
	check_null($info['mobile']  	,   '手机号');
	$userid 	  	= irequest('userid');
	$sql = "SELECT * FROM member WHERE mobile = '{$info['mobile']}'";
	$member = $db->get_row($sql);
	/*if($member && $member['userid'] != $userid){
		alert_back('系统已存在该手机号，请勿重复添加！');
	}*/
	$db->update('member',$info,"userid=$userid");

	$aid  = $_SESSION['admin_id'];
	$text = '修改用户，修改用户ID：' . $userid;
	operate_log($aid, 'member', 2, $text);

	$now_page = irequest('now_page');
	$url_to = "member.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');
}


function del_member()
{
	global $db;

	$userid = irequest('userid');
	/*$sql = "DELETE FROM member WHERE userid = '{$userid}'";
	$db->query($sql);*/

	$update_col = "is_delete = '1'";
	$sql = "UPDATE member SET {$update_col} WHERE userid = '{$userid}'";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '删除用户，删除用户ID：' . $userid;
	operate_log($aid, 'member', 3, $text);

	$now_page = irequest('now_page');
	$url_to = "member.php?action=list&page={$now_page}";
	href_locate($url_to);
}


function del_sel_member()
{
	global $db;

	$userid = crequest('checkboxes');
	if (empty($userid))alert_back('请选中需要删除的选项');

	/*$sql = "DELETE FROM member WHERE userid IN ({$userid})";
	$db->query($sql);*/

	$sql = "SELECT * FROM member WHERE userid IN ({$userid})";
	$member_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($member_all as $key=>$val){
		$sql = "UPDATE member SET {$update_col} WHERE userid = '{$val['userid']}'";
		$db->query($sql);
	}

	$aid  = $_SESSION['admin_id'];
	$text = '批量删除会员，批量删除会员ID：' . $userid;
	operate_log($aid, 'member', 4, $text);

	$now_page = irequest('now_page');
	$url_to = "member.php?action=list&page={$now_page}";
	href_locate($url_to);
}


function get_member_info(){
	$info['identity'] = ['选择身份','正式党员','预备党员','积极分子','群众','发展对象'];
	$info['position'] = ['选择职位','固定党员','一般党员'];
	$info['grade'] = ['选择等级','无','初级','中级','高级级','正高级'];
	$info['rank_title'] = ['选择职称','无','工程','经济','会记','政工'];
	return $info;
}

?>

