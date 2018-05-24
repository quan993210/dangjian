<?php /* Smarty version Smarty-3.0.6, created on 2018-05-02 11:23:14
         compiled from "/home/wwwroot/default/dangjian/temp/admin/member/member_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:12484656265ae92f221b9ed5-04985596%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'efaa9ee49aa66320fd08c4b461fdb251c241f374' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/member/member_list.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12484656265ae92f221b9ed5-04985596',
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
</script>

</head>
<h1>
	<span class="action-span"><a href="member.php?action=add_member">添加会员</a></span>
	<span class="action-span1"><a href=""><?php echo $_smarty_tpl->getVariable('sys_name')->value;?>
 管理中心</a>  - <?php echo $_smarty_tpl->getVariable('page_title')->value;?>
 </span>
<div style="clear:both"></div>
</h1>
<body>
<div class="form-div">
  <form action="member.php" name="searchForm" onsubmit="">
    <img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    关键字 <input type="text" name="keyword" id="keyword" value="<?php echo $_smarty_tpl->getVariable('keyword')->value;?>
"/>
	  <select name="identity">
		  <?php  $_smarty_tpl->tpl_vars['identity'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['identity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['identity']->key => $_smarty_tpl->tpl_vars['identity']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['identity']->key;
?>
		  <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('identitys')->value==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['identity']->value;?>
</option>
		  <?php }} ?>
	  </select>
	  <select name="position">
		  <?php  $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['position']->key => $_smarty_tpl->tpl_vars['position']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['position']->key;
?>
		  <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('positions')->value==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['position']->value;?>
</option>
		  <?php }} ?>
	  </select>
	  <select name="grade">
		  <?php  $_smarty_tpl->tpl_vars['grade'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['grade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['grade']->key => $_smarty_tpl->tpl_vars['grade']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['grade']->key;
?>
		  <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('grades')->value==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['grade']->value;?>
</option>
		  <?php }} ?>
	  </select>
	  <select name="rank_title">
		  <?php  $_smarty_tpl->tpl_vars['rank_title'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info')->value['rank_title']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['rank_title']->key => $_smarty_tpl->tpl_vars['rank_title']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['rank_title']->key;
?>
		  <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->getVariable('rank_titles')->value==$_smarty_tpl->tpl_vars['key']->value){?>selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['rank_title']->value;?>
</option>
		  <?php }} ?>
	  </select>
	  <select name="is_party_affairs">
		  <option value="0" selected >请选择为专职党务干事</option>
		  <option value="1" <?php if ($_smarty_tpl->getVariable('is_party_affairs')->value==1){?>selected <?php }?> >是为专职党务干事</option>
		  <option value="2" <?php if ($_smarty_tpl->getVariable('is_party_affairs')->value==2){?>selected <?php }?> >不是为专职党务干事</option>
	  </select>

	  <select name="is_discipline">
		  <option value="0" selected >请选择违纪</option>
		  <option value="1" <?php if ($_smarty_tpl->getVariable('is_discipline')->value==1){?>selected <?php }?> >是违纪</option>
		  <option value="2" <?php if ($_smarty_tpl->getVariable('is_discipline')->value==2){?>selected <?php }?> >不是违纪</option>
	  </select>

	  <select name="is_retire">
		  <option value="0" selected >请选择退休</option>
		  <option value="1" <?php if ($_smarty_tpl->getVariable('is_retire')->value==1){?>selected <?php }?> >是退休</option>
		  <option value="2" <?php if ($_smarty_tpl->getVariable('is_retire')->value==2){?>selected <?php }?> >不是退休备</option>
	  </select>

	  <select name="is_prepare">
		  <option value="0" selected >请选择发展预备</option>
		  <option value="1" <?php if ($_smarty_tpl->getVariable('is_prepare')->value==1){?>selected <?php }?> >是发展预备</option>
		  <option value="2" <?php if ($_smarty_tpl->getVariable('is_prepare')->value==2){?>selected <?php }?> >不是发展预备</option>
	  </select>
    <input type="submit" value="搜索" class="button" />
  </form>
</div>
<form method="post" action="member.php?action=del_sel_member" name="listForm" onsubmit="return check()">
<div class="list-div" id="listDiv">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr align="center">
	  <th width="10%"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" name="checkbox[]">编号</th>
		<th width="10%">头像</td>
		<th width="15%">姓名</td>
      <th width="15%">性别</td>
      <th width="15%">电话</td>
      <th width="15%">添加时间</td>
      <th width="15%">操作</td>
    </tr>
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('member_list')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		  <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['userid'];?>
" /><?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['userid'];?>
</span></td>
			<td><img src="<?php if ($_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['avatar']!=''){?><?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['avatar'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/upload/member/default.png<?php }?>" style="width: 50px;height: 50px;border-radius:50%; overflow:hidden;" /></td>
			<td><?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</td>
			<td><?php if ($_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['gender']==1){?>男<?php }elseif($_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['gender']==2){?>女<?php }else{ ?>不详<?php }?></td>
          <td><?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['mobile'];?>
</td>
          <td><?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['add_time_format'];?>
</td>
          <td>
            <a href="member.php?action=mod_member&userid=<?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['userid'];?>
&now_page=<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
">修改</a> |
            <a href="javascript:void(0);" onclick="check_del('member.php?action=del_member&userid=<?php echo $_smarty_tpl->getVariable('member_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['userid'];?>
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