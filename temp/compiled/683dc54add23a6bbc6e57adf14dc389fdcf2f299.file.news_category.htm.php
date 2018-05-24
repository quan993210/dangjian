<?php /* Smarty version Smarty-3.0.6, created on 2018-05-04 11:48:57
         compiled from "/home/wwwroot/default/dangjian/temp/admin/news/news_category.htm" */ ?>
<?php /*%%SmartyHeaderCode:2786515055aebd829b53726-93249973%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '683dc54add23a6bbc6e57adf14dc389fdcf2f299' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/news/news_category.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2786515055aebd829b53726-93249973',
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
/js/Datepicker/Wdatepicker.js" type="text/javascript"></script>
    <script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/editor/kindeditor.js" charset="utf-8"></script>
    <script src="<?php echo $_smarty_tpl->getVariable('url_path')->value;?>
/js/editor/lang/zh_CN.js" charset="utf-8"></script>
    <script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>

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
<form name="frm" action="news_category.php" method="post">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
	<tr>
      <td class="label">选择新闻分类：</td>
	  <td>
      	<select name="pid">
        	<option value="">请新闻选择分类</option>
            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('top_news_category')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <option value="<?php echo $_smarty_tpl->getVariable('top_news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catid'];?>
" <?php if ($_smarty_tpl->getVariable('cat')->value['pid']==$_smarty_tpl->getVariable('top_news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catid']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('top_news_category')->value[$_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']]['catname'];?>
</option>
            <?php endfor; endif; ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="label">新闻分类名称：</td>
	  <td><input type="text" name="catname" value="<?php echo $_smarty_tpl->getVariable('cat')->value['catname'];?>
"></td>
    </tr>
    <tr>
        <td class="label">分类图片：</td>
        <td>
            <!--<input type="file" name="pic" value="">-->
            <img src="<?php if ($_smarty_tpl->getVariable('cat')->value['logo']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('cat')->value['logo'];?>
<?php }else{ ?>/images/default_news.jpg<?php }?>" id="upload_logo" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
            <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('cat')->value['logo'];?>
" name="logo_path" id="logo_path" />
            <input type="button" id="pickfiles" style="background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />
        </td>
    </tr>
    <tr>
      <td class="label">排序：</td>
	  <td><input type="text" name="listorder" value="<?php if ($_smarty_tpl->getVariable('cat')->value['listorder']){?><?php echo $_smarty_tpl->getVariable('cat')->value['listorder'];?>
<?php }else{ ?>0<?php }?>"></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('cat')->value['catid'];?>
" name="catid" />
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


<script type="text/javascript">
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'pickfiles', // you can pass in id...
        url : 'news_category.php?action=upload_batch_photo&dir_type=news&upload_name=logo',
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
                //alert(data.response.logo_path);
                var dataObj = eval("(" + data.response + ")");
               // console.log(dataObj)
                //alert(dataObj.pic_path);
                //var piclist = $("#piclist").val();
                //piclist += piclist == "" ? dataObj.logo_path : "|" + dataObj.logo_path;
                $("#logo_path").val(dataObj.pic_path);
                $("#upload_logo").attr("src", dataObj.pic_path);
            },

            Error: function(up, err) {
                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            }
        }
    });

    uploader.init();
</script>

</body>
</html>
