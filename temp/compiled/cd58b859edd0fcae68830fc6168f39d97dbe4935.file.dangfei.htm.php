<?php /* Smarty version Smarty-3.0.6, created on 2018-04-20 14:30:52
         compiled from "/home/wwwroot/default/dangjian/temp/admin/dangfei/dangfei.htm" */ ?>
<?php /*%%SmartyHeaderCode:6205836485ad9891c8f5b27-41580668%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cd58b859edd0fcae68830fc6168f39d97dbe4935' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/dangfei/dangfei.htm',
      1 => 1504864695,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6205836485ad9891c8f5b27-41580668',
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
    <script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/DatePicker/WdatePicker.js" type="text/javascript"></script>

<style>
.pic-list div{float:left;margin-right:10px;text-align:center;}
.pic-list img{width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;}
</style>
    <script>
        function select_time()
        {
            WdatePicker({dateFmt:'yyyy-MM'})
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
<form name="form" action="" method="post" enctype="multipart/form-data">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td class="label">标题：</td>
	  <td><input type="text" name="title" value="<?php echo $_smarty_tpl->getVariable('dangfei')->value['title'];?>
"  required="required" size="32" /></td>
    </tr>
	<tr>
		<td class="label">党费时间：</td>
		<td><input type="text" name="add_time" onclick="return select_time()"  required="required" value="<?php echo $_smarty_tpl->getVariable('dangfei')->value['add_time_format'];?>
" size="32" /></td>
	</tr>
    <tr>
        <td class="label">党费导入excel</td>
        <td><input  type="file" name="dangfei" required="required"/></td>
    </tr>
    <tr>
        <td class="label">  <a href="/upload/excel/党费模板.xlsx">下载Excel模板</a></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
      <input type="hidden" name="action" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" />
      <input type="hidden" name="userid" value="<?php echo $_smarty_tpl->getVariable('dangfei')->value['id'];?>
" id="id" />
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
