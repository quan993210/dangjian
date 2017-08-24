<?php /* Smarty version Smarty-3.0.6, created on 2017-08-24 15:22:51
         compiled from "E:/phpStudy/WWW/dangjian/temp/admin\ad/ads_category.htm" */ ?>
<?php /*%%SmartyHeaderCode:22691599e7ecb31d457-71710280%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'beb2f3dd57d6729bd92b30de6ac844a4fdfad3e9' => 
    array (
      0 => 'E:/phpStudy/WWW/dangjian/temp/admin\\ad/ads_category.htm',
      1 => 1501893769,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22691599e7ecb31d457-71710280',
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

<script>
function add_one()
{
	var cat_count = $("#cat_count").val();
	var next_one = parseInt(cat_count) + 1;
	var html = '<div id="cat_'+next_one+'"><input type="text" name="cat_name'+next_one+'" value=""> <a href="javascript:void(0);" onclick="del_one('+next_one+')">[-]</a></div>';
	$("#cat_td").append(html);
	$("#cat_count").val(next_one);
}
function del_one(id)
{
	$("#cat_"+id).remove();
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
<form name="frm" action="ads_category.php" method="post">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
	<tr>
      <td class="label">选择广告分类：</td>
	  <td>
      	<select name="parent_id">
        	<option value="">请选择广告分类</option>
            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('top_ads_category')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <option value="<?php echo $_smarty_tpl->getVariable('top_ads_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" <?php if ($_smarty_tpl->getVariable('cat')->value['parent_id']==$_smarty_tpl->getVariable('top_ads_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('top_ads_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</option>	
            <?php endfor; endif; ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="label">广告分类名称：</td>
	  <td><input type="text" name="name" value="<?php echo $_smarty_tpl->getVariable('cat')->value['name'];?>
"></td>
    </tr>
    <tr>
      <td class="label">排序：</td>
	  <td><input type="text" name="order_num" value="<?php if ($_smarty_tpl->getVariable('cat')->value['order_num']){?><?php echo $_smarty_tpl->getVariable('cat')->value['order_num'];?>
<?php }else{ ?>0<?php }?>"></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('cat')->value['id'];?>
" name="id" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" name="action" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
" name="now_page" />
      	<input type="submit" value="添加">
      </td>
    </tr>
</table>
</form>
</div>
</body>
</html>
