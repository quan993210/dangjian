<?php /* Smarty version Smarty-3.0.6, created on 2018-05-02 09:57:13
         compiled from "/home/wwwroot/default/dangjian/temp/admin/metting/metting_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:10036617125ae91af9d56952-45195669%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6f145fb48aa64dc37e45b2f9748a0fc3f7d4b53' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/metting/metting_list.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10036617125ae91af9d56952-45195669',
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

<script>
	function search_check()
	{
		if($("search_cat").value != 0)
		{			
			if($("keyword").value == "")
			{
				alert("请填写搜索关键字");
				$("keyword").focus();
				return false;
			}
		}
		else
		{
			alert('请选择搜索类型');
			return false;
		}
		return true;
	}
	
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
		if(confirm("您是否确认删除该会议！"))
		{
			location.href = url;
		}
		
		
		return;
	}
</script>

</head>
<h1>
<span class="action-span"><a href="metting.php?action=add_metting">添加会议</a></span>
<span class="action-span1"><a href=""><?php echo $_smarty_tpl->getVariable('sys_name')->value;?>
 管理中心</a>  - <?php echo $_smarty_tpl->getVariable('page_title')->value;?>
 </span>
<div style="clear:both"></div>
</h1>
<body>
<div class="form-div">
  <form action="" name="searchForm" onsubmit="">
    <img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    关键字 <input type="text" name="keyword" id="keyword" value="<?php echo $_smarty_tpl->getVariable('keyword')->value;?>
"/>
    <input type="submit" value="搜索" class="button" />
  </form>
</div>
<form method="post" action="metting.php?action=del_sel_metting" name="listForm" onsubmit="return check()">
<div class="list-div" id="listDiv">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr align="center">
	  <th width="5%"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" name="checkbox[]">编号</th>
		<th width="15%">二维码</td>
      <th width="20%">标题</td>
      <th width="20%">开始时间</td>
      <th width="10%">参加人数</td>
      <th width="15%">操作</td>
    </tr>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('metting_list')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		  <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" /><?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
</span></td>
			<td><a href="metting.php?action=get_qrcode&id=<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
"><img src="/upload/metting/metting-<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
.jpg" style="width: 50px;height: 50px" /></a></td>
			<td class="first-cell"><a href="metting.php?action=sign&id=<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
"><span><?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['title'];?>
</span></a></td>
          <td><?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['start_time'];?>
</td>
			<td><a href="metting.php?action=sign&id=<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
"><?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sign_sum'];?>
/<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sum'];?>
</a></td>
		  <td>
          	<a href="metting.php?action=mod_metting&id=<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&now_page=<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
">修改</a> |
            <a href="javascript:void(0);" onclick="check_del('metting.php?action=del_metting&id=<?php echo $_smarty_tpl->getVariable('metting_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&nowpage=<?php echo $_smarty_tpl->getVariable('nowpage')->value;?>
');">删除</a>
          </td>
		</tr>  
	<?php endfor; endif; ?>
    <tr>
      <td>
      	<input type="submit" value="批量删除" id="btnSubmit" name="btnSubmit" class="button" disabled="true" />
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