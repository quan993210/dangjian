<?php /* Smarty version Smarty-3.0.6, created on 2017-08-24 15:21:36
         compiled from "E:/phpStudy/WWW/dangjian/temp/admin\article/article.htm" */ ?>
<?php /*%%SmartyHeaderCode:4871599e7e802793d0-11693470%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8bb4dc0cada97e0c03366635fc18add57672a8e3' => 
    array (
      0 => 'E:/phpStudy/WWW/dangjian/temp/admin\\article/article.htm',
      1 => 1501893769,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4871599e7e802793d0-11693470',
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
<script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/editor/kindeditor.js" charset="utf-8"></script>
<script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/editor/lang/zh_CN.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>

<script language="javascript">
function add_img()
{
	var img_count = parseInt($("#img_count").val());
	var next_img = img_count + 1;
	var img_div = '<div id="img' + next_img + '"><input type="file" name="image' + next_img + '" value=""> <a href="javascript:void(0);" onclick="del_img(' + next_img + ');">[-]</a></div>';
	$("#imgs").append(img_div);
	$("#img_count").val(next_img);
}

function del_img(num)
{
	$("#img" + num).remove();
}

function select_time()
{
	WdatePicker({dateFmt:'yyyy-MM-dd'})
}

function show_pic(type)
{
	if (type == 1)
		$("#pic_tr").show();
	else
		$("#pic_tr").hide();
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
<form name="frm" action="article.php" method="post" enctype="multipart/form-data">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td class="label">文章分类：</td>
	  <td>
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
" <?php if ($_smarty_tpl->getVariable('article')->value['cid']==$_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
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
" <?php if ($_smarty_tpl->getVariable('article')->value['cid']==$_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['id']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('article_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['sub'][$_smarty_tpl->getVariable('smarty')->value['section']['subloop']['index']]['name'];?>
</option>
            <?php endfor; endif; ?>
            <?php endfor; endif; ?>
        </select>       
      </td>
    </tr>
    <tr>
      <td class="label">文章标题：</td>
	  <td><input type="text" name="title" value="<?php echo $_smarty_tpl->getVariable('article')->value['title'];?>
" size="48" /></td>
    </tr>   
    <tr>
      <td class="label">文章图片：</td>
	  <td>
        <!--<input type="file" name="pic" value="">-->
      	<img src="<?php if ($_smarty_tpl->getVariable('article')->value['pic']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('article')->value['pic'];?>
<?php }else{ ?>/images/default_article.jpg<?php }?>" id="upload_pic" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('article')->value['pic'];?>
" name="pic_path" id="pic_path" />
        <input type="button" id="pickfiles" style="background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />
      </td>
    </tr>
    
    <tr>
      <td class="label">文章简介：</td>
	  <td>
      	<textarea id="brief" name="brief" style="width:300px;height:60px;"><?php echo $_smarty_tpl->getVariable('article')->value['brief'];?>
</textarea>
      </td>
    </tr>     
    <tr>
      <td class="label">文章内容：</td>
	  <td>
      	<textarea id="content" name="content" style="width:700px;height:300px;"><?php echo $_smarty_tpl->getVariable('article')->value['content'];?>
</textarea>

        
    	<script>
					var editor;
					KindEditor.ready(function(K) {
						editor = K.create('textarea[name="content"]', {
							filterMode:false
						});
					});
		</script>
        
      </td>
    </tr>
    <tr>
      <td class="label">发布人：</td>
	  <td><input type="text" name="author" value="<?php if ($_smarty_tpl->getVariable('article')->value['author']==''){?>辰锦科技<?php }else{ ?><?php echo $_smarty_tpl->getVariable('article')->value['author'];?>
<?php }?>" size="15" /></td>
    </tr>
    <tr>
      <td class="label">来源：</td>
	  <td><input type="text" name="source" value="<?php if ($_smarty_tpl->getVariable('article')->value['source']==''){?>本站原创<?php }else{ ?><?php echo $_smarty_tpl->getVariable('article')->value['source'];?>
<?php }?>" size="15" /></td>
    </tr> 
    <tr>
      <td class="label">排序：</td>
	  <td><input type="text" name="order_num" value="<?php if ($_smarty_tpl->getVariable('article')->value['order_num']==''){?>0<?php }else{ ?><?php echo $_smarty_tpl->getVariable('article')->value['order_num'];?>
<?php }?>" size="15" /></td>
    </tr>
    <tr>
      <td class="label">对应案例：</td>
	  <td>
      <select name="pid" id="pid">	
        <option value="0">选择对应案例</option>
      	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('cases')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <option value="<?php echo $_smarty_tpl->getVariable('cases')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id'];?>
" <?php if ($_smarty_tpl->getVariable('article')->value['pid']==$_smarty_tpl->getVariable('cases')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['id']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('cases')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['name'];?>
</option>
      	<?php endfor; endif; ?>
      </select>
      </td>
    </tr> 
    <!--<tr>
      <td class="label">是否头条：</td>
	  <td>
      	<input type="radio" name="is_top" value="0" onclick="show_pic(0);" <?php if ($_smarty_tpl->getVariable('article')->value['is_top']==0||$_smarty_tpl->getVariable('article')->value['is_top']==''){?>checked="checked"<?php }?> />否 
        <input type="radio" name="is_top" value="1" onclick="show_pic(1);" <?php if ($_smarty_tpl->getVariable('article')->value['is_top']==1){?>checked="checked"<?php }?> />是
      </td>
    </tr>
    <tr id="pic_tr" style="display:<?php if ($_smarty_tpl->getVariable('article')->value['is_top']==0||$_smarty_tpl->getVariable('article')->value['is_top']==''){?>none<?php }?>;">
      <td class="label">头条大图：</td>
	  <td><input type="file" name="top_pic" value=""></td>
    </tr>-->
    
    <tr>
      <td colspan="2" align="center">
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" name="action" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('now_page')->value;?>
" name="now_page" />
      	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('article')->value['id'];?>
" name="id" />
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('article')->value['pic'];?>
" name="pic_name" />
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('article')->value['top_pic'];?>
" name="top_pic_name" />
      	<input type="submit" value="确定">
      </td>
    </tr>
</table>
</form>


<script type="text/javascript">
// Custom example logic

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	url : 'article.php?action=upload_batch_photo&dir_type=article&upload_name=pic',
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
			//document.getElementById('filelist').innerHTML = '';

			/*document.getElementById('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			};*/
		},

		FilesAdded: function(up, files) {
	
			plupload.each(files, function(file) {
				//document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
				
				var html = '<tr id="' + file.id + '">';
				html += '<td width="200" align="left">' + file.name + '</td>'; 
				html += '<td width="100" align="center">' + plupload.formatSize(file.size) + '</td>';
				html += '<td width="100" align="center" id="' + file.id + '_progress"></td>';
				html += '</tr>';
				
				//$("#uploadlist").append(html);
				//$("#uploadlist").html(html);
			});
			
			uploader.start();
		},

		UploadProgress: function(up, file) {
			//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			$("#" + file.id + "_progress").html(file.percent + "%");
		},
		
		FileUploaded: function(up, file, data) {
			//alert(data.response.pic_path);
			var dataObj = eval("(" + data.response + ")");
			//alert(dataObj.pic_path);
			//var piclist = $("#piclist").val();
			//piclist += piclist == "" ? dataObj.pic_path : "|" + dataObj.pic_path;
			$("#pic_path").val(dataObj.pic_path);
			$("#upload_pic").attr("src", dataObj.pic_path);
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader.init();

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
