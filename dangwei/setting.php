
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
$action = $action == '' ? 'mod_school' : $action;

switch ($action)
{
	case "mod_school":
		mod_school();
		break;
	case "do_mod_school":
		do_mod_school();
		break;
	case "upload_batch_photo";
		upload_batch_photo();
		break;
	case "region";
		region();
		break;
}

/*------------------------------------------------------ */
//-- 修改学校
/*------------------------------------------------------ */
function mod_school()
{
	global $db, $smarty;
	$schoolid = $_COOKIE['schoolid'];
	$sql = "SELECT * FROM school WHERE id = '{$schoolid}' and is_delete =0";
	$school = $db->get_row($sql);
	$school['albums'] = explode(',',$school['albums']);
	$smarty->assign('school', $school);
	$smarty->assign('url_path', URL_PATH);
	$smarty->assign('now_page', irequest('now_page'));
	$smarty->assign('action', 'do_mod_school');
	$smarty->assign('page_title', '设置');
	$smarty->display('school/school.htm');
}

/*------------------------------------------------------ */
//-- 修改学校
/*------------------------------------------------------ */
function do_mod_school()
{
	global $db;
	$id 	  	= irequest('id');
	$data=$_POST['info'];
	$image[]   = crequest('image1');
	$image[]   = crequest('image2');
	$image[]   = crequest('image3');
	$image[]   = crequest('image4');
	$image[]   = crequest('image5');
	$image[]   = crequest('image6');
	$image[]   = crequest('image7');
	$image[]   = crequest('image8');
	$image[]   = crequest('image9');
	$data['albums'] = implode(',',$image);
	$data['password'] = md5($data['password']);
	/*check_null($data['admin_user_name']  	,   '登录账号');
	check_null($data['password']  	,   '登录密码');*/
	check_null($data['name']  	,   '机构名称');
	check_null($data['mobile']  	,   '联系电话');

	if($data['admin_user_name']){
		$sql = "SELECT * FROM school WHERE admin_user_name = '{$data['admin_user_name']}' and is_delete=0";
		$school = $db->get_row($sql);
		if($school && $school['id'] != $id){
			alert_back('系统已存在该登录账号！');
		}
	}

	$location = location($data['region'].$data['address']);
	$data['lng'] = $location['lng'];
	$data['lat'] = $location['lat'];
	$db->update('school',$data,"id=$id");
	$aid  = $_COOKIE['schoolid'];
	$text = '修改幼教机构，修改幼教机构ID：' . $id;
	school_operate_log($aid, 'school', 2, $text);
	$now_page = irequest('now_page');
	$url_to = "setting.php?list&page={$now_page}";
	url_locate($url_to, '修改成功');
}

?>

