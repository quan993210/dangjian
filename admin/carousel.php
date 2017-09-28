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
    case "add_member":
        add_member();
        break;
    case "do_add_member":
        do_add_member();
        break;
    case "mod_member":
        mod_member();
        break;
    case "do_mod_member":
        do_mod_member();
        break;
    case "del_member":
        del_member();
        break;
    case "del_sel_member":
        del_sel_member();
        break;
}



/*------------------------------------------------------ */
//-- 案例列表
/*------------------------------------------------------ */
function carousel()
{
    global $db, $smarty;
    $act 	= crequest('act');
    if($act == "edit"){
        $id = irequest('id');
        $image1 = crequest('image1');
        $image2 = crequest('image2');
        $image3 = crequest('image3');
        $update_col = "image1 = '{$image1}', image2 = '{$image2}', image3 = '{$image3}'";
        $sql = "UPDATE carousel SET {$update_col} WHERE id='{$id}'";
        $db->query($sql);
    }
    //列表信息
    $sql 		= "SELECT * FROM carousel";
    $arr 		= $db->get_row($sql);
    $smarty->assign('image',$arr);

    $smarty->assign('page_title', '用户列表');
    $smarty->display('carousel/image.htm');
}


/*------------------------------------------------------ */
//-- 删除案例
/*------------------------------------------------------ */
function del_member()
{
    global $db;

    $userid = irequest('userid');
    /*$sql = "DELETE FROM member WHERE userid = '{$userid}'";
    $db->query($sql);*/

    $update_col = "is_delete = '1'";
    $sql = "UPDATE member SET {$update_col} WHERE userid = '{$userid}'";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '删除用户，删除用户ID：' . $userid;
    operate_log($aid, 'member', 3, $text);

    $now_page = irequest('now_page');
    $url_to = "member.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除案例
/*------------------------------------------------------ */
function del_sel_member()
{
    global $db;

    $userid = crequest('checkboxes');
    if (empty($userid))alert_back('请选中需要删除的选项');

    /*$sql = "DELETE FROM member WHERE userid IN ({$userid})";
    $db->query($sql);*/

    $sql = "SELECT * FROM member WHERE userid IN ({$userid})";
    $member_all = $db->get_all($sql);
    $update_col = "is_delete = '1'";
    foreach($member_all as $key=>$val){
        $sql = "UPDATE member SET {$update_col} WHERE userid = '{$val['userid']}'";
        $db->query($sql);
    }

    $aid  = $_SESSION['admin_id'];
    $text = '批量删除会员，批量删除会员ID：' . $userid;
    operate_log($aid, 'member', 4, $text);

    $now_page = irequest('now_page');
    $url_to = "member.php?action=list&page={$now_page}";
    href_locate($url_to);
}

?>

