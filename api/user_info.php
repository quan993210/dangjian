<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/1 0001
 * Time: 21:39
 * 用户信息
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'get_user_info' : $action;

switch ($action)
{
    case "get_user_info":
        get_user_info();
        break;
    case "mod_user_info":
        mod_user_info();
        break;
    case "upload_avatar":
        upload_avatar();
        break;
}
function get_user_info(){
    global $db;
    if(isset($_POST['mobile']) && !empty($_POST['mobile'])) {
        $mobile = addslashes(trim($_POST['mobile']));
        $sql = "SELECT * FROM member WHERE mobile=$mobile";
        $member = $db->get_row($sql);
        showapisuccess($member);
    } else {
        showapierror('参数错误！');
    }
}

function mod_user_info(){
    global $db;
    if(is_array($_POST) && !empty($_POST['userid'])) {
        $userid   = $_POST['userid'];
        $set = "";
        if($_POST['mobile']){
            $mobile   = $_POST['mobile'];
            $set.= "mobile = '{$mobile}'";
        }
       if($_POST['name']){
           $name   = $_POST['name'];
           $set.= ", name = '{$name}'";
       }

        if($_POST['nickname']){
            $nickname   = $_POST['nickname'];
            $set.= ", nickname = '{$nickname}'";
        }
        $sql = "UPDATE member SET  $set WHERE userid = '{$userid}'";
        $db->query($sql);
        $sql = "SELECT * FROM member WHERE userid=$userid";
        $member = $db->get_row($sql);
        showapisuccess($member);
    } else {
        //exit('参数错误')
        showapierror('参数错误！');
    }
}

/*------------------------------------------------------ */
//-- 批量上传相册图片
/*------------------------------------------------------ */
function upload_avatar()
{
    global $db;
    $userid = irequest('userid');
    $url = $_POST['image_url'];
    $save_dir = '../upload/member/' . date('ym') ;
    $filename = "";
    if(trim($url)==''){
        showapierror('图片路径不对！');
    }

    if(trim($filename)==''){//保存文件名
        $ext=strrchr($url,'.');
        if($ext!='.gif'&&$ext!='.jpg'){
            return array('file_name'=>'','save_path'=>'','error'=>3);
        }
        $filename=time().$ext;
    }
    if(0!==strrpos($save_dir,'/')){
        $save_dir.='/';
    }
    //创建保存目录
    if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
        showapierror('上传失败');
    }
    ob_start();
    readfile($url);
    $img=ob_get_contents();
    ob_end_clean();
    //$size=strlen($img);
    //文件大小
    $fp2=@fopen($save_dir.$filename,'a');
    fwrite($fp2,$img);
    fclose($fp2);
    unset($img,$url);
    $pic_path = substr($save_dir,2).$filename;
    $sql = "UPDATE member SET avatar = '{$pic_path}' WHERE userid = '{$userid}'";
    $db->query($sql);
    $sql = "SELECT * FROM member WHERE userid=$userid";
    $member = $db->get_row($sql);
    showapisuccess($member);
}


