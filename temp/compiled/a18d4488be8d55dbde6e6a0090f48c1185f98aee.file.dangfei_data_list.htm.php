<?php /* Smarty version Smarty-3.0.6, created on 2018-04-23 09:51:15
         compiled from "/home/wwwroot/default/dangjian/temp/admin/dangfei/dangfei_data_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:4025500405add3c1317b5a8-35057418%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a18d4488be8d55dbde6e6a0090f48c1185f98aee' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/dangfei/dangfei_data_list.htm',
      1 => 1506431486,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4025500405add3c1317b5a8-35057418',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->getVariable('page_title')->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/css/general.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/css/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/jquery.js"></script>
<script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/utils.js"></script>
<script src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/js/listtable.js"></script>
<script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/DatePicker/WdatePicker.js" type="text/javascript"></script>

<script>
	function check()
	{
		if(confirm("您确认删除这些吗？"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function check_del(url)
	{
		if(confirm("您是否确认删除该用户！"))
		{
			location.href = url;
		}


		return;
	}
	function select_time()
	{
		WdatePicker({dateFmt:'yyyy'})
	}
</script>

</head>
<h1>
	<span class="action-span1"><a href=""><?php echo $_smarty_tpl->getVariable('sys_name')->value;?>
 管理中心</a>  - <?php echo $_smarty_tpl->getVariable('page_title')->value;?>
 </span>
<div style="clear:both"></div>
</h1>
<body>
<div class="form-div">
  <form action="dangfei.php" name="searchForm" method="get">
    <img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
	  <input type="hidden" value="dangfei_data" name="action" />
	  <select name="status" >
		  <option value="0" <?php if ($_smarty_tpl->getVariable('status')->value==0){?>selected<?php }?>>是否缴费</option>
		  <option value="1" <?php if ($_smarty_tpl->getVariable('status')->value==1){?>selected<?php }?>>未缴费</option>
		  <option value="2" <?php if ($_smarty_tpl->getVariable('status')->value==2){?>selected<?php }?>>已缴费</option>
	  </select>
    <input type="submit" value="搜索" class="button" />
  </form>
</div>
<form method="post" action="dangfei.php?action=del_sel_dangfei_data" name="listForm" onsubmit="return check()">
<div class="list-div" id="listDiv">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr align="center">
	  <th width="5%"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" name="checkbox[]">编号</th>
		<th width="10%">用户名</td>
		<th width="10%">需缴纳党费</td>
		<th width="15%">添加时间</td>
      <th width="15%">是否缴纳</td>
		<th width="15%">手机号</td>
      <th width="15%">操作</td>
    </tr>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('dangfei_data_list')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>
		<tr align="center">
		  <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" /><?php echo $_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
</span></td>
			<td><?php echo $_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['cost'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['add_time_format'];?>
</td>
          <td><?php if ($_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['status']==1){?><span style="color: red">未缴纳</span><?php }else{ ?>已缴纳<?php }?></td>
			<td><?php echo $_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['mobile'];?>
</td>
          <td>
			  <?php if ($_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['status']==1){?>
			  <a href="dangfei.php?action=mod_dangfei_data&id=<?php echo $_smarty_tpl->getVariable('dangfei_data_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&now_page=<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
">修改党费</a>
			  <?php }?>
		  </td>
		</tr>
	<?php endfor; endif; ?>
    <tr>
      <td>
     <!-- 	<input type="submit" value="批量删除" id="btnSubmit" name="btnSubmit" class="button" disabled="true" />-->
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
" name="now_page"/>
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
" id="admin_temp_path"/>
      </td>
      <td colspan="10" align="right">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('pageshow')->value;?>
</td>
    </tr>
</table>
</div>
</form>
</body>
</html>
<script language="JavaScript" src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/js/select.js"></script>