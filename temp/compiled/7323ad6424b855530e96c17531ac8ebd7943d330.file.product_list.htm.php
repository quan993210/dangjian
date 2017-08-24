<?php /* Smarty version Smarty-3.0.6, created on 2017-08-24 15:21:57
         compiled from "E:/phpStudy/WWW/dangjian/temp/admin\product/product_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:27700599e7e95c2c9b3-56174027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7323ad6424b855530e96c17531ac8ebd7943d330' => 
    array (
      0 => 'E:/phpStudy/WWW/dangjian/temp/admin\\product/product_list.htm',
      1 => 1501893769,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27700599e7e95c2c9b3-56174027',
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
		if(confirm("您是否确认删除改案例！"))
		{
			location.href = url;
		}
		
		
		return;
	}
</script>

</head>
<h1>
<span class="action-span"><a href="product.php?action=add_product">添加案例</a></span>
<span class="action-span1"><a href=""><?php echo $_smarty_tpl->getVariable('sys_name')->value;?>
 管理中心</a>  - <?php echo $_smarty_tpl->getVariable('page_title')->value;?>
 </span>
<div style="clear:both"></div>
</h1>
<body>
<div class="form-div">
  <form action="product.php" name="searchForm" onsubmit="">
    <img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <select name="cid" id="cid">
       	<option value="0">选择案例分类</option>
       	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('product_category')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
       	<option value="<?php echo $_smarty_tpl->getVariable('product_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" <?php if ($_smarty_tpl->getVariable('cid')->value==$_smarty_tpl->getVariable('product_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('product_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</option>
    	<?php endfor; endif; ?>
    </select>  
    关键字 <input type="text" name="keyword" id="keyword" value="<?php echo $_smarty_tpl->getVariable('keyword')->value;?>
"/>
    <input type="submit" value="搜索" class="button" />
  </form>
</div>
<form method="post" action="product.php?action=del_sel_product" name="listForm" onsubmit="return check()">
<div class="list-div" id="listDiv">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr align="center">
	  <th width="5%"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" name="checkbox[]">编号</th>	
      <th width="15%">案例名称</td>
      <th width="20%">案例行业</td>
      <th width="15%">案例版本</td>
      <th width="5%">首页推荐</td>
      <th width="5%">是否启用</td>
      <th width="5%">排序</td>
      <th width="15%">添加时间</td>
      <th width="15%">操作</td>
    </tr>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('product_list')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		  <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" /><?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
</span></td>
          <td class="first-cell"><span onclick="listTable.edit(this, '<?php echo $_smarty_tpl->getVariable('tbl')->value['tbl'];?>
','<?php echo $_smarty_tpl->getVariable('tbl')->value['col1'];?>
', <?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
)" ><?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</span></td>
          <td><?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['trade'];?>
</td>
          <td><?php if ($_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['is_apple']==1){?>apple<?php }?> <?php if ($_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['is_android']==1){?>android<?php }?> </td>
          <td><img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/<?php if ($_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['is_index']==1){?>yes<?php }else{ ?>no<?php }?>.gif" onclick="listTable.toggle(this, '<?php echo $_smarty_tpl->getVariable('tbl')->value['tbl'];?>
','<?php echo $_smarty_tpl->getVariable('tbl')->value['col5'];?>
', <?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
)" style="cursor:pointer;" /></td>
          <td><img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/<?php if ($_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['is_pub']==1){?>yes<?php }else{ ?>no<?php }?>.gif" onclick="listTable.toggle(this, '<?php echo $_smarty_tpl->getVariable('tbl')->value['tbl'];?>
','<?php echo $_smarty_tpl->getVariable('tbl')->value['col6'];?>
', <?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
)" style="cursor:pointer;" /></td>
          <td><?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['order_num'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['add_time'];?>
</td>
		  <td>
          	<a href="product.php?action=mod_product&id=<?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&now_page=<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
">修改</a> | 
          	<a href="javascript:void(0);" onclick="check_del('product.php?action=del_product&id=<?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
&now_page=<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
');">删除</a> | 
            <a href="/case/down.php?id=<?php echo $_smarty_tpl->getVariable('product_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" target="_blank">下载地址</a>
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