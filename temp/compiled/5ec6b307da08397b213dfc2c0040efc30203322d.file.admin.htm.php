<?php /* Smarty version Smarty-3.0.6, created on 2018-05-02 09:58:11
         compiled from "/home/wwwroot/default/dangjian/temp/admin/admin/admin.htm" */ ?>
<?php /*%%SmartyHeaderCode:15604688885ae91b339a1414-55387769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ec6b307da08397b213dfc2c0040efc30203322d' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/admin/admin.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15604688885ae91b339a1414-55387769',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加管理员</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/css/general.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/css/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/jquery-1.4.2.min.js"></script>

<script language="javascript">
	function sel_p(type)
	{
		if (type == 0)
		{
			$("#p1").css("display", "");
			$("#p2").css("display", "none");
		}
		else
		{
			$("#p1").css("display", "none");
			$("#p2").css("display", "");
		}
	}
</script>

</head>
<body>
<h1>
<span class="action-span"><a href="javascript:history.back();">返回</a></span>
<span class="action-span1"><a href=""><?php echo $_smarty_tpl->getVariable('sys_name')->value;?>
 管理中心</a>  - <?php echo $_smarty_tpl->getVariable('page_title')->value;?>
 </span>
<div style="clear:both"></div>
</h1>
<div id="tabbody-div">
<form name="frm" action="admin.php" method="post" autoComplete="Off">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td class="label">用户名：</td>
	  <td><input type="text" name="info[userid]" readonly="readonly" value="<?php echo $_smarty_tpl->getVariable('admin')->value['userid'];?>
"></td>
    </tr>
    <tr>
      <td class="label">密码：</td>
	  <td><input type="password" name="info[password]" value=""> (留空表示不修改)</td>
    </tr>
    <tr>
      <td class="label">邮箱：</td>
	  <td><input type="text" name="info[email]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['email'];?>
"></td>
    </tr>
	<tr>
		<td class="label">appid：</td>
		<td><input type="text" name="info[appid]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['appid'];?>
"></td>
	</tr>
	<tr>
		<td class="label">appsecret：</td>
		<td><input type="text" name="info[appsecret]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['appsecret'];?>
"></td>
	</tr>
	<tr>
		<td class="label">商户号：</td>
		<td><input type="text" name="info[mac_id]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['mac_id'];?>
"></td>
	</tr>
	<tr>
		<td class="label">支付key：</td>
		<td><input type="text" name="info[wx_key]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['wx_key'];?>
"></td>
	</tr>
	<tr>
		<td class="label">会员统计：</td>
		<td><input type="text" name="info[member_count]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['member_count'];?>
"></td>
	</tr>
	<tr>
		<td class="label">文章统计：</td>
		<td><input type="text" name="info[news_count]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['news_count'];?>
"></td>
	</tr>
	<tr>
		<td class="label">订单统计：</td>
		<td><input type="text" name="info[order_count]" value="<?php echo $_smarty_tpl->getVariable('admin')->value['order_count'];?>
"></td>
	</tr>
    <tr>
      <td colspan="2" align="center">
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" name="action" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
" name="now_page" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('admin')->value['id'];?>
" name="id" />
        <input type="submit" value="确定">
      </td>
    </tr>
</table>
</form>
</div>
</body>
</html>
