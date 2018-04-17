<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/8/31 0031
 * Time: 22:08
 * 手机号登录
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();
global $db;
$sql = "SELECT * FROM member WHERE userid=214 ";
$member = $db->get_row($sql);
if($member){
    showapisuccess($member);
}



