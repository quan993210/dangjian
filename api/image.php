<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/29 0003
 * Time: 21:46
 * 获取轮播图
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

global $db;
$adminid  = $_POST["adminid"];
$sql = "SELECT * FROM carousel WHERE id =1 and adminid='{$adminid}'";
$image = $db->get_row($sql);
showapisuccess($image);



