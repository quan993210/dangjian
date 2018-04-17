<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/3 0003
 * Time: 21:42
 * 获取内容分类
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$adminid  = $_POST["adminid"];
if(isset($_POST['pid']) && !empty($_POST['pid']) && !empty($_POST['adminid']) ) {
    $pid = intval(trim($_POST['pid']));
    $order 	 	 = 'ORDER BY c.listorder ASC, c.catid DESC';
    $sql = "SELECT * FROM news_category WHERE pid =$pid and is_delete =0 and adminid='{$adminid}' ORDER BY listorder ASC, catid DESC";
    $category = $db->get_all($sql);
    showapisuccess($category );
}else{
    $pid = intval(trim($_POST['pid']));
    $order 	 	 = 'ORDER BY c.listorder ASC, c.catid DESC';
    $sql = "SELECT * FROM news_category WHERE pid =0 and is_delete =0 and adminid='{$adminid}' ORDER BY listorder ASC, catid DESC";
    $category = $db->get_all($sql);
    showapisuccess($category );
}
