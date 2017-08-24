<?php /* Smarty version Smarty-3.0.6, created on 2017-08-24 15:22:17
         compiled from "E:/phpStudy/WWW/dangjian/temp/admin\product/product.htm" */ ?>
<?php /*%%SmartyHeaderCode:6749599e7ea9f09079-05368186%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b67eceaf9949766bb9452496160ccd15578a3c8b' => 
    array (
      0 => 'E:/phpStudy/WWW/dangjian/temp/admin\\product/product.htm',
      1 => 1501893769,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6749599e7ea9f09079-05368186',
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
<script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>

<style>
.pic-list div{float:left;margin-right:10px;text-align:center;}
.pic-list img{width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;}
.upload-img{width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;}
.upload-btn{background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;}
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
<form name="frm" action="" method="post" enctype="multipart/form-data">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td class="label">案例名称：</td>
	  <td><input type="text" name="name" value="<?php echo $_smarty_tpl->getVariable('product')->value['name'];?>
" size="32" /></td>
    </tr>
    <tr>
      <td class="label">案例描述：</td>
	  <td>
      	<textarea id="brief" name="brief" style="width:300px;height:60px;"><?php echo $_smarty_tpl->getVariable('product')->value['brief'];?>
</textarea>
      </td>
    </tr>  
    <tr>
      <td class="label">案例行业：</td>
	  <td><input type="text" name="trade" value="<?php echo $_smarty_tpl->getVariable('product')->value['trade'];?>
" size="32" /></td>
    </tr>
    <tr>
      <td class="label">案例背景色：</td>
	  <td><input type="text" name="bg_color" value="<?php echo $_smarty_tpl->getVariable('product')->value['bg_color'];?>
" size="32" /> （格式：#ffffff）</td>
    </tr>
    <tr>
      <td class="label">案例版本：</td>
	  <td>
      	<input type="checkbox" name="is_apple" value="1" <?php if ($_smarty_tpl->getVariable('product')->value['is_apple']==1){?>checked="checked"<?php }?> onclick="show_down_url(1, this)" />苹果  
        <input type="checkbox" name="is_android" value="1" <?php if ($_smarty_tpl->getVariable('product')->value['is_android']==1){?>checked="checked"<?php }?> onclick="show_down_url(2, this)" />安卓
        <div id="apple_down" style="line-height:30px;display:<?php if ($_smarty_tpl->getVariable('product')->value['is_apple']!=1){?>none<?php }?>;">苹果下载地址：<input type="text" name="apple_down_url" value="<?php echo $_smarty_tpl->getVariable('product')->value['apple_down_url'];?>
" size="64" /></div>
        <div id="android_down" style="line-height:30px;display:<?php if ($_smarty_tpl->getVariable('product')->value['is_android']!=1){?>none<?php }?>;">安卓下载地址：<input type="text" name="android_down_url" value="<?php echo $_smarty_tpl->getVariable('product')->value['android_down_url'];?>
" size="64" /></div>
      </td>
    </tr>
    <tr>
      <td class="label">列表图片：</td>
	  <td>
      	<img src="<?php if ($_smarty_tpl->getVariable('product')->value['pic']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('product')->value['pic'];?>
<?php }else{ ?>/images/default_article.jpg<?php }?>" id="pic_img" class="upload-img" /><br/>
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('product')->value['pic'];?>
" name="pic_path" id="pic_path" />
        <input type="button" id="pic_btn" class="upload-btn" value="上传图片" /> （尺寸：582*225）
      </td>
    </tr>
    <tr>
      <td class="label">案例LOGO：</td>
	  <td>
      	<img src="<?php if ($_smarty_tpl->getVariable('product')->value['pic']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('product')->value['logo'];?>
<?php }else{ ?>/images/default_article.jpg<?php }?>" id="logo_img" class="upload-img" /><br/>
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('product')->value['logo'];?>
" name="logo_path" id="logo_path" />
        <input type="button" id="logo_btn" class="upload-btn" value="上传LOGO" /> （尺寸：180*180）
      </td>
    </tr>
    <tr>
      <td class="label">案例二维码：</td>
	  <td>
      	<img src="<?php if ($_smarty_tpl->getVariable('product')->value['qrcode']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('product')->value['qrcode'];?>
<?php }else{ ?>/images/default_article.jpg<?php }?>" id="qrcode_img" class="upload-img" /><br/>
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('product')->value['qrcode'];?>
" name="qrcode_path" id="qrcode_path" />
        <input type="button" id="qrcode_btn" class="upload-btn" value="上传二维码" /> （尺寸：121*121）
      </td>
    </tr>
    <tr>
      <td class="label">案例图集：</td>
	  <td>
        
        
      	<div class="pic-list" id="pic_list">
        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('pic_list')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <?php if ($_smarty_tpl->getVariable('pic_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]){?>
        <div><img src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('pic_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']];?>
" /><br/> <a href="javascript:void(0)" onclick="del_one_img('<?php echo $_smarty_tpl->getVariable('pic_list')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']];?>
', this)">删除</a></div>
        <?php }?>
        <?php endfor; endif; ?>
        </div>
        <div style="clear:both;"></div>
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('product')->value['pics'];?>
" name="pics_path" id="pics_path" />
        <input type="button" id="pics_btn" class="upload-btn" value="上传图片" /> （尺寸：329*576）
      </td>
    </tr>
    <tr>
      <td class="label">首页推荐：</td>
	  <td>
      	<input type="radio" name="is_index" value="1" <?php if ($_smarty_tpl->getVariable('product')->value['is_index']==1){?>checked="checked"<?php }?> />是   
        <input type="radio" name="is_index" value="0" <?php if ($_smarty_tpl->getVariable('product')->value['is_index']==0||$_smarty_tpl->getVariable('product')->value['is_index']==''){?>checked="checked"<?php }?> />否
      </td>
    </tr>
    <tr>
      <td class="label">排序：</td>
	  <td><input type="text" name="order_num" value="<?php if ($_smarty_tpl->getVariable('product')->value['order_num']==''){?>0<?php }else{ ?><?php echo $_smarty_tpl->getVariable('product')->value['order_num'];?>
<?php }?>" size="15" /> （数值越大，越靠前）</td>
    </tr>
    <tr>
      <td class="label">是否启用：</td>
	  <td>
      	<?php if ($_smarty_tpl->getVariable('action')->value=='do_add_product'){?>
        <input type="radio" name="is_pub" value="1" checked="checked" />是   
        <input type="radio" name="is_pub" value="0" />否
        <?php }else{ ?>
      	<input type="radio" name="is_pub" value="1" <?php if ($_smarty_tpl->getVariable('product')->value['is_pub']==1){?>checked="checked"<?php }?> />是   
        <input type="radio" name="is_pub" value="0" <?php if ($_smarty_tpl->getVariable('product')->value['is_pub']==0){?>checked="checked"<?php }?> />否
      	<?php }?>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
      <input type="hidden" name="action" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" />
      <input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('product')->value['id'];?>
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

<script type="text/javascript">
// Custom example logic

var uploader1 = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pic_btn', // you can pass in id...
	url : 'product.php?action=upload_batch_photo&dir_type=case&upload_name=pic',
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
		PostInit: function() {
		},

		FilesAdded: function(up, files) {
	
			plupload.each(files, function(file) {
			});
			
			uploader1.start();
		},

		UploadProgress: function(up, file) {
		},
		
		FileUploaded: function(up, file, data) {
			var dataObj = eval("(" + data.response + ")");
			$("#pic_path").val(dataObj.pic_path);
			$("#pic_img").attr("src", dataObj.pic_path);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});
var uploader2 = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'logo_btn', // you can pass in id...
	url : 'product.php?action=upload_batch_photo&dir_type=case&upload_name=logo',
	flash_swf_url : '/js/plupload/Moxie.swf',
	silverlight_xap_url : '/js/plupload/Moxie.xap',
	file_data_name : 'logo',
	multi_selection : false,
	
	filters : {
		max_file_size : '10mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		PostInit: function() {
		},

		FilesAdded: function(up, files) {
	
			plupload.each(files, function(file) {
			});
			
			uploader2.start();
		},

		UploadProgress: function(up, file) {
		},
		
		FileUploaded: function(up, file, data) {
			var dataObj = eval("(" + data.response + ")");
			$("#logo_path").val(dataObj.pic_path);
			$("#logo_img").attr("src", dataObj.pic_path);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

var uploader3 = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'qrcode_btn', // you can pass in id...
	url : 'product.php?action=upload_batch_photo&dir_type=case&upload_name=qrcode',
	flash_swf_url : '/js/plupload/Moxie.swf',
	silverlight_xap_url : '/js/plupload/Moxie.xap',
	file_data_name : 'qrcode',
	multi_selection : false,
	
	filters : {
		max_file_size : '10mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		PostInit: function() {
		},

		FilesAdded: function(up, files) {
	
			plupload.each(files, function(file) {
			});
			
			uploader3.start();
		},

		UploadProgress: function(up, file) {
		},
		
		FileUploaded: function(up, file, data) {
			var dataObj = eval("(" + data.response + ")");
			$("#qrcode_path").val(dataObj.pic_path);
			$("#qrcode_img").attr("src", dataObj.pic_path);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

var uploader4 = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pics_btn', // you can pass in id...
	url : 'article.php?action=upload_batch_photo&dir_type=case&upload_name=pics',
	flash_swf_url : '/js/plupload/Moxie.swf',
	silverlight_xap_url : '/js/plupload/Moxie.xap',
	file_data_name : 'pics',
	multi_selection : true,
	
	filters : {
		max_file_size : '10mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		PostInit: function() {
		},

		FilesAdded: function(up, files) {
	
			plupload.each(files, function(file) {
			});
			
			uploader4.start();
		},

		UploadProgress: function(up, file) {
		},
		
		FileUploaded: function(up, file, data) {
			var dataObj = eval("(" + data.response + ")");
			//alert(dataObj.pic_path);
			var pics = $("#pics_path").val();
			pics += dataObj.pic_path + "|";
			$("#pics_path").val(pics);
			
			var html = '<div><img src="' + dataObj.pic_path + '" /><br/> <a href="javascript:void(0)" onclick="del_one_img(\''+dataObj.pic_path+'\', this)">删除</a></div>'
			$("#pic_list").append(html);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader1.init();
uploader2.init();
uploader3.init();
uploader4.init();

function print_array(arr){
	for(var key in arr){
		if(typeof(arr[key])=='array'||typeof(arr[key])=='object'){//递归调用  
			print_array(arr[key]);
		}else{
			document.write(key + ' = ' + arr[key] + '<br>');
		}
	}
}

function del_one_img(pic_path, obj)
{
	if (!confirm("确认删除该图片吗？"))return;
	
	var id = $("#id").val();
	$.get(
		"product.php",
		{action : "del_one_img" , id : id, pic_path : pic_path},
		function(data)
		{
			var result = parseInt(data);
			if (data == 1)
			{
				$(obj).parent().remove();
				var pics = $("#pics_path").val();
				pic_path = pic_path + "|";
				pics = pics.replace(pic_path, "");
				$("#pics_path").val(pics);
			}
			else
				alert(data);	
		}
	);
}

function show_down_url(type, obj)
{
	switch (type)
	{
		case 1:
			if ($(obj).prop("checked") == true)
				$("#apple_down").show();
			else
				$("#apple_down").hide();
			break;
		case 2:
			if ($(obj).prop("checked") == true)
				$("#android_down").show();
			else
				$("#android_down").hide();
			break;	
	}
}
</script>

</html>
