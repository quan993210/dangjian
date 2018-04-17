<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/28 0028
 * Time: 22:38
 * 首页轮播图
 */

set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
    case "list":
        carousel();
        break;
    case "del_image":
        del_image();
        break;
}



/*------------------------------------------------------ */
//-- 案例列表
/*------------------------------------------------------ */
function carousel()
{
    global $db, $smarty;
    $adminid  = $_SESSION["admin_id"];
    $act 	= crequest('act');
    if($act == "edit"){
        $id = irequest('id');
        $image1 = crequest('image1');
        $image2 = crequest('image2');
        $image3 = crequest('image3');
        $update_col = "image1 = '{$image1}', image2 = '{$image2}', image3 = '{$image3}'";
        $sql = "UPDATE carousel SET {$update_col} WHERE adminid = '{$adminid}'";
        $db->query($sql);
    }
    //列表信息
    $sql 		= "SELECT * FROM carousel where adminid='{$adminid}'";
    $arr 		= $db->get_row($sql);
    $smarty->assign('image',$arr);

    $smarty->assign('page_title', '用户列表');
    $smarty->display('carousel/image.htm');
}


function del_image()
{
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $id =$_GET['img'];
    $update_col = "image$id = ''";
    $sql = "UPDATE carousel SET {$update_col} WHERE adminid='{$adminid}'";
    $db->query($sql);

    $url_to = "carousel.php";
    url_locate($url_to, '已清空');
}

?>

