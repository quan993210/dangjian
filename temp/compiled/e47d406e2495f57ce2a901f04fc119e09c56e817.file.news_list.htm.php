<?php /* Smarty version Smarty-3.0.6, created on 2018-05-04 11:51:13
         compiled from "/home/wwwroot/default/dangjian/temp/admin/news/news_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:9339309035aebd8b13d67a9-35070266%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e47d406e2495f57ce2a901f04fc119e09c56e817' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/news/news_list.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9339309035aebd8b13d67a9-35070266',
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
		if(confirm("您是否确认删除该新闻！"))
		{
			location.href = url;
		}
		
		
		return;
	}
</script>

</head>
<h1>
<span class="action-span"><a href="news.php?action=add_news">添加新闻</a></span>
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
    <select name="catid" id="catid">
       	<option value="0">选择新闻分类</option>
       	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('news_category')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
       	<option value="<?php echo $_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catid'];?>
" <?php if ($_smarty_tpl->getVariable('catid')->value==$_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catid']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catname'];?>
</option>
        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['name'] = 'subloop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['total']);
?>
        <option value="<?php echo $_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['catid'];?>
" <?php if ($_smarty_tpl->getVariable('catid')->value==$_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['catid']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['catname'];?>
</option>
        <?php endfor; endif; ?>
    	<?php endfor; endif; ?>
    </select> 
    
    关键字 <input type="text" name="keyword" id="keyword" value="<?php echo $_smarty_tpl->getVariable('keyword')->value;?>
"/>
	  <select name="lables" id="lables">
		  <option value="0">选择文章标签</option>
		  <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('lables')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		  <option value="<?php echo $_smarty_tpl->getVariable('lables')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" <?php if ($_smarty_tpl->getVariable('lable')->value==$_smarty_tpl->getVariable('lables')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('lables')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</option>
		  <?php endfor; endif; ?>
	  </select>
	  <input type="submit" value="搜索" class="button" />
  </form>
</div>
<form method="post" action="news.php?action=del_sel_news" name="listForm" onsubmit="return check()">
<div class="list-div" id="listDiv">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr align="center">
	  <th width="5%"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" name="checkbox[]">编号</th>
      <th width="35%">标题</td>
      <th width="10%">新闻分类</td>
      <th width="5%">浏览次数</td>
		<th width="10%">发布时间</td>
      <th width="15%">添加时间</td>
		<th width="5%">排序</td>
      <th width="15%">操作</td>
    </tr>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('news_list')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		  <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" /><?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
</span></td>
          <td class="first-cell"><span><?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['title'];?>
</span></td>
          <td><?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catname'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['viewcout'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['release_time'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['add_time_format'];?>
</td>
			<td><?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['listorder'];?>
</td>
		  <td>
          	<a href="news.php?action=mod_news&id=<?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&now_page=<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
">修改</a> |
            <a href="javascript:void(0);" onclick="check_del('news.php?action=del_news&id=<?php echo $_smarty_tpl->getVariable('news_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
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