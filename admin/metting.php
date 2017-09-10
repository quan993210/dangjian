<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/5 0005
 * Time: 20:25
 * 会议
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
require("inc/lib_common.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
    case "list":
        metting_list();
        break;
   /* case "add_metting":
        add_metting();
        break;
    case "do_add_metting":
        do_add_metting();
        break;
    case "mod_metting":
        mod_metting();
        break;
    case "do_mod_metting":
        do_mod_metting();
        break;
    case "del_metting":
        del_metting();
        break;
    case "del_sel_metting":
        del_sel_metting();
        break;
    case "metting_data":
        metting_data();
        break;
    case "do_mod_metting_data":
        do_mod_metting_data();
        break;
    case "mod_metting_data":
        mod_metting_data();
        break;*/


}

function get_con()
{
    global $smarty;
    $con = "";
    //会议分类
    $keyword = crequest('keyword');
    $smarty->assign('keyword', $keyword);
    if (!empty($keyword))
    {
        $con .=" where title = '{$keyword}' ";
    }

    return $con;
}

/*------------------------------------------------------ */
//-- 会议列表
/*------------------------------------------------------ */
function metting_list()
{
    global $db, $smarty;

    //搜索条件
    $con 		= get_con();

    //排序字段
    $order 	 	 = 'ORDER BY id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM metting {$con} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);

    $sql 		= "SELECT COUNT(id) FROM metting {$con}";
    $total 		= $db->get_one($sql);


    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('metting_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);


    $smarty->assign('page_title', '会议列表');
    $smarty->display('metting/metting_list.htm');
}

/*------------------------------------------------------ */
//-- 添加会议
/*------------------------------------------------------ */
function add_metting()
{
    global $smarty;
    $smarty->assign('action', 'do_add_metting');
    $smarty->assign('page_title', '添加会议');
    $smarty->display('metting/metting.htm');
}

/*------------------------------------------------------ */
//-- 添加会议
/*------------------------------------------------------ */
function do_add_metting()
{
    global $db;
    $title    = crequest('title');
    $add_time_format	  = crequest('add_time');
    $add_time = strtotime($add_time_format);
    $year = date('Y',$add_time );
    check_null($title, 			'会议标题');

    $sql = "INSERT INTO metting (title, year, add_time, add_time_format) VALUES('{$title}','{$year}', '{$add_time}', '{$add_time_format}')";
    $db->query($sql);
    $mettingid = $db->link_id->insert_id;
    $aid  = $_SESSION['admin_id'];
    $text = '添加会议，添加会议ID：' . $mettingid;
    operate_log($aid, 'metting', 1, $text);

    $sql = "SELECT * FROM metting WHERE id = '{$mettingid}'";
    $metting = $db->get_row($sql);

    //接收前台文件，
    $filename = $_FILES['metting']['name'];
    $tmp_name = $_FILES['metting']['tmp_name'];
    $data = uploadFile($filename, $tmp_name);
    add_metting_data($data,$metting);

    $url_to = "metting.php?action=list";
    url_locate($url_to, '添加成功');

}

function add_metting_data($data,$metting){
    global $db;
    $one = $data[0];
    unset($data[0]);
    $mettingid = $metting['id'];
    $add_time = $metting['add_time'];
    $add_time_format = $metting['add_time_format'];
    foreach($data as $key=>$val){
        $name = $val[0];
        $mobile = $val[1];
        $cost = $val[2];
        $sql = "SELECT * FROM member WHERE mobile = '{$mobile}'";
        $member = $db->get_row($sql);
        if(!$member){
            url_locate('metting.php?action=list', '第'.$key.'行信息不存在用户表中');
        }
        $userid = $member['userid'];
        $sql = "SELECT * FROM metting_data WHERE name = '{$name}' and mobile = '{$mobile}' and mettingid = '{$mettingid}' and add_time = '{$add_time}'";
        $row = $db->get_row($sql);
        if(!$row){
            $sql = "INSERT INTO metting_data (mettingid, userid, name,mobile,cost,status,add_time, add_time_format) VALUES
                      ('{$mettingid}','{$userid}', '{$name}','{$mobile}', '{$cost}','1', '{$add_time}', '{$add_time_format}')";
            if(!$db->query($sql)){
                url_locate('metting.php?action=list', '第'.$key.'行导入错误');
            }
        }
    }
    return true;

}

//导入Excel文件
function uploadFile($file,$filetempname){
    //自己设置的上传文件存放路径
    $filePath = ROOT_PATH.'/upload/excel/';
    //下面的路径按照你PHPExcel的路径来修改

    //注意设置时区
    $time=date("y-m-d-H-i-s");//去当前上传的时间
    //获取上传文件的扩展名
    $extend=strrchr ($file,'.');
    //上传后的文件名
    $name=$time.$extend;
    $uploadfile=$filePath.$name;//上传后的文件名地址
    //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
    $result=move_uploaded_file($filetempname,$uploadfile);//假如上传到当前目录下
    if($result) //如果上传文件成功，就执行导入excel操作
    {
        $type = 'Excel2007';//设置为Excel5代表支持2003或以下版本，Excel2007代表2007版
        $xlsReader = PHPExcel_IOFactory::createReader($type);
        $xlsReader->setReadDataOnly(true);
        $xlsReader->setLoadSheetsOnly(true);
        $Sheets = $xlsReader->load($uploadfile);
        //开始读取上传到服务器中的Excel文件，返回一个二维数组
        $dataArray = $Sheets->getSheet(0)->toArray();
        return $dataArray;
    }

}

/*------------------------------------------------------ */
//-- 修改会议
/*------------------------------------------------------ */
function mod_metting()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM metting WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    $smarty->assign('metting', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'do_mod_metting');
    $smarty->assign('page_title', '会议导入');
    $smarty->display('metting/metting.htm');
}

/*------------------------------------------------------ */
//-- 修改会议
/*------------------------------------------------------ */
function do_mod_metting()
{
    global $db;
    $title    = crequest('title');
    $add_time_format	  = crequest('add_time');
    $add_time = strtotime($add_time_format);
    $year = date('Y',$add_time );
    check_null($title, 			'会议标题');

    $id = irequest('id');
    $update_col = "title = '{$title}', year = '{$year}', add_time = '{$add_time}', add_time_format = '{$add_time_format}'";
    $sql = "UPDATE metting SET {$update_col} WHERE id='{$id}'";
    $db->query($sql);
    $aid  = $_SESSION['admin_id'];
    $text = '修改会议，修改会议ID：' . $id;
    operate_log($aid, 'metting', 2, $text);

    $sql = "SELECT * FROM metting WHERE id = '{$id}'";
    $metting = $db->get_row($sql);

    //接收前台文件，
    $filename = $_FILES['metting']['name'];
    $tmp_name = $_FILES['metting']['tmp_name'];
    $data = uploadFile($filename, $tmp_name);
    add_metting_data($data,$metting);

    $now_page = irequest('now_page');
    $url_to = "metting.php?action=list&page={$now_page}";
    url_locate($url_to, '导入成功');
}

/*------------------------------------------------------ */
//-- 删除会议
/*------------------------------------------------------ */
function del_metting()
{
    global $db;

    $id  = irequest('id');
    $sql = "SELECT cover FROM metting WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    del_img($row['cover']);

    $sql = "DELETE FROM metting WHERE id = '{$id}'";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '删除会议，删除会议ID：' . $id;
    operate_log($aid, 'metting', 3, $text);

    $now_page = irequest('now_page');
    $url_to = "metting.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除会议
/*------------------------------------------------------ */
function del_sel_metting()
{
    global $db;
    $id = crequest('checkboxes');

    if ($id == '')
        alert_back('请选中需要删除的选项');


    $sql = "DELETE FROM metting WHERE id IN ({$id})";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '批量删除会议，批量删除会议ID：' . $id;
    operate_log($aid, 'metting', 4, $text);

    $now_page = irequest('now_page');
    $url_to = "metting.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 删除会议图片
/*------------------------------------------------------ */
function del_one_img()
{
    $img_name = crequest('img_name');
    //del_img($img_name);

    $id = irequest('id');
    $now_page = irequest('now_page');

    global $db;
    $replace_img = $img_name . '|';
    $sql = "UPDATE metting SET imgs = replace(imgs, '{$replace_img}', '') WHERE id = '{$id}'";
    $db->query($sql);

    $url_to = "metting.php?action=mod_metting&id={$id}&now_page=$now_page";
    href_locate($url_to, '删除成功');
}

function metting_data(){
    global $db, $smarty;
    $mettingid = irequest('mettingid');
    //搜索条件
    $status = irequest('status');
    $smarty->assign('status', $status);
    $where =$status ? " where mettingid = '{$mettingid}' and status = '{$status}' " : " where mettingid = '{$mettingid}' ";

    //排序字段
    $order 	 	 = 'ORDER BY status ASC,id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM metting_data {$where} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);

    $sql 		= "SELECT COUNT(id) FROM metting_data {$where}";
    $total 		= $db->get_one($sql);


    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('metting_data_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);


    $smarty->assign('page_title', '会议详情列表');
    $smarty->display('metting/metting_data_list.htm');
}

/*------------------------------------------------------ */
//-- 修改会议
/*------------------------------------------------------ */
function mod_metting_data()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM metting_data WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    $smarty->assign('metting_data', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'do_mod_metting_data');
    $smarty->assign('page_title', '会议修改');
    $smarty->display('metting/metting_data.htm');
}

/*------------------------------------------------------ */
//-- 修改会议
/*------------------------------------------------------ */
function do_mod_metting_data()
{
    global $db;
    $cost    = crequest('cost');
    check_null($cost, 			'会议');

    $id = irequest('id');
    $update_col = "cost = '{$cost}'";
    $sql = "UPDATE metting_data SET {$update_col} WHERE id='{$id}'";
    $db->query($sql);
    $aid  = $_SESSION['admin_id'];
    $text = '修改会议详情，修改会议详情ID：' . $id;
    operate_log($aid, 'metting', 2, $text);

    $now_page = irequest('now_page');
    $url_to = "metting.php";
    url_locate($url_to, '会议详情修改成功');
}


