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

if(isset($_POST['pid']) && !empty($_POST['pid']) ) {
    $pid = intval(trim($_POST['pid']));
    $sql = "SELECT * FROM news_category WHERE pid =$pid";
    $category = $db->get_all($sql);
    if(is_array($category) && $category){
        exit(json_encode(array('status'=>1,'category'=>$category)));
    }else{
        exit(json_encode(array('status'=>0,'msg'=>'参数错误')));
    }
}else{
    $pid = intval(trim($_POST['pid']));
    $sql = "SELECT * FROM news_category WHERE pid =0";
    $category = $db->get_all($sql);
    if(is_array($category) && $category){
        exit(json_encode(array('status'=>1,'category'=>$category)));
    }else{
        exit(json_encode(array('status'=>0,'msg'=>'参数错误')));
    }
}
