<?php
//register_shutdown_function(function(){ var_dump(error_get_last()); });
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
    case "list":
        lable_list();
        break;
    case "add_lable":
        add_lable();
        break;
    case "do_add_lable":
        do_add_lable();
        break;
    case "mod_lable":
        mod_lable();
        break;
    case "do_mod_lable":
        do_mod_lable();
        break;
    case "del_lable":
        del_lable();
        break;
    case "del_sel_lable":
        del_sel_lable();
        break;
    case "upload_batch_photo":
        upload_batch_photo();
        break;
}


/*------------------------------------------------------ */
//-- 新闻分类列表
/*------------------------------------------------------ */
function lable_list()
{
    global $db, $smarty;
    $con = "where is_delete=0";
    //关键字
    $keyword = crequest('keyword');
    $smarty->assign('keyword', $keyword);
    if (!empty($keyword))
    {
        $con .= " AND name like '%{$keyword}%' ";
    }

    //排序字段
    $order 	 	 = 'ORDER BY listorder DESC, id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM lable {$con} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);

    $sql 		= "SELECT COUNT(id) FROM lable {$con}";
    $total 		= $db->get_one($sql);
    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);

    $page_title = '文章列表';
    $smarty->assign('page_title', $page_title);
    $smarty->display('lable/lable_list.htm');
}

/*------------------------------------------------------ */
//-- 添加新闻分类
/*------------------------------------------------------ */
function add_lable()
{
    global $smarty;

    $page_title = '添加文章标签';
    $smarty->assign('page_title', $page_title);

    $smarty->assign('action', 'do_add_lable');
    $smarty->display('lable/lable.htm');
}

/*------------------------------------------------------ */
//-- 添加新闻分类
/*------------------------------------------------------ */
function do_add_lable()
{
    global $db;
    $info = $_POST['info'];
    $info['add_time']	= time();
    $info['add_time_format']	= now_time();
    check_null($info['name'], '文章标签');
    $id = $db->insert('lable',$info);
    $aid  = $_SESSION['dangwei_id'];
    $text = '添加文章标签，添加文章标签ID：'.$id;
    dangwei_operate_log($aid, 'lable', 1, $text);

    $url_to = "lable.php?action=list";
    url_locate($url_to, '添加成功');
}

/*------------------------------------------------------ */
//-- 修改新闻分类
/*------------------------------------------------------ */
function mod_lable()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM lable WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    $smarty->assign('list', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $page_title = '修改文章标签';
    $smarty->assign('page_title', $page_title);
    $smarty->assign('action', 'do_mod_lable');
    $smarty->display('lable/lable.htm');
}

/*------------------------------------------------------ */
//-- 修改新闻分类
/*------------------------------------------------------ */
function do_mod_lable()
{
    global $db;

    $info = $_POST['info'];
    check_null($info['name'], '新闻分类名称');
    $id = irequest('id');
    $db->update('lable',$info,"id=$id");

    $aid  = $_SESSION['dangwei_id'];
    $text = '修改文章分类，修改文章分类ID：' . $id;
    dangwei_operate_log($aid, 'lable', 2, $text);

    $now_page = irequest('now_page');
    $url_to = "lable.php?action=list&page=$now_page";
    url_locate($url_to, '修改成功');
}

/*------------------------------------------------------ */
//-- 删除新闻分类
/*------------------------------------------------------ */
function del_lable()
{
    global $db;
    $id = irequest('id');

    /*$sql = "DELETE FROM lable WHERE id = '{$id}' OR pid = '{$id}'";
    $db->query($sql);*/

    $update_col = "is_delete = '1'";
    $sql = "UPDATE lable SET {$update_col} WHERE id = '{$id}'";
    $db->query($sql);

    $aid  = $_SESSION['dangwei_id'];
    $text = '删除文章标签，删除文章标签ID：' . $id;
    dangwei_operate_log($aid, 'lable', 3, $text);

    $now_page = irequest('now_page');
    $url_to = "lable.php?action=list&page=$now_page";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除新闻分类
/*------------------------------------------------------ */
function del_sel_lable()
{
    global $db;
    $id = crequest('checkboxes');

    if ($id == '')
        alert_back('请选中需要删除的选项');

    /*$sql = "DELETE FROM lable WHERE id IN ({$id}) OR pid IN ({$id})";
    $db->query($sql);*/

    $sql = "SELECT * FROM lable WHERE id IN ({$id})";
    $lable_all = $db->get_all($sql);
    $update_col = "is_delete = '1'";
    foreach($lable_all as $key=>$val){
        $sql = "UPDATE lable SET {$update_col} WHERE id = '{$val['id']}'";
        $db->query($sql);
    }

    $aid  = $_SESSION['dangwei_id'];
    $text = '批量删除文章标签，批量删除文章标签ID：' . $id;
    dangwei_operate_log($aid, 'lable', 4, $text);

    $now_page = irequest('now_page');
    $url_to = "lable.php?action=list&page=$now_page";
    href_locate($url_to);
}


?>