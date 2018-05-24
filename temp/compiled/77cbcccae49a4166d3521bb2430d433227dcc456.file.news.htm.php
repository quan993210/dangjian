<?php /* Smarty version Smarty-3.0.6, created on 2018-05-04 11:49:01
         compiled from "/home/wwwroot/default/dangjian/temp/admin/news/news.htm" */ ?>
<?php /*%%SmartyHeaderCode:5993238465aebd82da85615-29140419%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77cbcccae49a4166d3521bb2430d433227dcc456' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/news/news.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5993238465aebd82da85615-29140419',
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
/js/DatePicker/WdatePicker.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>

	<script type="text/javascript" charset="utf-8" src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/ueditor/ueditor.all.min.js"> </script>
	<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
	<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
	<script type="text/javascript" charset="utf-8" src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/ueditor/lang/zh-cn/zh-cn.js"></script>

<script language="javascript">

function select_time()
{
	WdatePicker({dateFmt:'yyyy-MM-dd'})
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
<form name="frm" action="news.php" method="post" enctype="multipart/form-data">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td class="label">新闻分类：</td>
	  <td colspan="6">
        <select name="info[catid]" id="catid">
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
" <?php if ($_smarty_tpl->getVariable('news')->value['catid']==$_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catid']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catname'];?>
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
" <?php if ($_smarty_tpl->getVariable('news')->value['catid']==$_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['catid']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['catname'];?>
</option>
            <?php endfor; endif; ?>
            <?php endfor; endif; ?>
        </select>       
      </td>
    </tr>
    <tr>
      <td class="label">新闻标题：</td>
	  <td colspan="6"><input type="text" name="info[title]" value="<?php echo $_smarty_tpl->getVariable('news')->value['title'];?>
" size="48" /></td>
    </tr>
	<tr>
		<td class="label">新闻：</td>
		<td colspan="6">
			<textarea id="content" name="info[content]" style="width:700px;height:300px;"><?php echo $_smarty_tpl->getVariable('news')->value['content'];?>
</textarea>
			<script type="text/javascript">
				//实例化编辑器
				var ue = UE.getEditor('content');
			</script>
		</td>
	</tr>
	<tr>
		<td class="label">展示样式：</td>
		<td colspan="6">
			<select name="info[type]" id="type">
				<option value="0" <?php if ($_smarty_tpl->getVariable('news')->value['type']==0){?>selected<?php }?>>无图展示</option>
				<option value="1" <?php if ($_smarty_tpl->getVariable('news')->value['type']==1){?>selected<?php }?>>一张大图(710*350)</option>
				<option value="2" <?php if ($_smarty_tpl->getVariable('news')->value['type']==2){?>selected<?php }?>>一张小图(200*150)</option>
				<option value="3" <?php if ($_smarty_tpl->getVariable('news')->value['type']==3){?>selected<?php }?>>三张图片(226*117)</option>
			</select>
		</td>
	</tr>
    <tr id="img" <?php if ($_smarty_tpl->getVariable('news')->value['type']==''){?> style="display: none"<?php }?>>
      <td class="label">封面图片：</td>
		<td id="img1" <?php if ($_smarty_tpl->getVariable('news')->value['image1']==''){?> style="display: none"<?php }?>>
			<img src="<?php if ($_smarty_tpl->getVariable('news')->value['image1']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('news')->value['image1'];?>
<?php }else{ ?>/images/default_news.jpg<?php }?>" id="upload_image1" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
			<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('news')->value['image1'];?>
" name="info[image1]" id="image1" />
			<input type="button" id="pic_image1" style="background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />
		</td>
		<td id="img2" <?php if ($_smarty_tpl->getVariable('news')->value['image2']==''){?> style="display: none"<?php }?>>
			<img src="<?php if ($_smarty_tpl->getVariable('news')->value['image2']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('news')->value['image2'];?>
<?php }else{ ?>/images/default_news.jpg<?php }?>" id="upload_image2" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
			<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('news')->value['image2'];?>
" name="info[image2]" id="image2" />
			<input type="button" id="pic_image2" style="background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />

		</td>
		<td id="img3" <?php if ($_smarty_tpl->getVariable('news')->value['image3']==''){?> style="display: none"<?php }?>>
			<img src="<?php if ($_smarty_tpl->getVariable('news')->value['image3']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('news')->value['image3'];?>
<?php }else{ ?>/images/default_news.jpg<?php }?>" id="upload_image3" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
			<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('news')->value['image3'];?>
" name="info[image3]" id="image3" />
			<input type="button" id="pic_image3" style="background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />
		</td>
    </tr>

    <tr>
      <td class="label">发布者：</td>
	  <td colspan="6"><input type="text" id="brief" name="info[brief]" value="<?php echo $_smarty_tpl->getVariable('news')->value['brief'];?>
" /></td>
    </tr>
	<tr>
		<td class="label">发布时间：</td>
		<td colspan="6"><input type="text" name="info[release_time]" onclick="return select_time()"  value="<?php echo $_smarty_tpl->getVariable('news')->value['release_time'];?>
" /></td>
	</tr>

	<tr>
		<td class="label">视频链接：</td>
		<td colspan="6"><input type="text" name="info[video_url]" value="<?php if ($_smarty_tpl->getVariable('news')->value['video_url']){?><?php echo $_smarty_tpl->getVariable('news')->value['video_url'];?>
<?php }?>" size="45" /></td>
	</tr>
	<tr>
		<td class="label">语音链接：</td>
		<td colspan="6"><input type="text" name="info[audio_url]" value="<?php if ($_smarty_tpl->getVariable('news')->value['audio_url']){?><?php echo $_smarty_tpl->getVariable('news')->value['audio_url'];?>
<?php }?>" size="45" /></td>
	</tr>
	<tr>
		<td class="label">文字转语音：</td>
		<td colspan="6"><input type="checkbox" <?php if ($_smarty_tpl->getVariable('news')->value['is_transfor']==1){?> checked<?php }?> name="info[is_transfor]" value="1"/>(勾选后，手机可播放语音)</td>
	</tr>
	<tr>
      <td class="label">排序：</td>
	  <td colspan="6"><input type="text" name="info[listorder]" value="<?php if ($_smarty_tpl->getVariable('news')->value['listorder']==''){?>0<?php }else{ ?><?php echo $_smarty_tpl->getVariable('news')->value['listorder'];?>
<?php }?>" size="15" /></td>
    </tr>
	<tr>
		<td class="label">添加投票：</td>
		<td colspan="6">
			<select name="info[voteid]" id="voteid">
				<option value="99" <?php if ($_smarty_tpl->getVariable('news')->value['voteid']==99||$_smarty_tpl->getVariable('news')->value['voteid']==0){?>selected<?php }?>>选择投票</option>
				<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('vote')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<option value="<?php echo $_smarty_tpl->getVariable('vote')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" <?php if ($_smarty_tpl->getVariable('news')->value['voteid']==$_smarty_tpl->getVariable('vote')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('vote')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['title'];?>
</option>
				<?php endfor; endif; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="label">文章标签：</td>
		<td colspan="6">
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
			<input type="checkbox" name="lables[]"  <?php if ($_smarty_tpl->getVariable('lables')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['flg']==1){?>checked<?php }?>  value="<?php echo $_smarty_tpl->getVariable('lables')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
"/><?php echo $_smarty_tpl->getVariable('lables')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>

			<?php endfor; endif; ?>
		</td>
	</tr>
    <tr>
      <td colspan="2" align="center">
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" name="action" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
" name="now_page" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('news')->value['id'];?>
" name="id" />
      	<input type="submit" value="确定">
      </td>
    </tr>
</table>
</form>


<script type="text/javascript">
// Custom example logic
$(document).ready(function(){
	$('#catid').change(function(){
		var catid = $('#catid option:selected').val();
		$.getJSON("news.php?action=checkChild",{ catid: catid}, function(data){
			if(data == 1){
				alert("请选择子分类！");
				$("#catid").val("0");
				return;
			}
		});
	})

	$('#type').change(function(){
		var type = $('#type option:selected').val();
		if(type == 0){
			$('#img').css('display','none');
			$('#img1').css('display','none');
			$('#img2').css('display','none');
			$('#img3').css('display','none');
		}else if(type == 1){
			$('#img').css('display','');
			$('#img1').css('display','');
			$('#img2').css('display','none');
			$('#img3').css('display','none');
		}else if(type == 2){
			$('#img').css('display','');
			$('#img1').css('display','');
			$('#img2').css('display','none');
			$('#img3').css('display','none');
		}else if(type == 3){
			$('#img').css('display','');
			$('#img1').css('display','');
			$('#img2').css('display','');
			$('#img3').css('display','');
		}

	})
})

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pic_image1', // you can pass in id...
	url : 'news.php?action=upload_batch_photo&dir_type=image&upload_name=pic',
	flash_swf_url : '/js/plupload/Moxie.swf',
	silverlight_xap_url : '/js/plupload/Moxie.xap',
	file_data_name : 'pic',
	multi_selection : false,

	filters : {
		max_file_size : '10mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		FilesAdded: function(up, files) {

			plupload.each(files, function(file) {
				var html = '<tr id="' + file.id + '">';
				html += '<td width="200" align="left">' + file.name + '</td>';
				html += '<td width="100" align="center">' + plupload.formatSize(file.size) + '</td>';
				html += '<td width="100" align="center" id="' + file.id + '_progress"></td>';
				html += '</tr>';

			});

			uploader.start();
		},

		UploadProgress: function(up, file) {
			$("#" + file.id + "_progress").html(file.percent + "%");
		},

		FileUploaded: function(up, file, data) {
			var dataObj = eval("(" + data.response + ")");
			$("#image1").val(dataObj.pic_path);
			$("#upload_image1").attr("src", dataObj.pic_path);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});
var uploader1 = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pic_image2', // you can pass in id...
	url : 'news.php?action=upload_batch_photo&dir_type=image&upload_name=pic',
	flash_swf_url : '/js/plupload/Moxie.swf',
	silverlight_xap_url : '/js/plupload/Moxie.xap',
	file_data_name : 'pic',
	multi_selection : false,

	filters : {
		max_file_size : '10mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		FilesAdded: function(up, files) {

			plupload.each(files, function(file) {
			});

			uploader1.start();
		},

		UploadProgress: function(up, file) {
		},

		FileUploaded: function(up, file, data) {
			var dataObj = eval("(" + data.response + ")");
			$("#image2").val(dataObj.pic_path);
			$("#upload_image2").attr("src", dataObj.pic_path);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});
var uploader2 = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pic_image3', // you can pass in id...
	url : 'news.php?action=upload_batch_photo&dir_type=image&upload_name=pic',
	flash_swf_url : '/js/plupload/Moxie.swf',
	silverlight_xap_url : '/js/plupload/Moxie.xap',
	file_data_name : 'pic',
	multi_selection : false,

	filters : {
		max_file_size : '10mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		FilesAdded: function(up, files) {

			plupload.each(files, function(file) {
			});

			uploader2.start();
		},

		UploadProgress: function(up, file) {
		},

		FileUploaded: function(up, file, data) {
			var dataObj = eval("(" + data.response + ")");
			$("#image3").val(dataObj.pic_path);
			$("#upload_image3").attr("src", dataObj.pic_path);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});




uploader.init();
uploader1.init();
uploader2.init();



function print_array(arr){
	for(var key in arr){
		if(typeof(arr[key])=='array'||typeof(arr[key])=='object'){//递归调用
			print_array(arr[key]);
		}else{
			document.write(key + ' = ' + arr[key] + '<br>');
		}
	}
}
</script>

</div>
</body>
</html>
