<?php
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");

$action = crequest("action");
$action = $action == '' ? 'index' : $action;  

switch ($action) 
{	   
    case 'index':
			    display_index();
				break;
	case 'login':
			    login();
				break;
	case 'logout':
			    logout();
				break;
	case 'menu':
				menu();
				break;
	case 'top':
				top();
				break;
	case 'drag':
				drag();
				break;			
	case 'main':
				admin_main();
				break;		  
	case "mod_pwd":
                mod_pwd();
				break;
	case "do_mod_pwd":
                do_mod_pwd();
				break;				
	case "clear_cache":
                clear_cache();
				break;	
}

/*------------------------------------------------------ */
//-- 显示菜单页面
/*------------------------------------------------------ */
function menu()
{
	global $smarty;
	$sub[]  = array('url' => 'lable.php', 				'name' => '文章标签');
	$sub[]  = array('url' => 'report.php',          	'name' => '报表管理');
	$sub[]  = array('url' => 'admin_dangwei.php',       'name' => '党支部管理');
	$menu[] = array('name' => '网站管理', 				     'sub' => $sub);
	$smarty->assign('menu', $menu);
	$smarty->display('common/menu.htm');
}

/*------------------------------------------------------ */
//-- 显示缩放页面
/*------------------------------------------------------ */
function drag()
{
	global $smarty;
	$smarty->display('common/drag.htm');
}

/*------------------------------------------------------ */
//-- 显示顶部页面
/*------------------------------------------------------ */
function top()
{
	global $smarty;
	
	$admin_user_name = $_COOKIE['admin_user_name'];
	$smarty->assign('admin', $admin_user_name);
	
	$smarty->display('common/top.htm');
}

/*------------------------------------------------------ */
//-- 显示后台页面
/*------------------------------------------------------ */
function admin_main()
{
	global $db, $smarty;
	
	/* 系统信息 */
	$sys_info['domain']     = $_SERVER['SERVER_NAME'];
	$sys_info['os']         = PHP_OS;
	$sys_info['ip']         = $_SERVER['SERVER_ADDR'];
	$sys_info['web_server'] = $_SERVER['SERVER_SOFTWARE'];
	$sys_info['server_port']= $_SERVER['SERVER_PORT'];
	$sys_info['php_ver']    = PHP_VERSION;
	$sys_info['safe_mode']  = (boolean) ini_get('safe_mode') ? '是' : '否';
	$sys_info['socket']     = function_exists('fsockopen') ?  '是' : '否';
	$sys_info['mysql']	    = $db->version(); 
	$sys_info['char_set']	= CHAR_SET; 
	$sys_info['gd']			= gd_version();
	
	$sys_info['copyright']  = WEB_NAME;
	$sys_info['version']   	= '1.0';
	$sys_info['support'] 	= '辰锦科技';
	$sys_info['service'] 	= '18070123163';
	$sys_info['qq']       	= '250686110';
	
	$smarty->assign('sys_info', $sys_info);
	$smarty->display('common/main.htm');
}

/*------------------------------------------------------ */
//-- 显示登录页面
/*------------------------------------------------------ */
function display_index()
{
	global $smarty;
	
	if (empty($_COOKIE["dangwei_id"]))
		$smarty->display('common/login.htm');
	else
		$smarty->display('index.htm');
}

/*------------------------------------------------------ */
//-- 管理员登陆
/*------------------------------------------------------ */
function login()
{	
	global $db, $smarty;
	
	$dangwei_name = crequest('userid');
	$pwd 	= md5(crequest('pwd'));
	
	check_null($dangwei_name, '用户名');
	check_null($pwd, '密码');
	
	//check_code();			//验证验证码
	
	$sql = "select * from dangwei where dangwei_name = '{$dangwei_name}' AND is_delete = 0";
	$row = $db->get_row($sql);
	
	if(!empty($row['dangwei_name']))
	{
		$password = $row['password'];
		$dangwei_name = $row['dangwei_name'];
		$ip 	  = real_ip();
		$now_time = now_time();
		
		if($password == $pwd )
		{
			$sql = "UPDATE dangwei SET last_login_time = '{$now_time}', last_login_ip = '{$ip}' WHERE dangwei_name = '{$dangwei_name}'";
			$db->query($sql);

			// 声明一个名为 admin 的变量，并赋空值。
			setcookie("dangwei_name", $dangwei_name, time()+3600);
			setcookie("dangwei_id", $row['id'], time()+3600);

			//$smarty->display('welcome.htm');
			href_locate('index.php');
		}
		else
		{
			alert_back("密码错误!");

		}

	}
	else
	{
		alert_back("用户名或密码错误！");

	}
}

/*function check_code()
{
	$safecode = crequest('safecode');
	check_null($safecode, '验证码');
	
	if (md5($safecode) != $_SESSION['safecode'])
	{
		alert_back('验证码不正确');
		die;
	}
	
	return;
}*/


/*------------------------------------------------------ */
//-- 修改密码
/*------------------------------------------------------ */	
function mod_pwd()
{
	global $smarty;
	
	$page_title = '修改密码';
    $smarty->assign('page_title', $page_title);
	
	$smarty->assign('action', 'do_mod_pwd');
	$smarty->display('common/mod_pwd.htm');
}

/*------------------------------------------------------ */
//-- 修改密码
/*------------------------------------------------------ */	
function do_mod_pwd()
{
    global $db;
	
	$old_pwd = md5(crequest('old_pwd'));
    $new_pwd = md5(crequest('new_pwd'));
	$cfm_pwd = md5(crequest('cfm_pwd'));

	check_null($old_pwd, '旧密码');
	check_null($new_pwd, '新密码');
	check_null($cfm_pwd, '确认新密码');
	check_pwd_same($new_pwd, $cfm_pwd);

	$dangwei_name = $_COOKIE["dangwei_name"];
	$sql = "SELECT password FROM dangwei WHERE dangwei_name = '{$dangwei_name}'";
	$password = $db->get_one($sql);
	
	if ($old_pwd != $password)
	{
		alert_back('旧密码输入错误');
	}
	
	$sql = "UPDATE dangwei set password = '{$new_pwd}' WHERE dangwei_name = '{$dangwei_name}'";
	$db->query($sql);


	$url_to = "index.php?action=mod_pwd";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 退出登陆
/*------------------------------------------------------ */
function logout()
{
	setcookie("dangwei_name", "", time()-3600);
	setcookie("dangwei_id", "", time()-3600);
	
	echo "<SCRIPT LANGUAGE='JavaScript'>";
	echo "parent.location.href='index.php';";
	echo "</SCRIPT>";
}

function clear_cache()
{
	$dir = dir("../temp/compiled/");
	
	//列出 images 目录中的文件
	while (($file = $dir->read()) !== false)
	{
		if ($file != '.' && $file != '..')
			@unlink("../temp/compiled/" . $file);
		//echo "filename: " . $file . "<br />";
	}
	
	$dir->close();
	
	echo '清除成功';
}
?>
