<?php /* Smarty version Smarty-3.0.6, created on 2017-09-28 19:58:42
         compiled from "E:/phpStudy/WWW/dangjian/temp/admin\common/drag.htm" */ ?>
<?php /*%%SmartyHeaderCode:2861259cce3f21c2229-37280515%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '38e6a1eeeb22e4f6620935d481437bb10c297115' => 
    array (
      0 => 'E:/phpStudy/WWW/dangjian/temp/admin\\common/drag.htm',
      1 => 1506392245,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2861259cce3f21c2229-37280515',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title></title>

<style type="text/css">
body {
  margin: 0;
  padding: 0;
  background: #80BDCB;
  cursor: E-resize;
}
</style>
<script type="text/javascript" language="JavaScript">
<!--
var url_path = "<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
";

var pic = new Image();
pic.src = url_path + "/images/arrow_right.gif";

function toggleMenu()
{
  frmBody = parent.document.getElementById('frame-body');
  imgArrow = document.getElementById('img');

  if (frmBody.cols == "0, 10, *")
  {
    frmBody.cols="160, 10, *";
    imgArrow.src = url_path + "/images/arrow_left.gif";
  }
  else
  {
    frmBody.cols="0, 10, *";
    imgArrow.src = url_path + "/images/arrow_right.gif";
  }
}

var orgX = 0;
document.onmousedown = function(e)
{
  var evt = Utils.fixEvent(e);
  orgX = evt.clientX;

  if (Browser.isIE) document.getElementById('tbl').setCapture();
}

document.onmouseup = function(e)
{
  var evt = Utils.fixEvent(e);

  frmBody = parent.document.getElementById('frame-body');
  frmWidth = frmBody.cols.substr(0, frmBody.cols.indexOf(','));
  frmWidth = (parseInt(frmWidth) + (evt.clientX - orgX));

  frmBody.cols = frmWidth + ", 10, *";

  if (Browser.isIE) document.releaseCapture();
}

var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var Utils = new Object();

Utils.fixEvent = function(e)
{
  var evt = (typeof e == "undefined") ? window.event : e;
  return evt;
}
//-->
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body onselect="return false;">
<table height="100%" cellspacing="0" cellpadding="0" id="tbl">
  <tr><td><a href="javascript:toggleMenu();"><img src="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/images/arrow_left.gif" width="10" height="30" id="img" border="0" /></a></td></tr>
</table>
</body>
</html>