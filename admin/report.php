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
$action = $action == '' ? 'list' : $action;

switch ($action)
{
    case "list":
        report_list();
        break;
    case "add_report":
        add_report();
        break;
    case "do_add_report":
        do_add_report();
        break;
    case "mod_report":
        mod_report();
        break;
    case "do_mod_report":
        do_mod_report();
        break;
    case "detail_report":
        detail_report();
        break;
    case "del_report":
        del_report();
        break;
    case "del_sel_report":
        del_sel_report();
        break;

}

/*------------------------------------------------------ */
//-- 新闻列表
/*------------------------------------------------------ */
function report_list()
{
    global $db, $smarty;

    //搜索条件
    $adminid  = $_SESSION["admin_id"];
    $con = "WHERE adminid = $adminid";
    //关键字
    $keyword = crequest('keyword');
    $starttime = crequest('starttime');
    $endtime = crequest('endtime');
    $smarty->assign('endtime', $endtime);
    $smarty->assign('starttime', $starttime);
    if (!empty($keyword))
    {
        $con .= " AND title like '{%$keyword%}' ";
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
function add_report()
{
    global $smarty;
    $smarty->assign('action', 'do_add_report');
    $smarty->assign('page_title', '添加报表');
    $smarty->display('report/report.htm');
}

/*------------------------------------------------------ */
//-- 添加新闻
/*------------------------------------------------------ */
function do_add_report()
{
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $info = $_POST['info'];
    $info['add_time']	= time();
    $info['add_time_format']	= now_time();
    $info['adminid'] = $adminid;
    $attachment = com_upload_file();
    if($attachment){
        $info['attachment'] = $attachment;
    }
    $sql = "SELECT * FROM report WHERE adminid = '{$adminid}' and time='{$info['time']}'";
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
}

/*------------------------------------------------------ */
//-- 修改新闻
/*------------------------------------------------------ */
function detail_report()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM report WHERE id = '{$id}'";
    $row = $db->get_row($sql);

    $smarty->assign('report', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'mod_report');
    $smarty->assign('page_title', '报表详情');
    $smarty->display('report/report.htm');
}



function mod_report()
{
    global $db, $smarty;

    $id  = irequest('id');
    $sql = "SELECT * FROM report WHERE id = '{$id}'";
    $row = $db->get_row($sql);

    $smarty->assign('report', $row);

    $now_page = irequest('now_page');
    $smarty->assign('now_page', $now_page);

    $smarty->assign('action', 'do_mod_report');
    $smarty->assign('page_title', '报表详情');
    $smarty->display('report/report.htm');
}

/*------------------------------------------------------ */
//-- 修改新闻
/*------------------------------------------------------ */
function do_mod_report()
{
    global $db;
    $adminid  = $_SESSION["admin_id"];
    $info = $_POST['info'];
    $attachment = com_upload_file();
    if($attachment){
        $info['attachment'] = $attachment;
    }
    $info['status'] = 1;

    $sql = "SELECT * FROM report WHERE adminid = '{$adminid}' and time='{$info['time']}'";
    $report = $db->get_row($sql);
    $id = irequest('id');
    if($report && $report['id'] != $id){
        alert_back('同时间段报表只能提交一次');
    }
    $db->update('report',$info,"id='{$id}'");
    $aid  = $_SESSION['admin_id'];
    $text = '修改报表，修改报表ID：' . $id;
    operate_log($aid, 'report', 1, $text);

    $url_to = "report.php?action=list";
    url_locate($url_to, '修改成功');
}

/*------------------------------------------------------ */
//-- 删除新闻
/*------------------------------------------------------ */
function del_report()
{
    global $db;

    $id  = irequest('id');
    /*$sql = "SELECT cover FROM report WHERE id = '{$id}'";
    $row = $db->get_row($sql);
    del_img($row['cover']);*/

    /*$sql = "DELETE FROM report WHERE id = '{$id}'";
    $db->query($sql);*/

    $update_col = "is_delete = '1'";
    $sql = "UPDATE report SET {$update_col} WHERE id = '{$id}'";
    $db->query($sql);

    $aid  = $_SESSION['admin_id'];
    $text = '删除新闻，删除新闻ID：' . $id;
    operate_log($aid, 'report', 3, $text);

    $now_page = irequest('now_page');
    $url_to = "report.php?action=list&page={$now_page}";
    href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除新闻
/*------------------------------------------------------ */
function del_sel_report()
{
    global $db;
    $id = crequest('checkboxes');

    if ($id == '')
        alert_back('请选中需要删除的选项');

    /*$sql = "SELECT cover FROM report WHERE id IN ({$id})";
    $imgs_all = $db->get_all($sql);
    for ($i = 0; $i < count($imgs_all); $i++)
    {
        $cover = $imgs_all[$i]['cover'];
        del_img($cover);
    }*/

    $sql = "SELECT * FROM report WHERE id IN ({$id})";
    $report_all = $db->get_all($sql);
    $update_col = "is_delete = '1'";
    foreach($report_all as $key=>$val){
        $sql = "UPDATE report SET {$update_col} WHERE id = '{$val['id']}'";
        $db->query($sql);
    }

    /*	$sql = "DELETE FROM report WHERE id IN ({$id})";
        $db->query($sql);*/

    $aid  = $_SESSION['admin_id'];
    $text = '批量删除新闻，批量删除新闻ID：' . $id;
    operate_log($aid, 'report', 4, $text);

    $now_page = irequest('now_page');
    $url_to = "report.php?action=list&page={$now_page}";
    href_locate($url_to);
}



//上传文件
function com_upload_file()
{
   // $imgext = array('.jpg','.gif','.png','.jpeg');
    $fileext = array('.docx','pdf','.doc','.xls','.xlsx','.jpg','.png');
    $upload_name = "attachment";
    $targetDir   = $_SERVER['DOCUMENT_ROOT'] . '/upload/report/' . date('ym') . '/';

    $cleanupTargetDir = true; // Remove old files
    $maxFileAge = 5 * 3600; // Temp file age in seconds

    if (!file_exists($targetDir)) {
        mkdir($targetDir,0777,true);
    }

    $pos = strrpos($_FILES[$upload_name]["name"], '.');
    if ($pos !== false)
    {
        $file_type = substr($_FILES[$upload_name]["name"], $pos);
        if(!in_array($file_type,$fileext)) {
            
            alert_back('Failed to File type ');
        }
        //上传图片过大时对图片进行等比压缩
       /* if(in_array($file_type,$imgext)) {
            if($_FILES[$upload_name]['size']>(800*800)){
                compressed_image($_FILES[$upload_name]['tmp_name'],$_FILES[$upload_name]['tmp_name']);
            }
        }*/

    }else{
        return "";
    }

    $fileName = date('YmdHis') . rand(1000, 9999) . $file_type;
    $filePath = $targetDir . $fileName;

    // Chunking might be enabled
    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

    // Remove old temp files
    if ($cleanupTargetDir) {
        if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
            alert_back('Failed to open temp directory.');
            //die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }

        while (($file = readdir($dir)) !== false) {
            $tmpfilePath = $targetDir . $file;

            // If temp file is current file proceed to the next
            if ($tmpfilePath == "{$filePath}.part") {
                continue;
            }

            // Remove temp file if it is older than the max age and is not the current file
            if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                @unlink($tmpfilePath);
            }
        }
        closedir($dir);
    }

    // Open temp file
    if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
        alert_back('Failed to open output stream');
        //die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    }

    if (!empty($_FILES)) {
        if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
            alert_back('Failed to move uploaded file');
            //die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        }

        // Read binary input stream and append it to temp file
        if (!$in = @fopen($_FILES[$upload_name]["tmp_name"], "rb")) {
            alert_back('Failed to open input stream');
            //die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }
    } else {
        if (!$in = @fopen("php://input", "rb")) {
            alert_back('Failed to open input stream');
            //die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }
    }

    while ($buff = fread($in, 4096)) {
        fwrite($out, $buff);
    }

    @fclose($out);
    @fclose($in);

    // Check if file has been uploaded
    if (!$chunks || $chunk == $chunks - 1) {
        // Strip the temp .part suffix off
        rename("{$filePath}.part", $filePath);
    }


    $file_path = '/upload/report/' . date('ym') . '/' . $fileName;
    return $file_path;
}

function compressed_image($imgsrc,$imgdst){
    list($width,$height,$type)=getimagesize($imgsrc);
    if($width*$height > 800*800){
        if($width > $height && $width >800){
            $new_width = 800;
            $new_height = round($height/(round($width/800)));
        }
        if($height > $width  && $height >800){
            $new_height = 800;
            $new_width = round($width/(round($height/800)));
        }
    }

    switch($type){
        case 1:
            break;
        case 2:
            $image_wp=imagecreatetruecolor($new_width, $new_height);
            $image = imagecreatefromjpeg($imgsrc);
            imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            //75代表的是质量、压缩图片容量大小
            imagejpeg($image_wp, $imgdst,75);
            imagedestroy($image_wp);
            imagedestroy($image);
            break;
        case 3:
            $image_wp=imagecreatetruecolor($new_width, $new_height);
            $image = imagecreatefrompng($imgsrc);
            imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            //75代表的是质量、压缩图片容量大小
            imagejpeg($image_wp, $imgdst,75);
            imagedestroy($image_wp);
            imagedestroy($image);
            break;
    }
}




