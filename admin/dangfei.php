<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/5 0005
 * Time: 20:25
 * 党费
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");

$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
    case "list":
        dangfei_list();
        break;
    case "add_dangfei":
        add_dangfei();
        break;
    case "do_add_dangfei":
        do_add_dangfei();
        break;
    case "mod_dangfei":
        mod_dangfei();
        break;
    case "do_mod_dangfei":
        do_mod_dangfei();
        break;
    case "del_dangfei":
        del_dangfei();
        break;
    case "del_sel_dangfei":
        del_sel_dangfei();
        break;
    case "dangfei_data":
        dangfei_data();
        break;
    case "do_mod_dangfei_data":
        do_mod_dangfei_data();
        break;
    case "mod_dangfei_data":
        mod_dangfei_data();
        break;


}

function get_con()
{
    global $smarty;
    $adminid  = $_SESSION["admin_id"];
    $con = "where adminid = $adminid";
    //党费分类
    $year = irequest('year');
    $smarty->assign('year', $year);
    if (!empty($year))
    {
        $con .=" and year = '{$year}' ";
    }

    return $con;
}

/*------------------------------------------------------ */
//-- 党费列表
/*------------------------------------------------------ */
function dangfei_list()
{
    global $db, $smarty;

    //搜索条件
    $con 		= get_con();

    //排序字段
    $order 	 	 = 'ORDER BY year DESC,id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM dangfei {$con} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);
    foreach($arr as $key=>$val){
        $sql 		= "SELECT sum(cost) AS sum_cost FROM dangfei_data WHERE dangfeiid ='{$val['id']}' ";
        $sum_cost 		= $db->get_one($sql);
        $arr[$key]['sum_cost'] = $sum_cost;
    }

    $sql 		= "SELECT COUNT(id) FROM dangfei {$con}";
    $total 		= $db->get_one($sql);


    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('dangfei_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);


    $smarty->assign('page_title', '党费列表');
    $smarty->display('dangfei/dangfei_list.htm');
}

/*------------------------------------------------------ */
//-- 添加党费
/*------------------------------------------------------ */
function add_dangfei()
{
    global $smarty;
    $smarty->assign('action', 'do_add_dangfei');
    $smarty->assign('page_title', '添加党费');
    $smarty->display('dangfei/dangfei.htm');
}

/*------------------------------------------------------ */
//-- 添加党费
/*------------------------------------------------------ */
function do_add_dangfei()
{
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $exten = explode('.', $_FILES['dangfei']['name']);
    if($exten[1] !='xls' && $exten[1] !='xlsx'){
        alert_back('请按模板导入EXCEL文件');
    }

    $title    = crequest('title');
    $add_time_format	  = crequest('add_time');
    $add_time = strtotime($add_time_format);
    $year = date('Y',$add_time );
    check_null($title, 			'党费标题');

    $sql = "SELECT * FROM dangfei WHERE title = '{$title}' and add_time_format='{$add_time_format}'";
    $dangfei = $db->get_row($sql);
    if($dangfei){
        alert_back('同时间同标题的党费已存在');
    }



    $sql = "INSERT INTO dangfei (title, year, add_time, add_time_format,adminid) VALUES('{$title}','{$year}', '{$add_time}', '{$add_time_format}','{$adminid}')";
    $db->query($sql);
    $dangfeiid = $db->link_id->insert_id;
    $aid  = $_SESSION['admin_id'];
    $text = '添加党费，添加党费ID：' . $dangfeiid;
    operate_log($aid, 'dangfei', 1, $text);

    $sql = "SELECT * FROM dangfei WHERE id = '{$dangfeiid}'";
    $dangfei = $db->get_row($sql);

    //接收前台文件，
    $filename = $_FILES['dangfei']['name'];
    $tmp_name = $_FILES['dangfei']['tmp_name'];
    $data = uploadFile($filename, $tmp_name);
    add_dangfei_data($data,$dangfei);

    $url_to = "dangfei.php?action=list";
    url_locate($url_to, '添加成功');

}



function add_dangfei_data($data,$dangfei){
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $one = $data[0];
    unset($data[0]);
    $dangfeiid = $dangfei['id'];
    $add_time = $dangfei['add_time'];
    $add_time_format = $dangfei['add_time_format'];
    foreach($data as $key=>$val){
        $name = $val[0];
        $mobile = $val[1];
        $cost = $val[2];
        $sql = "SELECT * FROM member WHERE mobile = '{$mobile}'";
        $member = $db->get_row($sql);
        if(!$member){
            url_locate('dangfei.php?action=list', '第'.$key.'行信息不存在用户表中');
        }
        $userid = $member['userid'];
        $sql = "SELECT * FROM dangfei_data WHERE name = '{$name}' and mobile = '{$mobile}' and dangfeiid = '{$dangfeiid}' and add_time = '{$add_time}'";
        $row = $db->get_row($sql);
        if(!$row){
            $sql = "INSERT INTO dangfei_data (dangfeiid, userid, name,mobile,cost,status,add_time, add_time_format,adminid) VALUES
                      ('{$dangfeiid}','{$userid}', '{$name}','{$mobile}', '{$cost}','1', '{$add_time}', '{$add_time_format}','{$adminid}')";
            if(!$db->query($sql)){
                url_locate('dangfei.php?action=list', '第'.$key.'行导入错误');
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
//-- 修改党费
/*------------------------------------------------------ */
function mod_dangfei()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM dangfei WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    $smarty->assign('dangfei', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'do_mod_dangfei');
    $smarty->assign('page_title', '党费导入');
    $smarty->display('dangfei/dangfei.htm');
}

/*------------------------------------------------------ */
//-- 修改党费
/*------------------------------------------------------ */
function do_mod_dangfei()
{
    global $db;

    $exten = explode('.', $_FILES['dangfei']['name']);
    if($exten !='xls' || $exten !='xlsx'){
        alert_back('请按模板导入EXCEL文件');
    }
    $title    = crequest('title');
    $add_time_format	  = crequest('add_time');
    $add_time = strtotime($add_time_format);
    $year = date('Y',$add_time );
    check_null($title, 			'党费标题');

    $id = irequest('id');
    $update_col = "title = '{$title}', year = '{$year}', add_time = '{$add_time}', add_time_format = '{$add_time_format}'";
    $sql = "UPDATE dangfei SET {$update_col} WHERE id='{$id}'";
    $db->query($sql);
    $aid  = $_SESSION['admin_id'];
    $text = '修改党费，修改党费ID：' . $id;
    operate_log($aid, 'dangfei', 2, $text);

    $sql = "SELECT * FROM dangfei WHERE id = '{$id}'";
    $dangfei = $db->get_row($sql);

    //接收前台文件，
    $filename = $_FILES['dangfei']['name'];
    $tmp_name = $_FILES['dangfei']['tmp_name'];
    $data = uploadFile($filename, $tmp_name);
    add_dangfei_data($data,$dangfei);

    $now_page = irequest('now_page');
    $url_to = "dangfei.php?action=list&page={$now_page}";
    url_locate($url_to, '导入成功');
}

/*------------------------------------------------------ */
//-- 删除党费
/*------------------------------------------------------ */
function del_dangfei()
{
    global $db;

    $id  = irequest('id');
    $sql = "SELECT cover FROM dangfei WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    del_img($row['cover']);

    $sql = "DELETE FROM dangfei WHERE id = '{$id}'";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '删除党费，删除党费ID：' . $id;
    operate_log($aid, 'dangfei', 3, $text);

    $now_page = irequest('now_page');
    $url_to = "dangfei.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除党费
/*------------------------------------------------------ */
function del_sel_dangfei()
{
    global $db;
    $id = crequest('checkboxes');

    if ($id == '')
        alert_back('请选中需要删除的选项');


    $sql = "DELETE FROM dangfei WHERE id IN ({$id})";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '批量删除党费，批量删除党费ID：' . $id;
    operate_log($aid, 'dangfei', 4, $text);

    $now_page = irequest('now_page');
    $url_to = "dangfei.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 删除党费图片
/*------------------------------------------------------ */
function del_one_img()
{
    $img_name = crequest('img_name');
    //del_img($img_name);

    $id = irequest('id');
    $now_page = irequest('now_page');

    global $db;
    $replace_img = $img_name . '|';
    $sql = "UPDATE dangfei SET imgs = replace(imgs, '{$replace_img}', '') WHERE id = '{$id}'";
    $db->query($sql);

    $url_to = "dangfei.php?action=mod_dangfei&id={$id}&now_page=$now_page";
    href_locate($url_to, '删除成功');
}

function dangfei_data(){
    global $db, $smarty;
    $adminid  = $_SESSION["admin_id"];
    $dangfeiid = irequest('dangfeiid');
    //搜索条件
    $status = irequest('status');
    $smarty->assign('status', $status);
    $where =$status ? " where dangfeiid = '{$dangfeiid}' and status = '{$status}' " : " where dangfeiid = '{$dangfeiid}' ";
    $where.=" and adminid='{$adminid}'";
    //排序字段
    $order 	 	 = 'ORDER BY status ASC,id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM dangfei_data {$where} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);

    $sql 		= "SELECT COUNT(id) FROM dangfei_data {$where}";
    $total 		= $db->get_one($sql);


    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('dangfei_data_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);


    $smarty->assign('page_title', '党费详情列表');
    $smarty->display('dangfei/dangfei_data_list.htm');
}

/*------------------------------------------------------ */
//-- 修改党费
/*------------------------------------------------------ */
function mod_dangfei_data()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM dangfei_data WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    $smarty->assign('dangfei_data', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'do_mod_dangfei_data');
    $smarty->assign('page_title', '党费修改');
    $smarty->display('dangfei/dangfei_data.htm');
}

/*------------------------------------------------------ */
//-- 修改党费
/*------------------------------------------------------ */
function do_mod_dangfei_data()
{
    global $db;
    $cost    = crequest('cost');
    check_null($cost, 			'党费');

    $id = irequest('id');
    $update_col = "cost = '{$cost}'";
    $sql = "UPDATE dangfei_data SET {$update_col} WHERE id='{$id}'";
    $db->query($sql);
    $aid  = $_SESSION['admin_id'];
    $text = '修改党费详情，修改党费详情ID：' . $id;
    operate_log($aid, 'dangfei', 2, $text);

    $now_page = irequest('now_page');
    $url_to = "dangfei.php";
    url_locate($url_to, '党费详情修改成功');
}


