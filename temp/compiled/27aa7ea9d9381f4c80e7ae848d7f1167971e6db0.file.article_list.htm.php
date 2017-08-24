<?php /* Smarty version Smarty-3.0.6, created on 2017-08-24 15:21:28
         compiled from "E:/phpStudy/WWW/dangjian/temp/admin\article/article_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:5446599e7e78f1feb2-02703543%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27aa7ea9d9381f4c80e7ae848d7f1167971e6db0' => 
    array (
      0 => 'E:/phpStudy/WWW/dangjian/temp/admin\\article/article_list.htm',
      1 => 1501893769,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5446599e7e78f1feb2-02703543',
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
		if(confirm("您是否确认删除该文章！"))
		{
			location.href = url;
		}
		
		
		return;
	}
</script>

</head>
<h1>
<span class="action-span"><a href="article.php?action=add_article&type=<?php echo $_smarty_tpl->getVariable('type')->value;?>
">添加文章</a></span>
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
    <select name="cid" id="cid">
       	<option value="0">选择文章分类</option>
       	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('article_category')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
       	<option value="<?php echo $_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" <?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</option>
        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['name'] = 'subloop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['subloop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <option value="<?php echo $_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['id'];?>
" <?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['id']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['name'];?>
</option>
        <?php endfor; endif; ?>
    	<?php endfor; endif; ?>
    </select> 
    
    关键字 <input type="text" name="keyword" id="keyword" value="<?php echo $_smarty_tpl->getVariable('keyword')->value;?>
"/>
    <input type="submit" value="搜索" class="button" />
  </form>
</div>
<form method="post" action="article.php?action=del_sel_article" name="listForm" onsubmit="return check()">
<div class="list-div" id="listDiv">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr align="center">
	  <th width="5%"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" name="checkbox[]">编号</th>	
      <th width="32%">标题</td>
      <th width="10%">文章分类</td>
      <th width="8%">发布人</td>
      <th width="8%">来源</td>
      <th width="5%">浏览次数</td>
      <th width="5%">排序</td>
      <th width="5%">是否推荐</td>
      <th width="12%">添加时间</td>            
      <th width="8%">操作</td>
    </tr>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('article_list')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		  <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" /><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
</span></td>
          <td class="first-cell"><span onclick="listTable.edit(this, '<?php echo $_smarty_tpl->getVariable('tbl')->value['tbl'];?>
','<?php echo $_smarty_tpl->getVariable('tbl')->value['col1'];?>
', <?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
)" ><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['title'];?>
</span></td>
          <td><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['cat'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['author'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['source'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['order_num'];?>
</td> 
          <td><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['view_num'];?>
</td>                    
          <td><img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/<?php if ($_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['is_top']==1){?>yes<?php }else{ ?>no<?php }?>.gif" /></td>
          <td><?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['add_time'];?>
</td>
		  <td>
          	<a href="article.php?action=mod_article&id=<?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&now_page=<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
&type=<?php echo $_smarty_tpl->getVariable('type')->value;?>
">修改</a> | 
            <a href="javascript:void(0);" onclick="check_del('article.php?action=del_article&id=<?php echo $_smarty_tpl->getVariable('article_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&nowpage=<?php echo $_smarty_tpl->getVariable('nowpage')->value;?>
&type=<?php echo $_smarty_tpl->getVariable('type')->value;?>
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