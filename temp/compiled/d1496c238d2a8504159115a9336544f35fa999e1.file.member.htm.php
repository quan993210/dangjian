<?php /* Smarty version Smarty-3.0.6, created on 2018-05-02 11:23:33
         compiled from "/home/wwwroot/default/dangjian/temp/admin/member/member.htm" */ ?>
<?php /*%%SmartyHeaderCode:3386116265ae92f35c498d0-60961380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1496c238d2a8504159115a9336544f35fa999e1' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/member/member.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3386116265ae92f35c498d0-60961380',
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
/js/editor/kindeditor.js" charset="utf-8"></script>
<script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/editor/lang/zh_CN.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/plupload/plupload.full.min.js"></script>

<style>
.pic-list div{float:left;margin-right:10px;text-align:center;}
.pic-list img{width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;}
</style>

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
<form name="form" action="" method="post" enctype="multipart/form-data">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td class="label">用户名：</td>
	  <td colspan="2"><input type="text" name="member[name]" value="<?php echo $_smarty_tpl->getVariable('member')->value['name'];?>
" size="32" /></td>
    </tr>
	<tr>
		<td class="label">手机号：</td>
		<td colspan="2"><input type="text" name="member[mobile]" value="<?php echo $_smarty_tpl->getVariable('member')->value['mobile'];?>
" size="32" /></td>
	</tr>
    <tr>
        <td class="label">身份：</td>
        <td colspan="2">
            <select name="member[identity]">
                <?php  $_smarty_tpl->tpl_vars['identity'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['identity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['identity']->key => $_smarty_tpl->tpl_vars['identity']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['identity']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('member')->value['identity']==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['identity']->value;?>
</option>
                <?php }} ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">职位：</td>
        <td colspan="2">
            <select name="member[position]">
                <?php  $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['position']->key => $_smarty_tpl->tpl_vars['position']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['position']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('member')->value['position']==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['position']->value;?>
</option>
                <?php }} ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">职称：</td>
        <td>
            <select name="member[grade]">
                <?php  $_smarty_tpl->tpl_vars['grade'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['grade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['grade']->key => $_smarty_tpl->tpl_vars['grade']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['grade']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('member')->value['grade']==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['grade']->value;?>
</option>
                <?php }} ?>
            </select>
            <select name="member[rank_title]">
                <?php  $_smarty_tpl->tpl_vars['rank_title'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['rank_title']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['rank_title']->key => $_smarty_tpl->tpl_vars['rank_title']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['rank_title']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('member')->value['rank_title']==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['rank_title']->value;?>
</option>
                <?php }} ?>
            </select>
        </td>
    </tr>

    <tr>
        <td class="label">是否为专职党务干事：</td>
        <td>
            <input name="member[is_party_affairs]" type="radio" value="2" <?php if ($_smarty_tpl->getVariable('member')->value['is_party_affairs']=='2'){?>checked <?php }?> />否
            <input name="member[is_party_affairs]" type="radio" value="1" <?php if ($_smarty_tpl->getVariable('member')->value['is_party_affairs']=='1'){?>checked <?php }?> />是
        </td>
    </tr>
    <tr>
        <td class="label">是否违纪：</td>
        <td>
            <input name="member[is_discipline]" type="radio" value="2" <?php if ($_smarty_tpl->getVariable('member')->value['is_discipline']=='2'){?>checked <?php }?> />否
            <input name="member[is_discipline]" type="radio" value="1" <?php if ($_smarty_tpl->getVariable('member')->value['is_discipline']=='1'){?>checked <?php }?> />是
        </td>
    </tr>
    <tr>
        <td class="label">是否是发展预备：</td>
        <td>
            <input name="member[is_prepare]" type="radio" value="2" <?php if ($_smarty_tpl->getVariable('member')->value['is_prepare']=='2'){?>checked <?php }?> />否
            <input name="member[is_prepare]" type="radio" value="1" <?php if ($_smarty_tpl->getVariable('member')->value['is_prepare']=='1'){?>checked <?php }?> />是
        </td>
    </tr>
    <tr>
        <td class="label">是否退休：</td>
        <td>
            <input name="member[is_retire]" type="radio" value="2" <?php if ($_smarty_tpl->getVariable('member')->value['is_retire']=='2'){?>checked <?php }?> />否
            <input name="member[is_retire]" type="radio" value="1" <?php if ($_smarty_tpl->getVariable('member')->value['is_retire']=='1'){?>checked <?php }?> />是
        </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
      <input type="hidden" name="action" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" />
      <input type="hidden" name="userid" value="<?php echo $_smarty_tpl->getVariable('member')->value['userid'];?>
" id="userid" />
      <input type="hidden" name="now_page" value="<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
" />
      <input type="submit" value="确定">      
      </td>
    </tr>
</table>
</form>
</div>
</body>
</html>
