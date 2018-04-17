<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2018/1/22 0022
 * Time: 21:28
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");

$action = crequest("action");
$action = $action == '' ? 'report' : $action;

switch ($action)
{
    case "report":
        report();
        break;
    case "report_list":
        report_list();
        break;
    case "mod_report":
        mod_report();
        break;
    case "update_report":
        update_report();
        break;
    case "export":
        export();
        break;
    case "detail_export":
        detail_export();
        break;

}


/*------------------------------------------------------
`money` decimal(10,2) DEFAULT NULL COMMENT '党费收缴金额',
  `num` int(11) DEFAULT NULL COMMENT '缴纳党费人数',
  `use_funds` decimal(10,2) DEFAULT NULL COMMENT '使用党建经费',
  `use_money` decimal(10,2) DEFAULT NULL COMMENT '使用党费',
  `paid_dues` int(11) DEFAULT NULL COMMENT '上缴党费百分比',
  `remaining_dues` int(11) DEFAULT NULL COMMENT '剩余党费百分比',
  `honor_country` int(11) DEFAULT NULL COMMENT '国家级荣誉',
  `honor_province` int(11) DEFAULT NULL COMMENT '省级荣誉',
  `honor_city` int(11) DEFAULT NULL COMMENT '市级荣誉',
  `file_country` int(11) DEFAULT NULL COMMENT '国家级稿件',
  `file_province` int(11) DEFAULT NULL COMMENT '省级稿件',
  `file_city` int(11) DEFAULT NULL COMMENT '市级稿件',
----------------------------------------------------- */
function report()
{
    global $db, $smarty;
    $where = "where status = 1";
    $starttime = crequest('starttime');
    $endtime = crequest('endtime');

    $time = date('Y-m',strtotime('-1 month'));
    $text = "";

    if (!empty($starttime))
    {
        $smarty->assign('starttime', $starttime);
        $where .= " AND time >= '{$starttime}' ";
        $text.= "$starttime";
    }
    if (!empty($endtime))
    {
        $smarty->assign('endtime', $endtime);
        $where .= " AND time <= '{$endtime}' ";
        $text.= "/$endtime";
    }
    if(empty($endtime) && empty($starttime)){
        $where.= " and time='{$time}'";
        $smarty->assign('endtime', $time);
        $smarty->assign('starttime', $time);
        $text.= "/$time";
    }

    $sql = "SELECT sum(money) as money,sum(num) as num,sum(use_funds) as use_funds,sum(use_money) as use_money,sum(honor_country) as honor_country,sum(honor_province) as honor_province,sum(honor_city) as honor_city,sum(file_country) as file_country,sum(file_province) as file_province,sum(file_city) as file_city FROM report {$where}";
    $row = $db->get_row($sql);

    $smarty->assign('report', $row);

    $smarty->assign('page_title', '各党支部'.$text."报表汇总");
    $smarty->display('report/reportAll.htm');
}

/*------------------------------------------------------ */
//-- 新闻列表
/*------------------------------------------------------ */
function report_list()
{
    global $db, $smarty;

    //搜索条件
    $con = "WHERE status = 1";
    //关键字
    $starttime = crequest('starttime');
    $endtime = crequest('endtime');
    $adminid = crequest('adminid');
    $smarty->assign('endtime', $endtime);
    $smarty->assign('starttime', $starttime);
    if (!empty($adminid))
    {
        $con .= " AND adminid = '{$adminid}' ";
    }
    if (!empty($starttime))
    {
        $con .= " AND time >= '{$starttime}' ";
    }
    if (!empty($endtime))
    {
        $con .= " AND time <= '{$endtime}' ";
    }
    //排序字段
    $order 	 	 = 'ORDER BY id DESC';

    //列表信息
    $now_page 	= irequest('page');
    $now_page 	= $now_page == 0 ? 1 : $now_page;
    $page_size 	= 20;
    $start    	= ($now_page - 1) * $page_size;
    $sql 		= "SELECT * FROM report {$con} {$order} LIMIT {$start}, {$page_size}";
    $arr 		= $db->get_all($sql);
    foreach($arr as $key=>$val){
        $sql 		= "SELECT * FROM admin WHERE id = '{$val['adminid']}'";
        $admin = $db->get_row($sql);
        $arr[$key]['admin_name'] = $admin['userid'];
    }

    $sql 		= "SELECT COUNT(id) FROM report {$con}";
    $total 		= $db->get_one($sql);
    $page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

    $smarty->assign('report_list'  ,   $arr);
    $smarty->assign('pageshow'  ,   $page->show(6));
    $smarty->assign('now_page'  ,   $page->now_page);

    $smarty->assign('page_title', '报表列表');
    $smarty->display('report/report_list.htm');
}

/*------------------------------------------------------ */
//-- 添加新闻
/*------------------------------------------------------ */
/*function add_report()
{
    global $smarty;
    $smarty->assign('action', 'do_add_report');
    $smarty->assign('page_title', '添加报表');
    $smarty->display('report/report.htm');
}*/

/*------------------------------------------------------ */
//-- 添加新闻
/*------------------------------------------------------ */
/*function do_add_report()
{
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $info = $_POST['info'];
    $time = $info['time'] = strtotime($info['time']);
    $info['add_time']	= time();
    $info['add_time_format']	= now_time();
    $info['adminid'] = $adminid;
    $sql = "SELECT * FROM report WHERE adminid = '{$adminid}' and time='{$time}'";
    $report = $db->get_row($sql);
    if($report){
        alert_back('同时间段报表只能提交一次');
    }
    $reportid = $db->insert('report',$info);
    $aid  = $_SESSION['admin_id'];
    $text = '添加报表，添加报表ID：' . $reportid;
    operate_log($aid, 'report', 1, $text);

    $url_to = "report.php?action=list";
    url_locate($url_to, '添加成功');
}*/

/*------------------------------------------------------ */
//-- 修改新闻
/*------------------------------------------------------ */
function mod_report()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM report WHERE id = '{$id}'";
    $row = $db->get_row($sql);

    $sql 		= "SELECT * FROM admin WHERE id = '{$row['adminid']}'";
    $admin = $db->get_row($sql);
    $row['admin_name'] = $admin['userid'];

    $smarty->assign('report', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'do_mod_report');
    $smarty->assign('page_title', $row['admin_name']."党支部".$row['time']."报表详情");
    $smarty->display('report/report.htm');
}


/*------------------------------------------------------ */
//-- 修改新闻
/*------------------------------------------------------ */
/*function do_mod_report()
{
    global $db;
    $info = $_POST['info'];
    $lables = $_POST['lables'];
    $info['lables'] = implode(',',$lables);
    check_null($info['title'], 			'标题');
    $id = irequest('id');
    $db->update('report',$info,"id='{$id}'");
    unset($_SESSION['image1'],$_SESSION['image2'],$_SESSION['image3']);
    $aid  = $_SESSION['admin_id'];
    $text = '修改新闻，修改新闻ID：' . $id;
    operate_log($aid, 'report', 2, $text);

    $now_page = irequest('now_page');
    $url_to = "report.php?action=list&page={$now_page}";
    url_locate($url_to, '修改成功');
}*/

/*------------------------------------------------------ */
//-- 删除新闻
/*------------------------------------------------------ */
function update_report()
{
    global $db;

    $id  = irequest('id');

    $update_col = "status = '0'";
    $sql = "UPDATE report SET {$update_col} WHERE id = '{$id}'";
    $db->query($sql);

    $aid  = $_SESSION['dangwei_id'];
    $text = '撤回报表，撤回报表ID：' . $id;
    dangwei_operate_log($aid, 'report', 3, $text);

    $now_page = irequest('now_page');
    $url_to = "report.php?action=report_list&page={$now_page}";
    url_locate($url_to, '撤回成功');
}

/*------------------------------------------------------ */
//-- 批量删除新闻
/*------------------------------------------------------ */
//function del_sel_report()
//{
//    global $db;
//    $id = crequest('checkboxes');
//
//    if ($id == '')
//        alert_back('请选中需要删除的选项');
//
//    /*$sql = "SELECT cover FROM report WHERE id IN ({$id})";
//    $imgs_all = $db->get_all($sql);
//    for ($i = 0; $i < count($imgs_all); $i++)
//    {
//        $cover = $imgs_all[$i]['cover'];
//        del_img($cover);
//    }*/
//
//    $sql = "SELECT * FROM report WHERE id IN ({$id})";
//    $report_all = $db->get_all($sql);
//    $update_col = "is_delete = '1'";
//    foreach($report_all as $key=>$val){
//        $sql = "UPDATE report SET {$update_col} WHERE id = '{$val['id']}'";
//        $db->query($sql);
//    }
//
//    /*	$sql = "DELETE FROM report WHERE id IN ({$id})";
//        $db->query($sql);*/
//
//    $aid  = $_SESSION['admin_id'];
//    $text = '批量删除新闻，批量删除新闻ID：' . $id;
//    operate_log($aid, 'report', 4, $text);
//
//    $now_page = irequest('now_page');
//    $url_to = "report.php?action=list&page={$now_page}";
//    href_locate($url_to);
//}


//导出
function export(){
    //$cashflow_db = pc_base::load_model('cashflow_model');
    global $db, $smarty;
    $where = "where status = 1";
    $starttime = crequest('starttime');
    $endtime = crequest('endtime');

    $time = date('Y-m',strtotime('-1 month'));
    $text = "";
    if (!empty($starttime))
    {
        $where .= " AND time >= '{$starttime}' ";
        $text.= "$starttime";
    }
    if (!empty($endtime))
    {
        $where .= " AND time <= '{$endtime}' ";
        $text.= "/$endtime";
    }
    if(empty($endtime) && empty($starttime)){
        $where.= " and time='{$time}'";
        $text.= "$time";
    }

    $sql = "SELECT sum(money) as money,sum(num) as num,sum(use_funds) as use_funds,sum(use_money) as use_money,sum(honor_country) as honor_country,sum(honor_province) as honor_province,sum(honor_city) as honor_city,sum(file_country) as file_country,sum(file_province) as file_province,sum(file_city) as file_city FROM report {$where}";
    $row = $db->get_row($sql);

    $objPHPExcel = new PHPExcel();

    /*以下是一些设置 ，什么作者  标题啊之类的*/
    $objPHPExcel->getProperties()->setCreator("转弯的阳光")
        ->setLastModifiedBy("转弯的阳光")
        ->setTitle("数据EXCEL导出")
        ->setSubject("数据EXCEL导出")
        ->setDescription("备份数据")
        ->setKeywords("excel")
        ->setCategory("result file");
    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    $objPHPExcel->setActiveSheetIndex(0)
        //Excel的第A列，uid是你查出数组的键值，下面以此类推
        ->setCellValue('A1', '开始时间')
        ->setCellValue('B1', '结束时间')
        ->setCellValue('C1', '党费缴纳金额')
        ->setCellValue('D1', '缴纳党费人数')
        ->setCellValue('E1', '使用党建经费')
        ->setCellValue('F1', '使用党费')
        ->setCellValue('G1', '获得荣誉（国家级）')
        ->setCellValue('H1', '获得荣誉（省部级）')
        ->setCellValue('I1', '获得荣誉（市厅级）')
        ->setCellValue('J1', '稿件发布（国家级）')
        ->setCellValue('K1', '稿件发布（省部级）')
        ->setCellValue('L1', '稿件发布（市厅级）');

    $num = 2;

    $objPHPExcel->setActiveSheetIndex(0)
        //Excel的第A列，uid是你查出数组的键值，下面以此类推
        //->setCellValue('A'.$num, $row['orderid'])
        ->setCellValueExplicit('A'.$num, $starttime,PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValue('B'.$num, $endtime)
        ->setCellValue('C'.$num, $row['money'])
        ->setCellValue('D'.$num, $row['num'])
        ->setCellValue('E'.$num, $row['use_funds'])
        ->setCellValue('F'.$num, $row['use_money'])
        ->setCellValue('G'.$num, $row['honor_country'])
        ->setCellValue('H'.$num, $row['honor_province'])
        ->setCellValue('I'.$num, $row['honor_city'])
        ->setCellValue('J'.$num, $row['file_country'])
        ->setCellValue('K'.$num, $row['file_province'])
        ->setCellValue('L'.$num, $row['file_city']);

    $name='各党支部'.$text.'报表汇总_'.date('Y-m-d H:i:s');
    $objPHPExcel->getActiveSheet()->setTitle('User');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}

function detail_export(){
    //$cashflow_db = pc_base::load_model('cashflow_model');
    global $db, $smarty;
    $id  = irequest('id');
    $sql = "SELECT * FROM report WHERE id = '{$id}'";
    $row = $db->get_row($sql);

    $sql 		= "SELECT * FROM admin WHERE id = '{$row['adminid']}'";
    $admin = $db->get_row($sql);
    $row['admin_name'] = $admin['userid'];
    $objPHPExcel = new PHPExcel();
    /*以下是一些设置 ，什么作者  标题啊之类的*/
    $objPHPExcel->getProperties()->setCreator("转弯的阳光")
        ->setLastModifiedBy("转弯的阳光")
        ->setTitle("数据EXCEL导出")
        ->setSubject("数据EXCEL导出")
        ->setDescription("备份数据")
        ->setKeywords("excel")
        ->setCategory("result file");
    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
    $objPHPExcel->setActiveSheetIndex(0)
        //Excel的第A列，uid是你查出数组的键值，下面以此类推
        ->setCellValue('A1', '党支部')
        ->setCellValue('B1', '提交时间')
        ->setCellValue('C1', '党费缴纳金额')
        ->setCellValue('D1', '缴纳党费人数')
        ->setCellValue('E1', '使用党建经费')
        ->setCellValue('F1', '使用党费')
        ->setCellValue('G1', '获得荣誉（国家级）')
        ->setCellValue('H1', '获得荣誉（省部级）')
        ->setCellValue('I1', '获得荣誉（市厅级）')
        ->setCellValue('J1', '稿件发布（国家级）')
        ->setCellValue('K1', '稿件发布（省部级）')
        ->setCellValue('L1', '稿件发布（市厅级）');

    $num = 2;
    $objPHPExcel->setActiveSheetIndex(0)
        //Excel的第A列，uid是你查出数组的键值，下面以此类推
        //->setCellValue('A'.$num, $row['orderid'])
        ->setCellValueExplicit('A'.$num, $row['admin_name'],PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValue('B'.$num, $row['time'])
        ->setCellValue('C'.$num, $row['money'])
        ->setCellValue('D'.$num, $row['num'])
        ->setCellValue('E'.$num, $row['use_funds'])
        ->setCellValue('F'.$num, $row['use_money'])
        ->setCellValue('G'.$num, $row['honor_country'])
        ->setCellValue('H'.$num, $row['honor_province'])
        ->setCellValue('I'.$num, $row['honor_city'])
        ->setCellValue('J'.$num, $row['file_country'])
        ->setCellValue('K'.$num, $row['file_province'])
        ->setCellValue('L'.$num, $row['file_city']);

    $name="党支部".$row['time']."报表详情_".date('Y-m-d H:i:s');
    $objPHPExcel->getActiveSheet()->setTitle('User');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}



