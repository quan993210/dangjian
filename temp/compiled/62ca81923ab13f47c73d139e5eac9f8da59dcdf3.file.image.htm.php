<?php /* Smarty version Smarty-3.0.6, created on 2018-05-02 09:57:14
         compiled from "/home/wwwroot/default/dangjian/temp/admin/carousel/image.htm" */ ?>
<?php /*%%SmartyHeaderCode:631591195ae91afa730337-38058429%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62ca81923ab13f47c73d139e5eac9f8da59dcdf3' => 
    array (
      0 => '/home/wwwroot/default/dangjian/temp/admin/carousel/image.htm',
      1 => 1524555267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '631591195ae91afa730337-38058429',
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
 管理中心</a>  - 首页轮播图 </span>
<div style="clear:both"></div>
</h1>
<div id="tabbody-div">
<form name="form" action="" method="post" enctype="multipart/form-data">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
        <td>轮播图片：</td>
        <td>
            <!--<input type="file" name="pic" value="">-->
            <img src="<?php if ($_smarty_tpl->getVariable('image')->value['image1']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('image')->value['image1'];?>
<?php }else{ ?>/images/default_news.jpg<?php }?>" id="upload_image1" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
            <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('image')->value['image1'];?>
" name="image1" id="image1" />
            <input type="button" id="pic_image1" style="background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />
            <a style="height: 19px;background: #fff; border: 1px #ccc solid;padding: 2px 8px 0px;display: inline-block;" href="carousel.php?action=del_image&img=1">清空</a>
            <div style="color:#ff0000">图片大小为750px*400px</div>
        </td>
        <td>
            <!--<input type="file" name="pic" value="">-->
            <img src="<?php if ($_smarty_tpl->getVariable('image')->value['image2']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('image')->value['image2'];?>
<?php }else{ ?>/images/default_news.jpg<?php }?>" id="upload_image2" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
            <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('image')->value['image2'];?>
" name="image2" id="image2" />
            <input type="button" id="pic_image2" style="width: 100px;height: 30px;background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />
            <a style="height: 19px;background: #fff; border: 1px #ccc solid;padding: 2px 8px 0px;display: inline-block;" href="carousel.php?action=del_image&img=2">清空</a>
            <div style="color:#ff0000">图片大小为750px*400px</div>
        </td>
        <td>
            <!--<input type="file" name="pic" value="">-->
            <img src="<?php if ($_smarty_tpl->getVariable('image')->value['image3']!=''){?><?php echo $_smarty_tpl->getVariable('url_path')->value;?>
<?php echo $_smarty_tpl->getVariable('image')->value['image3'];?>
<?php }else{ ?>/images/default_news.jpg<?php }?>" id="upload_image3" style="width:150px;height:100px;border: 1px solid #ccc;padding: 3px;border-radius: 5px;" /><br/>
            <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('image')->value['image3'];?>
" name="image3" id="image3" />
            <input type="button" id="pic_image3" style="background:#fff;width:76px;height:24px;border:0;cursor:pointer;border:1px solid #CCC;margin:5px 0;margin-bottom:10px;" value="上传图片" />
            <a style="height: 19px;background: #fff; border: 1px #ccc solid;padding: 2px 8px 0px;display: inline-block;" href="carousel.php?action=del_image&img=3">清空</a>
            <div style="color:#ff0000">图片大小为750px*400px</div>
        </td>
    </tr>

    <tr style="margin-top: 50px">
      <td colspan="4" align="center">
      <input type="hidden" name="act" value="edit" />
      <input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('image')->value['id'];?>
" />
          </br></br></br>
      <input type="submit" style="width: 100px;height: 30px" value="确定">
      </td>
    </tr>
</table>
</form>
</div>

<script type="text/javascript">
    // Custom example logic
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

</body>
</html>
